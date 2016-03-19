<?php

require_once('BaseRepository.php');

class VotesRepository extends BaseRepository{

	private $voteRepository;

	public function __construct($option){
		parent::__construct($option);
		$this->voteRepository = $this->mapper->votes;
	}

	public function vote($vote){
		$userVoted = $this->userVoteMeme($vote);
		if($userVoted){
			$votePersisted = $userVoted;
			$this->voteRepository->persist($userVoted);
		} else{
			$votePersisted = $vote;
			$this->voteRepository->persist($vote);
		}
		$this->mapper->flush();
		return array(
			'votePersisted'    => $votePersisted,
			'updateCountVotes' => $this->voteCount($vote)
		);
	}

	private function voteCount($vote){
		$query   = "SELECT 
						COUNT(*) as upvotes, 
						(SELECT COUNT(*) FROM votes WHERE meme_id = {$vote->getMemeId()} AND vote = -1) as downvotes 
					FROM votes 
					WHERE meme_id = {$vote->getMemeId()} AND vote = 1";
		$dbQuery = $this->getConn()
						->prepare($query);
		$dbQuery->execute();
		return $dbQuery->fetch();
	}

	private function userVoteMeme($vote){
		$conditions = array(
			'user_id' => $vote->getUserId(),
			'meme_id' => $vote->getMemeId()
		);
		$voteDb = $this->mapper->votes($conditions)->fetch();

		if (!$voteDb){
			return 0;
		}

		if ($vote->getVote() == $voteDb->getVote()){
			$voteDb->setVote(0);
		} else{
			$voteDb->setVote($vote->getVote());
		}
		return $voteDb;
	}

}