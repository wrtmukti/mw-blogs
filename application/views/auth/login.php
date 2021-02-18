<div class="container">
  <!-- Outer Row -->
  <div class="row justify-content-center">
    <div class="col-lg-7">
      <div class="card o-hidden border-0 shadow-lg my-5 ">
        <div class="card-body p-0">
          <!-- Nested Row within Card Body -->
          <div class="row">
            <div class="col-lg">
              <div class="p-5">
                <div class="text-center">
                  <h1 class="h4 text-gray-900 mb-4">MW BLOGS</h1>
                </div>

                <!-- pesan dari session -->
                <?= $this->session->flashdata('message'); ?>
                <!-- form login -->
                <form class="user" method="POST" action="<?= base_url('auth'); ?>">
                  <!-- email -->
                  <div class="form-group">
                    <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="Email.." value="<?= set_value('email'); ?>">
                    <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                  <!-- password -->
                  <div class="form-group py-2">
                    <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password..">
                    <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                  <!-- button -->
                  <div class="form-group  mx-auto">
                    <button type="submit" class=" btn btn-info rounded-pill ">
                      Masuk
                    </button>
                  </div>
                </form>
                <hr>
                <!-- lupa password -->
                <div class="text-center">
                  <a class="small" href="<?= base_url('auth/forgotpassword'); ?>">Lupa Password?</a>
                </div>
                <!-- regiter -->
                <div class="text-center py-2">
                  <a class="small" href="<?= base_url('auth/registration'); ?>">Buat akun sekarang!</a>
                </div>
                <!-- kembali -->
                <div class="text-center">
                  <a class="small" href="<?= base_url(); ?>">Kembali</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>