<?php

namespace app\controllers;

use app\components\CommonFnc;
use app\models\MasUser;
use Yii;
use yii\web\Controller;
// use yii\helpers\Url;

use app\models\PerPersonal1;

class CronempController extends Controller
{


	// http://samservice/empdata/personaltosql
	public function actionPersonaltosql()
	{

		
		ini_set("default_socket_timeout", 60000);
		ini_set('memory_limit', '2048M');
		set_time_limit(0);
		global $params;
		$con = Yii::$app->dbdpis;
		$con2 = Yii::$app->dbdpisemp;
		$con3 = Yii::$app->db;

		$sqlUnion = [];
		$perPage = 10000;
		foreach ($params['dbInserts'] as $kdb => $vdb) {

			$offset = 0;

			for ($i = 0; $i <= 50; ++$i) {

				$sql = "
					SELECT
						p.* 
					FROM per_personal_news p
					OFFSET " . $offset . " ROWS FETCH NEXT " . $perPage . " ROWS ONLY
				";

				if ($vdb == 1) {
					$cmd = $con->createCommand($sql);
				} else {
					$cmd = $con2->createCommand($sql);
				}

				$datas = $cmd->queryAll();

				if (count($datas) == 0) {

					break;
				}

				foreach ($datas as $kd => $vd) {

					// arr( $vd );

					$s = [];
					foreach ($vd as $ks => $vs) {

						
						if( empty( trim($vs) ) ) {

							$s[] = "NULL as " . strtolower($ks) . "";
						}
						else {

							$s[] = "'" . trim($vs) . "' as " . strtolower($ks) . "";
						}
						 

					}

					$sqlUnion[] = "
						SELECT 
							" . implode(',', $s) . "
					";

					if (count($sqlUnion) > 200) {

						$sql = "
							REPLACE INTO per_personal_news ( per_id, per_status, organize_id_ass, per_cardno, pos_id, per_name, per_surname, per_level_id, pertype_id, per_pos_desc, per_pos_doctype, per_pos_orgmgt, per_pos_org, org_owner, d5_per_id, pos_no, per_offno, per_renew, per_taxno, per_start_org, per_startdate, per_occupydate, per_effectivedate, per_gender, blood_id, scar, birth_place, is_ordain, ordain_date, ordain_detail, is_disability, is_soldier_service, per_saldate, probation_startdate, probation_enddate, probation_passdate, per_posdate, approve_per_id, replace_per_id, per_mobile, per_email, per_license_no, per_id_ref, per_nickname, per_pos_docdate, per_pos_remark, per_book_no, per_job, per_ot_flag, per_type_2535, prename_id, prename_th, prename_en, per_eng_name, per_eng_surname, department_id, province_id, movement_id, pay_no, per_orgmgt, posstatus_id, per_salary, hip_flag, is_sync, sync_datetime, sync_status_code, per_set_ass, organize_id_work, organize_id_kpi, organize_id_salary, create_date, creator, department_id_ass, create_org, update_date, update_user, update_name, allow_sync, edit_req_no, update_org, birth_date, creator_name, audit_name, is_delete, per_level_date, per_line_date ) 
							SELECT
							per_id, per_status, organize_id_ass, per_cardno, pos_id, per_name, per_surname, per_level_id, pertype_id, per_pos_desc, per_pos_doctype, per_pos_orgmgt, per_pos_org, org_owner, d5_per_id, pos_no, per_offno, per_renew, per_taxno, per_start_org, per_startdate, per_occupydate, per_effectivedate, per_gender, blood_id, scar, birth_place, is_ordain, ordain_date, ordain_detail, is_disability, is_soldier_service, per_saldate, probation_startdate, probation_enddate, probation_passdate, per_posdate, approve_per_id, replace_per_id, per_mobile, per_email, per_license_no, per_id_ref, per_nickname, per_pos_docdate, per_pos_remark, per_book_no, per_job, per_ot_flag, per_type_2535, prename_id, prename_th, prename_en, per_eng_name, per_eng_surname, department_id, province_id, movement_id, pay_no, per_orgmgt, posstatus_id, per_salary, hip_flag, is_sync, sync_datetime, sync_status_code, per_set_ass, organize_id_work, organize_id_kpi, organize_id_salary, create_date, creator, department_id_ass, create_org, update_date, update_user, update_name, allow_sync, edit_req_no, update_org, birth_date, creator_name, audit_name, is_delete, per_level_date, per_line_date
							FROM (
							" . implode(' UNION ', $sqlUnion) . "
							) as s;
							
						";

						$con3->createCommand($sql)->execute();

						$sqlUnion = [];
					}
				}

				$datas = [];

				$offset += $perPage;
			}
		}

		if (count($sqlUnion) > 0) {

			$sql = "
				REPLACE INTO per_personal_news ( per_id, per_status, organize_id_ass, per_cardno, pos_id, per_name, per_surname, per_level_id, pertype_id, per_pos_desc, per_pos_doctype, per_pos_orgmgt, per_pos_org, org_owner, d5_per_id, pos_no, per_offno, per_renew, per_taxno, per_start_org, per_startdate, per_occupydate, per_effectivedate, per_gender, blood_id, scar, birth_place, is_ordain, ordain_date, ordain_detail, is_disability, is_soldier_service, per_saldate, probation_startdate, probation_enddate, probation_passdate, per_posdate, approve_per_id, replace_per_id, per_mobile, per_email, per_license_no, per_id_ref, per_nickname, per_pos_docdate, per_pos_remark, per_book_no, per_job, per_ot_flag, per_type_2535, prename_id, prename_th, prename_en, per_eng_name, per_eng_surname, department_id, province_id, movement_id, pay_no, per_orgmgt, posstatus_id, per_salary, hip_flag ) 
				SELECT
				per_id, per_status, organize_id_ass, per_cardno, pos_id, per_name, per_surname, per_level_id, pertype_id, per_pos_desc, per_pos_doctype, per_pos_orgmgt, per_pos_org, org_owner, d5_per_id, pos_no, per_offno, per_renew, per_taxno, per_start_org, per_startdate, per_occupydate, per_effectivedate, per_gender, blood_id, scar, birth_place, is_ordain, ordain_date, ordain_detail, is_disability, is_soldier_service, per_saldate, probation_startdate, probation_enddate, probation_passdate, per_posdate, approve_per_id, replace_per_id, per_mobile, per_email, per_license_no, per_id_ref, per_nickname, per_pos_docdate, per_pos_remark, per_book_no, per_job, per_ot_flag, per_type_2535, prename_id, prename_th, prename_en, per_eng_name, per_eng_surname, department_id, province_id, movement_id, pay_no, per_orgmgt, posstatus_id, per_salary, hip_flag
				FROM (
				" . implode(' UNION ', $sqlUnion) . "
				) as s;
				REPLACE INTO per_personal_news2 ( per_id, is_sync, sync_datetime, sync_status_code, per_set_ass, organize_id_work, organize_id_kpi, organize_id_salary, create_date, creator, department_id_ass, create_org, update_date, update_user, update_name, allow_sync, edit_req_no, update_org, birth_date, creator_name, audit_name, is_delete, per_level_date, per_line_date ) 
				SELECT
				per_id, is_sync, sync_datetime, sync_status_code, per_set_ass, organize_id_work, organize_id_kpi, organize_id_salary, create_date, creator, department_id_ass, create_org, update_date, update_user, update_name, allow_sync, edit_req_no, update_org, birth_date, creator_name, audit_name, is_delete, per_level_date, per_line_date
				FROM (
				" . implode(' UNION ', $sqlUnion) . "
		
				) as s;
			";

			$con3->createCommand($sql)->execute();

			$sqlUnion = [];
		}

		$datas['status'] = 'success';
		$datas['msg'] = 'อัพเดทเสร็จสิ้น';
		echo json_encode($datas);
		exit;
	}


