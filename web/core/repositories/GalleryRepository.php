<?php
require_once('BaseRepository.php');

class GalleryRepository extends BaseRepository
{
	private $galleryRepository;
	
	function __construct($option)
	{
		parent::__construct($option);
		$this->galleryRepository = $this->mapper->gallery;
	}

	public function getById($id)
	{
		$result = $this->galleryRepository[$id]->fetch();
		return $result;
	}

	public function getAll()
	{
		$result = $this->galleryRepository->fetchAll();
		return $result;
	}

	public function save($item)
	{
		$this->galleryRepository->persist($item);
		$this->mapper->flush();
	}

	public function removeById($id)
	{
		$item = $this->galleryRepository[$id]->fetch();
		$this->galleryRepository->remove($item);
		$this->mapper->flush();
	}

	public function removeGalleryItem($item)
	{
		$this->galleryRepository->remove($item);
		$this->mapper->flush();
	}
}