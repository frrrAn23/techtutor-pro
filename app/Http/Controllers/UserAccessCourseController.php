<?php

namespace App\Http\Controllers;

use App\Models\UserAccessCourse;
use Illuminate\Http\Request;

class UserAccessCourseController extends Controller
{
    public function index() {
        $data['pageTitle'] = 'Akses Kelas';
        $data['userAccessCourses'] = UserAccessCourse::latest()->get();

        return view('dashboard.admin.user-access-course.index', $data);
    }
}
