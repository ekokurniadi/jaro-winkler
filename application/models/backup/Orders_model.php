<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Orders_model extends CI_Model
{

    public $table = 'orders';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id', $q);
	$this->db->or_like('kode_order', $q);
	$this->db->or_like('nama_customer', $q);
	$this->db->or_like('nomor_wa', $q);
	$this->db->or_like('jadwal_kirim', $q);
	$this->db->or_like('jam', $q);
	$this->db->or_like('kota', $q);
	$this->db->or_like('lantai', $q);
	$this->db->or_like('parkir_mobil', $q);
	$this->db->or_like('kota_kirim', $q);
	$this->db->or_like('lantai_kirim', $q);
	$this->db->or_like('parkir_mobil_kirim', $q);
	$this->db->or_like('bantuan_customer', $q);
	$this->db->or_like('barang_customer', $q);
	$this->db->or_like('bantuan_driver', $q);
	$this->db->or_like('bantuan_kenek', $q);
	$this->db->or_like('biaya_tol', $q);
	$this->db->or_like('biaya_overload', $q);
	$this->db->or_like('waktu_tunggu', $q);
	$this->db->or_like('total_customer_bayar', $q);
	$this->db->or_like('cara_pembayaran', $q);
	$this->db->or_like('catatan', $q);
	$this->db->or_like('status', $q);
	$this->db->or_like('status_pengantaran', $q);
	$this->db->or_like('driver', $q);
	$this->db->or_like('created_at', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id', $q);
	$this->db->or_like('kode_order', $q);
	$this->db->or_like('nama_customer', $q);
	$this->db->or_like('nomor_wa', $q);
	$this->db->or_like('jadwal_kirim', $q);
	$this->db->or_like('jam', $q);
	$this->db->or_like('kota', $q);
	$this->db->or_like('lantai', $q);
	$this->db->or_like('parkir_mobil', $q);
	$this->db->or_like('kota_kirim', $q);
	$this->db->or_like('lantai_kirim', $q);
	$this->db->or_like('parkir_mobil_kirim', $q);
	$this->db->or_like('bantuan_customer', $q);
	$this->db->or_like('barang_customer', $q);
	$this->db->or_like('bantuan_driver', $q);
	$this->db->or_like('bantuan_kenek', $q);
	$this->db->or_like('biaya_tol', $q);
	$this->db->or_like('biaya_overload', $q);
	$this->db->or_like('waktu_tunggu', $q);
	$this->db->or_like('total_customer_bayar', $q);
	$this->db->or_like('cara_pembayaran', $q);
	$this->db->or_like('catatan', $q);
	$this->db->or_like('status', $q);
	$this->db->or_like('status_pengantaran', $q);
	$this->db->or_like('driver', $q);
	$this->db->or_like('created_at', $q);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}

/* End of file Orders_model.php */
/* Location: ./application/models/Orders_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-03-17 03:23:12 */
/* http://harviacode.com */