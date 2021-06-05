<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Zakat extends MY_Controller {

    // protected $access = array('Admin', 'Pimpinan','Finance');
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('Zakat_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'zakat/index.dart?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'zakat/index.dart?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'zakat/index.dart';
            $config['first_url'] = base_url() . 'zakat/index.dart';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Zakat_model->total_rows($q);
        $zakat = $this->Zakat_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'zakat_data' => $zakat,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('header');
        $this->load->view('zakat_list', $data);
        $this->load->view('footer');
    }

    public function read($id) 
    {
        $row = $this->Zakat_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'tanggal_awal' => $row->tanggal_awal,
		'tanggal_akhir' => $row->tanggal_akhir,
		'total_penjualan' => $row->total_penjualan,
		'total_keuntungan' => $row->total_keuntungan,
		'zakat' => $row->zakat,
	    );
            $this->load->view('header');
            $this->load->view('zakat_read', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('zakat'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('zakat/create_action'),
	    'id' => set_value('id'),
	    'tanggal_awal' => set_value('tanggal_awal'),
	    'tanggal_akhir' => set_value('tanggal_akhir'),
	    'total_penjualan' => set_value('total_penjualan'),
	    'total_keuntungan' => set_value('total_keuntungan'),
	    'zakat' => set_value('zakat'),
	);

        $this->load->view('header');
        $this->load->view('zakat_form', $data);
        $this->load->view('footer');
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'tanggal_awal' => $this->input->post('tanggal_awal',TRUE),
		'tanggal_akhir' => $this->input->post('tanggal_akhir',TRUE),
		'total_penjualan' => $this->input->post('total_penjualan',TRUE),
		'total_keuntungan' => $this->input->post('total_keuntungan',TRUE),
		'zakat' => $this->input->post('zakat',TRUE),
	    );

            $this->Zakat_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('zakat'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Zakat_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('zakat/update_action'),
		'id' => set_value('id', $row->id),
		'tanggal_awal' => set_value('tanggal_awal', $row->tanggal_awal),
		'tanggal_akhir' => set_value('tanggal_akhir', $row->tanggal_akhir),
		'total_penjualan' => set_value('total_penjualan', $row->total_penjualan),
		'total_keuntungan' => set_value('total_keuntungan', $row->total_keuntungan),
		'zakat' => set_value('zakat', $row->zakat),
	    );
            $this->load->view('header');
            $this->load->view('zakat_form', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('zakat'));
        }
    }


    public function hitung_zakat(){
        $tanggal_awal = $_GET['tanggal_awal'];
        $tanggal_akhir = $_GET['tanggal_akhir'];

        $data =$this->db->query("SELECT COALESCE(SUM(total)) as total,COALESCE(SUM(laba)) as laba from detail_transaksi where tanggal_transaksi BETWEEN '$tanggal_awal' AND '$tanggal_akhir'")->row();
        $result = array();
        $sub_array=array();
        $sub_array[]=$data->total;
        $sub_array[]=$data->laba;
        $sub_array[]=(String)$data->laba * 0.025;
        $result[] = $sub_array;

        echo json_encode($result);
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'tanggal_awal' => $this->input->post('tanggal_awal',TRUE),
		'tanggal_akhir' => $this->input->post('tanggal_akhir',TRUE),
		'total_penjualan' => $this->input->post('total_penjualan',TRUE),
		'total_keuntungan' => $this->input->post('total_keuntungan',TRUE),
		'zakat' => $this->input->post('zakat',TRUE),
	    );

            $this->Zakat_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('zakat'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Zakat_model->get_by_id($id);

        if ($row) {
            $this->Zakat_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('zakat'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('zakat'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('tanggal_awal', 'tanggal awal', 'trim|required');
	$this->form_validation->set_rules('tanggal_akhir', 'tanggal akhir', 'trim|required');
	$this->form_validation->set_rules('total_penjualan', 'total penjualan', 'trim|required|numeric');
	$this->form_validation->set_rules('total_keuntungan', 'total keuntungan', 'trim|required|numeric');
	$this->form_validation->set_rules('zakat', 'zakat', 'trim|required|numeric');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Zakat.php */
/* Location: ./application/controllers/Zakat.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-02-16 15:41:04 */
/* http://harviacode.com */