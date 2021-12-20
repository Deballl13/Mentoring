<?php
session_start();

require_once '../config.php';
require_once '../controller/ujian.php';

$ujian = new Ujian;

if(isset($_POST['tambah-ujian'])){
    $ujian->tambahUjian($_POST);
}