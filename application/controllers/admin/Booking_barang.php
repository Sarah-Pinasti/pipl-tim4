<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Booking_barang extends CI_Controller
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
		$data['title']		= 'Data Booking Barang';
		$data['subtitle']	= 'Semua data booking akan muncul disini';

		$data['collapse']	= 'No';

		$data['barang']       = $this->m_model->get_desc('tb_barang');

		$data['instansi']       = $this->m_model->get_desc('tb_instansi');

		if ($this->session->userdata('level') == 'User') {
			$this->db->where('idUser', $this->session->userdata('id'));
		}

		$data['booking_barang']       = $this->m_model->get_desc('tb_booking_barang');

		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar');
		$this->load->view('admin/booking_barang');
		$this->load->view('admin/templates/footer');
	}

	public function delete($id)
	{
		$where = array('id' => $id);

		$this->m_model->delete($where, 'tb_booking_barang');
		$this->session->set_flashdata('pesan', 'Data berhasil dihapus!');
		redirect('admin/booking_barang');
	}

	public function insert()
	{
		date_default_timezone_set('Asia/Jakarta');

		$config['upload_path']		= './application/views/admin/pdf_barang';
		$config['allowed_types']	= 'pdf|png|jpg';
		$config['max_size'] 		= 20480;
		// $config['max_width']		= 10000;
		// $config['max_height']		= 10000;

		$this->load->library('upload', $config);

		$surat = $this->input->post('surat');

		if ($surat == 'Ada' && !$this->upload->do_upload('file')) {
			// Gagal upload file
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('your_view', $error); // Tampilkan pesan error ke view
		} else {

			$data = array(
				'idUser'        => $this->session->userdata('id'),
				'idBarang'     => $this->input->post('idBarang'),
				'jumlah'		=> $this->input->post('jumlah'),
				'idBarang2'     => $this->input->post('idBarang2'),
				'jumlah2'		=> $this->input->post('jumlah2'),
				'peminjam'      => $this->input->post('peminjam'),
				'idInstansi'    => $this->input->post('idInstansi'),
				'tanggal'       => $this->input->post('tanggal'),
				'dariJam'       => $this->input->post('dariJam'),
				'sampaiJam'     => $this->input->post('sampaiJam'),
				'agenda'        => $this->input->post('agenda'),
				'surat'			=> $surat,
				'file'          => ($surat == 'Ada') ? $this->upload->data('file_name') : '', // Jika surat Ada, simpan nama file, jika tidak, biarkan kosong
				'status'        => 'Menunggu',
				'terdaftar'     => date('Y-m-d H:i:s')
			);

			$cekstock = $this->m_model->CekStock($this->input->post('idBarang'), $this->input->post('idBarang2'), $this->input->post('jumlah'), 'tb_barang');
			if ((int) $cekstock > 0) {
				$this->m_model->insert($data, 'tb_booking_barang');
				$this->session->set_flashdata('pesan', 'Data berhasil ditambahkan!');
				redirect('admin/booking_barang');
			} else {
				$this->session->set_flashdata('pesanError', 'Stock barang tidak memenuhi permintaan');
				redirect('admin/booking_barang');
			}
		}

		// date_default_timezone_set('Asia/Jakarta');

		// $idUser	    = $this->session->userdata('id');
		// $idBarang	= $_POST['idBarang'];
		// $peminjam	= $_POST['peminjam'];
		// $idInstansi	= $_POST['idInstansi'];
		// $tanggal	= $_POST['tanggal'];
		// $dariJam	= $_POST['dariJam'];
		// $sampaiJam	= $_POST['sampaiJam'];
		// $agenda	    = $_POST['agenda'];
		// $jumlah		= $_POST['jumlah'];
		// $surat	    = $_POST['surat'];
		// $file		= $_FILES['file'];
		// $status	    = 'Menunggu';
		// $terdaftar	= date('Y-m-d H:i:s');

		// $config['upload_path']		= './application/views/admin/pdf_barang';
		// $config['allowed_types']	= 'pdf';
		// $config['max_size']			= 10000;
		// $config['max_width']		= 10000;
		// $config['max_height']		= 10000;

		// $this->load->library('upload', $config);

		// if(! $this->upload->do_upload('file')) {
		// 	echo "Gagal Tambah";
		// } else {
		// 	$file = $this->upload->data();
		// 	$file = $file['file_name'];
		// }

		// $data = array(
		//     'idUser'        => $idUser,
		//     'idBarang'      => $idBarang,
		// 	'peminjam'      => $peminjam,
		// 	'idInstansi'    => $idInstansi,
		//     'tanggal'       => $tanggal,
		//     'dariJam'       => $dariJam,
		//     'sampaiJam'     => $sampaiJam,
		//     'agenda'        => $agenda,
		// 	'jumlah'		=> $jumlah,
		// 	'surat'         => $surat,
		// 	'file'			=> $file,
		//     'status'        => $status,
		//     'terdaftar'     => $terdaftar,
		// );

		// $this->m_model->insert($data,'tb_booking_barang');
		// $this->session->set_flashdata('pesan', 'Data berhasil ditambahkan!');
		// redirect('admin/booking_barang');
	}

	public function update($id)
	{
		$idBarang	= $_POST['idBarang'];
		$idBarang2	= $_POST['idBarang2'];
		$peminjam	= $_POST['peminjam'];
		$idInstansi	= $_POST['idInstansi'];
		$tanggal	= $_POST['tanggal'];
		$dariJam	= $_POST['dariJam'];
		$sampaiJam	= $_POST['sampaiJam'];
		$agenda	    = $_POST['agenda'];
		$jumlah		= $_POST['jumlah'];
		$surat		= $_POST['surat'];
		$file	    = $_POST['file'];

		$data = array(
			'idBarang'    	=> $idBarang,
			'idBarang2'    	=> $idBarang2,
			'peminjam'      => $peminjam,
			'idInstansi'    => $idInstansi,
			'tanggal'       => $tanggal,
			'dariJam'       => $dariJam,
			'sampaiJam'     => $sampaiJam,
			'agenda'        => $agenda,
			'jumlah'		=> $jumlah,
			'surat'        => $surat,
			'file'        => $file,
		);

		$where = array('id' => $id);

		$this->m_model->update($where, $data, 'tb_booking_barang');
		$this->session->set_flashdata('pesan', 'Data berhasil diubah!');
		redirect('admin/booking_barang');
	}

	public function respon($id)
	{
		$status	= $_POST['status'];

		$data = array(
			'status'     => $status,
		);

		$where = array('id' => $id);

		$this->m_model->update($where, $data, 'tb_booking_barang');
		$this->m_model->UpdateStock($where, $status, 'tb_booking_barang');
		$this->session->set_flashdata('pesan', 'Berhasil respon data!');
		redirect('admin/booking_barang');
	}

	public function kembalikan($id)
	{
		$data = array(
			'status'     => "Kembali",
		);

		$where = array('id' => $id);
		$this->m_model->update($where, $data, 'tb_booking_barang');
		$this->m_model->UpdateStockKembali($where, 'tb_booking_barang');
		$this->session->set_flashdata('pesan', 'Berhasil respon data!');
		redirect('admin/booking_barang');
	}

	public function view_pdf($nama_file)
	{
		// Tentukan direktori tempat file PDF Anda disimpan.
		$pdf_dir = APPPATH . 'views/admin/pdf_barang/';

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
