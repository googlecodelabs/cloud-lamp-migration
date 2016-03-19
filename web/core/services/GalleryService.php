<?php
require_once('./repositories/GalleryRepository.php');
require_once('./models/Gallery.php');
require_once('File.php');

class GalleryService
{
	private $galleryRepository;
	private $config_option;
	
	function __construct($option)
	{
		try {
			$this->galleryRepository = new GalleryRepository($option);
			$this->config_option = $option;
			return $this;
		} catch(PDOException $e) {
		    echo $e->getMessage();
		    return null;
		}
	}

	public function getAll()
	{
		return $this->galleryRepository->getAll();
	}

	public function create($data)
	{
		$gallery = new Gallery();
		
		$fileSrc = new File($data->img, 2, $this->config_option);
		$img = $fileSrc->createFileFromBase64();
		if ($img != '' && $img != false) {
			$gallery->setUrl($img);
			$this->save($gallery);
		}
        return $img;        
	}

	public function save($item)
	{
		try {
			$this->galleryRepository->save($item);
			return true;
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		    return false; 
		}
	}

	public function removeById($galleryId)
	{
		try {
			$item = $this->galleryRepository->getById($galleryId);
			$file = new File($item->getUrl(), 2, $this->config_option);
	        $file->removeFile();

	        $this->galleryRepository->removeGalleryItem($item);
			return true;
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		    return false; 
		}
	}
}