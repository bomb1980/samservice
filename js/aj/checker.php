<?php
// The file has JSON type.
header('Content-Type: application/json');

// Prepare the file name from the query string.
// Don't use session_start here. Otherwise this file will be only executed after the process.php execution is done.
$file = str_replace(".", "", $_GET['file']);
$file = "tmp/" . $file . ".txt";

/*
// Make sure the file is exist.
if (file_exists($file)) {
  // Get the content and echo it.
  $text = file_get_contents($file);
  echo $text;

  // Convert to JSON to read the status.
  $obj = json_decode($text);
  // If the process is finished, delete the file.
  if ($obj->percent == 100) {
    unlink($file);
  }
}
else {
  echo json_encode(array("percent" => null, "message" => null));
}
*/
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
