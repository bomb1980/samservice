<?php

namespace Database\Seeders;

use App\Models\OoapTblPopulation;
use Illuminate\Database\Seeder;

class  TblPopulationsSeeder extends Seeder
{

    //ooap_tbl_populations_seed
    public function run()
    {
        OoapTblPopulation::truncate();
        OoapTblPopulation::insert([
            ["pop_actnumber" => "AT-6511-0002", "pop_subdistrict" => "339", "pop_province" => "4", "total_score" => "7", "total_avg" => "1.75", "pop_year" => "65", "pop_periodno" => "1", "pop_div" => "1", "pop_role" => "2", "pop_nationalid" => "5001303363501", "pop_welfarecard" => NULL, "pop_title" => "2", "pop_firstname" => "lllllll", "pop_lastname" => "hhhhhhh", "pop_gender" => "หญิง", "pop_age" => "20", "pop_addressno" => "12323", "pop_moo" => "33434", "pop_soi" => "4334", "pop_district" => "68", "pop_education" => "6", "pop_postcode" => "12120", "pop_mobileno" => "0999999999", "pop_ocuupation" => "1", "pop_income" => "15000", "pop_birthday" => "2002-11-01 00:00:00", "pop_assessflag" => "1 "],
            ["pop_actnumber" => "AT-6511-0002", "pop_subdistrict" => "211", "pop_province" => "2", "total_score" => "7", "total_avg" => "1.75", "pop_year" => "65", "pop_periodno" => "1", "pop_div" => "1", "pop_role" => "2", "pop_nationalid" => "5454218222654", "pop_welfarecard" => NULL, "pop_title" => "1", "pop_firstname" => "etrtrtr", "pop_lastname" => "trrttrt", "pop_gender" => "หญิง", "pop_age" => "20", "pop_addressno" => "12333", "pop_moo" => "45454", "pop_soi" => "3444", "pop_district" => "55", "pop_education" => "4", "pop_postcode" => "73120", "pop_mobileno" => "0999999999", "pop_ocuupation" => "2", "pop_income" => "18000", "pop_birthday" => "2002-11-04 00:00:00", "pop_assessflag" => "1 "],
            ["pop_actnumber" => "AT-6511-0001", "pop_subdistrict" => "1", "pop_province" => "1", "total_score" => NULL, "total_avg" => NULL, "pop_year" => "65", "pop_periodno" => "1", "pop_div" => "1", "pop_role" => "1", "pop_nationalid" => "1111111111119", "pop_welfarecard" => NULL, "pop_title" => "1", "pop_firstname" => "test", "pop_lastname" => "dfdf", "pop_gender" => "หญิง", "pop_age" => "20", "pop_addressno" => "123", "pop_moo" => "3434", "pop_soi" => "3434", "pop_district" => "1", "pop_education" => "5", "pop_postcode" => "10110", "pop_mobileno" => "0999999999", "pop_ocuupation" => NULL, "pop_income" => "18000", "pop_birthday" => "2002-11-01 00:00:00", "pop_assessflag" => "1 "],
            ["pop_actnumber" => "AT-6511-0002", "pop_subdistrict" => "2", "pop_province" => "1", "total_score" => "10", "total_avg" => "2.5", "pop_year" => "65", "pop_periodno" => "1", "pop_div" => "1", "pop_role" => "2", "pop_nationalid" => "8068574226608", "pop_welfarecard" => NULL, "pop_title" => "1", "pop_firstname" => "testggg", "pop_lastname" => "fffff", "pop_gender" => "ชาย", "pop_age" => "46", "pop_addressno" => "123", "pop_moo" => "5455", "pop_soi" => "5555", "pop_district" => "1", "pop_education" => "5", "pop_postcode" => "10110", "pop_mobileno" => "0999999999", "pop_ocuupation" => "1", "pop_income" => "15000", "pop_birthday" => NULL, "pop_assessflag" => "1 "],
            ["pop_actnumber" => "AT-6611-0003", "pop_subdistrict" => "742", "pop_province" => "36", "total_score" => NULL, "total_avg" => NULL, "pop_year" => "65", "pop_periodno" => "1", "pop_div" => "1", "pop_role" => "2", "pop_nationalid" => "1160100538506", "pop_welfarecard" => "123453", "pop_title" => "1", "pop_firstname" => "Kritsada", "pop_lastname" => "Phrasertphol", "pop_gender" => "ชาย", "pop_age" => "26", "pop_addressno" => "234/245", "pop_moo" => "1", "pop_soi" => "3", "pop_district" => "113", "pop_education" => "6", "pop_postcode" => "15000", "pop_mobileno" => "0929417165", "pop_ocuupation" => NULL, "pop_income" => "18000", "pop_birthday" => "1996-12-11 00:00:00", "pop_assessflag" => "0 "],


        ]);
    }
}
