<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
// use yii\helpers\Url;

use app\components\UserController;
use app\models\PerPersonal1;
use yii\helpers\Url;

class ApiController extends Controller
{

    public function init()
    {
        parent::init();
        if (Yii::$app->user->isGuest) {
            UserController::chkLogin();
            exit;
        }
    }

    public function actionIndex()
    {


        // PerPersonal1
        // echo 'dsdassfd';
        // $id = 33;

        // $res = PerPersonal1::findOne($id);

        // arr( $res->DPIS6_DATA    );

        // exit;

        // $text = ' {"per_id":"110060023452201","per_cardno":"1100600234522","birth_date":"1989-07-24","fullname_th":"\u0e19\u0e32\u0e22\u0e04\u0e31\u0e21\u0e20\u0e35\u0e23\u0e4c \u0e14\u0e2d\u0e01\u0e41\u0e01\u0e49\u0e27","prename_th":"\u0e19\u0e32\u0e22","per_name":"\u0e04\u0e31\u0e21\u0e20\u0e35\u0e23\u0e4c","per_surname":"\u0e14\u0e2d\u0e01\u0e41\u0e01\u0e49\u0e27","prename_en":"Mr.","per_eng_name":"Khumpee","per_eng_surname":"Dorkkaew","fullname_en":"Mr.Khumpee Dorkkaew","per_startdate":"2022-09-26","per_occupydate":"2022-09-26","pertype_id":"5","pertype":"\u0e02\u0e49\u0e32\u0e23\u0e32\u0e0a\u0e01\u0e32\u0e23\u0e1e\u0e25\u0e40\u0e23\u0e37\u0e2d\u0e19\u0e2a\u0e32\u0e21\u0e31\u0e0d","linename_th":"\u0e19\u0e31\u0e01\u0e27\u0e34\u0e0a\u0e32\u0e01\u0e32\u0e23\u0e40\u0e07\u0e34\u0e19\u0e41\u0e25\u0e30\u0e1a\u0e31\u0e0d\u0e0a\u0e35","pos_no":"1719","levelname_th":"\u0e23\u0e30\u0e14\u0e31\u0e1a\u0e1b\u0e0f\u0e34\u0e1a\u0e31\u0e15\u0e34\u0e01\u0e32\u0e23","organize_th":"\u0e01\u0e25\u0e38\u0e48\u0e21\u0e07\u0e32\u0e19\u0e01\u0e32\u0e23\u0e40\u0e07\u0e34\u0e19\u0e41\u0e25\u0e30\u0e1a\u0e31\u0e0d\u0e0a\u0e35","organize_th_ass":"\u0e01\u0e25\u0e38\u0e48\u0e21\u0e07\u0e32\u0e19\u0e01\u0e32\u0e23\u0e40\u0e07\u0e34\u0e19\u0e41\u0e25\u0e30\u0e1a\u0e31\u0e0d\u0e0a\u0e35","per_status":"1"}';

        // $text = json_decode( $text );

        // arr( $text );
        $req = Yii::$app->request->get();
        // $req = Yii::$app->request->post();

        $seltype = isset($req['seltype']) ? $req['seltype'] : 1;
        $start = isset($req['start']) ? $req['start'] : 0;
        $length = isset($req['length']) ? $req['length'] : 10;

        if ($seltype == 1) {

            $con = Yii::$app->dbdpis;
        } else {

            $con = Yii::$app->dbdpisemp;
        }

        $sql = "
            SELECT
                count( * ) as t
            FROM per_personal
            [WHERE]
            
        ";

        $replace = [];
        $bindValue = [];
        if (isset($req['per_cardno'])) {


            if( 0 ) {

                $replace['WHERE'][] = "per_cardno LIKE '%".  $req['per_cardno'] ."%'";
    
                // $bindValue['per_cardno'] = '%' . $req['per_cardno'] . '%';
            }
            else {

                $replace['WHERE'][] = "per_cardno LIKE :per_cardno";
    
                $bindValue['per_cardno'] = '%' . str_replace( ' ', '%', $req['per_cardno'] )  . '%';
            }

        }


        // arr( $req );

        $cmd = genCond_($sql, $replace, $con, $bindValue);

        $totalRecords = 0;
        foreach ($cmd->queryAll() as $kt => $vt) {

            $totalRecords = $vt['T'];
        }

        $sql = "
            SELECT
                NVL( p.update_date , '-') as update_date_,
                CONCAT( p.per_name, CONCAT(' ', p.per_surname) ) as full_name_thai,
                CONCAT( p.per_eng_name, CONCAT(' ', p.per_eng_surname) ) as full_name_en,
                p.per_cardno,
                p.per_status,
                p.per_startdate,
                p.per_occupydate,
                p.pos_id,
                p.per_id,
                t.ot_name,
                CASE
                    WHEN p.per_status = -1 THEN 'ยังไม่มี per_id'
                    WHEN p.per_status = 0 THEN 'รอบรรจุ'
                    WHEN p.per_status = 1 THEN 'ปกติ'
                    WHEN p.per_status = 2 THEN 'พ้นจากราชการแล้ว'
                    WHEN p.per_status = 3 THEN 'รอคำสั่งบรรจุ/รอเลขที่ตำแหน่ง'
                    ELSE 'ไม่มาปฏิบัติงาน'
                END as per_status_name,
                p.dpis6_data,
                p.level_no,
                p.org_id as organize_th,
                p.org_id as organize_th_ass

            FROM per_personal p 
            LEFT JOIN per_off_type t ON p.ot_code = t.ot_code
            [WHERE]
            [ORDER]
            OFFSET " . $start . " ROWS FETCH NEXT :length ROWS ONLY
        ";

        $bindValue['length'] = $length;
        $orders = [];
        if( isset( $req['columns'] ) ) {

            foreach( $req['columns']  as $kc => $vc ) {
    
                if( $kc == $req['order'][0]['column'] ) {
    
                    $orders[] = $vc['data'] ." ". $req['order'][0]['dir'];
                }
    
            }
        }


        $replace['ORDER'] = NULL;
        if( !empty( $orders ) ) {

            $replace['ORDER'] = "ORDER BY " . implode( ' , ', $orders );
        }
        
        $cmd = genCond_( $sql, $replace, $con, $bindValue );


        // arr( $cmd->sql );
        
        $keep = [];
        foreach( $cmd->queryAll() as $kd => $vd ) {

            $json_decode = json_decode( $vd['DPIS6_DATA'] );

            $vd['LEVEL_NO'] = $json_decode->levelname_th;
            $vd['ORGANIZE_TH'] = $json_decode->organize_th;
            $vd['ORGANIZE_TH_ASS'] = $json_decode->organize_th_ass;
            $keep[] = $vd;
        }

        echo json_encode(
            [
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecords,
                "aaData" =>  $keep,
            ]
        );

        exit;
    }

