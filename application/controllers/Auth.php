<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
  public function __construct()
  {
    Parent::__construct();
    $this->load->library('form_validation');
  }
  public function index()
  {
    // cek session
    if ($this->session->userdata('email')) {
      redirect('user');
    }
    $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
    $this->form_validation->set_rules('password', 'Password', 'required|trim', [
      // ngasi pesan sendiri key => value
      'matches' => 'password tidak sama',
      'min_length' => 'password minimum 6 karakter'
    ]);
    if ($this->form_validation->run() == false) {
      $data['title'] = 'Login';
      $this->load->view('templates/auth_header', $data);
      $this->load->view('auth/login');
      $this->load->view('templates/auth_footer');
    } else {
      $this->_login();
    }
  }

  private function _login()
  {
    // mengambil variabel request
    $email = $this->input->post('email');
    $password = $this->input->post('password');

    $users = $this->db->get_where('users', ['email' => $email])->row_array();
    // var_dump($users);    // die;
    // jika usermya ada
    if ($users) {
      // jika usernya aktivated
      if ($users['is_active'] == 1) {
        // cek password
        if (password_verify($password, $users['password'])) {
          // semua validasi benar
          $data = [
            'email' => $users['email'],
            'role_id' => $users['role_id']
          ];
          $this->session->set_userdata($data);
          // cek role user
          if ($users['role_id'] == 1) {
            redirect('admin');
          } else {
            redirect('user/dashboard');
          }
        } else {
          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password salah!</div>');
          redirect('auth');
        }
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email belum diaktivasi</div>');
        redirect('auth');
      }
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">email belum terdaftar</div>');
      redirect('auth');
    }
  }

  public function logout()
  {
    $this->session->unset_userdata('email');
    $this->session->unset_userdata('role_id');

    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil logout</div>');
    redirect('guest');
  }

  public function registration()
  {
    // cek session
    if ($this->session->userdata('email')) {
      redirect('user');
    }
    // validasi
    // (name dari form, alias, rules1|rules2)
    $this->form_validation->set_rules('name', 'Name', 'required');
    $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[users.username]');
    $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]');
    $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[6]|matches[password2]', [
      // ngasi pesan sendiri key => value
      'matches' => 'password tidak sama',
      'min_length' => 'password minimum 6 karakter'
    ]);
    $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]', [
      'matches' => 'password tidak sama',
      'min_length' => 'password minimum 6 karakter'
    ]);
    if ($this->form_validation->run() == false) {
      $data['title'] = 'Registration';
      $this->load->view('templates/auth_header', $data);
      $this->load->view('auth/registration');
      $this->load->view('templates/auth_footer');
    } else {
      $email = $this->input->post('email', true);
      $data = [
        'name' => htmlspecialchars($this->input->post('name', true)),
        'username' => htmlspecialchars($this->input->post('username', true)),
        'email' => htmlspecialchars($email),
        'image' => 'default.jpg',
        'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
        'role_id' => 2,
        'is_active' => 0,
        'date_created' => time()
      ];
      // membuat token
      $token = base64_encode(random_bytes(32));
      $user_token = [
        'email' =>  $email,
        'token' => $token,
        'date_created' => time()
      ];

      // insert db
      $this->db->insert('users', $data);
      $this->db->insert('users_token', $user_token);

      // email verif
      $this->_sendEmail($token, 'verify');

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Selamat anda berhasil registrasi. Saatnya Aktivasi emailmu:)</div>');
      redirect('auth');
    }
  }
  public function _sendEmail($token, $type)
  {
    // konfigurasi
    $config = [
      'protocol'  => 'smtp', //simple mail transfer protocol
      'smtp_host' => 'ssl://smtp.googlemail.com',
      'smtp_user' => 'wrtmtest@gmail.com', // isi gmail
      'smtp_pass' => 'gallardo109', // isi password gmail
      'smtp_port' => 465, //port smtp google
      'mailtype'  => 'html', //ada link (bagian dr html)
      'charset'   => 'utf-8',
      'newline'   => "\r\n"
    ];

    // masukin konfigurasi
    $this->load->library('email', $config);
    $this->email->initialize($config);  //tambahkan baris ini

    $this->email->from('wrtmtest@gmail.com', 'MW.dev');
    $this->email->to($this->input->post('email'));

    // cek verifikasi dan forgot password
    if ($type == 'verify') {
      $this->email->subject('Account Verification');
      $this->email->message('Klik link ini untuk verifikasi email kamu : <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Activate</a>');
    } else if ($type == 'forgot') {
      $this->email->subject('Reset Password');
      $this->email->message('Klik link ini untuk reset password kamu : <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>');
    }

    // cek error
    if ($this->email->send()) {
      return true;
    } else {
      echo $this->email->print_debugger();
      die;
    }
  }

  public function verify()
  {
    // mengambil email dan token dari url dgn get
    $email = $this->input->get('email');
    $token = $this->input->get('token');

    // validasi email
    $user = $this->db->get_where('users', ['email' => $email])->row_array();
    // cek email di db
    if ($user) {
      // validasi token
      $user_token = $this->db->get_where('users_token', ['token' => $token])->row_array();
      // cek token
      if ($user_token) {
        // membuat waktu validasi dlm detik (24 jam)
        if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
          // klo bener update db user
          $this->db->set('is_active', 1);
          $this->db->where('email', $email);
          $this->db->update('users');

          //hapus token di tabel user token setelah activasi 
          $this->db->delete('users_token', ['email' => $email]);
          // flashdata
          $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">' . $email . ' has been activated! Please login.</div>');
          redirect('auth');
        } else {
          // hapus user 
          $this->db->delete('users', ['email' => $email]);
          // hapus token
          $this->db->delete('users_token', ['email' => $email]);

          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account activation failed! Token expired.</div>');
          redirect('auth');
        }
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account activation failed! Wrong token.</div>');
        redirect('auth');
      }
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account activation failed! Wrong email.</div>');
      redirect('auth');
    }
  }

  public function forbidden()
  {
    $this->load->view('auth/forbidden');
  }

  public function forgotPassword()
  {
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

    if ($this->form_validation->run() == false) {
      $data['title'] = 'Forget Password';
      $this->load->view('templates/auth_header', $data);
      $this->load->view('auth/forgot-password');
      $this->load->view('templates/auth_footer');
    } else {
      $email = $this->input->post('email');
      $user = $this->db->get_where('users', ['email' => $email, 'is_active' => 1])->row_array();
      // cekemail
      // klo ada bikin token lagi, klo gada user ga terdaftar
      if ($user) {
        $token = base64_encode(random_bytes(32));
        // bikin token lagi
        $user_token = [
          'email' =>  $email,
          'token' => $token,
          'date_created' => time()
        ];
        // masukin ke database
        $this->db->insert('users_token', $user_token);
        // kirim email dengan type forgot password
        $this->_sendEmail($token, 'forgot');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">sukses kirim email, cek emailmu sekarang :)</div>');
        redirect('auth/forgotpassword');
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email kamu belum terdaftar atau belum aktif :(</div>');
        redirect('auth/forgotpassword');
      }
    }
  }
  public function resetPassword()
  {
    // ambil email dan password lewat method get
    $email = $this->input->get('email');
    $token = $this->input->get('token');
    // acek di db usernya
    $user = $this->db->get_where('users', ['email' => $email])->row_array();
    // cek user
    if ($user) {
      // cektoken
      $user_token = $this->db->get_where('users_token', ['token' => $token]);
      if ($user_token) {
        // bikin session jd data session server yg tau
        // jd sessionnya ada klo kita mau reset aja
        // klo reset sukses apus lagi sessionnya
        $this->session->set_userdata('reset_email', $email);
        //bikin method baru
        $this->changePassword();
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Token kamu salah, gagal reset password :((</div>');
        redirect('auth');
      }
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email kamu salah, gagal reset password :((</div>');
      redirect('auth');
    }
  }

  public function changePassword()
  {
    // terakhir cek session reser_email
    if (!$this->session->userdata('reset_email')) {
      redirect('auth');
    }
    $this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[6]|matches[password2]');
    $this->form_validation->set_rules('password2', 'Repeat Password', 'trim|required|min_length[6]|matches[password1]');
    // validasi
    if ($this->form_validation->run() == false) {
      $data['title'] = 'Ubah Password';
      $this->load->view('templates/auth_header', $data);
      $this->load->view('auth/change-password');
      $this->load->view('templates/auth_footer');
    } else {
      // hash password
      $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
      $email = $this->session->userdata('reset_email');

      $this->db->set('password', $password);
      $this->db->where('email', $email);
      $this->db->update('users');

      // waktunya hapus session tadi
      $this->session->unset_userdata('reset_email');

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password berhasil diubah, silahkan login kembali :)</div>');
      redirect('auth');
    }
  }
}
