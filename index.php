<?php

// comment out the following two lines when deployed to production
//defined('YII_DEBUG') or define('YII_DEBUG', true);
//defined('YII_ENV') or define('YII_ENV', 'dev');
function arr( $arr = [], $exit = true ) {
      echo '<pre>';
      print_r( $arr );

      if($exit == true) {

            exit;
      }
} 

//
//
function genCond_( $sql, $replace = [], $con, $bindValue = [] )
{

	$defConditions = array('WHERE', 'HAVING');

	$keep = array();
	foreach ($defConditions as $kr => $vr) {
		$keep['[' . $vr . ']'] = '';
	}

	foreach ($replace as $kr => $vr) {

		if (in_array($kr, $defConditions)) {

			if (!empty($vr)) {
				$keep['[' . $kr . ']'] = $kr . " " . implode(' AND ', $vr);
			} else {

				$keep['[' . $kr . ']'] = '';
			}
		} else {
			$keep['[' . $kr . ']'] = $vr;
		}
	}

	$sql = str_replace(array_keys($keep), $keep, $sql);

      $cmd = $con->createCommand($sql);

      foreach( $bindValue as $kb => $vb ) {
		
		$cmd->bindValue( $kb, $vb );
      }

      return $cmd;
}

require __DIR__ . '/framework/vendor/autoload.php';
require __DIR__ . '/framework/vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/framework/config/web.php';

(new yii\web\Application($config))->run();