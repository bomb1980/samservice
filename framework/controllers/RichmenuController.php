<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

use \app\models\RichmenuAction;
use \app\models\CommonAction;

use app\components\CustomWebUser;
use app\components\UserController;

class RichmenuController extends Controller
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

		//Yii::log('Error Test by niras: ' ,CLogger::LEVEL_ERROR,'system.db.CDbCommand');
		/*
		$data = \app\models\lkup_data::getContentGroup(4);
		$catid = array();
		foreach ($data as $dataitem) {
			$catid[]  =  $dataitem["id"];
		}
		$modelform = \app\models\lkup_content::getContentListMain($catid);

		$data = \app\models\lkup_data::getContentGroup(28);
		$catid = array();
		foreach ($data as $dataitem) {
			$catid[]  =  $dataitem["id"];
		}
		$modelform_ = \app\models\lkup_content::getContentListMain($catid);

		$this->render('index', array("id" => 5, "modelform" => $modelform, "modelform_" => $modelform_));
		*/

		//*********************************************************
		$this->render('index');
	}

	public function actionList()
	{
		$cwebuser = new CustomWebUser();
		$user_id = Yii::$app->user->getId();
		$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['cms'];

		$data = \app\models\lkup_user::getUserPermission($user_id, $app_id);
		$user_role = $data[0]["user_role"];
		Yii::$app->controller->layout = "main";
		return $this->render('listdata', array("user_role" => $user_role, "user_id" => $user_id,));
	}

	public function actionListmenumap()
	{
		$cwebuser = new CustomWebUser();
		$user_id = Yii::$app->user->getId();
		$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['cms'];

		$data = \app\models\lkup_user::getUserPermission($user_id, $app_id);
		$user_role = $data[0]["user_role"];
		Yii::$app->controller->layout = "main";
		return $this->render('listmenumap', array("user_role" => $user_role, "user_id" => $user_id,));
	}


	public function actionDelete_mappingrichmenu()
	{
		if (Yii::$app->request->isPost) {
			$content_id = $_POST['content_id'];
			if (is_null($content_id)) {
				exit;
			}

			$cwebuser = new CustomWebUser();
			$user_id = Yii::$app->user->getId();
			$ssobranch_code = $cwebuser->getInfo("ssobranch_code");
			$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['cms'];

			$data = \app\models\lkup_user::getUserPermission($user_id, $app_id, $ssobranch_code);
			$user_role = $data[0]["user_role"];


			if (\app\models\lkup_data::chkAddPermission($user_role, $app_id)) {

				$sql = "SELECT * FROM trn_richmenu_custom_view WHERE id=:id ";
				$conn = Yii::$app->db;
				$rows = $conn->createCommand($sql)->bindValue('id', $content_id)->queryAll();
				if (count($rows) == 0) {
					echo json_encode(array('msg' => "ไม่พบไอดีชุดข้อมูลที่ต้องการลบ"));
					exit;
				}

				$items = (array) $rows[0];
			} else {
				echo json_encode(array('msg' => "เจ้าหน้าที่ไม่สามารถลบข้อมูลได้"));
				exit;
			}


			$model = new RichmenuAction;
			$model->id = $content_id;
			$model->menu_id = $items['menu_id'];

			if ($model->Delete_viewrichmenu()) {

				$log_page = basename('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
				$log_page = basename(Yii::$app->request->referrer);

				$log_description = 'ลบ Custom Rich menu <br/>';
				$log_description .= 'Menu ID : ' . $items['menu_id'] . ' <br/>';
				$log_description .= 'Custom Menu ID : ' . $content_id . ' <br/>';

				$cwebuser = new \app\components\CustomWebUser();
				$createby = !Yii::$app->user->isGuest ? $cwebuser->getInfo('uid') : 0;
				\app\models\CommonAction::AddEventLog($createby, "Delete", $log_page, $log_description);

				echo json_encode(array('msg' => 'success'));
			} else {
				$log_page = basename('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
				$log_page = basename(Yii::$app->request->referrer);

				$log_description = 'ลบ Custom Rich menu <br/>';
				$log_description .= 'Menu ID : ' . $items['menu_id'] . ' <br/>';
				$log_description .= 'Custom Menu ID : ' . $content_id . ' <br/>';
				$log_description .= "ไม่สำเร็จสถานะ " . Yii::$app->session['errmsg_richmenu'];

				$cwebuser = new \app\components\CustomWebUser();
				$createby = !Yii::$app->user->isGuest ? $cwebuser->getInfo('uid') : 0;
				\app\models\CommonAction::AddEventLog($createby, "Delete", $log_page, $log_description);

				$msg = Yii::$app->session['errmsg_richmenu'];
				echo json_encode(array('msg' => $msg));
				Yii::$app->session->remove('errmsg_richmenu');
			}
		}
	}

	public function actionListback()
	{
		$page = 1;
		if (!empty($_POST['page'])) $page = (int) $_POST['page'];

		$recordsPerPage = 10;
		if (!empty($_POST['length'])) $recordsPerPage = (int) $_POST['length'];

		$start = 0;
		if (!empty($_POST['start'])) $start = (int) $_POST['start'];

		$search = '';
		if (!empty($_POST['search'])) $search = $_POST['search'];

		$type_id = null;
		if (!empty($_POST['type_id'])) $type_id = $_POST['type_id'];

		$noOfRecords = 0;


		$model = new RichmenuAction();
		$model->search = $search;
		$model->page = $page;
		$model->recordsPerPage = $recordsPerPage;
		$model->start = $start;
		$model->noOfRecords = $noOfRecords;



		$model->pAdmin = true;
		$model->Listback();
	}

	public function actionListmenumapback()
	{
		$page = 1;
		if (!empty($_POST['page'])) $page = (int) $_POST['page'];

		$recordsPerPage = 10;
		if (!empty($_POST['length'])) $recordsPerPage = (int) $_POST['length'];

		$start = 0;
		if (!empty($_POST['start'])) $start = (int) $_POST['start'];

		$search = '';
		if (!empty($_POST['search'])) $search = $_POST['search'];

		$type_id = null;
		if (!empty($_POST['type_id'])) $type_id = $_POST['type_id'];

		$noOfRecords = 0;


		$model = new RichmenuAction();
		$model->search = $search;
		$model->page = $page;
		$model->recordsPerPage = $recordsPerPage;
		$model->start = $start;
		$model->noOfRecords = $noOfRecords;

		$model->pAdmin = true;
		$model->Listmenumapback();
	}

	//ลิสต์รายการใน popup
	public function actionListselect()
	{
		$page = 1;
		if (!empty($_POST['page'])) $page = (int) $_POST['page'];

		$recordsPerPage = 10;
		if (!empty($_POST['length'])) $recordsPerPage = (int) $_POST['length'];

		$start = 0;
		if (!empty($_POST['start'])) $start = (int) $_POST['start'];

		$search = '';
		if (!empty($_POST['search'])) $search = $_POST['search'];

		$type_id = null;
		if (!empty($_POST['type_id'])) $type_id = $_POST['type_id'];

		$noOfRecords = 0;


		$model = new RichmenuAction;
		$model->search = $search;
		$model->page = $page;
		$model->recordsPerPage = $recordsPerPage;
		$model->start = $start;
		$model->noOfRecords = $noOfRecords;



		$model->pAdmin = true;
		$model->Listselect();
	}

	public function actionCreate()
	{
		return $this->render('create');
	}

	public function actionSetview()
	{

		if (!empty($_GET["id"])) {
			$id = $_GET["id"];

			if (is_numeric($id)) {
				$cwebuser = new CustomWebUser();
				$user_id = Yii::$app->user->getId();
				$ssobranch_code = $cwebuser->getInfo("ssobranch_code");

				$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['cms'];

				$data_role = \app\models\lkup_user::getUserPermission($user_id, $app_id, $ssobranch_code);
				$user_role = $data_role[0]["user_role"];

				$isAddmin = \app\models\lkup_data::chkAddPermission($user_role, $app_id);

				if ($isAddmin) {
					$conn = Yii::$app->db;
					$sql = "SELECT * FROM trn_richmenu_custom_view WHERE id=:id ";
					$command = $conn->createCommand($sql);
					$command->bindValue(":id", $id);
					$rows = $command->queryAll();


					return $this->render('setview', array('data' => $rows, "user_role" => $user_role, "user_id" => $user_id, 'id' => $id));
				} else {
					if (Yii::$app->request->referrer) {
						$redirect = Yii::$app->request->referrer;
					} else {
						$redirect = Yii::$app->createUrl('');
					}
?>
					<script>
						alert("เจ้าหน้าที่ไม่สามารถแก้ไขข้อมูลได้");
						window.location.href = "<?= $redirect ?>";
					</script>
				<?php
					exit;
					//return $this->redirect(Yii::$app->request->referrer);
				}
			}
		} else {
			$cwebuser = new CustomWebUser();
			$user_id = Yii::$app->user->getId();
			$ssobranch_code = $cwebuser->getInfo("ssobranch_code");
			$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['cms'];

			$data_role = \app\models\lkup_user::getUserPermission($user_id, $app_id, $ssobranch_code);
			$user_role = $data_role[0]["user_role"];

			$isAddmin = \app\models\lkup_data::chkAddPermission($user_role, $app_id);

			if ($isAddmin) {
				return $this->render('setview', array('data' => null, "user_role" => $user_role, "user_id" => $user_id,));
			}
		}
	}
	public function actionView()
	{

		if (!empty($_GET["id"])) {
			$id = $_GET["id"];

			if (is_numeric($id)) {
				$cwebuser = new CustomWebUser();
				$user_id = Yii::$app->user->getId();
				$ssobranch_code = $cwebuser->getInfo("ssobranch_code");
				$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['cms'];

				$data_role = \app\models\lkup_user::getUserPermission($user_id, $app_id, $ssobranch_code);
				$user_role = $data_role[0]["user_role"];

				$isAddmin = \app\models\lkup_data::chkAddPermission($user_role, $app_id);

				if ($isAddmin) {
					$conn = Yii::$app->db;
					$sql = "SELECT * FROM trn_richmenu WHERE id=:id ";
					$command = $conn->createCommand($sql);
					$command->bindValue(":id", $id);
					$rows = $command->queryAll();

					return $this->render('view', array('data' => $rows, 'id' => $id));
				} else {
					if (Yii::$app->request->referrer) {
						$redirect = Yii::$app->request->referrer;
					} else {
						$redirect = Yii::$app->createUrl('');
					}
				?>
					<script>
						alert("เจ้าหน้าที่ไม่สามารถแก้ไขข้อมูลได้");
						window.location.href = "<?= $redirect ?>";
					</script>
<?php
					exit;
					//return $this->redirect(Yii::$app->request->referrer);
				}
			}
		}
	}

	function isJSON($string)
	{
		return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
	}

	public function actionSavemenu()
	{

		if (Yii::$app->request->isPost) {

			//ini_set('memory_limit', '8192M'); 

			$menu_name = $_POST['menu_name'];
			$menu_json = $_POST['menu_json'];
			if (!$this->isJSON($menu_json)) {
				echo json_encode(array('status' => 'error', 'msg' => "รูปแบบ JSON ไม่ถูกต้อง",));
				exit;
			}
			$image_base64 = base64_encode(file_get_contents($_FILES['menuimg']['tmp_name']));

			$model = new RichmenuAction;
			$model->menu_name = $menu_name;
			$model->menu_json = $menu_json;
			$model->image_base64 = $image_base64;

			if ($model->savemenu()) {

				$child = new RichmenuAction;
				$child->menu_name = $menu_name;
				$child->menu_json = $menu_json;
				$child->image_base64 = $image_base64;
				$child->setDefault = FALSE;

				$conn = Yii::$app->db;

				if ($child->pushmenuraw()) {

					$createby = !Yii::$app->user->isGuest ? Yii::$app->user->id : 0;
					$richmenuid = Yii::$app->session['success_pushrichmenu'];

					$sql = "UPDATE trn_richmenu SET menuid=:menuid, push_status=1, push_by=$createby, push_date=NOW() WHERE id=:id ";
					$command = $conn->createCommand($sql);
					$command->bindValue(":menuid", $richmenuid);
					$command->bindValue(":id", Yii::$app->session['success_richmenu_id']);
					$command->execute();

					$log_page = basename('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
					$log_page = basename(Yii::$app->request->referrer);

					$log_description = 'PUSH LINE Rich menu first create <br/>';
					$log_description .= 'Menu ID : ' . Yii::$app->session['success_richmenu_id'];
					$log_description .= "สำเร็จ ";

					$cwebuser = new \app\components\CustomWebUser();
					$createby = !Yii::$app->user->isGuest ? $cwebuser->getInfo('uid') : 0;
					\app\models\CommonAction::AddEventLog($createby, "Insert", $log_page, $log_description);
				} else {
					$log_page = basename('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
					$log_page = basename(Yii::$app->request->referrer);

					$log_description = 'PUSH LINE Rich menu first create <br/>';
					$log_description .= 'Menu ID : ' . Yii::$app->session['success_richmenu_id']  . ' <br/>';
					$log_description .= "ไม่สำเร็จสถานะ " . Yii::$app->session['errmsg_pushrichmenu'];

					$cwebuser = new \app\components\CustomWebUser();
					$createby = !Yii::$app->user->isGuest ? $cwebuser->getInfo('uid') : 0;
					\app\models\CommonAction::AddEventLog($createby, "Insert", $log_page, $log_description);
				}

				$log_page = basename(Yii::$app->request->referrer);

				$log_description = 'เพิ่ม LINE Rich menu <br/>';
				$log_description .= 'Menu ID : ' . Yii::$app->session['success_richmenu_id'] . '<br/>';
				$log_description .= 'หัวข้อ : ' . strip_tags($_POST['menu_name']) . ' <br/>';

				$cwebuser = new \app\components\CustomWebUser();
				$createby = !Yii::$app->user->isGuest ? $cwebuser->getInfo('uid') : 0;
				\app\models\CommonAction::AddEventLog($createby, "Insert", $log_page, $log_description);

				echo json_encode(array('status' => 'success', 'msg' => Yii::$app->session['success_richmenu'],));
				Yii::$app->session->remove('success_richmenu');
				Yii::$app->session->remove('success_richmenu_id');
			} else {
				echo json_encode(array('status' => 'error', 'msg' => Yii::$app->session['errmsg_richmenu'],));
				Yii::$app->session->remove('errmsg_richmenu');
			}
		}
	}

	public function actionEditmenu()
	{
		if (Yii::$app->request->isPost) {
			$id = $_POST['id'];
			$menu_name = $_POST['menu_name'];
			$menu_json = $_POST['menu_json'];

			$menu_json = ltrim($menu_json);
			$menu_json = rtrim($menu_json);

			if (!$this->isJSON($menu_json)) {
				echo json_encode(array('status' => 'error', 'msg' => "รูปแบบ JSON ไม่ถูกต้อง",));
				exit;
			}

			if (empty($_FILES["menuimg"]["name"])) {
				$image_base64 = null;
			} else {
				$image_base64 = base64_encode(file_get_contents($_FILES['menuimg']['tmp_name']));
			}

			$model = new RichmenuAction;
			$model->id = $id;
			$model->menu_name = $menu_name;
			$model->menu_json = $menu_json;
			$model->image_base64 = $image_base64;

			if ($model->editmenu()) {

				if ($_POST['hdsetdefault'] == 0) {
					$setDefault = FALSE;
				} else {
					$setDefault = TRUE;
				}

				$conn = Yii::$app->db;

				$sql = "SELECT * FROM trn_richmenu WHERE id=:id ";
				$rows = $conn->createCommand($sql)->bindValue('id', $id)->queryAll();
				if (count($rows) != 0) {
					$items = (array) $rows[0];
					//var_dump($items['push_status']);exit;
					if (!is_null($items['menuid']) || !empty($items['menuid'])) {
						$model->richmenuid = $items['menuid'];
						$model->deletemenu();
					}
					$image_base64 = $items['img'];
					if ($items['push_status'] == 1) {
						$this->Pushmenu($id, $setDefault, $menu_json, $image_base64);
					}
				}

				$log_page = basename(Yii::$app->request->referrer);

				$log_description = 'แก้ไข LINE Rich menu <br/>';
				$log_description .= 'Menu ID : ' . Yii::$app->session['success_richmenu_id'] . '<br/>';
				$log_description .= 'หัวข้อ : ' . strip_tags($_POST['menu_name']) . ' <br/>';

				$cwebuser = new \app\components\CustomWebUser();
				$createby = !Yii::$app->user->isGuest ? $cwebuser->getInfo('uid') : 0;

				\app\models\CommonAction::AddEventLog($createby, "Update", $log_page, $log_description);

				echo json_encode(array('status' => 'success', 'msg' => Yii::$app->session['success_richmenu'],));
				Yii::$app->session->remove('success_richmenu');
				Yii::$app->session->remove('success_richmenu_id');
			} else {
				echo json_encode(array('status' => 'error', 'msg' => Yii::$app->session['errmsg_richmenu'],));
				Yii::$app->session->remove('errmsg_richmenu');
			}
		}
	}


	public function actionDelete_richmenu()
	{
		if (Yii::$app->request->isPost) {
			$content_id = $_POST['content_id'];
			if (is_null($content_id)) {
				exit;
			}

			$cwebuser = new CustomWebUser();
			$user_id = Yii::$app->user->getId();
			$ssobranch_code = $cwebuser->getInfo("ssobranch_code");
			$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['cms'];

			$data = \app\models\lkup_user::getUserPermission($user_id, $app_id, $ssobranch_code);
			$user_role = $data[0]["user_role"];


			if (\app\models\lkup_data::chkAddPermission($user_role, $app_id)) {

				$sql = "SELECT * FROM trn_richmenu WHERE id=:id ";
				$conn = Yii::$app->db;
				$rows = $conn->createCommand($sql)->bindValue('id', $content_id)->queryAll();

				$items = (array) $rows[0];
			} else {
				echo json_encode(array('msg' => "เจ้าหน้าที่ไม่สามารถลบข้อมูลได้"));
				exit;
			}


			$model = new RichmenuAction;
			$model->id = $content_id;

			if ($model->Delete_richmenu()) {

				if (!is_null($items['menuid']) || !empty($items['menuid'])) {
					$model->richmenuid = $items['menuid'];
					$model->deletemenu();
				}

				$log_page = basename('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
				$log_page = basename(Yii::$app->request->referrer);

				$log_description = 'ลบ LINE Rich menu <br/>';
				$log_description .= 'Menu ID : ' . $content_id . ' <br/>';

				$cwebuser = new \app\components\CustomWebUser();
				$createby = !Yii::$app->user->isGuest ? $cwebuser->getInfo('uid') : 0;
				\app\models\CommonAction::AddEventLog($createby, "Delete", $log_page, $log_description);

				echo json_encode(array('msg' => 'success'));
			} else {
				$log_page = basename('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
				$log_page = basename(Yii::$app->request->referrer);

				$log_description = 'ลบ LINE Rich menu <br/>';
				$log_description .= 'Menu ID : ' . $content_id  . ' <br/>';
				$log_description .= "ไม่สำเร็จสถานะ " . Yii::$app->session['errmsg_richmenu'];

				$cwebuser = new \app\components\CustomWebUser();
				$createby = !Yii::$app->user->isGuest ? $cwebuser->getInfo('uid') : 0;
				\app\models\CommonAction::AddEventLog($createby, "Delete", $log_page, $log_description);

				$msg = Yii::$app->session['errmsg_richmenu'];
				echo json_encode(array('msg' => $msg));
				Yii::$app->session->remove('errmsg_richmenu');
			}
		}
	}

	public function actionGetrichmenu()
	{
		$model = new RichmenuAction();
		//echo $model->getrichmenu();
		ob_start();
		$model->getrichmenu();
		return ob_get_clean();
	}

	public function actionUnpushmenu()
	{
		if (Yii::$app->request->isPost) {

			$menuid = $_POST['id'];
			if (is_null($menuid)) {
				exit;
			}
			$conn = Yii::$app->db;
			$sql = "SELECT * FROM trn_richmenu WHERE id=:id ";
			$rows = $conn->createCommand($sql)->bindValue('id', $menuid)->queryAll();

			if (count($rows) != 0) {
				$items = (array) $rows[0];
				if (!is_null($items['menuid']) || !empty($items['menuid'])) {
					$model = new RichmenuAction();
					$model->richmenuid = $items['menuid'];
					if ($model->deletemenu()) {

						$createby = !Yii::$app->user->isGuest ? Yii::$app->user->id : 0;
						$sql = "UPDATE trn_richmenu SET menuid=:menuid, push_status=0, push_by=$createby, push_date=NOW(), setdefault=0 WHERE id=:id ";
						$command = $conn->createCommand($sql);
						$command->bindValue(":menuid", null);
						$command->bindValue(":id", $menuid);
						$command->execute();

						$log_page = basename('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
						$log_page = basename(Yii::$app->request->referrer);

						$log_description = 'Remove LINE Rich menu <br/>';
						$log_description .= 'Menu ID : ' . $menuid . ' <br/>';
						$log_description .= 'Rich menu ID : ' . $items['menuid'] . ' <br/>';

						$cwebuser = new \app\components\CustomWebUser();
						$createby = !Yii::$app->user->isGuest ? $cwebuser->getInfo('uid') : 0;

						\app\models\CommonAction::AddEventLog($createby, "Remove", $log_page, $log_description);

						echo json_encode(array('msg' => 'success'));
					} else {

						$createby = !Yii::$app->user->isGuest ? Yii::$app->user->id : 0;
						$sql = "UPDATE trn_richmenu SET menuid=:menuid, push_status=0, push_by=$createby, push_date=NOW() WHERE id=:id ";
						$command = $conn->createCommand($sql);
						$command->bindValue(":menuid", null);
						$command->bindValue(":id", $menuid);
						$command->execute();

						$log_page = basename('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
						$log_page = basename(Yii::$app->request->referrer);

						$log_description = 'Remove LINE Rich menu <br/>';
						$log_description .= 'Menu ID : ' . $menuid . ' <br/>';
						$log_description .= 'Rich menu ID : ' . $items['menuid'] . ' <br/>';
						$log_description .= 'ค่ารีเทิร์น : ' . Yii::$app->session['error_unpushmenu'] . ' <br/>';

						$cwebuser = new \app\components\CustomWebUser();
						$createby = !Yii::$app->user->isGuest ? $cwebuser->getInfo('uid') : 0;

						\app\models\CommonAction::AddEventLog($createby, "Remove", $log_page, $log_description);


						$msg = "ลบเมนูไลน์ออกจากระบบแล้ว ค่ารีเทิร์นคือ " . Yii::$app->session['error_unpushmenu'];
						Yii::$app->session->remove('error_unpushmenu');
						echo json_encode(array('msg' => $msg));
					}
				}
			}

			//$model = new RichmenuAction();
			//$model->richmenuid = "richmenu-a2ab37a7b605bedc4b1be237b957b9c9";
			//echo $model->deletemenu();
		}
	}

	public function actionDeletemenu()
	{
		$model = new RichmenuAction();
		$model->richmenuid = "richmenu-d44c00d999e274fc7634c4e07388bd7c";
		echo $model->deletemenu();

		if (Yii::$app->request->isPost) {

			$richmenuid = $_POST['richmenuid'];
			if (is_null($richmenuid)) {
				exit;
			}

			$model = new RichmenuAction();
			$model->richmenuid = "richmenu-a2ab37a7b605bedc4b1be237b957b9c9";
			echo $model->deletemenu();
		}
	}

	public function actionPushmenu()
	{
		if (Yii::$app->request->isPost) {

			$content_id = $_POST['id'];
			if (is_null($content_id)) {
				exit;
			}

			$sql = "SELECT * FROM trn_richmenu WHERE id=:id ";
			$conn = Yii::$app->db;
			$rows = $conn->createCommand($sql)->bindValue('id', $content_id)->queryAll();
			if (count($rows) != 0) {
				$items = (array) $rows[0];
				if (!is_null($items['menuid']) || !empty($items['menuid'])) {
					echo "เมนูนี้มีการเพิ่มเข้าระบบก่อนหน้านี้แล้ว";
					exit;
				}

				$menu_json = ltrim($items['menudata']);
				$menu_json = rtrim($menu_json);
				$image_base64 = $items['img'];

				$result = $this->Pushmenu($content_id, false, $menu_json, $image_base64);
				if ($result) {
					echo json_encode(array('msg' => 'success'));
				} else {
					$msg = "เพิ่มเมนูในไลน์ไม่สำเร็จกรุณาลองอีกครั้ง";
					echo json_encode(array('msg' => $msg));
				}
			}
		}
	}


	public function actionSetdefaultmenu()
	{
		if (Yii::$app->request->isPost) {

			$content_id = $_POST['id'];
			if (is_null($content_id)) {
				exit;
			}

			$sql = "SELECT * FROM trn_richmenu WHERE id=:id ";
			$conn = Yii::$app->db;
			$rows = $conn->createCommand($sql)->bindValue('id', $content_id)->queryAll();
			if (count($rows) != 0) {
				$items = (array) $rows[0];
				if ($items['setdefault'] == 1) {
					echo "เมนูนี้มีการเพิ่มเป็นค่าเริ่มต้นแล้ว";
					exit;
				}

				if (!is_null($items['menuid']) || !empty($items['menuid'])) {
					$model = new RichmenuAction();
					$model->richmenuid = $items['menuid'];
					if ($model->setdefaultmenu()) {
						$createby = !Yii::$app->user->isGuest ? Yii::$app->user->id : 0;

						$sql = "UPDATE trn_richmenu SET setdefault=0, setdefault_by=$createby, setdefault_date=NOW() WHERE id != :id ";
						$command = $conn->createCommand($sql);
						$command->bindValue(":id", $content_id);
						$command->execute();

						$sql = "UPDATE trn_richmenu SET setdefault=1, setdefault_by=$createby, setdefault_date=NOW() WHERE id=:id ";
						$command = $conn->createCommand($sql);
						$command->bindValue(":id", $content_id);
						$command->execute();

						$log_page = basename('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
						$log_page = basename(Yii::$app->request->referrer);

						$log_description = 'Set Default LINE Rich menu <br/>';
						$log_description .= 'Menu ID : ' . $content_id . ' <br/>';
						$log_description .= 'Rich menu ID : ' . $items['menuid'] . ' <br/>';
						$log_description .= 'สำเร็จ';

						$cwebuser = new \app\components\CustomWebUser();
						$createby = !Yii::$app->user->isGuest ? $cwebuser->getInfo('uid') : 0;
						\app\models\CommonAction::AddEventLog($createby, "Update", $log_page, $log_description);

						echo json_encode(array('msg' => 'success'));
					} else {

						$log_page = basename('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
						$log_page = basename(Yii::$app->request->referrer);

						$log_description = 'Set Default LINE Rich menu <br/>';
						$log_description .= 'Menu ID : ' . $content_id . ' <br/>';
						$log_description .= 'Rich menu ID : ' . $items['menuid'] . ' <br/>';
						$log_description .= 'ไม่สำเร็จค่ารีเทิร์น : ' . Yii::$app->session['error_setdefaultmenu'] . ' <br/>';

						$cwebuser = new \app\components\CustomWebUser();
						$createby = !Yii::$app->user->isGuest ? $cwebuser->getInfo('uid') : 0;
						\app\models\CommonAction::AddEventLog($createby, "Update", $log_page, $log_description);

						$msg = "ตั้งค่าไม่สำเร็จ ค่ารีเทิร์นคือ " . Yii::$app->session['error_setdefaultmenu'];
						Yii::$app->session->remove('error_setdefaultmenu');
						echo json_encode(array('msg' => $msg));
					}
				}
			}
		}
	}



	private function Pushmenu($id, $setDefault = false, $menu_json, $image_base64)
	{

		$model = new RichmenuAction();
		$model->setDefault = $setDefault;
		$model->menu_json = $menu_json;
		$model->image_base64 = $image_base64;

		$conn = Yii::$app->db;

		if ($model->pushmenuraw()) {

			$createby = !Yii::$app->user->isGuest ? Yii::$app->user->id : 0;
			$richmenuid = Yii::$app->session['success_pushrichmenu'];

			$sql = "UPDATE trn_richmenu SET menuid=:menuid, push_status=1, push_by=$createby, push_date=NOW() WHERE id=:id ";
			$command = $conn->createCommand($sql);
			$command->bindValue(":menuid", $richmenuid);
			$command->bindValue(":id", $id);
			$command->execute();

			$log_page = basename('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
			$log_page = basename(Yii::$app->request->referrer);

			$log_description = 'PUSH LINE Rich menu with update <br/>';
			$log_description .= 'Menu ID : ' . $id . ' <br/>';
			$log_description .= "สำเร็จ";

			$cwebuser = new \app\components\CustomWebUser();
			$createby = !Yii::$app->user->isGuest ? $cwebuser->getInfo('uid') : 0;

			\app\models\CommonAction::AddEventLog($createby, "Update", $log_page, $log_description);
			return true;
		} else {
			$createby = !Yii::$app->user->isGuest ? Yii::$app->user->id : 0;
			$sql = "UPDATE trn_richmenu SET menuid=:menuid, push_status=0, push_by=$createby, push_date=NOW() WHERE id=:id ";
			$command = $conn->createCommand($sql);
			$command->bindValue(":menuid", null);
			$command->bindValue(":id", $id);
			$command->execute();

			//return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);

			$log_page = basename('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
			$log_page = basename(Yii::$app->request->referrer);

			$log_description = 'PUSH LINE Rich menu with update <br/>';
			$log_description .= 'Menu ID : ' . $id . ' <br/>';
			$log_description .= "ไม่สำเร็จสถานะ " . Yii::$app->session['errmsg_pushrichmenu'];

			$cwebuser = new \app\components\CustomWebUser();
			$createby = !Yii::$app->user->isGuest ? $cwebuser->getInfo('uid') : 0;

			\app\models\CommonAction::AddEventLog($createby, "Update", $log_page, $log_description);
			return false;
		}
	}

	public function actionSetviewmenu()
	{

		if (Yii::$app->request->isPost) {

			$menu_id = $_POST['menu_id'];
			$section = $_POST['section'];
			$perselect = $_POST['perselect'];

			if ($perselect == "") {
				$perselect = null;
			}

			$model = new RichmenuAction;
			$model->section = implode(",", $section);
			$model->perselect = $perselect;
			$model->id = $menu_id;

			if ($model->save_Setviewmenu()) {

				$log_page = basename(Yii::$app->request->referrer);

				$log_description = 'เพิ่มสิทธิ์การแสดงเมนูของแต่ละบุคคล <br/>';
				$log_description .= 'สำหรับเมนูไอดี : ' . $_POST['menu_id'] . '<br/>';
				$log_description .= 'ประกันสังคมมาตรา : ' . strip_tags(implode(",", $section)) . ' <br/>';
				$log_description .= 'หน่วยงาน : ' . strip_tags($_POST['perselect']) . ' <br/>';

				$cwebuser = new \app\components\CustomWebUser();
				$createby = !Yii::$app->user->isGuest ? $cwebuser->getInfo('uid') : 0;
				\app\models\CommonAction::AddEventLog($createby, "Insert", $log_page, $log_description);

				echo json_encode(array('status' => 'success', 'msg' => Yii::$app->session['success_setviewmenu'],));
				Yii::$app->session->remove('success_setviewmenu');
				Yii::$app->session->remove('success_setviewmenu_id');
			} else {
				echo json_encode(array('status' => 'error', 'msg' => Yii::$app->session['errmsg_setviewmenu'],));
				Yii::$app->session->remove('errmsg_setviewmenu');
			}
		}
	}

	public function actionEditviewmenu()
	{

		if (Yii::$app->request->isPost) {

			$id = $_POST['id'];
			$menu_id = $_POST['menu_id'];
			$section = $_POST['section'];
			$perselect = $_POST['perselect'];

			if ($perselect == "") {
				$perselect = null;
			}

			$model = new RichmenuAction;
			$model->section = implode(",", $section);
			$model->perselect = $perselect;
			$model->menu_id = $menu_id;
			$model->id = $id;

			if ($model->Edit_Setviewmenu()) {

				$log_page = basename(Yii::$app->request->referrer);

				$log_description = 'แก้ไขสิทธิ์การแสดงเมนูของแต่ละบุคคล <br/>';
				$log_description .= 'สำหรับเมนูไอดี : ' . $_POST['menu_id'] . '<br/>';
				$log_description .= 'ประกันสังคมมาตรา : ' . strip_tags(implode(",", $section)) . ' <br/>';
				$log_description .= 'หน่วยงาน : ' . strip_tags($_POST['perselect']) . ' <br/>';

				$cwebuser = new \app\components\CustomWebUser();
				$createby = !Yii::$app->user->isGuest ? $cwebuser->getInfo('uid') : 0;

				\app\models\CommonAction::AddEventLog($createby, "Insert", $log_page, $log_description);

				echo json_encode(array('status' => 'success', 'msg' => Yii::$app->session['success_setviewmenu'],));
				Yii::$app->session->remove('success_setviewmenu');
				Yii::$app->session->remove('success_setviewmenu_id');
			} else {
				echo json_encode(array('status' => 'error', 'msg' => Yii::$app->session['errmsg_setviewmenu'],));
				Yii::$app->session->remove('errmsg_setviewmenu');
			}
		}
	}

	public function actionEditstatustviewmenu()
	{
		if (Yii::$app->request->isPost) {
			$id = $_POST['id'];
			$status = $_POST['status'];
			if (is_null($id) || is_null($status)) {
				exit;
			}

			$model = new RichmenuAction;
			$model->id = $id;
			$model->status = $status;

			if ($model->Edit_viewrichmenustatus()) {

				$log_page = basename(Yii::$app->request->referrer);

				$log_description = 'แก้ไขสถานะ สิทธิ์การมองเห็น Line Richmenu <br/>';
				$log_description .= 'ID : ' . $_POST['id'] . '<br/>';
				$log_description .= 'จากสถานะ : ' . $_POST['old_status'] . ' <br/>';
				$log_description .= 'เป็น : ' . $status . ' <br/>';

				$cwebuser = new \app\components\CustomWebUser();
				$createby = !Yii::$app->user->isGuest ? $cwebuser->getInfo('uid') : 0;
				CommonAction::AddEventLog($createby, "Update", $log_page, $log_description);
				echo json_encode(array('msg' => 'success'));
			} else {
				$msg = Yii::app()->session['errmsg_viewrichmenustatus'];
				echo json_encode(array('msg' => $msg));
				Yii::app()->session->remove('errmsg_viewrichmenustatus');
			}
		}
	}

	public function actionSetrichmenu($sec = "")
	{
		if (!empty($_REQUEST['sec'])) $sec = $_REQUEST['sec'];
		if (is_null($sec) || empty($sec)) {
			exit;
		}
		$arrSec = [1,3,4];
		if (in_array($sec, $arrSec)) {

		}else{
			exit("ไม่มีมาตราที่ระบุ  1 3 หรือ 4");
		}
		//echo $section;exit;
		set_time_limit(0);
		// 1 ม33 3 ม39 4 ม40 
		//$section = [1];
		$section = [$sec]; //var_dump(implode(",",$section));exit;
		$branchcode = [
			1000, 1001, 1002, 1003, 1004, 1005, 1006, 1007, 1008, 1009, 1010, 1011, 1012, 1050, 1063, 1100, 1101, 1102, 1103, 1200, 1201, 1300, 1301, 1400, 1401, 1500, 1600, 1601, 1700, 1800, 1900, 1902, 2000, 2001, 2002, 2100, 2101, 2200, 2201, 2300, 2400, 2401, 2402, 2500, 2501, 2600, 2700, 2701, 3000, 3001, 3002, 3100, 3101, 3200, 3201, 3300, 3400, 3401, 3500, 3600, 3700, 3800, 3900, 4000, 4001, 4002, 4100, 4101, 4200, 4300, 4400, 4500, 4501, 4600, 4700, 4701, 4800, 4900, 5000, 5001, 5100, 5101, 5200, 5201, 5300, 5400, 5401, 5500, 5501, 5600, 5700, 5800, 6000, 6001, 6100, 6200, 6300, 6301, 6400, 6500, 6501, 6600, 6700, 6701, 7000, 7001, 7100, 7101, 7200, 7201, 7300, 7301, 7400, 7401, 7500, 7600, 7601, 7700, 7701, 8000, 8001, 8002, 8100, 8101, 8200, 8300, 8301, 8400, 8401, 8500, 8600, 9000, 9001, 9002, 9100, 9200, 9201, 9300, 9400, 9500, 9600, 1000, 1002, 1004
		];
		$this->actionSetrichmenutomultipleuser($section, $branchcode);
	}
	public function actionSetrichmenutomultipleuser($section = "", $branchcode = "")
	{
		//$username = null;
		set_time_limit(0);

		if (!empty($_REQUEST['section'])) $section = $_REQUEST['section'];
		if (is_null($section) || empty($section)) {
			exit;
		}
		//$password = null;
		if (!empty($_REQUEST['branchcode'])) $branchcode = $_REQUEST['branchcode'];
		if (is_null($branchcode) || empty($branchcode)) {
			exit;
		}


		$conn = Yii::$app->db;

		$sql = "
        SELECT menuid, trn_richmenu.id 
        FROM
        trn_richmenu
        INNER JOIN trn_richmenu_custom_view
            ON (
            `trn_richmenu`.`id` = `trn_richmenu_custom_view`.`menu_id`
            )
        WHERE section_type REGEXP :section_type AND ssobranch REGEXP :ssobranch AND trn_richmenu.status=1 and menuid is not null ORDER BY trn_richmenu_custom_view.create_date DESC limit 1;

        ";
		$command = $conn->createCommand($sql);
		$command->bindValue(":section_type",  "[" . implode(",", $section) . "]");
		$command->bindValue(":ssobranch", "[" . implode(",", $branchcode) . "]");
		$rs = $command->queryAll();

		if (count($rs) > 0) {

			$sql = "
			SELECT li_line_id
				FROM
			tran_ssoid
			INNER JOIN tran_line_id
				ON (
					tran_ssoid.id_sso = li_user_id
				)
			INNER JOIN tran_ssoid_state
				ON(
					tran_ssoid.id_sso = tran_ssoid_state.id_sso	
				)
				WHERE section_id IN(" . implode(",", $section) . ") AND ssobranch_code IN(" . implode(',', $branchcode) . ")
				AND (tran_ssoid_state.access_token != '' OR tran_ssoid_state.access_token IS NOT NULL) GROUP BY li_line_id;
			";

			//echo $sql;exit;
			$command = $conn->createCommand($sql);
			$rows = $command->queryAll();

			$arr = array();
			foreach ($rows as $dataitem) {
				if (strlen($dataitem['li_line_id']) > 32){
					$arr[] = $dataitem['li_line_id'];
				}				
			}

			$arrsplit = array_chunk($arr, 500, false);

			$menuid = $rs[0]['menuid'];

			foreach($arrsplit as $item) {
				//echo '<pre>'; print_r($item);
				
				
				$rich = new RichmenuAction;
				$rich->userid = $item;
				$rich->richmenuid = $menuid;
				$resrich =  $rich->linkrichmenutomultipleUser();

				if (!$resrich) {
					$log_page = basename('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
					$log_page = basename(Yii::$app->request->referrer);
	
					$log_description = 'Set richmenu to multiple <br/>';
					$log_description .= "ไม่สำเร็จสถานะ " . Yii::$app->session['error_LinkRichmenuToMultipleUser'];
	
					//\app\models\CommonAction::AddUserEventLog($item, "Insert", $log_page, $log_description);
					Yii::$app->session->remove('error_LinkRichmenuToMultipleUser');
					echo "ไม่สำเร็จ";
				} else {
					/*
					$conn = Yii::$app->db;
					$sql = "UPDATE tran_line_id SET currichmenu=:currichmenu WHERE li_user_id=:li_user_id";
	
					$command = $conn->createCommand($sql);
					$command->bindValue(":currichmenu", $rs[0]['id']);
					$command->bindValue(":li_user_id", $id_sso);
					$command->execute();
					*/
					echo "สำเร็จ";
				}
				

			}

			//print_r(array_chunk($arr, 500, false));

			exit;

			/*
            $menuid = $rs[0]['menuid'];
			$rich = new RichmenuAction;
			$rich->userid = $li_line_id;
			$rich->richmenuid = $menuid;
			$resrich =  $rich->linkrichmenutomultipleUser();
			*/
		}
	}
	public function actionError()
	{
		if ($error = Yii::$app->errorHandler->error) {
			if (Yii::$app->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
}
