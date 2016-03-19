<?php
require_once('./repositories/MemeRepository.php');
require_once('File.php');
require_once('./models/Meme.php');
require_once('Utils.php');
require_once('AppConfigService.php');

class MemeService
{
	private $memeRepository;
	private $config_option;
	private $pageSize = 10;
	
	function __construct($option)
	{
		try {
			$this->memeRepository = new memeRepository($option);
			$this->config_option = $option;
			return $this;
		} catch(PDOException $e) {
		    echo $e->getMessage();
		    return null;
		}
	}

	public function getAll($order, $page)
	{
		$memes = $this->memeRepository->getAll('', null, $order, null, $page, $this->pageSize);
		return array('memes' => $memes, 'finishLoad' => count($memes) < $this->pageSize);
	}

	public function search($searchTerm, $page, $user)
	{
		$memes = set_relative_time($this->memeRepository->getAll($user, 1, 'new', $searchTerm, $page, $this->pageSize));
		return array('memes' => $memes, 'finishLoad' => count($memes) < $this->pageSize);
	}

	public function getAllApproved($order, $page, $user)
	{
		$memes = set_relative_time($this->memeRepository->getAll($user, 1, $order, null, $page, $this->pageSize));
		return array('memes' => $memes, 'finishLoad' => count($memes) < $this->pageSize);
	}

	public function getMeme($memeId)
	{
		return $this->memeRepository->getMeme($memeId);
	}

	public function getAllFromUser($userId)
	{
		return $this->memeRepository->getAllFromUser($userId);
	}

	public function createMeme($data)
	{
		$appconfigService = new AppConfigService($this->config_option);
		$initialApproval = $appconfigService->getByKey("AUTO_APPROVE")->getValue();
		$meme = new Meme($data->top_text, 
		$data->bottom_text, 
		null, 
		null, 
		$data->user, 
		$data->gallery_id, 
		date("Y-m-d H:i:s"), 
		$initialApproval);

		$fileSrc   = new File($data->url_src_img, 0, $this->config_option);
		$fileFinal = new File($data->url_final_img, 1, $this->config_option);

		$src_img   = $fileSrc->createFileFromBase64();
		$final_img = $fileFinal->createFileFromBase64();

		// verifica as imagens foram criadas corretamente
		if( !$src_img && !$final_img ){
			//$fileSrc->removeFile();
			//$fileFinal->removeFile();
			return array('erro'=>'erro ao criar imagem no servidor');
		}

       $meme->setUrlSrcImg($src_img);
       $meme->setUrlFinalImg($final_img);
       return $this->save($meme);
	}

	public function updateMeme($data)
	{
		$meme = $this->memeRepository->getMeme($data->id);
		$meme->setTopText($data->top_text);
		$meme->setBottomText($data->bottom_text);
		$meme->setGalleryId( $data->gallery_id);

		$fileSrc = new File($meme->getUrlSrcImg(), 0, $this->config_option);
        $fileSrc->removeFile();

        $fileFinal = new File($meme->getUrlFinalImg(), 1, $this->config_option);
        $fileFinal->removeFile();

		$fileSrc   = new File($data->url_src_img, 0, $this->config_option);
		$fileFinal = new File($data->url_final_img, 1, $this->config_option);

		$src_img   = $fileSrc->createFileFromBase64();
		$final_img = $fileFinal->createFileFromBase64();

		// verifica as imagens foram criadas corretamente
		if( !$src_img && !$final_img ){
			//$fileSrc->removeFile();
			//$fileFinal->removeFile();
			return array('erro'=>'erro ao criar imagem no servidor');
		}

       $meme->setUrlSrcImg($src_img);
       $meme->setUrlFinalImg($final_img);
       return $this->save($meme);
	}

	public function save($meme)
	{
		try {
			$this->memeRepository->save($meme);
			return true;
		}
		catch(Exception $e)
		{
			return array('erro'=>$e->getMessage()); 
		}
	}

	public function removeMemeById($memeId)
	{
		try 
		{
			$meme = $this->memeRepository->getMeme($memeId);

			$fileSrc = new File($meme->getUrlSrcImg(), 0, $this->config_option);
	        $fileSrc->removeFile();

	        $fileFinal = new File($meme->getUrlFinalImg(), 1, $this->config_option);
	        $fileFinal->removeFile();

			$this->memeRepository->removeMeme($meme);
			return true;
		}
		catch(Exception $e)
		{
			echo $e->getMessage().'fsdfsdfsdß';
		    return false; 
		}
	}

	public function approveMeme($memeId, $approval)
	{
		try{
			$meme = $this->memeRepository->getMeme($memeId);
			$meme->setIsApproved($approval);
			return $this->save($meme);
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		    return false; 
		}
	}
}