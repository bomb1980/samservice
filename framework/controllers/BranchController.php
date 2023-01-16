<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

use app\components\CustomWebUser;

use app\components\UserController;
use app\models\AdminAction;

class BranchController extends Controller
{
	public $superadmin = false;


	public function init()
	{
		parent::init();
		if (Yii::$app->user->isGuest) {
			UserController::chkLogin();
			exit;
		}

		$cwebuser = new CustomWebUser();
		$user_id = Yii::$app->user->getId();
		$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['admin'];
		$rows = \app\models\lkup_user::getUserPermission($user_id, $app_id);
		$user_role = $rows[0]['user_role'];
		$this->superadmin = \app\models\lkup_data::chkAddPermission($user_role, $app_id);

		$this->layout = 'main';
	}

	public function actionIndex()
	{
		$branch_type = lkup_branch::getBranch_type();
		$this->render('listdata', array("branch_type" => $branch_type));
	}

	public function actionAddbranch()
	{

		$cwebuser = new CustomWebUser();
		$user_id = Yii::$app->user->getId();
		$ssobranch_code = $cwebuser->getInfo("ssobranch_code");
		$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['admin'];
		$rows = \app\models\lkup_user::getUserPermission($user_id, $app_id);
		$user_role = $rows[0]["user_role"];

		$isAddmin = \app\models\lkup_data::chkAddPermission($user_role, $app_id);

		if ($isAddmin) {
			$filecode =  \app\components\CommonFnc::genstring();
			$branch_type = \app\models\lkup_branch::getBranch_type();
			return $this->render('addbranch', array("filecode" => $filecode, "ssobranch_code" => $ssobranch_code, "user_role" => $user_role, "branch_type" => $branch_type, "isAddmin" => $isAddmin));
		} else {
			if (Yii::$app->request->referrer) {
				$redirect = Yii::$app->request->referrer;
			} else {
				$redirect = Yii::$app->urlManager->createUrl('');
			} ?>
			<script>
				alert("เจ้าหน้าที่ไม่สามารถเพิ่มข้อมูลได้");
				window.location.href = "<?= $redirect ?>";
			</script> <?php
					}
				}

