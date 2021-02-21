<div class="container mt-5">
  <div class="jumbotron jumbotron-fluid aqua-gradient text-white shadow-lg ">
    <div class="container">
      <?php
      if ($this->session->userdata('email')) { ?>
        <h1 class="display-4 font-weight-bold">Hai, <?= $users['username']; ?>!</h1>
        <p class="lead">Selamat datang di MW blogs buat artikelmu sekarang juga!</p>
      <?php } else { ?>
        <h1 class="display-4 font-weight-bold">Hai !</h1>
        <p class="lead">Mau buat artikel juga? <a class="text-white border-bottom-light" href="<?= base_url('auth/registration'); ?>">daftar sekarang!</a> </p>
      <?php } ?>
    </div>
  </div>


  <!-- card -->
  <div class="d-flex flex-row ">
    <div class="row flex-2">
      <?php foreach ($articles as $article) : ?>
        <div class="col-md-12 mb-3">
          <div class="card shadow-lg border">
            <div class="card-header bg-white">
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
                <a role="" href=" <?= base_url() ?>article/show/<?= $article['slug'] ?>" class="">Selegkapnya</a>
              </div>
            </div>
            <div class="card-footer grey lighten-3 ">
              <div class=" text-muted text-xs "> <i class="fas fa-user-edit"></i>
                <?= $article['name']; ?>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach ?>
    </div>

    <div class="col-md-4 flex-2 ">
      <div class="card shadow-lg ">
        <div class=" card-header aqua-gradient text-white">
          <h3 class="font-weight-bold"><i class="fas fa-user-edit"></i> Penulis</h3>
        </div>
        <div class="card-body p-3 ">
          <?php foreach ($allUsers as $user) : ?>
            <div class=" nav-item row mx-2 mb-3 border-bottom ">
              <img src=" <?= base_url('assets/img/profile/') . $user['image']; ?>" class="rounded-circle z-depth-0 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" alt="avatar image" height="35" width="35">
              <div class="nav-link p-0 mx-2">
                <?php if ($this->session->userdata('email')) { ?>
                  <a href="<?= base_url('user/profile/') . $user['id'] ?> "><?= $user['name']; ?></a>
                  <div class="text-muted text-xs"><i class="fas fa-pen"></i>
                    <?= $this->db
                      ->where('user_id', $user['id'])->from('articles')->count_all_results();; ?>
                    artikel
                  </div>
                <?php } else { ?>
                  <a href="<?= base_url('guest/user/') . $user['id'] ?> " class="my-0"><?= $user['name']; ?></a>
                  <div class="text-muted text-xs "><i class="fas fa-pen"></i>
                    <?= $this->db
                      ->where('user_id', $user['id'])->from('articles')->count_all_results();; ?>
                    artikel
                  </div>
                <?php } ?>
              </div>
            </div>
          <?php endforeach ?>
        </div>
      </div>
    </div>
  </div>

  <div class="mx-auto ">
    <?= $this->pagination->create_links(); ?>
  </div>
</div>
</div>
</div>