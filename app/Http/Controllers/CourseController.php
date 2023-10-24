<?php

namespace App\Http\Controllers;

use App\Enums\CourseLevelEnum;
use App\Enums\CourseStatusEnum;
use App\Enums\CourseTypeEnum;
use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::latest()->get();
        $data['pageTitle'] = 'Kursus';
        $data['courses'] = $courses;

        return view('dashboard.course.index', $data);
    }

    public function create()
    {
        $categories = CourseCategory::all();
        $data['pageTitle'] = 'Tambah Kursus';
        $data['categories'] = $categories;

        return view('dashboard.course.create', $data);
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

        return redirect()->route('dashboard.course.index')->with('success', 'Kursus berhasil ditambahkan');
    }

    public function show($id)
    {
        $course = Course::findOrFail($id);
        $data['pageTitle'] = 'Detail Kursus';
        $data['course'] = $course;
        $data['course']->discount = $course->retail_price != 0 ? ($course->price - $course->retail_price) / $course->price * 100 : 0;

        return view('dashboard.course.show', $data);
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $categories = CourseCategory::all();
        $data['pageTitle'] = 'Edit Kursus';
        $data['course'] = $course;
        $data['categories'] = $categories;

        return view('dashboard.course.edit', $data);
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

        return redirect()->route('dashboard.course.index')->with('success', 'Kursus berhasil diubah');
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
}
