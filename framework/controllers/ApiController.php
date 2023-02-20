<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
// use yii\helpers\Url;

use app\components\UserController;
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

        $req = Yii::$app->request->get();

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

        $cmd = genCond_($sql, $replace, $con, $bindValue);

        $totalRecords = 0;
        foreach ($cmd->queryAll() as $kt => $vt) {

            $totalRecords = $vt['T'];
        }

        $sql = "
            SELECT
                p.per_cardno,
                p.pos_id,
                CONCAT( p.per_name, CONCAT(' ', p.per_surname ) ) as full_name_thai,
                l.level_code as level_no,
                orga.organize_th as organize_th_ass,
                orga2.organize_th as organize_th,
                t.pertype as ot_name,
                CASE
                    WHEN p.per_status = -1 THEN 'ยังไม่มี per_id'
                    WHEN p.per_status = 0 THEN 'รอบรรจุ'
                    WHEN p.per_status = 1 THEN 'ปกติ'
                    WHEN p.per_status = 2 THEN 'พ้นจากราชการแล้ว'
                    WHEN p.per_status = 3 THEN 'รอคำสั่งบรรจุ/รอเลขที่ตำแหน่ง'
                    ELSE 'ไม่มาปฏิบัติงาน'
                END as per_status_name
            FROM per_personal_news p
            LEFT JOIN per_off_type_news t ON p.pertype_id = t.pertype_id
            LEFT JOIN per_position_news po ON p.pos_id = po.pos_id
            LEFT JOIN per_org_ass_news orga2 ON p.organize_id_ass = orga2.organize_id
            LEFT JOIN per_org_ass_news orga ON po.organize_id = orga.organize_id
            LEFT JOIN per_level_news l ON p.per_level_id = l.level_id
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


    public function actionIndex____()
    {

        $req = Yii::$app->request->get();

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
                lv.level_name,
                a.org_name as organize_th_ass,
                ap.org_name as organize_th
            FROM per_personal p 
            LEFT JOIN per_position pos ON p.pos_id = pos.pos_id
            LEFT JOIN per_org_ass ap ON pos.org_id = ap.org_id
            LEFT JOIN per_org_ass a ON p.org_id = a.org_id
            LEFT JOIN per_level lv ON p.level_no = lv.level_no
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
