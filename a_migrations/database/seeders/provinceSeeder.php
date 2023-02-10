<?php

namespace Database\Seeders;

use App\Models\OoapMasProvince;
use Illuminate\Database\Seeder;

class provinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OoapMasProvince::truncate();

        OoapMasProvince::insert([
            ["province_name" => "กรุงเทพมหานคร", "geo_id" => "2"],
            ["province_name" => "นครปฐม", "geo_id" => "2"],
            ["province_name" => "ชัยนาท", "geo_id" => "3"],
            ["province_name" => "ปทุมธานี", "geo_id" => "2"],
            ["province_name" => "กาญจนบุรี", "geo_id" => "4"],
            ["province_name" => "ประจวบคีรีขันธ์", "geo_id" => "2"],
            ["province_name" => "เพชรบุรี", "geo_id" => "2"],
            ["province_name" => "นครนายก", "geo_id" => "2"],
            ["province_name" => "นนทบุรี", "geo_id" => "2"],
            ["province_name" => "ลพบุรี", "geo_id" => "2"],
            ["province_name" => "ราชบุรี", "geo_id" => "5"],
            ["province_name" => "สมุทรสาคร", "geo_id" => "2"],
            ["province_name" => "สระบุรี", "geo_id" => "2"],
            ["province_name" => "สมุทรสงคราม", "geo_id" => "2"],
            ["province_name" => "สุพรรณบุรี", "geo_id" => "2"],
            ["province_name" => "พระนครศรีอยุธยา", "geo_id" => "2"],
            ["province_name" => "สิงห์บุรี", "geo_id" => "2"],
            ["province_name" => "อ่างทอง", "geo_id" => "2"],
            ["province_name" => "ตาก", "geo_id" => "1"],
            ["province_name" => "สมุทรปราการ", "geo_id" => "2"],
            ["province_name" => "เชียงราย", "geo_id" => "1"],
            ["province_name" => "พะเยา", "geo_id" => "1"],
            ["province_name" => "พิจิตร", "geo_id" => "1"],
            ["province_name" => "พิษณุโลก", "geo_id" => "1"],
            ["province_name" => "นครสวรรค์", "geo_id" => "2"],
            ["province_name" => "เพชรบูรณ์", "geo_id" => "2"],
            ["province_name" => "กำแพงเพชร", "geo_id" => "2"],
            ["province_name" => "ลำปาง", "geo_id" => "1"],
            ["province_name" => "เชียงใหม่", "geo_id" => "1"],
            ["province_name" => "แม่ฮ่องสอน", "geo_id" => "1"],
            ["province_name" => "แพร่", "geo_id" => "1"],
            ["province_name" => "สุโขทัย", "geo_id" => "2"],
            ["province_name" => "อุตรดิตถ์", "geo_id" => "1"],
            ["province_name" => "ลำพูน", "geo_id" => "1"],
            ["province_name" => "กาฬสินธุ์", "geo_id" => "3"],
            ["province_name" => "น่าน", "geo_id" => "3"],
            ["province_name" => "นครราชสีมา", "geo_id" => "3"],
            ["province_name" => "ขอนแก่น", "geo_id" => "3"],
            ["province_name" => "อุทัยธานี", "geo_id" => "2"],
            ["province_name" => "ชัยภูมิ", "geo_id" => "3"],
            ["province_name" => "บึงกาฬ", "geo_id" => "3"],
            ["province_name" => "มหาสารคาม", "geo_id" => "3"],
            ["province_name" => "นครพนม", "geo_id" => "3"],
            ["province_name" => "ยโสธร", "geo_id" => "3"],
            ["province_name" => "บุรีรัมย์", "geo_id" => "3"],
            ["province_name" => "สกลนคร", "geo_id" => "3"],
            ["province_name" => "ศรีสะเกษ", "geo_id" => "3"],
            ["province_name" => "ร้อยเอ็ด", "geo_id" => "3"],
            ["province_name" => "เลย", "geo_id" => "3"],
            ["province_name" => "มุกดาหาร", "geo_id" => "3"],
            ["province_name" => "หนองบัวลำภู", "geo_id" => "3"],
            ["province_name" => "อำนาจเจริญ", "geo_id" => "3"],
            ["province_name" => "สุรินทร์", "geo_id" => "3"],
            ["province_name" => "ฉะเชิงเทรา", "geo_id" => "5"],
            ["province_name" => "อุบลราชธานี", "geo_id" => "3"],
            ["province_name" => "หนองคาย", "geo_id" => "3"],
            ["province_name" => "ตราด", "geo_id" => "5"],
            ["province_name" => "ชลบุรี", "geo_id" => "2"],
            ["province_name" => "สระแก้ว", "geo_id" => "3"],
            ["province_name" => "ชุมพร", "geo_id" => "6"],
            ["province_name" => "จันทบุรี", "geo_id" => "5"],
            ["province_name" => "ปราจีนบุรี", "geo_id" => "5"],
            ["province_name" => "อุดรธานี", "geo_id" => "3"],
            ["province_name" => "นราธิวาส", "geo_id" => "6"],
            ["province_name" => "ระยอง", "geo_id" => "5"],
            ["province_name" => "ปัตตานี", "geo_id" => "6"],
            ["province_name" => "นครศรีธรรมราช", "geo_id" => "6"],
            ["province_name" => "ตรัง", "geo_id" => "6"],
            ["province_name" => "ยะลา", "geo_id" => "6"],
            ["province_name" => "ภูเก็ต", "geo_id" => "6"],
            ["province_name" => "พัทลุง", "geo_id" => "6"],
            ["province_name" => "สตูล", "geo_id" => "6"],
            ["province_name" => "สงขลา", "geo_id" => "6"],
            ["province_name" => "พังงา", "geo_id" => "6"],
            ["province_name" => "สุราษฎร์ธานี", "geo_id" => "6"],
            ["province_name" => "ระนอง", "geo_id" => "6"],
            ["province_name" => "กระบี่", "geo_id" => "6"],
        ]);
    }
}
