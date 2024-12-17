<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aplikasi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('licensing');
        $this->licensing->check_license();
        if (!$this->session->userdata('level')) {
            $this->session->set_flashdata('pesan', 'Anda harus masuk terlebih dahulu!');
            redirect('home');
        } elseif ($this->session->userdata('level') != 'Administrator') {
            redirect('home');
        }
    }

    public function index()
    {
        $data['title']      = 'Tentang Aplikasi';
        $data['subtitle']   = 'Atur aplikasi anda disini';

        $data['collapse']    = 'No';

        $data['aplikasi']   = $this->m_model->get_desc('tb_aplikasi');

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar');
        $this->load->view('admin/aplikasi');
        $this->load->view('admin/templates/footer');
    }

    public function update($id)
    {
        $nama           = $_POST['nama'];
        $email          = $_POST['email'];
        $telp           = $_POST['telp'];
        $alamat         = $_POST['alamat'];
        $logo           = $_FILES['logo'];

        $where = array('id' => $id);

        if ($logo != '') {
            $config['upload_path'] = './assets/logo/';
            $config['allowed_types'] = 'png|jpg|jpeg';
            $config['file_name'] = 'Logo-' . time();
            $config['max_size'] = 5120;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('logo')) {
                $logo = '';
            } else {
                $logo = $this->upload->data('file_name');
            }
        }

        if ($logo == '') {
            $data = array(
                'nama'          => $nama,
                'email'         => $email,
                'telp'          => $telp,
                'alamat'        => $alamat,
                'logo'          => $logo
            );
        } else {
            $data = array(
                'nama'          => $nama,
                'email'         => $email,
                'telp'          => $telp,
                'alamat'        => $alamat,
                'logo'          => $logo,
            );
        }

        $this->m_model->update($where, $data, 'tb_aplikasi');
        $this->session->set_flashdata('pesan', 'Pengaturan aplikasi berhasil diubah!');
        redirect('admin/aplikasi');
    }

    public function delete_logo($id)
    {
        $where = array('id' => $id);
        $data = array('logo' => '');

        $this->m_model->update($where, $data, 'tb_aplikasi');
        $this->session->set_flashdata('pesan', 'Logo berhasil dihapus!');
        redirect('admin/aplikasi');
    }
}
