<?php

class Auth{

    private $db;
    private $dbh;

    public function __construct(){
        $this->dbh = new Connection;
        $this->db = $this->dbh->getConn();
    }

    public function registrasi($data, $status){
        $nim = htmlspecialchars(trim($data['nim']));
        $nama = htmlspecialchars(trim(ucwords(strtolower($data['nama']))));
        $jenis_kelamin = htmlspecialchars(trim($data['jenis_kelamin']));
        $tempat_lahir = htmlspecialchars(trim(ucwords(strtolower($data['tempat_lahir']))));
        $tanggal_lahir = htmlspecialchars(trim(date('Y-m-d', strtotime($data['tanggal_lahir']))));
        $email = htmlspecialchars(trim($data['email']));
        $no_hp = htmlspecialchars(trim($data['no_hp']));
        $jurusan = htmlspecialchars(trim(ucwords(strtolower($data['jurusan']))));
        $password = password_hash('12345', PASSWORD_BCRYPT);

        try{
            $this->db->begin_transaction();

            $statement = $this->db->prepare('SELECT nim FROM users WHERE nim = ?');
            $statement->bind_param('i', $nim);
            $statement->execute();

            if($statement->get_result()->num_rows > 0){
                $_SESSION['gagal'] = "Anda sudah terdaftar";
            }
            else{
                $statement = $this->db->prepare('INSERT INTO users VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, NULL, ?)');
                $statement->bind_param('isssssssss', $nim, $nama, $jenis_kelamin, $tempat_lahir, $tanggal_lahir, $email, $no_hp, $jurusan, $status, $password);
                $statement->execute();

                $statement->close();
                if($this->db->commit() == true){
                    $_SESSION['berhasil'] = "Selamat, pendaftaran berhasil";
                }
                else{
                    $_SESSION['gagal'] = "Maaf, pendaftaran tidak berhasil";
                }
            }
        }   
        catch(Exception $e){
            $this->db->rollback();
            $_SESSION['gagal'] = "Proses gagal";
        }   

        if($status === 'mentee'){
            header("Location: ".BASEURL."/views/auth/register-mentee.php");  
        }
        elseif($status === 'mentor'){
            header("Location: ".BASEURL."/views/auth/register-mentor.php");  
        }
    }

    public function login($data){
        $nim = intval(htmlspecialchars(trim($data['nim'])));
        $password = htmlspecialchars($data['password']);

        try{
            $statement = $this->db->prepare('SELECT * FROM users WHERE nim = ?');
            $statement->bind_param('i', $nim);
            $statement->execute();
            $resultSet = $statement->get_result();

            if($resultSet->num_rows > 0){
                $result = $resultSet->fetch_assoc();
                if(password_verify($password, $result['password'])){
                    $_SESSION['user']['nim'] = $result['nim'];
                    $_SESSION['user']['nama'] = $result['nama'];
                    $_SESSION['user']['role'] = $result['role'];
                    header('Location: '.BASEURL.'/views');
                }
                else{
                    $_SESSION['gagal'] = 'Username/Password salah';
                }
            }
            else{
                $_SESSION['gagal'] = 'Anda belum terdaftar';
            }
            
            $statement->close();
        }
        catch(Exception $e){
            $this->db->rollback();
            $_SESSION['gagal'] = "Proses gagal";
        }

        if(isset($_SESSION['gagal'])){
            header('Location: '.BASEURL.'/views/auth/login.php');
        }
    }

    public function logout(){
        session_reset();
        session_unset();
        session_destroy();
        header('Location: '.BASEURL.'/views/auth/login.php');
    }

    public function getProfil(){
        $statement = $this->db->prepare('SELECT nim, nama, jenis_kelamin, tempat_lahir, tanggal_lahir,
                                email, no_hp, jurusan, role FROM users WHERE nim = ?');
        $statement->bind_param('i', $_SESSION['user']['nim']);
        $statement->execute();
        return $statement->get_result()->fetch_assoc();
    }

    public function changePass($data){
        $password = htmlspecialchars(password_hash($data['password'], PASSWORD_BCRYPT));
        
        $statement = $this->db->prepare('UPDATE users SET password = ?  WHERE nim = ?');
        $statement->bind_param('si', $password, $_SESSION['user']['nim']);
        $statement->execute();

        if($this->db->affected_rows > 0){
            $_SESSION['berhasil'] = 'Password berhasil diganti';
        }
        else{
            $_SESSION['gagal'] = 'Password gagal diganti';
        }

        $statement->close();
        header('Location: '.BASEURL.'/views/auth/profil.php');
    }

}