<?php
session_start();
require_once '../../config.php';
require_once '../../controller/auth.php';
require_once '../../controller/pendaftaran.php';

if(!isset($_SESSION['user'])){
    header('Location: '.BASEURL.'/views/auth/login.php');
}

$pendaftaran = new Pendaftaran;
if(isset($_GET['nim'])){
    $profil = $pendaftaran->detail($_GET['nim']);
}

$title = 'Mentoring | Detail '.ucwords($profil['role']);
$menu = 'Pendaftaran';
require_once '../layout/header.php';


?>

<div class="row">
    <div class="col-lg-7 col-md-9 col-sm-12">
        <div class="card mx-2">
            <div class="card-body">
                <h3 class="role-header mb-5">Informasi <?= ucwords($profil['role']) ?></h3>
                <div class="row">
                    <div class="col-4">
                        <p class="mb-3">Nama</p>
                        <p class="mb-3">Nim</p>
                        <p class="mb-3">No. Hp</p>
                        <p class="mb-3">Jenis Kelamin</p>
                        <p class="mb-3">Tempat/Tanggal Lahir</p>
                        <p class="mb-3">Email</p>
                        <p class="mb-3">Jurusan</p>
                        <p class="mb-3">Status</p>
                    </div>
                    <div class="col-8">
                        <p class="mb-3">: <?= $profil['nama'] ?></p>
                        <p class="mb-3">: <?= $profil['nim'] ?></p>
                        <p class="mb-3">: <?= $profil['no_hp'] ?></p>
                        <p class="mb-3">: <?= ($profil['jenis_kelamin'] === 'L') ? 'Laki-laki' : 'Perempuan' ?></p>
                        <p class="mb-3">: <?= $profil['tempat_lahir'].'/'.date('d-m-Y', strtotime($profil['tanggal_lahir'])) ?></p>
                        <p class="mb-3">: <?= $profil['email'] ?></p>
                        <p class="mb-3">: <?= $profil['jurusan'] ?></p>
                        <p class="mb-3">: <?= ucwords($profil['role']) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php require_once '../layout/footer.php' ?>