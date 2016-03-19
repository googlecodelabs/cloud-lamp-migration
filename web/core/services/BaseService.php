<?php
require_once('./repositories/BaseRepository.php');

class BaseService
{	
	protected $repository;
	
	public function __construct($option=LOCAL_CONFIG)
	{
		try {
			$this->repository = new BaseRepository($option);
			return $this;
		} catch(PDOException $e) {
		    echo $e->getMessage();
		    return null;
		}   
	}
}