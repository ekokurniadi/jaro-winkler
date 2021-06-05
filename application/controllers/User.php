<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends MY_Controller {

    // protected $access = array('Admin', 'Pimpinan','Finance');
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('form_validation');
    }

    public function index()
    { 
        $this->load->view('header');
        $this->load->view('user_list');
        $this->load->view('footer');
    }

    public function read($id) 
    {
        $row = $this->User_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'nama' => $row->nama,
		'username' => $row->username,
        'password' => $row->password,
        'kode_ahass'=>$row->kode_ahass,
		'role' => $row->role,
	
	    );
            $this->load->view('header');
            $this->load->view('user_read', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('user'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('user/create_action'),
	    'id' => set_value('id'),
	    'nama' => set_value('nama'),
	    'username' => set_value('username'),
	    'password' => set_value('password'),
	    'role' => set_value('role'),
      
        
	);

        $this->load->view('header');
        $this->load->view('user_form', $data);
        $this->load->view('footer');
    }


    public function fetch_data(){
        $starts       = $this->input->post("start");
        $length       = $this->input->post("length");
        $LIMIT        = "LIMIT  $starts, $length ";
        $draw         = $this->input->post("draw");
        $search       = $this->input->post('search')['value'];
        $orders       = isset($_POST['order']) ? $_POST['order'] : ''; 
        
        $where ="WHERE 1=1";
        $searchingColumn;
        $result=array();
        if (isset($search)) {
          if ($search != '') {
             $searchingColumn = $search;
                $where .= " AND (nama LIKE '%$search%'
                                OR username LIKE '%$search%'
                                OR password LIKE '%$search%'
                                OR role LIKE '%$search%'
                                
                                )";
              }
          }

        if (isset($orders)) {
            if ($orders != '') {
              $order = $orders;
              $order_column = ['nama', 'username', 'password','role'];
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
        $fetch = $this->db->query("SELECT * FROM user $where");
        foreach($fetch->result() as $rows){
            $button1= "<a href=".base_url('user/read/'.$rows->id)." class='btn btn-icon icon-left btn-light'><i class='fa fa-eye'></i></a>";
          
            $button2= "<a href=".base_url('user/update/'.$rows->id)." class='btn btn-icon icon-left btn-warning'><i class='fa fa-pencil-square-o'></i></a>";
            
            $button3 = "<a href=".base_url('user/delete/'.$rows->id)." class='btn btn-icon icon-left btn-danger' onclick='javasciprt: return confirm(\"Are You Sure ?\")''><i class='fa fa-trash'></i></a>";
            $sub_array=array();
            $sub_array[]=$index;
            $sub_array[]=$rows->nama;
            $sub_array[]=$rows->username;
            $sub_array[]=sha1($rows->password);
            $sub_array[]=$rows->role;
            $sub_array[]=$button1." ".$button2." ".$button3;
            $result[]      = $sub_array;
            $index++;
        }
        $output = array(
          "draw"            =>     intval($this->input->post("draw")),
          "recordsFiltered" =>     $fetch->num_rows(),
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
		'nama' => $this->input->post('nama',TRUE),
		'username' => $this->input->post('username',TRUE),
		'password' => $this->input->post('password',TRUE),
		'role' => $this->input->post('role',TRUE),
		
	    );

            $this->User_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('user'));
        }
    }

    // public function create_action() 
    // {
    //     $this->load->library('upload');
    //         $nmfile = "user".time();
    //         $config['upload_path']   = './image/';
    //         $config['overwrite']     = true;
    //         $config['allowed_types'] = 'gif|jpeg|png|jpg|bmp|PNG|JPEG|JPG';
    //         $config['file_name'] = $nmfile;

    //         $this->upload->initialize($config);

    //         if($_FILES['foto']['name'])
    //         {
    //             if($this->upload->do_upload('foto'))
    //             {
    //             $gbr = $this->upload->data();
    //             $data = array(
    //                 'foto' =>  $gbr['file_name'],
    //                 'nama' => $this->input->post('nama',TRUE),
    //                 'username' => $this->input->post('username',TRUE),
    //                 'password' => $this->input->post('password',TRUE),
    //                 'role' => $this->input->post('role',TRUE),
    //                 'kode_ahass'=>$this->input->post('kode_ahass',TRUE),
    //             );

    //             $this->User_model->insert($data);
    //             $this->session->set_flashdata('message', 'Create Record Success');
    //             redirect(site_url('user'));
    //         }
    //     }
    // }

    
    public function update($id) 
    {
        $row = $this->User_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('user/update_action'),
		'id' => set_value('id', $row->id),
		'nama' => set_value('nama', $row->nama),
		'username' => set_value('username', $row->username),
		'password' => set_value('password', $row->password),
		'role' => set_value('role', $row->role),
       
	    );
            $this->load->view('header');
            $this->load->view('user_form', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('user'));
        }
    }
    
    // public function update_action() 
    // {
    //     $this->load->library('upload');
    //     $nmfile = "user".time();
    //     $config['upload_path']   = './image/';
    //     $config['overwrite']     = true;
    //     $config['allowed_types'] = 'gif|jpeg|png|jpg|bmp|PNG|JPEG|JPG';
    //     $config['file_name'] = $nmfile;

    //     $this->upload->initialize($config);
        
    //             if(!empty($_FILES['foto']['name']))
    //             {  
    //                     unlink("./image/".$this->input->post('foto'));

    //                 if($_FILES['foto']['name'])
    //                 {
    //                     if($this->upload->do_upload('foto'))
    //                     {
    //                         $gbr = $this->upload->data();
    //                         $data = array(
    //                             'nama' => $this->input->post('nama',TRUE),
    //                             'username' => $this->input->post('username',TRUE),
    //                             'password' => $this->input->post('password',TRUE),
    //                             'role' => $this->input->post('role',TRUE),
    //                             'foto' => $gbr['file_name'],
    //                             'kode_ahass'=>$this->input->post('kode_ahass',TRUE),
    //                         );
    //                     }
    //                 }
                  
    //                 $this->User_model->update($this->input->post('id', TRUE), $data);
    //                 $this->session->set_flashdata('message', 'Update Record Success');
    //                 redirect(site_url('user'));
    //             }
    //                 else
    //                     {
    //                         $data = array(
    //                             'nama' => $this->input->post('nama',TRUE),
    //                             'username' => $this->input->post('username',TRUE),
    //                             'password' => $this->input->post('password',TRUE),
    //                             'role' => $this->input->post('role',TRUE),
    //                             'kode_ahass'=>$this->input->post('kode_ahass',TRUE),
    //                         );
    //                     }
                    
    //                     $this->User_model->update($this->input->post('id', TRUE), $data);
    //                     $this->session->set_flashdata('message', 'Update Record Success');
    //                     redirect(site_url('user'));
    // }
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'nama' => $this->input->post('nama',TRUE),
		'username' => $this->input->post('username',TRUE),
		'password' => $this->input->post('password',TRUE),
		'role' => $this->input->post('role',TRUE),
		// 'foto' => $this->input->post('foto',TRUE),
	    );

            $this->User_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('user'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->User_model->get_by_id($id);

        if ($row) {
            // unlink('image/'.$row->foto);
            $this->User_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('user'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('user'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama', 'nama', 'trim|required');
	$this->form_validation->set_rules('username', 'username', 'trim|required');
	$this->form_validation->set_rules('password', 'password', 'trim|required');
	$this->form_validation->set_rules('role', 'role', 'trim|required');


	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "user.xls";
        $judul = "user";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
	xlsWriteLabel($tablehead, $kolomhead++, "Kode AHASS");
	xlsWriteLabel($tablehead, $kolomhead++, "Nama");
	xlsWriteLabel($tablehead, $kolomhead++, "Username");
	xlsWriteLabel($tablehead, $kolomhead++, "Password");
	xlsWriteLabel($tablehead, $kolomhead++, "Role");


	foreach ($this->User_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
            xlsWriteNumber($tablebody, $kolombody++, $kode_ahass);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama);
	    xlsWriteLabel($tablebody, $kolombody++, $data->username);
	    xlsWriteLabel($tablebody, $kolombody++, $data->password);
	    xlsWriteLabel($tablebody, $kolombody++, $data->role);
	  
	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=user.doc");

        $data = array(
            'user_data' => $this->User_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('user_doc',$data);
    }

}

/* End of file User.php */
/* Location: ./application/controllers/User.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2019-12-15 02:54:59 */
/* http://harviacode.com */