<div class="container mt-5">
  <!-- jumbotron -->
  <div class="jumbotron jumbotron-fluid grey grey aqua-gradient text-white">
    <div class="container">
      <div class=" col-3">
        <h1 class="display-5 mb-0 ">Edit Profil </h1>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-10 mx-auto py-3">
      <!-- pesan dari session -->
      <?= $this->session->flashdata('message'); ?>
      <!-- <form action="" method="" enctype="multipart/form-data"> -->
      <div class="border p-4 grey lighten-5">
        <?= form_open_multipart('user/edit'); ?>
        <!-- email -->
        <div class="form-group row py-2 ">
          <label for="email" class="col-sm-2 col-form-label">Email</label>
          <div class="col-sm-10">
            <input type="text" class="form-control rounded-pill" id="email" name="email" value="<?= $users['email']; ?>" readonly>
          </div>
        </div>
        <!-- name -->
        <div class="form-group row py-2">
          <label for="name" class="col-sm-2 col-form-label">Nama Lengkap</label>
          <div class="col-sm-10">
            <input type="text" class="form-control rounded-pill" id="name" name="name" value="<?= $users['name']; ?>">
          </div>
          <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
        </div>
        <!-- username -->
        <div class="form-group row py-2">
          <label for="username" class="col-sm-2 col-form-label">Username</label>
          <div class="col-sm-10">
            <input type="text" class="form-control rounded-pill" id="username" name="username" value="<?= $users['username']; ?>" readonly>
          </div>
        </div>
        <!-- password -->
        <div class="form-group row py-2">
          <label for="username" class="col-sm-2 col-form-label">Password</label>
          <div class="col-sm-10">
            <a class="btn btn-info my-2 my-sm-0  rounded-pill" href="<?= base_url('user/changepassword') ?>">Ubah?</a>
          </div>
        </div>
        <!-- gambar -->
        <div class="form-group row py-2">
          <div class="col-sm-2">Picture</div>
          <div class="col-sm-10">
            <div class="row">
              <div class="col-sm-3">
                <img src="<?= base_url('assets/img/profile/') . $users['image']  ?>" class="img-thumbnail">
              </div>
              <div class="col-sm-9">
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="image" name="image">
                  <label class="custom-file-label" for="image">Choose file</label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- submit -->
        <div class="form-group-row float-right">
          <div class="col-sm-10 mr-3 float-right ">
            <button type="submit" class="btn btn-info  rounded-pill">Simpan</button>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>