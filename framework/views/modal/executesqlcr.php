<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<title>Execute SQL Command</title>
	<style>
		.tablen {
			border-collapse: collapse;
		}

		.tablen,
		.thn,
		.tdn {
			border: 1px solid black;
		}
	</style>
</head>
<?php
$sqlcr = $sqlcr; //strtolower($sqlcr);	
$sqlcmdtype = "-"; //ตรวจสอบว่ามีคำว่า  หรือปล่าว
if (strstr($sqlcr, 'select')) {
	//$Condition = substr($txtsql,strpos($txtsql,'where'),strlen($txtsql));
	$sqlcmdtype = 'select';
} else {
	//$Condition = "";
	if (strstr($sqlcr, 'insert')) {
		//$Condition = substr($txtsql,strpos($txtsql,'where'),strlen($txtsql));
		$sqlcmdtype = 'insert';
	} else {
		//$Condition = "";
		if (strstr($sqlcr, 'update')) {
			//$Condition = substr($txtsql,strpos($txtsql,'where'),strlen($txtsql));
			$sqlcmdtype = 'update';
		} else {
			//$Condition = "";
			if (strstr($sqlcr, 'delete')) {
				//$Condition = substr($txtsql,strpos($txtsql,'where'),strlen($txtsql));
				$sqlcmdtype = 'delete';
			} else {
				//$Condition = "";
				$sqlcmdtype = '-';
			}
		}
	}
}

/*
Yii::$app->setComponents(array(
	'dynamicdb' => array('connectionString' => Yii::$app->params['data_ctrl']['dbhost'] . 'dbname=' . $udb1)
));
*/
\Yii::$app->dynamicdb->dsn = Yii::$app->params['data_ctrl']['dbhost'] . 'dbname=' . $udb1;
$conn = Yii::$app->dynamicdb; //get connection

