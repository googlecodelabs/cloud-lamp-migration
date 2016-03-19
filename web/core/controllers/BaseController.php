<?php
require_once('./services/BaseService.php');

class BaseController
{
	private $baseService;

	function __construct($option)
	{
		$this->baseService = new BaseService($option);
		if ($this->baseService != null) {
			return $this;
		} else {
			return null;
		}
	}

}