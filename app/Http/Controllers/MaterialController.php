<?php

namespace App\Http\Controllers;

use App\Enums\CourseTypeEnum;
use App\Enums\MaterialStatusEnum;
use App\Enums\MaterialTypeEnum;
use App\Models\Material;
use App\Models\Topic;
use App\Models\UserAccessCourse;
use App\Models\UserMaterialProgress;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class MaterialController extends Controller
{
    public function create($topicId)
    {
        $topic = Topic::findOrFail($topicId);
        $data['pageTitle'] = 'Tambah Materi';
        $data['topic'] = $topic;
        $data['course'] = $topic->course;

        return view('dashboard.admin.material.create', $data);
    }

    public function store(Request $request, $topicId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required_if:video_url,null|string',
            'is_preview' => 'string',
            'status' => 'required|string|in:' . implode(',', MaterialStatusEnum::getValues()),
            'video_url' => 'required_if:content,null|url',
            'duration_in_minutes' => 'required|integer',
        ]);

        $topic = Topic::findOrFail($topicId);
        $lastOrderMaterial = $topic->materials()->max('order');

        $material = new Material();
        $material->name = $request->name;
        $material->course_id = $topic->course_id;
        $material->topic_id = $topic->id;
        $material->content = $request->content;
        $material->is_preview = !!$request->is_preview;
        $material->status = $request->status;
        $material->video_url = $request->video_url;
        $material->type = MaterialTypeEnum::LESSON;
        $material->duration_in_minutes = $request->duration_in_minutes;
        $material->order = $lastOrderMaterial + 1;
        $material->slug = Str::slug($request->name);

        $material->save();

        return redirect()->route('dashboard.admin.course.show', $topic->course_id)->with('success', 'Materi berhasil ditambahkan');
    }

    public function edit($id)
    {
        $material = Material::findOrFail($id);
        $data['pageTitle'] = 'Ubah Materi';
        $data['material'] = $material;

        return view('dashboard.admin.material.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $material = Material::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required_if:video_url,null|string',
            'is_preview' => 'string',
            'status' => 'required|string|in:' . implode(',', MaterialStatusEnum::getValues()),
            'video_url' => 'required_if:content,null|url',
            'duration_in_minutes' => 'required|integer',
        ]);

        $material->update([
            'name' => $request->name,
            'content' => $request->content,
            'is_preview' => !!$request->is_preview,
            'status' => $request->status,
            'video_url' => $request->video_url,
            'duration_in_minutes' => $request->duration_in_minutes,
        ]);

        return redirect()->route('dashboard.admin.course.show', $material->course_id)->with('success', 'Materi berhasil diubah');
    }

    public function up($id)
    {
        $material = Material::findOrFail($id);
        $prevMaterial = Material::where('topic_id', $material->topic_id)->where('order', '<', $material->order)->orderBy('order', 'desc')->first();

        if ($prevMaterial) {
            $currentOrder = $material->order;

            $prevMaterial->update([
                'order' => $currentOrder,
            ]);

            $material->update([
                'order' => $currentOrder - 1,
            ]);
        }

        return redirect()->route('dashboard.admin.course.show', $material->course_id)->with('success', 'Materi berhasil diubah');
    }

    public function down($id)
    {
        $material = Material::findOrFail($id);
        $nextMaterial = Material::where('topic_id', $material->topic_id)->where('order', '>', $material->order)->orderBy('order', 'asc')->first();

        if ($nextMaterial) {
            $currentOrder = $material->order;

            $nextMaterial->update([
                'order' => $currentOrder,
            ]);

            $material->update([
                'order' => $currentOrder + 1,
            ]);
        }

        return redirect()->route('dashboard.admin.course.show', $material->course_id)->with('success', 'Materi berhasil diubah');
    }

    public function delete($id)
    {
        try {
            $material = Material::findOrFail($id);
            $material->delete();

            Session::flash('success', 'Materi berhasil dihapus!');

            return response()->json([
                'success' => true,
                'message' => 'Materi berhasil dihapus',
            ], 200);
        } catch (\Exception $e) {
            Session::flash('failed', $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function showByStudentPov($slugCourse, $slugMaterial)
    {
        $material = Material::where('slug', $slugMaterial)->firstOrFail();
        $course = $material->course;

        if ($course->slug != $slugCourse) {
            abort(404);
        }

        $topics = $course->topics()->orderBy('order', 'asc')->get();

        foreach ($topics as $topic) {
            $topic->materials = $topic->materials()->orderBy('order', 'asc')->get();

            foreach ($topic->materials as $m) {
                $m->is_completed = $m->isCompletedByUser(auth()->user()->id);
            }
        }

        $nextMaterial = Material::where('topic_id', $material->topic_id)->where('order', '>', $material->order)->orderBy('order', 'asc')->first();
        if (!$nextMaterial) {
            $nextTopic = Topic::where('course_id', $course->id)->where('order', '>', $material->topic->order)->orderBy('order', 'asc')->first();
            if ($nextTopic) {
                $nextMaterial = Material::where('topic_id', $nextTopic->id)->orderBy('order', 'asc')->first();
            }
        }

        $totalMaterial = Material::where('course_id', $material->course_id)->count();
        $userProgress = UserMaterialProgress::where('user_id', auth()->user()->id)->where('course_id', $material->course_id)->count();

        $data['pageTitle'] = 'Detail Materi';
        $data['course'] = $course;
        $data['material'] = $material;
        $data['topics'] = $topics;
        $data['nextMaterial'] = $nextMaterial;
        $data['isCompleted'] = $totalMaterial == $userProgress;

        return view('dashboard.student.material.show', $data);
    }

    public function saveUserProgress($materialId, Request $request)
    {
        try {
            if (!$request->userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'User ID tidak ditemukan',
                ], 500);
            }

            $material = Material::findOrFail($materialId);

            if (!$material->isCompletedByUser($request->userId)) {
                $material->userMaterialProgresses()->create([
                    'user_id' => $request->userId,
                    'material_id' => $material->id,
                    'course_id' => $material->course_id,
                ]);

                $payloadUpdate =[
                    'last_material_id' => $material->id
                ];

                $totalMaterial = Material::where('course_id', $material->course_id)->count();
                $userProgress = UserMaterialProgress::where('user_id', $request->userId)->where('course_id', $material->course_id)->count();

                if ($totalMaterial == $userProgress) {
                    $payloadUpdate['completed_at'] = now();
                }

                UserAccessCourse::updateOrCreate([
                    'user_id' => $request->userId,
                    'course_id' => $material->course_id,
                ], $payloadUpdate);
            }

            return response()->json([
                'success' => true,
                'message' => 'Progress berhasil disimpan',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Progress gagal disimpan',
                'error' => $th->getMessage(),
            ], 500);
        }

    }
}
