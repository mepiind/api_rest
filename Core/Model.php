<?php
namespace Core;

class Model {

	protected $db;

	public function __construct() {
		global $db;
		$this->db = $db;
	}

	public function redoConnection(){
		global $db;
		$this->db = $db;
	}

}