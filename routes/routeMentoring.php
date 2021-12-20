<?php
session_start();

require_once '../config.php';
require_once '../controller/mentoring.php';

$mentoring = new Mentoring;
if(isset($_POST['hapus'])){
    $mentoring->delete($_POST['id']);
}
else if(isset($_POST['tambah-materi'])){
    $mentoring->tambah($_POST, 'mentor');
}
// else if(isset($_POST['bagi-kelompok-mentee'])){
//     $pendaftaran->gachaGroup($_POST['numberGroup'], 'mentee');
// }
