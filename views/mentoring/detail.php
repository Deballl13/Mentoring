<?php
session_start();
require_once '../../config.php';
require_once '../../controller/auth.php';
require_once '../../controller/mentoring.php';

if(!isset($_SESSION['user'])){
    header('Location: '.BASEURL.'/views/auth/login.php');
}

$auth  = new Auth;
$mentoring = new Mentoring;

if(isset($_GET['id'])){
    $detailPertemuanBPMAI = $mentoring->detailPertemuanBPMAI($_GET['id']);
    $detailPertemuan = $mentoring->detailPertemuan($_GET['id']);
}

$title = 'Mentoring | Detail Pertemuan';
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
                <?php if($_SESSION['user']['role'] === 'mentee'): ?>       
                <a class="btn btn-primary float-right<?= $detailPertemuan['status_kehadiran'] !== null ? ' disabled' : '' ?>" href="<?= BASEURL ?>/views/mentoring/presensi.php?id=<?= $detailPertemuan['id'] ?>">Presensi</a>
                <?php elseif($_SESSION['user']['role'] === 'mentor' || $_SESSION['user']['role'] === 'bpmai' ): ?>
                <a class="btn btn-primary float-right" href="<?= BASEURL ?>/views/presensi/index.php?id=<?= $detailPertemuanBPMAI['id'] ?>">Lihat presensi</a>
                <?php endif ?>

                <?php if($_SESSION['user']['role'] === 'mentee'): ?>
                <h3 class="role-header mb-5">Materi Pertemuan <?= $detailPertemuan['pertemuan_ke'] ?></h3>
                <p><?= $detailPertemuan['materi'] ?></p>
                <?php elseif($_SESSION['user']['role'] === 'mentor' || $_SESSION['user']['role'] === 'bpmai'): ?>
                <h3 class="role-header mb-5">Materi Pertemuan <?= $detailPertemuanBPMAI['pertemuan_ke'] ?></h3>
                <p><?= $detailPertemuanBPMAI['materi'] ?></p>
                <?php endif ?>
                 
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Materi -->
<div class="modal fade" id="tambahMateri" tabindex="-1" aria-labelledby="tambahMateriLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title mt-2" id="tambahMateriLabel">Kelompok mentor</h3>
            </div>
            <div class="modal-body">
                <form action="<?= BASEURL ?>/routes/routeMentoring.php" method="post">
                    <div class="form-group">
                        <label for="tanggal_mentoring">Tanggal Mentoring</label>
                        <input type="date" min="1" class="form-control form-control-lg" id="exampletanggal_mentoring" placeholder="Tanggal Mentoring" id="tanggal_mentoring" name="tanggal_mentoring">
                    </div>
                    <div class="form-group">
                        <label for="materi">Materi Mentoring</label>
                        <input type="text" min="1" class="form-control form-control-lg" id="examplemateri" placeholder="Materi Mentoring" id="materi" name="materi">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">Reset</button>
                <button type="submit" name="bagi-kelompok-mentor" class="btn btn-primary">Bagi</button>
            </div>
                </form>
        </div>
    </div>
</div>


<?php require_once '../layout/footer.php' ?>
<script>
    $(document).ready(function() {
        $('#listMentor').DataTable({
            "ordering": false,
            "info":     false
        });
        $('#listMentee').DataTable({
            "ordering": false,
            "info":     false
        });
    } );
</script>