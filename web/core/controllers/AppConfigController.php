<?php
require_once('./services/AppConfigService.php');
require_once('./models/AppConfig.php');

class AppConfigController
{
	private $appconfigService;
	
	function __construct($option)
	{
		$this->appconfigService = new AppConfigService($option);
		if ($this->appconfigService != null) {
			return $this;
		} else {
			return null;
		}
	}

	public function index()
	{
		$resp = array('action' => 'index',
			'data' => $this->appconfigService->getAll());   
		return $resp;
	}

	public function update($data)
	{
		$resp = array('action' => 'save',
			'data' => $this->appconfigService->save($data));      
		return $resp;
	}
}