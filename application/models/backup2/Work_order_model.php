<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Work_order_model extends CI_Model
{

    public $table = 'work_order';
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
	$this->db->or_like('task_id', $q);
	$this->db->or_like('document_no', $q);
	$this->db->or_like('date', $q);
	$this->db->or_like('customer_id', $q);
	$this->db->or_like('activities', $q);
	$this->db->or_like('date_meter', $q);
	$this->db->or_like('time_meter', $q);
	$this->db->or_like('stand_meter_WBP', $q);
	$this->db->or_like('stand_meter_WBP1', $q);
	$this->db->or_like('stand_meter_WBP2', $q);
	$this->db->or_like('stand_meter_total', $q);
	$this->db->or_like('kvarh', $q);
	$this->db->or_like('voltage_r', $q);
	$this->db->or_like('voltage_s', $q);
	$this->db->or_like('voltage_t', $q);
	$this->db->or_like('current_r', $q);
	$this->db->or_like('current_s', $q);
	$this->db->or_like('current_t', $q);
	$this->db->or_like('cosphi', $q);
	$this->db->or_like('panel_condition', $q);
	$this->db->or_like('meter_dev_condition', $q);
	$this->db->or_like('meter_disp_condition', $q);
	$this->db->or_like('shuntrip_condition', $q);
	$this->db->or_like('current_limiter', $q);
	$this->db->or_like('current_limiter_type', $q);
	$this->db->or_like('current_limiter_brand', $q);
	$this->db->or_like('modem_condition', $q);
	$this->db->or_like('modem_imei', $q);
	$this->db->or_like('modem_type', $q);
	$this->db->or_like('modem_brand', $q);
	$this->db->or_like('ant_potition', $q);
	$this->db->or_like('Ratio_CT', $q);
	$this->db->or_like('top_panel_door_seal', $q);
	$this->db->or_like('bottom_panel_door_seal', $q);
	$this->db->or_like('meter_dev_seal', $q);
	$this->db->or_like('modem_seal', $q);
	$this->db->or_like('latitude', $q);
	$this->db->or_like('longitude', $q);
	$this->db->or_like('site_allocation', $q);
	$this->db->or_like('note', $q);
	$this->db->or_like('photo_panel', $q);
	$this->db->or_like('photo_meter_dev', $q);
	$this->db->or_like('photo_shuntrip', $q);
	$this->db->or_like('photo_current_limiter', $q);
	$this->db->or_like('photo_building', $q);
	$this->db->or_like('photo_1', $q);
	$this->db->or_like('photo_2', $q);
	$this->db->or_like('status', $q);
	$this->db->or_like('reason', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id', $q);
	$this->db->or_like('task_id', $q);
	$this->db->or_like('document_no', $q);
	$this->db->or_like('date', $q);
	$this->db->or_like('customer_id', $q);
	$this->db->or_like('activities', $q);
	$this->db->or_like('date_meter', $q);
	$this->db->or_like('time_meter', $q);
	$this->db->or_like('stand_meter_WBP', $q);
	$this->db->or_like('stand_meter_WBP1', $q);
	$this->db->or_like('stand_meter_WBP2', $q);
	$this->db->or_like('stand_meter_total', $q);
	$this->db->or_like('kvarh', $q);
	$this->db->or_like('voltage_r', $q);
	$this->db->or_like('voltage_s', $q);
	$this->db->or_like('voltage_t', $q);
	$this->db->or_like('current_r', $q);
	$this->db->or_like('current_s', $q);
	$this->db->or_like('current_t', $q);
	$this->db->or_like('cosphi', $q);
	$this->db->or_like('panel_condition', $q);
	$this->db->or_like('meter_dev_condition', $q);
	$this->db->or_like('meter_disp_condition', $q);
	$this->db->or_like('shuntrip_condition', $q);
	$this->db->or_like('current_limiter', $q);
	$this->db->or_like('current_limiter_type', $q);
	$this->db->or_like('current_limiter_brand', $q);
	$this->db->or_like('modem_condition', $q);
	$this->db->or_like('modem_imei', $q);
	$this->db->or_like('modem_type', $q);
	$this->db->or_like('modem_brand', $q);
	$this->db->or_like('ant_potition', $q);
	$this->db->or_like('Ratio_CT', $q);
	$this->db->or_like('top_panel_door_seal', $q);
	$this->db->or_like('bottom_panel_door_seal', $q);
	$this->db->or_like('meter_dev_seal', $q);
	$this->db->or_like('modem_seal', $q);
	$this->db->or_like('latitude', $q);
	$this->db->or_like('longitude', $q);
	$this->db->or_like('site_allocation', $q);
	$this->db->or_like('note', $q);
	$this->db->or_like('photo_panel', $q);
	$this->db->or_like('photo_meter_dev', $q);
	$this->db->or_like('photo_shuntrip', $q);
	$this->db->or_like('photo_current_limiter', $q);
	$this->db->or_like('photo_building', $q);
	$this->db->or_like('photo_1', $q);
	$this->db->or_like('photo_2', $q);
	$this->db->or_like('status', $q);
	$this->db->or_like('reason', $q);
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

/* End of file Work_order_model.php */
/* Location: ./application/models/Work_order_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-04-26 09:56:44 */
/* http://harviacode.com */