<div class="container mt-5">
  <div class="jumbotron jumbotron-fluid aqua-gradient text-white shadow-lg ">
    <div class="d-flex flex-column justify-content-center align-items-center">
      <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class=" rounded-sm mx-auto z-depth-0 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" alt="avatar image" width="200">
      <p class="display-4 font-weight-bold my-0"><?= $user['name']; ?></p>
      <p class="flex-end">Bergabung sejak : <?= date('d F Y', $user['date_created']); ?></p>
    </div>
  </div>

  <?= $this->pagination->create_links(); ?>
  <div class=" text-center"><?= $this->session->flashdata('message'); ?></div>
  <div class="row mt-4">
    <?php foreach ($articles as $article) : ?>
      <div class="col-md-6 mb-3">
        <div class="card shadow-lg">
          <div class="card-header bg-white ">
            <h3 class="text-truncate font-weight-bold"><?= $article['title']; ?></h3>
            <div class=" text-muted text-xs ">terakhir update:
              <?= date('d F Y', $article['updated_at']); ?>
            </div>
          </div>
          <div class="card-body">
            <p style="-webkit-line-clamp:3; overflow:hidden;
            text-overflow:ellipsis; display: -webkit-box; 
            -webkit-box-orient:vertical;">
              <?= $article['body']; ?>
            </p>
            <div class="float-right">
              <a role="" href=" <?= base_url() ?>article/show/<?= $article['slug'] ?>" class="">Selengkapnya</a>
            </div>
          </div>
          <div class="card-footer bg-white ">
            <div class="float-right">
            </div>
          </div>
        </div>
      </div>
    <?php endforeach ?>

  </div>
</div>
</div>
</div>