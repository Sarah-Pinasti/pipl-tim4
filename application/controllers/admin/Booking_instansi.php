<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Booking_instansi extends CI_Controller
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
		$data['title']		= 'Data Booking Instansi';
		$data['subtitle']	= 'Semua data booking instansi akan muncul disini';

		$data['collapse']	= 'No';

		$data['instansi']       = $this->m_model->get_desc('tb_instansi');


		if ($this->session->userdata('level') == 'User') {
			$this->db->where('idUser', $this->session->userdata('id'));
		}

		$data['booking_instansi']       = $this->m_model->get_desc('tb_booking_instansi');

		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar');
		$this->load->view('admin/booking_instansi');
		$this->load->view('admin/templates/footer');
	}

	public function delete($id)
	{
		$where = array('id' => $id);

		$this->m_model->delete($where, 'tb_booking_instansi');
		$this->session->set_flashdata('pesan', 'Data berhasil dihapus!');
		redirect('admin/booking_instansi');
	}

	public function insert()
	{
		date_default_timezone_set('Asia/Jakarta');

		$idUser	    = $this->session->userdata('id');
		$idInstansi	= $_POST['idInstansi'];
		$peminjam	= $_POST['peminjam'];
		$tanggal	= $_POST['tanggal'];
		$dariJam	= $_POST['dariJam'];
		$sampaiJam	= $_POST['sampaiJam'];
		$agenda	    = $_POST['agenda'];
		$idBarang	= $_POST['idBarang'];
		$surat	    = $_POST['surat'];
		$status	    = 'Menunggu';
		$terdaftar	= date('Y-m-d H:i:s');

		$data = array(
			'idUser'        => $idUser,
			'idInstansi'     => $idInstansi,
			'peminjam'      => $peminjam,
			'tanggal'       => $tanggal,
			'dariJam'       => $dariJam,
			'sampaiJam'     => $sampaiJam,
			'agenda'        => $agenda,
			'idBarang'		=> $idBarang,
			'surat'			=> $surat,
			'status'        => $status,
			'terdaftar'     => $terdaftar,
		);

		$this->m_model->insert($data, 'tb_booking_instansi');
		$this->session->set_flashdata('pesan', 'Data berhasil ditambahkan!');
		redirect('admin/booking_instansi');
	}

	public function update($id)
	{
		$idInstansi	= $_POST['idInstansi'];
		$peminjam	= $_POST['peminjam'];
		$tanggal	= $_POST['tanggal'];
		$dariJam	= $_POST['dariJam'];
		$sampaiJam	= $_POST['sampaiJam'];
		$agenda	    = $_POST['agenda'];
		$idBarang	= $_POST['idBarang'];
		$surat	    = $_POST['surat'];

		$data = array(
			'idInstansi'     => $idInstansi,
			'peminjam'      => $peminjam,
			'tanggal'       => $tanggal,
			'dariJam'       => $dariJam,
			'sampaiJam'     => $sampaiJam,
			'agenda'        => $agenda,
			'idBarang'		=> $idBarang,
			'surat'        => $surat,
		);

		$where = array('id' => $id);

		$this->m_model->update($where, $data, 'tb__instansi');
		$this->session->set_flashdata('pesan', 'Data berhasil diubah!');
		redirect('admin/booking_instansi');
	}

	public function respon($id)
	{
		$status	= $_POST['status'];

		$data = array(
			'status'     => $status,
		);

		$where = array('id' => $id);

		$this->m_model->update($where, $data, 'tb_booking_instansi');
		$this->session->set_flashdata('pesan', 'Berhasil respon data!');
		redirect('admin/booking_instansi');
	}
}
