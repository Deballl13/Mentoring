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
$statusUjian = $ujian->getStatus($_GET['id']);

if(isset($_GET['id'])){
    $listSubmission = $ujian->listSubmisson($_GET['id']);
}

$title = 'Mentoring | Detail Ujian';
$menu = 'Ujian';
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

<div class="row">
    <div class="col-lg-11 col-md-12 col-sm-12">
        <div class="card mx-2">
            <div class="card-body">
                <h3 class="role-header mb-5">Ujian</h3>

                <?php if($statusUjian === 0): ?>
                <form action="<?= BASEURL ?>/routes/routeUjian.php" method="post" class="d-inline-block mr-2">
                    <input type="text" name="id" id="id" value="<?= $_GET['id'] ?>" hidden>
                    <button class="btn btn-primary" type="submit" name="post-ujian">Posting</button>
                </form>
                <a class="btn btn-warning mr-2" href="<?= BASEURL ?>/views/ujian/edit-soal.php?id=<?= $_GET['id'] ?>">Edit soal</a>
                <form action="<?= BASEURL ?>/routes/routeUjian.php" method="post" onsubmit="return confirm('Yakin mau dihapus?')" class="d-inline-block">
                    <input type="text" name="id" id="id" value="<?= $_GET['id'] ?>" hidden>
                    <button class="btn btn-danger" type="submit" name="delete-ujian">Hapus ujian</button>
                </form>

                <?php else: ?>
                <a class="btn btn-info mr-2" href="<?= BASEURL ?>/views/ujian/soal.php?id=<?= $_GET['id'] ?>">Lihat soal</a>

                <?php endif ?>

                <h4 class="mt-5 mb-3">Submission ujian mentee</h4>
                <table id="listSubmission" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th>Nim</th>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach($listSubmission as $ls): ?>
                        <tr>
                            <td class="text-center"><?= $i++ ?></td>
                            <td><?= $ls['nim'] ?></td>
                            <td><?= $ls['nama'] ?></td>
                            <td>
                                <a class="btn btn-primary" href="<?= BASEURL ?>/views/ujian/jawaban-mentee.php?id=<?= $_GET['id'] ?>&nim=<?= $ls['nim'] ?>">Lihat jawaban</a>
                            </td>
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
        $('#listSubmission').DataTable({
            "ordering": false,
            "info":     false
        });
    } );
</script>