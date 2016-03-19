<?php
require_once('./services/UserService.php');

class UserController
{

	private $userService;


	function __construct($option)
	{
		$this->userService = new UserService($option);
		if ($this->userService != null) {
			return $this;
		} else {
			return null;
		}
	}

	public function authenticate($credentials){
		$authenticated = $this->userService->authenticate($credentials);
		if ($authenticated){
			$user = $this->userService->userDbLocal($credentials->user);
			if(is_array($user)){
				return $user;
			}
			return $this->userService->updateExpirationTime($user);
		}
		return array('erro'=>'user or password invalid');
	}

	public function validateToken($user,$token){
		$valid = $this->userService->validateToken($user,$token);
		$error = array();
		if($valid == 1){
			return true;
		} else if($valid == 2){
			$error['error'] = $valid;
			$error['msg']  = 'token expirated';
		} else if($valid == 3){
			$error['error'] = $valid;
			$error['msg']  = 'token for user invalid';
		} else if($valid == 4){
			$error['error'] = $valid;
			$error['msg']  = 'user invalid';
		}
		return $error;
	}

	public function create($user){
		//TODO: general validations
		$resp = array('action' => 'index','data' => false);
		if($this->userService->create($user) === true){
			$resp['data'] = true;
		}
		return $resp;
	}

	public function index()
	{
		$resp = array('action' => 'index',
			'data' => $this->userService->getAllUsers());        
		return $resp;
	}

	public function detail($id)
	{
		$resp = array('action' => 'index',
			'data' => $this->userService->getUser($id));        
		return $resp;
	}

	public function delete($id)
	{
		$resp = array('action' => 'delete',
			'data' => $this->userService->removeById($id));        
		return $resp;
	}

}