<div class="container">
  <div class="card o-hidden border-0 shadow-lg my-5 col-lg-7 mx-auto">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4">Registrasi Akun</h1>
            </div>
            <!-- form -->
            <form class="user" method="POST" action="<?= base_url('auth/registration'); ?>">
              <!-- name -->
              <div class="form-group">
                <input type="text" class="form-control form-control-user" id="name" name="name" placeholder="Nama Lengkap.." value="<?= set_value('name'); ?>">
                <!-- error message (name dari form, tag pembuka, tag penutup) -->
                <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
              </div>
              <!-- username -->
              <div class="form-group">
                <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Username.." value="<?= set_value('username'); ?>">
                <?= form_error('username', '<small class="text-danger pl-3">', '</small>'); ?>
              </div>
              <!-- Email -->
              <div class=" form-group">
                <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="Email.." value="<?= set_value('email'); ?>">
                <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
              </div>
              <!-- password -->
              <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                  <input type="password" class="form-control form-control-user" id="password1" name="password1" placeholder="Password..">
                  <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <!-- repeat password -->
                <div class="col-sm-6">
                  <input type="password" class="form-control form-control-user" id="password2" name="password2" placeholder="Ulangi Password..">
                  <?= form_error('password2', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
              </div>
              <button type="submit" class="btn btn-info rounded-pill">
                Daftar
              </button>
            </form>
            <hr>
            <div class="text-center">
              <a class="small" href="<?= base_url('auth/forgotpassword'); ?>">Lupa Password ?</a>
            </div>
            <div class="text-center py-2">
              <a class="small" href="<?= base_url('auth'); ?>">Sudah punya akun? Masuk sekarang!</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>