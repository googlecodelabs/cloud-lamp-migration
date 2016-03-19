<?php

use Respect\Config\Container;

class File
{

	private $img;

	private $config;

	private $dirServer;

	private $dirSave;

	const DIR_SRC = 0;

	const DIR_FINAL = 1;

	const DIR_GALLERY = 2;

	const CONFIG_LOCAL = 0;

	const CONFIG_REMOTE = 1;

	public function __construct($img, $dir=self::DIR_SRC, $config=self::CONFIG_LOCAL){

		if($config === self::CONFIG_LOCAL){
			$this->config = new Container( dirname(__DIR__).'/local_config.ini' );
		} else{
			$this->config = new Container( dirname(__DIR__).'/remote_config.ini' );
		}		

		$this->dirServer = __DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR;
		
		if ($dir === self::DIR_SRC){
			$this->dirSave = $this->config->dir_src_img;
		} else if($dir === self::DIR_FINAL) {
			$this->dirSave = $this->config->dir_final_img;
		} else {
			$this->dirSave = $this->config->dir_gallery;
		}

		$this->img = $img;
	}

	private function validateimg(){
		// @todo ver uma forma viavel de validar a imagem em base64
		return TRUE;
	}

	public function createFileFromBase64(){
		if(!$this->validateimg()){
			throw new Exception("Imagem invalida...", 1);
		}

		$file = $this->saveImage( $this->img );

		return $file;
	}

	private function saveImage($dataString){
		try{ 
			$img = imagecreatefromstring( base64_decode($dataString) );
		
			if (!$img){
				throw new Exception("Erro ao gerar imagem...", 1);	
			}
			$fileName = uniqid().".png";
			$file     = $this->dirServer.$this->dirSave.DIRECTORY_SEPARATOR.$fileName;
			if( @imagepng($img, $file)){
			 	return $fileName;
			}
			return false;
		}
		catch(Exception $e){
			echo $e->getMessage(); 
			return false;
		}
	}

	public function removeFile(){
		try{
			$file = $this->dirServer.$this->dirSave.DIRECTORY_SEPARATOR.$this->img;
			if(file_exists($file)){
				if(unlink($file)){
					return true;
				}
				return false;
			}
			return true;
		}
		catch(Exception $e){
			return array('erro'=>$e->getMessage()); 
		}
	}

}