				public function actionSavedata()
				{
					if ($_FILES['cover']["error"] != 0) {
						$model = new AdminAction;
						$model->cover = '';
						$model->filecode = $_POST["filecode"];
						$model->branchcode = isset($_POST['branchcode']) ? addslashes(trim($_POST['branchcode'])) : '';
						$model->name = isset($_POST['name']) ? addslashes(trim($_POST['name'])) : '';
						$model->shortname = isset($_POST['shortname']) ? addslashes(trim($_POST['shortname'])) : '';
						$model->ssobranch_type_id = isset($_POST['ssobranch_type_id']) ? addslashes(trim($_POST['ssobranch_type_id'])) : '';
						//$model->desc = isset($_POST['desc'])?addslashes(trim($_POST['desc'])):'';
						$model->desc = $_POST['desc'];

						$model->address = isset($_POST['address']) ? addslashes(trim($_POST['address'])) : '';
						$model->telno = isset($_POST['telno']) ? addslashes(trim($_POST['telno'])) : '';
						$model->location = isset($_POST['location']) ? addslashes(trim($_POST['location'])) : '';

						if ($model->save_insert()) {
							$log_page = basename(Yii::$app->request->referrer);
							//$log_page = basename('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);		
							$log_description = 'เพิ่มโปรไฟล์หน่วยงาน <br/>';
							$log_description .= 'รหัสหน่วยงาน : ' . $_POST["branchcode"] . '<br/>';
							$log_description .= 'ชื่อหน่วยงาน : ' . strip_tags($_POST['name']) . ' <br/>';
							$log_description .= 'ชื่อย่อหน่วยงาน : ' . strip_tags($_POST['shortname']) . ' <br/>';
							$log_description .= 'ประเภทหน่วยงาน : ' . strip_tags($_POST['ssobranch_type_id']) . ' <br/>';

							$log_description .= 'ที่อยู่ : ' . strip_tags($_POST['address']) . ' <br/>';
							$log_description .= 'หมายเลขติดต่อ : ' . strip_tags($_POST['telno']) . ' <br/>';
							$log_description .= 'ลิงค์แผนที่ : ' . strip_tags($_POST['location']) . ' <br/>';

							$cwebuser = new \app\components\CustomWebUser();
							$createby = !Yii::$app->user->isGuest ? $cwebuser->getInfo('uid') : 0;
							\app\models\CommonAction::AddEventLog($createby, "Insert", $log_page, $log_description);

							echo json_encode(array('status' => 'success', 'msg' => Yii::$app->session['success_content'],));
							Yii::$app->session->remove('success_content');
						} else {
							echo json_encode(array('status' => 'error', 'msg' => Yii::$app->session['errmsg_content'],));
							Yii::$app->session->remove('errmsg_content');
						}
					} else {
						$image = $_FILES['cover'];

						$model = new FroalaAction;
						$model->directoryName = Yii::$app->params['prg_ctrl']['path']['basepath'] . '/uploads/cover/';
						$model->urlupload = Yii::$app->params['prg_ctrl']['url']['baseurl'] . '/uploads/cover/';
						$model->allowedExts = array("gif", "jpeg", "jpg", "png");
						$model->allowedMimeTypes = array("image/gif", "image/jpeg", "image/pjpeg", "image/x-png", "image/png");
						$model->fieldname = "cover";
						$model->genfiename = true;

						if ($model->upload_file()) {
							$model = new AdminAction;
							$model->directoryName = Yii::$app->params['prg_ctrl']['path']['basepath'] . '/uploads/cover/';
							$obj = json_decode(Yii::$app->session['successmsg_upload'], true);
							$model->cover = $obj['name'];
							$model->filecode = $_POST["filecode"];
							$model->branchcode = isset($_POST['branchcode']) ? addslashes(trim($_POST['branchcode'])) : '';
							$model->name = isset($_POST['name']) ? addslashes(trim($_POST['name'])) : '';
							$model->shortname = isset($_POST['shortname']) ? addslashes(trim($_POST['shortname'])) : '';
							$model->ssobranch_type_id = isset($_POST['ssobranch_type_id']) ? addslashes(trim($_POST['ssobranch_type_id'])) : '';
							//$model->desc = isset($_POST['desc'])?addslashes(trim($_POST['desc'])):'';
							$model->desc = $_POST['desc'];

							$model->address = isset($_POST['address']) ? addslashes(trim($_POST['address'])) : '';
							$model->telno = isset($_POST['telno']) ? addslashes(trim($_POST['telno'])) : '';
							$model->location = isset($_POST['location']) ? addslashes(trim($_POST['location'])) : '';

							if ($model->save_insert()) {

								$log_page = basename(Yii::$app->request->referrer);	
								$log_description = 'เพิ่มโปรไฟล์หน่วยงาน <br/>';
								$log_description .= 'รหัสหน่วยงาน : ' . $_POST["branchcode"] . '<br/>';
								$log_description .= 'ชื่อหน่วยงาน : ' . strip_tags($_POST['name']) . ' <br/>';
								$log_description .= 'ชื่อย่อหน่วยงาน : ' . strip_tags($_POST['shortname']) . ' <br/>';
								$log_description .= 'ประเภทหน่วยงาน : ' . strip_tags($_POST['ssobranch_type_id']) . ' <br/>';

								$log_description .= 'ที่อยู่ : ' . strip_tags($_POST['address']) . ' <br/>';
								$log_description .= 'หมายเลขติดต่อ : ' . strip_tags($_POST['telno']) . ' <br/>';
								$log_description .= 'ลิงค์แผนที่ : ' . strip_tags($_POST['location']) . ' <br/>';

								$cwebuser = new \app\components\CustomWebUser();
								$createby = !Yii::$app->user->isGuest ? $cwebuser->getInfo('uid') : 0;
								\app\models\CommonAction::AddEventLog($createby, "Insert", $log_page, $log_description);

								echo json_encode(array('status' => 'success', 'msg' => Yii::$app->session['success_content'],));
								Yii::$app->session->remove('success_content');
							} else {
								echo json_encode(array('status' => 'error', 'msg' => Yii::$app->session['errmsg_content'],));
								Yii::$app->session->remove('errmsg_content');
							}
						} else {
							$msg = Yii::$app->session['errmsg_upload'];
							echo json_encode(array('msg' => $msg));
							Yii::$app->session->remove('errmsg_upload');
						}
					}
				}

