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
        // $req = Yii::$app->request->get();
        $req = Yii::$app->request->post();

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

            $replace['WHERE'][] = "per_cardno LIKE :per_cardno";

            $bindValue['per_cardno'] = '%' . $req['per_cardno'] . '%';
        }


        $cmd = genCond_($sql, $replace, $con, $bindValue);

        $totalRecords = 0;
        foreach ($cmd->queryAll() as $kt => $vt) {

            $totalRecords = $vt['T'];
        }
   
        $sql = "
            SELECT
                NVL( update_date , '-') as update_date_,
                CONCAT( per_name, CONCAT(' ', per_surname) ) as full_name_thai,
                CONCAT( per_eng_name, CONCAT(' ', per_eng_surname) ) as full_name_en,
                per_cardno,
                per_status,
                per_startdate,
                per_occupydate,
                level_no,
                per_id
            FROM per_personal 
            [WHERE]
            [ORDER]
            OFFSET " . $start . " ROWS FETCH NEXT :length ROWS ONLY
        ";

        $bindValue['length'] = $length;

        foreach( $req['columns']  as $kc => $vc ) {

            if( $kc == $req['order'][0]['column'] ) {

                $orders[] = $vc['data'] ." ". $req['order'][0]['dir'];
            }

        }

        $orders[] = "per_id DESC";

        $replace['ORDER'] = "ORDER BY " . implode( ' , ', $orders );

        $cmd = genCond_( $sql, $replace, $con, $bindValue );

        echo json_encode(
            [
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecords,
                "aaData" =>  $cmd->queryAll(),
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
