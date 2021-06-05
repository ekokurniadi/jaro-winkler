<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Setting_potongan extends MY_Controller {

    // protected $access = array('Admin', 'Pimpinan','Finance');
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('Setting_potongan_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'setting_potongan/index.dart?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'setting_potongan/index.dart?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'setting_potongan/index.dart';
            $config['first_url'] = base_url() . 'setting_potongan/index.dart';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Setting_potongan_model->total_rows($q);
        $setting_potongan = $this->Setting_potongan_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'setting_potongan_data' => $setting_potongan,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('header');
        $this->load->view('setting_potongan_list', $data);
        $this->load->view('footer');
    }

    public function read($id) 
    {
        $row = $this->Setting_potongan_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'potongan' => $row->potongan,
		'status' => $row->status,
	    );
            $this->load->view('header');
            $this->load->view('setting_potongan_read', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('setting_potongan'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('setting_potongan/create_action'),
	    'id' => set_value('id'),
	    'potongan' => set_value('potongan'),
	    'status' => set_value('status'),
	);

        $this->load->view('header');
        $this->load->view('setting_potongan_form', $data);
        $this->load->view('footer');
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'potongan' => $this->input->post('potongan',TRUE),
		'status' => $this->input->post('status',TRUE),
	    );

            $this->Setting_potongan_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('setting_potongan'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Setting_potongan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('setting_potongan/update_action'),
		'id' => set_value('id', $row->id),
		'potongan' => set_value('potongan', $row->potongan),
		'status' => set_value('status', $row->status),
	    );
            $this->load->view('header');
            $this->load->view('setting_potongan_form', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('setting_potongan'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'potongan' => $this->input->post('potongan',TRUE),
		'status' => $this->input->post('status',TRUE),
	    );

            $this->Setting_potongan_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('setting_potongan'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Setting_potongan_model->get_by_id($id);

        if ($row) {
            $this->Setting_potongan_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('setting_potongan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('setting_potongan'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('potongan', 'potongan', 'trim|required|numeric');
	$this->form_validation->set_rules('status', 'status', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Setting_potongan.php */
/* Location: ./application/controllers/Setting_potongan.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-03-21 07:14:07 */
/* http://harviacode.com */