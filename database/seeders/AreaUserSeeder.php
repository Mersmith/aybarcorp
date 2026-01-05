<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaUserSeeder extends Seeder
{
    public function run(): void
    {
        for ($userId = 5; $userId <= 19; $userId++) {
            DB::table('area_user')->insert([
                'area_id' => 1,
                'user_id' => $userId,
            ]);
        }

        for ($userId = 20; $userId <= 36; $userId++) {
            DB::table('area_user')->insert([
                'area_id' => 2,
                'user_id' => $userId,
            ]);
        }

        for ($userId = 37; $userId <= 47; $userId++) {
            DB::table('area_user')->insert([
                'area_id' => 3,
                'user_id' => $userId,
            ]);
        }

        for ($userId = 48; $userId <= 49; $userId++) {
            DB::table('area_user')->insert([
                'area_id' => 4,
                'user_id' => $userId,
            ]);
        }
    }
}