				public function actionViewdata()
				{
					$id = "";
					if (!empty($_GET["id"])) {
						if (filter_var($_GET["id"], FILTER_VALIDATE_INT)) {
							$id = $_GET["id"];
						} else	$id = "";
					}
					if (is_numeric($id)) {
						$cwebuser = new CustomWebUser();
						$user_id = Yii::$app->user->getId();
						$ssobranch_code = $cwebuser->getInfo("ssobranch_code");

						$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['admin'];
						$rows = \app\models\lkup_user::getUserPermission($user_id, $app_id, $ssobranch_code);
						$user_role = $rows[0]["user_role"];

						$isAddmin = \app\models\lkup_data::chkAddPermission($user_role, $app_id);

						//echo lkup_content::getViewPermission($id,$user_id,$ssobranch_code); exit;
						//ตรวจสอบสิทธิ์การเข้าถึงแบบสาธารณะ
						if (\app\models\lkup_data::chkPermission($user_role, $app_id)) {
							$data = \app\models\lkup_data::getBranch_Description($id, true);
							if (count($data) == 0) {
								if (Yii::$app->request->referrer) {
									$redirect = Yii::$app->request->referrer;
								} else {
									$redirect = Yii::$app->urlManager->createUrl('');
								} ?>
					<script>
						alert("ไม่พบหน่วยงานที่จะเพิ่มเมนู");
						window.location.href = "<?= $redirect ?>";
					</script> <?php
								exit;
							}
							return $this->render('viewdata', array("id" => $id, "data" => $data, "ssobranch_code" => $ssobranch_code, "user_role" => $user_role, "isAddmin" => $isAddmin, "superadmin" => $this->superadmin));
						}
					}
				}

				public function actionEditdata()
				{
					$id = $_GET["id"];
					if (is_numeric($id)) {

						$cwebuser = new CustomWebUser();
						$user_id = Yii::$app->user->getId();
						$ssobranch_code = $cwebuser->getInfo("ssobranch_code");

						$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['admin'];
						$rows = \app\models\lkup_user::getUserPermission($user_id, $app_id, $ssobranch_code);
						$user_role = $rows[0]["user_role"];

						$isAddmin = \app\models\lkup_data::chkAddPermission($user_role, $app_id);

						if ($isAddmin) {
							$filecode =  \app\components\CommonFnc::genstring();
							$branch_type = \app\models\lkup_branch::getBranch_type();
							return $this->render('editbranch', array("id" => $id, "filecode" => $filecode, "ssobranch_code" => $ssobranch_code, "user_role" => $user_role, "branch_type" => $branch_type, "isAddmin" => $isAddmin, "superadmin" => $this->superadmin));
						} else {
							if (Yii::$app->request->referrer) {
								$redirect = Yii::$app->request->referrer;
							} else {
								$redirect = Yii::$app->urlManager->createUrl('');
							} ?>
				<script>
					alert("เจ้าหน้าที่ไม่สามารถแก้ไขข้อมูลได้");
					window.location.href = "<?= $redirect ?>";
				</script> <?php
							exit;
						}
					}
				}

