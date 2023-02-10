<?php

namespace App\Http\Controllers;

use App\Models\OoapMasEstimate;
use App\Models\OoapMasRolePer;
use App\Models\OoapMasSubmenu;
use App\Models\OoapTblBudgetProjectplanPeriod;
use App\Models\User;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

use App\Exports\Report1ExelExport;
use App\Models\OoapTblFiscalyear;
use App\Models\OoapTblFiscalyearReqPeriod;
use App\Models\OoapTblFybdtransfer;
use App\Models\OoapTblNotification;
use App\Models\OoapTblNotificationLog;
use App\Models\OoapTblPlanAdjust;
use App\Models\OoapTblPopulation;
use App\Models\OoapTblRequest;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class testController extends Controller
{

    public function get_request()
    {
        $test = OoapTblRequest::getTbDatas()->take(5)->get();

        return $test;
    }

    public function select_area_example()
    {
        $data = OoapMasEstimate::find(1);

        return view('test', ['data' => $data]);
    }

    public function show_per_personal()
    {

        echo 'dsafdsfds';

    }


    //
    public function index(Request $request)
    {
        return createSeedText('per_prename');

        $datas[] = ['id'=>1, 'name'=>'goog'];
        $datas[] = ['id'=>1, 'name'=>'goog'];

        return $datas;

        // DB
        return createSeedText('PER_PERSONAL');

        return DB::connection()->getDatabaseName(); //bombtest
        return DB::connection()->getDatabaseName(); //db_ooap

        $dd = OoapTblRequest::getAreas()->toSql();

        return $dd;

        return;

        return createSeedText('OoapTblEmployee');
        return createSeedText('OoapMasCourseOwnertype');
        return createSeedText('OoapMasCoursetype');
        return createSeedText('OoapMasCoursesubgroup');
        return createSeedText('OoapMasCoursegroup');
        return createSeedText('OoapMasActtype');
        return createSeedText('OoapMasCourseOwnertype');
        return createSeedText('OoapMasCourse');
        return createSeedText('OoapMasCoursesubgroup');
        return createSeedText('OoapMasCoursegroup');
        return createSeedText('OoapMasCoursetype');
        return createSeedText('OoapMasCoursetype');
        return createSeedText('OoapMasCoursegroup');
        return createSeedText('OoapMasActtype');
        return createSeedText('OoapMasCoursesubgroup');

        $ddas = OoapTblRequest::getDatas()->get();
        foreach ( $ddas as $kd => $vd) {

            echo $vd->req_year;
echo '<br>';
echo $vd->total_req_sumreqamt;

echo '<br>';
                OoapTblFiscalyear::where('fiscalyear_code', '=', $vd->req_year)
                ->update([
                    'req_urgentamt' => $vd->total_req_urgentamt,
                    'req_skillamt' => $vd->total_req_skillamt,
                    'req_sumreqamt' => $vd->total_req_sumreqamt,

                ]);
        }


        // foreach ( OoapTblFybdtransfer::getTotalByYears()->get() as $ka => $va) {

        //     OoapTblFiscalyear::where('fiscalyear_code', '=', $va->fiscalyear_code)->update([
        //         'transfer_amt' => $va->total_transfer_amt,
        //         'remember_token' => csrf_token(),
        //         'updated_by' => auth()->user()->emp_citizen_id,
        //         'updated_at' => now(),
        //     ]);
        // }




        dd('dsda');



        return;

        $data = OoapTblPlanAdjust::select(
            'ooap_tbl_plan_adjusts.plan_id',
            'ooap_mas_tambon.tambon_name',
            'ooap_mas_amphur.amphur_name',
            'ooap_tbl_plan_adjusts.plan_number',
            'ooap_tbl_plan_adjusts.plan_year',
            'ooap_tbl_plan_adjusts.plan_periodno',
            'ooap_tbl_plan_adjusts.plan_acttype',
            'ooap_tbl_plan_adjusts.plan_div',
            'ooap_mas_acttype.name',
            'ooap_tbl_plan_adjusts.plan_district',
            'ooap_tbl_plan_adjusts.plan_subdistrict',
            'ooap_tbl_plan_adjusts.plan_moo',
            'ooap_tbl_plan_adjusts.plan_startmonth',
            'ooap_tbl_plan_adjusts.plan_endmonth',
            'ooap_tbl_plan_adjusts.plan_numofday',
            'ooap_tbl_plan_adjusts.plan_numofpeople',
            'ooap_tbl_plan_adjusts.plan_amount',
            'ooap_tbl_plan_adjusts.status'
        )
            ->leftjoin('ooap_mas_acttype', 'ooap_tbl_plan_adjusts.plan_acttype', 'ooap_mas_acttype.id')
            ->leftjoin('ooap_mas_tambon', 'ooap_tbl_plan_adjusts.plan_subdistrict', 'ooap_mas_tambon.tambon_id')
            ->leftjoin('ooap_mas_amphur', 'ooap_tbl_plan_adjusts.plan_district', 'ooap_mas_amphur.amphur_id')
            ->where('ooap_tbl_plan_adjusts.in_active', '=', false);
        // ->where('ooap_tbl_plan_adjusts.status', '=', 0);

        if ($request->plan_year) {
            $data = $data->where('ooap_tbl_plan_adjusts.plan_year', '=', intval($request->plan_year));
        }

        $request->plan_periodno = 'dfdd';
        if ($request->plan_periodno) {
            $data = $data->where('ooap_tbl_plan_adjusts.plan_periodno', '=', $request->plan_periodno);
        }
        $request->txt_search = 'ddfd';
        if ($request->txt_search) {
            $data = $data->where(function ($query) use ($request) {
                $query->where('ooap_tbl_plan_adjusts.plan_number', 'LIKE', '%' . $request->txt_search . '%')
                    ->orWhere('ooap_mas_acttype.name', 'LIKE', '%' . $request->txt_search . '%')
                    ->orWhere('ooap_mas_amphur.amphur_name', 'LIKE', '%' . $request->txt_search . '%')
                    ->orWhere('ooap_mas_tambon.tambon_name', 'LIKE', '%' . $request->txt_search . '%')
                    ->orWhere('ooap_tbl_plan_adjusts.plan_moo', 'LIKE', '%' . $request->txt_search . '%');
            });
        }

        return $data->toSql();

        return;


        dd(OoapTblFiscalyearReqPeriod::getNextRequestTime());

        exit;

        $value = request()->getRequestUri();
        $value = request()->route()->getName();

        dd($value);


        exit;

        if (1) {
            $datas = [
                'noti_name' => 'dddddddddd',
                'noti_detail' => 'gggggggggg',
                'noti_to' => ['3920200161055', 'tcmad'],
                // 'noti_to' => ['all'],
                // 'noti_to' => [],
                'noti_link' => 'http://tcm/master/fiscalyear',
            ];

            OoapTblNotification::create_($datas);
        }


        exit;



        //     $t1 = strtotime("2022-11-13 01:45:35");
        //     $t2 = strtotime("2022-11-13 11:39:30");

        //    echo  getTimeAgo( $t1, $t2 );

        //     exit;


        if (false) {


            foreach (OoapTblNotification::getDatas(auth()->user()->emp_citizen_id) as $ka => $va) {

                arr($va);
            }
        }



        // $datas = [
        //     'parent_id' =>4454,
        //     'receive_nationalid' => 4545454,
        //     'receive_date' =>  now(),
        //     'created_by' => auth()->user()->emp_citizen_id,
        //     'created_at' => now(),
        // ];

        // OoapTblNotificationLog::create_( $datas );

        exit;


        $datas = OoapTblPopulation::getReport1();

        $config = [

            'region' => ['label' => 'ภาค'],
            'province' => ['label' => 'จังหวัด'],
            'act_shortname' => ['label' => 'กิจกรรม'],
            'people_checkin' => ['label' => 'จำนวนผู้เข้าร่วม'],
            'total_score' => ['label' => 'ความพึงพอใจ'],
            't' => ['label' => 'จำนวนผู้ประเมิน'],
            'total_avg' => ['label' => 'ความพึงพอใจเฉลี่ย'],
        ];
        return Excel::download(new Report1ExelExport($datas, $config), 'บันทึกข้อมูลคำขอรับการจัดสรรงบประมาณ.xlsx');

        exit;





        return createSeedText('OoapTblFybdpayment');
        return createSeedText('OoapMasProvince');
        //
        return createSeedText('OoapMasAmphur');
        //return createSeedText('OoapMasTambon');
        // User::create(
        //     ['name' => 'ttttgdgtt', 'email' => 'uttgdfddfdfggdgttuu@user.com', 'password' => Hash::make('adsdsdsfdmin1234')],

        // );

        return User::whereEncrypted('name', 'user')->get();


        //whereEncrypted('menu_name','จัดการข้อมูลกลาง');
        exit;
        //echo getEmployeeImg( '3400100592644');

        exit;
        exit;


        $encrypter = new Encrypter('PeVKxcage5QNJqiC', 'AES-256-CBC');

        // if ($type == 'encrypt') {

        //     return $encrypter->encrypt($code);
        // }

        return $encrypter->decrypt('SzIxdU1TU0RSaXNSejJoOUVpMlphdz09');


        echo getEncrypter('SzIxdU1TU0RSaXNSejJoOUVpMlphdz09', $type = 'enfddfdfcrypt');

        exit;
        echo createSeedText('OoapMasRolePer');

        exit;

        $data = OoapMasRolePer::get()->toArray();

        arr($data);
        exit;
        return view('test', ['data' => $data]);
    }



    public function show_route()
    {
        $SvlsMasSubmenu = OoapMasSubmenu::getDatas();

        foreach ($SvlsMasSubmenu as $ka => $va) {

            if (empty($va->route_name)) {
                continue;
            }

            $keep[] = $va->route_name;
        }


        arr($keep);


        $routeCollection = Route::getRoutes();


        foreach ($routeCollection as $value) {

            if (empty($value->getName())) {
                continue;
            }

            if (in_array($value->getName(), $keep)) {
                continue;
            }

            if ($value->getName()  == 'request.request2_1.index') {

                $start = 1;
            }

            if (empty($start)) {
                continue;
            }

            $inserts[] = [
                $value->getName(),
                $value->methods()[0],
                $value->uri(),
                $value->getActionName(),

            ];
            // echo $value->getName() . "<br>";
            //echo "</tr>";
        }


        arr($inserts);


        // echo "</table>";

        exit;
    }
}