	// http://samservice/cronemp/perpersonal/?ciphering=AES-256-CBC&encryption_iv=1234567891011121
	public function actionPerpersonal()
	{

		if (Yii::$app->user->getId()) {


			echo PerPersonal1::getFromApi(Yii::$app->user->getId());
			exit;
		} else {

			$r = Yii::$app->request->get();

			$headers = CommonFnc::getAuthorizationHeader();

			if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {

				$ciphering = $r['ciphering'];
				$encryption_iv = $r['encryption_iv'];

				$MasUser = MasUser::find()
					->where(['uid' => CommonFnc::getEncrypter($matches[1], 'decypt', $ciphering, $encryption_iv)])
					->one();

				if ($MasUser) {

					echo PerPersonal1::getFromApi($MasUser->id);
					exit;
				}
			}
		}

		$datas['status'] = 'fail';
		$datas['msg'] = 'ไม่สำเร็จ';

		echo json_encode($datas);

		exit;
	}

	public function actionPertype()
	{

		if (Yii::$app->user->getId()) {


			echo PerPersonal1::getPertypeApi(Yii::$app->user->getId());


			exit;
		} else {

			$r = Yii::$app->request->get();

			$headers = CommonFnc::getAuthorizationHeader();

			if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {

				$ciphering = $r['ciphering'];
				$encryption_iv = $r['encryption_iv'];

				$MasUser = MasUser::find()
					->where(['uid' => CommonFnc::getEncrypter($matches[1], 'decypt', $ciphering, $encryption_iv)])
					->one();

				if ($MasUser) {

					// arr($MasUser->id );
					echo PerPersonal1::getPertypeApi($MasUser->id);


					exit;
				}
			}
		}



		$datas['status'] = 'fail';
		$datas['msg'] = 'ไม่สำเร็จ';

		echo json_encode($datas);

		exit;
	}


