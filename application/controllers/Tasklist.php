<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tasklist extends MY_Controller {

    // protected $access = array('Admin', 'Pimpinan','Finance');
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('Tasklist_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->load->view('header');
        $this->load->view('tasklist_list');
        $this->load->view('footer');
    }

    public function taskHistory()
    {
        $this->load->view('header');
        $this->load->view('history_tasklist_list');
        $this->load->view('footer');
    }

    public function index_mobile(){
        $_SESSION['level'] = $_GET['level']; 
        $_SESSION['area'] = $_GET['area']; 
		$data['level']=$_SESSION['level'];
		$data['area']=$_SESSION['area'];
		$this->load->view('header2');
		$this->load->view('tasklist_list2',$data);
		$this->load->view('footer2');
	}

    public function kode()
    {   
        $get_data = $this->db
        ->from('tasklist')
        ->limit(1)
        ->order_by('id', 'desc')
        ->get();
            
        if ($get_data->num_rows()>0) {
            $row        = $get_data->row();
            $kode_transaksi= substr($row->task_id, -8);
            $new_kode = "TL" . sprintf("%'.08d", $kode_transaksi+1);
        } else {
            $new_kode   = "TL00000001";
        }
        return strtoupper($new_kode);
    }

    function acak($panjang)
    {
      $karakter= 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789';
      $string = '';
      for ($i = 0; $i < $panjang; $i++) {
        $pos = rand(0, strlen($karakter)-1);
        $string .= $karakter{$pos};
      }
      return $string;
    }

    public function fetch_data(){
        $starts       = $this->input->post("start");
        $length       = $this->input->post("length");
        $LIMIT        = "LIMIT  $starts, $length ";
        $draw         = $this->input->post("draw");
        $search       = $this->input->post('search')['value'];
        $orders       = isset($_POST['order']) ? $_POST['order'] : ''; 
        
       
        if($_SESSION['level']=="Admin"){
            $where ="WHERE a.task_status in('Process','OTW','Belum')";
        }elseif ($_SESSION['level']=="Operator") {
            $where ="WHERE a.task_status in('Process','OTW','Belum') AND b.area_name='{$_SESSION['area_name']}'";
        }elseif ($_SESSION['level']=="Lapangan") {
            $where ="WHERE a.task_status in('Process','OTW','Belum') AND b.area_name='{$_SESSION['area_name']}'";
        }
        if($_SESSION['level']=="Admin"){
            $where2 ="WHERE a.task_status in('Process','OTW','Belum')";
        }elseif ($_SESSION['level']=="Operator") {
            $where2 ="WHERE a.task_status in('Process','OTW','Belum') AND b.area_name='{$_SESSION['area_name']}'";
        }elseif ($_SESSION['level']=="Lapangan") {
            $where2 ="WHERE a.task_status in('Process','OTW','Belum') AND b.area_name='{$_SESSION['area_name']}'";
        }
        $searchingColumn;
        $result=array();
        if (isset($search)) {
          if ($search != '') {
             $searchingColumn = $search;
                $where .= " AND ( a.date LIKE '%$search%'
                                OR a.customer_id LIKE '%$search%'
                                OR b.customer_name LIKE '%$search%'
                                OR b.address LIKE '%$search%'
                                OR a.task_status LIKE '%$search%'
                                OR a.indikasi LIKE '%$search%'
                                OR a.klasifikasi LIKE '%$search%'
                                )";
              }
          }

        if (isset($orders)) {
            if ($orders != '') {
              $order = $orders;
              $order_column = ['','a.date','a.customer_id','b.device_id','b.customer_name','b.address','a.indikasi','a.klasifikasi','a.task_status'];
              $order_clm  = $order_column[$order[0]['column']];
              $order_by   = $order[0]['dir'];
              $where .= " ORDER BY $order_clm $order_by ";
            } else {
              $where .= " ORDER BY a.klasifikasi DESC ";
            }
          } else {
            $where .= " ORDER BY a.klasifikasi DESC ";
          }
          if (isset($LIMIT)) {
            if ($LIMIT != '') {
              $where .= ' ' . $LIMIT;
            }
          }
        $index=1;
        $button="";
        $fetch = $this->db->query("SELECT a.*,b.customer_name,b.address,b.device_id FROM tasklist a join customer b on a.customer_id=b.customer_id $where");
        $fetch2 = $this->db->query("SELECT a.*,b.customer_name,b.address,b.device_id FROM tasklist a join customer b on a.customer_id=b.customer_id $where2");
        foreach($fetch->result() as $rows){
            // $button1= "<a href=".base_url('tasklist/read/'.$rows->id)." class='btn btn-icon icon-left btn-light'><i class='fa fa-eye'></i></a>";
          
            $button2= "<a href=".base_url('tasklist/update/'.$rows->id)." class='btn btn-icon icon-left btn-warning'>Proses<i class='fa fa-pencil-square-o'></i></a>";
            
            $button3 = "<a href=".base_url('tasklist/delete/'.$rows->id)." class='btn btn-icon icon-left btn-danger' onclick='javasciprt: return confirm(\"Are You Sure ?\")''>Delete<i class='fa fa-trash'></i></a>";
            $sub_array=array();
            $sub_array[]=$index;
            // $sub_array[]=$rows->task_id;
            $sub_array[]=formatTanggal($rows->date);
            $sub_array[]=$rows->customer_id;
            $sub_array[]=$rows->device_id;
            $sub_array[]=$rows->customer_name;
            $sub_array[]=$rows->address;
            $sub_array[]=$rows->indikasi;
            $sub_array[]=$rows->klasifikasi." Days Offline";
            $sub_array[]=$rows->task_status;
            $sub_array[]=$button2." ".$button3;
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

    public function fetch_data2(){
        $starts       = $this->input->post("start");
        $length       = $this->input->post("length");
        $LIMIT        = "LIMIT  $starts, $length ";
        $draw         = $this->input->post("draw");
        $search       = $this->input->post('search')['value'];
        $orders       = isset($_POST['order']) ? $_POST['order'] : ''; 
        $level        = $this->input->post('level');
		$area         = ucwords($this->input->post('area'));
       
        if($level=="Admin"){
            $where ="WHERE a.task_status in('Process','OTW','Belum')";
        }elseif ($level=="Operator") {
            $where ="WHERE a.task_status in('Process','OTW','Belum') AND b.area_name='$area'";
        }elseif ($level=="Lapangan") {
            $where ="WHERE a.task_status in('Process','OTW','Belum') AND b.area_name='$area'";
        }
        if($level=="Admin"){
            $where2 ="WHERE a.task_status in('Process','OTW','Belum')";
        }elseif ($level=="Operator") {
            $where2 ="WHERE a.task_status in('Process','OTW','Belum') AND b.area_name='$area'";
        }elseif ($level=="Lapangan") {
            $where2 ="WHERE a.task_status in('Process','OTW','Belum') AND b.area_name='$area'";
        }
        $searchingColumn;
        $result=array();
        if (isset($search)) {
          if ($search != '') {
             $searchingColumn = $search;
                $where .= " AND ( a.date LIKE '%$search%'
                                OR a.customer_id LIKE '%$search%'
                                OR b.customer_name LIKE '%$search%'
                                OR b.address LIKE '%$search%'
                                OR a.task_status LIKE '%$search%'
                                OR a.indikasi LIKE '%$search%'
                                OR a.klasifikasi LIKE '%$search%'
                                )";
              }
          }

        if (isset($orders)) {
            if ($orders != '') {
              $order = $orders;
              $order_column = ['','a.date','a.customer_id','b.device_id','b.customer_name','b.address','a.indikasi','a.klasifikasi','a.task_status'];
              $order_clm  = $order_column[$order[0]['column']];
              $order_by   = $order[0]['dir'];
              $where .= " ORDER BY $order_clm $order_by ";
            } else {
              $where .= " ORDER BY a.klasifikasi DESC ";
            }
          } else {
            $where .= " ORDER BY a.klasifikasi DESC ";
          }
          if (isset($LIMIT)) {
            if ($LIMIT != '') {
              $where .= ' ' . $LIMIT;
            }
          }
        $index=1;
        $button="";
        $fetch = $this->db->query("SELECT a.*,b.customer_name,b.area_name,b.address,b.device_id FROM tasklist a left join customer b on a.customer_id=b.customer_id $where");
        $fetch2 = $this->db->query("SELECT a.*,b.customer_name,b.area_name,b.address,b.device_id FROM tasklist a left join customer b on a.customer_id=b.customer_id $where2");
        foreach($fetch->result() as $rows){
            // $button1= "<a href=".base_url('tasklist/read/'.$rows->id)." class='btn btn-icon icon-left btn-light'><i class='fa fa-eye'></i></a>";
          
            $button2= "<a href=".base_url('tasklist/update2?id='.$rows->id.'&level='.$_SESSION['level'].'&area='.$_SESSION['area'])." class='btn btn-icon icon-left btn-warning'>Proses<i class='fa fa-pencil-square-o'></i></a>";
            
            // $button3 = "<a href=".base_url('tasklist/delete/'.$rows->id)." class='btn btn-icon icon-left btn-danger' onclick='javasciprt: return confirm(\"Are You Sure ?\")''>Delete<i class='fa fa-trash'></i></a>";
            $sub_array=array();
            $sub_array[]=$index;
            // $sub_array[]=$rows->task_id;
            $sub_array[]=formatTanggal($rows->date);
            $sub_array[]=$rows->customer_id;
            $sub_array[]=$rows->device_id;
            $sub_array[]=$rows->customer_name;
            $sub_array[]=$rows->address;
            $sub_array[]=$rows->indikasi;
            $sub_array[]=$rows->klasifikasi." Days Offline";
            $sub_array[]=$rows->task_status;
            $sub_array[]=$button2;
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

    


    public function history_fetch_data(){
        $starts       = $this->input->post("start");
        $length       = $this->input->post("length");
        $LIMIT        = "LIMIT  $starts, $length ";
        $draw         = $this->input->post("draw");
        $search       = $this->input->post('search')['value'];
        $orders       = isset($_POST['order']) ? $_POST['order'] : ''; 
        
       
        if($_SESSION['level']=="Admin"){
            $where ="WHERE a.task_status in('Complete','Cancel')";
        }elseif ($_SESSION['level']=="Operator") {
            $where ="WHERE a.task_status in('Complete','Cancel') AND b.area_name='{$_SESSION['area_name']}'";
        }elseif ($_SESSION['level']=="Lapangan") {
            $where ="WHERE a.task_status in('Complete','Cancel') AND b.area_name='{$_SESSION['b.area_name']}'";
        }
        if($_SESSION['level']=="Admin"){
            $where2 ="WHERE a.task_status in('Complete','Cancel')";
        }elseif ($_SESSION['level']=="Operator") {
            $where2 ="WHERE a.task_status in('Complete','Cancel') AND b.area_name='{$_SESSION['area_name']}'";
        }elseif ($_SESSION['level']=="Lapangan") {
            $where2 ="WHERE a.task_status in('Complete','Cancel') AND b.area_name='{$_SESSION['b.area_name']}'";
        }
        $searchingColumn;
        $result=array();
        if (isset($search)) {
          if ($search != '') {
             $searchingColumn = $search;
                $where .= " AND (a.date LIKE '%$search%'
                                OR a.customer_id LIKE '%$search%'
                                OR b.customer_name LIKE '%$search%'
                                OR b.address LIKE '%$search%'
                                OR a.task_status LIKE '%$search%'
                                OR a.indikasi LIKE '%$search%'
                                OR a.klasifikasi LIKE '%$search%'
                                )";
              }
          }

        if (isset($orders)) {
            if ($orders != '') {
              $order = $orders;
              $order_column = ['','a.date','a.customer_id','b.device_id','b.customer_name','b.address','a.indikasi','a.klasifikasi','a.task_status'];
              $order_clm  = $order_column[$order[0]['column']];
              $order_by   = $order[0]['dir'];
              $where .= " ORDER BY $order_clm $order_by ";
            } else {
              $where .= " ORDER BY a.klasifikasi DESC ";
            }
          } else {
            $where .= " ORDER BY a.klasifikasi DESC ";
          }
          if (isset($LIMIT)) {
            if ($LIMIT != '') {
              $where .= ' ' . $LIMIT;
            }
          }
        $index=1;
        $button="";
        $fetch = $this->db->query("SELECT a.*,b.customer_name,b.address,b.device_id FROM tasklist a join customer b on a.customer_id=b.customer_id $where");
        $fetch2 = $this->db->query("SELECT a.*,b.customer_name,b.address,b.device_id FROM tasklist a join customer b on a.customer_id=b.customer_id $where2");
        foreach($fetch->result() as $rows){
            // $button1= "<a href=".base_url('tasklist/read/'.$rows->id)." class='btn btn-icon icon-left btn-light'><i class='fa fa-eye'></i></a>";
          
            // $button2= "<a href=".base_url('tasklist/update/'.$rows->id)." class='btn btn-icon icon-left btn-warning'>Proses<i class='fa fa-pencil-square-o'></i></a>";
            
            // $button3 = "<a href=".base_url('tasklist/delete/'.$rows->id)." class='btn btn-icon icon-left btn-danger' onclick='javasciprt: return confirm(\"Are You Sure ?\")''>Delete<i class='fa fa-trash'></i></a>";
            $sub_array=array();
            $sub_array[]=$index;
            // $sub_array[]=$rows->task_id;
            $sub_array[]=formatTanggal($rows->date);
            $sub_array[]=$rows->customer_id;
            $sub_array[]=$rows->device_id;
            $sub_array[]=$rows->customer_name;
            $sub_array[]=$rows->address;
            $sub_array[]=$rows->indikasi;
            $sub_array[]=$rows->klasifikasi." Days Offline";
            $sub_array[]=$rows->task_status;
            // $sub_array[]=$button2." ".$button3;
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
        $row = $this->Tasklist_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'task_id' => $row->task_id,
		'date' => $row->date,
		'groups' => $row->groups,
		'customer_id' => $row->customer_id,
		'task_status' => $row->task_status,
		'indikasi' => $row->indikasi,
		'klasifikasi' => $row->klasifikasi,
	    );
            $this->load->view('header');
            $this->load->view('tasklist_read', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tasklist'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('tasklist/create_action'),
	    'id' => set_value('id'),
	    'task_id' => $this->acak(10),
	    'date' => set_value('date'),
	    'groups' => set_value('groups'),
	    'customer_id' => set_value('customer_id'),
	    'task_status' => set_value('task_status'),
        'customer_name' => set_value('customer_name'),
		'address' => set_value('address'),
		'dial_status' => set_value('dial_status'),
		'indikasi' => set_value('indikasi'),
		'klasifikasi' => set_value('klasifikasi'),
	);

        $this->load->view('header');
        $this->load->view('tasklist_form', $data);
        $this->load->view('footer');
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $var = $this->input->post('date');
            $date = str_replace('/', '-', $var);
            $data = array(
		'task_id' => $this->input->post('task_id',TRUE),
		'date' => date('Y-m-d H:i:s', strtotime($date)),
		'groups' => $this->input->post('groups',TRUE),
		'customer_id' => $this->input->post('customer_id',TRUE),
		'task_status' => $this->input->post('task_status',TRUE),
        'indikasi' => $this->input->post('indikasi',TRUE),
		'klasifikasi' => $this->input->post('klasifikasi',TRUE),
	    );

            $this->Tasklist_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('tasklist'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Tasklist_model->get_by_id($id);
        $pelanggan = $this->db->query("SELECT a.customer_name,a.address,a.response,b.dial_status from customer a join dial_status b on b.customer_Id=a.customer_id where b.customer_Id='$row->customer_id'")->row();
        if ($row) {
            
            $data = array(
                'button' => 'Update',
                'action' => site_url('tasklist/update_action'),
		'id' => set_value('id', $row->id),
		'task_id' => set_value('task_id', $row->task_id),
		'date' => set_value('date', $row->date),
		'groups' => set_value('groups', $row->groups),
		'customer_id' => set_value('customer_id', $row->customer_id),
		'customer_name' => set_value('customer_name', $pelanggan->customer_name),
		'address' => set_value('address', $pelanggan->address),
		'dial_status' => set_value('dial_status', $pelanggan->dial_status),
		'task_status' => set_value('task_status', $row->task_status),
		'indikasi' => set_value('indikasi', $row->indikasi),
		'klasifikasi' => set_value('klasifikasi', $row->klasifikasi),
	    );
            $this->load->view('header');
            $this->load->view('tasklist_form', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tasklist'));
        }
    }

    public function update2()

    {
        $id = $_GET['id'];
        $area=$_GET['area'];
        $level=$_GET['level'];
        $row = $this->Tasklist_model->get_by_id($id);
        $pelanggan = $this->db->query("SELECT a.customer_name,a.address,a.response,b.dial_status from customer a join dial_status b on b.customer_Id=a.customer_id where b.customer_Id='$row->customer_id'")->row();
        if ($row) {
            
            $data = array(
                'button' => 'Save All',
                'action' => site_url('tasklist/update_action2'),
		'id' => set_value('id', $row->id),
		'task_id' => set_value('task_id', $row->task_id),
		'date' => set_value('date', $row->date),
		'groups' => set_value('groups', $row->groups),
		'customer_id' => set_value('customer_id', $row->customer_id),
		'customer_name' => set_value('customer_name', $pelanggan->customer_name),
		'address' => set_value('address', $pelanggan->address),
		'dial_status' => set_value('dial_status', $pelanggan->dial_status),
		'task_status' => set_value('task_status', $row->task_status),
		'indikasi' => set_value('indikasi', $row->indikasi),
		'klasifikasi' => set_value('klasifikasi', $row->klasifikasi),
		'level' => set_value('level', $level),
		'area' => set_value('area', $area),
	    );
            $this->load->view('header2');
            $this->load->view('tasklist_form2', $data);
            $this->load->view('footer2');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tasklist/index_mobile'));
        }
    }
    
    public function update_action2() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            echo "<script>
                alert('Group tidak boleh kosong');
                history.go(-1);
            </script>";
        } else {
            $var = $this->input->post('date');
            $date = str_replace('/', '-', $var);
            $idcus = $this->input->post('customer_id',TRUE);
            $getArea = $this->db->get_where('grup',array('id'=>$this->input->post('groups',TRUE)))->row()->nama_up3;
            $customer = $this->db->query("SELECT * FROM customer where customer_id='$idcus'")->row();
            $data = array(
		'task_id' => $this->input->post('task_id',TRUE),
		'date' => $this->input->post('date'),
		'groups' => $this->input->post('groups',TRUE),
		'customer_id' => $this->input->post('customer_id',TRUE),
		'indikasi' => $this->input->post('indikasi',TRUE),
		'area_name' => $getArea,
		'klasifikasi' => $this->input->post('klasifikasi',TRUE),
		'task_status' => "Persiapan",
		'status' => "1",
	    );
        $data_wo = array(
            "task_id"=>$this->input->post('task_id',TRUE),
            "date"=>$this->input->post('date'),
            "customer_id"=> $this->input->post('customer_id',TRUE),
            "groups"=> $this->input->post('groups',TRUE),
            "area_name"=> $getArea,
            "status"=>"Persiapan",
            "modem_imei"=>$customer->imei_modem,
            "modem_type"=>$customer->tipe_modem,
            "modem_brand"=>$customer->merk_modem,
            "latitude"=>$customer->coordinate,
            "longitude"=>$customer->location,
        );
        $groups= $this->input->post('groups',TRUE);
            $this->db->insert('work_order',$data_wo);
            $cari_group = $this->db->get_where('petugas',array('groups'=>$groups));
            $title = "Notifikasi Tugas";
            $body = "kamu mendapatkan notifikasi tugas baru.";
            $screen ="list_trx";
            $server_key = get_setting('server_fcm_app');
            foreach($cari_group->result() as $rows){
                $hasil = $this->send_notif($server_key,$rows->token,$title, $body, $screen);
                $insert_notif = array(
                    "user_id"=>$rows->id,
                    "pesan"=>$body,
                    "status"=>"0",
                    "created"=>date('Y-m-d H:i:s'),
                    "deleted"=>"0"
                );
                $ins = $this->db->insert("notifikasi",$insert_notif);
            }
            $area=$this->input->post('area');
            $level=$this->input->post('level');
            $this->Tasklist_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            
            redirect(base_url('tasklist/index_mobile?level='.$level.'&area='.$area.''));
        }
    }

    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $var = $this->input->post('date');
            $date = str_replace('/', '-', $var);
            $idcus = $this->input->post('customer_id',TRUE);
            $getArea = $this->db->get_where('grup',array('id'=>$this->input->post('groups',TRUE)))->row()->nama_up3;
            $customer = $this->db->query("SELECT * FROM customer where customer_id='$idcus'")->row();
            $data = array(
		'task_id' => $this->input->post('task_id',TRUE),
		'date' => $this->input->post('date'),
		'groups' => $this->input->post('groups',TRUE),
		'customer_id' => $this->input->post('customer_id',TRUE),
		'indikasi' => $this->input->post('indikasi',TRUE),
		'area_name' => $getArea,
		'klasifikasi' => $this->input->post('klasifikasi',TRUE),
		'task_status' => "Persiapan",
		'status' => "1",
	    );
        $data_wo = array(
            "task_id"=>$this->input->post('task_id',TRUE),
            "date"=>$this->input->post('date'),
            "customer_id"=> $this->input->post('customer_id',TRUE),
            "groups"=> $this->input->post('groups',TRUE),
            "area_name"=> $getArea,
            "status"=>"Persiapan",
            "modem_imei"=>$customer->imei_modem,
            "modem_type"=>$customer->tipe_modem,
            "modem_brand"=>$customer->merk_modem,
            "latitude"=>$customer->coordinate,
            "longitude"=>$customer->location,
        );
        $groups= $this->input->post('groups',TRUE);
            $this->db->insert('work_order',$data_wo);
            $cari_group = $this->db->get_where('petugas',array('groups'=>$groups));
            $title = "Notifikasi Tugas";
            $body = "kamu mendapatkan notifikasi tugas baru.";
            $screen ="list_trx";
            $server_key = get_setting('server_fcm_app');
            foreach($cari_group->result() as $rows){
                $hasil = $this->send_notif($server_key,$rows->token,$title, $body, $screen);
                $insert_notif = array(
                    "user_id"=>$rows->id,
                    "pesan"=>$body,
                    "status"=>"0",
                    "created"=>date('Y-m-d H:i:s'),
                    "deleted"=>"0"
                );
                $ins = $this->db->insert("notifikasi",$insert_notif);
            }
            $this->Tasklist_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('tasklist'));
        }
    }

   
    
    public function delete($id) 
    {
        $row = $this->Tasklist_model->get_by_id($id);

        if ($row) {
            $this->Tasklist_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('tasklist'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tasklist'));
        }
    }

    public function getTaskDetail(){
		$id = $this->input->post('id');
		$query = $this->db->query("SELECT * FROM work_order where id='$id'");
		$result=array();
		if($query->num_rows()>0){
			$data=array(
				"id"=>$query->row()->id,
				"task_id"=>$query->row()->task_id,
			);
			echo json_encode(array(
				"status"=>200,
				"message"=>"Success",
				"data"=>$data,
			));
		}else{
			echo json_encode(array(
				"status"=>"error",
				"message"=>"Data tidak ditemukan",	
			));
		}
	}

	private function send_notif($server_key,$token,$title, $body, $screen)
	{
		# agar diparse sebagai JSON di browser
		header('Content-Type:application/json');

		# atur zona waktu sender server ke Jakarta (WIB / GMT+7)
		date_default_timezone_set("Asia/Jakarta");


		$headers = [
		'Content-Type:application/json',
		'Accept:application/json',
		'Authorization: key='.$server_key.''
		];


		// echo $post_raw_json;
		// exit();
		

		# Inisiasi CURL request
		$ch = curl_init();

		# atur CURL Options
		curl_setopt_array($ch, array(
		CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send', # URL endpoint
		CURLOPT_HTTPHEADER => $headers, # HTTP Headers
		CURLOPT_RETURNTRANSFER => 1, # return hasil curl_exec ke variabel, tidak langsung dicetak
		CURLOPT_FOLLOWLOCATION => 1, # atur flag followlocation untuk mengikuti bila ada url redirect di server penerima tetap difollow
		CURLOPT_CONNECTTIMEOUT => 60, # set connection timeout ke 60 detik, untuk mencegah request gantung saat server mati
		CURLOPT_TIMEOUT => 60, # set timeout ke 120 detik, untuk mencegah request gantung saat server hang
		CURLOPT_POST => 1, # set method request menjadi POST
		CURLOPT_POSTFIELDS => '{"notification": {"body": "'.$body.'","title": "'.$title.'","sound": "default","badge":"1"}, "priority": "high", "data": {"click_action": "FLUTTER_NOTIFICATION_CLICK", "screen": "'.$screen.'", "status": "done"}, "to": "'.$token.'"}', # attached post data dalam bentuk JSON String,
		// CURLOPT_VERBOSE => 1, # mode debug
		// CURLOPT_HEADER => 1, # cetak header
		CURLOPT_SSL_VERIFYPEER => true  
		));

		# eksekusi CURL request dan tampung hasil responsenya ke variabel $resp
		$resp = curl_exec($ch);

		# validasi curl request tidak error
		if (curl_errno($ch) == false) {
		# jika curl berhasil
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if ($http_code == 200) {
		  # http code === 200 berarti request sukses (harap pastikan server penerima mengirimkan http_code 200 jika berhasil)
		//   return $resp;
			$send = '{"notification": {"body": "'.$body.'","title": "'.$title.'","sound": "default","badge":"1"}, "priority": "high", "data": {"click_action": "FLUTTER_NOTIFICATION_CLICK", "screen": "'.$screen.'", "status": "done"}, "to": "'.$token.'"}';
			$this->db->insert('log_notif', array('log'=>$send,'resp'=>$resp));
			return $resp;
		} else {
		  # selain itu request gagal (contoh: error 404 page not found)
		  // echo 'Error HTTP Code : '.$http_code."\n";
		  
			$send = '{"notification": {"body": "'.$body.'","title": "'.$title.'","sound": "default","badge":"1"}, "priority": "high", "data": {"click_action": "FLUTTER_NOTIFICATION_CLICK", "screen": "'.$screen.'", "status": "done"}, "to": "'.$token.'"}';
			$this->db->insert('log_notif', array('log'=>$send,'resp'=>$resp));
			return $resp;
		}
		} else {
		# jika curl error (contoh: request timeout)
		# Daftar kode error : https://curl.haxx.se/libcurl/c/libcurl-errors.html
		// echo "Error while sending request, reason:".curl_error($ch);
		}

		# tutup CURL
		curl_close($ch);
	}

    public function _rules() 
    {
	$this->form_validation->set_rules('task_id', 'task id', 'trim|required');
	$this->form_validation->set_rules('date', 'date', 'trim|required');
	$this->form_validation->set_rules('groups', 'groups', 'trim|required');
	$this->form_validation->set_rules('customer_id', 'customer id', 'trim|required');
	$this->form_validation->set_rules('task_status', 'task status', 'trim|required');
	

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Tasklist.php */
/* Location: ./application/controllers/Tasklist.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-04-19 05:02:33 */
/* http://harviacode.com */