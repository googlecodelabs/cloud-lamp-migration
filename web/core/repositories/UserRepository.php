<?php
require_once('BaseRepository.php');

class UserRepository extends BaseRepository
{
	private $userRepository;
	
	function __construct($option)
	{
		parent::__construct($option);
		$this->userRepository = $this->mapper->user;
	}

	public function getUserByName($user){
		return $this->mapper->user(array('name'=>$user))->fetch();
	}

	public function getUserById($id){
		return $this->mapper->user(array('id'=>$id))->fetch();
	}

	public function getUserByEmail($email){
		return $this->mapper->user(array('email'=>$email))->fetch();
	}

	public function createUser($user){
		try{
			$this->userRepository->persist($user);
			$this->mapper->flush();	
			return $user;
		} catch(Exception $e){
			throw new Exception($e->getMessage(), 1);
			return false;
		}
	}

	public function updateExpirationTime($user){
		$time  = $this->updateTime();
		$token = $this->generatedToken();
		
		$user->setExpirationTime($time);
		$user->setToken($token);		
		$this->userRepository->persist($user);
		$this->mapper->flush();
		return $user;
	}

	public function cancelToken($user){
		$user->setToken(NULL);		
		$this->userRepository->persist($user);
		$this->mapper->flush();
		return $user;
	}
	
	public function updateTime(){
		return date("Y-m-d H:i:s", strtotime('+1 hour'));
	}

	public function generatedToken(){
		return md5(uniqid(rand(), true));
	}

	public function getAllUsers()
	{
		return $this->userRepository->fetchAll();
	}

	public function getUser($userId)
	{
		return $this->userRepository[$userId]->fetch();
	}

	public function remove($user)
	{
		$this->userRepository->remove($user);
		$this->mapper->flush();
	}
}