<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Instansi extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('licensing');
		$this->licensing->check_license();
		if (!$this->session->userdata('level')) {
			$this->session->set_flashdata('pesan', 'Anda harus masuk terlebih dahulu!');
			redirect('home');
		}
	}

	public function index()
	{
		$data['title']		= 'Data Instansi';
		$data['subtitle']	= 'Semua data instansi akan muncul disini';

		$data['collapse']	= 'No';

		$data['instansi']       = $this->m_model->get_desc('tb_instansi');

		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar');
		$this->load->view('admin/instansi');
		$this->load->view('admin/templates/footer');
	}

	public function delete($id)
	{
		$where = array('id' => $id);

		$this->m_model->delete($where, 'tb_instansi');
		$this->session->set_flashdata('pesan', 'Data berhasil dihapus!');
		redirect('admin/instansi');
	}

	public function insert()
	{
		date_default_timezone_set('Asia/Jakarta');

		$kode	    = $_POST['kode'];
		$nama	    = $_POST['nama'];
		$terdaftar	= date('Y-m-d H:i:s');

		$data = array(
			'kode'      => $kode,
			'nama'      => $nama,
			'terdaftar' => $terdaftar,
		);

		$this->m_model->insert($data, 'tb_instansi');
		$this->session->set_flashdata('pesan', 'Data berhasil ditambahkan!');
		redirect('admin/instansi');
	}

	public function update($id)
	{
		$kode	    = $_POST['kode'];
		$nama	    = $_POST['nama'];

		$data = array(
			'kode'      => $kode,
			'nama'      => $nama,
		);

		$where = array('id' => $id);

		$this->m_model->update($where, $data, 'tb_instansi');
		$this->session->set_flashdata('pesan', 'Data berhasil diubah!');
		redirect('admin/instansi');
	}

	public function detail_instansi($id)
	{
		$data['title']		= 'Detail Instansi';
		$data['subtitle']	= 'Semua data instansi akan muncul disini';

		$data['collapse']	= 'Yes';

		$this->db->where('id', $id);
		$data['instansi']       = $this->m_model->get_desc('tb_instansi');
		$this->db->where('idInstansi', $id);
		$data['booking_instansi']       = $this->m_model->get_desc('tb_booking_instansi');

		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar');
		$this->load->view('admin/detail_instansi');
		$this->load->view('admin/templates/footer');
	}
}
