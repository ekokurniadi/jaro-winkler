<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Level extends MY_Controller {

    // protected $access = array('Admin', 'Pimpinan','Finance');
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('Level_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'level/index?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'level/index?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'level/index';
            $config['first_url'] = base_url() . 'level/index';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Level_model->total_rows($q);
        $level = $this->Level_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'level_data' => $level,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('header');
        $this->load->view('level_list', $data);
        $this->load->view('footer');
    }

    public function read($id) 
    {
        $row = $this->Level_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'level' => $row->level,
	    );
            $this->load->view('header');
            $this->load->view('level_read', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('level'));
        }
    }

    public function setting($id){
        $row = $this->Level_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Save All',
                'action' => site_url('level/settings_action'),
		'id' => set_value('id', $row->id),
		'level' => set_value('level', $row->level),
	    );
            $this->load->view('header');
            $this->load->view('level_setting_form', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('level'));
        }
    }

    public function settings_action(){
        		
            $id 		= $this->input->post('level');	
            $jum_data   = $this->input->post('jum_data');	
            $id_menu    = $this->input->post('menu');
            $cek = $this->db->query("SELECT * FROM access_level WHERE user_level = '$id'");
            if(count($cek) == 0){	
                for ($i=1; $i <= $jum_data; $i++) { 
                    if(isset($_POST["status".$i.""])) $akses = 1;
                        else $akses = 0;							
                    $id_menu 	= $_POST["menu".$i.""];
                    $data['user_level']  = $id;	
                    $data['menu']=$id_menu;
                    $data['status']=$akses;
                    
                    // print_r($data);
                    $testb= $this->db->insert('access_level', $data);			
                }					
            }else{	
                $del = $this->db->query("DELETE FROM access_level WHERE user_level = '$id'");		
                for ($i=1; $i <= $jum_data; $i++) { 
                    if(isset($_POST["status".$i.""])) $akses = 1;
                        else $akses = 0;							
                    $id_menu 	= $_POST["menu".$i.""];
                    $data['user_level']  = $id;	
                    $data['menu']=$id_menu;
                    $data['status']=$akses;
                    
                    // print_r($data);
                    $testb= $this->db->insert('access_level', $data);			
                }	
            }		
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('level'));
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('level/create_action'),
	    'id' => set_value('id'),
	    'level' => set_value('level'),
	);

        $this->load->view('header');
        $this->load->view('level_form', $data);
        $this->load->view('footer');
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'level' => $this->input->post('level',TRUE),
	    );

            $this->Level_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('level'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Level_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('level/update_action'),
		'id' => set_value('id', $row->id),
		'level' => set_value('level', $row->level),
	    );
            $this->load->view('header');
            $this->load->view('level_form', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('level'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'level' => $this->input->post('level',TRUE),
	    );

            $this->Level_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('level'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Level_model->get_by_id($id);

        if ($row) {
            $this->Level_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('level'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('level'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('level', 'level', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Level.php */
/* Location: ./application/controllers/Level.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-04-17 21:12:19 */
/* http://harviacode.com */