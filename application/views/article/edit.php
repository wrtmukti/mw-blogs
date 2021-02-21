<div class="container mt-5">
  <div class="jumbotron jumbotron-fluid grey grey aqua-gradient text-white">
    <div class="container">
      <div class=" col-3">
        <h1 class="display-5 mb-0 ">Edit Artikel</h1>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-10 mx-auto">
      <?php foreach ($articles as $article) : ?>
        <div class="card shadow-lg">
          <!-- <div class="card-header">Edit Artikel</div> -->
          <div class="card-body">
            <form action="<?= base_url() ?>article/update/<?= $article['slug']; ?>" method="POST">
              <div class="mb-3 form-group">
                <div class="col">
                  <label for="title" class="form-label mx-auto">Judul </label>
                  <input type="text" value="<?= $article['title']; ?>" class="form-control" id="title" name="title" required>
                </div>
              </div>
              <div class="mb-3 form-group">
                <div class="col">
                  <label for="body" class="form-label">Teks Artikel</label>
                  <textarea type="text" value="" id="body" name="body" class="form-control" cols="30" rows="10"> <?= $article['body']; ?> </textarea>
                  <?= form_error('body', '<small class="text-danger pl-3">', '</small>'); ?>

                </div>
              </div>
              <div class="float-right">
                <div class="col">
                  <a href="<?= base_url('user/dashboard') ?>" class="btn btn-grey rounded-pill">Batal</a>
                  <button type="submit" class="btn btn-info rounded-pill">Ubah</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>