<?php
session_start();
require_once '../../config.php';
require_once '../../controller/auth.php';
require_once '../../controller/pendaftaran.php';

if(!isset($_SESSION['user'])){
    header('Location: '.BASEURL.'/views/auth/login.php');
}

$auth  = new Auth;
$pendaftaran = new Pendaftaran;

$profil = $auth->getProfil();
$listMentor = $pendaftaran->listMentor();
$listMentee = $pendaftaran->listMentee();

$title = 'Mentoring | Pendaftaran';
$menu = 'Pendaftaran';
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



<?php if($_SESSION['user']['role'] === 'bpmai'): ?>
<div class="row">
    <div class="col-lg-11 col-md-12 col-sm-12">
        <div class="card mx-2">
            <div class="card-body">
                <h3 class="role-header mb-5">Mentor</h3>
                <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#kelompokMentor" data-toggle="modal" data-target="#kelompokMentor"  <?= $listMentor->fetch_assoc() === null ? 'disabled' : '' ?>>Bagi Kelompok</button>
                <table id="listMentor" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th>Nim</th>
                            <th>Nama</th>
                            <th>No. Hp</th>
                            <th>Email</th>
                            <th>Jurusan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach($listMentor as $lm): ?>
                        <tr>
                            <td class="text-center"><?= $i++.'.' ?></td>
                            <td><?= $lm['nim'] ?></td>
                            <td><?= $lm['nama'] ?></td>
                            <td><?= $lm['no_hp'] ?></td>
                            <td><?= $lm['email'] ?></td>
                            <td><?= $lm['jurusan'] ?></td>
                            <td>
                                <form action="<?= BASEURL ?>/routes/routePendaftaran.php" method="post" onsubmit="return confirm('Yakin mau dihapus?')">
                                    <a class="btn btn-primary" href="<?= BASEURL ?>/views/pendaftaran/detail.php?nim=<?= $lm['nim'] ?>">Detail</a>
                                    <input type="text" name="nim" value="<?= $lm['nim'] ?>" class="d-none">
                                    <button type="submit" name="hapus" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php endif ?>

<div class="row mt-4">
    <div class="col-lg-11 col-md-12 col-sm-12">
        <div class="card mx-2">
            <div class="card-body">
                <h3 class="role-header mb-5">Mentee</h3>
                <?php if($_SESSION['user']['role'] === 'mentor'): ?>
                <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#kelompokMentee" data-toggle="modal" data-target="#kelompokMentee" <?= $listMentee->fetch_assoc() === null ? 'disabled' : '' ?>>Bagi Kelompok</button>
                <?php endif ?>
                <table id="listMentee" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th>Nim</th>
                            <th>Nama</th>
                            <th>No. Hp</th>
                            <th>Email</th>
                            <th>Jurusan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach($listMentee as $lm): ?>
                        <tr>
                            <td class="text-center"><?= $i++.'.' ?></td>
                            <td><?= $lm['nim'] ?></td>
                            <td><?= $lm['nama'] ?></td>
                            <td><?= $lm['no_hp'] ?></td>
                            <td><?= $lm['email'] ?></td>
                            <td><?= $lm['jurusan'] ?></td>
                            <td>
                                <form action="<?= BASEURL ?>/routes/routePendaftaran.php" method="post" onsubmit="return confirm('Yakin mau dihapus?')">
                                    <a class="btn btn-primary" href="<?= BASEURL ?>/views/pendaftaran/detail.php?nim=<?= $lm['nim'] ?>">Detail</a>
                                    <input type="text" name="nim" value="<?= $lm['nim'] ?>" class="d-none">
                                    <button type="submit" name="hapus" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Mentor -->
<div class="modal fade" id="kelompokMentor" tabindex="-1" aria-labelledby="kelompokMentorLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title mt-2" id="kelompokMentorLabel">Kelompok mentor</h3>
            </div>
            <div class="modal-body">
                <form action="<?= BASEURL ?>/routes/routePendaftaran.php" method="post">
                    <div class="form-group">
                        <label for="numberGroup">Jumlah Kelompok</label>
                        <input type="number" min="1" class="form-control form-control-lg" id="exampleInputNumberGroup" placeholder="Jumlah Kelompok" id="numberGroup" name="numberGroup">
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

<!-- Modal Mentee -->
<div class="modal fade" id="kelompokMentee" tabindex="-1" aria-labelledby="kelompokMenteeLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title mt-2" id="kelompokMenteeLabel">Kelompok mentee</h3>
            </div>
            <div class="modal-body">
                <form action="<?= BASEURL ?>/routes/routePendaftaran.php" method="post">
                    <div class="form-group">
                        <label for="numberGroup">Jumlah Kelompok</label>
                        <input type="number" min="1" class="form-control form-control-lg" id="exampleInputNumberGroup" placeholder="Jumlah Kelompok" id="numberGroup" name="numberGroup">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">Reset</button>
                <button type="submit" name="bagi-kelompok-mentee" class="btn btn-primary">Bagi</button>
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