<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_model extends CI_Model
{

	public function get_where($where, $table)
	{
		return $this->db->get_where($table, $where);
	}

	public function insert($data, $table)
	{
		$this->db->insert($table, $data);
	}

	public function get_desc($table)
	{
		$this->db->ORDER_BY('id', 'desc');
		return $this->db->get($table);
	}

	public function delete($where, $table)
	{
		$this->db->delete($table, $where);
	}

	public function update($where, $data, $table)
	{
		$this->db->where($where);
		$this->db->update($table, $data);
	}

	public function UpdateStock($where, $status, $table)
	{
		$this->db->select();
		$this->db->where($where);
		$this->db->from($table);
		$booking = $this->db->get()->row();

		if (trim($status) === "Diterima") {
			$this->db->where("id", $booking->idBarang);
			$this->db->set("stock", 'stock-' . $booking->jumlah, FALSE);
			$this->db->update("tb_barang");

			$this->db->where("id", $booking->idBarang2);
			$this->db->set("stock", 'stock-' . $booking->jumlah2, FALSE);
			$this->db->update("tb_barang");
		}
	}
	public function UpdateStockKembali($where, $table)
	{
		$this->db->select();
		$this->db->where($where);
		$this->db->from($table);
		$booking = $this->db->get()->row();
		$this->db->where("id", $booking->idBarang);
		$this->db->set("stock", 'stock+' . $booking->jumlah, FALSE);
		$this->db->update("tb_barang");

		$this->db->where("id", $booking->idBarang2);
		$this->db->set("stock", 'stock+' . $booking->jumlah2, FALSE);
		$this->db->update("tb_barang");
	}

	public function UpdateStockKembaliFormRuangan($where, $table)
	{
		$this->db->select();
		$this->db->where($where);
		$this->db->from($table);
		$booking = $this->db->get()->row();
		$this->db->where("id", $booking->idBarang);
		$this->db->set("stock", 'stock+' . $booking->jumlah, FALSE);
		$this->db->update("tb_barang");
	}


	public function UpdateStockFromRuangan($where, $status, $table)
	{
		$this->db->select();
		$this->db->where($where);
		$this->db->from($table);
		$booking = $this->db->get()->row();

		if (trim($status) === "Diterima") {
			$this->db->where("id", $booking->idBarang);
			$this->db->set("stock", 'stock-' . $booking->jumlah, FALSE);
			$this->db->update("tb_barang");
		}
	}

	public function CekStock($id1, $id2, $jmlh, $tbl)
	{
		$this->db->select();
		$this->db->where('id', $id1);
		$this->db->from($tbl);
		$count1 = $this->db->get()->row()->stock;
		$this->db->select();
		$this->db->where('id', $id2);
		$this->db->from($tbl);
		$count2 = $this->db->get()->row()->stock;


		if ((int)$count1 > (int)$jmlh && (int)$count2 > (int)$jmlh) {
			return 1;
		} else if((int)$count1 = (int)$jmlh && (int)$count2 = (int)$jmlh) {
			return 1;
		} else {
			return 0;
		}
	}

	public function tampil_data()
	{
		return $this->db->get('tb_kegiatan');
	}
}
