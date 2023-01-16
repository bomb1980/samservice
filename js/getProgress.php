<?php
header('Content-Type: application/json');
if (strlen(session_id()) === 0) {
    session_start();
}



if (isset($_SESSION['progress'])) {
	$progress = $_SESSION['progress'];
	$obj = json_decode($_SESSION['progress']);

	echo json_encode(array("percent" => $obj->percent, "message" => $obj->message));
    //echo $_SESSION['progress'];
    if ($obj->percent == 100) {
        unset($_SESSION['progress']);
    }
} else {
    //echo '0';
	echo json_encode(array("percent" => 0, "message" => null));
}