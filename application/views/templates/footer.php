  <!-- Footer -->
  <footer class="page-footer shadow border-top ">
    <!-- Copyright -->
    <div class=" text-center text-dark mt-1">© 2021 Copyright:
      <a href="https://mw-blogs.com/" class="text-dark"> mw-blogs.com</a>
    </div>
    <div class=" text-center text-dark  py-3">
      <a href="https://www.instagram.com/mukti.wrtm"><i class="fab fa-instagram fa-2x text-dark"></i></a>
      <a href="https://twitter.com/wrtm_mukti"><i class="fab fa-twitter fa-2x mx-3 text-dark"></i></a>
      <a href="https://github.com/wrtmukti/"><i class="fab fa-github fa-2x text-dark"></i></a>
    </div>
    <!-- Copyright -->
  </footer>
  <!-- Footer -->


  <!-- jQuery -->
  <script type="text/javascript" src="<?= base_url('assets/mdbootstrap/'); ?>js/jquery.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="<?= base_url('assets/mdbootstrap/'); ?>js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="<?= base_url('assets/mdbootstrap/'); ?>js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="<?= base_url('assets/mdbootstrap/'); ?>js/mdb.min.js"></script>
  <!-- Your custom scripts (optional) -->
  <script type="text/javascript"></script>

  <!-- script sendiri -->
  <script>
    $('.custom-file-input').on('change', function() {
      let fileName = $(this).val().split('\\').pop();
      $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
  </script>
  </body>

  </html>