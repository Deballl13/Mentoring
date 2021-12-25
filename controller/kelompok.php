<?php

class KelompokMentoring{

    private $db;
    private $dbh;

    public function __construct(){
        $this->dbh = new Connection;
        $this->db = $this->dbh->getConn();
    }

    public function getMentor(){
        $statement = $this->db->prepare('SELECT kelompok FROM users WHERE nim = ?');
        $statement->bind_param('i', $_SESSION['user']['nim']);
        $statement->execute();
        $kelompok = $statement->get_result()->fetch_assoc()['kelompok'];

        if($kelompok !== null){
            $statement = $this->db->prepare("SELECT * FROM users WHERE kelompok = ? AND role = 'mentor'");
            $statement->bind_param('i', $kelompok);
            $statement->execute();

            return $statement->get_result()->fetch_assoc();
        }

        return null;
    }

    public function getMentee(){
        $statement = $this->db->prepare('SELECT kelompok FROM users WHERE nim = ?');
        $statement->bind_param('i', $_SESSION['user']['nim']);
        $statement->execute();
        $kelompok = $statement->get_result()->fetch_assoc()['kelompok'];

        if($kelompok !== null){
            $statement = $this->db->prepare("SELECT * FROM users WHERE kelompok = ? AND role = 'mentee'");
            $statement->bind_param('i', $kelompok);
            $statement->execute();

            return $statement->get_result();
        }

        return null;
    }

    public function getListKelompokMentor(){
        $listKelompokMentor = $this->db->query("SELECT * FROM users WHERE role='mentor' ORDER BY kelompok ASC");
        
        return $listKelompokMentor;
    }

    public function getListKelompokMentee(){
        $listKelompokMentee = $this->db->query("SELECT * FROM users WHERE role='mentee' ORDER BY kelompok ASC");
        
        return $listKelompokMentee;
    }

}