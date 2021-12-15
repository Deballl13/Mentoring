<?php
    session_start();
    require_once '../../config.php'; 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Pendaftaran Peserta</title>
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
</head>

<body style="margin-left: -285px">
    <div class="container-scroller d-flex">
        <div class="container-fluid page-body-wrapper full-page-wrapper d-flex">
            <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
                <div class="row flex-grow">
                    <div class="col-lg-6 d-flex align-items-center justify-content-center">
                        <div class="auth-form-transparent text-left p-3 mt-5 pt-5 mb-5">

                            <?php if(isset($_SESSION['berhasil'])): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                </symbol>
                            </svg>
                            <div class="alert alert-success d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2 mr-3" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                                <div><?= $_SESSION['berhasil'] ?></div>
                            </div>
                            
                            <?php unset($_SESSION['berhasil']); elseif(isset($_SESSION['gagal'])): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                </symbol>
                            </svg>
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2 mr-3" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                                <div><?= $_SESSION['gagal'] ?></div>
                            </div>
                            <?php unset($_SESSION['gagal']); endif; ?>

                            <h3>Selamat datang di mentoringFTI</h3>
                            <h4 class="font-weight-light">Daftarkan diri kamu di mentoringFTI</h4>
                            <form method="POST" action="<?= BASEURL ?>/routes/routeAuth.php" class="pt-3">
                                <div class="form-group">
                                    <label class="heading-6" for="nim">Nim</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend bg-transparent">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="mdi mdi-account-card-details text-primary"></i>
                                            </span>
                                        </div>
                                        <input type="text" id="nim" name="nim" class="form-control form-control-lg border-left-0" placeholder="Masukkan Nim">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend bg-transparent">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="mdi mdi-account text-primary"></i>
                                            </span>
                                        </div>
                                        <input type="text" id="nama" name="nama" class="form-control form-control-lg border-left-0" placeholder="Masukkan Nama">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend bg-transparent">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="mdi mdi-gender-male-female text-primary"></i>
                                            </span>
                                        </div>
                                        <select class="form-control form-control-lg border-left-0" id="jenis_kelamin" name="jenis_kelamin">
                                            <option value="">Masukkan pilihan</option>
                                            <option value="L">Laki-laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tempat_lahir">Tempat Lahir</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend bg-transparent">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="mdi mdi-map-marker text-primary"></i>
                                            </span>
                                        </div>
                                        <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control form-control-lg border-left-0" placeholder="Masukkan Tempat Lahir">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend bg-transparent">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="mdi mdi-calendar-today text-primary"></i>
                                            </span>
                                        </div>
                                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control form-control-lg border-left-0">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend bg-transparent">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="mdi mdi-email text-primary"></i>
                                            </span>
                                        </div>
                                        <input type="email" id="email" name="email" class="form-control form-control-lg border-left-0" placeholder="Masukkan Email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="no_hp">No. Hp</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend bg-transparent">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="mdi mdi-cellphone text-primary"></i>
                                            </span>
                                        </div>
                                        <input type="tel" id="no_hp" name="no_hp" class="form-control form-control-lg border-left-0" placeholder="Masukkan No. Hp">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jurusan">Jurusan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend bg-transparent">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="mdi mdi-school text-primary"></i>
                                            </span>
                                        </div>
                                        <input type="text" id="jurusan" name="jurusan" class="form-control form-control-lg border-left-0" placeholder="Masukkan Jurusan">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend bg-transparent">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="mdi mdi-lock text-primary"></i>
                                            </span>
                                        </div>
                                        <input type="password" id="password" name="password" class="form-control form-control-lg border-left-0" placeholder="Masukkan Password">
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form-check">
                                        <label class="form-check-label text-muted">
                                            <input type="checkbox" class="form-check-input">
                                            I agree to all Terms & Conditions
                                        </label>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" type="submit" name="daftar-mentee">DAFTAR</button>
                                </div>
                                <div class="text-center mt-4 font-weight-light">
                                    Already have an account? <a href="login.php" class="text-primary">Login</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6 register-half-bg d-none d-lg-flex flex-row">
                        <p class="text-white font-weight-medium text-center flex-grow align-self-end">Copyright &copy; 2021  Kelompok 2 PPSI.</p>
                    </div>
                </div>
            </div>
        <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- base:js -->
    <script src="<?= BASEURL ?>/public/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="<?= BASEURL ?>/public/js/off-canvas.js"></script>
    <script src="<?= BASEURL ?>/public/js/hoverable-collapse.js"></script>
    <script src="<?= BASEURL ?>/public/js/template.js"></script>
    <!-- endinject -->
</body>

</html>
