<?php
require_once('BaseRepository.php');

class AppConfigRepository extends BaseRepository
{
	private $appconfigRepository;
	
	function __construct($option)
	{
		parent::__construct($option);
		$this->appconfigRepository = $this->mapper->appconfig;
	}

	public function getById($id)
	{
		$result = $this->appconfigRepository[$id]->fetch();
		return $result;
	}

	public function getByKey($key)
	{
		$result = $this->mapper->appconfig(array('setting_key'=>$key))->fetch();
		return $result;
	}

	public function getAll()
	{
		$result = $this->appconfigRepository->fetchAll();
		return $result;
	}

	public function save($item)
	{
		$this->appconfigRepository->persist($item);
		$this->mapper->flush();
	}
}