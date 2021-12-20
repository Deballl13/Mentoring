<?php
session_start();
require_once '../../config.php';
require_once '../../controller/auth.php';

if(!isset($_SESSION['user'])){
    header('Location: '.BASEURL.'/views/auth/login.php');
}

$title = 'Mentoring | Profil';
require_once '../layout/header.php';

$auth  = new Auth;
$profil = $auth->getProfil();
?>

<?php if(isset($_SESSION['berhasil'])): ?>
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </symbol>
    </svg>
    <div class="alert alert-success d-flex align-items-center mx-2 w-75" role="alert">
        <svg class="bi flex-shrink-0 me-2 mr-3" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
        <div><?= $_SESSION['berhasil'] ?></div>
    </div>
    
    <?php unset($_SESSION['berhasil']); elseif(isset($_SESSION['gagal'])): ?>
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
        </symbol>
    </svg>
    <div class="alert alert-danger d-flex align-items-center mx-2 w-75" role="alert">
        <svg class="bi flex-shrink-0 me-2 mr-3" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
        <div><?= $_SESSION['gagal'] ?></div>
    </div>
<?php unset($_SESSION['gagal']); endif; ?>

<div class="row">
    <div class="col-lg-7 col-md-9 col-sm-12">
        <div class="card mx-2">
            <div class="card-body">
                <h3 class="role-header mb-5">Informasi Profil</h3>
                <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#exampleModal" data-toggle="modal" data-target="#exampleModal">
                Ubah Password
                </button>
                <div class="row">
                    <div class="col-4">
                        <p class="mb-3">Nama</p>
                        <p class="mb-3">Nim</p>
                        <p class="mb-3">No. Hp</p>
                        <p class="mb-3">Jenis Kelamin</p>
                        <p class="mb-3">Tempat/Tanggal Lahir</p>
                        <p class="mb-3">Email</p>
                        <p class="mb-3">Jurusan</p>
                        <p class="mb-3">Status</p>
                    </div>
                    <div class="col-8">
                        <p class="mb-3">: <?= $profil['nama'] ?></p>
                        <p class="mb-3">: <?= $profil['nim'] ?></p>
                        <p class="mb-3">: <?= $profil['no_hp'] ?></p>
                        <p class="mb-3">: <?= ($profil['jenis_kelamin'] === 'L') ? 'Laki-laki' : 'Perempuan' ?></p>
                        <p class="mb-3">: <?= $profil['tempat_lahir'].'/'.date('d-m-Y', strtotime($profil['tanggal_lahir'])) ?></p>
                        <p class="mb-3">: <?= $profil['email'] ?></p>
                        <p class="mb-3">: <?= $profil['jurusan'] ?></p>
                        <p class="mb-3">: <?= ucwords($profil['role']) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title mt-2" id="kelompokMentorLabel">Ganti Password</h3>
            </div>
            <div class="modal-body">
                <form action="<?= BASEURL ?>/routes/routeAuth.php" method="post">
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
                    <div class="form-group">
                        <label for="confirm-password">Konfirmasi Password</label>
                        <div class="input-group">
                            <div class="input-group-prepend bg-transparent">
                                <span class="input-group-text bg-transparent border-right-0">
                                    <i class="mdi mdi-lock text-primary"></i>
                                </span>
                            </div>
                            <input type="password" id="confirm-password" name="confirm-password" class="form-control form-control-lg border-left-0" placeholder="Masukkan Konfirmasi Password">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">Reset</button>
                <button type="submit" name="ganti-password" class="btn btn-primary">Ganti</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../layout/footer.php' ?>