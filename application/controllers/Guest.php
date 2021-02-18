<?php

// Struktur url ci3 : [base url]/index.php/class/function
class Guest extends CI_Controller
{
  public function index()
  {
    $data['judul'] = "Welcome";
    $data['users'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
    $this->load->view('templates/header', $data);
    $this->load->view('welcome');
    $this->load->view('templates/footer');
  }
}
