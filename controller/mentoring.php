<?php

class Mentoring{

    private $db;
    private $dbh;

    public function __construct(){
        $this->dbh = new Connection;
        $this->db = $this->dbh->getConn();
    }

    public function listPertemuan(){
        $listMateri = $this->db->query('SELECT * FROM pertemuan');
        return $listMateri;
    }

    public function detailPertemuan($id){
        $statement = $this->db->prepare('SELECT id, pertemuan_ke, materi FROM pertemuan WHERE id = ?');
        $statement->bind_param('i', $id);
        $statement->execute();

        return $statement->get_result()->fetch_assoc();
    }

    public function lihatPresensi($id){
        $statement = $this->db->prepare('SELECT presensi.id, pertemuan.pertemuan_ke, presensi.status_kehadiran, presensi.waktu, users.nama, users.kelompok FROM presensi INNER JOIN users ON users.nim=presensi.nim_peserta INNER JOIN pertemuan ON presensi.id_pertemuan=pertemuan.id_pertemuan  WHERE id_pertemuan = ?');
        // $statement = $this->db->prepare('SELECT * pertemuan.pertemuan_ke, users.nama, users.kelompok FROM presensi INNER JOIN users ON users.nim=presensi.nim_peserta INNER JOIN pertemuan ON presensi.id_pertemuan=pertemuan.id_pertemuan  WHERE id_pertemuan = ?');
       
        // return $lihatPresensi;
        $statement->bind_param('i', $id);
        $statement->execute();

        return $statement->get_result()->fetch_assoc();
    }

    public function tambahPertemuan($data){
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

    public function submitPresensi ($data){
        $nim_peserta = htmlspecialchars(trim($data['nim_peserta']));
        $id_pertemuan = htmlspecialchars(trim($data['id_pertemuan']));
        $status_kehadiran = htmlspecialchars(trim($data['status_kehadiran']));
        $waktu = htmlspecialchars(trim(date('Y-m-d H:i:s', strtotime($data['tanggal'].' '.$data['jam']))));
        $sholat_fardhu_berjamaah = htmlspecialchars(trim($data['sholat_fardhu_berjamaah']));
        $qiyamul_lail = htmlspecialchars(trim($data['qiyamul_lail']));
        $sholat_dhuha = htmlspecialchars(trim($data['sholat_dhuha']));
        $sholat_rawatib = htmlspecialchars(trim($data['sholat_rawatib']));
        $tilawah_quran = htmlspecialchars(trim($data['tilawah_quran']));
        $infaq = htmlspecialchars(trim($data['infaq']));
        $olahraga = htmlspecialchars(trim($data['olahraga']));
        $baca_buku = htmlspecialchars(trim($data['baca_buku']));
        $kegiatan_ukhuwah = htmlspecialchars(trim($data['kegiatan_ukhuwah']));
        
        $statement =$this->db->prepare("INSERT INTO presensi (nim_peserta, id_pertemuan, status_kehadiran, waktu, sholat_fardhu_berjamaah, qiyamul_lail, sholat_dhuha, sholat_rawatib, tilawah_quran, infaq, olahraga, baca_buku, kegiatan_ukhuwah) 
                                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            if (!$statement) {
                echo "false";
            }
            else {
                $statement->bind_param("sssssssssssss", $nim_peserta, $id_pertemuan, $status_kehadiran,  $waktu, $sholat_fardhu_berjamaah, $qiyamul_lail, $sholat_dhuha, $sholat_rawatib,  $tilawah_quran, $infaq, $olahraga, $baca_buku, $kegiatan_ukhuwah);
                $statement->execute();
                $statement->close();
                if($this->db->commit() == true){
                    $_SESSION['berhasil'] = "Selamat, berhasil menambahkan presensi";
                }
                else{
                    $_SESSION['gagal'] = "Maaf, tidak berhasil menambahkan presensi";
                }
            }


        
            header("Location: ".BASEURL."/views/mentoring/index.php");  
        
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



}