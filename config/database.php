<?php
class Database {

    private $connection;

    public $host = "localhost";
    public $db_name = "nexus";
    public $username = "root";
    public $password = "";
    public static $instance = null;



    private function __construct()
    {
        $this->connection = new PDO(
            "mysql:host=$this->host;dbname=$this->db_name",
            $this->username,
            $this->password
        );

    }
    public function getConnection(){
        return $this->connection;
    }
    public static function getInstance(){
        if(self::$instance === null)
        {
            self::$instance = new Database();
        }
        return self::$instance; 
    }

}