<?php

class Meme implements JsonSerializable
{
	private $id;
	private $top_text;
	private $bottom_text;
	private $url_final_img;
	private $url_src_img;
	private $user_id;
	private $gallery_id;
	private $created_at;

	function __construct($top_text = null, 
		$bottom_text = null, 
		$url_final_img = null, 
		$url_src_img = null, 
		$user_id = null, 
		$gallery_id = null, 
		$created_at = null,
		$is_approved = 0)
	{
		$this->top_text = $top_text;
		$this->bottom_text = $bottom_text;
		$this->url_final_img = $url_final_img;
		$this->url_src_img = $url_src_img;
		$this->user_id = $user_id;
		$this->gallery_id = $gallery_id;
		$this->created_at = $created_at;
		$this->is_approved = $is_approved;
	}

	public function jsonSerialize() {
        return [
            'id' => $this->getId(),
            'top_text' => $this->getTopText(),
            'bottom_text' => $this->getBottomText(),
            'url_final_img' => $this->getUrlFinalImg(),
            'url_src_img' => $this->getUrlSrcImg(),
            'user_id' => $this->getUserId(),
            'gallery_id' => $this->getGalleryId(),
            'created_at' => $this->getCreatedAt(),
            'is_approved' => $this->getIsApproved()
        ];
    }

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getTopText()
	{
		return $this->top_text;
	}

	public function setTopText($top_text)
	{
		$this->top_text = $top_text;
	}

	public function getBottomText()
	{
		return $this->bottom_text;
	}

	public function setBottomText($bottom_text)
	{
		$this->bottom_text = $bottom_text;
	}

	public function getUrlFinalImg()
	{
		return $this->url_final_img;
	}

	public function setUrlFinalImg($url_final_img)
	{
		$this->url_final_img = $url_final_img;
	}

	public function getUrlSrcImg()
	{
		return $this->url_src_img;
	}

	public function setUrlSrcImg($url_src_img)
	{
		$this->url_src_img = $url_src_img;
	}	
	
	public function getUserId()
	{
		return $this->user_id;
	}

	public function setUserId($user_id)
	{
		$this->user_id = $user_id;
	}
	
	public function getGalleryId()
	{
		return $this->gallery_id;
	}

	public function setGalleryId($gallery_id)
	{
		$this->gallery_id = $gallery_id;
	}	
	
	public function getCreatedAt()
	{
		return $this->created_at;
	}

	public function setCreatedAt($created_at)
	{
		$this->created_at = $created_at;
	}
	
	public function getIsApproved()
	{
		return $this->is_approved;
	}

	public function setIsApproved($is_approved)
	{
		$this->is_approved = $is_approved;
	}	
}