<div class="container mt-5">
  <div class="jumbotron jumbotron-fluid aqua-gradient text-white ">
    <div class="container">
      <h1 class="display-4">hello !</h1>
      <p class="lead">This is a modified jumbotron that occupies the entire horizontal space of its parent.</p>
    </div>
    <form class="form-inline my-5 mx-2 my-lg-0 float-right " method="POST" action="">
      <input class="form-control rounded-pill " type="search" placeholder="cari artikel apa?" name="keyword" aria-label="Search">
      <button class="btn btn-info  rounded-pill " type="submit" name="submit">Cari</button>
    </form>
  </div>
  <div class="my-5">
    <a class="btn btn-success my- my-sm-0  rounded-pill" href="<?= base_url() ?>article/create">Buat Artikel</a> <br>
  </div>

  <?= $this->pagination->create_links(); ?>
  <div class=" text-center"><?= $this->session->flashdata('message'); ?></div>
  <div class="row mt-4">
    <?php foreach ($articles as $article) : ?>
      <div class="col-md-6 mb-3">
        <div class="card">
          <div class="card-header grey lighten-4 ">
            <h3 class="text-truncate font-weight-bold"><?= $article['title']; ?></h3>
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
            <div class="float-right">

              <!-- cek auth -->
              <?php
              if ($this->session->userdata('email')) { ?>
                <a role="button" href=" <?= base_url() ?>article/edit/<?= $article['slug'] ?>" class="btn btn-success rounded-pill">Edit</a>
                <a role="button" href=" <?= base_url() ?>article/delete/<?= $article['slug'] ?>" class="btn btn-danger rounded-pill">Hapus</a>
              <?php }  ?>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach ?>

  </div>
</div>
</div>
</div>