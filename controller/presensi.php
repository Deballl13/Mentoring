<?php

class Presensi{

    private $db;
    private $dbh;

    public function __construct(){
        $this->dbh = new Connection;
        $this->db = $this->dbh->getConn();
    }

    public function listPresensi(){
        $listPresensi = $this->db->query('SELECT * FROM presensi');
        return $listPresensi;
    }

    public function detailPeserta(){
        $detailPeserta = $this->db->query('SELECT * FROM peserta WHERE id = ?');
        return $detailPeserta;
    }


    public function detailPresensi($id){
        $statement = $this->db->prepare('SELECT pertemuan_ke, materi FROM pertemuan WHERE id = ?');
        $statement->bind_param('i', $id);
        $statement->execute();

        return $statement->get_result()->fetch_assoc();
    }

    public function tambahPresensi($data){
        $tanggal = htmlspecialchars(trim(date('Y-m-d', strtotime($data['tanggal']))));
        $waktu = htmlspecialchars(trim(date('H:i:s', strtotime($data['waktu']))));
        $pertemuan_ke = htmlspecialchars(trim($data['pertemuan_ke']));
        $materi = htmlspecialchars(trim($data['materi']));
        
        try{
            $this->db->begin_transaction();

            $statement = $this->db->prepare('SELECT kelompok FROM users WHERE nim = ?');
            $statement->bind_param('i', $_SESSION['user']['nim']);
            $statement->execute();
            $kelompok = $statement->get_result()->fetch_assoc()['kelompok'];

            $statement =$this->db->prepare("INSERT INTO pertemuan VALUES ('', ?, ?, ?, ?, ?)");
            $statement->bind_param("issss", $kelompok, $tanggal, $pertemuan_ke, $waktu, $materi);
            $statement->execute();
        
            if($this->db->commit() == true){
                $_SESSION['berhasil'] = "Selamat, berhasil menambahkan materi";
            }
            else{
                $_SESSION['gagal'] = "Maaf, tidak berhasil menambahkan materi";
            }
        }
        catch(Exception $e){
            $this->db->rollback();
            $_SESSION['gagal'] = "Proses gagal";
        } 

        $statement->close();
        header("Location: ".BASEURL."/views/mentoring");  
    }

    public function deletePertemuan($id){
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

    public function listPresensiPeserta($id){
        $statement = $this->db->prepare('SELECT presensi.id, pertemuan.pertemuan_ke, presensi.status_kehadiran, presensi.waktu, users.nama, users.kelompok FROM presensi INNER JOIN users ON users.nim = presensi.nim_peserta INNER JOIN pertemuan ON presensi.id_pertemuan = pertemuan.id WHERE pertemuan.id = ? GROUP BY users.kelompok ORDER BY users.kelompok ASC');
        $statement->bind_param('i', $id);
        $statement->execute();

        return $statement->get_result();
    }
}