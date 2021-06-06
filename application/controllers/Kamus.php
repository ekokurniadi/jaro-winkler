<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kamus extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Kamus_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'kamus/index.dart?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'kamus/index.dart?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'kamus/index.dart';
            $config['first_url'] = base_url() . 'kamus/index.dart';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Kamus_model->total_rows($q);
        $kamus = $this->Kamus_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'kamus_data' => $kamus,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('header');
        $this->load->view('kata_dasar_list', $data);
        $this->load->view('footer');
    }

    public function read($id) 
    {
        $row = $this->Kamus_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'kata' => $row->kata,
		'arti' => $row->arti,
	    );
            $this->load->view('header');
            $this->load->view('kata_dasar_read', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kamus'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('kamus/create_action'),
	    'id' => set_value('id'),
	    'kata' => set_value('kata'),
	    'arti' => set_value('arti'),
	);

        $this->load->view('header');
        $this->load->view('kata_dasar_form', $data);
        $this->load->view('footer');
    }
    
    public function fetch_data(){
        $starts       = $this->input->post("start");
        $length       = $this->input->post("length");
        $LIMIT        = "LIMIT  $starts, $length ";
        $draw         = $this->input->post("draw");
        $search       = $this->input->post('search')['value'];
        $orders       = isset($_POST['order']) ? $_POST['order'] : '';

        $where ="WHERE 1=1 ";
        $searchingColumn;
        $result=array();
        if (isset($search)) {
          if ($search != '') {
             $searchingColumn = $search;
                $where .= " AND (kata LIKE '%$search%'
                                OR arti LIKE '%$search%'
                                )";
              }
          }
          if (isset($orders)) {
            if ($orders != '') {
              $order = $orders;
              $order_column = ['','kata','arti'];
              $order_clm  = $order_column[$order[0]['column']];
              $order_by   = $order[0]['dir'];
              $where .= " ORDER BY $order_clm $order_by ";
            } else {
              $where .= " ORDER BY id ASC ";
            }
          } else {
            $where .= " ORDER BY id ASC ";
          }
          if (isset($LIMIT)) {
            if ($LIMIT != '') {
              $where .= ' ' . $LIMIT;
            }
          }
        $index=1;
        $fetch = $this->db->query("SELECT * from kata_dasar $where");
        $fetch2 = $this->db->query("SELECT * from kata_dasar");
        foreach($fetch->result() as $rows){
            $button1= "<a href=".base_url('kamus/read/'.$rows->id)." class='btn btn-icon icon-left btn-light'><i class='fa fa-eye'></i></a>";
          
            $button2= "<a href=".base_url('kamus/update/'.$rows->id)." class='btn btn-icon icon-left btn-warning'><i class='fa fa-pencil-square-o'></i></a>";
            
            $button3 = "<a href=".base_url('kamus/delete/'.$rows->id)." class='btn btn-icon icon-left btn-danger' onclick='javasciprt: return confirm(\"Are You Sure ?\")''><i class='fa fa-trash'></i></a>";
            $sub_array=array();
            $sub_array[]=$index;
            $sub_array[]=$rows->kata;
            $sub_array[]=$rows->arti;
            $sub_array[]=$button1." ".$button2." ".$button3;  
            $result[]      = $sub_array;
            $index++;
        }
            $output = array(
                "draw"            =>     intval($this->input->post("draw")),
                "recordsFiltered" =>     $fetch2->num_rows(),
                "data"            =>     $result,
            );
          echo json_encode($output);
    }

    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'kata' => $this->input->post('kata',TRUE),
		'arti' => $this->input->post('arti',TRUE),
	    );

            $this->Kamus_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('kamus'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Kamus_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('kamus/update_action'),
		'id' => set_value('id', $row->id),
		'kata' => set_value('kata', $row->kata),
		'arti' => set_value('arti', $row->arti),
	    );
            $this->load->view('header');
            $this->load->view('kata_dasar_form', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kamus'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'kata' => $this->input->post('kata',TRUE),
		'arti' => $this->input->post('arti',TRUE),
	    );

            $this->Kamus_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('kamus'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Kamus_model->get_by_id($id);

        if ($row) {
            $this->Kamus_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('kamus'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kamus'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('kata', 'kata', 'trim|required');
	$this->form_validation->set_rules('arti', 'arti', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Kamus.php */
/* Location: ./application/controllers/Kamus.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-06-05 18:00:59 */
/* http://harviacode.com */