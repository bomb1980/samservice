<?php

namespace Database\Seeders;

use App\Models\OoapMasUnit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OoapMasUnit::truncate();

        OoapMasUnit::insert([
            ['name' => 'เมตร'],
            ['name' => 'กิโลเมตร'],
        ]);
    }
}
