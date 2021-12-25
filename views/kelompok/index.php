<?php
session_start();
require_once '../../config.php';
require_once '../../controller/auth.php';
require_once '../../controller/kelompok.php';

if(!isset($_SESSION['user'])){
    header('Location: '.BASEURL.'/views/auth/login.php');
}

$auth  = new Auth;
$kelompokMentoring = new KelompokMentoring;

$profil = $auth->getProfil();
$mentor = $kelompokMentoring->getMentor();
$peserta = $kelompokMentoring->getMentee();
$listKelompokMentor = $kelompokMentoring->getListKelompokMentor();
$listKelompokMentee = $kelompokMentoring->getListKelompokMentee();

$title = 'Mentoring | Kelompok Mentoring';
$menu = 'Kelompok Mentoring';
require_once '../layout/header.php';

?>


<?php if($_SESSION['user']['role'] !== 'bpmai'): ?>  
<div class="row mt-4">
    <div class="col-lg-11 col-md-12 col-sm-12">
        <div class="card mx-2">
            <div class="card-body"> 
            <?php if($mentor !== null): ?>
                <h3 class="role-header mb-5">Kelompok <?= $mentor['kelompok'] ?></h3>
                <div class="row mx-1">
                    <h4 class="mr-4">Mentor |</h4>
                    <p style="background-color: #dee5fc; width: 40px; height: 36px; border-radius: 10px; font-family: 'Poppins', sans-serif; font-size: 20px;" class="mt-n2 d-flex justify-content-center align-items-center mr-2">
                        <?php 
                            $arr_nama = explode(" ", $mentor['nama']);
                            if(count($arr_nama) > 1){
                                echo substr(current($arr_nama), 0, 1).substr(end($arr_nama),0, 1);
                            }
                            else{
                                echo substr(current($arr_nama), 0, 1);
                            }
                        ?>
                    </p>
                    <div>
                        <h4><?= $mentor['nama'] ?></h4>
                        <p class="text-muted">
                            <?php
                                $arr_jurusan = explode(" ", $mentor['jurusan']);
                                echo substr(current($arr_jurusan), 0, 1).substr(end($arr_jurusan), 0, 1)."-".substr($mentor['nim'], 0, 2);
                            ?>
                        </p>
                    </div>
                </div>

                <h4 class="mt-5 mx-1">Peserta |</h4>
                <?php if($peserta !== null): ?>
                <div class="row mx-1 mt-4">
                    <?php foreach($peserta as $p): ?>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <p style="background-color: #dee5fc; width: 40px; height: 36px; border-radius: 10px; font-family: 'Poppins', sans-serif; font-size: 20px;" class="d-flex justify-content-center align-items-center mr-2">
                        <?php 
                            $arr_nama = explode(" ", $p['nama']);
                            if(count($arr_nama) > 1){
                                echo substr(current($arr_nama), 0, 1).substr(end($arr_nama),0, 1);
                            }
                            else{
                                echo substr(current($arr_nama), 0, 1);
                            }
                        ?>
                        </p>
                        <h4><?= $p['nama'] ?></h4>
                        <p class="text-muted">
                            <?php
                                $arr_jurusan = explode(" ", $p['jurusan']);
                                echo substr(current($arr_jurusan), 0, 1).substr(end($arr_jurusan), 0, 1)."-".substr($p['nim'], 0, 2);
                            ?>
                        </p>
                    </div>
                    <?php endforeach ?>
                </div>
                <?php else: ?>
                <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </symbol>
                </svg>
                <div class="alert alert-danger d-flex align-items-center mx-2 w-75" role="alert">
                    <svg class="bi flex-shrink-0 me-2 mr-3" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                    <div>Peserta belum dibagi</div>
                </div>
                <?php endif ?>

            <?php else: ?>
                <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </symbol>
                </svg>
                <div class="alert alert-danger d-flex align-items-center mx-2 w-75" role="alert">
                    <svg class="bi flex-shrink-0 me-2 mr-3" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                    <div>Kamu belum mendapatkan kelompok</div>
                </div>
            <?php endif ?>
            
            
            </div>
        </div>
    </div>
</div>

<?php else: ?>
<div class="row mt-4">
    <div class="col-lg-11 col-md-12 col-sm-12">
        <div class="card mx-2">
            <div class="card-body"> 
                <h3 class="role-header mb-5">Kelompok mentor</h3>
                <table id="listKelompokMentor" class="display" style="width:100%">
                    <thead>
                        <tr class="text-center">
                            <th>No.</th>
                            <th>Nim</th>
                            <th>Nama</th>
                            <th>Jurusan</th>
                            <th>Kelompok</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach($listKelompokMentor as $lk): ?>
                        <tr class="text-center">
                            <td><?= $i++ ?>.</td>
                            <td><?= $lk['nim'] ?></td>
                            <td><?= $lk['nama'] ?></td>
                            <td><?= $lk['jurusan'] ?></td>
                            <td><?= $lk['kelompok'] ?></td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-11 col-md-12 col-sm-12">
        <div class="card mx-2">
            <div class="card-body"> 
                <h3 class="role-header mb-5">Kelompok mentee</h3>
                <table id="listKelompokMentee" class="display" style="width:100%">
                    <thead>
                        <tr class="text-center">
                            <th>No.</th>
                            <th>Nim</th>
                            <th>Nama</th>
                            <th>Jurusan</th>
                            <th>Kelompok</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $a=1; foreach($listKelompokMentee as $lk): ?>
                        <tr class="text-center">
                            <td><?= $a++ ?></td>
                            <td><?= $lk['nim'] ?></td>
                            <td><?= $lk['nama'] ?></td>
                            <td><?= $lk['jurusan'] ?></td>
                            <td><?= $lk['kelompok'] ?></td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php endif ?>


<?php require_once '../layout/footer.php' ?>
<script>
    $(document).ready(function() {
        $('#listKelompokMentor').DataTable({
            "ordering": false,
            "info":     false
        });
        $('#listKelompokMentee').DataTable({
            "ordering": false,
            "info":     false
        });
    } );
</script>