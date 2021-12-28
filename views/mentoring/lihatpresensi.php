<?php
session_start();
require_once '../../config.php';
require_once '../../controller/auth.php';
require_once '../../controller/mentoring.php';

if(!isset($_SESSION['user'])){
    header('Location: '.BASEURL.'/views/auth/login.php');
}

$mentoring = new Mentoring;
$lihatPresensi = $mentoring->lihatPresensi();

if(isset($_GET['id'])){
    $detailPertemuan = $mentoring->detailPertemuan($_GET['id']);
}

$title = 'Mentoring | Mentoring';
$menu = 'Mentoring';
require_once '../layout/header.php';

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



<div class="row mt-4">
    <div class="col-lg-11 col-md-12 col-sm-12">
        <div class="card mx-2">
            <div class="card-body">
                <h3 class="role-header mb-5">Presensi Mentoring</h3>
                <?php if($_SESSION['user']['role'] === 'mentor'): ?>
                <!-- <a class="btn btn-primary mb-4" href="<?= BASEURL ?>/views/mentoring/tambah.php">Tambah</a> -->
                <?php endif ?>
                <table id="listMateri" class="display" style="width:100%">
                    <thead>
                        <tr class="text-center">
                            <th>No.</th>
                            <th>Kelompok</th>
                            <th>Pertemuan Ke</th>
                            <th>Nama</th>
                            <th>Status Kehadiran</th>                        
                            <th>Waktu</th>
                            <
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach($lihatPresensi as $lp): ?>
                        <tr class="text-center">
                            <td><?= $i++.'.' ?></td>
                            <td><?= $lp['kelompok'] ?></td>
                            <td><?= $lp['pertemuan'] ?></td>
                            <td><?= $lp['nama'] ?></td>
                            <td><?= $lp['status_kehadiran'] ?></td>
                            <td><?= $lp['waktu'] ?></td>                            
                            
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?php require_once '../layout/footer.php' ?>
<script>
    $(document).ready(function() {
        $('#listMateri').DataTable({
            "ordering": false,
            "info":     false
        });
    } );
</script>