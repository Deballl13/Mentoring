<?php
  session_start();
  require_once '../../config.php';
  
  if(isset($_SESSION['user'])){
    header('Location: '.BASEURL.'/views');
  }

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login</title>
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
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light shadow-lg text-left py-5 px-4 px-sm-5">
              <h3>Selamat datang di mentoringFTI</h3>
              <h4 class="font-weight-light">Silahkan login ke akun anda</h4>
              <form method="POST" action="<?= BASEURL ?>/routes/routeAuth.php" class="pt-3">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="exampleInputNim" placeholder="Username" id="nim" name="nim">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password" id="password" name="password">
                </div>

                    <?php if(isset($_SESSION['logout'])): ?>
                    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                        </symbol>
                    </svg>
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2 mr-3" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                        <div><?= $_SESSION['logout'] ?></div>
                    </div>

                    <?php unset($_SESSION['logout']); elseif(isset($_SESSION['gagal'])): ?>
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
                    
                  <div class="mt-3">
                  <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" name="masuk" type="submit">MASUK</button>
                </div>
              </form>
            </div>
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
