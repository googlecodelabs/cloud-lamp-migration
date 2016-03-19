<?php
require_once('./repositories/VotesRepository.php');
require_once('./models/Votes.php');

class VotesService
{
	private $voteRepository;
	
	public function __construct($option)
	{
		try {
			$this->voteRepository = new VotesRepository($option);
			return $this;
		} catch(PDOException $e) {
		    echo $e->getMessage();
		    return null;
		}
	}

	public function vote($vote){
		//TODO: get current user
		$newVote = new Votes(null, $vote->user, $vote->meme_id, $vote->vote);
		try{
			return $this->voteRepository->vote($newVote);
		} catch(PDOException $e) {
		    echo $e->getMessage();
		    return null;
		}
	}
}