<?php

class Mentoring{

     private $db;
    private $dbh;

    public function __construct(){
        $this->dbh = new Connection;
        $this->db = $this->dbh->getConn();
    }

    public function listMateri(){
        $listMateri = $this->db->query('SELECT id, kelompok, jadwal, nama_pertemuan, materi FROM pertemuan');
        return $listMateri;
    }

    public function detail($id){
        $statement = $this->db->prepare('SELECT materi FROM pertemuan WHERE id = ?');
        $statement->bind_param('i', $id);
        $statement->execute();

        return $statement->get_result()->fetch_assoc();
    }

    public function tambah($data, $status){
       
        $jadwal = htmlspecialchars(trim(date('Y-m-d', strtotime($data['jadwal']))));
        $nama_pertemuan = htmlspecialchars(trim($data['nama_pertemuan']));
        $kelompok = htmlspecialchars(trim($data['kelompok']));
        $materi = htmlspecialchars(trim($data['materi']));
       
        $statement =$this->db->prepare("INSERT INTO pertemuan (jadwal, nama_pertemuan, kelompok, materi) 
                                  VALUES (?, ?, ?, ?)");
            if (!$statement) {
                echo "false";
            }
            else {
                $statement->bind_param("ssss", $jadwal, $nama_pertemuan, $kelompok,  $materi);
                $statement->execute();
                $statement->close();
                if($this->db->commit() == true){
                    $_SESSION['berhasil'] = "Selamat, berhasil menambahkan materi";
                }
                else{
                    $_SESSION['gagal'] = "Maaf, tidak berhasil menambahkan materi";
                }
            }

        
        if($status === 'mentor'){
            header("Location: ".BASEURL."/views/mentoring/index.php");  
        }
       
                
    }

    public function delete($id){
        $statement = $this->db->prepare('DELETE FROM pertemuan WHERE id = ?');
        $statement->bind_param('i', $id);
        $statement->execute();
        
        if($this->db->affected_rows > 0){
            $_SESSION['berhasil'] = 'Data berhasil dihapus';
        }
        else{
            $_SESSION['gagal'] = 'Data gagal dihapus';
        }
        $statement->close();
        header('Location: '.BASEURL.'/views/mentoring');
    }



}