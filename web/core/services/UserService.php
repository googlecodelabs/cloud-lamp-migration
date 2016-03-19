<?php
require_once('./repositories/UserRepository.php');
require_once('./services/MemeLdapService.php');
require_once('./models/User.php');

class UserService
{
	private $userRepository;

	private $ldapService;
	
	public function __construct($option)
	{
		$this->ldapService = new MemeLdapService($option);
		try {
			$this->userRepository = new UserRepository($option);
			return $this;
		} catch(PDOException $e) {
		    echo $e->getMessage();
		    return null;
		}
	}

	public function authenticate($credentials){
		$adAuthenticated = $this->ldapService->authenticate($credentials);
		if($adAuthenticated){
			return true;
		}
		return false;
	}

	/**
	 * return 1 => token valid and expiration_time ok
	 * return 2 => expiration time invalido
	 * return 3 => token enviado nao bate com usuario
	*/
	public function validateToken($id,$token){
		$user = $this->userRepository->getUserById($id);
		if(!is_object($user)){
			return 4;
		}
		if($user->getToken() != $token){
			return 3;
		}
		if( strtotime($user->getExpirationTime()) < strtotime('now')){
			return 2;
		}
		return 1;
	}

	public function updateExpirationTime($user){
		return $this->userRepository->updateExpirationTime($user);
	}

	public function getUserByName($name){
		return $this->userRepository->getUserByName($name);
	}

	public function getUserById($id){
		return $this->userRepository->getUserById($id);
	}

	public function getUserByEmail($email){
		return $this->userRepository->getUserByEmail($email);
	}

	public function create($user){
		//verificar user existente no AD
		//$adUser = $this->ldapService->getInfoUser($user->id);
		//var_dump($adUser);
		//return user existente
		try{			
			//salvar no AD
			//salvar local
			if(!$user->token){
				$user->token = $this->generatedToken();
			}
			if(!$user->expiration_time){
				$user->expiration_time = $this->userRepository->updateTime();
			}
			if(!$user->is_admin){
				$user->is_admin = 0;
			}

			if(!$user->roles){
				$user->roles = null;
			}
			
			$newUser = new User($user->id,$user->name,$user->roles,$user->token,$user->expiration_time,$user->is_admin,date("Y-m-d H:i:s"),$user->email);
			$this->userRepository->createUser($newUser);
			return $newUser;
		}
		catch(Exception $e){
			return array('erro'=>$e->getMessage());
		}
	}

	public function userDbLocal($user){
		$userExists = $this->userRepository->getUserById($user);
		if(!$userExists){
			//@Todo pegar os dados do ad
			$newUser = new stdClass();
			$newUser->id   = $user;
			$newUser->name = $user;
			return $this->create($newUser);
		}
		return $userExists;
	}


	public function getAllUsers()
	{
		return $this->userRepository->getAllUsers();
	}

	public function getUser($userId)
	{
		return $this->userRepository->getUser($userId);
	}

	public function removeById($id)
	{
		try {
			$user = $this->userRepository->getUserById($id);
	        $this->userRepository->remove($user);
			return true;
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		    return false; 
		}
	}
}
