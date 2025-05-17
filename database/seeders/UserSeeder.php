<?php
namespace Database\Seeders;

// database/seeders/UserSeeder.php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Role;
use App\Models\User;
use App\Enums\RoleEnum;
use App\Enums\UserStatusEnum;

class UserSeeder extends Seeder
{
public function run(): void
{
// Admin
User::firstOrCreate([
'email' => 'admin@example.com',
], [
'name' => 'Admin Utama',
'username' => 'admin',
'password' => Hash::make('password123'),
'role_id' => Role::where('name', RoleEnum::ADMIN)->first()->id,
'status' => UserStatusEnum::ACTIVE,
'email_verified_at' => now(),
'remember_token' => Str::random(10),
]);

    // Instructor
    User::firstOrCreate([
        'email' => 'instructor@example.com',
    ], [
        'name' => 'Instruktur Satu',
        'username' => 'instructor',
        'password' => Hash::make('password123'),
        'role_id' => Role::where('name', RoleEnum::INSTRUCTOR)->first()->id,
        'status' => UserStatusEnum::ACTIVE,
        'email_verified_at' => now(),
        'remember_token' => Str::random(10),
    ]);

    // Student
    User::firstOrCreate([
        'email' => 'student@example.com',
    ], [
        'name' => 'Siswa Pertama',
        'username' => 'student',
        'password' => Hash::make('password123'),
        'role_id' => Role::where('name', RoleEnum::STUDENT)->first()->id,
        'status' => UserStatusEnum::ACTIVE,
        'email_verified_at' => now(),
        'remember_token' => Str::random(10),
    ]);

}

}