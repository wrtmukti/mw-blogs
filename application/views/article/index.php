<div class="container mt-5">
  <div class="jumbotron jumbotron-fluid aqua-gradient text-white ">
    <div class="container">
      <?php
      if ($this->session->userdata('email')) { ?>
        <h1 class="display-4">Hi, <?= $users['username']; ?>!</h1>
        <p class="lead">Selamat datang di MW blogs buat artikelmu sekarang juga!</p>
      <?php } else { ?>
        <h1 class="display-4">Hi !</h1>
        <p class="lead">Mau buat artikel juga? <a class="text-white border-bottom-light" href="<?= base_url('auth/registration'); ?>">daftar sekarang!</a> </p>
      <?php } ?>
    </div>
    <form class="form-inline my-5 mx-2 my-lg-0 float-right " method="POST" action="">
      <input class="form-control rounded-pill" type="search" placeholder="cari artikel apa?" name="keyword" aria-label="Search">
      <button class="btn btn-info  rounded-pill " type="submit" name="submit">Cari</button>
    </form>
  </div>

  <div class="row mt-4">
    <?php foreach ($articles as $article) : ?>
      <div class="col-md-6 mb-3">
        <div class="card">
          <div class="card-header grey lighten-4">
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
              <a role="" href=" <?= base_url() ?>article/show/<?= $article['slug'] ?>" class="">baca yuk</a>
            </div>
          </div>
          <div class="card-footer bg-white ">

          </div>
        </div>
      </div>
    <?php endforeach ?>
  </div>
  <div class="mx-auto">
    <?= $this->pagination->create_links(); ?>
  </div>
</div>
</div>
</div>