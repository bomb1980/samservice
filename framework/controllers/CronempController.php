<?php

namespace app\controllers;

use app\models\MasUser;
use Yii;
use yii\web\Controller;
// use yii\helpers\Url;

use app\models\PerPersonal1;

class CronempController extends Controller
{

    // http://samservice/cronemp/
    public function actionIndex()
    {

        $request = Yii::$app->request;
        $uid = $request->get("uid"); //'ksukrit'

        // $password = $request->get("password","sukrit6290" );

        $MasUser = MasUser::find()
            ->where(['uid' => $uid])
            ->one();

        if ($MasUser) {

            // if (password_verify($password, $MasUser->password)) {


            // }
            
            echo PerPersonal1::getFromApi($MasUser->id);
            exit;
        }

        $datas['status'] = 'fail';
        $datas['msg'] = 'ไม่สำเร็จ';

        echo json_encode( $datas );

        exit;

    }
}
