<?php

namespace Database\Seeders;

use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        $data = [
            [
                'name' => 'admin',
                'slug' => 'admin',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'editor',
                'slug' => 'editor',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'viewer',
                'slug' => 'viewer',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        Role::insert($data);
    }
}
