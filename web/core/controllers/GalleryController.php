<?php
require_once('./services/GalleryService.php');

class GalleryController
{
	private $galleryService;
	
	function __construct($option)
	{
		$this->galleryService = new GalleryService($option);
		if ($this->galleryService != null) {
			return $this;
		} else {
			return null;
		}
	}

	public function index()
	{
		$resp = array('action' => 'index',
			'data' => $this->galleryService->getAll());   
		return $resp;
	}

	public function create($data)
	{
		$resp = array('action' => 'save create',
			'data' => $this->galleryService->create($data));        
		return $resp;
	}

	public function delete($id)
	{
		$this->galleryService->removeById($id);
		$resp = array('action' => 'delete',
			'data' => $this->galleryService->getAll());        
		return $resp;
	}
}