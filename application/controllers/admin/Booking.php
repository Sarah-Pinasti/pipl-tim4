<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Booking extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('licensing');
		$this->licensing->check_license();
		if (!$this->session->userdata('level')) {
			$this->session->set_flashdata('pesan', 'Anda harus masuk terlebih dahulu!');
			redirect('home');
		}
	}

	public function index()
	{
		$data['title']		= 'Data Booking';
		$data['subtitle']	= 'Semua data booking akan muncul disini';

		$data['collapse']	= 'No';

		$data['ruangan']       = $this->m_model->get_desc('tb_ruangan');

		$data['barang']       = $this->m_model->get_desc('tb_barang');

		$data['instansi']       = $this->m_model->get_desc('tb_instansi');

		if ($this->session->userdata('level') == 'User') {
			$this->db->where('idUser', $this->session->userdata('id'));
		}

		$data['booking']       = $this->m_model->get_desc('tb_booking');

		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar');
		$this->load->view('admin/booking');
		$this->load->view('admin/templates/footer');
	}

	public function delete($id)
	{
		$where = array('id' => $id);

		$this->m_model->delete($where, 'tb_booking');
		$this->session->set_flashdata('pesan', 'Data berhasil dihapus!');
		redirect('admin/booking');
	}

	public function insert()
	{
		date_default_timezone_set('Asia/Jakarta');

		$config['upload_path']   = './application/views/admin/pdf_ruangan';
		$config['allowed_types'] = 'pdf';
		$config['max_size']      = 20480;

		$this->load->library('upload', $config);

		$surat = $this->input->post('surat');

		if ($surat == 'Ada' && !$this->upload->do_upload('file')) {
			// Gagal upload file
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('your_view', $error); // Tampilkan pesan error ke view
		} else {
			// Upload file berhasil atau surat tidak ada
			$data = array(
				'idUser'        => $this->session->userdata('id'),
				'idRuangan'     => $this->input->post('idRuangan'),
				'peminjam'      => $this->input->post('peminjam'),
				'idInstansi'    => $this->input->post('idInstansi'),
				'tanggal'       => $this->input->post('tanggal'),
				'dariJam'       => $this->input->post('dariJam'),
				'sampaiJam'     => $this->input->post('sampaiJam'),
				'agenda'        => $this->input->post('agenda'),
				'idBarang'      => $this->input->post('idBarang'),
				'jumlah'        => $this->input->post('jumlah'),
				'surat'         => $surat,
				'file'          => ($surat == 'Ada') ? $this->upload->data('file_name') : '', // Jika surat Ada, simpan nama file, jika tidak, biarkan kosong
				'status'        => 'Menunggu',
				'terdaftar'     => date('Y-m-d H:i:s')
			);

			$this->m_model->insert($data, 'tb_booking');
			$this->session->set_flashdata('pesan', 'Data berhasil ditambahkan!');
			redirect('admin/booking');
		}
	}


	public function update($id)
	{
		$idRuangan	= $_POST['idRuangan'];
		$peminjam	= $_POST['peminjam'];
		$idInstansi	= $_POST['idInstansi'];
		$tanggal	= $_POST['tanggal'];
		$dariJam	= $_POST['dariJam'];
		$sampaiJam	= $_POST['sampaiJam'];
		$agenda	    = $_POST['agenda'];
		$idBarang	= $_POST['idBarang'];
		$surat	    = $_POST['surat'];
		$file	    = $_POST['file'];

		$data = array(
			'idRuangan'     => $idRuangan,
			'peminjam'      => $peminjam,
			'idInstansi'    => $idInstansi,
			'tanggal'       => $tanggal,
			'dariJam'       => $dariJam,
			'sampaiJam'     => $sampaiJam,
			'agenda'        => $agenda,
			'idBarang'		=> $idBarang,
			'surat'        => $surat,
			'file'        => $file,
		);

		$where = array('id' => $id);

		$this->m_model->update($where, $data, 'tb_booking');
		$this->session->set_flashdata('pesan', 'Data berhasil diubah!');
		redirect('admin/booking');
	}

	public function respon($id)
	{
		$status	= $_POST['status'];

		$data = array(
			'status'     => $status,
		);

		$where = array('id' => $id);

		$this->m_model->update($where, $data, 'tb_booking');
		$this->m_model->UpdateStockFromRuangan($where, $status, 'tb_booking');
		$this->session->set_flashdata('pesan', 'Berhasil respon data!');
		redirect('admin/booking');
	}

	public function kembalikan($id)
	{
		$data = array(
			'status'     => "Kembali",
		);

		$where = array('id' => $id);
		$this->m_model->update($where, $data, 'tb_booking');
		$this->m_model->UpdateStockKembaliFormRuangan($where, 'tb_booking');
		$this->session->set_flashdata('pesan', 'Berhasil respon data!');
		redirect('admin/booking');
	}

	public function view_pdf($nama_file)
	{
		// Tentukan direktori tempat file PDF Anda disimpan.
		$pdf_dir = APPPATH . 'views/admin/pdf_ruangan/';

		// Buat path lengkap ke file PDF dengan nama dinamis.
		$pdf_path = $pdf_dir . $nama_file;

		// Cek apakah file PDF ada sebelum menampilkan.
		if (file_exists($pdf_path)) {
			// Set header untuk tipe konten PDF
			// Header content type
			header('Content-type: application/pdf');

			header('Content-Disposition: inline; filename="' . $nama_file . '"');

			header('Content-Transfer-Encoding: binary');

			header('Accept-Ranges: bytes');

			// Tampilkan file PDF
			readfile($pdf_path);
		} else {
			show_404(); // Tampilkan halaman 404 jika file tidak ditemukan.
		}
	}
}
