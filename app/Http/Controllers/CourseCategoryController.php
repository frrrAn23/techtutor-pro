<?php

namespace App\Http\Controllers;

use App\Models\CourseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CourseCategoryController extends Controller
{
    public function index()
    {
        $data['title'] = 'Kategori Kursus';
        $data['categories'] = CourseCategory::latest()->get();

        return view('dashboard.admin.course-category.index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Kategori Kursus';

        return view('dashboard.admin.course-category.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:course_categories'
        ]);

        $category = new CourseCategory();
        $category->name = $request->name;
        $category->save();

        return redirect()->route('dashboard.admin.course-category.index')->with('success', 'Kategori kursus berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data['title'] = 'Ubah Kategori Kursus';
        $data['category'] = CourseCategory::findOrFail($id);

        return view('dashboard.admin.course-category.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:course_categories,name,' . $id
        ]);

        $category = CourseCategory::findOrFail($id);
        $category->name = $request->name;
        $category->save();

        return redirect()->route('dashboard.admin.course-category.index')->with('success', 'Kategori kursus berhasil diubah');
    }

    public function destroy($id)
    {
        try {
            $category = CourseCategory::findOrFail($id);
            $category->delete();
            Session::flash('success', 'Kategori kursus berhasil dihapus!');

            return response()->json([
                'success' => true,
                'message' => 'Siswa berhasil dihapus',
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
