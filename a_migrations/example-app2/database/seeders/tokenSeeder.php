<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TokenSeeder extends Seeder
{

    public function run()
    {

        DB::table('personal_access_tokens')->insert([
            'tokenable_type' => 'App\Models\UmTblEmployee',
            'tokenable_id' => '1',
            'name' => 'APIGateway',
            'token' => '9c7b439e6cca80569c965fa2b16c9285141925cbb9a59b389a0c70dcbe9ea1b4',
            'abilities' => '["*"]'
        ]);
    }
}
