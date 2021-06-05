<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dial_status extends MY_Controller {

    // protected $access = array('Admin', 'Pimpinan','Finance');
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('Dial_status_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->load->view('header');
        $this->load->view('dial_status_list');
        $this->load->view('footer');
    }

    public function uploads()
    {
        $this->load->view('header');
        $this->load->view('import_view_dial');
        $this->load->view('footer');
    }

    public function fetch_data(){
        $filter_columns = $this->input->post("filter_columns");
        $filter_value = $this->input->post("filter_value");
        $starts       = $this->input->post("start");
        $length       = $this->input->post("length");
        $LIMIT        = "LIMIT $starts, $length ";
        $draw         = $this->input->post("draw");
        $search       = $this->input->post('search')['value'];
        $orders       = isset($_POST['order']) ? $_POST['order'] : ''; 
        if($filter_columns == "" || $filter_value==""){
          $where ="WHERE 1=1";
        }else{
          $where ="WHERE 1=1 and $filter_columns like'%$filter_value%'";
        }
        $searchingColumn;
        $result=array();
        if (isset($search)) {
          if ($search != '') {
             $searchingColumn = $search;
                $where .= " AND (a.customer_Id LIKE '%$search%'
                                OR a.dial_status LIKE '%$search%'
                                OR a.area_name LIKE '%$search%'
                                OR a.area_code LIKE '%$search%'
                                OR a.date LIKE '%$search%'
                                OR a.uid LIKE '%$search%'
                                OR b.customer_name LIKE '%$search%'
                                OR b.response LIKE '%$search%'
                                OR b.rate LIKE '%$search%'
                                OR b.device_id LIKE '%$search%'
                                OR b.cellular_no LIKE '%$search%'
                                OR b.IP_address LIKE '%$search%'
                                OR c.ULP LIKE '%$search%'
                                )";
              }
          }

        if (isset($orders)) {
            if ($orders != '') {
              $order = $orders;
              $order_column = ['','a.customer_Id','b.customer_name','b.address','b.rate','b.device_id','b.cellular_no','b.IP_address','','b.response','c.ULP','a.area_name'];
              $order_clm  = $order_column[$order[0]['column']];
              $order_by   = $order[0]['dir'];
              $where .= " GROUP BY a.customer_Id ORDER BY $order_clm $order_by ";
            } else {
              $where .= " GROUP BY a.customer_Id ORDER BY b.response DESC ";
            }
          } else {
            $where .= " GROUP BY a.customer_Id ORDER BY b.response DESC";
          }
          if (isset($LIMIT)) {
            if ($LIMIT != '') {
              $where .= ' ' . $LIMIT;
            }
          }
        $index=1;
        $button="";
        $fetch = $this->db->query("SELECT a.*,b.customer_name,b.address,b.response,b.rate,b.power,b.device_id,b.cellular_no,b.IP_address,c.ULP,concat(b.coordinate,',',replace(b.location,' ','')) as loc from dial_status a left join customer b on a.customer_Id=b.customer_id left join area c on b.area_name=c.ULP $where");
        $fetch2 = $this->db->query("SELECT a.* from dial_status a group by a.customer_Id");
        foreach($fetch->result() as $rows){
            $link ="https://www.google.com/maps/search/$rows->loc/@";
            $button1 = "<a href=".$link.$rows->loc." class='btn btn-icon icon-left btn-light bg-white' title='Lihat Lokasi di Peta' target='_blank'><i class='fa fa-map-marker' style='color:red;'></i></a>";
            $button2 = "<a href=".base_url('dial_status/update/'.$rows->id)." class='btn btn-icon icon-left btn-warning'><i class='fa fa-pencil-square-o'></i></a>";
            $button3 = "<a href=".base_url('dial_status/delete/'.$rows->id)." class='btn btn-icon icon-left btn-danger' onclick='javasciprt: return confirm(\"Are You Sure ?\")''><i class='fa fa-trash'></i></a>";
            $sub_array=array();
            $sub_array[]=$index;
            // $sub_array[]=formatTanggal($rows->date);
            // $sub_array[]=$rows->uid;
            $sub_array[]=$rows->customer_Id;
            $sub_array[]=$rows->customer_name;
            $sub_array[]=$rows->address;
            $sub_array[]=$rows->rate ."/".$rows->power;
            $sub_array[]=$rows->device_id;
            $sub_array[]=$rows->cellular_no;
            $sub_array[]=$rows->IP_address;
            $sub_array[]=$button1;
            $sub_array[]=$rows->response =="0" ? "Online" : $rows->response. " Days Offline";
            // $sub_array[]=$rows->area_name;
            $sub_array[]=$rows->ULP;
            $sub_array[]=$this->db->query("SELECT 
                                          case 
                                            when dial_status = '=' then 'No Answer'
                                            when dial_status = 'O' then 'Success'  
                                            when dial_status = 'X' then 'RTO' 
                                            when dial_status = 'L' then 'Login Timeout' 
                                            when dial_status = '-' then '-' else ''
                                            end as dial_status from dial_status where customer_Id='$rows->customer_Id' order by id DESC LIMIT 1")->row()->dial_status;
            $sub_array[]=$button2." ".$button3;
            $result[]   = $sub_array;
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
      $filter_columns = $this->input->post("filter_columns");
      $filter_value = $this->input->post("filter_value");
      $starts       = $this->input->post("start");
      $length       = $this->input->post("length");
      $LIMIT        = "LIMIT $starts, $length ";
      $draw         = $this->input->post("draw");
      $search       = $this->input->post('search')['value'];
      $orders       = isset($_POST['order']) ? $_POST['order'] : ''; 
      if($filter_columns == "" || $filter_value==""){
        $where ="WHERE 1=1";
      }else{
        $where ="WHERE 1=1 and $filter_columns ='$filter_value'";
      }
      $searchingColumn;
      $result=array();
      if (isset($search)) {
        if ($search != '') {
           $searchingColumn = $search;
              $where .= " AND (a.customer_Id LIKE '%$search%'
                              OR a.dial_status LIKE '%$search%'
                              OR a.area_name LIKE '%$search%'
                              OR a.area_code LIKE '%$search%'
                              OR a.date LIKE '%$search%'
                              OR a.uid LIKE '%$search%'
                              OR b.customer_name LIKE '%$search%'
                              OR b.response LIKE '%$search%'
                              )";
            }
        }

      if (isset($orders)) {
          if ($orders != '') {
            $order = $orders;
            $order_column = ['','a.uid','a.customer_Id','b.customer_name','b.address','b.response','a.area_code','a.area_name'];
            $order_clm  = $order_column[$order[0]['column']];
            $order_by   = $order[0]['dir'];
            $where .= " GROUP BY a.customer_Id ORDER BY $order_clm $order_by ";
          } else {
            $where .= " GROUP BY a.customer_Id ORDER BY a.id ASC ";
          }
        } else {
          $where .= " GROUP BY a.customer_Id ORDER BY a.id ASC ";
        }
        if (isset($LIMIT)) {
          if ($LIMIT != '') {
            $where .= ' ' . $LIMIT;
          }
        }
      $index=1;
      $button="";
      $fetch = $this->db->query("SELECT a.*,b.customer_name,b.address,b.response from dial_status a left join customer b on a.customer_Id=b.customer_id $where");
      $fetch2 = $this->db->query("SELECT a.* from dial_status a group by a.customer_Id");
      foreach($fetch->result() as $rows){
          // $button1 = "<a href=".base_url('dial_status/read/'.$rows->id)." class='btn btn-icon icon-left btn-light'><i class='fa fa-eye'></i></a>";
          $button2 = "<a href=".base_url('dial_status/update/'.$rows->id)." class='btn btn-icon icon-left btn-warning'><i class='fa fa-pencil-square-o'></i></a>";
          $button3 = "<a href=".base_url('dial_status/delete/'.$rows->id)." class='btn btn-icon icon-left btn-danger' onclick='javasciprt: return confirm(\"Are You Sure ?\")''><i class='fa fa-trash'></i></a>";
          $sub_array=array();
          $sub_array[]=$index;
          // $sub_array[]=formatTanggal($rows->date);
          $sub_array[]=$rows->uid;
          $sub_array[]=$rows->customer_Id;
          $sub_array[]="<span style='color:lime;font-weight:bold'>".$rows->customer_name."</span>";
          $sub_array[]=$rows->address;
          $sub_array[]=$rows->response =="0" ? "Online" : $rows->response. " Days Offline";
          $sub_array[]=$rows->area_name;
          $sub_array[]=$rows->area_code;
          $sub_array[]=$button2." ".$button3;
          $result[]   = $sub_array;
          $index++;
      }
      
      $output = array(
        "draw"            =>     intval($this->input->post("draw")),
        "recordsFiltered" =>     $fetch2->num_rows(),
        "data"            =>     $result,
       
      );
      echo json_encode($output);

  }



    public function fetch_data_modals(){
      $starts       = $this->input->post("start");
      $length       = $this->input->post("length");
      $LIMIT        = "LIMIT $starts, $length ";
      $draw         = $this->input->post("draw");
      $search       = $this->input->post('search')['value'];
      $orders       = isset($_POST['order']) ? $_POST['order'] : ''; 
      $filter       = $this->input->post('filter');

      
      if($_SESSION['level']=="Admin"){
        if($filter == ""){
          $where ="WHERE 1=1";
        }else {
          $where ="WHERE a.dial_status='$filter'";
        }
      }else{
        if($filter == ""){
          $where ="WHERE a.area_name='{$_SESSION['area_name']}'";
        }else {
          $where ="WHERE a.dial_status='$filter' and a.area_name='{$_SESSION['area_name']}'";
        }
      }
      $searchingColumn;
      $result=array();
      if (isset($search)) {
        if ($search != '') {
           $searchingColumn = $search;
              $where .= " AND (a.customer_Id LIKE '%$search%'
                              OR a.dial_status LIKE '%$search%'
                              OR a.area_name LIKE '%$search%'
                              OR a.area_code LIKE '%$search%'
                              OR a.date LIKE '%$search%'
                              OR a.uid LIKE '%$search%'
                              OR b.customer_name LIKE '%$search%'
                              OR b.response LIKE '%$search%'
                              )";
            }
        }

      if (isset($orders)) {
          if ($orders != '') {
            $order = $orders;
            $order_column = ['','a.date','a.customer_Id','b.customer_name','b.address','a.dial_status','b.response'];
            $order_clm  = $order_column[$order[0]['column']];
            $order_by   = $order[0]['dir'];
            $where .= " ORDER BY $order_clm $order_by ";
          } else {
            $where .= " ORDER BY a.id ASC ";
          }
        } else {
          $where .= " ORDER BY a.id ASC ";
        }
        if (isset($LIMIT)) {
          if ($LIMIT != '') {
            $where .= ' ' . $LIMIT;
          }
        }
      $index=1;
      $button="";
      $fetch = $this->db->query("SELECT a.*,b.customer_name,b.address,b.response from dial_status a left join customer b on a.customer_Id=b.customer_id $where");
      $fetch2 = $this->db->query("SELECT a.* from dial_status a");
      $status ="";
      foreach($fetch->result() as $rows){
        if($rows->dial_status == "O"){
          $status = "Success";
        }elseif($rows->dial_status == "X"){
          $status="RTO";
        }elseif($rows->dial_status == "L"){
          $status="Login Timeout";
        }else{
          $status="-";
        }
          $button1 = "<button onclick='return getCustomer(".$rows->id.")' class='btn btn-flat btn-xs btn-success' data-dismiss='modal' type='button'><i class='fa fa-check'></i></button>";
          $sub_array=array();
          $sub_array[]=$index;
          $sub_array[]=formatTanggal($rows->date);
          $sub_array[]=$rows->customer_Id;
          $sub_array[]=$rows->customer_name;
          $sub_array[]=$rows->address;
          $sub_array[]=$status;
          $sub_array[]=$rows->response." Days Offline";
          $sub_array[]=$button1;
          $result[]   = $sub_array;
          $index++;
      }
      
      $output = array(
        "draw"            =>     intval($this->input->post("draw")),
        "recordsFiltered" =>     $fetch2->num_rows(),
        "data"            =>     $result,
       
      );
      echo json_encode($output);

  }


  public function getById(){
    $id = $this->input->post('id');
    $query = $this->db->query("SELECT a.*,b.customer_name,b.address,b.response from dial_status a left join customer b on a.customer_Id=b.customer_id where a.id='$id'");
    if($query->num_rows() > 0){
      $data =array(
        "id"=>$query->row()->customer_Id,
        "name"=>$query->row()->customer_name,
        "address"=>$query->row()->address,
        "dial_state"=>$query->row()->dial_status,
        "klasifikasi"=>$query->row()->response,
      );
      $response = array("status"=>"sukses","value"=>$data);
    } else{
      $response = array("status"=>"error","pesan"=>"Data tidak ditemukan");
    }
    echo json_encode($response);
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


    function import_data()
  {
    $filename = $_FILES["userfile"]["tmp_name"];
    $name     = $_FILES["userfile"]["name"];
    $size     = $_FILES["userfile"]["size"];
    $name_r   = explode('.', $name);
    $year     = substr($name,3,4);
    $month    = substr($name,7,2);
    $day      = substr($name,9,2);
    $uid      = substr($name,12,2);
    $date     = $year."-".$month."-".$day; 
    $cek = $this->db->query("SELECT * from dial_status where date='$date' and uid='$uid'");
    if($cek->num_rows() > 0){
      $_SESSION['pesan']   = "File sudah pernah di upload!";
      $_SESSION['tipe']   = "danger";
      $rsp = [
        'status' => 'sukses',
        'link' => base_url('dial_status')
      ];
      echo json_encode($rsp); 
    }else{
      if ($size > 0 and $name_r[1] == 'csv') {
        $file = fopen($filename, "r");
        $is_header_removed = FALSE;
        $no = 1;
        $cek_status_dial=[];
        $number =1;
        $ada_id = [];
        $status= "";
        while (($rs = fgetcsv($file, 1000000, ";")) !== FALSE) {
          $no++;
          // if ($no == 1) continue; // Skip Header
          //Cek No. Mesin
          
          

          $fcm = [
            'customer_id' => $rs[1],
            'date'        => $date,
            'uid'         => $uid,
          ];
          $cek_data =$this->db->query("select * from dial_status where customer_Id ='{$rs[1]}' and date='$date' and uid='$uid'");
          if($rs[2] == "O"){
            $status =0;
            $query = $this->db->query("UPDATE customer set response = '$status' where customer_id='{$rs[1]}'");
            $del   = $this->db->query("UPDATE tasklist set task_status='cancel' where customer_id='{$rs[1]}' and status='0'");
            
          }else{
            $status=1;
            $query = $this->db->query("UPDATE customer set response = response + '$status' where customer_id='{$rs[1]}'");
          }
          $customer = $this->db->query("SELECT * from customer where customer_id='{$rs[1]}'");
        
          
          if ($cek_data->num_rows() > 0) {
            $cek_data2 = $cek_data->row();
            $ada_id[$no] = [
              'customer_id' => $cek_data2->customer_Id,
            ];
            if($rs[2] !="O"){
              $number++;
              $cek_status_dial[$number]=[
                "dial_status"=>$rs[2],
              ];
            }
            $update_cust[]=[
              'customer_Id' => $rs[1],
              'dial_status' => $rs[2],
              'area_name' => $rs[3],
              'area_code' => $rs[4],
              'updated' => date('Y-m-d H:i:s'),
              'date'    =>$date,
              'uid'     =>$uid,
            ];
            $insert_to[]=[
              "task_id"=>$this->acak(10),
              "date"=>date('Y-m-d H:i:s'),
              "groups"=>"",
              "customer_id"=>$rs[1],
              "area_name"=>$rs[3],
              "task_status"=>"belum",
              "created"=>date('Y-m-d H:i:s'),
              "indikasi"=>"-",
              "klasifikasi"=>$customer->row()->response,
              "date_file"=>$date,
              "uid"=>$uid,
            ];
            $update_to[]=[
              "groups"=>"",
              "customer_id"=>$rs[1],
              "indikasi"=>"-",
              "area_name"=>$rs[3],
              "klasifikasi"=>$customer->row()->response,
              "date_file"=>$date,
              "uid"=>$uid,
            ]; 
            // if($rs[2] == "O"){
            //   $status =0;
            //   $query = $this->db->query("UPDATE customer set response = '$status' where customer_id='{$rs[1]}'");
            // }else{
            //   $status=1;
            //   $query = $this->db->query("UPDATE customer set response = response + '$status' where customer_id='{$rs[1]}'");
            // }   
          } else {
            $insert_cust[] = [   
              'customer_Id' => $rs[1],
              'dial_status' => $rs[2],
              'area_name' => $rs[3],
              'area_code' => $rs[4],
              'created' => date('Y-m-d H:i:s'),
              'date'    =>$date,
              'uid'     =>$uid,
            ];
            $insert_to[]=[
              "task_id"=>$this->acak(10),
              "date"=>date('Y-m-d H:i:s'),
              "groups"=>"",
              "customer_id"=>$rs[1],
              "area_name"=>$rs[3],
              "task_status"=>"Belum",
              "created"=>date('Y-m-d H:i:s'),
              "indikasi"=>"-",
              "klasifikasi"=>$customer->row()->response,
              "date_file"=>$date,
              "uid"=>$uid,
            ];
            $update_to[]=[
              "groups"=>"",
              "customer_id"=>$rs[1],
              "area_name"=>$rs[3],
              "indikasi"=>"-",
              "klasifikasi"=>$customer->row()->response,
              "date_file"=>$date,
              "uid"=>$uid,
            ];    
  
          }
          $no++;
        }
        fclose($file);
  
        if (count($ada_id) > 0) {
          $html_pesan = 'No. Mesin & KPB Ke- Sudah Ada Dalam Database : <ul>';
          foreach ($ada_id as $key => $er) {
            $html_pesan .= "<li> Line : $key";
            $html_pesan .= "<ol>";
            // send_json($er);
            $html_pesan .= "<li>Customer ID : {$er['customer_id']}</li>";
            $html_pesan .= "</ol>";
            $html_pesan .= "</li>";
          }
          $html_pesan .= "</ul>";
          $rsp_error = ['status' => 'error', 'tipe' => 'html', 'pesan' => $html_pesan];
        }
  
        if(count($cek_status_dial) > 0){
          $html_pesan = 'No. Mesin & KPB Ke- Sudah Ada Dalam Database : <ul>';
          foreach ($cek_status_dial as $key => $er) {
            $html_pesan .= "<li> Line : $key";
            $html_pesan .= "<ol>";
            // send_json($er);
            // $html_pesan .= "<li>Customer ID : {$er['customer_id']}</li>";
            $html_pesan .= "</ol>";
            $html_pesan .= "</li>";
          }
          $html_pesan .= "</ul>";
          $rsp_error = ['status' => 'error', 'tipe' => 'html', 'pesan' => $html_pesan];
        }
  
        $tes = [
          'ins_kpb' => isset($insert_cust) ? $insert_cust : NULL,
          'ada_nosin' => isset($ada_id) ? $ada_id : NULL
        ];
        // send_json($tes);
  
        $this->db->trans_begin();
        if($cek_data->num_rows() > 0){
          if (isset($update_cust)) {
              $this->db->update_batch('dial_status', $update_cust,'customer_Id');
              $this->db->where('date',$date);
              $this->db->where('uid',$uid);
              $this->db->update_batch('tasklist',$update_to,'customer_id');
              $this->db->where('klasifikasi','0');
              $this->db->delete('tasklist');
              
              
              $rsp = [
                'status' => 'sukses',
                'link' => base_url('customer')
              ];
            }
            if (!$this->db->trans_status()) {
              $this->db->trans_rollback();
              
              $rsp = [
                'status' => 'sukses',
                'link' => base_url('dial_status')
              ];
            } else {
              $this->db->trans_commit();
              $cins = 0;
              if (isset($update_cust)) {
                $cins = count($update_cust);
              }
              $pesan =   $cins . " Data berhasil di upload";
              if (count($ada_id) > 0) {
                $pesan .=  ", " . count($ada_id) . " ID Customer sudah ada di dalam database, dan berhasil di update";
              }
              $this->session->set_flashdata('Success', 'data Berhasil di Upload');
              $_SESSION['pesan']   = $pesan;
              $_SESSION['tipe']   = "warning";
              $rsp = [
                'status' => 'sukses',
                'link' => base_url('dial_status')
              ];
            }
            
          }else{
            if (isset($insert_cust)) {
              $this->db->insert_batch('dial_status', $insert_cust);
              $this->db->insert_batch('tasklist',$insert_to);
              $this->db->where('klasifikasi','0');
              $this->db->delete('tasklist');
              $rsp = [
                  'status' => 'sukses',
                  'link' => base_url('dial_status')
                ];
            }
            if (!$this->db->trans_status()) {
              $this->db->trans_rollback();
              $_SESSION['pesan']   = $pesan;
              $_SESSION['tipe']   = "success";
              $rsp = [
                'status' => 'sukses',
                'link' => base_url('dial_status')
              ];
            } else {
              $this->db->trans_commit();
              $cins = 0;
              if (isset($insert_cust)) {
                $cins = count($insert_cust);
              }
              $pesan =   $cins . " Data berhasil di upload";
              if (count($ada_id) > 0) {
                $pesan .=  ", " . count($ada_id) . " No. mesin dan KPB sudah ada di dalam database";
              }
              
              $_SESSION['pesan']   = "Success Upload Data";
              $_SESSION['tipe']   = "primary";
              $rsp = [
                'status' => 'sukses',
                'link' => base_url('dial_status')
              ];
            }
            
          }
      }  
      echo json_encode($rsp); 
    } 
    }

    public function read($id) 
    {
        $row = $this->Dial_status_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'customer_Id' => $row->customer_Id,
		'dial_status' => $row->dial_status,
		'area_name' => $row->area_name,
		'area_code' => $row->area_code,
	    );
            $this->load->view('header');
            $this->load->view('dial_status_read', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('dial_status'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('dial_status/create_action'),
	    'id' => set_value('id'),
	    'customer_Id' => set_value('customer_Id'),
	    'dial_status' => set_value('dial_status'),
	    'area_name' => set_value('area_name'),
	    'area_code' => set_value('area_code'),
	    'date' => set_value('date'),
	    'uid' => set_value('uid'),
	);

        $this->load->view('header');
        $this->load->view('dial_status_form', $data);
        $this->load->view('footer');
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'customer_Id' => $this->input->post('customer_Id',TRUE),
		'dial_status' => $this->input->post('dial_status',TRUE),
		'area_name' => $this->input->post('area_name',TRUE),
		'area_code' => $this->input->post('area_code',TRUE),
		'date' => $this->input->post('date',TRUE),
		'uid' => $this->input->post('uid',TRUE),
	    );

            $this->Dial_status_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('dial_status'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Dial_status_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('dial_status/update_action'),
		'id' => set_value('id', $row->id),
		'customer_Id' => set_value('customer_Id', $row->customer_Id),
		'dial_status' => set_value('dial_status', $row->dial_status),
		'area_name' => set_value('area_name', $row->area_name),
		'area_code' => set_value('area_code', $row->area_code),
		'date' => set_value('date', $row->date),
		'uid' => set_value('uid', $row->uid),
	    );
            $this->load->view('header');
            $this->load->view('dial_status_form', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('dial_status'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'customer_Id' => $this->input->post('customer_Id',TRUE),
		'dial_status' => $this->input->post('dial_status',TRUE),
		'area_name' => $this->input->post('area_name',TRUE),
		'area_code' => $this->input->post('area_code',TRUE),
    'date' => $this->input->post('date',TRUE),
		'uid' => $this->input->post('uid',TRUE),
	    );

            $this->Dial_status_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('dial_status'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Dial_status_model->get_by_id($id);

        if ($row) {
            $this->Dial_status_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('dial_status'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('dial_status'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('customer_Id', 'customer id', 'trim|required');
	$this->form_validation->set_rules('dial_status', 'dial status', 'trim|required');
	$this->form_validation->set_rules('area_name', 'area name', 'trim|required');
	$this->form_validation->set_rules('area_code', 'area code', 'trim|required');
	$this->form_validation->set_rules('date', 'date', 'trim|required');
	$this->form_validation->set_rules('uid', 'uid code', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Dial_status.php */
/* Location: ./application/controllers/Dial_status.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-04-16 11:05:19 */
/* http://harviacode.com */