<?php

class Pendaftaran{

     private $db;
    private $dbh;

    public function __construct(){
        $this->dbh = new Connection;
        $this->db = $this->dbh->getConn();
    }

    public function listMentor(){
        $mentor = $this->db->query('SELECT nim, nama, jenis_kelamin, tempat_lahir, tanggal_lahir,
                                email, no_hp, jurusan, role FROM users WHERE role = "mentor" AND kelompok IS NULL');
        return $mentor;
    }

    public function listMentee(){
        $mentee = $this->db->query('SELECT nim, nama, jenis_kelamin, tempat_lahir, tanggal_lahir,
                                email, no_hp, jurusan, role FROM users WHERE role = "mentee" AND kelompok IS NULL');
        return $mentee;
    }

    public function detail($nim){
        $statement = $this->db->prepare('SELECT nim, nama, jenis_kelamin, tempat_lahir, tanggal_lahir,
                                email, no_hp, jurusan, role FROM users WHERE nim = ?');
        $statement->bind_param('i', $nim);
        $statement->execute();

        return $statement->get_result()->fetch_assoc();
    }

    public function delete($nim){
        $statement = $this->db->prepare('DELETE FROM users WHERE nim = ?');
        $statement->bind_param('i', $nim);
        $statement->execute();
        
        if($this->db->affected_rows > 0){
            $_SESSION['berhasil'] = 'Data berhasil dihapus';
        }
        else{
            $_SESSION['gagal'] = 'Data gagal dihapus';
        }
        $statement->close();
        header('Location: '.BASEURL.'/views/pendaftaran');
    }

    public function countMentor(){
        $mentor = $this->db->query('SELECT COUNT(*) AS countMentor FROM users WHERE role = "mentor"');
        return $mentor->fetch_assoc();
    }

    public function countMentee(){
        $mentee = $this->db->query('SELECT COUNT(*) AS countMentee FROM users WHERE role = "mentee"');
        return $mentee->fetch_assoc();
    }

    public function gachaGroup($number, $status){
        try{
            $this->db->begin_transaction();
            $statement = $this->db->prepare('SELECT * FROM users WHERE role = ?');
            $statement->bind_param('s', $status);
            $statement->execute();
            $result = $statement->get_result();
            
            foreach($result as $r){
                $statement = $this->db->prepare('UPDATE users SET kelompok = ? WHERE nim = ?');
                $statement->bind_param('ii', random_int(1,$number), $r['nim']);
                $statement->execute();

                if($this->db->commit() == true){
                    $_SESSION['berhasil'] = "Pembagian kelompok mentor berhasil";
                }
                else{
                    $_SESSION['gagal'] = "Pembagian kelompok mentor gagal";
                }
            }
        }
        catch(Exception $e){
            $this->db->rollback();
            $_SESSION['gagal'] = "Proses gagal";
        }

        header("Location: ".BASEURL."/views/pendaftaran");  
    }

}