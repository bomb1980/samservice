<?php
$sql = "SELECT * FROM `ooap_tbl_employees` WHERE `emp_citizen_id` = '". $_GET['test'] ."'";

echo $sql;


//http://tcm/a.php?test=%27or%27%27=%27
