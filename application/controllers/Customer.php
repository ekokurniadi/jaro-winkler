<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customer extends MY_Controller {

    // protected $access = array('Admin', 'Pimpinan','Finance');
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('Customer_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->load->view('header');
        $this->load->view('customer_list');
        $this->load->view('footer');
    }

    public function uploads()
    {
        $this->load->view('header');
        $this->load->view('import_view');
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
                $where .= " AND (customer_id LIKE '%$search%'
                                OR customer_name LIKE '%$search%'
                                OR address LIKE '%$search%'
                                OR rate LIKE '%$search%'
                                OR power LIKE '%$search%'
                                OR device_id LIKE '%$search%'
                                OR device_type LIKE '%$search%'
                                OR server LIKE '%$search%'
                                OR cellular_no LIKE '%$search%'
                                OR provider LIKE '%$search%'
                                OR gardu LIKE '%$search%'
                                OR imei_modem LIKE '%$search%'
                                OR tipe_modem LIKE '%$search%'
                                OR merk_modem LIKE '%$search%'
                                OR IP_address LIKE '%$search%'
                                OR coordinate LIKE '%$search%'
                                OR location LIKE '%$search%'
                                OR area_name LIKE '%$search%'
                                OR area_code LIKE '%$search%'
                                )";
              }
          }

        if (isset($orders)) {
            if ($orders != '') {
              $order = $orders;
              $order_column = ['','customer_id', 'customer_name', 'address','rate','power', 'device_id', 'device_type','server','cellular_no','provider','IP_address','imei_modem','tipe_modem','merk_modem','gardu','coordinate','location','area_code','area_name'];
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
        $fetch = $this->db->query("SELECT * FROM customer $where");
        $fetch2 = $this->db->query("SELECT * FROM customer ");
        foreach($fetch->result() as $rows){
            $button1= "<a href=".base_url('customer/read/'.$rows->id)." class='btn btn-icon icon-left btn-light'><i class='fa fa-eye'></i></a>";
          
            $button2= "<a href=".base_url('customer/update/'.$rows->id)." class='btn btn-icon icon-left btn-warning'><i class='fa fa-pencil-square-o'></i></a>";
            
            $button3 = "<a href=".base_url('customer/delete/'.$rows->id)." class='btn btn-icon icon-left btn-danger' onclick='javasciprt: return confirm(\"Are You Sure ?\")''><i class='fa fa-trash'></i></a>";
            $sub_array=array();
            $sub_array[]=$index;
            $sub_array[]=$rows->customer_id;
            $sub_array[]=$rows->customer_name;
            $sub_array[]=$rows->address;
            $sub_array[]=$rows->rate;
            $sub_array[]=$rows->power;
            $sub_array[]=$rows->device_id;
            $sub_array[]=$rows->device_type;
            $sub_array[]=$rows->server;
            $sub_array[]=$rows->cellular_no;
            $sub_array[]=$rows->provider;
            $sub_array[]=$rows->IP_address;
            $sub_array[]=$rows->imei_modem;
            $sub_array[]=$rows->tipe_modem;
            $sub_array[]=$rows->merk_modem;
            $sub_array[]=$rows->gardu;
            $sub_array[]=$rows->coordinate;
            $sub_array[]=$rows->location;
            $sub_array[]=$rows->area_name;
            $sub_array[]=$rows->area_code;
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



function import_data()
  {
    ini_set('display_errors', 0);
    $filename = $_FILES["userfile"]["tmp_name"];
    $name     = $_FILES["userfile"]["name"];
    $size     = $_FILES["userfile"]["size"];
    $name_r   = explode('.', $name);
    $year     = substr($name,3,4);
    $month    = substr($name,7,2);
    $day      = substr($name,9,2);
    $uid      = substr($name,12,2);
    $date     = $year."-".$month."-".$day; 
    if ($size > 0 and $name_r[1] == 'csv') {
      $file = fopen($filename, "r");
      $is_header_removed = FALSE;
      $no = 1;
      $ada_id = [];
      $nama_operator = "";
      while (($rs = fgetcsv($file, 10000, ";")) !== FALSE) {
        $no++;
        $cellular = substr($rs[9],1,3);
        $cel = $cellular;
        $cell = $this->db->query("SELECT nama_operator from operator_selular where SUBSTRING(kode_operator,2,3) ='$cel'");
          if($cell->num_rows() > 0){
            $nama_operator = $cell->row()->nama_operator;
          }else{
            $nama_operator="";
          }
        // if ($no == 1) continue; // Skip Header
        //Cek No. Mesin
        $fcm = [
          'customer_id' => $rs[0],
        ];
        $cek_data =$this->db->query("select * from customer where customer_id ='{$rs[0]}'");

        if ($cek_data->num_rows() > 0) {
          $cek_data2 = $cek_data->row();
          $ada_id[$no] = [
            'customer_id' => $cek_data2->customer_id,
          ];
          $update_cust[]=[
            'customer_id' => $rs[0],
            'customer_name' => $rs[1],
            'address' => $rs[2],
            'rate' => $rs[3],
            'power' => $rs[4],
            'device_id' => $rs[5],
            'device_type' => $rs[6],
            'merk_meter' => $rs[7],
            'server' => $rs[8],
            'cellular_no' => $rs[9],
            'provider' => $rs[10],
            'IP_address' => $rs[11],
            'imei_modem'=>$rs[12],
            'tipe_modem'=>$rs[13],
            'merk_modem'=>$rs[14],
            'gardu'=>$rs[15],
            'coordinate' => $rs[16],
            'location' => $rs[17],
            'area_name' => $rs[18],
            'area_code' => $rs[19],
            'updated' => date('Y-m-d H:i:s'),
            'date'    =>$date,
            'uid'     =>$uid,
          ];
        } else {
          $insert_cust[] = [   
            'customer_id' => $rs[0],
            'customer_name' => $rs[1],
            'address' => $rs[2],
            'rate' => $rs[3],
            'power' => $rs[4],
            'device_id' => $rs[5],
            'device_type' => $rs[6],
            'merk_meter' => $rs[7],
            'server' => $rs[8],
            'cellular_no' => $rs[9],
            'provider' => $rs[10],
            'IP_address' => $rs[11],
            'imei_modem'=>$rs[12],
            'tipe_modem'=>$rs[13],
            'merk_modem'=>$rs[14],
            'gardu'=>$rs[15],
            'coordinate' => $rs[16],
            'location' => $rs[17],
            'area_name' => $rs[18],
            'area_code' => $rs[19],
            'created' => date('Y-m-d H:i:s'),
            'date'    =>$date,
            'uid'     =>$uid,
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

      $tes = [
        'ins_kpb' => isset($insert_cust) ? $insert_cust : NULL,
        'ada_nosin' => isset($ada_id) ? $ada_id : NULL
      ];
      // send_json($tes);

      $this->db->trans_begin();
      if($cek_data->num_rows() > 0){
        if (isset($update_cust)) {
            $this->db->update_batch('customer', $update_cust,'customer_id');
            $rsp = [
                'status' => 'sukses',
                'link' => base_url('customer')
              ];
          }
          if (!$this->db->trans_status()) {
            $this->db->trans_rollback();
           
            $rsp = [
              'status' => 'sukses',
              'link' => base_url('customer')
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
              'link' => base_url('customer')
            ];
          }
        
      }else{
        if (isset($insert_cust)) {
            $this->db->insert_batch('customer', $insert_cust);
            $rsp = [
                'status' => 'sukses',
                'link' => base_url('customer')
              ];
          }
          if (!$this->db->trans_status()) {
            $this->db->trans_rollback();
            $_SESSION['pesan']   = $pesan;
            $_SESSION['tipe']   = "success";
            $rsp = [
              'status' => 'sukses',
              'link' => base_url('customer')
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
              'link' => base_url('customer')
            ];
          }
          
        }
    }  
    echo json_encode($rsp); 
      
    }

    public function read($id) 
    {
        $row = $this->Customer_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'customer_id' => $row->customer_id,
		'customer_name' => $row->customer_name,
		'address' => $row->address,
		'rate' => $row->rate,
		'power' => $row->power,
		'device_id' => $row->device_id,
		'device_type' => $row->device_type,
		'server' => $row->server,
		'cellular_no' => $row->cellular_no,
		'IP_address' => $row->IP_address,
		'coordinate' => $row->coordinate,
		'location' => $row->location,
		'area_name' => $row->area_name,
		'area_code' => $row->area_code,
	    );
            $this->load->view('header');
            $this->load->view('customer_read', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('customer'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('customer/create_action'),
	    'id' => set_value('id'),
	    'customer_id' => set_value('customer_id'),
	    'customer_name' => set_value('customer_name'),
	    'address' => set_value('address'),
	    'rate' => set_value('rate'),
	    'power' => set_value('power'),
	    'device_id' => set_value('device_id'),
	    'device_type' => set_value('device_type'),
	    'server' => set_value('server'),
	    'cellular_no' => set_value('cellular_no'),
	    'IP_address' => set_value('IP_address'),
	    'coordinate' => set_value('coordinate'),
	    'location' => set_value('location'),
	    'area_name' => set_value('area_name'),
	    'area_code' => set_value('area_code'),
	);

        $this->load->view('header');
        $this->load->view('customer_form', $data);
        $this->load->view('footer');
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'customer_id' => $this->input->post('customer_id',TRUE),
		'customer_name' => $this->input->post('customer_name',TRUE),
		'address' => $this->input->post('address',TRUE),
		'rate' => $this->input->post('rate',TRUE),
		'power' => $this->input->post('power',TRUE),
		'device_id' => $this->input->post('device_id',TRUE),
		'device_type' => $this->input->post('device_type',TRUE),
		'server' => $this->input->post('server',TRUE),
		'cellular_no' => $this->input->post('cellular_no',TRUE),
		'IP_address' => $this->input->post('IP_address',TRUE),
		'coordinate' => $this->input->post('coordinate',TRUE),
		'location' => $this->input->post('location',TRUE),
		'area_name' => $this->input->post('area_name',TRUE),
		'area_code' => $this->input->post('area_code',TRUE),
	    );

            $this->Customer_model->insert($data);
            $_SESSION['pesan']   = "Success Create Data";
            $_SESSION['tipe']   = "success";
            redirect(site_url('customer'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Customer_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('customer/update_action'),
		'id' => set_value('id', $row->id),
		'customer_id' => set_value('customer_id', $row->customer_id),
		'customer_name' => set_value('customer_name', $row->customer_name),
		'address' => set_value('address', $row->address),
		'rate' => set_value('rate', $row->rate),
		'power' => set_value('power', $row->power),
		'device_id' => set_value('device_id', $row->device_id),
		'device_type' => set_value('device_type', $row->device_type),
		'server' => set_value('server', $row->server),
		'cellular_no' => set_value('cellular_no', $row->cellular_no),
		'IP_address' => set_value('IP_address', $row->IP_address),
		'coordinate' => set_value('coordinate', $row->coordinate),
		'location' => set_value('location', $row->location),
		'area_name' => set_value('area_name', $row->area_name),
		'area_code' => set_value('area_code', $row->area_code),
	    );
            $this->load->view('header');
            $this->load->view('customer_form', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('customer'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'customer_id' => $this->input->post('customer_id',TRUE),
		'customer_name' => $this->input->post('customer_name',TRUE),
		'address' => $this->input->post('address',TRUE),
		'rate' => $this->input->post('rate',TRUE),
		'power' => $this->input->post('power',TRUE),
		'device_id' => $this->input->post('device_id',TRUE),
		'device_type' => $this->input->post('device_type',TRUE),
		'server' => $this->input->post('server',TRUE),
		'cellular_no' => $this->input->post('cellular_no',TRUE),
		'IP_address' => $this->input->post('IP_address',TRUE),
		'coordinate' => $this->input->post('coordinate',TRUE),
		'location' => $this->input->post('location',TRUE),
		'area_name' => $this->input->post('area_name',TRUE),
		'area_code' => $this->input->post('area_code',TRUE),
	    );

            $this->Customer_model->update($this->input->post('id', TRUE), $data);
            $_SESSION['pesan']   = "Success Update Data";
            $_SESSION['tipe']   = "success";
            redirect(site_url('customer'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Customer_model->get_by_id($id);

        if ($row) {
            $this->Customer_model->delete($id);
            $_SESSION['pesan']   = "Success Delete Data";
            $_SESSION['tipe']   = "success";
            redirect(site_url('customer'));
        } else {
            $_SESSION['pesan']   = "Success Create Data";
            $_SESSION['tipe']   = "success";
            redirect(site_url('customer'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('customer_id', 'customer id', 'trim|required');
	$this->form_validation->set_rules('customer_name', 'customer name', 'trim|required');
	$this->form_validation->set_rules('address', 'address', 'trim|required');
	$this->form_validation->set_rules('rate', 'rate', 'trim|required');
	$this->form_validation->set_rules('power', 'power', 'trim|required');
	$this->form_validation->set_rules('device_id', 'device id', 'trim|required');
	$this->form_validation->set_rules('device_type', 'device type', 'trim|required');
	$this->form_validation->set_rules('server', 'server', 'trim|required');
	$this->form_validation->set_rules('cellular_no', 'cellular no', 'trim|required');
	$this->form_validation->set_rules('IP_address', 'ip address', 'trim|required');
	$this->form_validation->set_rules('coordinate', 'coordinate', 'trim|required');
	$this->form_validation->set_rules('location', 'location', 'trim|required');
	$this->form_validation->set_rules('area_name', 'area name', 'trim|required');
	$this->form_validation->set_rules('area_code', 'area code', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Customer.php */
/* Location: ./application/controllers/Customer.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-04-16 08:36:15 */
/* http://harviacode.com */