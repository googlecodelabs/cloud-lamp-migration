
<?php

require_once('./services/VotesService.php');

class VotesController
{
	private $votesService;
	
	function __construct($option)
	{
		$this->votesService = new VotesService($option);
		if ($this->votesService != null) {
			return $this;
		} else {
			return null;
		}
	}

	public function vote($data){
		$resp = array('action' => 'vote',
			'data' => $this->votesService->vote($data));        
		return $resp;
	}

}