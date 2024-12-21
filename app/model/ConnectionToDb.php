<?php

namespace app\model;
use PDO;

class ConnectionToDb
{
    private $db;
    public function __construct() {
        $this->db  = new PDO("mysql:host=localhost;dbname=mysql;charset=utf8", 'root', 'root');
    }
    public function getConnection() {
        return $this->db;
    }
}
