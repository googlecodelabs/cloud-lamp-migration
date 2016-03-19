<?php

use Respect\Config\Container;
use Respect\Relational\Mapper;

class MemeLdapService{

	private $config;

	private $connection;

	private $authenticated;

	public function __construct($option=LOCAL_CONFIG)
	{
		if ($option == LOCAL_CONFIG) {
			$this->config = new Container(dirname(__DIR__).'/local_config.ini');
		} else {
			$this->config = new Container(dirname(__DIR__).'/remote_config.ini');
		}
		$this->connect();
		$this->authenticated = false;
	}

	private function connect(){
		$this->connection = ldap_connect( $this->config->ad_server );
		if (FALSE === $this->connection){
			throw new Exception("Error ao conectar AD", 1);
		}
		ldap_set_option($this->connection, LDAP_OPT_REFERRALS, 0);
		ldap_set_option($this->connection, LDAP_OPT_PROTOCOL_VERSION, 3);
		return $this->connection;
	}

	public function authenticate($credentials){
		$this->authenticated = ldap_bind($this->connection,$credentials->user,$credentials->password);
		return $this->authenticated;
	}

	public function getEntryUser($user){
		if(!$this->authenticated){
			return array('erro'=>'Você deve autenticar primeiro para buscar informações.');
		}
		
		$search_filter = "(cn={$user->user})";
		$attr = array("*");
		try{
			$result  = ldap_search($this->connection, $this->config->ad_dn, $search_filter,$attr);
			if($result){
				$entries = ldap_get_entries($this->connection, $result);
				if($entries){
					// echo "<pre>";
					// print_r($entries[0]);
					return $entries[0];
	 			}
	 			return array('erro'=>"Nenhuma entrada para o usuário: ".$user);
			}
			return array('erro'=>"Usuário não encontrado: ".$user);
		} catch(Exception $ex){
			return $ex->getMessage();
		}
	}

	public function isAdmin($entry){
		if($entry['admincount'][0] == 1){
			return true;
		}
		return false;
	}

	public function getInfo($entry){
		$attributes = array("name","displayname","userprincipalname","objectcategory","cn");
		$data = array();
		foreach ($attributes as $value) {
			$data[$value] = $entry[$value][0];
		}
		$data['ad-admin'] = $this->isAdmin($entry);
		return $data;
	}

}