    public function actionGetuser()
    {

        $seltype = isset($_REQUEST['seltype']) ? $_REQUEST['seltype'] : 1;
        $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
        $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : 10;

        $con = Yii::$app->db;


        $sql = "
            SELECT 
                count(*) as t
        
            FROM mas_user
        
        ";

        $replace = [];
        $bindValue = [];
        if (isset($_REQUEST['per_cardno'])) {

            // $replace['WHERE'][] = "per_cardno LIKE :per_cardno";

            // $bindValue['per_cardno'] = '%'. $_REQUEST['per_cardno'] .'%';
        }


        $cmd = genCond_($sql, $replace, $con, $bindValue);


        $totalRecords = 0;
        foreach ($cmd->queryAll() as $kt => $vt) {
            $totalRecords = $vt['t'];
        }

        $sql = "
            SELECT 
                u.id, 
                u.uid, 
                u.displayname, 
                u.ssobranch_code, 
                u.ssomail, 
                u.lasted_login_date, 
                u.status, 
                u.create_by, 
                u.create_date, 
                u.update_by,
                u.update_date, 
                b.name as branch_name
            FROM mas_user u
            LEFT JOIN mas_ssobranch b ON u.ssobranch_code = b.ssobranch_code
            ORDER BY 
                u.id DESC
            LIMIT 0,  :length
            
        ";

        $bindValue[':length'] = intval($length);

        $cmd = genCond_($sql, $replace, $con, $bindValue);

        $keep = [];
        $user_id = Yii::$app->user->getId();
        foreach ($cmd->queryAll() as $ka => $dataitem) {

            $dataitem['btn'] = '';
            $dataitem['btn1'] = '';
            if ($dataitem["id"] !=  $user_id) {

                $dataitem['btn1'] = '<input type="checkbox" class="js-switch_work_status" id="input_work_status' . $dataitem["id"] . '" name="input_work_status' . $dataitem["id"] . '" data-id="' . $dataitem["id"] . '" data-status="' . $dataitem["status"] . '" data-plugin="switchery" ' . ($dataitem["status"] == 1 ? "checked" : "") . '  />';

                

                $dataitem['btn'] = '
                    <div class="btn-group" role="group">
                        <a href="'. Url::to(['empdata/user_register', 'id' => $dataitem["id"]]) .'" class="btn btn-icon btn-info waves-effect waves-classic"><i class="icon md-edit" aria-hidden="true"></i></a>
                    </div>
                ';

                
            }


            $keep[] = $dataitem;
        }

        // exit;

        return json_encode(
            [
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecords,
                "aaData" =>  $keep,
            ]
        );
    }
}
