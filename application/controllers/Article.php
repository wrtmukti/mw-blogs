<?php
// Struktur url ci3 : [base url]/index.php/class/function
class Article extends CI_Controller
{
  public function __construct()
  {
    Parent::__construct();
    $this->load->model('Article_model');
    $this->load->model('User_model');
    $this->load->library('form_validation');
  }
  public function index()
  {

    $data['allUsers'] = $this->db
      ->get('users')->result_array();
    $data['users'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
    $data['judul'] = "Artikel";


    $this->session->set_userdata('keyword', '');

    // pagination
    $this->load->library('pagination');
    $config['base_url'] = 'http://localhost/blog-codeigniter/article/index';
    if (isset($_POST['submit'])) {
      $data['keyword'] = $this->input->post('keyword');
      $this->session->set_userdata('keyword', $data['keyword']);
    } else {
      $data['keyword'] = $_SESSION['keyword'];
    }
    $config['total_rows'] = $this->Article_model->countArticle($data['keyword']);
    $config['per_page'] = 3;
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
    $data['start'] = $this->uri->segment(3); //parameter di url
    $data['articles'] = $this
      ->Article_model
      ->getArticle($config['per_page'], $data['start'], $data['keyword']);

    $this->load->view('templates/header', $data);
    $this->load->view('article/index', $data);
    $this->load->view('templates/footer');
  }
  public function show($slug)
  {
    $data['users'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
    $data['judul'] = 'Show Article';
    $data['articles'] = $this->Article_model->getArticleBySlug($slug);;

    $this->load->view('templates/header', $data);
    $this->load->view('article/show', $data);
    $this->load->view('templates/footer');
  }
  public function create()
  {
    $data['users'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
    $data['judul'] = "Buat artikel";
    $this->load->view('templates/header', $data);
    $this->load->view('article/create', $data);
    $this->load->view('templates/footer');
  }
  public function store()
  {
    $this->form_validation->set_rules('title', 'Title', 'required', [
      'required' => 'judul tidak boleh kosong',
    ]);
    $this->form_validation->set_rules('body', 'Body', 'required', [
      'required' => 'isi tidak boleh kosong',
    ]);
    // cek validasi
    if ($this->form_validation->run() == false) {
      $data['judul'] = "Buat artikel";
      $data['users'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
      $this->load->view('templates/header', $data);
      $this->load->view('article/create', $data);
      $this->load->view('templates/footer');
    } else {
      $this->Article_model->createArticle();
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Selamat kamu berhasil membuat artikel baru :)</div>');
      redirect('user/dashboard');
    }
  }
  public function edit($slug)
  {
    $data['users'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
    $data['judul'] = 'Edit Artikel';
    $data['articles'] = $this->Article_model->getArticleBySlug($slug);;
    $this->load->view('templates/header', $data);
    $this->load->view('article/edit', $data);
    $this->load->view('templates/footer');
  }
  public function update($slug)
  {
    $this->form_validation->set_rules('title', 'Title', 'required', [
      'required' => 'Judul tidak boleh kosong',
    ]);
    $this->form_validation->set_rules('body', 'Body', 'required', [
      'required' => 'Isi tidak boleh kosong',
    ]);
    // cek validasi
    if ($this->form_validation->run() == false) {
      $data['users'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
      $data['judul'] = 'Update Artikel';
      $data['articles'] = $this->Article_model->getArticleBySlug($slug);;
      $this->load->view('templates/header', $data);
      $this->load->view('article/edit/' . $slug, $data);
      $this->load->view('templates/footer');
    } else {
      $this->Article_model->updateArticle($slug);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Update artikel berhasil:)</div>');
      redirect('user/dashboard');
    }
  }
  public function delete($slug)
  {
    $this->Article_model->deleteArticle($slug);
    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Hapus artikel berhasil:)</div>');
    redirect('user/dashboard');
  }
}
