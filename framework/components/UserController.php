<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
 
 namespace app\components;
 use Yii;
 use yii\base\Component;

 use app\models\LoginForm;

 
class UserController  {

	public $layout='//layouts/column1';

	public $menu=array();

	public $breadcrumbs=array();
	
    public $pageTitle = '';	
	
	public static function chkLogin() {

		/*
			$model=new CommonAction;
			$model->uid = "ksukrit";			
			$model->displayname = "สุกฤต กมลวัฒนา";
			$model->ssobranch_code = "1050";
			$model->ssomail = "sukrit.k@sso.go.th";			
			$rows = $model->Check_mas_user();
		*/

		/*if(Yii::app()->user->isGuest) { 
			$idplib = new idplib();	
			$idplib->getIdpinfo();
			$idplib->setStateuser();

			$model=new CommonAction;
			$model->uid = Yii::app()->user->getState("sub"); 

			if($model->uid == NULL || Yii::app()->user->getState("SSObranchCode") == NULL){
				Yii::app()->session['errmsg_login']='รหัสผู้ใช้ ไม่ถูกต้องหรือไม่มีในระบบ';
				$this->renderPartial('//logout/index', array("res" => Yii::app()->session['errmsg_login'], 'type'=>'login' ));
				return false;
			}

			$displayname = Yii::app()->user->getState("SSOfirstname") . " " . Yii::app()->user->getState("SSOsurname") ;
			$model->displayname = $displayname;
			$model->ssobranch_code = Yii::app()->user->getState("SSObranchCode");
			$model->ssomail = Yii::app()->user->getState("SSOmail");
			
			$rows = $model->Check_mas_user();
			
			if( count($rows) == 0 ){
				$model->displayname = $displayname;
				$model->ssobranch_code = Yii::app()->user->getState("SSObranchCode");
				$model->ssomail = Yii::app()->user->getState("SSOmail");
				$user_id = $model->Add_mas_user();
			}

			$identity = new UserIdentity(Yii::app()->user->getState("sub"),""); 
			$identity->authenticate();

			if($identity->errorCode===UserIdentity::ERROR_NONE)
			{
				//$duration=3600*24*Yii::app()->params['prg_ctrl']['authCookieDuration'];
				Yii::app()->user->login($identity,1440);
				$idtoken2 = $idplib->idtoken;

				Yii::app()->user->setState("guid", $identity->getGUID() );
				
				CommonAction::AddLoginSession();
				CommonAction::AddLoginLog("Login","");				

				return true;
			}else{
				Yii::app()->session->destroy();
				if( $identity->errorCode === UserIdentity::ERROR_USERNAME_INVALID) {
					Yii::app()->session['errmsg_login']='รหัสผู้ใช้ ไม่ถูกต้องหรือไม่มีในระบบ';
					
				} elseif($identity->errorCode === UserIdentity::ERROR_PASSWORD_INVALID) {
					 Yii::app()->session['errmsg_login']='รหัสผ่าน ไม่ถูกต้อง';
					 
				} elseif($identity->errorCode === UserIdentity::ERROR_USERNAME_NOTADMIN) {
					Yii::app()->session['errmsg_login']='คุณไม่มีสิทธิ์ในการเข้าใช้งานระบบ';
	
				} elseif($identity->errorCode === UserIdentity::ERROR_USERNAME_INACTIVE) {
					Yii::app()->session['errmsg_login']='คุณไม่มีสิทธิ์ในการเข้าใช้งานระบบ';
					
				} else {
					Yii::app()->session['errmsg_login']='Invalid Exception1.';
				}		
				$this->renderPartial('//logout/index', array("res" => Yii::app()->session['errmsg_login'], 'type'=>'login' ));
				return false;
			}
		} else {
			CommonAction::ChkLoginSession(); 

			if(Yii::app()->user->getInfo('uid')==false){
				$this->redirect(Yii::app()->createUrl(''));
			}
		}*/

		if(Yii::$app->user->isGuest) {

			return Yii::$app->response->redirect(Yii::$app->urlManager->createUrl('/login')."/")->send(); 
			exit;
			//Yii::$app->response->redirect(Yii::$app->urlManager->createAbsoluteUrl('login/')."/");
return;
			
			//$this->redirect(Yii::$app->urlManager->createUrl('/login'));

			$identity = new UserIdentity("ksukrit",""); 
			$identity->authenticate();

			if($identity->errorCode===UserIdentity::ERROR_NONE)
			{
				Yii::app()->user->setState("guid", $identity->getGUID() );
				CommonAction::AddLoginSession();
				CommonAction::AddLoginLog("Login","");
				Yii::app()->user->setState("SSObranchCode", "1050");
				
				return true;
			}else{
				return false;
			}
		} else {
			//$this->redirect(Yii::app()->createUrl(''));

			$cwebuser = new \app\components\CustomWebUser();

			if($cwebuser->getInfo('uid')==false){
				Yii::app()->session['errmsg_login']='คุณไม่มีสิทธิ์ในการเข้าใช้งานระบบ กรุณาติดต่อสำนักบริหารเทคโนโลยีสารสนเทศ';
				$this->renderPartial('//logout/index', array("res" => Yii::app()->session['errmsg_login'], 'type'=>'login' ));
				exit;				
			}

			//$this->redirect(Yii::app()->createUrl(''));

		}
	}
	
	public function setStateuser(){
		$arr = (array)$this->sub;
		$values = array_values($arr);
		Yii::app()->user->setState("sub", end($values));

		$arr = (array)$this->SSOinitials;
		$values = array_values($arr);
		Yii::app()->user->setState("SSOinitials", end($values));

		$arr = (array)$this->SSOfirstname;
		$values = array_values($arr);
		Yii::app()->user->setState("SSOfirstname", end($values));

		$arr = (array)$this->SSOsurname;
		$values = array_values($arr);
		Yii::app()->user->setState("SSOsurname", end($values));

		$arr = (array)$this->SSOworkingdepdescription;
		$values = array_values($arr);
		Yii::app()->user->setState("SSOworkingdepdescription", end($values));

		$arr = (array)$this->SSOpersonclass;
		$values = array_values($arr);
		Yii::app()->user->setState("SSOpersonclass", end($values));
	
		$arr = (array)$this->SSOpersonposition;
		$values = array_values($arr);
		Yii::app()->user->setState("SSOpersonposition", end($values));
	
		$arr = (array)$this->SSObranchCode;
		$values = array_values($arr);
		Yii::app()->user->setState("SSObranchCode", end($values));
		
		Yii::app()->user->setState("idtoken", $this->idtoken);
	}
	
    public function init() {
        //parent::init();
    }		
	
}