				public function actionSaveedit()
				{

					$cwebuser = new CustomWebUser();
					$user_id = Yii::$app->user->getId();
					$ssobranch_code = $cwebuser->getInfo("ssobranch_code");
					$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['admin'];

					$data = \app\models\lkup_user::getUserPermission($user_id, $app_id, $ssobranch_code);
					$user_role = $data[0]["user_role"];

					$isAddmin = \app\models\lkup_data::chkAddPermission($user_role, $app_id);

					if (!$isAddmin) {
						echo json_encode(array('msg' => 'เจ้าหน้าที่ไม่สามารถแก้ไขข้อมูลได้'));
						exit;
					}

					if ($_FILES['cover']["error"] != 0) {
						$model = new AdminAction;
						$model->id = $_POST["id"];
						$model->cover = '';
						$model->filecode = $_POST["filecode"];
						$model->branchcode = isset($_POST['branchcode']) ? addslashes(trim($_POST['branchcode'])) : '';
						$model->name = isset($_POST['name']) ? addslashes(trim($_POST['name'])) : '';
						$model->shortname = isset($_POST['shortname']) ? addslashes(trim($_POST['shortname'])) : '';
						$model->ssobranch_type_id = isset($_POST['ssobranch_type_id']) ? addslashes(trim($_POST['ssobranch_type_id'])) : '';
						//$model->desc = isset($_POST['desc'])?addslashes(trim($_POST['desc'])):'';
						$model->desc = $_POST['desc'];

						$model->address = isset($_POST['address']) ? addslashes(trim($_POST['address'])) : '';
						$model->telno = isset($_POST['telno']) ? addslashes(trim($_POST['telno'])) : '';
						$model->location = isset($_POST['location']) ? addslashes(trim($_POST['location'])) : '';

						if ($model->save_edit()) {

							$log_page = basename(Yii::$app->request->referrer);
							//$log_page = basename('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);		
							$log_description = 'แก้ไขโปรไฟล์หน่วยงาน <br/>';
							$log_description .= 'โปรไฟล์ ID : ' . $_POST["id"] . '<br/>';
							$log_description .= 'รหัสหน่วยงาน : ' . $_POST["branchcode"] . '<br/>';
							$log_description .= 'ชื่อหน่วยงาน : ' . strip_tags($_POST['name']) . ' <br/>';
							$log_description .= 'ชื่อย่อหน่วยงาน : ' . strip_tags($_POST['shortname']) . ' <br/>';
							$log_description .= 'ประเภทหน่วยงาน : ' . strip_tags($_POST['ssobranch_type_id']) . ' <br/>';

							$log_description .= 'ที่อยู่ : ' . strip_tags($_POST['address']) . ' <br/>';
							$log_description .= 'หมายเลขติดต่อ : ' . strip_tags($_POST['telno']) . ' <br/>';
							$log_description .= 'ลิงค์แผนที่ : ' . strip_tags($_POST['location']) . ' <br/>';

							$cwebuser = new \app\components\CustomWebUser();
							$createby = !Yii::$app->user->isGuest ? $cwebuser->getInfo('uid') : 0;
							\app\models\CommonAction::AddEventLog($createby, "Update", $log_page, $log_description);

							echo json_encode(array('status' => 'success', 'msg' => Yii::$app->session['success_content'],));
							Yii::$app->session->remove('success_content');
						} else {
							echo json_encode(array('status' => 'error', 'msg' => Yii::$app->session['errmsg_content'],));
							Yii::$app->session->remove('errmsg_content');
						}
					} else {
						$image = $_FILES['cover'];

						$model = new FroalaAction;
						$model->directoryName = Yii::$app->params['prg_ctrl']['path']['basepath'] . '/uploads/cover/';
						$model->urlupload = Yii::$app->params['prg_ctrl']['url']['baseurl'] . '/uploads/cover/';
						$model->allowedExts = array("gif", "jpeg", "jpg", "png");
						$model->allowedMimeTypes = array("image/gif", "image/jpeg", "image/pjpeg", "image/x-png", "image/png");
						$model->fieldname = "cover";
						$model->genfiename = true;

						if ($model->upload_file()) {
							$model = new AdminAction;
							$model->directoryName = Yii::$app->params['prg_ctrl']['path']['basepath'] . '/uploads/cover/';
							$obj = json_decode(Yii::$app->session['successmsg_upload'], true);
							$model->id = $_POST["id"];
							$model->cover = $obj['name'];
							$model->filecode = $_POST["filecode"];
							$model->branchcode = isset($_POST['branchcode']) ? addslashes(trim($_POST['branchcode'])) : '';
							$model->name = isset($_POST['name']) ? addslashes(trim($_POST['name'])) : '';
							$model->shortname = isset($_POST['shortname']) ? addslashes(trim($_POST['shortname'])) : '';
							$model->ssobranch_type_id = isset($_POST['ssobranch_type_id']) ? addslashes(trim($_POST['ssobranch_type_id'])) : '';
							//$model->desc = isset($_POST['desc'])?addslashes(trim($_POST['desc'])):'';
							$model->desc = $_POST['desc'];

							$model->address = isset($_POST['address']) ? addslashes(trim($_POST['address'])) : '';
							$model->telno = isset($_POST['telno']) ? addslashes(trim($_POST['telno'])) : '';
							$model->location = isset($_POST['location']) ? addslashes(trim($_POST['location'])) : '';

							if ($model->save_edit()) {

								$log_page = basename(Yii::$app->request->referrer);
								//$log_page = basename('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);		
								$log_description = 'แก้ไขโปรไฟล์หน่วยงาน <br/>';
								$log_description .= 'โปรไฟล์ ID : ' . $_POST["id"] . '<br/>';
								$log_description .= 'รหัสหน่วยงาน : ' . $_POST["branchcode"] . '<br/>';
								$log_description .= 'ชื่อหน่วยงาน : ' . strip_tags($_POST['name']) . ' <br/>';
								$log_description .= 'ชื่อย่อหน่วยงาน : ' . strip_tags($_POST['shortname']) . ' <br/>';
								$log_description .= 'ประเภทหน่วยงาน : ' . strip_tags($_POST['ssobranch_type_id']) . ' <br/>';

								$log_description .= 'ที่อยู่ : ' . strip_tags($_POST['address']) . ' <br/>';
								$log_description .= 'หมายเลขติดต่อ : ' . strip_tags($_POST['telno']) . ' <br/>';
								$log_description .= 'ลิงค์แผนที่ : ' . strip_tags($_POST['location']) . ' <br/>';

								$cwebuser = new \app\components\CustomWebUser();
								$createby = !Yii::$app->user->isGuest ? $cwebuser->getInfo('uid') : 0;
								\app\models\CommonAction::AddEventLog($createby, "Update", $log_page, $log_description);

								echo json_encode(array('status' => 'success', 'msg' => Yii::$app->session['success_content'],));
								Yii::$app->session->remove('success_content');
							} else {
								echo json_encode(array('status' => 'error', 'msg' => Yii::$app->session['errmsg_content'],));
								Yii::$app->session->remove('errmsg_content');
							}
						} else {
							$msg = Yii::$app->session['errmsg_upload'];
							echo json_encode(array('msg' => $msg));
							Yii::$app->session->remove('errmsg_upload');
						}
					}
				}

