<?php


namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\UmMasDepartment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::truncate();
        Role::truncate();

        UmMasDepartment::truncate();

        DB::table('role_user')->truncate();

        DB::table('users')->insert([
            ['name' => 'user', 'email' => 'user@user.com', 'password' => Hash::make('admin1234')],
            ['name' => 'admin', 'email' => 'admin@admin.com', 'password' => Hash::make('admin1234')],

            ['name' => 'superadmin', 'email' => 'superadmin@superadmin.com', 'password' => Hash::make('admin1234')],
        ]);

        DB::table('roles')->insert(
            [
                ['name' => 'ROLE_USER', 'description' => 'สมาชิกทั่วไป'],
                ['name' => 'ROLE_ADMIN', 'description' => 'ผู้ดูแลระบบ'],
                ['name' => 'ROLE_SUPERADMIN', 'description' => 'ผู้ดูแลระบบสูงสุด']
            ]
        );

        DB::table('role_user')->insert(
            [
                ['role_id' => '1', 'user_id' => '1'],
                ['role_id' => '2', 'user_id' => '2'],
                ['role_id' => '3', 'user_id' => '3'],
            ]
        );

        UmMasDepartment::insert([
            ['dept_code' => '0002', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดนครปฐม', 'dept_short_name' => 'สรจ.นครปฐม', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0032', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดสุโขทัย', 'dept_short_name' => 'สรจ.สุโขทัย', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0096', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดยะลา', 'dept_short_name' => 'สรจ.ยะลา', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0035', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดกาฬสินธุ์', 'dept_short_name' => 'สรจ.กาฬสินธุ์', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0045', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดบุรีรัมย์', 'dept_short_name' => 'สรจ.บุรีรัมย์', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0070', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดภูเก็ต', 'dept_short_name' => 'สรจ.ภูเก็ต', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0044', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดยโสธร', 'dept_short_name' => 'สรจ.ยโสธร', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0068', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดตรัง', 'dept_short_name' => 'สรจ.ตรัง', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0074', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดพังงา', 'dept_short_name' => 'สรจ.พังงา', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0037', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดนครราชสีมา', 'dept_short_name' => 'สรจ.นครราชสีมา', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0057', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดตราด', 'dept_short_name' => 'สรจ.ตราด', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0063', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดอุดรธานี', 'dept_short_name' => 'สรจ.อุดรธานี', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0025', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดนครสวรรค์', 'dept_short_name' => 'สรจ.นครสวรรค์', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0022', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดพะเยา', 'dept_short_name' => 'สรจ.พะเยา', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0030', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดแม่ฮ่องสอน', 'dept_short_name' => 'สรจ.แม่ฮ่องสอน', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0011', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดราชบุรี', 'dept_short_name' => 'สรจ.', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0047', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดศรีสะเกษ', 'dept_short_name' => 'สรจ.ศรีสะเกษ', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0034', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดลำพูน', 'dept_short_name' => 'สรจ.ลำพูน', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '00024', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดพิษณุโลก', 'dept_short_name' => 'สรจ.พิษณุโลก', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0017', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดสิงห์บุรี', 'dept_short_name' => 'สรจ.สิงห์บุรี', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0051', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดหนองบัวลำภู', 'dept_short_name' => 'สรจ.หนองบัวลำภู', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0006', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดประจวบคีรีขันธ์', 'dept_short_name' => 'สรจ.ประจวบคีรีขันธ์', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0065', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดระยอง', 'dept_short_name' => 'สรจ.ระยอง', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0020', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดสมุทรปราการ', 'dept_short_name' => 'สรจ.สมุทรปราการ', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0033', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดอุตรดิตถ์', 'dept_short_name' => 'สรจ.อุตรดิตถ์', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0042', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดมหาสารคาม', 'dept_short_name' => 'สรจ.มหาสารคาม', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0060', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดชุมพร', 'dept_short_name' => 'สรจ.ชุมพร', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0059', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดสระแก้ว', 'dept_short_name' => 'สรจ.สระแก้ว', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0040', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดชัยภูมิ', 'dept_short_name' => 'สรจ.ชัยภูมิ', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0005', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดกาญจนบุรี', 'dept_short_name' => 'สรจ.กาญจนบุรี', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0056', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดหนองคาย', 'dept_short_name' => 'สรจ.หนองคาย', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0004', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดปทุมธานี', 'dept_short_name' => 'สรจ.ปทุมธานี', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0031', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดแพร่', 'dept_short_name' => 'สรจ.แพร่', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0055', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดอุบลราชธานี', 'dept_short_name' => 'สรจ.อุบลราชธานี', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0071', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดพัทลุง', 'dept_short_name' => 'สรจ.พัทลุง', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0072', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดสตูล', 'dept_short_name' => 'สรจ.สตูล', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0028', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดลำปาง', 'dept_short_name' => 'สรจ.ลำปาง', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0027', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดกำแพงเพชร', 'dept_short_name' => 'สรจ.กำแพงเพชร', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0066', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดปัตตานี', 'dept_short_name' => 'สรจ.ปัตตานี', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0010', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดลพบุรี', 'dept_short_name' => 'สรจ.ลพบุรี', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0058', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดชลบุรี', 'dept_short_name' => 'สรจ.ชลบุรี', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0003', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดชัยนาท', 'dept_short_name' => 'สรจ.ชัยนาท', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0014', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดสมุทรสงคราม', 'dept_short_name' => 'สรจ.สมุทรสงคราม', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0007', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดเพชรบุรี', 'dept_short_name' => 'สรจ.เพชรบุรี', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0046', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดสกลนคร', 'dept_short_name' => 'สรจ.สกลนคร', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0073', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดสงขลา', 'dept_short_name' => 'สรจ.สงขลา', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0036', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดน่าน', 'dept_short_name' => 'สรจ.น่าน', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0064', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดนราธิวาส', 'dept_short_name' => 'สรจ.นราธิวาส', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0048', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดร้อยเอ็ด', 'dept_short_name' => 'สรจ.ร้อยเอ็ด', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0077', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดกระบี่', 'dept_short_name' => 'สรจ.กระบี่', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0075', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดสุราษฎร์ธานี', 'dept_short_name' => 'สรจ.สุราษฎร์ธานี', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0039', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดอุทัยธานี', 'dept_short_name' => 'สรจ.อุทัยธานี', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0021', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดเชียงราย', 'dept_short_name' => 'สรจ.เชียงราย', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0067', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดนครศรีธรรมราช', 'dept_short_name' => 'สรจ.นครศรีธรรมราช', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0076', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดระนอง', 'dept_short_name' => 'สรจ.ระนอง', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0026', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดเพชรบูรณ์', 'dept_short_name' => 'สรจ.เพชรบูรณ์', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0050', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดมุกดาหาร', 'dept_short_name' => 'สรจ.มุกดาหาร', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0019', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดตาก', 'dept_short_name' => 'สรจ.ตาก', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0053', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดสุรินทร์', 'dept_short_name' => 'สรจ.สุรินทร์', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0061', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดจันทบุรี', 'dept_short_name' => 'สรจ.จันทบุรี ', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0013', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดสระบุรี', 'dept_short_name' => 'สรจ. กรุงสระบุรี', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0043', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดนครพนม', 'dept_short_name' => 'สรจ.นครพนม', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0052', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดอำนาจเจริญ', 'dept_short_name' => 'สรจ.อำนาจเจริญ', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0000', 'dept_name_th' => 'กองยุทธศาสตร์และแผนงาน', 'dept_short_name' => 'กยผ.', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0038', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดขอนแก่น', 'dept_short_name' => 'สรจ.ขอนแก่น', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0054', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดฉะเชิงเทรา', 'dept_short_name' => 'สรจ.ฉะเชิงเทรา', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0015', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดสุพรรณบุรี', 'dept_short_name' => 'สรจ.สุพรรณบุรี', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0009', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดนนทบุรี', 'dept_short_name' => 'สรจ.นนทบุรี', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0012', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดสมุทรสาคร', 'dept_short_name' => 'สรจ.สมุทรสาคร', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0023', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดพิจิตร', 'dept_short_name' => 'สรจ.พิจิตร', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0008', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดนครนายก', 'dept_short_name' => 'สรจ.นครนายก', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0016', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดพระนครศรีอยุธยา', 'dept_short_name' => 'สรจ.พระนครศรีอยุธยา', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0062', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดปราจีนบุรี', 'dept_short_name' => 'สรจ.ปราจีนบุรี', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0041', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดบึงกาฬ', 'dept_short_name' => 'สรจ.บึงกาฬ', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0018', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดอ่างทอง', 'dept_short_name' => 'สรจ.อ่างทอง', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0029', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดเชียงใหม่', 'dept_short_name' => 'สรจ.เชียงใหม่', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],
            ['dept_code' => '0049', 'dept_name_th' => 'สำนักงานแรงงานจังหวัดเลย', 'dept_short_name' => 'สรจ.เลย', 'address' => '-', 'district' => 1, 'aumpur' => 1, 'province' => 1, 'postcode' => 000010, 'phone' => '025511411', 'email' => 'KK@GMAIL.COM', 'branch_type_id' => 1],

        ]);
    }
}
