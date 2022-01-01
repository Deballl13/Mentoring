<?php
session_start();

require_once '../config.php';
require_once '../controller/mentoring.php';

$mentoring = new Mentoring;
if(isset($_POST['hapus'])){
    $mentoring->deletePertemuan($_POST['id']);
}
else if(isset($_POST['tambah-materi'])){
    $mentoring->tambahPertemuan($_POST, 'mentor');
}
else if(isset($_POST['submit-presensi'])){
    $mentoring->submitPresensi($_POST);
}
