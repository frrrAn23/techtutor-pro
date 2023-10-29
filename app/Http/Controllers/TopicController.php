<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TopicController extends Controller
{
    public function create($courseId)
    {
        $course = Course::findOrFail($courseId);
        $lastOrderTopic = $course->topics()->orderBy('order', 'desc')->first();

        $data['pageTitle'] = 'Tambah Topik';
        $data['course'] = $course;
        $data['lastOrderTopic'] = $lastOrderTopic->order ?? 0;

        return view('dashboard.admin.topic.create', $data);
    }

    public function store(Request $request, $courseId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'required|integer',
        ]);

        $course = Course::findOrFail($courseId);

        $course->topics()->create([
            'name' => $request->name,
            'order' => $request->order,
        ]);

        return redirect()->route('dashboard.admin.course.show', $courseId)->with('success', 'Topik berhasil ditambahkan');
    }

    public function edit($courseId, $topicId)
    {
        $topic = Topic::where('course_id', $courseId)->findOrFail($topicId);

        $data['pageTitle'] = 'Ubah Topik';
        $data['topic'] = $topic;

        return view('dashboard.admin.topic.edit', $data);
    }

    public function update(Request $request, $courseId, $topicId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $topic = Topic::where('course_id', $courseId)->findOrFail($topicId);

        $topic->update([
            'name' => $request->name,
        ]);

        return redirect()->route('dashboard.admin.course.show', $courseId)->with('success', 'Topik berhasil diubah');
    }

    public function up($courseId, $topicId)
    {
        $topic = Topic::where('course_id', $courseId)->findOrFail($topicId);
        $prevTopic = Topic::where('course_id', $courseId)->where('order', '<', $topic->order)->orderBy('order', 'desc')->first();

        if ($prevTopic) {
            $currentOrder = $topic->order;

            $prevTopic->update([
                'order' => $currentOrder,
            ]);

            $topic->update([
                'order' => $currentOrder - 1,
            ]);
        }

        return redirect()->route('dashboard.admin.course.show', $courseId)->with('success', 'Topik berhasil diubah posisinya');
    }

    public function down($courseId, $topicId)
    {
        $topic = Topic::where('course_id', $courseId)->findOrFail($topicId);
        $nextTopic = Topic::where('course_id', $courseId)->where('order', '>', $topic->order)->orderBy('order', 'asc')->first();

        if ($nextTopic) {
            $currentOrder = $topic->order;

            $nextTopic->update([
                'order' => $currentOrder,
            ]);

            $topic->update([
                'order' => $currentOrder + 1,
            ]);
        }

        return redirect()->route('dashboard.admin.course.show', $courseId)->with('success', 'Topik berhasil diubah posisinya');
    }

    public function delete($courseId, $topicId)
    {
        try {
            $topic = Topic::where('course_id', $courseId)->findOrFail($topicId);
            $topic->delete();

            Session::flash('success', 'Topik berhasil dihapus!');

            return response()->json([
                'success' => true,
                'message' => 'Topik berhasil dihapus',
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
