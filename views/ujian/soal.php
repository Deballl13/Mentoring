<?php
session_start();
require_once '../../config.php';
require_once '../../controller/auth.php';
require_once '../../controller/ujian.php';

if(!isset($_SESSION['user'])){
    header('Location: '.BASEURL.'/views/auth/login.php');
}

$ujian = new Ujian;
if(isset($_GET['id'])){
    $soal = $ujian->getSoal($_GET['id']);
}

$title = 'Mentoring | Soal Ujian';
$menu = 'Ujian';
require_once '../layout/header.php';

?>



<div class="row">
    <div class="col-lg-11 col-md-12 col-sm-12">
        <div class="card mx-2">
            <div class="card-body">
                <h3 class="role-header mb-5">Ujian</h3>

                <?php $i=1; foreach($soal as $s): ?>
                <h5 class="<?= $i>1 ? 'mt-5' : '' ?>">Soal <?= $i ?> 
                    <span class="ml-5">(<?= $s['bobot_nilai'] ?> poin)</span>
                </h5>

                <p><?= $s['soal'] ?></p>
                <p class="font-weight-bold">jawaban :</p>
                <p><?= $s['jawaban'] ?></p>
                <?php $i++; endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once '../layout/footer.php' ?>