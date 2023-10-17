<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payload = [
            [
                'name' => 'student',
            ],
            [
                'name' => 'admin',
            ],
            [
                'name' => 'instructor',
            ],
        ];

        foreach ($payload as $data) {
            Role::firstOrCreate($data);
        }
    }
}
