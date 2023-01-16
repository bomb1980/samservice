<?php
	
class UserIdentity extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
	public $username;
	public $password;
	private $_id;
	private $_guid;
	
	private $_uid;
	
	/*
   	const ERROR_NONE=0;
    const ERROR_USERNAME_INVALID=1;
    const ERROR_PASSWORD_INVALID=2;
    const ERROR_UNKNOWN_IDENTITY=100;
	*/		
	const ERROR_USERNAME_NOTADMIN=21;
	const ERROR_USERNAME_INACTIVE=67;

	public function __construct()
	{
        $arg_list = func_get_args();
		$this->username=$arg_list[0];
		$this->password=$arg_list[1];
	}

	public function authenticate()
	{	
		$username=strtolower($this->username);		
		$user=lkup_user::getUsername($username);
		//Check User
		if(count($user)=='0') { return $this->errorCode=self::ERROR_USERNAME_INVALID; } 

		$local = Yii::app()->params['auth']['local'];
		if ($local) {
			//Check Pass
			if($user[0]['userpass']!=$this->password) { return $this->errorCode=self::ERROR_PASSWORD_INVALID; }
		}
		
		if($user[0]['status'] != 1) { return $this->errorCode=self::ERROR_USERNAME_INACTIVE; }

		//Login OK	
		$this->_id=$user[0]['id'];	
		$this->_uid=$user[0]['uid'];
		$this->_guid = Yii::app()->CommonFnc->getGUID(); //echo Yii::app()->CommonFnc->getGUID();exit;

		$this->errorCode=self::ERROR_NONE;
		
		return $this->errorCode==self::ERROR_NONE;
	}	
	
	public function getId()
	{
		return $this->_id;
	}	
	public function getGUID()
	{
		return $this->_guid;
	}
	public function getUID()
	{
		return $this->_uid;
	}

}