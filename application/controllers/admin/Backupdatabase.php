<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Backupdatabase extends CI_Controller
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
        $data['title']      = 'Backup Database';
        $data['subtitle']   = 'Halaman ini untuk backup database';

        $data['collapse']    = 'No';

        $data['backupdb']   = $this->m_model->get_desc('tb_backupdb');

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar');
        $this->load->view('admin/backupdatabase');
        $this->load->view('admin/templates/footer');
    }

    public function backup_database()
    {

        $this->load->dbutil();
        $conf = [
            'format'    => 'zip',
            'filename'  => 'Pengolahan - backup_db.sql'
        ];

        $backup = $this->dbutil->backup($conf);
        $db_name = 'Pengolahan - Backup Database - ' . date('d F Y H:i:s') . '.zip';

        $this->load->helper('file');
        write_file('./assets/database_backup/' . $db_name, $backup);

        $data = array(
            'idUser'    => $this->session->userdata('id'),
            'database'  => $db_name,
            'terdaftar' => date('Y-m-d H:i:s')
        );

        $this->m_model->insert($data, 'tb_backupdb');

        $this->load->helper('download');
        force_download($db_name, $backup);
    }
}
