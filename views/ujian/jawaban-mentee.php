<?php
session_start();
require_once '../../config.php';
require_once '../../controller/auth.php';
require_once '../../controller/ujian.php';

if(!isset($_SESSION['user'])){
    header('Location: '.BASEURL.'/views/auth/login.php');
}

$ujian = new Ujian;
if(isset($_GET['id']) && isset($_GET['nim'])){
    $submission = $ujian->getSubmission($_GET['id'], $_GET['nim']);
}

$title = 'Mentoring | Jawaban Ujian';
$menu = 'Ujian';
require_once '../layout/header.php';

?>



<div class="row">
    <div class="col-lg-11 col-md-12 col-sm-12">
        <div class="card mx-2">
            <div class="card-body">
                <h3 class="role-header mb-5">Ujian</h3>
                <form action="<?= BASEURL ?>/routes/routeUjian.php?id=<?= $_GET['id'] ?>&nim=<?= $_GET['nim'] ?>" method="post">
                    <?php $i=1; foreach($submission as $s): ?>
                    <h5 class="<?= $i>1 ? 'mt-5' : '' ?>">Soal <?= $i ?> 
                        <span class="ml-5">(<?= $s['bobot_nilai'] ?> poin)</span>
                    </h5>

                    <p><?= $s['soal'] ?></p>
                    <p class="font-weight-bold">jawaban :</p>
                    <p><?= $s['jawaban'] ?></p>
                    <p class="font-weight-bold">kunci jawaban :</p>
                    <p><?= $s['kunci_jawaban'] ?></p>
                    <div class="form-group">
                        <label for="soal-<?= $i ?>">Nilai :</label>
                        <input class="form-control border-dark w-25" type="number" name="nilai[]" id="bobot-<?= $i ?>" value="<?= $s['nilai'] ?>">
                    </div>
                    <?php $i++; endforeach; ?>
                    <button type="submit" name="submit_nilai" class="btn btn-primary">Submit nilai</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../layout/footer.php' ?>