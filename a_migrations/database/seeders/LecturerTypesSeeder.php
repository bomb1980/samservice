<?php

namespace Database\Seeders;

use App\Models\OoapMasLecturerType;
use Illuminate\Database\Seeder;

class LecturerTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OoapMasLecturerType::truncate();

        OoapMasLecturerType::insert([
            ["lecturer_types_name" => "วิทยากรมีใบรับรอง", "status" => "1"],
            ["lecturer_types_name" => "วิทยากรชุมนุม", "status" => "1"],
        ]);
    }
}
