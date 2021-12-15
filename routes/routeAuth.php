<?php
session_start();

require_once '../config.php';
require_once '../controller/auth.php';

$auth = new Auth;
if(isset($_POST['masuk'])){
      $auth->login($_POST);
}
elseif(isset($_POST['daftar-mentee'])){
      $auth->registrasi($_POST, 'mentee');
}
elseif(isset($_POST['daftar-mentor'])){
      $auth->registrasi($_POST, 'mentor');
}
elseif(isset($_POST['logout'])){
      $auth->logout();
      header('Location: '.BASEURL.'/views/auth/login.php');
}