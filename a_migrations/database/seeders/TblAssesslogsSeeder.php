<?php

namespace Database\Seeders;

use App\Models\OoapTblAssesslog;
use Illuminate\Database\Seeder;

class TblAssesslogsSeeder extends Seeder
{

    //ooap_tbl_assesslogs_seed
    public function run()
    {
        OoapTblAssesslog::truncate();
        OoapTblAssesslog::insert([
            ["assesslog_pop_id" => "1", "assesslog_type" => "R", "assesslog_score" => "3", "assesslog_act_id" => "0", "assesslog_refid" => "0", "assesslog_description" => "0", "assesslog_answers" => "0"],
            ["assesslog_pop_id" => "1", "assesslog_type" => "R", "assesslog_score" => "5", "assesslog_act_id" => "0", "assesslog_refid" => "0", "assesslog_description" => "0", "assesslog_answers" => "0"],
            ["assesslog_pop_id" => "2", "assesslog_type" => "R", "assesslog_score" => "4", "assesslog_act_id" => "0", "assesslog_refid" => "0", "assesslog_description" => "0", "assesslog_answers" => "0"],
            ["assesslog_pop_id" => "2", "assesslog_type" => "R", "assesslog_score" => "3", "assesslog_act_id" => "0", "assesslog_refid" => "0", "assesslog_description" => "0", "assesslog_answers" => "0"],
            ["assesslog_pop_id" => "1", "assesslog_type" => "R", "assesslog_score" => "5", "assesslog_act_id" => "0", "assesslog_refid" => "0", "assesslog_description" => "0", "assesslog_answers" => "0"],
            ["assesslog_pop_id" => "1", "assesslog_type" => "R", "assesslog_score" => "5", "assesslog_act_id" => "0", "assesslog_refid" => "0", "assesslog_description" => "0", "assesslog_answers" => "0"],
            ["assesslog_pop_id" => "1", "assesslog_type" => "R", "assesslog_score" => "5", "assesslog_act_id" => "0", "assesslog_refid" => "0", "assesslog_description" => "0", "assesslog_answers" => "0"],
            ["assesslog_pop_id" => "2", "assesslog_type" => "R", "assesslog_score" => "1", "assesslog_act_id" => "0", "assesslog_refid" => "0", "assesslog_description" => "0", "assesslog_answers" => "0"],
            ["assesslog_pop_id" => "2", "assesslog_type" => "R", "assesslog_score" => "3", "assesslog_act_id" => "0", "assesslog_refid" => "0", "assesslog_description" => "0", "assesslog_answers" => "0"],
            ["assesslog_pop_id" => "2", "assesslog_type" => "R", "assesslog_score" => "1", "assesslog_act_id" => "0", "assesslog_refid" => "0", "assesslog_description" => "0", "assesslog_answers" => "0"],
            ["assesslog_pop_id" => "3", "assesslog_type" => "R", "assesslog_score" => "4", "assesslog_act_id" => "0", "assesslog_refid" => "0", "assesslog_description" => "0", "assesslog_answers" => "0"],
            ["assesslog_pop_id" => "3", "assesslog_type" => "R", "assesslog_score" => "3", "assesslog_act_id" => "0", "assesslog_refid" => "0", "assesslog_description" => "0", "assesslog_answers" => "0"],
            ["assesslog_pop_id" => "3", "assesslog_type" => "R", "assesslog_score" => "1", "assesslog_act_id" => "0", "assesslog_refid" => "0", "assesslog_description" => "0", "assesslog_answers" => "0"],
            ["assesslog_pop_id" => "3", "assesslog_type" => "R", "assesslog_score" => "3", "assesslog_act_id" => "0", "assesslog_refid" => "0", "assesslog_description" => "0", "assesslog_answers" => "0"],
            ["assesslog_pop_id" => "3", "assesslog_type" => "R", "assesslog_score" => "1", "assesslog_act_id" => "0", "assesslog_refid" => "0", "assesslog_description" => "0", "assesslog_answers" => "0"],


        ]);
    }
}
