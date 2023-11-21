<?php

namespace App\Http\Controllers;

use App\Enums\CourseLevelEnum;
use App\Enums\CourseStatusEnum;
use App\Enums\CourseTypeEnum;
use App\Enums\UserAccessCourseStatusEnum;
use App\Enums\UserAccessCourseStatusPaymentEnum;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Material;
use App\Models\Topic;
use App\Models\UserAccessCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Services\Midtrans\CreateSnapTokenService;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::latest()->get();
        $data['pageTitle'] = 'Kursus';
        $data['courses'] = $courses;

        return view('dashboard.admin.course.index', $data);
    }

    public function create()
    {
        $categories = CourseCategory::all();
        $data['pageTitle'] = 'Tambah Kursus';
        $data['categories'] = $categories;

        return view('dashboard.admin.course.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:courses,name',
            'description' => 'required|string',
            'summary' => 'required|string',
            'price' => 'required|numeric',
            'retail_price' => 'nullable|numeric',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:' . implode(',', CourseStatusEnum::getValues()),
            'level' => 'required|in:' . implode(',', CourseLevelEnum::getValues()),
            'course_category_id' => 'required|uuid',
            'labels' => 'nullable|array',
            'labels.*' => 'nullable|string',
            'type' => 'required|in:' . implode(',', CourseTypeEnum::getValues()),
        ]);

        $course = new Course();
        $course->name = $request->name;
        $course->description = $request->description;
        $course->summary = $request->summary;
        $course->price = $request->price;
        $course->retail_price = $request->retail_price;
        $course->author_id = auth()->user()->id;
        $course->status = $request->status;
        $course->level = $request->level;
        $course->course_category_id = $request->course_category_id;
        $course->labels = $request->labels;
        $course->type = $request->type;
        $course->slug = Str::slug($request->name);

        $thumbnailUrl = storeFile($request->file('thumbnail'), 'courses');
        $course->thumbnail_url = $thumbnailUrl;

        $course->save();

        return redirect()->route('dashboard.admin.course.index')->with('success', 'Kursus berhasil ditambahkan');
    }

    public function show($id)
    {
        $course = Course::findOrFail($id);
        $topics = $course->topics()->orderBy('order', 'asc')->get();

        $durationInMinute = 0;
        $totalMaterial = 0;
        foreach ($topics as $topic) {
            $durationInMinute += $topic->materials->sum('duration_in_minutes');
            $totalMaterial += $topic->materials->count();
        }

        $rating = $course->feedbacks->avg('rating');

        $data['pageTitle'] = 'Detail Kursus';
        $data['course'] = $course;
        $data['course']->discount = ($course->retail_price != 0 || $course->price != 0) ? ($course->price - $course->retail_price) / $course->price * 100 : 0;
        $data['topics'] = $topics;
        $data['durationInMinute'] = $durationInMinute;
        $data['rating'] = $rating;
        $data['totalMaterial'] = $totalMaterial;

        return view('dashboard.admin.course.show', $data);
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $categories = CourseCategory::all();
        $data['pageTitle'] = 'Edit Kursus';
        $data['course'] = $course;
        $data['categories'] = $categories;

        return view('dashboard.admin.course.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:courses,name,' . $course->id,
            'description' => 'required|string',
            'summary' => 'required|string',
            'price' => 'required|numeric',
            'retail_price' => 'nullable|numeric',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:' . implode(',', CourseStatusEnum::getValues()),
            'level' => 'required|in:' . implode(',', CourseLevelEnum::getValues()),
            'course_category_id' => 'required|uuid',
            'labels' => 'nullable|array',
            'labels.*' => 'nullable|string',
            'type' => 'required|in:' . implode(',', CourseTypeEnum::getValues()),
        ]);

        $course->name = $request->name;
        $course->description = $request->description;
        $course->summary = $request->summary;
        $course->price = $request->price;
        $course->retail_price = $request->retail_price;
        $course->status = $request->status;
        $course->level = $request->level;
        $course->course_category_id = $request->course_category_id;
        $course->labels = $request->labels;
        $course->type = $request->type;
        $course->slug = Str::slug($request->name);

        if ($request->hasFile('thumbnail')) {
            deleteFile($course->thumbnail_url);
            $thumbnailUrl = storeFile($request->file('thumbnail'), 'courses');
            $course->thumbnail_url = $thumbnailUrl;
        }

        $course->save();

        return redirect()->route('dashboard.admin.course.index')->with('success', 'Kursus berhasil diubah');
    }

    public function destroy($id)
    {
        try {
            $course = Course::findOrFail($id);
            $course->delete();
            Session::flash('success', 'Kursus berhasil dihapus!');

            return response()->json([
                'success' => true,
                'message' => 'Kursus berhasil dihapus',
            ], 200);
        } catch (\Throwable $th) {
            Session::flash('failed', $th->getMessage());

            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function indexStudent(Request $request)
    {
        $query = Course::whereIn('status', [CourseStatusEnum::ACTIVE, CourseStatusEnum::INACTIVE]);

        if ($request->has('name') && trim($request->name) != '') {
            $query->where('name', 'ILIKE', '%' . $request->name . '%');
        }

        if ($request->has('technology') && $request->technology != 'Semua Teknologi') {
            $query->where('course_category_id', $request->technology);
        }

        if ($request->has('level') && $request->level != 'Semua Level') {
            $query->where('level', CourseLevelEnum::getValueByLabel($request->level));
        }

        if ($request->has('types')) {
            $query->whereIn('type', $request->types);
        }

        $courses = $query->get();

        $courseCategories = CourseCategory::orderBy('name', 'asc')->get();

        $data['pageTitle'] = 'Kursus';
        $data['courses'] = $courses;
        $data['courseCategories'] = $courseCategories;

        return view('dashboard.student.course.index', $data);
    }

    public function indexEnrolled() {
        $courses = Course::whereHas('users', function ($query) {
            $query->where('user_id', auth()->user()->id);
        })->get();

        $data['pageTitle'] = 'Kursus saya';
        $data['courses'] = $courses;

        return view('dashboard.student.course.enrolled', $data);
    }

    public function showByStudendPov($slug) {
        $course = Course::where('slug', $slug)->firstOrFail();
        $topics = $course->topics()->orderBy('order', 'ASC')->get();
        $access = UserAccessCourse::where('course_id', $course->id)->where('user_id', auth()->user()->id)->first();

        $durationInMinute = 0;
        $totalMaterial = 0;
        foreach ($topics as $topic) {
            $durationInMinute += $topic->materials->sum('duration_in_minutes');
            $totalMaterial += $topic->materials->count();
        }

        $continueMaterialSlug = null;
        if ($access && $access->last_material_id) {
            $continueMaterial = Material::where('order', '>', $access->lastMaterial->order)->where('topic_id', $access->lastMaterial->topic_id)->orderBy('order', 'ASC')->first();

            if (!$continueMaterial) {
                $nextTopic = Topic::where('course_id', $course->id)->where('order', '>', $access->lastMaterial->topic->order)->orderBy('order', 'ASC')->first();
                if ($nextTopic) {
                    $continueMaterial = Material::where('topic_id', $nextTopic->id)->orderBy('order', 'ASC')->first();
                    $continueMaterialSlug = $continueMaterial ? $continueMaterial->slug : $access->lastMaterial->slug;
                }
                $continueMaterialSlug = $access->lastMaterial->slug;
            } else {
                $continueMaterialSlug = $continueMaterial->slug;
            }
        } else {
            $continueMaterialSlug = $topics->first()->materials()->orderBy('order', 'ASC')->first()->slug;
        }
        $rating = $course->feedbacks->avg('rating');

        $data['pageTitle'] = 'Detail Kursus';
        $data['course'] = $course;
        $data['course']->discount = ($course->retail_price != 0 || $course->price != 0) ? ($course->price - $course->retail_price) / $course->price * 100 : 0;
        $data['topics'] = $topics;
        $data['durationInMinute'] = $durationInMinute;
        $data['totalMaterial'] = $totalMaterial;
        $data['access'] = $access;
        $data['continueMaterialSlug'] = $continueMaterialSlug;
        $data['rating'] = $rating;
        $data['feedbacks'] = $course->feedbacks()->orderBy('created_at', 'DESC')->limit(3)->get();

        return view('dashboard.student.course.show', $data);
    }

    public function enroll($slug) {
        $course = Course::where('slug', $slug)->firstOrFail();
        $userAccessCourse = $course->users()->where('user_id', auth()->user()->id)->first();

        DB::beginTransaction();

        if (!$userAccessCourse) {
            $userAccessCourse = new UserAccessCourse();
            $userAccessCourse->user_id = auth()->user()->id;
            $userAccessCourse->course_id = $course->id;
            $userAccessCourse->purchased_at = now('Asia/Jakarta');
            $userAccessCourse->status = UserAccessCourseStatusEnum::UNPAID;
            $userAccessCourse->payment_status = UserAccessCourseStatusPaymentEnum::PENDING;
            $userAccessCourse->course_price = $course->price;
            $userAccessCourse->course_retail_price = $course->retail_price;

            if ($course->price == 0 && $course->retail_price == 0) {
                $userAccessCourse->status = UserAccessCourseStatusEnum::ACTIVE;
                $userAccessCourse->payment_status = UserAccessCourseStatusPaymentEnum::PAID;
            }

            $userAccessCourse->save();
        }

        try {
            if(
                is_null($userAccessCourse->snap_token) &&
                $userAccessCourse->course_price > 0 &&
                $userAccessCourse->status != UserAccessCourseStatusEnum::ACTIVE
            ) {
                $price = $userAccessCourse->course_retail_price > 0 ?
                    $userAccessCourse->course_retail_price :
                    $userAccessCourse->course_price;

                $order = (object)[
                    'id' => $userAccessCourse->id,
                    'total_price' => $price,
                    'items' => [
                        [
                            'id' => $course->id,
                            'price' => $price,
                            'quantity' => 1,
                            'name' => $course->name,
                        ],
                    ],
                    'user' => (object)[
                        'name' => auth()->user()->name,
                        'email' => auth()->user()->email,
                        'phone_number' => auth()->user()->phone_number,
                    ],
                ];

                $midtrans = new CreateSnapTokenService($order);
                $snapToken = $midtrans->getSnapToken();

                $userAccessCourse->snap_token = $snapToken;
                $userAccessCourse->save();
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->route('dashboard.student.course.show', $course->slug)->with('error', $th->getMessage());
        }
        return redirect()->route('dashboard.student.course.show', $course->slug)->with('success', 'Kursus berhasil diambil');
    }
}
