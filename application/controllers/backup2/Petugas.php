<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Petugas extends MY_Controller {

    // protected $access = array('Admin', 'Pimpinan','Finance');
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('Petugas_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        
        $this->load->view('header');
        $this->load->view('petugas_list');
        $this->load->view('footer');
    }


    public function fetch_data(){
        $starts       = $this->input->post("start");
        $length       = $this->input->post("length");
        $LIMIT        = "LIMIT  $starts, $length ";
        $draw         = $this->input->post("draw");
        $search       = $this->input->post('search')['value'];
        $orders       = isset($_POST['order']) ? $_POST['order'] : ''; 
        
        $where ="WHERE 1=1 and area_name='{$_SESSION['area_name']}'";
        $searchingColumn;
        $result=array();
        if (isset($search)) {
          if ($search != '') {
             $searchingColumn = $search;
                $where .= " AND (name LIKE '%$search%'
                                OR NIK LIKE '%$search%'
                                OR address LIKE '%$search%'
                                OR cellular_no LIKE '%$search%'
                                OR groups LIKE '%$search%'
                                OR photo LIKE '%$search%'
                                OR status LIKE '%$search%'
                                OR level LIKE '%$search%'
                                OR area_name LIKE '%$search%'
                                )";
              }
          }

        if (isset($orders)) {
            if ($orders != '') {
              $order = $orders;
              $order_column = ['','name','NIK', 'address', 'cellular_no','groups','area_name','password','level'];
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
        $fetch = $this->db->query("SELECT * FROM petugas $where");
        $fetch2 = $this->db->query("SELECT * FROM petugas where area_name='{$_SESSION['area_name']}'");
        foreach($fetch->result() as $rows){
            $button1= "<a href=".base_url('petugas/read/'.$rows->id)." class='btn btn-icon icon-left btn-light'><i class='fa fa-eye'></i></a>";
          
            $button2= "<a href=".base_url('petugas/update/'.$rows->id)." class='btn btn-icon icon-left btn-warning'><i class='fa fa-pencil-square-o'></i></a>";
           
            $button3 = "<a href=".base_url('petugas/delete/'.$rows->id)." class='btn btn-icon icon-left btn-danger' onclick='javasciprt: return confirm(\"Are You Sure ?\")''><i class='fa fa-trash'></i></a>";
            $span    = $rows->status == "1" ? "<button class='btn btn-icon btn-success'><span class='fa fa-check-circle'></span></button>" : "<button class='btn btn-icon btn-danger'><span class='fa fa-exclamation-triangle'></span></button>";
            $sub_array=array();
            $sub_array[]=$index;
            $sub_array[]=$rows->name;
            $sub_array[]=$rows->NIK;
            $sub_array[]=$rows->address;
            $sub_array[]=$rows->cellular_no;
            if($rows->level=="Lapangan"){
                $sub_array[]=$this->db->get_where('grup',array('id'=>$rows->groups))->row()->group;
            }else{
                $sub_array[]="";
            }
            $sub_array[]=$rows->area_name;
            $sub_array[]=sha1($rows->password);
            $sub_array[]=$rows->level;
            $sub_array[]=$span;
            $sub_array[]="<img src=".base_url().'image/profil_user/'.$rows->photo." class='img-fluid' width='80px'>";
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
        $row = $this->Petugas_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'name' => $row->name,
		'NIK' => $row->NIK,
		'address' => $row->address,
		'cellular_no' => $row->cellular_no,
		'groups' => $row->groups,
		'photo' => $row->photo,
		'password' => $row->password,
		'status' => $row->status,
		'level' => $row->level,
		'area_name' => $row->area_name,
	    );
            $this->load->view('header');
            $this->load->view('petugas_read', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('dashboard'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('petugas/create_action'),
	    'id' => set_value('id'),
	    'name' => set_value('name'),
	    'NIK' => set_value('NIK'),
	    'address' => set_value('address'),
	    'cellular_no' => set_value('cellular_no'),
	    'groups' => set_value('groups'),
	    'photo' => set_value('photo'),
	    'password' => set_value('password'),
	    'status' => set_value('status'),
	    'level' => set_value('status'),
	    'area_name' => set_value('area_name'),
	);
       
        $data['areaOptions']=$this->db->get('area')->result();
        $data['levelOptions']=$this->db->get('level')->result();
        $this->load->view('header');
        $this->load->view('petugas_form', $data);
        $this->load->view('footer');
    }
    
    // public function create_action() 
    // {
    //     $this->_rules();

    //     if ($this->form_validation->run() == FALSE) {
    //         $this->create();
    //     } else {
    //         $data = array(
	// 	'name' => $this->input->post('name',TRUE),
	// 	'NIK' => $this->input->post('NIK',TRUE),
	// 	'address' => $this->input->post('address',TRUE),
	// 	'cellular_no' => $this->input->post('cellular_no',TRUE),
	// 	'groups' => $this->input->post('groups',TRUE),
	// 	'photo' => $this->input->post('photo',TRUE),
	// 	'password' => $this->input->post('password',TRUE),
	// 	'status' => $this->input->post('status',TRUE),
	// 	'level' => $this->input->post('level',TRUE),
	// 	'area_name' => $this->input->post('area_name',TRUE),
	//     );

    //         $this->Petugas_model->insert($data);
    //         $this->session->set_flashdata('message', 'Create Record Success');
    //         redirect(site_url('petugas'));
    //     }
    // }

     public function create_action() 
    {
        $this->load->library('upload');
            $nmfile = "user".time();
            $config['upload_path']   = './image/profil_user';
            $config['overwrite']     = true;
            $config['allowed_types'] = 'gif|jpeg|png|jpg|bmp|PNG|JPEG|JPG';
            $config['file_name'] = $nmfile;

            $this->upload->initialize($config);

            if($_FILES['photo']['name'])
            {
                if($this->upload->do_upload('photo'))
                {
                $gbr = $this->upload->data();
                $data = array(
                    'photo' =>  $gbr['file_name'],
                    'name' => $this->input->post('name',TRUE),
                    'NIK' => $this->input->post('NIK',TRUE),
                    'address' => $this->input->post('address',TRUE),
                    'cellular_no' => $this->input->post('cellular_no',TRUE),
                    'groups' => $this->input->post('groups',TRUE),
                    'password' => $this->input->post('password',TRUE),
                    'status' => $this->input->post('status',TRUE),
                    'level' => $this->input->post('level',TRUE),
                    'area_name' => $this->input->post('area_name',TRUE),
                );

               
                $this->Petugas_model->insert($data);
                $this->session->set_flashdata('message', 'Create Record Success');
                redirect(site_url('petugas'));
            }
        }
    }
    
    public function update($id) 
    {
        $row = $this->Petugas_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('petugas/update_action'),
		'id' => set_value('id', $row->id),
		'name' => set_value('name', $row->name),
		'NIK' => set_value('NIK', $row->NIK),
		'address' => set_value('address', $row->address),
		'cellular_no' => set_value('cellular_no', $row->cellular_no),
		'groups' => set_value('groups', $row->groups),
		'photo' => set_value('photo', $row->photo),
		'password' => set_value('password', $row->password),
		'status' => set_value('status', $row->status),
		'level' => set_value('level', $row->level),
		'area_name' => set_value('area_name', $row->area_name),
	    );
            $data['areaOptions']=$this->db->get('area')->result();
            $data['levelOptions']=$this->db->get('level')->result();
            $this->load->view('header');
            $this->load->view('petugas_form', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('petugas'));
        }
    }
    
    // public function update_action() 
    // {
    //     $this->_rules();

    //     if ($this->form_validation->run() == FALSE) {
    //         $this->update($this->input->post('id', TRUE));
    //     } else {
    //         $data = array(
	// 	'name' => $this->input->post('name',TRUE),
	// 	'NIK' => $this->input->post('NIK',TRUE),
	// 	'address' => $this->input->post('address',TRUE),
	// 	'cellular_no' => $this->input->post('cellular_no',TRUE),
	// 	'groups' => $this->input->post('groups',TRUE),
	// 	'photo' => $this->input->post('photo',TRUE),
	// 	'password' => $this->input->post('password',TRUE),
	// 	'status' => $this->input->post('status',TRUE),
    //     'level' => $this->input->post('level',TRUE),
	// 	'area_name' => $this->input->post('area_name',TRUE),
	//     );

    //         $this->Petugas_model->update($this->input->post('id', TRUE), $data);
    //         $this->session->set_flashdata('message', 'Update Record Success');
    //         redirect(site_url('petugas'));
    //     }
    // }

    public function update_action() 
    {
        $this->load->library('upload');
        $nmfile = "user".time();
        $config['upload_path']   = './image/profil_user';
        $config['overwrite']     = true;
        $config['allowed_types'] = 'gif|jpeg|png|jpg|bmp|PNG|JPEG|JPG';
        $config['file_name'] = $nmfile;

        $this->upload->initialize($config);
        
                if(!empty($_FILES['photo']['name']))
                {  
                        unlink("./image/profil_user/".$this->input->post('photo'));

                    if($_FILES['photo']['name'])
                    {
                        if($this->upload->do_upload('photo'))
                        {
                            $gbr = $this->upload->data();
                            $data = array(
                                'name' => $this->input->post('name',TRUE),
                                'NIK' => $this->input->post('NIK',TRUE),
                                'address' => $this->input->post('address',TRUE),
                                'cellular_no' => $this->input->post('cellular_no',TRUE),
                                'groups' => $this->input->post('groups',TRUE),
                                'photo' => $gbr['file_name'],
                                'password' => $this->input->post('password',TRUE),
                                'status' => $this->input->post('status',TRUE),
                                'level' => $this->input->post('level',TRUE),
                                'area_name' => $this->input->post('area_name',TRUE),
                            );
                        }
                    }
                  
                    $this->Petugas_model->update($this->input->post('id', TRUE), $data);
                    $this->session->set_flashdata('message', 'Update Record Success');
                    redirect(site_url('dashboard'));
                }
                    else
                        {
                            $data = array(
                                'name' => $this->input->post('name',TRUE),
                                'NIK' => $this->input->post('NIK',TRUE),
                                'address' => $this->input->post('address',TRUE),
                                'cellular_no' => $this->input->post('cellular_no',TRUE),
                                'groups' => $this->input->post('groups',TRUE),
                                'password' => $this->input->post('password',TRUE),
                                'status' => $this->input->post('status',TRUE),
                                'level' => $this->input->post('level',TRUE),
                                'area_name' => $this->input->post('area_name',TRUE),
                            );
                        }
                    
                        $this->Petugas_model->update($this->input->post('id', TRUE), $data);
                        $this->session->set_flashdata('message', 'Update Record Success');
                        redirect(site_url('dashboard'));
    }
    
    public function delete($id) 
    {
        $row = $this->Petugas_model->get_by_id($id);

        if ($row) {
            $this->Petugas_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('petugas'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('petugas'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('name', 'Nama', 'trim|required');
	$this->form_validation->set_rules('NIK', 'Username', 'trim|required');
	$this->form_validation->set_rules('address', 'Alamat', 'trim|required');
	$this->form_validation->set_rules('cellular_no', 'No. HP', 'trim|required');
	$this->form_validation->set_rules('groups', 'Grup', '');
	$this->form_validation->set_rules('photo', 'Foto', 'trim|required');
	$this->form_validation->set_rules('password', 'Password', 'trim|required');
	$this->form_validation->set_rules('status', 'Status', 'trim|required');
	$this->form_validation->set_rules('level', 'Level', 'trim|required');
	$this->form_validation->set_rules('area_name', 'Nama UP3', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Petugas.php */
/* Location: ./application/controllers/Petugas.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-04-16 04:51:37 */
/* http://harviacode.com */