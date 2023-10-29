<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function createFeedback($slugCourse) {
        $course = Course::where('slug', $slugCourse)->first();
        $feedback = Feedback::where('course_id', $course->id)->where('user_id', auth()->user()->id)->first();

        $data['pageTitle'] = 'Feedback';
        $data['feedback'] = $feedback;
        $data['course'] = $course;

        return view('dashboard.student.feedback.create', $data);
    }

    public function storeFeedback(Request $request, $slugCourse) {
        $request->validate([
            'comment' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $course = Course::where('slug', $slugCourse)->first();
        $feedback = Feedback::where('course_id', $course->id)->where('user_id', auth()->user()->id)->first();

        if ($feedback) {
            $feedback->comment = $request->comment;
            $feedback->rating = $request->rating;
            $feedback->save();
        } else {
            $feedback = new Feedback();
            $feedback->user_id = auth()->user()->id;
            $feedback->course_id = $course->id;
            $feedback->comment = $request->comment;
            $feedback->rating = $request->rating;
            $feedback->save();
        }

        return redirect()->route('dashboard.student.course.show', $slugCourse)->with('success', 'Feedback berhasil ditambahkan');
    }
}
