<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?= $judul; ?></title>

  <!-- Custom fonts for this template-->
  <link href="<?= base_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?= base_url('assets/'); ?>css/sb-admin-2.min.css" rel="stylesheet">
  <!-- Bootstrap CSS -->
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous"> -->
  <!-- MDB icon -->
  <link rel="icon" href="<?= base_url('assets/mdbootstrap/'); ?>img/mdb-favicon.ico" type="image/x-icon">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
  <!-- Google Fonts Roboto -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/mdbootstrap/'); ?>css/bootstrap.min.css">
  <!-- Material Design Bootstrap -->
  <link rel="stylesheet" href="<?= base_url('assets/mdbootstrap/'); ?>css/mdb.min.css">
  <!-- Your custom styles (optional) -->
  <link rel="stylesheet" href="<?= base_url('assets/mdbootstrap/'); ?>css/style.css">

</head>

<body>
  <!--Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light white fixed-top ">
    <div class="container">
      <div class="row">
        <!-- logo -->
        <div class="nav-item">
          <a class="navbar-brand" href="<?= base_url('guest') ?>">
            <i class="fab fa-monero fa-2x"></i>
          </a>
        </div>
        <!-- search -->
        <div class="nav-item mt-2 ">
          <form class="form-inline my-lg-0" method="POST" action="<?= base_url('article'); ?>">
            <input class="form-control rounded-pill grey lighten-3" type="search" placeholder='Cari artikel apa?' name="keyword" aria-label="Search">
            <button class="btn btn-link rounded-pill " type="submit" name="submit">
            </button>
          </form>
        </div>
      </div>
      <!-- button responsive -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav" aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="basicExampleNav">
        <!-- kiri -->
        <ul class="navbar-nav mr-auto">
        </ul>
        <!-- +article -->
        <div class="nav-item">
          <?php
          if ($this->session->userdata('email')) { ?>
            <a class="nav-link" href="<?= base_url() ?>article/create">Buat Artikel?</a>
          <?php } ?>
        </div>
        <!-- article -->
        <div class="nav-item mx-0">
          <?php
          if ($this->session->userdata('email')) { ?>
            <a class="nav-link" href="<?= base_url('article') ?>">Beranda</a>
          <?php } else { ?>
            <a class="nav-link" href="<?= base_url('article') ?>">Artikel</a>
          <?php } ?>
        </div>
        <!-- auth -->
        <div class="nav-item">
          <?php
          if (!$this->session->userdata('email')) { ?>
            <div class="nav-item">
              <a class="nav-link btn btn-info rounded-pill" href="<?= base_url('auth') ?>">Masuk</a>
            </div>
          <?php } else {  ?>
            <div class="mx-3">
              <div class="row nav-item dropdown">
                <!-- photos -->
                <img src="<?= base_url('assets/img/profile/') . $users['image']; ?>" class="rounded-circle z-depth-0 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" alt="avatar image" height="45" width="45">
                <div class="dropdown-menu dropdown-menu-right dropdown-default" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="<?= base_url('user/dashboard') ?>"><i class="fas fa-address-card"></i> Dashboard</a>
                  <a class="dropdown-item" href="<?= base_url('user/edit') ?>"><i class="fas fa-user-edit"></i> Edit Profile</a>
                  <a class="dropdown-item" href=" <?= base_url('auth/logout') ?>"><i class="fas fa-sign-out-alt"></i> Keluar</a>
                </div>

              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </nav>