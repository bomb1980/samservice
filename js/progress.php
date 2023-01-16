<?php

if (strlen(session_id()) === 0) {
    session_start();
    unset($_SESSION['progress']);
}
set_time_limit(0);
makeProgress();

function makeProgress() {
    $progress = 0;
    $max = 135;
	$arr_content = array();
    for ($i = 1; $i <= $max; $i++) {
        if (isset($_SESSION['progress'])) {
            session_start(); //IMPORTANT!
        }

		// Calculate the percentation
		$percent = intval($i/$max * 100);

		// Put the progress percentage and message to array.
		$arr_content['percent'] = $percent;
		$arr_content['message'] = $i . " row(s) processed.";

		$progress = json_encode($arr_content);
		$_SESSION['progress'] = $progress;

        //$progress++;
        //$_SESSION['progress'] = $progress;
        session_write_close(); //IMPORTANT!
        sleep(1); //IMPORTANT!
    }
}