				public function actionUpdateBranchStatus()
				{
					if (Yii::$app->request->isPostRequest) {
						$ssobranch_code = $_POST['ssobranch_code'];
						$status = $_POST['status'];
						if (is_null($ssobranch_code) || is_null($status)) {
							exit;
						}

						$model = new AdminAction;
						$model->ssobranch_code = $ssobranch_code;
						$model->status = $status;

						if ($model->Edit_StatusBranch()) {
							echo json_encode(array('msg' => 'success'));
						} else {
							$msg = Yii::$app->session['errmsg_branch'];
							echo json_encode(array('msg' => $msg));
							Yii::$app->session->remove('errmsg_branch');
						}
					}
				}


				public function actionUpdatetabname()
				{
					if (Yii::$app->request->isPostRequest) {
						$id = $_POST['id'];
						$tabname = $_POST['tabname'];
						$obj_id = $_POST['obj_id'];

						// Remove all illegal characters from email
						$tabname = filter_var($tabname, FILTER_SANITIZE_STRING);

						if (filter_var($tabname, FILTER_SANITIZE_STRING)) {
							$model = new BranchAction;

							$model->id = $id;
							$model->tabname = $tabname;
							$model->obj_id = $obj_id;

							if ($model->Updatetabname()) {

								$log_page = basename(Yii::$app->request->referrer);

								$log_description = 'แก้ไขชื่อเมนูของหน่วยงาน <br/>';
								$log_description .= 'ชื่อเมนูเก่า : ' . strip_tags($_POST['oldetabname']) . ' <br/>';
								$log_description .= 'ชื่อเมนูใหม่ : ' . strip_tags($tabname) . ' <br/>';

								$cwebuser = new \app\components\CustomWebUser();
								$createby = !Yii::$app->user->isGuest ? $cwebuser->getInfo('uid') : 0;
								\app\models\CommonAction::AddEventLog($createby, "Update", $log_page, $log_description);

								echo json_encode(array('status' => 'success',));
							} else {
								echo json_encode(array('status' => 'error', 'msg' => Yii::$app->session['errmsg_tabname'],));
								Yii::$app->session->remove('errmsg_tabname');
							}
						} else {
							echo json_encode(array('status' => 'error', 'msg' => "ชื่อเมนูไม่ถูกต้อง กรุณาตรวจสอบ",));
						}
					}
				}

				public function actionAddcollection()
				{

					$id = "";
					if (!empty($_GET["id"])) {
						if (filter_var($_GET["id"], FILTER_VALIDATE_INT)) {
							$id = $_GET["id"];
						} else {
							$id = "";
						}
					}

					if (Yii::$app->request->referrer) {
						$redirect = Yii::$app->request->referrer;
					} else {
						$redirect = Yii::$app->urlManager->createUrl('');
					}

					$user_id = Yii::$app->user->getInfo("id");
					$ssobranch_code = Yii::$app->user->getInfo("ssobranch_code");
					$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['branch'];

					$data = lkup_user::getUserPermission($user_id, $app_id);
					$user_role = $data[0]["user_role"];


					$isAdmin = false;

					$allowed = lkup_data::chkAddPermission($user_role, $app_id);

					if ($this->superadmin) {
						$allowed = true;
					}
					if ($allowed) {

						$rows = lkup_data::getBranch_Description($id, false);

						$cate_name = "";
						if (count($rows) != 0) {
							$cate_name = $rows[0]["branch_name"];
						} else {
							?>
				<script>
					alert("ไม่พบหน่วยงานที่ต้องการเพิ่ม");
					window.location.href = "<?= $redirect ?>";
				</script>
				<?php
							exit;
						}

						if (!$this->superadmin) {
							$rqssobranch_code = $rows[0]['ssobranch_code'];
							if ($rqssobranch_code != $ssobranch_code) {
				?>
					<script>
						alert("เจ้าหน้าที่ไม่สามารถเพิ่มข้อมูลได้");
						window.location.href = "<?= $redirect ?>";
					</script>
			<?php
								exit;
							}
						}

						$sql = "SELECT * FROM trn_collection_settings WHERE obj_id=:obj_id AND name='menuname' AND status=1 ORDER BY id ";
						$conn = Yii::$app->db;
						$command = $conn->createCommand($sql);
						$command->bindValue(":obj_id", $id);
						$settings = $command->queryAll();

						$filecode =  Yii::$app->CommonFnc->genstring();
						$this->render('addcollection', array("settings" => $settings, "filecode" => $filecode, "cate_name" => $cate_name, "ssobranch_code" => $ssobranch_code, "user_role" => $user_role, "id" => $id));
					} else {
			?>
			<script>
				alert("เจ้าหน้าที่ไม่สามารถเพิ่มหรือแก้ไขข้อมูลได้");
				window.location.href = "<?= $redirect ?>";
			</script>
<?php
					}
				}

