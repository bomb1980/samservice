<?php

namespace Database\Seeders;

use App\Models\OoapMasRolePer;
use App\Models\OoapMasSubmenu;
use Illuminate\Database\Seeder;
//ooap_mas_submenu_seed
class SubMenuSeeder extends Seeder
{
    public function run()
    {
        OoapMasSubmenu::truncate();
        OoapMasSubmenu::insert([

            ['admin'=>1, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '1', 'submenu_name' => 'ข้อมูลปีงบประมาณ', 'route_name' => 'master.fiscalyear.index'],
            ['admin'=>1, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '1', 'submenu_name' => 'ข้อมูลกลุ่มหลักสูตร', 'route_name' => 'master.coursegroup.index'],
            ['admin'=>1, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '1', 'submenu_name' => 'ข้อมูลกลุ่มสาขาอาชีพ', 'route_name' => 'master.coursesubgroup.index'],
            ['admin'=>1, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '1', 'submenu_name' => 'ข้อมูลประเภทหลักสูตร', 'route_name' => 'master.coursetype.index'],
            ['admin'=>0, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '1', 'submenu_name' => 'ข้อมูลหลักสูตรอบรม (กยผ/สรจ)', 'route_name' => 'master.course.index'],
            ['admin'=>1, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '1', 'submenu_name' => 'ข้อมูลแหล่งที่มาของหลักสูตร', 'route_name' => 'master.ownertype.index'],
            ['admin'=>1, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '1', 'submenu_name' => 'ข้อมูลประเภทสถานที่ ', 'route_name' => 'master.buildingtype.index'],
            ['admin'=>1, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '1', 'submenu_name' => 'ข้อมูลประเภทความเดือดร้อน', 'route_name' => 'master.troubletype.index'],

            ['admin'=>1, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '1', 'submenu_name' => 'ข้อมูลทะเบียนคุมวิทยากร', 'route_name' => 'master.lecturer.index'], //เอาคุมวิทยากรไว้ล่าง


            // ['admin'=>1, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '1', 'submenu_name' => 'กิจกรรมจ้างงานเร่งด่วน', 'route_name' => 'master.assessment_topic.index'], เปลี่ยนเป็น แบบประเมิน
            // ['admin'=>1, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '1', 'submenu_name' => 'บริหารแบบประเมินความพึงพอใจ', 'route_name' => 'master.assessment_topic.index'],

            // ['admin'=>1, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '1', 'submenu_name' => 'บริหารแบบประเมินความพึงพอใจ', 'route_name' => 'master.satisfactionform.index'],
            // ['admin'=>1, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '1', 'submenu_name' => 'บริหารแบบประเมินความพึงพอใจ', 'route_name' => 'master.satisfactionform.index'],
            ['admin'=>1, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '1', 'submenu_name' => 'บริหารแบบประเมินความพึงพอใจ', 'route_name' => 'master.form.index'],
            ['admin'=>1, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '1', 'submenu_name' => 'ข้อมูลประเภทกิจกรรม', 'route_name' => 'master.activitytype.index'],
            ['admin'=>1, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '1', 'submenu_name' => 'ข้อมูลประเภทแบบประเมิน', 'route_name' => 'master.assessmenttype.index'],


            // ['admin'=>1, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '1', 'submenu_name' => 'บริหารแบบประเมินความพึงพอใจ', 'route_name' => 'master.form.index'],
            // ['admin'=>1, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '1', 'submenu_name' => 'ประเภทกิจกรรม', 'route_name' => 'master.acttype.index'],
            // ['admin'=>1, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '1', 'submenu_name' => 'ประเภทแบบประเมิน', 'route_name' => 'master.poptype.index'],


            ['admin' => 0, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '2', 'submenu_name' => 'บันทึกข้อมูลคำขอรับการจัดสรรงบประมาณ', 'route_name' => 'request.projects.index'],
            ['admin' => 0, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '2', 'submenu_name' => 'บันทึกผลการพิจารณาคำขอรับการจัดสรรงบประมาณ', 'route_name' => 'request.consider.index'],
            // ['admin' => 0, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '2', 'submenu_name' => 'แบบคำขอทำโครงการ', 'route_name' => 'request.projects.index'],
            // ['admin' => 0, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '2', 'submenu_name' => 'พิจารณาคำขอทำโครงการ', 'route_name' => 'request.consider.index'],
            ['admin' => 0, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '2', 'submenu_name' => 'บันทึกข้อมูลการเสนองบประมาณ', 'route_name' => 'request.sum_list.index'],


            ['admin' => 0, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '3', 'submenu_name' => 'ข้อมูลงบประมาณ', 'route_name' => 'manage.fiscal.index'],
            ['admin' => 0, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '3', 'submenu_name' => 'ข้อมูลงวดเงิน', 'route_name' => 'manage.fiscal.index2'],
            ['admin' => 0, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '3', 'submenu_name' => 'รับโอนเงินจาก สนง.', 'route_name' => 'manage.receivetransfer.index'],
            ['admin' => 0, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '3', 'submenu_name' => 'จัดสรรงบประมาณ', 'route_name' => 'manage.local_mng.index'],
            ['admin' => 0, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '3', 'submenu_name' => 'เบิกค่าใช้จ่ายส่วนกลาง', 'route_name' => 'manage.center'],
            ['admin' => 0, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '3', 'submenu_name' => 'บันทึกค่าใช้จ่ายงานบริหาร (สรจ.)', 'route_name' => 'manage.upcountry'],
            ['admin' => 0, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '3', 'submenu_name' => 'ปิดปีงบประมาณ', 'route_name' => 'manage.fiscalyear_cls.index'],


            ['admin' => 0, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '4', 'submenu_name' => 'ข้อมูลระยะเวลาดำเนินกิจกรรม (สรจ)', 'route_name' => 'activity.act_detail.index'],
            ['admin' => 0, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '4', 'submenu_name' => 'บันทึกยืนยันความพร้อมคำขอรับการจัดสรรงบ(สรจ)', 'route_name' => 'activity.ready_confirm.index'],
            ['admin' => 0, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '4', 'submenu_name' => 'จัดสรรโอนเงิน', 'route_name' => 'activity.tran_mng.index'],
            ['admin' => 0, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '4', 'submenu_name' => 'บันทึกข้อมูลปรับแผน/โครงการ(สรจ)', 'route_name' => 'activity.plan_adjust.index'],
            ['admin' => 0, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '4', 'submenu_name' => 'บันทึกดำเนินการกิจกรรม (สรจ.)', 'route_name' => 'operate.index'],
            ['admin' => 0, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '4', 'submenu_name' => 'บันทึกผู้เข้าร่วมกิจกรรม(สรจ)', 'route_name' => 'activity.participant.index'],
            // ['admin' => 0, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '4', 'submenu_name' => 'รวบรวมคำขอ (ก่อนจัดสรรงบ)', 'route_name' => 'activity.ready_confirm.index'],
            // ['admin' => 0, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '4', 'submenu_name' => 'ปรับแผนโครงการ', 'route_name' => 'activity.plan_adjust.index'],
            // ['admin' => 0, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '4', 'submenu_name' => 'บันทึกผลดำเนินการ', 'route_name' => 'operate.index'],
            // ['admin' => 0, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '4', 'submenu_name' => 'สรุปรวมค่าใช้จ่าย', 'route_name' => 'activity.summary_expenses.index'],
            // ['admin' => 0, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '4', 'submenu_name' => 'สรุปรวมค่าใช้จ่ายประจำปี', 'route_name' => 'activity.summary_expensesyear.index'],



            ['admin' => 0, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '5', 'submenu_name' => 'บันทึกเวลาเข้าร่วมกิจกรรม', 'route_name' => 'activity.recordattendance.index'],
            ['admin' => 0, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '5', 'submenu_name' => 'บันทึกแบบประเมิน', 'route_name' => 'activity.assessment.index'],
            ['admin' => 0, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '5', 'submenu_name' => 'บันทึกค่าใช้จ่ายอื่นๆ', 'route_name' => 'activity.other_expense.index'],
            ['admin' => 0, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '5', 'submenu_name' => 'บันทึกรูปกิจกรรม', 'route_name' => 'activity.activity_image.index'],
            // ['admin' => 0, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '5', 'submenu_name' => 'รายงานประมวลผลความพึงพอใจ', 'route_name' => 'report1'],
            // ['admin' => 0, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '5', 'submenu_name' => 'รายงานเป็นรายกิจกรรม หลักสูตร รูปภาพกิจกรรม แยกเป็นรายจังหวัด', 'route_name' => 'report2'],
            // ['admin' => 0, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '5', 'submenu_name' => 'รายงานสรุป', 'route_name' => 'report3'],



            // ['admin' => 0, 'error' => 1, 'show_on_menu' => 1, 'menu_id' => '6', 'submenu_name' => 'Dashboard', 'route_name' => 'report.dashboard3.index'],
            ['admin' => 1, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '6', 'submenu_name' => 'Dashboard', 'route_name' => 'dashboard'],
            ['admin' => 1, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '6', 'submenu_name' => 'รายงานสรุป', 'route_name' => 'report.dashboard1.index'],
            // ['admin' => 1, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '6', 'submenu_name' => 'รายงานสรุป', 'route_name' => 'report7'],
            // ['admin' => 1, 'error' => 1, 'show_on_menu' => 1, 'menu_id' => '6', 'submenu_name' => 'รายงานรูปภาพกิจกรรม', 'route_name' => 'report.dashboard2.index'],
            ['admin' => 1, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '6', 'submenu_name' => 'รายงานรูปภาพกิจกรรม', 'route_name' => 'report2'],
            ['admin' => 1, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '6', 'submenu_name' => 'รายงานสรุปข้อมูลรายได้เฉลี่ยต่อเดือนแยกตามอาชีพหลัก', 'route_name' => 'report9'],
            ['admin' => 1, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '6', 'submenu_name' => 'รายงานสรุปข้อมูลรายได้เฉลี่ยต่อเดือนแยกตามหลักสูตร', 'route_name' => 'report8'],
            ['admin' => 1, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '6', 'submenu_name' => 'รายงานสรุปข้อมูลผลการจัดกิจกรรมแยกตามกลุ่มหลักสูตร', 'route_name' => 'report6'],
            ['admin' => 1, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '6', 'submenu_name' => 'รายงานประมวลผลความพึงพอใจ', 'route_name' => 'report1'],


            // ['admin' => 0, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '6', 'submenu_name' => 'แบบฟอร์มประเมินความพึงพอใจ', 'route_name' => 'master.form.index'],


            ['admin' => 1, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '7', 'submenu_name' => 'กำหนดสิทธิ์การเข้าใช้งานระบบ', 'route_name' => 'permission.index'],
            ['admin' => 1, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '7', 'submenu_name' => 'จัดการข้อมูลกลุ่มผู้ใช้', 'route_name' => 'grouppermission.index'],
            ['admin' => 0, 'error' => 0, 'show_on_menu' => 1, 'menu_id' => '7', 'submenu_name' => 'ประวัติการใช้งาน', 'route_name' => 'history'],


        ]);

        $this->createPermission();
    }


    function createPermission()
    {

        OoapMasRolePer::truncate();

        foreach (OoapMasSubmenu::select('*')->get() as $ka => $va) {

            // OoapMasRolePer::create(["role_id" => "1", "submenu_id" => $va->submenu_id, "view_data" => "1", "insert_data" => "1", "update_data" => "1", "delete_data" => "1"]);

            OoapMasRolePer::create(["role_id" => "2", "submenu_id" => $va->submenu_id, "view_data" => "1", "insert_data" => "1", "update_data" => "1", "delete_data" => "1"]);

            if(   in_array( $va->route_name , ['history','master.course.index', 'request.projects.index','activity.ready_confirm.index','activity.plan_adjust.index','activity.participant.index', 'manage.upcountry']  ) ) {

                // OoapMasRolePer::create(["role_id" => "2", "submenu_id" => $va->submenu_id, "view_data" => "1", "insert_data" => "1", "update_data" => "1", "delete_data" => "1"]);
                OoapMasRolePer::create(["role_id" => "3", "submenu_id" => $va->submenu_id, "view_data" => "1", "insert_data" => "1", "update_data" => "1", "delete_data" => "1"]);


            }
        }
    }
}
