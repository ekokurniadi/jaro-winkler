<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Operator_selular extends MY_Controller {

    // protected $access = array('Admin', 'Pimpinan','Finance');
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('Operator_selular_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'operator_selular/index?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'operator_selular/index?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'operator_selular/index';
            $config['first_url'] = base_url() . 'operator_selular/index';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Operator_selular_model->total_rows($q);
        $operator_selular = $this->Operator_selular_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'operator_selular_data' => $operator_selular,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('header');
        $this->load->view('operator_selular_list', $data);
        $this->load->view('footer');
    }

    public function read($id) 
    {
        $row = $this->Operator_selular_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'kode_operator' => $row->kode_operator,
		'nama_operator' => $row->nama_operator,
	    );
            $this->load->view('header');
            $this->load->view('operator_selular_read', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('operator_selular'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('operator_selular/create_action'),
	    'id' => set_value('id'),
	    'kode_operator' => set_value('kode_operator'),
	    'nama_operator' => set_value('nama_operator'),
	);

        $this->load->view('header');
        $this->load->view('operator_selular_form', $data);
        $this->load->view('footer');
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'kode_operator' => $this->input->post('kode_operator',TRUE),
		'nama_operator' => $this->input->post('nama_operator',TRUE),
	    );

            $this->Operator_selular_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('operator_selular'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Operator_selular_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('operator_selular/update_action'),
		'id' => set_value('id', $row->id),
		'kode_operator' => set_value('kode_operator', $row->kode_operator),
		'nama_operator' => set_value('nama_operator', $row->nama_operator),
	    );
            $this->load->view('header');
            $this->load->view('operator_selular_form', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('operator_selular'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'kode_operator' => $this->input->post('kode_operator',TRUE),
		'nama_operator' => $this->input->post('nama_operator',TRUE),
	    );

            $this->Operator_selular_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('operator_selular'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Operator_selular_model->get_by_id($id);

        if ($row) {
            $this->Operator_selular_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('operator_selular'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('operator_selular'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('kode_operator', 'kode operator', 'trim|required');
	$this->form_validation->set_rules('nama_operator', 'nama operator', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Operator_selular.php */
/* Location: ./application/controllers/Operator_selular.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-04-23 05:03:06 */
/* http://harviacode.com */