				//ต้นฉบับ Content Controller
				public function actionAddgroupcollection()
				{

					$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['branch'];
					$user_id = Yii::$app->user->getInfo("id");
					$data = lkup_user::getUserPermission($user_id, $app_id);
					$user_role = $data[0]["user_role"];

					$allowed = lkup_data::chkAddPermission($user_role, $app_id);

					if ($this->superadmin) {
						$allowed = true;
					}
					if (!$allowed) {
						echo json_encode(array('status' => 'error', 'msg' => 'เจ้าหน้าที่ไม่ได้รับสิทธิ์ในการเพิ่มข้อมูล',));
						exit;
					}

					$model = new BranchAction;
					$model->subject = isset($_POST['subject']) ? addslashes(trim($_POST['subject'])) : '';
					$model->permission = isset($_POST['permission']) ? addslashes(trim($_POST['permission'])) : '';
					$model->master_id = $_POST['master'];

					if ($model->save_groupcollection()) {

						$log_page = basename(Yii::$app->request->referrer);

						$log_description = 'เพิ่มชุดเอกสารสำหรับหน่วยงาน <br/>';
						$log_description .= 'Content ID : ' . Yii::$app->session['success_content_id'] . '<br/>';
						$log_description .= 'หัวข้อ : ' . strip_tags($_POST['subject']) . ' <br/>';

						CommonAction::AddEventLog(Yii::$app->user->getState("sub"), "Insert", $log_page, $log_description);

						echo json_encode(array('status' => 'success'));
						Yii::$app->session->remove('success_content_id');
					} else {
						echo json_encode(array('status' => 'error', 'msg' => Yii::$app->session['errmsg_content'],));
						Yii::$app->session->remove('errmsg_content');
					}
				}

				public function actionEditgroupcollection()
				{

					$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['branch'];
					$user_id = Yii::$app->user->getInfo("id");
					$data = lkup_user::getUserPermission($user_id, $app_id);
					$user_role = $data[0]["user_role"];

					$allowed = lkup_data::chkAddPermission($user_role, $app_id);

					if ($this->superadmin) {
						$allowed = true;
					}
					if (!$allowed) {
						echo json_encode(array('status' => 'error', 'msg' => 'เจ้าหน้าที่ไม่ได้รับสิทธิ์ในการเพิ่มข้อมูล',));
						exit;
					}

					$model = new BranchAction;
					$model->subject = isset($_POST['subject']) ? addslashes(trim($_POST['subject'])) : '';
					$model->permission = isset($_POST['permission']) ? addslashes(trim($_POST['permission'])) : '';
					$model->content_id = $_POST['id'];

					if ($model->save_updategroupcollection()) {

						$log_page = basename(Yii::$app->request->referrer);

						$log_description = 'แก้ไขชุดเอกสารสำหรับหน่วยงาน <br/>';
						$log_description .= 'Content ID : ' . $_POST['id'] . '<br/>';
						$log_description .= 'หัวข้อ : ' . strip_tags($_POST['subject']) . ' <br/>';

						CommonAction::AddEventLog(Yii::$app->user->getState("sub"), "Update", $log_page, $log_description);

						echo json_encode(array('status' => 'success'));
						Yii::$app->session->remove('success_content_id');
					} else {
						echo json_encode(array('status' => 'error', 'msg' => Yii::$app->session['errmsg_content'],));
						Yii::$app->session->remove('errmsg_content');
					}
				}