//$conn = Yii::$app->db; 
//echo "{$sqlcr}<br>"; 
//$sql = "select * from accnumber_tb";
if ($sqlcmdtype == 'select') {
	try {
		$time_start = microtime(true);
		$command = $conn->createCommand($sqlcr);
		$rows = $command->queryAll(); //sql respons data array
		$rowsn = $command->execute(); //sql respons action rows number
		$time_end = microtime(true);
		$execution_time = ($time_end - $time_start);
		if (round($execution_time) > 0) {
			$execution_time = Yii::$app->CommonFnc->calctime(round($execution_time));
		} else {
			$execution_time = $execution_time . " millisecond";
		}
		echo '<div class="alert alert-success alert-dismissible" role="alert"> <i class="icon fa-info" aria-hidden="true"></i>&nbsp;&nbsp;';
		echo "จำนวนค้นหา : " . number_format($rowsn) . " เร็คคอร์ด , ใช้เวลา {$execution_time}";
		echo '</div>';
	} catch (CDbException $e) {

		die('<div class="alert alert-warning alert-dismissible" role="alert"><i class="icon fa-warning" aria-hidden="true"></i> เกิดข้อผิดพลาด ' . $e->getMessage() . '</div>');
	}
} else if ($sqlcmdtype == 'insert') {
	$cwebuser = new \app\components\CustomWebUser();
	$uid = $cwebuser->getInfo('uid');
	if ($uid === 'niras') {
		try {
			$time_start = microtime(true);
			$command = $conn->createCommand($sqlcr);
			$rowsn = $command->execute();
			//$rowsn = 0;
			$time_end = microtime(true);
			$execution_time = ($time_end - $time_start);
			if (round($execution_time) > 0) {
				$execution_time = Yii::$app->CommonFnc->calctime(round($execution_time));
			} else {
				$execution_time = $execution_time . " millisecond";
			}
			echo '<div class="alert alert-success alert-dismissible" role="alert"> <i class="icon fa-info" aria-hidden="true"></i>&nbsp;&nbsp;';
			echo "จำนวนเพิ่ม : " . number_format($rowsn) . " เร็คคอร์ด , ใช้เวลา {$execution_time}";
			echo '</div>';
		} catch (CDbException $e) {
			die('<div class="alert alert-warning alert-dismissible" role="alert"><i class="icon fa-warning" aria-hidden="true"></i> เกิดข้อผิดพลาด ' . $e->getMessage() . '</div>');
		}
	} else {
		die('<div class="alert alert-info alert-dismissible" role="alert"><i class="icon fa-user-secret" aria-hidden="true"></i> คุณไม่สามารถ insert ข้อมูลได้ กรุณาติดต่อผู้ดูแลระบบ! </div>');
	}
} else if ($sqlcmdtype == 'update') {
	$cwebuser = new \app\components\CustomWebUser();
	$uid = $cwebuser->getInfo('uid');
	if ($uid === 'niras') {
		try {
			$time_start = microtime(true);
			$command = $conn->createCommand($sqlcr);
			$rowsn = $command->execute();
			//$rowsn = 0;	
			$time_end = microtime(true);
			$execution_time = ($time_end - $time_start);
			if (round($execution_time) > 0) {
				$execution_time = Yii::$app->CommonFnc->calctime(round($execution_time));
			} else {
				$execution_time = $execution_time . " millisecond";
			}
			echo '<div class="alert alert-success alert-dismissible" role="alert"> <i class="icon fa-info" aria-hidden="true"></i>&nbsp;&nbsp;';
			echo "จำนวนปรับปรุง : " . number_format($rowsn) . " เร็คคอร์ด , ใช้เวลา {$execution_time}";
			echo '</div>';
		} catch (CDbException $e) {
			die('<div class="alert alert-warning alert-dismissible" role="alert"><i class="icon fa-warning" aria-hidden="true"></i> เกิดข้อผิดพลาด ' . $e->getMessage() . '</div>');
		}
	} else {
		die('<div class="alert alert-info alert-dismissible" role="alert"><i class="icon fa-user-secret" aria-hidden="true"></i> คุณไม่สามารถ update ข้อมูลได้ กรุณาติดต่อผู้ดูแลระบบ! </div>');
	}
} else if ($sqlcmdtype == 'delete') {
	$cwebuser = new \app\components\CustomWebUser();
	$uid = $cwebuser->getInfo('uid');
	if ($uid === 'niras') {
		try {
			$time_start = microtime(true);
			$command = $conn->createCommand($sqlcr);
			$rowsn = $command->execute();
			//$rowsn = 0;
			$time_end = microtime(true);
			$execution_time = ($time_end - $time_start);
			if (round($execution_time) > 0) {
				$execution_time = Yii::$app->CommonFnc->calctime(round($execution_time));
			} else {
				$execution_time = $execution_time . " millisecond";
			}
			echo '<div class="alert alert-success alert-dismissible" role="alert"> <i class="icon fa-info" aria-hidden="true"></i>&nbsp;&nbsp;';
			echo "จำนวนลบ : " . number_format($rowsn) . " เร็คคอร์ด , ใช้เวลา {$execution_time}";
			echo '</div>';
		} catch (CDbException $e) {
			die('<div class="alert alert-warning alert-dismissible" role="alert"><i class="icon fa-warning" aria-hidden="true"></i> เกิดข้อผิดพลาด ' . $e->getMessage() . '</div>');
		}
	} else {
		die('<div class="alert alert-info alert-dismissible" role="alert"><i class="icon fa-user-secret" aria-hidden="true"></i> คุณไม่สามารถ update ข้อมูลได้ กรุณาติดต่อผู้ดูแลระบบ! </div>');
	}
} //if

//var_dump($rows);
//echo "{$rows}";


?>

<body>
	<div style="overflow: auto; height:400px;">
		<?php if ($sqlcmdtype == 'select') {  ?>
			<table class="tablen" style="white-space:nowrap;width:100%;">
				<?php

				if ($rowsn) {
				?>
					<tr>
						<?php
						foreach ($rows[0] as $key => $value) {
							echo "<td class='tdn' style='width:auto; text-align:center; background-color:#6F9;'>{$key}</td>"; // Would output "subkey" in the example array 
						} //foreach
						?>
					</tr>
					<?php
					$rn = 0;
					while ($rn < $rowsn) {
					?>
						<tr>
						<?php
						foreach ($rows[$rn] as $key => $value) {
							//echo "{$key} : "; // Would output "subkey" in the example array
							echo "<td class='tdn' style='width:auto; text-align:center;'>{$value}</td>";
						} //foreach
						//echo "<br>";
						$rn = $rn + 1;
					} //while
						?>
						</tr>
					<?php
				} else { //if
					//echo "no data 0 record.";
				}
					?>

			</table>
		<?Php } //if 
		?>
	</div>
</body>

</html>