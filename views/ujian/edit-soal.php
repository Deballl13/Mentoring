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
$soal = $ujian->getSoal($_GET['id']);

$title = 'Mentoring | Edit Soal Ujian';
$menu = 'Ujian';
require_once '../layout/header.php';

?>


<h3 class="role-header mt-4 mx-2 mb-5">Ujian</h3>
<form action="<?= BASEURL ?>/routes/routeUjian.php?id=<?= $_GET['id'] ?>" method="post" id="form-soal">  
    <?php $i=1 ?>
    <div id="soal-ujian">
        <?php if($soal->fetch_assoc() === null): ?>
        <div class="row">
            <div class="col-lg-11 col-md-12 col-sm-12">
                <div class="card mx-2">
                    <div class="card-body">
                        <h4 class="d-inline-block mr-3">Soal 1</h4>
                        <div class="form-group mt-4">
                            <label for="soal-1">Bobot nilai :</label>
                            <input class="form-control border-dark w-25" type="number" name="bobot_nilai[]" id="bobot-1">
                        </div>
                        <div class="form-group">
                            <label for="soal-1">Soal :</label>
                            <textarea class="form-control border-dark" name="soal[]" id="soal-1" rows="20"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="jawaban-1">Jawaban :</label>
                            <textarea class="form-control border-dark" name="jawaban[]" id="jawaban-1" rows="20"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php else: $i=1;?>
        <?php foreach($soal as $s): ?>
        <div class="row<?= $i>1 ? ' mt-3' : ''?>">
            <div class="col-lg-11 col-md-12 col-sm-12">
                <div class="card mx-2">
                    <div class="card-body">
                        <h4 class="d-inline-block mr-3">Soal <?= $i ?></h4>
                        <div class="form-group mt-4">
                            <label for="soal-<?= $i ?>">Bobot nilai :</label>
                            <input class="form-control border-dark w-25" type="number" name="bobot_nilai[]" id="bobot-<?= $i ?>" value="<?= $s['bobot_nilai'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="soal-<?= $i ?>">Soal :</label>
                            <textarea class="form-control border-dark" name="soal[]" id="soal-<?= $i ?>" rows="20"><?= $s['soal'] ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="jawaban-<?= $i ?>">Jawaban :</label>
                            <textarea class="form-control border-dark" name="jawaban[]" id="jawaban-<?= $i ?>" rows="20"><?= $s['jawaban'] ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $i++; endforeach; ?>

        <?php endif ?>
    </div>
    <button class="btn btn-danger ml-2 mt-4 mr-1" onclick="remove_soal()" type="button">Hapus soal</button>
    <button class="btn btn-info  mr-1 mt-4" onclick="add_soal()" type="button">Tambah soal</button>
    <button class="btn btn-primary mr-1 mt-4" name="submit_soal" type="submit">Submit soal</button>
</form>

<?php require_once '../layout/footer.php' ?>
<script src="../../public/js/myscript.js" defer></script>