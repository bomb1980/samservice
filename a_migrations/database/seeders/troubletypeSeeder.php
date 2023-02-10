<?php

namespace Database\Seeders;

use App\Models\OoapMasTroubletype;
use Illuminate\Database\Seeder;

class TroubletypeSeeder extends Seeder
{
    public function run()
    {
        OoapMasTroubletype::truncate();

        OoapMasTroubletype::insert([
            ['name' => 'ภัยธรรมชาติ', 'remember_token' => 'V1XaCZykaKMlVlAvPVfaGpHkwMT716PmAg10W4cS', 'created_by' => 'admin'],
            ['name' => 'ภัยแล้ง', 'remember_token' => 'V1XaCZykaKMlVlAvPVfaGpHkwMT716PmAg10W4cS', 'created_by' => 'admin'],
            ['name' => 'อทุกภัย', 'remember_token' => 'V1XaCZykaKMlVlAvPVfaGpHkwMT716PmAg10W4cS', 'created_by' => 'admin'],
            ['name' => 'อื่นๆ', 'remember_token' => 'V1XaCZykaKMlVlAvPVfaGpHkwMT716PmAg10W4cS', 'created_by' => 'admin'],
        ]);
    }
}
