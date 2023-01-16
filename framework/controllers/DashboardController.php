<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

use \app\models\Data_dashboard;

use app\components\CustomWebUser;
use app\components\UserController;

class DashboardController extends Controller
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
		$data = \app\models\Data_dashboard::user_count();
		$all = \app\models\Data_dashboard::all_count();

		foreach ($all as $dataitem1) {

			$alldata = $dataitem1['total'];
		}
		$i = 0;
		foreach ($data as $dataitem) {
			if ($dataitem['name'] == "มาตรา 33") {
				$m33 = $dataitem['num'];
			} else if ($dataitem['name'] == "มาตรา 39") {
				$m39 = $dataitem['num'];
			} else if ($dataitem['name'] == "มาตรา 40") {
				$m40 = $dataitem['num'];
			} else if ($dataitem['name'] == "มาตรา 38") {
				$m38 = $dataitem['num'];
			} else if ($dataitem['name'] == "ลาออก") {
				$out = $dataitem['num'];
			}
			$i++;
		}



		//*********************************************************
		return	$this->render('index', array(
			'm33' => $m33,
			'm39' => $m39,
			'm40' => $m40,
			'm38' => $m38,
			'out' => $out,
			'alldata' => $alldata,
		));
	}
	public function actionMessage()
	{


		$data = \app\models\Data_dashboard::message();

		$i = 0;


		foreach ($data as $dataitem) {
			$chart[$i]['name'] = $dataitem["area"];
			$chart[$i]['y'] = intval($dataitem["percentage"]);


			//   $name[]=$dataitem["name"];
			//	$count[]=intval($dataitem["count"]);
			$i++;
		}

		echo json_encode(array('status' => 'success', 'msg' => '', 'chart' => $chart));
	}
	public function actionSso_new_old()
	{


		$data = \app\models\Data_dashboard::sso_new_old();

		$i = 0;


		foreach ($data as $dataitem) {
			$categories[] = $dataitem["log_date"];
			//	$chart[$i]['data']=[intval($dataitem["count_new"]),intval($dataitem["count_old"])];
			$contacts[] = intval($dataitem["contacts"]);
			$targetReaches[] = intval($dataitem["targetReaches"]);
			$blocks[] = intval($dataitem["blocks"]);
			//   $name[]=$dataitem["name"];
			//	$count[]=intval($dataitem["count"]);
			$i++;
		}
		$chart[0]['name'] = "contacts";
		$chart[0]['data'] = $contacts;
		$chart[1]['name'] = "targetReaches";
		$chart[1]['data'] = $targetReaches;
		$chart[2]['name'] = "blocks";
		$chart[2]['data'] = $blocks;

		echo json_encode(array('status' => 'success', 'msg' => '', 'chart' => $chart, 'categories' => $categories));
	}
	public function actionSso_provice()
	{


		$data = \app\models\Data_dashboard::sso_provice();


		$i = 0;


		foreach ($data as $dataitem) {
			$chart[$i][0] = $dataitem["code"];
			$chart[$i][1] = intval($dataitem["code_department"]);

			//   $name[]=$dataitem["name"];
			//	$count[]=intval($dataitem["count"]);
			$i++;
		}

		echo json_encode(array('status' => 'success', 'msg' => '', 'chart' => $chart));
	}
	public function actionSso_keyword()
	{


		$data = \app\models\Data_dashboard::user_count();


		$i = 0;


		foreach ($data as $dataitem) {
			$chart[$i] = intval($dataitem["num"]);


			//   $name[]=$dataitem["name"];
			//	$count[]=intval($dataitem["count"]);
			$i++;
		}

		echo json_encode(array('status' => 'success', 'msg' => '', 'chart' => $chart));
	}
	public function actionSso_region()
	{


		$data = \app\models\Data_dashboard::sso_region();


		$i = 0;
		$a = 0;

		foreach ($data as $dataitem) {
			$chart[$i]['name'] = $dataitem["region_name"];
			$chart[$i]['y'] = intval($dataitem["cont_region"]);

			$i++;
		}
		//	var_dump($chart_provice);
		//	exit;

		echo json_encode(array('status' => 'success', 'msg' => '', 'chart' => $chart));
	}
	public function actionSso_provicedetail()
	{


		$data = \app\models\Data_dashboard::thai_provicedetail($_POST['name']);
		$nameprovice = \app\models\Data_dashboard::nameprovice($_POST['name']);

		$i = 0;

		foreach ($nameprovice as $dataitem1) {
			$provice_name = $dataitem1['name'];
		}
		foreach ($data as $dataitem) {

			$provicedetail[$i]['name'] = $dataitem['name'];
			$provicedetail[$i]['y'] = intval($dataitem["num"]);

			//   $name[]=$dataitem["name"];
			//	$count[]=intval($dataitem["count"]);
			$i++;
		}

		echo json_encode(array('status' => 'success', 'msg' => '', 'provicedetail' => $provicedetail, 'provice_name' => $provice_name));
	}
	public function actionSso_regiondetail()

	{
		$data = \app\models\Data_dashboard::region_detail($_POST['name']);
		$i = 0;


		foreach ($data as $dataitem) {
			$region_detail[$i]['name'] = $dataitem["name"];
			$region_detail[$i]['y'] = intval($dataitem["cont_region"]);
			$region_detail[$i]['drilldown'] = $dataitem["name"];
			$region_provice1[$i]['id'] = $dataitem["name"];
			$region_provice1[$i]['name'] = $dataitem["name"];
			$data1 = \app\models\Data_dashboard::region_provicedetail($dataitem["code_department"]);
			$a = 0;
			foreach ($data1 as $dataitem) {

				$provicedetail[$a][0] = $dataitem['name'];
				$provicedetail[$a][1] = intval($dataitem["num"]);

				//   $name[]=$dataitem["name"];
				//	$count[]=intval($dataitem["count"]);
				$a++;
			}
			$region_provice1[$i]['data'] = $provicedetail;
			$i++;
		}
		//	var_dump(region_provice1);
		//	exit;
		\Yii::$app->response->data = json_encode(array('status' => 'success', 'msg' => '', 'region_detail' => $region_detail, 'region_provice1' => $region_provice1));
	}
}
