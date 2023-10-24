<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
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
                'name' => RoleEnum::STUDENT,
            ],
            [
                'name' => RoleEnum::INSTRUCTOR,
            ],
            [
                'name' => RoleEnum::ADMIN,
            ],
        ];

        foreach ($payload as $data) {
            Role::firstOrCreate($data);
        }
    }
}