	public function actionLevel()
	{

		if (Yii::$app->user->getId()) {


			echo PerPersonal1::getlevelApi(Yii::$app->user->getId());


			exit;
		} else {

			$r = Yii::$app->request->get();

			$headers = CommonFnc::getAuthorizationHeader();

			if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {

				$ciphering = $r['ciphering'];
				$encryption_iv = $r['encryption_iv'];

				$MasUser = MasUser::find()
					->where(['uid' => CommonFnc::getEncrypter($matches[1], 'decypt', $ciphering, $encryption_iv)])
					->one();

				if ($MasUser) {

					echo PerPersonal1::getlevelApi($MasUser->id);

					exit;
				}
			}
		}



		$datas['status'] = 'fail';
		$datas['msg'] = 'ไม่สำเร็จ';

		echo json_encode($datas);

		exit;
	}

	public function actionLine()
	{

		if (Yii::$app->user->getId()) {


			echo PerPersonal1::getlineApi(Yii::$app->user->getId());

			$datas['status'] = 'success';
			$datas['msg'] = 'อัพเดทเรียบร้อย';

			echo json_encode($datas);
			exit;
		} else {


			$r = Yii::$app->request->get();

			$headers = CommonFnc::getAuthorizationHeader();

			if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {

				$ciphering = $r['ciphering'];
				$encryption_iv = $r['encryption_iv'];

				$MasUser = MasUser::find()
					->where(['uid' => CommonFnc::getEncrypter($matches[1], 'decypt', $ciphering, $encryption_iv)])
					->one();

				if ($MasUser) {

					// arr($MasUser->id );
					echo PerPersonal1::getlineApi($MasUser->id);

					$datas['status'] = 'success';
					$datas['msg'] = 'อัพเดทเรียบร้อย';

					echo json_encode($datas);
					exit;
				}
			}
		}
		$datas['status'] = 'fail';
		$datas['msg'] = 'ไม่สำเร็จ';

		echo json_encode($datas);

		exit;
	}

	public function actionPosition()
	{

		if (Yii::$app->user->getId()) {


			echo PerPersonal1::getPositionApi(Yii::$app->user->getId());


			exit;
		} else {


			$r = Yii::$app->request->get();

			$headers = CommonFnc::getAuthorizationHeader();

			if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {

				$ciphering = $r['ciphering'];
				$encryption_iv = $r['encryption_iv'];

				$MasUser = MasUser::find()
					->where(['uid' => CommonFnc::getEncrypter($matches[1], 'decypt', $ciphering, $encryption_iv)])
					->one();

				if ($MasUser) {

					// arr($MasUser->id );
					echo PerPersonal1::getPositionApi($MasUser->id);


					exit;
				}
			}
		}




		$datas['status'] = 'fail';
		$datas['msg'] = 'ไม่สำเร็จ';

		echo json_encode($datas);

		exit;
	}

	public function actionOganize()
	{

		if (Yii::$app->user->getId()) {


			echo PerPersonal1::getOganizeApi(Yii::$app->user->getId());


			exit;
		} else {


			$r = Yii::$app->request->get();

			$headers = CommonFnc::getAuthorizationHeader();

			if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {

				$ciphering = $r['ciphering'];
				$encryption_iv = $r['encryption_iv'];

				$MasUser = MasUser::find()
					->where(['uid' => CommonFnc::getEncrypter($matches[1], 'decypt', $ciphering, $encryption_iv)])
					->one();

				if ($MasUser) {

					// arr($MasUser->id );
					echo PerPersonal1::getOganizeApi($MasUser->id);


					exit;
				}
			}
		}



		$datas['status'] = 'fail';
		$datas['msg'] = 'ไม่สำเร็จ';

		echo json_encode($datas);

		exit;
	}
}
