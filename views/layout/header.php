<?php

    $auth = new Auth;
    if(isset($_POST['logout'])){
        $auth->logout();
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $title ?></title>
    <!-- base:css -->
    <link rel="stylesheet" href="<?= BASEURL ?>/public/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?= BASEURL ?>/public/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="<?= BASEURL ?>/public/css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="<?= BASEURL ?>/public/images/favicon.png" />

    <!-- datatables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

    <!-- my css -->
    <link rel="stylesheet" href="<?= BASEURL ?>/public/css/my-style.css">

    <!-- google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container-scroller d-flex">
        <!-- partial:./partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                <li class="nav-item mt-3">
                    <a class="nav-link" href="<?= BASEURL ?>/views">
                        <svg width="25" height="17" viewBox="0 0 20 17" fill="none" xmlns="http://www.w3.org/2000/svg" class="mt-n1">
                            <path d="M10 2.253C11.168 1.477 12.754 1 14.5 1C16.247 1 17.832 1.477 19 2.253V15.253C17.832 14.477 16.247 14 14.5 14C12.754 14 11.168 14.477 10 15.253M10 2.253V15.253V2.253ZM10 2.253C8.832 1.477 7.246 1 5.5 1C3.754 1 2.168 1.477 1 2.253V15.253C2.168 14.477 3.754 14 5.5 14C7.246 14 8.832 14.477 10 15.253V2.253Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="menu-title ml-3">
                            <h3>mentoringFTI</h3>
                        </span>
                    </a>
                </li>
                <li class="nav-item mt-5 <?= ($menu==='Dashboard') ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= BASEURL ?>/views">
                        <i class="mdi mdi-view-dashboard menu-icon"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item <?= ($menu==='Ujian') ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= BASEURL ?>/views/ujian">
                        <i class="mdi mdi-file-document menu-icon"></i>
                        <span class="menu-title">Ujian</span>
                    </a>
                </li>
                <li class="nav-item <?= ($menu==='Mentoring') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= BASEURL ?>/views/mentoring">
                        <i class="mdi mdi mdi-account-multiple menu-icon"></i>
                        <span class="menu-title">Mentoring</span>
                    </a>
                </li>
                <?php if($_SESSION['user']['role'] !== 'bpmai' ): ?>
                <li class="nav-item <?= ($menu==='Kelompok Mentoring') ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= BASEURL ?>/views/kelompok">
                        <i class="mdi mdi-account-group menu-icon"></i>
                        <span class="menu-title">Kelompok Mentoring</span>
                    </a>
                </li>
                <?php endif ?>
                <?php if($_SESSION['user']['role'] === 'mentor' ||$_SESSION['user']['role'] === 'bpmai' ): ?>
                <li class="nav-item <?= ($menu==='Pendaftaran') ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= BASEURL ?>/views/pendaftaran">
                        <i class="mdi mdi-folder-account menu-icon"></i>
                        <span class="menu-title">Pendaftaran</span>
                    </a>
                </li>
                <?php endif ?>
            </ul>
        </nav>

        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:./partials/_navbar.html -->
            <nav class="navbar col-lg-12 col-12 px-0 py-0 py-lg-4 d-flex flex-row">
                <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                    <button class="navbar-toggler align-self-center mt-2 navbar-nav-left" type="button" data-toggle="minimize">
                        <span class="mdi mdi-menu"></span>
                    </button>
                    <h2 class="ml-3 mb-0 d-none d-md-block mt-1" style="font-family: 'Open Sans', sans-serif;">Selamat datang</h2>
                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item">
                        <h3 class="mb-0 font-weight-bold d-none d-xl-block" id="datetime" style="font-family: 'Open Sans', sans-serif;"><!-- Tanggal dan waktu --></h3>
                        </li>
                    </ul>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas" >
                        <span class="mdi mdi-menu"></span>
                    </button>
                </div>
                <div class="navbar-menu-wrapper navbar-search-wrapper d-none d-lg-flex align-items-center">
                    <ul class="navbar-nav mr-lg-2">
                        <li class="nav-item nav-search d-none d-lg-block">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search Here..." aria-label="search" aria-describedby="search" style="font-family: 'Open Sans', sans-serif;">
                            </div>
                        </li>
                    </ul>
                    <ul class="navbar-nav navbar-nav-right mr-5">
                        <li class="nav-item nav-profile dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                                <img src="<?= BASEURL ?>/public/images/faces/avatar.jpg" alt="profile"/>
                                <span class="nav-profile-name" style="font-family: 'Open Sans', sans-serif;"><?= $_SESSION['user']['nama'] ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                                <a class="dropdown-item" href="<?= BASEURL ?>/views/auth/profil.php">
                                    <i class="mdi mdi-account text-primary"></i>
                                    Profil
                                </a>
                                <form method="post" action="<?= BASEURL ?>/routes/routeAuth.php">
                                    <button class="dropdown-item" name="logout" type="submit">
                                        <i class="mdi mdi-logout text-primary"></i>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="container-fluid mx-4 mt-5">
            
        
            