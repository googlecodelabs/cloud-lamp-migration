<?php
require_once('./services/StatisticsService.php');

class StatisticsController
{
  private $statisticsService;

  function __construct($option)
  {
    $this->statisticsService = new StatisticsService($option);
    if ($this->statisticsService != null) {
      return $this;
    } else {
      return null;
    }
  }

  public function getTopMemesVotedUser()
  {
    $resp = array('action' => 'getTopMemesVotedUser',
      'votesUp'   => $this->statisticsService->getTopUpMemesVotedUser(),
      'votesDown' => $this->statisticsService->getTopDownMemesVotedUser(),
      'total'     => $this->statisticsService->getTotal());        
    return $resp;
  }



}