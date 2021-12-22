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
    $soal = $ujian->getSoalUjian($_GET['id']);
    $durasi = $ujian->getDuration($_GET['id']);
}

$title = 'Mentoring | Edit Soal Ujian';
$menu = 'Ujian';
require_once '../layout/header.php';

?>


<h3 class="role-header mt-4 mx-2 mb-5">Ujian</h3>
<h4 class="mx-2 mb-2 d-flex justify-content-end mr-5 pr-5" id="countdown"></h4>
<form action="<?= BASEURL ?>/routes/routeUjian.php?id=<?= $_GET['id'] ?>" method="post" id="form-soal">  
    <?php $i=1 ?>
    <div id="soal-ujian">

        <?php foreach($soal as $s): ?>
        <div class="row<?= $i>1 ? ' mt-3' : ''?>">
            <div class="col-lg-11 col-md-12 col-sm-12">
                <div class="card mx-2">
                    <div class="card-body">
                        <h4 class="d-inline-block mr-3">Soal <?= $i ?> <span class="ml-5">(<?= $s['bobot_nilai'] ?> poin)</span> </h4>
                        <p><?= $s['soal'] ?></p>
                        <div class="form-group mt-5">
                            <label for="jawaban-<?= $i ?>">Jawaban :</label>
                            <textarea class="form-control border-dark" name="jawaban[]" id="jawaban-<?= $i ?>" rows="20"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $i++; endforeach; ?>

    </div>
    <button class="btn btn-primary ml-2 mt-4 mr-1" name="submit_jawaban" type="submit">Submit jawaban</button>
</form>

<?php require_once '../layout/footer.php' ?>
<script>
    const timeFromMysql = "<?= $durasi['tanggal'] ?>";
    let timeFromMysqlParts = timeFromMysql.split(/[- :]/);
    timeFromMysqlParts[1]--;
    const endExam = new Date(...timeFromMysqlParts);
    endExam.setHours(endExam.getHours() + Math.floor(<?= $durasi['durasi'] ?> / 60));
    endExam.setMinutes(endExam.getMinutes() + Math.floor(<?= $durasi['durasi'] ?> - 60));
    
    const countdown = () => {
        const time = document.getElementById('countdown');
        const now = new Date();
        let duration = endExam - now;

        if(duration > 0){
            let jam = Math.floor((duration % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            let menit = Math.floor((duration % (1000 * 60 * 60)) / (1000 * 60));
            let detik = Math.floor((duration % (1000 * 60)) / 1000);

            time.innerHTML = formatNumber(jam) + ':' + formatNumber(menit) + ':' + formatNumber(detik);
        }
        else{
            const form = document.getElementById('form-soal');
            form.submit();
        }
    };

    setInterval(countdown);

</script>