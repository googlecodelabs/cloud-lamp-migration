<?php

class Votes implements JsonSerializable{

	private $id;

	private $user_id;

	private $meme_id;

	private $vote;

	public function __construct($id = null,$user_id = null,$meme_id = null,$vote = null){
		$this->id      = $id;
		$this->user_id = $user_id;
		$this->meme_id = $meme_id;
		$this->vote    = $vote;
	}

	public function jsonSerialize() {
        return [
            'id' => $this->getId(),
			'user_id' => $this->getuserId(),
			'meme_id' => $this->getMemeId(),
			'vote'    => $this->getVote()
        ];
    }

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getuserId(){
		return $this->user_id;
	}

	public function setUserId($user_id){
		$this->user_id = $user_id;
	}

	public function getMemeId(){
		return $this->meme_id;
	}

	public function setMemeId($meme_id){
		$this->meme_id = $meme_id;
	}

	public function getVote(){
		return $this->vote;
	}

	public function setVote($vote){
		$this->vote = $vote;
	}
}