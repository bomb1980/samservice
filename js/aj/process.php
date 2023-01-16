<?php
// Start the session.
if (strlen(session_id()) === 0) {
    session_start();
    unset($_SESSION['progress']);
}
set_time_limit(0);

// The example total processes.
$total = 50;

// The array for storing the progress.
$arr_content = array();

// Loop through process
for($i=1; $i<=$total; $i++){

	if (isset($_SESSION['progress'])) {
	   session_start(); //IMPORTANT!
	}

  // Calculate the percentation
  $percent = intval($i/$total * 100);

  // Put the progress percentage and message to array.
  $arr_content['percent'] = $percent;
  $arr_content['message'] = $i . "/" . $total." row(s) processed.";

	$progress = json_encode($arr_content);
	$_SESSION['progress'] = $progress;

	session_write_close(); //IMPORTANT!

  // Sleep one second so we can see the delay
  sleep(1);
}
