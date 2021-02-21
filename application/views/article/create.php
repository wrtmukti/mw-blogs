<div class="container mt-5">
  <div class="jumbotron jumbotron-fluid grey grey aqua-gradient text-white">
    <div class="container">
      <div class=" col-3">
        <h1 class="display-5 mb-0 ">Buat Artikel </h1>
      </div>
    </div>
  </div>
  <div class="row ">
    <div class="col-10 mx-auto">
      <div class="card shadow-lg">
        <!-- <div class="card-header">Tulis artikel</div> -->
        <div class="card-body">
          <form action="<?= base_url() ?>article/store" method="POST">
            <input type="hidden" class="form-control" id="user_id" name="user_id" value="<?= $users['id']; ?>">
            <div class="mb-3 form-group">
              <label for="title" class="form-label">Judul</label>
              <input type="text" class="form-control" id="title" name="title" placeholder="Judul artikel.." value="<?= set_value('title'); ?>">
              <!-- error message (name dari form, tag pembuka, tag penutup) -->
              <?= form_error('title', '<small class="text-danger pl-3">', '</small>'); ?>
            </div>
            <div class="mb-3">
              <label for="body" class="form-label" cols="30" rows="10">Teks Artikel</label>
              <textarea type="text" id="body" name="body" class="form-control" value="<?= set_value('body'); ?>" cols="30" rows="10"> </textarea>
              <?= form_error('body', '<small class="text-danger pl-3">', '</small>'); ?>
            </div>
            <div class="float-right">
              <a href="<?= base_url('user/dashboard') ?>" class="btn btn-grey rounded-pill">Batal</a>
              <button type="submit" class="btn btn-primary rounded-pill">Kirim</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>