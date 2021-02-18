<div class="container mt-5 ">
  <div class="">
    <div class="row py-5 grey lighten-5 shadow">
      <div class="col-12">
        <?php foreach ($articles as $article) : ?>
          <div class="row border-bottom-dark mb-3 ">
            <div class="col-12 ">
              <h3 class="mt-5 text-center font-weight-bold">
                <?= $article['title']; ?>
              </h3>
              <hr>
              <div class=" text-muted mt-3 mb-1">dibuat pada:
                <?= date('d F Y', $article['created_at']); ?>
              </div>
              <div class=" text-muted float-left mb-3">update terakhir:
                <?= date('d F Y', $article['updated_at']); ?>
              </div>
            </div>
          </div>
          <div class="row mt-5">
            <div class="col-12">
              <p><?= $article['body']; ?></p>
            </div>
          </div>
          <div class="row ">
            <div class="col-12 ">
              <div class="float-right">
                <a href="<?= base_url('article/') ?>" class="btn btn-primary rounded-pill ">Kembali</a>
              </div>
            </div>
          </div>
      </div>
    <?php endforeach; ?>
    </div>
  </div>
</div>
</div>