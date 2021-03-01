<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
  public function __construct()
  {
    Parent::__construct();
    $this->load->model('Article_model');
    $this->load->library('form_validation');
    // helper buat dahulu di folder helper
    is_logged_in();
  }
  public function index()
  {
  }
  public function edit()
  {
    $data['judul'] = "Edit Profil";
    $data['users'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
    //  validasi
    $this->form_validation->set_rules('name', 'Name', 'required');
    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('user/edit', $data);
      $this->load->view('templates/footer');
    } else {
      $name = $this->input->post('name');
      $email = $this->input->post('email');

      // gambar
      $upload_image = $_FILES['image']['name'];
      // validasi gambar
      if ($upload_image) {
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']      = '2048'; //kb
        $config['upload_path']   = './assets/img/profile/';

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('image')) {
          // hapus gambar lama
          $old_image = $data['users']['image'];
          if ($old_image != 'default.jpg') {
            // gabisa baseurl jd pake unlink
            unlink(FCPATH . 'assets/img/profile/' . $old_image);
          }
          // simpan gambar
          $new_image = $this->upload->data('file_name');
          $this->db->set('image', $new_image);
        } else {
          // jika error
          echo $this->upload->display_errors();
        }
      }

      $this->db->set('name', $name);
      $this->db->where('email', $email);
      $this->db->update('users');

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Selamat anda berhasil update profil</div>');
      redirect('user/edit');
    }
  }
  public function changePassword()
  {
    $data['judul'] = "Change Password";
    $data['users'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();

    // validasi
    $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
    $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim|min_length[6]|matches[new_password2]', [
      // ngasi pesan sendiri key => value
      'matches' => 'password tidak sama',
      'min_length' => 'password minimum 6 karakter'
    ]);
    $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim|matches[new_password1]', [
      'matches' => 'password tidak sama',
      'min_length' => 'password minimum 6 karakter'
    ]);
    if ($this->form_validation->run() == false) {
      # code...
      $this->load->view('templates/header', $data);
      $this->load->view('user/changePassword', $data);
      $this->load->view('templates/footer');
    } else {
      $current_password = $this->input->post('current_password');
      $new_password = $this->input->post('new_password1');
      // cek current sama dr data password session
      if (!password_verify($current_password, $data['users']['password'])) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password salah!</div>');
        redirect('user/changePassword');
      } else {
        // cek pass baru sama tidak dengan pass lama
        if ($current_password == $new_password) {
          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password tidak boleh sama dengan password lama</div>');
          redirect('user/changePassword');
        } else {
          $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
          // baru update password
          $this->db->set('password', $password_hash);
          $this->db->where('email', $this->session->userdata('email'));
          $this->db->update('users');
          $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">berhasil mengubah password</div>');
          redirect('user/changePassword');
        }
      }
    }
  }

  public function dashboard()
  {
    $email = $this->session->userdata('email');
    $data['id_users'] = $this->db->select('id')->get_where('users', ['email' => $email])->row_array();
    $data['users'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
    $data['users_id'] = $data['users']['id'];


    $data['judul'] = "Dashboard";
    if ($this->session->userdata('keyword') == false) {
      $this->session->set_userdata('keyword', '');
    }
    // pagination
    $this->load->library('pagination');
    $config['base_url'] = 'http://localhost/blog-codeigniter/user/dashboard/';
    if (isset($_POST['submit'])) {
      $data['keyword'] = $this->input->post('keyword');
      $this->session->set_userdata('keyword', $data['keyword']);
    } else {
      $data['keyword'] = $_SESSION['keyword'];
    }
    $config['total_rows'] = $this->Article_model->countUserArticle($data['users_id'], $data['keyword']);
    $config['per_page'] = 4;
    // styling
    $config['full_tag_open'] = '<nav><ul class="pagination justify-content-center">';
    $config['full_tag_close'] = '</ul></nav>';
    $config['first_tag_open'] = '<li class="page-item">';
    $config['first_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li class="page-item">';
    $config['last_tag_close'] = '</li>';
    $config['next-link'] = '$raquo';
    $config['next_tag_open'] = '<li class="page-item">';
    $config['next_tag_close'] = '</li>';
    $config['prev-link'] = '$laquo';
    $config['prev_tag_open'] = '<li class="page-item">';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="page-item active  "> <a class="page-link" href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li class="page-item"> ';
    $config['num_tag_close'] = '</li>';

    $config["attributes"] = ['class' => 'page-link'];

    $this->pagination->initialize($config);
    $data['start'] = $this->uri->segment(3);
    $data['articles'] = $this
      ->Article_model
      ->getUserArticle($data['users_id'], $config['per_page'], $data['start'], $data['keyword']);

    $this->load->view('templates/header', $data);
    $this->load->view('user/dashboard', $data);
    $this->load->view('templates/footer');
  }
  public function profile($id)
  {
    $data['judul'] = "User Dashboard";
    $data['users'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
    $data['user'] = $this->db->get_where('users', ['id' => $id])->row_array();

    if ($this->session->userdata('keyword') == false) {
      $this->session->set_userdata('keyword', '');
    }
    // pagination
    $this->load->library('pagination');
    $config['base_url'] = 'http://localhost/blog-codeigniter/guest/user/' . $id;
    if (isset($_POST['submit'])) {
      $data['keyword'] = $this->input->post('keyword');
      $this->session->set_userdata('keyword', $data['keyword']);
    } else {
      $data['keyword'] = $_SESSION['keyword'];
    }
    $config['total_rows'] = $this->Article_model->countUserArticle($id, $data['keyword']);
    $config['per_page'] = 4;
    // styling
    $config['full_tag_open'] = '<nav><ul class="pagination justify-content-center">';
    $config['full_tag_close'] = '</ul></nav>';
    $config['first_tag_open'] = '<li class="page-item">';
    $config['first_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li class="page-item">';
    $config['last_tag_close'] = '</li>';
    $config['next-link'] = '$raquo';
    $config['next_tag_open'] = '<li class="page-item">';
    $config['next_tag_close'] = '</li>';
    $config['prev-link'] = '$laquo';
    $config['prev_tag_open'] = '<li class="page-item">';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="page-item active  "> <a class="page-link" href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li class="page-item"> ';
    $config['num_tag_close'] = '</li>';

    $config["attributes"] = ['class' => 'page-link'];

    $this->pagination->initialize($config);
    $data['start'] = $this->uri->segment(4); //parameter di url
    $data['articles'] = $this
      ->Article_model
      ->getUserArticle($id, $config['per_page'], $data['start'], $data['keyword']);

    $this->load->view('templates/header', $data);
    $this->load->view('user/profile', $data);
    $this->load->view('templates/footer');
  }
}
