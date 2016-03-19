<?php

class User implements JsonSerializable
{

	private $id;

	private $name;

	private $roles;

	private $token;

	private $expiration_time;

	private $is_admin;

	private $created_at;

	private $email;

	public function __construct($id=null,$name=null,$roles=null,$token=null,$expiration_time=null,$is_admin=null,$created_at=null,$email=null){
		$this->id = $id;
		$this->name = $name;
		$this->roles = $roles;
		$this->token = $token;
		$this->expiration_time = $expiration_time;
		$this->is_admin = $is_admin;
		$this->created_at = $created_at;
		$this->email    = $email;
	}

	public function jsonSerialize() {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'roles' => $this->getRoles(),
            'token' => $this->getToken(),
            'expiration_time' => $this->getExpirationTime(),
            'is_admin' => $this->isAdmin(),
            'created_at' => $this->getCreatedAt(),
            'email' => $this->getEmail()
        ];
    }

    public function getId(){
    	return $this->id;
    }

    public function getName(){
    	return $this->name;
    }

    public function getRoles(){
    	return $this->roles;
    }

    public function getToken(){
    	return $this->token;
    }

    public function getExpirationTime(){
    	return $this->expiration_time;
    }

    public function isAdmin(){
    	return $this->is_admin;
    }

    public function getCreatedAt(){
    	return $this->created_at;
    }

    public function getEmail(){
    	return $this->email;
    }

    public function setToken($token){
    	$this->token = $token;
    }

    public function setExpirationTime($time){
        $this->expiration_time = $time;
    }

}