<?php

class Gallery implements JsonSerializable
{
	private $id;
	private $url;

	function __construct($url = null)
	{
		$this->url = $url;
	}

	public function setUrl($url)
	{
		$this->url = $url;
	}

	public function getUrl()
	{
		return $this->url;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getId()
	{
		return $this->id;
	}

	public function jsonSerialize() {
        return [
            'url' => $this->getUrl(),
            'id' => $this->getId()
        ];
    }

}