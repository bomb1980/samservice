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

    public function actionFiles()
    {

        $req = Yii::$app->request->get();

        $seltype = isset($req['seltype']) ? $req['seltype'] : 1;
        $start = isset($req['start']) ? $req['start'] : 0;
        $length = isset($req['length']) ? $req['length'] : 10;

       
        $con = Yii::$app->db;

        $sql = "
            SELECT
                count( * ) as t
            FROM tb_save_files        
            [WHERE] 
        ";

        $replace = [];
        $bindValue = [];
       

        $cmd = genCond_($sql, $replace, $con, $bindValue);

        $totalRecords = 0;
        foreach ($cmd->queryAll() as $kt => $vt) {


            $totalRecords = $vt['t'];
        }

        $sql = "
            SELECT
                p.*,
                CONCAT( '<a target=\"blank_\" href=\"empdata/loadfile/', p.id,'\">ดาวน์โหลด</a>') as download_link
            FROM tb_save_files p
           
            [WHERE]
            [ORDER]
            
        ";

        // $bindValue['length'] = $length;

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


    

    public function actionPertype()
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
            FROM per_off_type_news        
            [WHERE] 
        ";

        $replace = [];
        $bindValue = [];
        if (isset($req['per_cardno'])) {
             
            // $replace['WHERE'][] = "per_cardno LIKE :per_cardno";

            // $bindValue['per_cardno'] = '%' . str_replace( ' ', '%', $req['per_cardno'] )  . '%';

        }

        $cmd = genCond_($sql, $replace, $con, $bindValue);

        $totalRecords = 0;
        foreach ($cmd->queryAll() as $kt => $vt) {

            $totalRecords = $vt['T'];
        }

        $sql = "
            SELECT
                p.*
            FROM per_off_type_news p
           
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
    public function actionOganize()
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
            FROM per_org_ass_news        
            [WHERE] 
        ";

        $replace = [];
        $bindValue = [];
        if (isset($req['per_cardno'])) {
             
            // $replace['WHERE'][] = "per_cardno LIKE :per_cardno";

            // $bindValue['per_cardno'] = '%' . str_replace( ' ', '%', $req['per_cardno'] )  . '%';

        }

        $cmd = genCond_($sql, $replace, $con, $bindValue);

        $totalRecords = 0;
        foreach ($cmd->queryAll() as $kt => $vt) {

            $totalRecords = $vt['T'];
        }

        $sql = "
            SELECT
                p.*
            FROM per_org_ass_news p
           
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



    public function actionPosition()
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
            FROM per_position_news        
            [WHERE] 
        ";

        $replace = [];
        $bindValue = [];
        if (isset($req['per_cardno'])) {
             
            // $replace['WHERE'][] = "per_cardno LIKE :per_cardno";

            // $bindValue['per_cardno'] = '%' . str_replace( ' ', '%', $req['per_cardno'] )  . '%';

        }

        $cmd = genCond_($sql, $replace, $con, $bindValue);

        $totalRecords = 0;
        foreach ($cmd->queryAll() as $kt => $vt) {

            $totalRecords = $vt['T'];
        }

        $sql = "
            SELECT
                p.*
            FROM per_position_news p
           
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


    public function actionLine()
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
            FROM per_line_news        
            [WHERE] 
        ";

        $replace = [];
        $bindValue = [];
        if (isset($req['per_cardno'])) {
             
            // $replace['WHERE'][] = "per_cardno LIKE :per_cardno";

            // $bindValue['per_cardno'] = '%' . str_replace( ' ', '%', $req['per_cardno'] )  . '%';

        }

        $cmd = genCond_($sql, $replace, $con, $bindValue);

        $totalRecords = 0;
        foreach ($cmd->queryAll() as $kt => $vt) {

            $totalRecords = $vt['T'];
        }

        $sql = "
            SELECT
                p.*
            FROM per_line_news p
           
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



    public function actionLevel()
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
            FROM per_level_news        
            [WHERE] 
        ";

        $replace = [];
        $bindValue = [];
        if (isset($req['per_cardno'])) {
             
            // $replace['WHERE'][] = "per_cardno LIKE :per_cardno";

            // $bindValue['per_cardno'] = '%' . str_replace( ' ', '%', $req['per_cardno'] )  . '%';

        }

        $cmd = genCond_($sql, $replace, $con, $bindValue);

        $totalRecords = 0;
        foreach ($cmd->queryAll() as $kt => $vt) {

            $totalRecords = $vt['T'];
        }

        $sql = "
            SELECT
                p.*
            FROM per_level_news p
           
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

 

    public function actionIndex()
    {

        $req = Yii::$app->request->get();

        $seltype = isset($req['seltype']) ? $req['seltype'] : 1;
        $start = isset($req['start']) ? $req['start'] : 0;
        $length = isset($req['length']) ? $req['length'] : 10;

        // if ($seltype == 1) {

        //     $con = Yii::$app->dbdpis;
        // } else {

        //     $con = Yii::$app->dbdpisemp;
        // }
        
        $con = Yii::$app->db;
        $sql = "
            SELECT
                COUNT( * ) as tt
            FROM per_personal_news p
            INNER JOIN per_off_type_news t ON p.pertype_id = t.pertype_id
            LEFT JOIN per_position_news po ON p.pos_id = po.pos_id
            LEFT JOIN per_org_ass_news o ON po.organize_id = o.organize_id
            LEFT JOIN per_line_news l ON po.line_id = l.line_id
            LEFT JOIN per_level_news lev ON p.per_level_id = lev.level_id
            [WHERE]
    
        ";

        $replace = [];
        $bindValue = [];
        if (isset($req['per_cardno'])) {
             
            // arr('dsafds');
            $replace['WHERE'][] = "p.per_cardno LIKE :per_cardno";

            $bindValue['per_cardno'] = '%' . str_replace( ' ', '%', $req['per_cardno'] )  . '%';

        }

        $cmd = genCond_($sql, $replace, $con, $bindValue);

        // arr( $cmd->sql );


        $totalRecords = 0;
        foreach ($cmd->queryAll() as $kt => $vt) {

            $totalRecords = $vt['tt'];
        }

        // $sql = "
        //     SELECT
        //         p.per_cardno,
        //         p.pos_id,
        //         CONCAT( p.per_name, CONCAT(' ', p.per_surname ) ) as full_name_thai,
        //         l.level_code as level_no,
        //         orga.organize_th as organize_th_ass,
        //         orga2.organize_th as organize_th,
        //         t.pertype as ot_name,
        //         CASE
        //             WHEN p.per_status = -1 THEN 'ยังไม่มี per_id'
        //             WHEN p.per_status = 0 THEN 'รอบรรจุ'
        //             WHEN p.per_status = 1 THEN 'ปกติ'
        //             WHEN p.per_status = 2 THEN 'พ้นจากราชการแล้ว'
        //             WHEN p.per_status = 3 THEN 'รอคำสั่งบรรจุ/รอเลขที่ตำแหน่ง'
        //             ELSE 'ไม่มาปฏิบัติงาน'
        //         END as per_status_name
        //     FROM per_personal_news p
        //     LEFT JOIN per_off_type_news t ON p.pertype_id = t.pertype_id
        //     LEFT JOIN per_position_news po ON p.pos_id = po.pos_id
        //     LEFT JOIN per_org_ass_news orga2 ON p.organize_id_ass = orga2.organize_id
        //     LEFT JOIN per_org_ass_news orga ON po.organize_id = orga.organize_id
        //     LEFT JOIN per_level_news l ON p.per_level_id = l.level_id
        //     [WHERE]
        //     [ORDER]
        //     LIMIT " . $start . ", ". $length ."
        // ";

        // [personal_id] => 3100601829038
        // [thai_title] => นางสาว
        // [thai_firstname] => ภรัณยา
        // [eng_title] => Miss
        // [eng_firstname] => PARUNYA
        // [eng_lastname] => THANOMKAEO
        // [start_date] => 2001-10-29
        // [birth_date] => 1972-10-17
        // [status] => 1
        // [thai_lastname] => ถนอมแก้ว
        // [per_status_name] => ปกติ
        // [branch_name] => กองบริหารทรัพยากรบุคคล
        // [off_type] => ข้าราชการพลเรือนสามัญ
        // [org_name] => กองบริหารทรัพยากรบุคคล
        // [org_ass_name] => กองบริหารทรัพยากรบุคคล
        // [position] => นิติกร
        // [level_name] => ระดับชำนาญการ
        $sql = "
        
            SELECT
                p.per_cardno as personal_id,
                p.prename_th as thai_title,
                p.per_name as thai_firstname ,
                p.per_surname as thai_lastname,
                CONCAT( p.per_name, ' ', p.per_surname ) as full_name,
                p.prename_en as eng_title,
                p.per_eng_name as eng_firstname ,
                p.per_eng_surname as eng_lastname,
                p.per_startdate as start_date,
                p.birth_date as birth_date,
                p.per_status as status,
                CASE
                    WHEN p.per_status = -1 THEN 'ยังไม่มี per_id'
                    WHEN p.per_status = 0 THEN 'รอบรรจุ'
                    WHEN p.per_status = 1 THEN 'ปกติ'
                    WHEN p.per_status = 2 THEN 'พ้นจากราชการแล้ว'
                    WHEN p.per_status = 3 THEN 'รอคำสั่งบรรจุ/รอเลขที่ตำแหน่ง'
                    ELSE 'ไม่มาปฏิบัติงาน'
                END as per_status_name,
                o.division as branch_name,
                t.pertype as off_type,
                o.division as org_name,
                ( select division from per_org_ass_news where organize_id = p.organize_id_ass) as org_ass_name,
                l.linename_th as position,
                lev.levelname_th as level_name
            FROM per_personal_news p
            INNER JOIN per_off_type_news t ON p.pertype_id = t.pertype_id
            LEFT JOIN per_position_news po ON p.pos_id = po.pos_id
            LEFT JOIN per_org_ass_news o ON po.organize_id = o.organize_id
            LEFT JOIN per_line_news l ON po.line_id = l.line_id
            LEFT JOIN per_level_news lev ON p.per_level_id = lev.level_id
            [WHERE]
            [ORDER]
            LIMIT " . $start . ", ". $length ."
        ";
            
            // OFFSET " . $start . " ROWS FETCH NEXT :length ROWS ONLY
        // $bindValue['length'] = $length;

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

            // arr($vd);

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
