<?php
require_once('./repositories/StatisticsRepository.php');
require_once('./models/Statistics.php');

class StatisticsService
{
  private $statisticsRepository;
  private $config_option;

  function __construct($option)
  {
    try {
      $this->statisticsRepository = new statisticsRepository($option);
      $this->config_option = $option;
      return $this;
    } catch(PDOException $e) {
        echo $e->getMessage();
        return null;
    }
  }

  public function getTopUpMemesVotedUser()
  {
    return $this->statisticsRepository->getTopMemesVotedUser(1);
  }

  public function getTopDownMemesVotedUser()
  {
    return $this->statisticsRepository->getTopMemesVotedUser(-1);
  }

   public function getTotal()
  {
    return $this->statisticsRepository->getTotal();
  }


}
