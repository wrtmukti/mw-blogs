<div class="row mt-5">
  <div class="col-5 mx-auto">
    <!-- flash message -->
    <?= $this->session->flashdata('message'); ?>
    <!-- form -->
    <form action="<?= base_url('user/changePassword'); ?>" method="POST" class="border p-5 mt-5 grey lighten-5">
      <h2 class="">Ubah Password</h2>
      <hr>
      <!-- current password  -->
      <div class="form-group mt-4">
        <input type="password" class="form-control rounded-pill" name="current_password" id="current_password" placeholder="Password saat ini..">
        <?= form_error('current_password', '<small class="text-danger pl-3">', '</small>'); ?>
      </div>
      <!-- new password -->
      <div class="form-group mt-4">
        <input type="password" class="form-control rounded-pill" name="new_password1" id="new_password1" placeholder="Password baru..">
        <?= form_error('new_password1', '<small class="text-danger pl-3">', '</small>'); ?>
      </div>
      <!-- repeat  password -->
      <div class="form-group mt-4">
        <input type="password" class="form-control rounded-pill" name="new_password2" id="new_password2" placeholder="Ulangi Password..">
        <?= form_error('new_password2', '<small class="text-danger pl-3">', '</small>'); ?>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-info  rounded-pill">Ubah</button>
      </div>
  </div>
  </form>
</div>
</div>