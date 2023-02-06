<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
// use yii\helpers\Url;

use app\components\UserController;
use app\models\MasSsobranch;
use app\models\MasUser;
use yii\helpers\Url;

class ProfileController extends Controller
{

    public function init()
    {
        parent::init();
        if (Yii::$app->user->isGuest) {
            UserController::chkLogin();
            exit;
        }
    }

    // http://samservice/profile
    public function actionIndex($id = NULL)
    {

        $id = Yii::$app->user->identity->id;

        $res = MasUser::findOne($id);

        if (Yii::$app->request->isPost) {


            $keep_errors = [];

            $r = Yii::$app->request->post();

            if (!$res) {

              
            }


            $res->uid = $r['uid'];

            if (!empty($r['password'])) {

                if ($r['password'] != $r['passwordcheck']) {

                    $keep_errors['passwordcheck'] = 'confirm password not match';
                }

                $res->password = Yii::$app->getSecurity()->generatePasswordHash($r['password']);
            }


            // ssobranch_code

            $res->displayname = $r['displayname'];
            $res->status = 1;
            $res->create_by = json_encode(Yii::$app->user->getId());

            if (!$res->validate()) {

                foreach ($res->errors as $ke => $ve) {
                    $keep_errors[$ke] = $ve;
                }
            }

            if (!empty($keep_errors)) {

                Yii::$app->session->setFlash('warning', json_encode($keep_errors));

            }
            else {

                $res->save();
            }

            $log_page = Yii::$app->request->referrer;

            return Yii::$app->getResponse()->redirect($log_page);

        }

        //view
        $datas['form']['id'] = NULL;
        $datas['form']['uid'] = NULL;
        $datas['form']['displayname'] = NULL;
        $datas['form']['ssobranch_code'] = NULL;
        $datas['button_text'] = 'บันทึกข้อมูล';


        $datas['check1'] = 'checked';
        $datas['check2'] = NULL;
        if ($res) {

            $datas['form'] = $res;
            // $datas['button_text'] = 'แก้ไขผู้ใช้งาน';

            if ($res->role_id != 1) {

                $datas['check1'] = NULL;
                $datas['check2'] = 'checked';
            }


        }

        $datas['MasSsobranch'] = MasSsobranch::find()->all();


        // arr( $res );


        return $this->render('view_user_new', $datas);
    }

}
