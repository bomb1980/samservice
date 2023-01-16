<?php
// The file has JSON type.
header('Content-Type: application/json');

if (strlen(session_id()) === 0) {
    session_start();
}

if (isset($_SESSION['progress'])) {
	$progress = $_SESSION['progress'];
	$obj = json_decode($_SESSION['progress']);
	
    //echo $_SESSION['progress'];
    if ($obj->percent == 100) {  

        $execution_time = $_SESSION['executionTime'];
        if ( round($_SESSION['executionTime']) > 0){
            $strTime = Yii::app()->CommonFnc->calctime( round($_SESSION['executionTime']) );
        }else{
            $execution_time = $execution_time . " millisecond";
        }
                
		$strcomplete = '<div class="alert alert-success alert-dismissible" role="alert"> <i class="icon fa-info" aria-hidden="true"></i>&nbsp;&nbsp;';
		$strcomplete .="จำนวนปรับปรุง : " . number_format($_SESSION['total_user']) . " เร็คคอร์ด , ใช้เวลา {$strTime}";
        echo json_encode(array("percent" => $obj->percent, "message" => $strcomplete ));
        unset($_SESSION['progress']);
        unset($_SESSION['executionTime']);
		unset($_SESSION['total_user']);
    }else{
        echo json_encode(array("percent" => $obj->percent, "message" => $obj->message));
    }

} else {
    //echo '0';
	echo json_encode(array("percent" => 0, "message" => null));
}
