<?php
session_start();
require_once '../config.php';
require_once '../controller/auth.php';
require_once '../controller/pendaftaran.php';

if(!isset($_SESSION['user'])){
    header('Location: '.BASEURL.'/views/auth/login.php');
}

$pendaftaran = new Pendaftaran;
$countMentor = $pendaftaran->countMentor()['countMentor'];
$countMentee = $pendaftaran->countMentee()['countMentee'];

$menu = 'Dashboard';
$title = 'Mentoring | Dashboard';
require_once 'layout/header.php';
?>

<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card mx-2">
            <div class="card-body">
                <h3>Mentor</h3>
                <h2 class="d-flex justify-content-end" style="color: #1C4185; font-family: 'Poppins', sans-serif;"><?= $countMentor ?></h2>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card mx-2">
            <div class="card-body">
                <h3>Mentee</h3>
                <h2 class="d-flex justify-content-end" style="color: #1C4185; font-family: 'Poppins', sans-serif;"><?= $countMentee ?></h2>
            </div>
        </div>
    </div>
</div>

<?php require_once 'layout/footer.php' ?>