<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Grup extends MY_Controller {

    // protected $access = array('Admin', 'Pimpinan','Finance');
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('Grup_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'grup/index.dart?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'grup/index.dart?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'grup/index.dart';
            $config['first_url'] = base_url() . 'grup/index.dart';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Grup_model->total_rows($q);
        $grup = $this->Grup_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'grup_data' => $grup,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('header');
        $this->load->view('grup_list', $data);
        $this->load->view('footer');
    }

    public function read($id) 
    {
        $row = $this->Grup_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'kode_up3' => $row->kode_up3,
		'nama_up3' => $row->nama_up3,
		'group' => $row->group,
	    );
            $this->load->view('header');
            $this->load->view('grup_read', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('grup'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('grup/create_action'),
	    'id' => set_value('id'),
	    'kode_up3' => set_value('kode_up3'),
	    'nama_up3' => set_value('nama_up3'),
	    'group' => set_value('group'),
	);

        $this->load->view('header');
        $this->load->view('grup_form', $data);
        $this->load->view('footer');
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'kode_up3' => $this->input->post('kode_up3',TRUE),
		'nama_up3' => $this->input->post('nama_up3',TRUE),
		'group' => $this->input->post('group',TRUE),
	    );

            $this->Grup_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('grup'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Grup_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('grup/update_action'),
		'id' => set_value('id', $row->id),
		'kode_up3' => set_value('kode_up3', $row->kode_up3),
		'nama_up3' => set_value('nama_up3', $row->nama_up3),
		'group' => set_value('group', $row->group),
	    );
            $this->load->view('header');
            $this->load->view('grup_form', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('grup'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'kode_up3' => $this->input->post('kode_up3',TRUE),
		'nama_up3' => $this->input->post('nama_up3',TRUE),
		'group' => $this->input->post('group',TRUE),
	    );

            $this->Grup_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('grup'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Grup_model->get_by_id($id);

        if ($row) {
            $this->Grup_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('grup'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('grup'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('kode_up3', 'kode up3', 'trim|required');
	$this->form_validation->set_rules('nama_up3', 'nama up3', 'trim|required');
	$this->form_validation->set_rules('group', 'group', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Grup.php */
/* Location: ./application/controllers/Grup.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-04-27 15:00:42 */
/* http://harviacode.com */