<?php

namespace App\Http\Controllers;

use App\Enums\LastEducationEnum;
use App\Enums\RoleEnum;
use App\Enums\UserStatusEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function getAdmin()
    {
        $role = Role::where('name', RoleEnum::ADMIN)->first();
        $admins = User::where('role_id', $role->id)->latest()->get();

        $data['pageTitle'] = 'List Admin';
        $data['admins'] = $admins;

        return view('dashboard.admin.index', $data);
    }

    public function createAdmin()
    {
        $data['pageTitle'] = 'Tambah Admin';

        return view('dashboard.admin.create', $data);
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:20|unique:users',
            'avatar_url' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        $role = Role::where('name', RoleEnum::ADMIN)->first();

        $avatarUrl = 'https://ui-avatars.com/api/?name=' . $request->name . '&color=7F9CF5&background=EBF4FF';
        if ($request->hasFile('avatar_url')) {
            $avatarUrl = storeFile($request->file('avatar_url'), 'avatars');
        }

        $user = new User();
        $user->role_id = $role->id;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->avatar_url = $avatarUrl;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->status = UserStatusEnum::ACTIVE;
        $user->save();

        return redirect()->route('dashboard.admin.index')->with('success', 'Admin berhasil ditambahkan');
    }

    public function editAdmin($id)
    {
        $admin = User::findOrFail($id);

        $data['pageTitle'] = 'Ubah Admin';
        $data['admin'] = $admin;

        return view('dashboard.admin.edit', $data);
    }

    public function updateAdmin(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:20|unique:users,username,' . $admin->id,
            'avatar_url' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'email' => 'required|string|email|max:255|unique:users,email,' . $admin->id,
            'new_password' => 'nullable|string|min:8',
            'status' => 'required|in:' . UserStatusEnum::ACTIVE . ',' . UserStatusEnum::SUSPENDED
        ]);

        $avatarUrl = $admin->avatar_url;
        if ($request->hasFile('avatar_url')) {
            deleteFile($avatarUrl);
            $avatarUrl = storeFile($request->file('avatar_url'), 'avatars');
        }

        $admin->name = $request->name;
        $admin->username = $request->username;
        $admin->avatar_url = $avatarUrl;
        $admin->email = $request->email;
        if ($request->password) {
            $admin->password = Hash::make($request->password);
        }
        $admin->status = $request->status;
        $admin->save();

        return redirect()->route('dashboard.admin.index')->with('success', 'Admin berhasil diubah');
    }

    public function deleteAdmin($id)
    {
        try {
            $admin = User::findOrFail($id);
            $admin->delete();
            Session::flash('success', 'Admin berhasil dihapus!');

            return response()->json([
                'success' => true,
                'message' => 'Admin berhasil dihapus',
            ], 200);
        } catch (\Throwable $th) {
            Session::flash('failed', $th->getMessage());

            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function getStudent()
    {
        $role = Role::where('name', RoleEnum::STUDENT)->first();
        $students = User::where('role_id', $role->id)->latest()->get();

        $data['pageTitle'] = 'List Siswa';
        $data['students'] = $students;

        return view('dashboard.student.index', $data);
    }

    public function createStudent()
    {
        $data['pageTitle'] = 'Tambah Siswa';

        return view('dashboard.student.create', $data);
    }

    public function storeStudent(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:20|unique:users',
            'avatar_url' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'status' => 'required|in:' . UserStatusEnum::ACTIVE . ',' . UserStatusEnum::SUSPENDED,
            'phone_number' => 'nullable|string|max:20|regex:/^[0-9]+$/',
            'last_education' => 'string|max:255|in:' . implode(",", LastEducationEnum::getAll())
        ]);

        $role = Role::where('name', RoleEnum::STUDENT)->first();

        $avatarUrl = 'https://ui-avatars.com/api/?name=' . $request->name . '&color=7F9CF5&background=EBF4FF';
        if ($request->hasFile('avatar_url')) {
            $avatarUrl = storeFile($request->file('avatar_url'), 'avatars');
        }

        $user = new User();
        $user->role_id = $role->id;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->avatar_url = $avatarUrl;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->status = $request->status;
        $user->phone_number = $request->phone_number;
        $user->last_education = $request->last_education;
        $user->save();

        return redirect()->route('dashboard.student.index')->with('success', 'Siswa berhasil ditambahkan');
    }

    public function editStudent($id)
    {
        $student = User::findOrFail($id);

        $data['pageTitle'] = 'Ubah Siswa';
        $data['student'] = $student;

        return view('dashboard.student.edit', $data);
    }

    public function updateStudent(Request $request, $id)
    {
        $student = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:20|unique:users,username,' . $student->id,
            'avatar_url' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'email' => 'required|string|email|max:255|unique:users,email,' . $student->id,
            'new_password' => 'nullable|string|min:8',
            'status' => 'required|in:' . UserStatusEnum::ACTIVE . ',' . UserStatusEnum::SUSPENDED,
            'phone_number' => 'nullable|string|max:20|regex:/^[0-9]+$/',
            'last_education' => 'string|max:255|in:' . implode(",", LastEducationEnum::getAll())
        ]);

        $avatarUrl = $student->avatar_url;
        if ($request->hasFile('avatar_url')) {
            deleteFile($avatarUrl);
            $avatarUrl = storeFile($request->file('avatar_url'), 'avatars');
        }

        $student->name = $request->name;
        $student->username = $request->username;
        $student->avatar_url = $avatarUrl;
        $student->email = $request->email;
        if ($request->password) {
            $student->password = Hash::make($request->password);
        }
        $student->status = $request->status;
        $student->phone_number = $request->phone_number;
        $student->last_education = $request->last_education;
        $student->save();

        return redirect()->route('dashboard.student.index')->with('success', 'Siswa berhasil diubah');
    }

    public function deleteStudent($id)
    {
        try {
            $student = User::findOrFail($id);
            $student->delete();
            Session::flash('success', 'Siswa berhasil dihapus!');

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
