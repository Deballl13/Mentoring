<?php
session_start();

require_once '../config.php';
require_once '../controller/ujian.php';

$ujian = new Ujian;

if(isset($_POST['tambah-ujian'])){
    $ujian->tambahUjian($_POST);
}
else if(isset($_POST['post-ujian'])){
    $ujian->posting($_POST['id']);
}
else if(isset($_POST['delete-ujian'])){
    $ujian->delete($_POST['id']);
}
else if(isset($_POST['submit_soal']) && isset($_GET['id'])){
    $ujian->tambahSoal($_POST, $_GET['id']);
}
else if(isset($_POST['submit_jawaban']) && isset($_GET['id'])){
    $ujian->submitJawaban($_POST, $_GET['id']);
}
else if(isset($_POST['submit_nilai']) && isset($_GET['id']) && isset($_GET['nim'])){
    $ujian->tambahNilaiSubmission($_POST, $_GET['id'], $_GET['nim']);
}
else if(isset($_GET['id'])){
    $ujian->submitJawaban($_POST, $_GET['id']);
}