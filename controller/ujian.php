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

        $statement = $this->db->prepare("INSERT INTO ujian VALUES('', ?, ?, 0)");
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

    public function tambahSoal($data, $id){
        $soal = $data['soal'];
        $jawaban = $data['jawaban'];
        $bobot_nilai = $data['bobot_nilai'];

        try{
            $this->db->begin_transaction();

            $statement = $this->db->prepare('DELETE FROM soal_ujian WHERE id_ujian = ?');
            $statement->bind_param('i', $id);
            $statement->execute();

            $statement = $this->db->query('SELECT MAX(id) as id FROM soal_ujian');
            $new_id = $statement->fetch_assoc()['id']+1;
            
            for($i=0; $i<count($soal); $i++){
                $statement = $this->db->prepare('INSERT INTO soal_ujian VALUES(?, ?, ?, ?, ?)');
                $statement->bind_param('iissi', $new_id, $id, trim($soal[$i]), trim($jawaban[$i]), trim($bobot_nilai[$i]));
                $statement->execute();
                $new_id++;
            }

            $statement->close();
            if($this->db->commit() == true){
                $_SESSION['berhasil'] = "Soal berhasil ditambah";
            }
            else{
                $_SESSION['gagal'] = "Soal gagal ditambah";
            }
        }
        catch(Exception $e){
            $this->db->rollback();
            $_SESSION['gagal'] = "Proses gagal";
        }

        header('Location: '.BASEURL.'/views/ujian/detail.php?id='.$id);
    }

    public function getPosting(){
        $statement = $this->db->prepare('SELECT ujian.*, SUM(jawaban_ujian.nilai) as nilai FROM ujian INNER JOIN soal_ujian ON ujian.id = soal_ujian.id_ujian LEFT JOIN jawaban_ujian ON soal_ujian.id = jawaban_ujian.id_soal WHERE status = 1 AND jawaban_ujian.nim_peserta = ? OR jawaban_ujian.id_soal IS NULL GROUP BY ujian.id;');
        $statement->bind_param('i', $_SESSION['user']['nim']);
        $statement->execute();

        return $statement->get_result();
    }

    public function getStatus($id){
        $statement = $this->db->prepare('SELECT status FROM ujian WHERE id = ?');
        $statement->bind_param('i', $id);
        $statement->execute();

        return $statement->get_result()->fetch_assoc()['status'];
    }

    public function posting($id){
        $statement = $this->db->prepare('UPDATE ujian SET status = 1 WHERE id = ?');
        $statement->bind_param('i', $id);
        $statement->execute();

        if($this->db->affected_rows > 0){
            $_SESSION['berhasil'] = 'Ujian berhasil diposting';
        }
        else{
            $_SESSION['gagal'] = 'Ujian gagal diposting';
        }

        $statement->close();
        header('Location: '.BASEURL.'/views/ujian/detail.php?id='.$id);
    }

    public function delete($id){
        $statement = $this->db->prepare('DELETE FROM ujian WHERE id = ?');
        $statement->bind_param('i', $id);
        $statement->execute();

        if($this->db->affected_rows > 0){
            $_SESSION['berhasil'] = 'Ujian berhasil dihapus';
        }
        else{
            $_SESSION['gagal'] = 'Ujian gagal dihapus';
        }

        $statement->close();
        header('Location: '.BASEURL.'/views/ujian');
    }

    public function getSoal($id){
        $statement = $this->db->prepare('SELECT * FROM soal_ujian WHERE id_ujian = ?');
        $statement->bind_param('i', $id);
        $statement->execute();

        return $statement->get_result();
    }

    public function getSoalUjian($id){
        $statement = $this->db->prepare('SELECT id, soal, bobot_nilai FROM soal_ujian WHERE id_ujian = ?');
        $statement->bind_param('i', $id);
        $statement->execute();

        return $statement->get_result();
    }

    public function doExam($id){
        try{
            $this->db->begin_transaction();

            $statement = $this->db->prepare('SELECT id FROM soal_ujian WHERE id_ujian = ?');
            $statement->bind_param('i', $id);
            $statement->execute();
            $result = $statement->get_result();

            $valid = true;
            foreach($result as $r){
                $statement = $this->db->prepare('SELECT * FROM jawaban_ujian WHERE nim_peserta = ? AND id_soal = ?');
                $statement->bind_param('ii', $_SESSION['user']['nim'], $r['id']);
                $statement->execute();

                if($statement->get_result()->fetch_assoc() !== null){
                    $valid = false; 
                    break;
                }
            }
            
            if($valid){
                $statement = $this->db->query('SELECT MAX(id) as id FROM jawaban_ujian');
                $new_id = $statement->fetch_assoc()['id']+1;

                foreach($result as $r){
                    $statement = $this->db->prepare("INSERT INTO jawaban_ujian VALUES(?, ?, ?, NULL, NULL)");
                    $statement->bind_param('iii', $new_id, $_SESSION['user']['nim'], $r['id']);
                    $statement->execute();

                    $new_id++;
                }

                $statement->close();
                $this->db->commit();
                header('Location: '.BASEURL.'/views/ujian/progress-ujian.php?id='.$id);
            }
            else{
                $_SESSION['gagal'] = "Kamu sudah mengerjakan ujian ini sebelumnya";
            }
        }
        catch(Exception $e){
            $this->db->rollback();
            $_SESSION['gagal'] = "Proses gagal";
        }
    }

    public function submitJawaban($data, $id){
        $jawaban = $data['jawaban'];

        try{
            $this->db->begin_transaction();
            
            $statement = $this->db->prepare('SELECT id FROM soal_ujian WHERE id_ujian = ?');
            $statement->bind_param('i', $id);
            $statement->execute();
            $result = $statement->get_result();

            $i = 0;
            foreach($result as $r){
                $statement = $this->db->prepare('UPDATE jawaban_ujian SET jawaban = ? WHERE nim_peserta = ? AND id_soal = ?');
                $statement->bind_param('sii', trim($jawaban[$i]), $_SESSION['user']['nim'], $r['id']);
                $statement->execute();
                $i++;
            }

            $statement->close();
            if($this->db->commit() == true){
                $_SESSION['berhasil'] = "Jawaban berhasil disubmit";
            }
            else{
                $_SESSION['gagal'] = "Jawaban berhasil disubmit";
            }
        }
        catch(Exception $e){
            $this->db->rollback();
            $_SESSION['gagal'] = "Proses gagal";
        }
        header('Location: '.BASEURL.'/views/ujian');
    }

    public function getDuration($id){
        $statement = $this->db->prepare('SELECT tanggal, durasi FROM ujian WHERE id = ?');
        $statement->bind_param('i', $id);
        $statement->execute();
        
        return $statement->get_result()->fetch_assoc();
    }

    public function listSubmisson($id){
        $statement = $this->db->prepare('SELECT DISTINCT users.nim, users.nama FROM users INNER JOIN jawaban_ujian ON users.nim = jawaban_ujian.nim_peserta INNER JOIN soal_ujian ON jawaban_ujian.id_soal = soal_ujian.id WHERE soal_ujian.id_ujian = ?');
        $statement->bind_param('i', $id);
        $statement->execute();
        
        return $statement->get_result();
    }

    public function getSubmission($id, $nim){
        $statement = $this->db->prepare('SELECT soal_ujian.soal, soal_ujian.jawaban as kunci_jawaban, soal_ujian.bobot_nilai, jawaban_ujian.* FROM soal_ujian INNER JOIN jawaban_ujian ON soal_ujian.id = jawaban_ujian.id_soal WHERE soal_ujian.id_ujian = ? AND nim_peserta = ? ORDER BY jawaban_ujian.id');
        $statement->bind_param('ii', $id, $nim);
        $statement->execute();

        return $statement->get_result();
    }

    public function tambahNilaiSubmission($data, $id, $nim){
        try{
            $nilai = $data['nilai'];

            $statement = $this->db->prepare('SELECT jawaban_ujian.id FROM soal_ujian INNER JOIN jawaban_ujian ON jawaban_ujian.id_soal = soal_ujian.id WHERE soal_ujian.id_ujian = ? AND jawaban_ujian.nim_peserta = ? ORDER BY jawaban_ujian.id_soal ASC;');
            $statement->bind_param('ii', $id, $nim);
            $statement->execute();

            $i=0;
            foreach($statement->get_result() as $r){
                $statement = $this->db->prepare('UPDATE jawaban_ujian SET nilai = ? WHERE id = ?');
                $statement->bind_param('ii', $nilai[$i], $r['id']);
                $statement->execute();
                $i++;
            }
            
            $statement->close();
            if($this->db->commit() == true){
                $_SESSION['berhasil'] = "Nilai berhasil disubmit";
            }
            else{
                $_SESSION['gagal'] = "Nilai berhasil disubmit";
            }
        }
        catch(Exception $e){
            $this->db->rollback();
            $_SESSION['gagal'] = "Proses gagal";
        }

        header('Location: '.BASEURL.'/views/ujian/detail.php?id='.$id);
    }

}