				//ต้นฉบับ Content Controller
				public function actionSavecollection()
				{

					$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['branch'];
					$user_id = Yii::$app->user->getInfo("id");
					$data = lkup_user::getUserPermission($user_id, $app_id);
					$user_role = $data[0]["user_role"];

					$allowed = lkup_data::chkAddPermission($user_role, $app_id);

					if ($this->superadmin) {
						$allowed = true;
					}
					if (!$allowed) {
						echo json_encode(array('status' => 'error', 'msg' => 'เจ้าหน้าที่ไม่ได้รับสิทธิ์ในการเพิ่มข้อมูล',));
						exit;
					}

					$model = new BranchAction;

					$model->content = $_POST['content'];
					$model->master_id = $_POST['obj_id'];
					$model->filecode = $_POST["filecode"];

					$externallink = isset($_POST['externallink']) ? $_POST['externallink'] : null;
					if ($externallink != null) {
						$model->externallink = $externallink;
					}


					if ($model->save_listcollection()) {

						$log_page = basename(Yii::$app->request->referrer);

						$log_description = 'เพิ่มรายการชุดเอกสารสำหรับหน่วยงาน <br/>';
						$log_description .= 'Content ID : ' . Yii::$app->session['success_content_id'] . '<br/>';
						$log_description .= 'หัวข้อ : ' . strip_tags($_POST['content']) . ' <br/>';

						CommonAction::AddEventLog(Yii::$app->user->getState("sub"), "Insert", $log_page, $log_description);

						echo json_encode(array('status' => 'success', 'msg' => Yii::$app->session['success_content'],));
						Yii::$app->session->remove('success_content');
						Yii::$app->session->remove('success_content_id');
					} else {
						echo json_encode(array('status' => 'error', 'msg' => Yii::$app->session['errmsg_content'],));
						Yii::$app->session->remove('errmsg_content');
					}
				}

				public function actionEditlistcollection()
				{

					$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['branch'];
					$user_id = Yii::$app->user->getInfo("id");
					$data = lkup_user::getUserPermission($user_id, $app_id);
					$user_role = $data[0]["user_role"];

					$allowed = lkup_data::chkAddPermission($user_role, $app_id);

					if ($this->superadmin) {
						$allowed = true;
					}
					if (!$allowed) {
						echo json_encode(array('status' => 'error', 'msg' => 'เจ้าหน้าที่ไม่ได้รับสิทธิ์ในการแก้ไขข้อมูล',));
						exit;
					}

					$model = new BranchAction;

					$model->content = $_POST['content'];
					$model->master_id = $_POST['obj_id'];
					$model->filecode = $_POST["filecode"];

					$externallink = isset($_POST['externallink']) ? $_POST['externallink'] : null;
					if ($externallink != null) {
						$model->externallink = $externallink;
					}


					if ($model->edit_listcollection()) {

						$log_page = basename(Yii::$app->request->referrer);

						$log_description = 'แก้ไขรายการชุดเอกสารสำหรับหน่วยงาน <br/>';
						$log_description .= 'Content ID : ' . Yii::$app->session['success_content_id'] . '<br/>';
						$log_description .= 'หัวข้อ : ' . strip_tags($_POST['content']) . ' <br/>';

						CommonAction::AddEventLog(Yii::$app->user->getState("sub"), "Update", $log_page, $log_description);

						echo json_encode(array('status' => 'success', 'msg' => Yii::$app->session['success_content'],));
						Yii::$app->session->remove('success_content');
						Yii::$app->session->remove('success_content_id');
					} else {
						echo json_encode(array('status' => 'error', 'msg' => Yii::$app->session['errmsg_content'],));
						Yii::$app->session->remove('errmsg_content');
					}
				}

				public function actionDelcollection()
				{

					$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['branch'];
					$user_id = Yii::$app->user->getInfo("id");
					$data = lkup_user::getUserPermission($user_id, $app_id);
					$user_role = $data[0]["user_role"];

					$allowed = lkup_data::chkAddPermission($user_role, $app_id);

					if ($this->superadmin) {
						$allowed = true;
					}
					if (!$allowed) {
						echo json_encode(array('status' => 'error', 'msg' => 'เจ้าหน้าที่ไม่ได้รับสิทธิ์ในการลบข้อมูล',));
						exit;
					}

					if (Yii::$app->request->isPostRequest) {
						$obj_id = $_POST['obj_id'];
						$content = $_POST['content'];

						if (is_null($obj_id)) {
							exit;
						}
						if (filter_var($obj_id, FILTER_VALIDATE_INT)) {

							$model = new BranchAction;

							$model->content_id = $obj_id;

							if ($model->DelListcollection()) {

								$log_page = basename(Yii::$app->request->referrer);

								$log_description = 'ลบรายการชุดเอกสารสำหรับหน่วยงาน <br/>';
								$log_description .= 'Content ID : ' . $obj_id . '<br/>';
								$log_description .= 'หัวข้อ : ' . strip_tags($content) . ' <br/>';

								CommonAction::AddEventLog(Yii::$app->user->getState("sub"), "Delete", $log_page, $log_description);

								echo json_encode(array('status' => 'success',));
							} else {
								echo json_encode(array('status' => 'error', 'msg' => Yii::$app->session['errmsg_content'],));
								Yii::$app->session->remove('errmsg_content');
							}
						}
					}
				}

