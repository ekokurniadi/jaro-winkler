<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pengujian extends MY_Controller {

    // protected $access = array('Admin', 'Pimpinan','Finance');
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('Pengujian_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'pengujian/index.dart?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'pengujian/index.dart?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'pengujian/index.dart';
            $config['first_url'] = base_url() . 'pengujian/index.dart';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Pengujian_model->total_rows($q);
        $pengujian = $this->Pengujian_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'pengujian_data' => $pengujian,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('header');
        $this->load->view('pengujian_list', $data);
        $this->load->view('footer');
    }

    public function read($id) 
    {
        $row = $this->Pengujian_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'teks' => $row->teks,
		'cleaning' => $row->cleaning,
		'casefolding' => $row->casefolding,
		'tokenizing' => $row->tokenizing,
		'stemming' => $row->stemming,
		'rekomendasi' => $row->rekomendasi,
	    );
            $this->load->view('header');
            $this->load->view('pengujian_read', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pengujian'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('pengujian/create_action'),
	    'id' => set_value('id'),
	    'teks' => set_value('teks'),
	    'cleaning' => set_value('cleaning'),
	    'casefolding' => set_value('casefolding'),
	    'tokenizing' => set_value('tokenizing'),
	    'stemming' => set_value('stemming'),
	    'rekomendasi' => set_value('rekomendasi'),
	);

        $this->load->view('header');
        $this->load->view('pengujian_form', $data);
        $this->load->view('footer');
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'teks' => $this->input->post('teks',TRUE),
		'cleaning' => $this->input->post('cleaning',TRUE),
		'casefolding' => $this->input->post('casefolding',TRUE),
		'tokenizing' => $this->input->post('tokenizing',TRUE),
		'stemming' => $this->input->post('stemming',TRUE),
		'rekomendasi' => $this->input->post('rekomendasi',TRUE),
	    );

            $this->Pengujian_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('pengujian'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Pengujian_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('pengujian/update_action'),
		'id' => set_value('id', $row->id),
		'teks' => set_value('teks', $row->teks),
		'cleaning' => set_value('cleaning', $row->cleaning),
		'casefolding' => set_value('casefolding', $row->casefolding),
		'tokenizing' => set_value('tokenizing', $row->tokenizing),
		'stemming' => set_value('stemming', $row->stemming),
		'rekomendasi' => set_value('rekomendasi', $row->rekomendasi),
	    );
            $this->load->view('header');
            $this->load->view('pengujian_form', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pengujian'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'teks' => $this->input->post('teks',TRUE),
		'cleaning' => $this->input->post('cleaning',TRUE),
		'casefolding' => $this->input->post('casefolding',TRUE),
		'tokenizing' => $this->input->post('tokenizing',TRUE),
		'stemming' => $this->input->post('stemming',TRUE),
		'rekomendasi' => $this->input->post('rekomendasi',TRUE),
	    );

            $this->Pengujian_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('pengujian'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Pengujian_model->get_by_id($id);

        if ($row) {
            $this->Pengujian_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('pengujian'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pengujian'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('teks', 'teks', 'trim|required');
	$this->form_validation->set_rules('cleaning', 'cleaning', 'trim|required');
	$this->form_validation->set_rules('casefolding', 'casefolding', 'trim|required');
	$this->form_validation->set_rules('tokenizing', 'tokenizing', 'trim|required');
	$this->form_validation->set_rules('stemming', 'stemming', 'trim|required');
	$this->form_validation->set_rules('rekomendasi', 'rekomendasi', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Pengujian.php */
/* Location: ./application/controllers/Pengujian.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-06-06 03:12:43 */
/* http://harviacode.com */