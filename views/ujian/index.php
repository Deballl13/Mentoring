<?php
session_start();
require_once '../../config.php';
require_once '../../controller/auth.php';
require_once '../../controller/ujian.php';

if(!isset($_SESSION['user'])){
    header('Location: '.BASEURL.'/views/auth/login.php');
}

$ujian = new Ujian;
$listUjian = $ujian->listUjian();
$getPostingUjian = $ujian->getPosting();

if(isset($_GET['id'])){
    $doExam = $ujian->doExam($_GET['id']);
}

$title = 'Mentoring | Ujian';
$menu = 'Ujian';
require_once '../layout/header.php';

?>

<h3 class="role-header mt-4 mx-2 mb-4">Ujian</h3>
<?php if($_SESSION['user']['role'] === 'mentor'): ?>
<button type="button" class="btn btn-primary mx-2 mb-4" data-bs-toggle="modal" data-bs-target="#exampleModal" data-toggle="modal" data-target="#modalTambahUjian">
Tambah ujian
</button>
<?php endif ?>

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
    <?php if($_SESSION['user']['role'] === 'mentor'): ?>
    <?php foreach($listUjian as $lu): ?>
    <div class="col-lg-4 col-md-6 col-sm-6 mt-3">
        <div class="card mx-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-2">
                        <p style="background-color: #dee5fc; width: 50px; height: 45px; border-radius: 10px; font-size: 20px;" class="d-flex justify-content-center align-items-center">
                            <i class="mdi mdi-clipboard-text"></i>
                        </p>
                    </div>
                    <div class="col-10">
                        <h6>
                            <a href="<?= BASEURL ?>/views/ujian/detail.php?id=<?= $lu['id'] ?>" class="text-dark">Ujian tulis mentoring</a>
                        </h6>
                        <p style="color: #1C4185; font-family: 'Poppins', sans-serif; font-size: 15px;">
                            <?= date('d-m-Y, H:i', strtotime($lu['tanggal'])) ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach ?>
    <?php endif ?>

    <?php if($_SESSION['user']['role'] === 'mentee'): ?>
    <?php foreach($getPostingUjian as $lu): ?>
    <div class="col-lg-4 col-md-6 col-sm-6 mt-3">
        <div class="card mx-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-2">
                        <p style="background-color: #dee5fc; width: 50px; height: 45px; border-radius: 10px; font-size: 20px;" class="d-flex justify-content-center align-items-center">
                            <i class="mdi mdi-clipboard-text"></i>
                        </p>
                    </div>
                    <div class="col-10">
                        <h6>
                            <?php 
                            $hours = floor($lu['durasi'] / 60);
                            $minutes = floor($lu['durasi'] - 60) >= 0 ? $lu['durasi'] - 60 : $lu['durasi'];
                            $endExam = new DateTime($lu['tanggal']);
                            $endExam->modify('+'.$hours.' hour');
                            $endExam->modify('+'.$minutes.' minute');
                            
                            if(date('d-m-Y, H:i') >= date('d-m-Y, H:i', strtotime($lu['tanggal'])) && date('d-m-Y, H:i') <= $endExam->format('d-m-Y, H:i')): ?>
                            <a href="?id=<?= $lu['id'] ?>" class="text-dark" onclick="return confirm('sudah siap untuk ujian?')" >Ujian tulis mentoring</a>
                            <?php else: ?>
                            <a href="#" class="text-dark" data-bs-toggle="modal" data-bs-target="#modalNotifikasi" data-toggle="modal" data-target="#modalNotifikasi">Ujian tulis mentoring</a>
                            <?php endif ?>
                        </h6>
                        <p style="color: #1C4185; font-family: 'Poppins', sans-serif; font-size: 15px;">
                            <?= date('d-m-Y, H:i', strtotime($lu['tanggal'])) ?>
                        </p>
                        <a href="#" class="mt-4" data-bs-toggle="modal" data-bs-target="#modalNilai" data-toggle="modal" data-target="#modalNilai-<?= $lu['id'] ?>">Lihat nilai</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach ?>
    <?php endif ?>
</div>

<!-- Modal -->
<div class="modal fade" id="modalTambahUjian" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Tambah Ujian</h3>
            </div>
            <div class="modal-body">
                <form action="<?= BASEURL ?>/routes/routeUjian.php" method="post">
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" id="tanggal" placeholder="Masukkan Tanggal Ujian">
                    </div>
                    <div class="form-group">
                        <label for="waktu">Waktu</label>
                        <input type="time" class="form-control" name="waktu" id="waktu" placeholder="Masukkan Waktu Ujian">
                    </div>
                    <div class="form-group">
                        <label for="durasi">Durasi</label>
                        <input type="number" class="form-control" name="durasi" id="durasi" placeholder="Masukkan Pertemuan ke">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">Reset</button>
                <button type="submit" name="tambah-ujian" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalNotifikasi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Notifikasi</h3>
            </div>
            <div class="modal-body">
                <p>Maaf, kamu belum bisa mengerjakan ujian ini</p>
            </div>
        </div>
    </div>
</div>

<?php if($_SESSION['user']['role'] === 'mentee'): ?>
<?php foreach($getPostingUjian as $lu): ?>
<div class="modal fade" id="modalNilai-<?= $lu['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Notifikasi</h3>
            </div>
            <div class="modal-body">
                <p>Nilai kamu : <?= ($lu['nilai'] === null) ? '0' : $lu['nilai'] ?></p>
            </div>
        </div>
    </div>
</div>
<?php endforeach ?>
<?php endif ?>

<?php require_once '../layout/footer.php' ?>