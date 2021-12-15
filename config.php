<?php

define('TIME_LOCATION', date_default_timezone_set('Asia/Jakarta'));
define("BASEURL", "http://localhost/ppsimentoring");

class Connection{

    private $conn;

    public function __construct(){
        $this->conn = new mysqli("localhost", "root", "", "mentoring_ppsi");    

        if($this->conn->connect_errno > 0) {
            echo "connection time out";
        }
    }

    public function getConn(){
        return $this->conn;
    }

}