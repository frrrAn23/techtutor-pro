<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();

        $data['user'] = $user;
        $data['userAccessCourses'] = $user->userAccessCourses()->with('course')->get();

        return view('dashboard.index', $data);
    }
}
