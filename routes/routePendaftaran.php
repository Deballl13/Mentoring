<?php
session_start();

require_once '../config.php';
require_once '../controller/pendaftaran.php';

$pendaftaran = new Pendaftaran;
if(isset($_POST['hapus'])){
    $pendaftaran->delete($_POST['nim']);
}
else if(isset($_POST['bagi-kelompok-mentor'])){
    $pendaftaran->gachaGroup($_POST['numberGroup'], 'mentor');
}
else if(isset($_POST['bagi-kelompok-mentee'])){
    $pendaftaran->gachaGroup($_POST['numberGroup'], 'mentee');
}
