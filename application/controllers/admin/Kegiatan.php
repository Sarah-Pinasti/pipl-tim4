<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Kegiatan extends CI_Controller
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
		$data['title']		= 'Data Kegiatan';
		$data['subtitle']	= 'Semua data kegiatan akan muncul disini';

		$data['collapse']	= 'No';

		$data['kegiatan']   = $this->m_model->get_desc('tb_kegiatan');

		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar');
		$this->load->view('admin/kegiatan');
		$this->load->view('admin/templates/footer');
	}

	public function delete($id)
	{
		$where = array('id' => $id);

		$this->m_model->delete($where, 'tb_kegiatan');
		$this->session->set_flashdata('pesan', 'Data berhasil dihapus!');
		redirect('admin/kegiatan');
	}

	public function insert()
	{
		date_default_timezone_set('Asia/Jakarta');

		$kode	    = $_POST['kode'];
		$nama	    = $_POST['nama'];
		$tanggal    = $_POST['tanggal'];
		$waktu	    = $_POST['waktu'];
		$tempat	    = $_POST['tempat'];
		$pegawai	= $_POST['pegawai'];
		$terdaftar	= date('Y-m-d H:i:s');

		$data = array(
			'kode'      => $kode,
			'nama'      => $nama,
			'tanggal'   => $tanggal,
			'waktu'     => $waktu,
			'tempat'    => $tempat,
			'pegawai'    => $pegawai,
			'terdaftar' => $terdaftar,
		);

		$this->m_model->insert($data, 'tb_kegiatan');
		$this->session->set_flashdata('pesan', 'Data berhasil ditambahkan!');
		redirect('admin/kegiatan');
	}

	public function update($id)
	{
		$kode	    = $_POST['kode'];
		$nama	    = $_POST['nama'];
		$tanggal    = $_POST['tanggal'];
		$waktu	    = $_POST['waktu'];
		$tempat	    = $_POST['tempat'];
		$pegawai	= $_POST['pegawai'];

		$data = array(
			'kode'      => $kode,
			'nama'      => $nama,
			'tanggal'   => $tanggal,
			'waktu'     => $waktu,
			'tempat'    => $tempat,
			'pegawai'    => $pegawai,
		);

		$where = array('id' => $id);

		$this->m_model->update($where, $data, 'tb_kegiatan');
		$this->session->set_flashdata('pesan', 'Data berhasil diubah!');
		redirect('admin/kegiatan');
	}

	public function detail($id)
	{
		$data['title']		= 'Detail Kegiatan';
		$data['subtitle']	= 'Semua data kegiatan akan muncul disini';

		$data['collapse']	= 'Yes';

		$this->db->where('id', $id);
		$data['kegiatan']       = $this->m_model->get_desc('tb_kegiatan');
		$this->db->where('idKegiatan', $id);
		$data['booking_kegiatan']       = $this->m_model->get_desc('tb_booking_kegiatan');

		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar');
		$this->load->view('admin/detail');
		$this->load->view('admin/templates/footer');
	}

	public function cetakpdf()
	{
		$data['kegiatan'] = $this->m_model->tampil_data('tb_kegiatan')->result();
		$this->load->library('pdf');
		$this->pdf->setPaper('A4', 'portrait');
		$this->pdf->filename = "Laporan-Data-Siswa-.pdf";
		$this->pdf->load_view('pdfcetak', $data);
	}

	public function excel()
	{

		$data['kegiatan'] = $this->m_model->tampil_data('tb_kegiatan')->result();

		require(APPPATH . 'PHPExcel-1.8/Classes/PHPExcel.php');
		require(APPPATH . 'PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');

		$object = new PHPExcel();

		$object->getProperties()->setCreator("Fariq Aditya Rahman");
		$object->getProperties()->setLastModifiedBy("Fariq Aditya Rahman");
		$object->getProperties()->setTitle("Data Kegiatan");

		$object->setActiveSheetIndex(0);

		$object->getActiveSheet()->setCellValue('A1', 'NO.');
		$object->getActiveSheet()->setCellValue('B1', 'Kode');
		$object->getActiveSheet()->setCellValue('C1', 'Nama Kegiatan');
		$object->getActiveSheet()->setCellValue('D1', 'Tanggal');
		$object->getActiveSheet()->setCellValue('E1', 'Waktu');
		$object->getActiveSheet()->setCellValue('F1', 'Tempat');
		$object->getActiveSheet()->setCellValue('G1', 'Pegawai');

		$baris = 2;
		$no = 1;

		foreach ($data['kegiatan'] as $kgt) {
			$object->getActiveSheet()->setCellValue('A' . $baris, $no++);
			$object->getActiveSheet()->setCellValue('B' . $baris, $kgt->kode);
			$object->getActiveSheet()->setCellValue('C' . $baris, $kgt->nama);
			$object->getActiveSheet()->setCellValue('D' . $baris, $kgt->tanggal);
			$object->getActiveSheet()->setCellValue('E' . $baris, $kgt->waktu);
			$object->getActiveSheet()->setCellValue('F' . $baris, $kgt->tempat);
			$object->getActiveSheet()->setCellValue('G' . $baris, $kgt->pegawai);

			$baris++;
		}

		$filename = "Data_Kegiatan" . '.xlsx';

		$object->getActiveSheet()->setTitle("Data Kegiatan");

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition:attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');


		$writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
		ob_end_clean();
		$writer->save('php://output');
	}
}
