<?php
require_once('BaseRepository.php');

class StatisticsRepository extends BaseRepository
{
  private $statisticsRepository;
  
  function __construct($option)
  {
    parent::__construct($option);
    $this->memeRepository = $this->mapper->Statistics;
  }

  public function getTopMemesVotedUser($typeVote = 1)
  {
  
    $query = "select 
                  ttv1.user_id, 
                  sum(ttv1.total_votes) as total_votes,
                  (select count(*) from meme where ttv1.user_id = meme.user_id) as count_memes
              from
                  (select 
                      meme.user_id as user_id, count(*) as total_votes
                  from
                      votes, meme
                  where
                      votes.vote = :typeVote 
                  and meme.id = votes.meme_id
                      and meme.is_approved = 1
                  group by votes.meme_id) as ttv1
              group by ttv1.user_id limit 10";
    $dbQuery = parent::getConn()->prepare($query);
    $dbQuery->execute(array('typeVote' => $typeVote));
    return $dbQuery->fetchAll();
  }

  public function getTotal()
  {
  
    $query = "select 
                  users.total_users, memes.total_memes
              from
                  (select 
                      count(*) as total_users
                  from
                      user) as users,
                  (select 
                      count(*) as total_memes
                  from
                      meme) as memes;
              ";
    $dbQuery = parent::getConn()->prepare($query);
    $dbQuery->execute();
    return $dbQuery->fetchAll();
  }





}