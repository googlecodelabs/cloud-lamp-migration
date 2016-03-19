<?php

class Statistics implements JsonSerializable{

  private $user_id;
  private $total_votes;
  private $count_votes;
  private $total_memes;
  private $total_users;


  public function __construct($user_id = null,$total_votes = null,$count_votes = null,$total_memes = null,$total_users = null){
    $this->user_id      = $user_id;
    $this->total_votes  = $total_votes;
    $this->count_votes  = $count_votes;
    $this->total_memes  = $total_memes;
    $this->total_users = $total_users;
  }

  public function jsonSerialize() {
        return [
            'user_id'       => $this->getUserId(),
            'total_votes'   => $this->getTotalVotes(),
            'count_votes'   => $this->getCountVotes(),
            'total_memes'   => $this->getTotalMemes(),
            'total_users'   => $this->getTotalUsers()
        ];
  }

  public function getUserId(){
    return $this->user_id;
  }

  public function setUserId($user_id){
    $this->user_id = $user_id;
  }

   public function getTotalVotes(){
    return $this->total_votes;
  }

  public function setTotalVotes($total_votes){
    $this->total_votes = $total_votes;
  }

  public function getCountVotes(){
     return $this->count_votes;
  }

  public function setCountVotes($count_votes){
    $this->count_votes=$count_votes;
  }

  public function getTotalMemes(){
    return $this->total_memes;
  }

  public function setTotalMemes($total_memes){
    $this->total_memes=$total_memes;
    
  }

  public function getTotalUsers(){
    return $this->total_users;
  }

  public function setTotalUsers($total_users){
    $this->total_users->$total_users;
  }

}