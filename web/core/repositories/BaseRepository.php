<?php
use Respect\Config\Container;
use Respect\Relational\Mapper;

const LOCAL_CONFIG = 0;
const REMOTE_CONFIG = 1;

class BaseRepository
{
	protected $config;
	public $mapper;

	private $conn;
	
	public function __construct($option=LOCAL_CONFIG)
	{
		if ($option == LOCAL_CONFIG) {
			$this->config = new Container(dirname(__DIR__).'/local_config.ini');
		} else {
			$this->config = new Container(dirname(__DIR__).'/remote_config.ini');
		}
		$this->connect();
	}

	public function connect()
	{

		$conn = new PDO($this->config->db_dsn, $this->config->db_user, $this->config->db_pass);
	    $this->conn = $conn;
	    $this->mapper = new Mapper($conn);
	}

	public function getConn(){
		return $this->conn;
	}
}