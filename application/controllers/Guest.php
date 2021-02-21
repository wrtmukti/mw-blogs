<?php

// Struktur url ci3 : [base url]/index.php/class/function
class Guest extends CI_Controller
{
  public function __construct()
  {
    Parent::__construct();
    $this->load->model('Article_model');
  }
  public function index()
  {
    $data['judul'] = "Welcome";
    $data['users'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
    $this->load->view('templates/header', $data);
    $this->load->view('welcome');
    $this->load->view('templates/footer');
  }


  public function user($id)
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
    $data['start'] = $this->uri->segment(5); //parameter di url
    $data['articles'] = $this
      ->Article_model
      ->getUserArticle($id, $config['per_page'], $data['start'], $data['keyword']);

    $this->load->view('templates/header', $data);
    $this->load->view('guest/user', $data);
    $this->load->view('templates/footer');
  }
}
