<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
// use yii\helpers\Url;

use app\components\UserController;

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
        $seltype = isset( $_REQUEST['seltype']) ? $_REQUEST['seltype']: 1;
        $start = isset( $_REQUEST['start'])? $_REQUEST['start']: 0;
        $length = isset( $_REQUEST['length'])? $_REQUEST['length']: 10;

        if( $seltype == 1 ) {

            $con = Yii::$app->dbdpis;
        }
        else {

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
        if( isset( $_REQUEST['per_cardno']) ) {

            $replace['WHERE'][] = "per_cardno LIKE :per_cardno";

            $bindValue['per_cardno'] = '%'. $_REQUEST['per_cardno'] .'%';
        }
       

        $cmd = genCond_($sql, $replace, $con, $bindValue );


        $totalRecords = 0;
        foreach( $cmd->queryAll() as $kt => $vt ) {

            $totalRecords = $vt['T'];
        }

        $sql = "
            SELECT
                per_cardno,
                per_name,
                per_surname,
                per_status,
                per_eng_name,
                per_eng_surname,
                per_startdate,
                per_occupydate,
                level_no,
                per_id
            FROM per_personal 
            [WHERE]
            ORDER BY per_id ASC
            OFFSET ". $start ." ROWS FETCH NEXT :length ROWS ONLY
        ";

        $bindValue['length'] = $length;

        $cmd = genCond_($sql, $replace, $con, $bindValue );
        
        echo json_encode( 
            [
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecords,
                "aaData" =>  $cmd->queryAll(),
            ]
        );
    }

}
