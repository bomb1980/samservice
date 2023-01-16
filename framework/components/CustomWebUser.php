<?php

namespace app\components;

use Yii;
use yii\base\Component;

use app\models\User;

class CustomWebUser
{
	private $_usermodel;
	private $_membermodel;

	public function getUser()
	{

		$this->_usermodel = User::findIdentity(Yii::$app->user->id); 
		
		//$this->_usermodel = lkup_user::getUserid(Yii::$app->user->id);
		//$this->_usermodel=lkup_user::getUserid(114);
		return true;
	}

	public function getInfo($fieldcode)
	{
		if ($this->_usermodel === null) {
			$this->getUser();
		}
		$user = $this->_usermodel;

		if ($fieldcode == 'displayname') {
			//$returnval = "tttt"; 
			$returnval = $user->displayname;
		} else if ($fieldcode == 'uid') {
			$returnval = $user->username;
		} else {
			$returnval = $user->$fieldcode;
		}

		return $returnval;
	}

	public function getMember($id = null)
	{
		//$this->_usermodel=lkup_user::getUserid(Yii::$app->user->id);
		if ($id == null) $id = 1;
		$this->_membermodel = User::findIdentity(Yii::$app->user->id); 
		return true;
	}
	public function getMemberInfo($fieldcode, $id)
	{
		if ($this->_membermodel === null) {
			$this->getMember($id);
		}
		$user = $this->_membermodel;
		$returnval = $user->$fieldcode;
		return $returnval;
	}

	public function clearInfo()
	{
		unset($this->_usermodel);
		return true;
	}
}
