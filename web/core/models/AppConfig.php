<?php

class AppConfig implements JsonSerializable
{
	private $id;
	private $setting_key;
	private $value;
	private $description;

	function __construct($id = null, $setting_key = null, $value = null, $description = null)
	{
		$this->id = $id;
		$this->setting_key = $setting_key;
		$this->value = $value;
		$this->description = $description;
	}

	public function setDescription($description)
	{
		$this->description = $description;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function setValue($value)
	{
		$this->value = $value;
	}

	public function getValue()
	{
		return $this->value;
	}

	public function setKey($setting_key)
	{
		$this->setting_key = $setting_key;
	}

	public function getKey()
	{
		return $this->setting_key;
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
        	'value' => $this->getValue(),
            'key' => $this->getKey(),
            'id' => $this->getId(),
            'description' => $this->getDescription()
        ];
    }

}