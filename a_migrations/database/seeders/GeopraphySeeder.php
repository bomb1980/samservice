<?php

namespace Database\Seeders;

use App\Models\OoapMasGeopraphyTh;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeopraphySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        OoapMasGeopraphyTh::truncate();

        DB::table('ooap_mas_geopraphy_th')->insert([
            ["geo_name" => "ภาคเหนือ", "status" => "1", "remember_token" => null, "created_by" => null, "updated_by" => null, "created_at" => null, "updated_at" => null, "deleted_at" => null],
            ["geo_name" => "ภาคกลาง", "status" => "1", "remember_token" => null, "created_by" => null, "updated_by" => null, "created_at" => null, "updated_at" => null, "deleted_at" => null],
            ["geo_name" => "ภาคตะวันออกเฉียงเหนือ", "status" => "1", "remember_token" => null, "created_by" => null, "updated_by" => null, "created_at" => null, "updated_at" => null, "deleted_at" => null],
            ["geo_name" => "ภาคตะวันตก", "status" => "1", "remember_token" => null, "created_by" => null, "updated_by" => null, "created_at" => null, "updated_at" => null, "deleted_at" => null],
            ["geo_name" => "ภาคตะวันออก", "status" => "1", "remember_token" => null, "created_by" => null, "updated_by" => null, "created_at" => null, "updated_at" => null, "deleted_at" => null],
            ["geo_name" => "ภาคใต้", "status" => "1", "remember_token" => null, "created_by" => null, "updated_by" => null, "created_at" => null, "updated_at" => null, "deleted_at" => null]
        ]);
    }
}
