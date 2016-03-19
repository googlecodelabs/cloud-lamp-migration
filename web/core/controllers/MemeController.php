<?php
require_once('./services/MemeService.php');

class MemeController
{
	private $memeService;
	
	function __construct($option)
	{
		$this->memeService = new MemeService($option);
		if ($this->memeService != null) {
			return $this;
		} else {
			return null;
		}
	}

	public function index($order, $page, $user)
	{
		$resp = array('action' => 'index',
			'data' => $this->memeService->getAllApproved($order, $page, $user));        
		return $resp;
	}

	public function indexAdmin($order, $page)
	{
		$resp = array('action' => 'index',
			'data' => $this->memeService->getAll($order, $page));        
		return $resp;
	}

	public function search($searchTerm, $page, $user)
	{
		$resp = array('action' => 'search',
			'data' => $this->memeService->search($searchTerm, $page, $user));        
		return $resp;
	}

	public function read($id)
	{
		$resp = array('action' => 'read',
			'data' => $this->memeService->getMeme($id));        
		return $resp;
	}

	public function create($data)
	{
		$resp = array('action' => 'save create',
			'data' => $this->memeService->createMeme($data));        
		return $resp;
	}

	public function update($meme)
	{
		$resp = array('action' => 'save',
			'data' => $this->memeService->updateMeme($meme));        
		return $resp;
	}

	public function delete($id)
	{
		$resp = array('action' => 'delete',
			'data' => $this->memeService->removeMemeById($id));        
		return $resp;
	}

	public function approve($id)
	{
		$resp = array('action' => 'approve',
			'data' => $this->memeService->approveMeme($id, 1));        
		return $resp;
	}

	public function disapprove($id)
	{
		$resp = array('action' => 'disapprove',
			'data' => $this->memeService->approveMeme($id, -1));        
		return $resp;
	}
}