				public function actionUpdateCollectionOrder()
				{
					if (Yii::$app->request->isPostRequest) {
						$id_array = $_POST['id_array'];
						$ordno_array = $_POST['ordno_array'];

						if (is_null($id_array) || is_null($ordno_array)) {
							exit;
						}

						foreach ($id_array as $value) {
							if (!(is_numeric($value))) {
								echo json_encode(array('msg' => "id is NOT numeric"));
								exit;
							}
						}

						foreach ($ordno_array as $value) {
							if (!(is_numeric($value))) {
								echo json_encode(array('msg' => "order no is NOT numeric"));
								exit;
							}
						}

						$model = new BranchAction;
						$model->id_array = $id_array;
						//$model->ordno_array = $ordno_array;

						if ($model->Edit_OrderCollection_Mas()) {
							$log_page = basename(Yii::$app->request->referrer);

							$log_description = 'แก้ไขการเรียงลำดับประเภทหัวข้อชุดเอกสารสำหรับหน่วยงาน <br/>';

							for ($i = 1; $i <= count($id_array); $i++) {
								$log_description .= 'Content ID : ' . $id_array[$i - 1] . ' อันดับใหม่ ' . $i . ' <br/>';
							}

							CommonAction::AddEventLog(Yii::$app->user->getState("sub"), "Update", $log_page, $log_description);
							echo json_encode(array('msg' => 'success'));
						} else {
							$msg = Yii::$app->session['errmsg_calendar'];
							echo json_encode(array('msg' => $msg));
							Yii::$app->session->remove('errmsg_calendar');
						}
					}
				}

				public function actionUpdateCollectionlistOrder()
				{
					if (Yii::$app->request->isPostRequest) {

						$id = $_POST['id'];
						$oldPosition = $_POST['oldPosition'];
						$newPosition = $_POST['newPosition'];
						$id_array = $_POST['id_array'];
						$pos_array = $_POST['pos_array'];
						if (is_null($oldPosition) || is_null($newPosition)) {
							exit;
						}

						$model = new BranchAction;
						$model->content_id = $id;
						$model->newPosition = $newPosition;
						$model->id_array = $id_array;
						$model->pos_array = $pos_array;

						if ($model->Edit_Orderlistcollection()) {
							$log_page = basename(Yii::$app->request->referrer);

							$log_description = 'แก้ไขการเรียงลำดับชุดเอกสารสำหรับหน่วยงาน <br/>';

							for ($i = 1; $i <= count($id_array); $i++) {
								$log_description .= 'Content ID : ' . $id_array[$i - 1] . ' อันดับใหม่ ' . $pos_array[$i - 1] . ' <br/>';
							}

							CommonAction::AddEventLog(Yii::$app->user->getState("sub"), "Update", $log_page, $log_description);

							echo json_encode(array('msg' => 'success'));
						} else {
							$msg = Yii::$app->session['errmsg_content'];
							echo json_encode(array('msg' => $msg));
							Yii::$app->session->remove('errmsg_content');
						}
					}
				}

				public function actionList_branch_collection()
				{

					//if (Yii::$app->request->isPostRequest) {

					$page = 1;
					if (!empty($_POST['page'])) $page = (int) $_POST['page'];

					$recordsPerPage = 10;
					if (!empty($_POST['length'])) $recordsPerPage = (int) $_POST['length'];

					$start = 0;
					if (!empty($_POST['start'])) $start = (int) $_POST['start'];

					$FSearch = "";
					if (!empty($_POST['FSearch'])) $FSearch = $_POST['FSearch'];

					$id = null;
					if (!empty($_POST['id'])) $id = $_POST['id'];

					$noOfRecords = 0;


					$model = new BranchAction;
					$model->page = $page;
					$model->recordsPerPage = $recordsPerPage;
					$model->start = $start;
					$model->noOfRecords = $noOfRecords;
					$model->FSearch = $FSearch;
					$model->master_id = $id;

					$model->Listbranchcollection();
					/*
			header("Content-type: application/json; charset=UTF-8");
			echo json_encode($model->Listuser());
			Yii::$app->end();
			*/
					//}
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
