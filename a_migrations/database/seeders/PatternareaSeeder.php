<?php

namespace Database\Seeders;

use App\Models\OoapMasPatternarea;
use Illuminate\Database\Seeder;

class PatternareaSeeder extends Seeder
{
    public function run()
    {
        OoapMasPatternarea::truncate();

        OoapMasPatternarea::insert([
            ['name' => 'ไม่ระบุ'],
            ['name' => 'รูปแบบปริมาตร'],
            ['name' => 'รูปแบบตาราง'],
        ]);
    }
}
