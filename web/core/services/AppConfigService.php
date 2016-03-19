<?php
require_once('./repositories/AppConfigRepository.php');

class AppConfigService
{
	private $appconfigRepository;
	private $config_option;
	
	function __construct($option)
	{
		try {
			$this->appconfigRepository = new AppConfigRepository($option);
			$this->config_option = $option;
			return $this;
		} catch(PDOException $e) {
		    echo $e->getMessage();
		    return null;
		}
	}

	public function getAll()
	{
		return $this->appconfigRepository->getAll();
	}

	public function getByKey($key)
	{
		return $this->appconfigRepository->getByKey($key);
	}

	public function save($item)
	{
		try {
			$setting = $this->appconfigRepository->getById($item->id);
			$setting->setValue($item->value);
			$this->appconfigRepository->save($setting);
			return true;
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		    return false; 
		}
	}
}