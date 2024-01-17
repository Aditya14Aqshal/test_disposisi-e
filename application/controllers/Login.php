<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('login/index');
        } else {
            $this->dologin();
        }
    }

    public function dologin()
    {
        $user_email = $this->input->post('email');
        $user_password = $this->input->post('password');

        // Cari user berdasarkan email
        $user = $this->db->get_where('tb_user', ['email' => $user_email])->row_array();

        // Jika user terdaftar
        if ($user) {
            // Periksa password
            if (password_verify($user_password, $user['password'])) {
                $data = [
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'username' => $user['username'],
                    'role' => $user['role']
                ];

                $user_id = $user['id'];
                $this->session->set_userdata($data);

                // Periksa role
                if ($user['role'] == 'admin') {
                    $this->_updateLastLogin($user_id);
                    redirect('admin/menu');
                } else if ($user['role'] == 'sekretaris') {
                    $this->_updateLastLogin($user_id);
                    redirect('surat');
                }
            } else {
                // Jika password salah
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> <b>Error :</b> Password Salah. </div>');
                redirect('/');
            }
        } else {
            // Jika user tidak terdaftar
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> <b>Error :</b> User Tidak Terdaftar. </div>');
            redirect('/');
        }
    }

    private function _updateLastLogin($userid)
    {
        $sql = "UPDATE tb_user SET last_login=now() WHERE id=$userid";
        $this->db->query($sql);
    }

    public function logout()
    {
        // Hancurkan semua sesi
        $this->session->sess_destroy();
        redirect(site_url('login'));
    }

    public function block()
    {
        $data = [
            'user' => infoLogin(),
            'title' => 'Access Denied!'
        ];
        $this->load->view('login/error404', $data);
    }
}
