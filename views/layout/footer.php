            </div>
            <!-- partial:./partials/_footer.html -->
            <footer class="footer mx-4 mt-5" style="font-family: 'Open Sans', sans-serif;">
                <div class="justify-content-center justify-content-sm-between">
                    <p class="text-center text-dark">Copyright &copy; 2021  Kelompok 2 PPSI.</p>
                    <p class="text-center text-dark mt-3">Templated By: <a href="https://www.themewagon.com/" target="_blank">ThemeWagon</a></p>
                </div>
            </footer>
        <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <!-- base:js -->
    <script src="<?= BASEURL ?>/public/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <script src="<?= BASEURL ?>/public/vendors/chart.js/Chart.min.js"></script>
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="<?= BASEURL ?>/public/js/off-canvas.js"></script>
    <script src="<?= BASEURL ?>/public/js/hoverable-collapse.js"></script>
    <script src="<?= BASEURL ?>/public/js/template.js"></script>
    <!-- endinject -->
    <!-- plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- Custom js for this page-->
    <script src="<?= BASEURL ?>/public/js/dashboard.js"></script>
    <!-- End custom js for this page-->

    <!-- datatables -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

    <script>
        const getDateTime = () => {
            const tanggal = document.getElementById('datetime');
            const date = new Date().toLocaleString("en-US", {timeZone: "Asia/Jakarta", day:"numeric", month:"long", year:"numeric", hour:"numeric", minute:"numeric"});
            tanggal.innerHTML = date;
        }
        setInterval(getDateTime);
    </script>
</body>

</html>