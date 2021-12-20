<?php

class Ujian{

    private $db;
    private $dbh;

    public function __construct(){
        $this->dbh = new Connection;
        $this->db = $this->dbh->getConn();
    }

    public function listUjian(){
        $ujian = $this->db->query('SELECT * FROM ujian');
        return $ujian;
    }

    public function tambahUjian($data){
        $jadwal = htmlspecialchars(trim(date('Y-m-d H:i:s', strtotime($data['tanggal'].' '.$data['waktu']))));
        $durasi = htmlspecialchars(trim($data['durasi']));

        $statement = $this->db->prepare("INSERT INTO ujian VALUES('', ?, ?)");
        $statement->bind_param('si', $jadwal, $durasi);
        $statement->execute();

        if($this->db->affected_rows > 0){
            $_SESSION['berhasil'] = 'Ujian berhasil ditambahkan';
        }
        else{
            $_SESSION['gagal'] = 'Ujian gagal ditambahkan';
        }

        $statement->close();
        header('Location: '.BASEURL.'/views/ujian');
    }

    public function tambahSoal(){
        
    }

}