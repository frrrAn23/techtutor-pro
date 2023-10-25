<?php

namespace App\Http\Controllers;

use App\Enums\CourseTypeEnum;
use App\Enums\MaterialStatusEnum;
use App\Enums\MaterialTypeEnum;
use App\Models\Material;
use App\Models\Topic;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MaterialController extends Controller
{
    public function create($topicId)
    {
        $topic = Topic::findOrFail($topicId);
        $data['pageTitle'] = 'Tambah Materi';
        $data['topic'] = $topic;
        $data['course'] = $topic->course;

        return view('dashboard.material.create', $data);
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

        return redirect()->route('dashboard.course.show', $topic->course_id)->with('success', 'Materi berhasil ditambahkan');
    }

    public function edit($id)
    {
        $material = Material::findOrFail($id);
        $data['pageTitle'] = 'Ubah Materi';
        $data['material'] = $material;

        return view('dashboard.material.edit', $data);
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

        return redirect()->route('dashboard.course.show', $material->course_id)->with('success', 'Materi berhasil diubah');
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

        return redirect()->route('dashboard.course.show', $material->course_id)->with('success', 'Materi berhasil diubah');
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

        return redirect()->route('dashboard.course.show', $material->course_id)->with('success', 'Materi berhasil diubah');
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
}
