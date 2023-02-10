<?php

namespace Database\Seeders;

use App\Models\OoapTblActImages;
use Illuminate\Database\Seeder;
//ooap_tbl_act_images_seed
class OoapTblActImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OoapTblActImages::truncate();

        OoapTblActImages::insert([
            ["act_id" => "21", "image_group" => "ก่อนดำเนินกิจกรรม", "image_file_type" => "image/png", "image_oriname" => "04c1ed7efbd03fea18879a5fab41efe7.png_wh300 - Copy (2).png", "image_name" => "vj1B0DwNlZwTlom7Gs3D7lgddGbSqeqNNvQb4IVN.png", "image_path" => "/operate/images_pre", "image_file_size" => "44457"],
            ["act_id" => "21", "image_group" => "ระหว่างดำเนินกิจกรรม", "image_file_type" => "image/jpeg", "image_oriname" => "Screenshot 2022-08-24 224312.jpg", "image_name" => "LSF8y9b9JhiqaaJmA1K2phyShhedwXFwckImyanT.jpg", "image_path" => "/operate/images_con", "image_file_size" => "177752"],
            ["act_id" => "1", "image_group" => "ก่อนดำเนินกิจกรรม", "image_file_type" => "image/jpeg", "image_oriname" => "8ab7266cc71351db757c2418b1d36f6d.jpg", "image_name" => "DeaLpJIWYaIOq8n5uOMPj1a1jbuqbaKoJpH6jn8M.jpg", "image_path" => "/operate/images_pre_train", "image_file_size" => "57853"],
            ["act_id" => "1", "image_group" => "ก่อนดำเนินกิจกรรม", "image_file_type" => "image/jpeg", "image_oriname" => "Alter-S.jpg", "image_name" => "G6aXx0jchVwYqmDhCBsSfNgy42Q7oBf49z8GAY4z.jpg", "image_path" => "/operate/images_pre_train", "image_file_size" => "138155"],
            ["act_id" => "1", "image_group" => "ก่อนดำเนินกิจกรรม", "image_file_type" => "image/jpeg", "image_oriname" => "Alter-S.jpg", "image_name" => "aAYZFitKfYPwJeB7QOFumejwwWiTmTQ7toQihpCc.jpg", "image_path" => "/operate/images_pre_train", "image_file_size" => "138155"],
            ["act_id" => "1", "image_group" => "ก่อนดำเนินกิจกรรม", "image_file_type" => "image/jpeg", "image_oriname" => "Alter-S.jpg", "image_name" => "mBDTd7roPZvDNtGCgcrw8KFo74SBT91Apfb5ZH1M.jpg", "image_path" => "/operate/images_pre_train", "image_file_size" => "138155"],
            ["act_id" => "1", "image_group" => "ก่อนดำเนินกิจกรรม", "image_file_type" => "image/jpeg", "image_oriname" => "Alter-S.jpg", "image_name" => "OdxE0k08HELF86Ynzob8L319psDNE1ILHKYP91r8.jpg", "image_path" => "/operate/images_pre_train", "image_file_size" => "138155"],
            ["act_id" => "1", "image_group" => "ระหว่างดำเนินกิจกรรม", "image_file_type" => "image/jpeg", "image_oriname" => "Alter-S.jpg", "image_name" => "3shdtoKN0Ot2TmSv9J5wa6RiH7oP83dfRb3LyOjP.jpg", "image_path" => "/operate/images_con_train", "image_file_size" => "138155"],
            ["act_id" => "1", "image_group" => "ระหว่างดำเนินกิจกรรม", "image_file_type" => "image/png", "image_oriname" => "DeepinScreenshot_select-area_20221102164053.png", "image_name" => "bXaU4cxK5yd7jnGtUqGPud0r7hDK5LyxOdVNW95L.png", "image_path" => "/operate/images_con_train", "image_file_size" => "47438"],
            ["act_id" => "1", "image_group" => "ระหว่างดำเนินกิจกรรม", "image_file_type" => "text/plain", "image_oriname" => "Digimon Story Cyber Sleuth Complete Edition.desktop", "image_name" => "WdB8z01nOQze3c6K0X5u0Y4IVgt3ynUxL4pyUu3e.txt", "image_path" => "/operate/images_con_train", "image_file_size" => "208"],
            ["act_id" => "1", "image_group" => "ระหว่างดำเนินกิจกรรม", "image_file_type" => "image/jpeg", "image_oriname" => "Alter-S.jpg", "image_name" => "YpC30pWvNi4PLfDBsJ7H5ZMffaAFmmvTZOWIygBt.jpg", "image_path" => "/operate/images_con_train", "image_file_size" => "138155"],
            ["act_id" => "2", "image_group" => "ก่อนดำเนินกิจกรรม", "image_file_type" => "image/png", "image_oriname" => "04c1ed7efbd03fea18879a5fab41efe7.png_wh300 - Copy (2).png", "image_name" => "apuQeQjLloD0j4UXL2wDM7PcUujqSVAARh3H4jAT.png", "image_path" => "/operate/images_pre_train", "image_file_size" => "44457"],

        ]);
    }
}
