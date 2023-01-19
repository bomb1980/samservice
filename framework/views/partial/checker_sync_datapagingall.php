<?php
// The file has JSON type.
header('Content-Type: application/json');


if (isset(Yii::$app->session['progress'])) {
	$progress = Yii::$app->session['progress'];
	$obj = json_decode(Yii::$app->session['progress']);
	
    //echo $_SESSION['progress'];
    if ($obj->percent == 100) {  

        $execution_time = Yii::$app->session['executionTimeAll'];
        if ( round(Yii::$app->session['executionTimeAll']) > 0){
            $strTime = \app\components\CommonFnc::calctime( round(Yii::$app->session['executionTimeAll']) );
        }else{
            $strTime = $execution_time . " millisecond";
        }
                
		$strcomplete = '<div class="alert alert-success alert-dismissible" role="alert"> <i class="fa fa-info" aria-hidden="true"></i>&nbsp;&nbsp;';
		$strcomplete .="จำนวนปรับปรุง : " . number_format(Yii::$app->session['total_all']) . " เร็คคอร์ด , ใช้เวลา {$strTime}";
        echo json_encode(array("percent" => $obj->percent, "message" => $strcomplete ));

        Yii::$app->session->remove('progress');
        Yii::$app->session->remove('executionTime');
        Yii::$app->session->remove('total_user');

        Yii::$app->session->remove('firstTime');
        Yii::$app->session->remove('total_all');
        Yii::$app->session->remove('executionTimeAll');
    }else{
        echo json_encode(array("percent" => $obj->percent, "message" => $obj->message));
    }

} else {
    //echo '0';
	echo json_encode(array("percent" => 0, "message" => null));
}
