<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Area extends MY_Controller {

    // protected $access = array('Admin', 'Pimpinan','Finance');
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('Area_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'area/index.dart?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'area/index.dart?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'area/index.dart';
            $config['first_url'] = base_url() . 'area/index.dart';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Area_model->total_rows($q);
        $area = $this->Area_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'area_data' => $area,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('header');
        $this->load->view('area_list', $data);
        $this->load->view('footer');
    }


    public function fetch_data(){
        $starts       = $this->input->post("start");
        $length       = $this->input->post("length");
        $LIMIT        = "LIMIT $starts, $length ";
        $draw         = $this->input->post("draw");
        $search       = $this->input->post('search')['value'];
        $orders       = isset($_POST['order']) ? $_POST['order'] : ''; 
        
        $where ="WHERE 1=1";
        $searchingColumn;
        $result=array();
        if (isset($search)) {
          if ($search != '') {
             $searchingColumn = $search;
                $where .= " AND (reg_name LIKE '%$search%'
                                OR reg_code LIKE '%$search%'
                                OR area_name LIKE '%$search%'
                                OR area_code LIKE '%$search%'
                                )";
              }
          }

        if (isset($orders)) {
            if ($orders != '') {
              $order = $orders;
              $order_column = ['reg_name','reg_code','area_code','area_name','ULP','ULP_Kode'];
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
        $button="";
        $fetch = $this->db->query("SELECT * from area $where");
        $fetch2 = $this->db->query("SELECT * from area ");
        foreach($fetch->result() as $rows){
            $button1= "<a href=".base_url('area/read/'.$rows->id)." class='btn btn-icon icon-left btn-light'><i class='fa fa-eye'></i></a>";
            $button2= "<a href=".base_url('area/update/'.$rows->id)." class='btn btn-icon icon-left btn-warning'><i class='fa fa-pencil-square-o'></i></a>";
            $button3 = "<a href=".base_url('area/delete/'.$rows->id)." class='btn btn-icon icon-left btn-danger' onclick='javasciprt: return confirm(\"Are You Sure ?\")''><i class='fa fa-trash'></i></a>";
            $sub_array=array();
            $sub_array[]=$index;
            $sub_array[]=$rows->reg_name;
            $sub_array[]=$rows->reg_code;
            $sub_array[]=$rows->area_name;
            $sub_array[]=$rows->area_code;
            $sub_array[]=$rows->ULP;
            $sub_array[]=$rows->ULP_Kode;
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


    public function read($id) 
    {
        $row = $this->Area_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'reg_name' => $row->reg_name,
		'reg_code' => $row->reg_code,
		'area_name' => $row->area_name,
		'area_code' => $row->area_code,
	    );
            $this->load->view('header');
            $this->load->view('area_read', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('area'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('area/create_action'),
	    'id' => set_value('id'),
	    'reg_name' => set_value('reg_name'),
	    'reg_code' => set_value('reg_code'),
	    'area_name' => set_value('area_name'),
	    'area_code' => set_value('area_code'),
	);

        $this->load->view('header');
        $this->load->view('area_form', $data);
        $this->load->view('footer');
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'reg_name' => $this->input->post('reg_name',TRUE),
		'reg_code' => $this->input->post('reg_code',TRUE),
		'area_name' => $this->input->post('area_name',TRUE),
		'area_code' => $this->input->post('area_code',TRUE),
	    );

            $this->Area_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('area'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Area_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('area/update_action'),
		'id' => set_value('id', $row->id),
		'reg_name' => set_value('reg_name', $row->reg_name),
		'reg_code' => set_value('reg_code', $row->reg_code),
		'area_name' => set_value('area_name', $row->area_name),
		'area_code' => set_value('area_code', $row->area_code),
	    );
            $this->load->view('header');
            $this->load->view('area_form', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('area'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'reg_name' => $this->input->post('reg_name',TRUE),
		'reg_code' => $this->input->post('reg_code',TRUE),
		'area_name' => $this->input->post('area_name',TRUE),
		'area_code' => $this->input->post('area_code',TRUE),
	    );

            $this->Area_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('area'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Area_model->get_by_id($id);

        if ($row) {
            $this->Area_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('area'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('area'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('reg_name', 'reg name', 'trim|required');
	$this->form_validation->set_rules('reg_code', 'reg code', 'trim|required');
	$this->form_validation->set_rules('area_name', 'area name', 'trim|required');
	$this->form_validation->set_rules('area_code', 'area code', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Area.php */
/* Location: ./application/controllers/Area.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-04-17 04:46:07 */
/* http://harviacode.com */