<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Barang extends CI_Controller
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
		$data['title']		= 'Data Barang';
		$data['subtitle']	= 'Semua data barang akan muncul disini';

		$data['collapse']	= 'No';

		$data['barang']       = $this->m_model->get_desc('tb_barang');

		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar');
		$this->load->view('admin/barang');
		$this->load->view('admin/templates/footer');
	}

	public function delete($id)
	{
		$where = array('id' => $id);

		$this->m_model->delete($where, 'tb_barang');
		$this->session->set_flashdata('pesan', 'Data berhasil dihapus!');
		redirect('admin/barang');
	}

	public function insert()
	{
		date_default_timezone_set('Asia/Jakarta');

		$kode       = $this->input->post('kode');
		$nama       = $this->input->post('nama');
		$stock      = $this->input->post('stock');

		// Validasi
		if ($stock === '' || $stock === null) {
			$this->session->set_flashdata('error', "Nilai 'stock' tidak boleh kosong.");
			redirect('admin/barang');
			return;
		}

		$terdaftar  = date('Y-m-d H:i:s');

		$data = array(
			'kode'      => $kode,
			'nama'      => $nama,
			'stock'     => $stock,
			'terdaftar' => $terdaftar,
		);

		// ... (lanjutan kode)

		$this->m_model->insert($data, 'tb_barang');
		$this->session->set_flashdata('pesan', 'Data berhasil ditambahkan!');
		redirect('admin/barang');
	}

	public function update($id)
	{
		$kode	    = $_POST['kode'];
		$nama	    = $_POST['nama'];
		$stock	    = $_POST['stock'];

		$data = array(
			'kode'      => $kode,
			'nama'      => $nama,
			'stock'      => $stock,
		);

		$where = array('id' => $id);

		$this->m_model->update($where, $data, 'tb_barang');
		$this->session->set_flashdata('pesan', 'Data berhasil diubah!');
		redirect('admin/barang');
	}

	public function detail_barang($id)
	{
		$data['title']		= 'Detail Barang';
		$data['subtitle']	= 'Semua data barang akan muncul disini';

		$data['collapse']	= 'Yes';

		$this->db->where('id', $id);
		$data['barang']       = $this->m_model->get_desc('tb_barang');
		$this->db->or_where('idBarang', $id);
		$this->db->or_where('idBarang2', $id);
		$data['booking_barang']       = $this->m_model->get_desc('tb_booking_barang');
		$data['booking_barang_barang2'] = $this->m_model->get_desc('tb_booking_barang');

		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar');
		$this->load->view('admin/detail_barang');
		$this->load->view('admin/templates/footer');
	}
}
