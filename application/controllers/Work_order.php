<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Work_order extends MY_Controller {

    // protected $access = array('Admin', 'Pimpinan','Finance');
	public $page = "cetak_penugasan";
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('Work_order_model');
        $this->load->library('form_validation');
    }
	

    public function index()
    { 
        $this->load->view('header');
        $this->load->view('work_order_list');
        $this->load->view('footer');
    }

	public function index_mobile(){
		$data['level']=$_GET['level'];
		$data['area']=$_GET['area'];
		$this->load->view('header2');
		$this->load->view('work_order_list2',$data);
		$this->load->view('footer2');
	}
	public function fetch_data(){
        $starts       = $this->input->post("start");
        $length       = $this->input->post("length");
        $LIMIT        = "LIMIT $starts, $length ";
        $draw         = $this->input->post("draw");
        $search       = $this->input->post('search')['value'];
        $orders       = isset($_POST['order']) ? $_POST['order'] : '';
		$referensi    = $this->input->post('ref'); 
        if($_SESSION['level']=="Admin"){
			if($referensi == ""){
				$where ="WHERE 1=1 ";
			}else{
				$where ="WHERE 1=1  and a.status='$referensi'";
			}
		}else{
			if($referensi == ""){
				$where ="WHERE 1=1  and a.area_name='{$_SESSION['area_name']}'";
			}else{
				$where ="WHERE 1=1  and a.area_name='{$_SESSION['area_name']}' and a.status='$referensi'";
			}
		}
        $searchingColumn;
        $result=array();
        if (isset($search)) {
          if ($search != '') {
             $searchingColumn = $search;
                $where .= " AND (a.customer_id LIKE '%$search%'
                                OR d.customer_name LIKE '%$search%'
                                OR a.task_id LIKE '%$search%'
                                OR a.status LIKE '%$search%'
                                -- OR address LIKE '%$search%'
                                -- OR rate LIKE '%$search%'
                                -- OR power LIKE '%$search%'
                                -- OR device_id LIKE '%$search%'
                                -- OR device_type LIKE '%$search%'
                                -- OR server LIKE '%$search%'
                                -- OR cellular_no LIKE '%$search%'
                                -- OR provider LIKE '%$search%'
                                -- OR gardu LIKE '%$search%'
                                -- OR imei_modem LIKE '%$search%'
                                -- OR tipe_modem LIKE '%$search%'
                                -- OR merk_modem LIKE '%$search%'
                                -- OR IP_address LIKE '%$search%'
                                -- OR coordinate LIKE '%$search%'
                                -- OR location LIKE '%$search%'
                                -- OR area_name LIKE '%$search%'
                                -- OR area_code LIKE '%$search%'
                                )";
              }
          }

        if (isset($orders)) {
            if ($orders != '') {
              $order = $orders;
              $order_column = ['','a.task_id','a.tanggal_survey','a.date','a.customer_id','d.customer_name','a.activities','petugas','a.reason'];
              $order_clm  = $order_column[$order[0]['column']];
              $order_by   = $order[0]['dir'];
              $where .= " GROUP BY a.task_id ORDER BY $order_clm $order_by ";
            } else {
              $where .= "GROUP BY a.task_id  ORDER BY a.id ASC ";
            }
          } else {
            $where .= "GROUP BY a.task_id  ORDER BY a.id ASC ";
          }
          if (isset($LIMIT)) {
            if ($LIMIT != '') {
              $where .= ' ' . $LIMIT;
            }
          }
        $index=1;
        $button="";
        $fetch = $this->db->query("SELECT a.id,a.date,a.tanggal_survey,a.reason,a.status,a.task_id,a.document_no,a.customer_id,a.activities,d.customer_name,b.group,b.id as grp FROM work_order a join grup b on a.groups=b.id join petugas c on b.id=c.groups join customer d on d.customer_id=a.customer_id join tasklist e on e.task_id=a.task_id $where");
        $fetch2 = $this->db->query("SELECT a.id,a.date,a.tanggal_survey,a.reason,a.status,a.task_id,a.document_no,a.customer_id,a.activities,d.customer_name,b.group,b.id as grp FROM work_order a join grup b on a.groups=b.id join petugas c on b.id=c.groups join customer d on d.customer_id=a.customer_id join tasklist e on e.task_id=a.task_id where a.area_name='{$_SESSION['area_name']}' GROUP BY a.task_id");
        foreach($fetch->result() as $rows){
            $button1= "<a href=".base_url('work_order/read/'.$rows->id)." class='btn btn-icon icon-left btn-primary'><i class='fa fa-eye'></i></a>";
			if($rows->status=="Complete"){
				$button2= "<a href=".base_url('work_order/cetak/'.$rows->id)." target='_blank' class='btn btn-icon icon-left btn-success'><i class='fa fa-print'></i></a>";
			}else{
				$button2="";
			}
            
            // $button3 = "<a href=".base_url('work_order/delete/'.$rows->id)." class='btn btn-icon icon-left btn-danger' onclick='javasciprt: return confirm(\"Are You Sure ?\")''><i class='fa fa-trash'></i></a>";
            $petugas="";
			$sub_array=array();
            $sub_array[]=$index;
            $sub_array[]=$rows->status;
            $sub_array[]=$rows->task_id;
            $sub_array[]=$rows->tanggal_survey == "0000-00-00" ||$rows->tanggal_survey =="" ? "Belum" : tgl_indo($rows->tanggal_survey);
            $sub_array[]=tgl_indo($rows->date);
            $sub_array[]=$rows->customer_id;
            $sub_array[]=$rows->customer_name;
            $sub_array[]=$rows->activities;
            $sub_array[]=$this->db->query("SELECT GROUP_CONCAT(name) as petugas from petugas where groups ='$rows->grp' and level='Lapangan'")->row()->petugas;
            $sub_array[]=$rows->reason;
			
            $sub_array[]=$button1." ".$button2;
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
        $LIMIT        = "LIMIT $starts, $length ";
        $draw         = $this->input->post("draw");
        $search       = $this->input->post('search')['value'];
        $orders       = isset($_POST['order']) ? $_POST['order'] : '';
		$referensi    = $this->input->post('ref'); 
		$level        = $this->input->post('level');
		$area         = $this->input->post('area');
        if($level=="Admin"){
			if($referensi == ""){
				$where ="WHERE 1=1 ";
			}else{
				$where ="WHERE 1=1  and a.status='$referensi'";
			}
		}else{
			if($referensi == ""){
				$where ="WHERE 1=1  and a.area_name='$area'";
			}else{
				$where ="WHERE 1=1  and a.area_name='$area' and a.status='$referensi'";
			}
		}
        $searchingColumn;
        $result=array();
        if (isset($search)) {
          if ($search != '') {
             $searchingColumn = $search;
                $where .= " AND (a.customer_id LIKE '%$search%'
                                OR d.customer_name LIKE '%$search%'
                                OR a.task_id LIKE '%$search%'
                                OR a.status LIKE '%$search%'
                                -- OR address LIKE '%$search%'
                                -- OR rate LIKE '%$search%'
                                -- OR power LIKE '%$search%'
                                -- OR device_id LIKE '%$search%'
                                -- OR device_type LIKE '%$search%'
                                -- OR server LIKE '%$search%'
                                -- OR cellular_no LIKE '%$search%'
                                -- OR provider LIKE '%$search%'
                                -- OR gardu LIKE '%$search%'
                                -- OR imei_modem LIKE '%$search%'
                                -- OR tipe_modem LIKE '%$search%'
                                -- OR merk_modem LIKE '%$search%'
                                -- OR IP_address LIKE '%$search%'
                                -- OR coordinate LIKE '%$search%'
                                -- OR location LIKE '%$search%'
                                -- OR area_name LIKE '%$search%'
                                -- OR area_code LIKE '%$search%'
                                )";
              }
          }

        if (isset($orders)) {
            if ($orders != '') {
              $order = $orders;
              $order_column = ['','a.task_id','a.tanggal_survey','a.date','a.customer_id','d.customer_name','a.activities','petugas','a.reason'];
              $order_clm  = $order_column[$order[0]['column']];
              $order_by   = $order[0]['dir'];
              $where .= " GROUP BY a.task_id ORDER BY $order_clm $order_by ";
            } else {
              $where .= "GROUP BY a.task_id  ORDER BY a.id ASC ";
            }
          } else {
            $where .= "GROUP BY a.task_id  ORDER BY a.id ASC ";
          }
          if (isset($LIMIT)) {
            if ($LIMIT != '') {
              $where .= ' ' . $LIMIT;
            }
          }
        $index=1;
        $button="";
        $fetch = $this->db->query("SELECT a.id,a.date,a.tanggal_survey,a.reason,a.status,a.task_id,a.document_no,a.customer_id,a.activities,d.customer_name,b.group,b.id as grp FROM work_order a join grup b on a.groups=b.id join petugas c on b.id=c.groups join customer d on d.customer_id=a.customer_id join tasklist e on e.task_id=a.task_id $where");
        $fetch2 = $this->db->query("SELECT a.id,a.date,a.tanggal_survey,a.reason,a.status,a.task_id,a.document_no,a.customer_id,a.activities,d.customer_name,b.group,b.id as grp FROM work_order a join grup b on a.groups=b.id join petugas c on b.id=c.groups join customer d on d.customer_id=a.customer_id join tasklist e on e.task_id=a.task_id where a.area_name='$area' GROUP BY a.task_id");
        foreach($fetch->result() as $rows){
            $button1= "<a href=".base_url('work_order/read2?id='.$rows->id.'&level='.$level.'&area='.$area)." class='btn btn-icon icon-left btn-primary'><i class='fa fa-eye'></i></a>";
			if($rows->status=="Complete"){
				$button2= "<a href=".base_url('work_order/cetak2/'.$rows->id)." class='btn btn-icon icon-left btn-success'><i class='fa fa-print'></i></a>";
			}else{
				$button2="";
			}
            // $button3 = "<a href=".base_url('work_order/delete/'.$rows->id)." class='btn btn-icon icon-left btn-danger' onclick='javasciprt: return confirm(\"Are You Sure ?\")''><i class='fa fa-trash'></i></a>";
            $petugas="";
			$sub_array=array();
            $sub_array[]=$index;
            $sub_array[]=$rows->status;
            $sub_array[]=$rows->task_id;
            $sub_array[]=$rows->tanggal_survey == "0000-00-00" ||$rows->tanggal_survey =="" ? "Belum" : tgl_indo($rows->tanggal_survey);
            $sub_array[]=tgl_indo($rows->date);
            $sub_array[]=$rows->customer_id;
            $sub_array[]=$rows->customer_name;
            $sub_array[]=$rows->activities;
            $sub_array[]=$this->db->query("SELECT GROUP_CONCAT(name) as petugas from petugas where groups ='$rows->grp' and level='Lapangan'")->row()->petugas;
            $sub_array[]=$rows->reason;
			
            $sub_array[]=$button1." ";
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

	public function download_excel(){
		$fetch = $this->db->query("SELECT a.id,a.date,a.tanggal_survey,a.reason,
		a.status,a.task_id,a.document_no,a.customer_id,a.activities,d.customer_name,
		b.group,b.id as grp FROM work_order a join grup b on a.groups=b.id join petugas c on 
		b.id=c.groups join customer d on d.customer_id=a.customer_id join tasklist e 
		on e.task_id=a.task_id where a.area_name='{$_SESSION['area_name']}' GROUP BY a.task_id");
	}


	public function cetak($id)
	{
		$data=array();
		$customer = $this->db->get_where('work_order',array('id'=>$id))->row();
		$data['details']=$this->db->get_where('work_order',array('id'=>$id))->row();
		$data['customerData']=$this->db->get_where('customer',array('customer_id'=>$customer->customer_id))->row();
		$data['header']= $this->db->query("SELECT a.reg_name,a.area_name from area a join customer b on b.area_code=a.area_code where b.customer_id='$customer->customer_id' limit 1")->row();
		$this->load->library('pdf');
        $mpdf                           = $this->pdf->load();
        $mpdf->allow_charset_conversion = true;  // Set by default to TRUE
        $mpdf->charset_in               = 'UTF-8';
        $mpdf->autoLangToFont           = true;
		$mpdf->AddPage('P');
        $html = $this->load->view($this->page,$data, true);
        $mpdf->WriteHTML($html);
        $output = $this->page . '.pdf';
        $mpdf->Output("$output", 'I');
	}

	public function cetak2($id)
	{
		$data=array();
		$customer = $this->db->get_where('work_order',array('id'=>$id))->row();
		$data['details']=$this->db->get_where('work_order',array('id'=>$id))->row();
		$data['customerData']=$this->db->get_where('customer',array('customer_id'=>$customer->customer_id))->row();
		$data['header']= $this->db->query("SELECT a.reg_name,a.area_name from area a join customer b on b.area_code=a.area_code where b.customer_id='$customer->customer_id' limit 1")->row();
		$this->load->library('pdf');
        $mpdf                           = $this->pdf->load();
        $mpdf->allow_charset_conversion = true;  // Set by default to TRUE
        $mpdf->charset_in               = 'UTF-8';
        $mpdf->autoLangToFont           = true;
		$mpdf->AddPage('P');
        $html = $this->load->view($this->page,$data, true);
        $mpdf->WriteHTML($html);
        $output = $this->page . '.pdf';
        $mpdf->Output("$output", 'I');
	}

    public function read($id) 
    {
        $row = $this->Work_order_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'task_id' => $row->task_id,
		'document_no' => $row->document_no,
		'date' => $row->date,
		'customer_id' => $row->customer_id,
		'activities' => $row->activities,
		'date_meter' => $row->date_meter,
		'time_meter' => $row->time_meter,
		'stand_meter_WBP' => $row->stand_meter_WBP,
		'stand_meter_WBP1' => $row->stand_meter_WBP1,
		'stand_meter_WBP2' => $row->stand_meter_WBP2,
		'stand_meter_total' => $row->stand_meter_total,
		'kvarh' => $row->kvarh,
		'voltage_r' => $row->voltage_r,
		'voltage_s' => $row->voltage_s,
		'voltage_t' => $row->voltage_t,
		'current_r' => $row->current_r,
		'current_s' => $row->current_s,
		'current_t' => $row->current_t,
		'cosphi' => $row->cosphi,
		'panel_condition' => $row->panel_condition,
		'meter_dev_condition' => $row->meter_dev_condition,
		'meter_disp_condition' => $row->meter_disp_condition,
		'shuntrip_condition' => $row->shuntrip_condition,
		'current_limiter' => $row->current_limiter,
		'current_limiter_type' => $row->current_limiter_type,
		'current_limiter_brand' => $row->current_limiter_brand,
		'modem_condition' => $row->modem_condition,
		'modem_imei' => $row->modem_imei,
		'modem_type' => $row->modem_type,
		'modem_brand' => $row->modem_brand,
		'ant_potition' => $row->ant_potition,
		'Ratio_CT' => $row->Ratio_CT,
		'top_panel_door_seal' => $row->top_panel_door_seal,
		'bottom_panel_door_seal' => $row->bottom_panel_door_seal,
		'meter_dev_seal' => $row->meter_dev_seal,
		'modem_seal' => $row->modem_seal,
		'latitude' => $row->latitude,
		'longitude' => $row->longitude,
		'site_allocation' => $row->site_allocation,
		'note' => $row->note,
		'photo_panel' => $row->photo_panel,
		'photo_meter_dev' => $row->photo_meter_dev,
		'photo_shuntrip' => $row->photo_shuntrip,
		'photo_current_limiter' => $row->photo_current_limiter,
		'photo_building' => $row->photo_building,
		'photo_1' => $row->photo_1,
		'photo_2' => $row->photo_2,
		'status' => $row->status,
		'reason' => $row->reason,
	    );
            $this->load->view('header');
            $this->load->view('work_order_read', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('work_order'));
        }
    }

	public function read2() 
    {	
		$id = $_GET['id'];
		$level = $_GET['level'];
		$area = $_GET['area'];
        $row = $this->Work_order_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'task_id' => $row->task_id,
		'document_no' => $row->document_no,
		'date' => $row->date,
		'customer_id' => $row->customer_id,
		'activities' => $row->activities,
		'date_meter' => $row->date_meter,
		'time_meter' => $row->time_meter,
		'stand_meter_WBP' => $row->stand_meter_WBP,
		'stand_meter_WBP1' => $row->stand_meter_WBP1,
		'stand_meter_WBP2' => $row->stand_meter_WBP2,
		'stand_meter_total' => $row->stand_meter_total,
		'kvarh' => $row->kvarh,
		'voltage_r' => $row->voltage_r,
		'voltage_s' => $row->voltage_s,
		'voltage_t' => $row->voltage_t,
		'current_r' => $row->current_r,
		'current_s' => $row->current_s,
		'current_t' => $row->current_t,
		'cosphi' => $row->cosphi,
		'panel_condition' => $row->panel_condition,
		'meter_dev_condition' => $row->meter_dev_condition,
		'meter_disp_condition' => $row->meter_disp_condition,
		'shuntrip_condition' => $row->shuntrip_condition,
		'current_limiter' => $row->current_limiter,
		'current_limiter_type' => $row->current_limiter_type,
		'current_limiter_brand' => $row->current_limiter_brand,
		'modem_condition' => $row->modem_condition,
		'modem_imei' => $row->modem_imei,
		'modem_type' => $row->modem_type,
		'modem_brand' => $row->modem_brand,
		'ant_potition' => $row->ant_potition,
		'Ratio_CT' => $row->Ratio_CT,
		'top_panel_door_seal' => $row->top_panel_door_seal,
		'bottom_panel_door_seal' => $row->bottom_panel_door_seal,
		'meter_dev_seal' => $row->meter_dev_seal,
		'modem_seal' => $row->modem_seal,
		'latitude' => $row->latitude,
		'longitude' => $row->longitude,
		'site_allocation' => $row->site_allocation,
		'note' => $row->note,
		'photo_panel' => $row->photo_panel,
		'photo_meter_dev' => $row->photo_meter_dev,
		'photo_shuntrip' => $row->photo_shuntrip,
		'photo_current_limiter' => $row->photo_current_limiter,
		'photo_building' => $row->photo_building,
		'photo_1' => $row->photo_1,
		'photo_2' => $row->photo_2,
		'status' => $row->status,
		'reason' => $row->reason,
		'level' => $level,
		'area' => $area,
	    );
            $this->load->view('header2');
            $this->load->view('work_order_read2', $data);
            $this->load->view('footer2');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('work_order/index_mobile'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('work_order/create_action'),
	    'id' => set_value('id'),
	    'task_id' => set_value('task_id'),
	    'document_no' => set_value('document_no'),
	    'date' => set_value('date'),
	    'customer_id' => set_value('customer_id'),
	    'activities' => set_value('activities'),
	    'date_meter' => set_value('date_meter'),
	    'time_meter' => set_value('time_meter'),
	    'stand_meter_WBP' => set_value('stand_meter_WBP'),
	    'stand_meter_WBP1' => set_value('stand_meter_WBP1'),
	    'stand_meter_WBP2' => set_value('stand_meter_WBP2'),
	    'stand_meter_total' => set_value('stand_meter_total'),
	    'kvarh' => set_value('kvarh'),
	    'voltage_r' => set_value('voltage_r'),
	    'voltage_s' => set_value('voltage_s'),
	    'voltage_t' => set_value('voltage_t'),
	    'current_r' => set_value('current_r'),
	    'current_s' => set_value('current_s'),
	    'current_t' => set_value('current_t'),
	    'cosphi' => set_value('cosphi'),
	    'panel_condition' => set_value('panel_condition'),
	    'meter_dev_condition' => set_value('meter_dev_condition'),
	    'meter_disp_condition' => set_value('meter_disp_condition'),
	    'shuntrip_condition' => set_value('shuntrip_condition'),
	    'current_limiter' => set_value('current_limiter'),
	    'current_limiter_type' => set_value('current_limiter_type'),
	    'current_limiter_brand' => set_value('current_limiter_brand'),
	    'modem_condition' => set_value('modem_condition'),
	    'modem_imei' => set_value('modem_imei'),
	    'modem_type' => set_value('modem_type'),
	    'modem_brand' => set_value('modem_brand'),
	    'ant_potition' => set_value('ant_potition'),
	    'Ratio_CT' => set_value('Ratio_CT'),
	    'top_panel_door_seal' => set_value('top_panel_door_seal'),
	    'bottom_panel_door_seal' => set_value('bottom_panel_door_seal'),
	    'meter_dev_seal' => set_value('meter_dev_seal'),
	    'modem_seal' => set_value('modem_seal'),
	    'latitude' => set_value('latitude'),
	    'longitude' => set_value('longitude'),
	    'site_allocation' => set_value('site_allocation'),
	    'note' => set_value('note'),
	    'photo_panel' => set_value('photo_panel'),
	    'photo_meter_dev' => set_value('photo_meter_dev'),
	    'photo_shuntrip' => set_value('photo_shuntrip'),
	    'photo_current_limiter' => set_value('photo_current_limiter'),
	    'photo_building' => set_value('photo_building'),
	    'photo_1' => set_value('photo_1'),
	    'photo_2' => set_value('photo_2'),
	    'status' => set_value('status'),
	    'reason' => set_value('reason'),
	);

        $this->load->view('header');
        $this->load->view('work_order_form', $data);
        $this->load->view('footer');
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'task_id' => $this->input->post('task_id',TRUE),
		'document_no' => $this->input->post('document_no',TRUE),
		'date' => $this->input->post('date',TRUE),
		'customer_id' => $this->input->post('customer_id',TRUE),
		'activities' => $this->input->post('activities',TRUE),
		'date_meter' => $this->input->post('date_meter',TRUE),
		'time_meter' => $this->input->post('time_meter',TRUE),
		'stand_meter_WBP' => $this->input->post('stand_meter_WBP',TRUE),
		'stand_meter_WBP1' => $this->input->post('stand_meter_WBP1',TRUE),
		'stand_meter_WBP2' => $this->input->post('stand_meter_WBP2',TRUE),
		'stand_meter_total' => $this->input->post('stand_meter_total',TRUE),
		'kvarh' => $this->input->post('kvarh',TRUE),
		'voltage_r' => $this->input->post('voltage_r',TRUE),
		'voltage_s' => $this->input->post('voltage_s',TRUE),
		'voltage_t' => $this->input->post('voltage_t',TRUE),
		'current_r' => $this->input->post('current_r',TRUE),
		'current_s' => $this->input->post('current_s',TRUE),
		'current_t' => $this->input->post('current_t',TRUE),
		'cosphi' => $this->input->post('cosphi',TRUE),
		'panel_condition' => $this->input->post('panel_condition',TRUE),
		'meter_dev_condition' => $this->input->post('meter_dev_condition',TRUE),
		'meter_disp_condition' => $this->input->post('meter_disp_condition',TRUE),
		'shuntrip_condition' => $this->input->post('shuntrip_condition',TRUE),
		'current_limiter' => $this->input->post('current_limiter',TRUE),
		'current_limiter_type' => $this->input->post('current_limiter_type',TRUE),
		'current_limiter_brand' => $this->input->post('current_limiter_brand',TRUE),
		'modem_condition' => $this->input->post('modem_condition',TRUE),
		'modem_imei' => $this->input->post('modem_imei',TRUE),
		'modem_type' => $this->input->post('modem_type',TRUE),
		'modem_brand' => $this->input->post('modem_brand',TRUE),
		'ant_potition' => $this->input->post('ant_potition',TRUE),
		'Ratio_CT' => $this->input->post('Ratio_CT',TRUE),
		'top_panel_door_seal' => $this->input->post('top_panel_door_seal',TRUE),
		'bottom_panel_door_seal' => $this->input->post('bottom_panel_door_seal',TRUE),
		'meter_dev_seal' => $this->input->post('meter_dev_seal',TRUE),
		'modem_seal' => $this->input->post('modem_seal',TRUE),
		'latitude' => $this->input->post('latitude',TRUE),
		'longitude' => $this->input->post('longitude',TRUE),
		'site_allocation' => $this->input->post('site_allocation',TRUE),
		'note' => $this->input->post('note',TRUE),
		'photo_panel' => $this->input->post('photo_panel',TRUE),
		'photo_meter_dev' => $this->input->post('photo_meter_dev',TRUE),
		'photo_shuntrip' => $this->input->post('photo_shuntrip',TRUE),
		'photo_current_limiter' => $this->input->post('photo_current_limiter',TRUE),
		'photo_building' => $this->input->post('photo_building',TRUE),
		'photo_1' => $this->input->post('photo_1',TRUE),
		'photo_2' => $this->input->post('photo_2',TRUE),
		'status' => $this->input->post('status',TRUE),
		'reason' => $this->input->post('reason',TRUE),
	    );

            $this->Work_order_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('work_order'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Work_order_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('work_order/update_action'),
		'id' => set_value('id', $row->id),
		'task_id' => set_value('task_id', $row->task_id),
		'document_no' => set_value('document_no', $row->document_no),
		'date' => set_value('date', $row->date),
		'customer_id' => set_value('customer_id', $row->customer_id),
		'activities' => set_value('activities', $row->activities),
		'date_meter' => set_value('date_meter', $row->date_meter),
		'time_meter' => set_value('time_meter', $row->time_meter),
		'stand_meter_WBP' => set_value('stand_meter_WBP', $row->stand_meter_WBP),
		'stand_meter_WBP1' => set_value('stand_meter_WBP1', $row->stand_meter_WBP1),
		'stand_meter_WBP2' => set_value('stand_meter_WBP2', $row->stand_meter_WBP2),
		'stand_meter_total' => set_value('stand_meter_total', $row->stand_meter_total),
		'kvarh' => set_value('kvarh', $row->kvarh),
		'voltage_r' => set_value('voltage_r', $row->voltage_r),
		'voltage_s' => set_value('voltage_s', $row->voltage_s),
		'voltage_t' => set_value('voltage_t', $row->voltage_t),
		'current_r' => set_value('current_r', $row->current_r),
		'current_s' => set_value('current_s', $row->current_s),
		'current_t' => set_value('current_t', $row->current_t),
		'cosphi' => set_value('cosphi', $row->cosphi),
		'panel_condition' => set_value('panel_condition', $row->panel_condition),
		'meter_dev_condition' => set_value('meter_dev_condition', $row->meter_dev_condition),
		'meter_disp_condition' => set_value('meter_disp_condition', $row->meter_disp_condition),
		'shuntrip_condition' => set_value('shuntrip_condition', $row->shuntrip_condition),
		'current_limiter' => set_value('current_limiter', $row->current_limiter),
		'current_limiter_type' => set_value('current_limiter_type', $row->current_limiter_type),
		'current_limiter_brand' => set_value('current_limiter_brand', $row->current_limiter_brand),
		'modem_condition' => set_value('modem_condition', $row->modem_condition),
		'modem_imei' => set_value('modem_imei', $row->modem_imei),
		'modem_type' => set_value('modem_type', $row->modem_type),
		'modem_brand' => set_value('modem_brand', $row->modem_brand),
		'ant_potition' => set_value('ant_potition', $row->ant_potition),
		'Ratio_CT' => set_value('Ratio_CT', $row->Ratio_CT),
		'top_panel_door_seal' => set_value('top_panel_door_seal', $row->top_panel_door_seal),
		'bottom_panel_door_seal' => set_value('bottom_panel_door_seal', $row->bottom_panel_door_seal),
		'meter_dev_seal' => set_value('meter_dev_seal', $row->meter_dev_seal),
		'modem_seal' => set_value('modem_seal', $row->modem_seal),
		'latitude' => set_value('latitude', $row->latitude),
		'longitude' => set_value('longitude', $row->longitude),
		'site_allocation' => set_value('site_allocation', $row->site_allocation),
		'note' => set_value('note', $row->note),
		'photo_panel' => set_value('photo_panel', $row->photo_panel),
		'photo_meter_dev' => set_value('photo_meter_dev', $row->photo_meter_dev),
		'photo_shuntrip' => set_value('photo_shuntrip', $row->photo_shuntrip),
		'photo_current_limiter' => set_value('photo_current_limiter', $row->photo_current_limiter),
		'photo_building' => set_value('photo_building', $row->photo_building),
		'photo_1' => set_value('photo_1', $row->photo_1),
		'photo_2' => set_value('photo_2', $row->photo_2),
		'status' => set_value('status', $row->status),
		'reason' => set_value('reason', $row->reason),
	    );
            $this->load->view('header');
            $this->load->view('work_order_form', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('work_order'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'task_id' => $this->input->post('task_id',TRUE),
		'document_no' => $this->input->post('document_no',TRUE),
		'date' => $this->input->post('date',TRUE),
		'customer_id' => $this->input->post('customer_id',TRUE),
		'activities' => $this->input->post('activities',TRUE),
		'date_meter' => $this->input->post('date_meter',TRUE),
		'time_meter' => $this->input->post('time_meter',TRUE),
		'stand_meter_WBP' => $this->input->post('stand_meter_WBP',TRUE),
		'stand_meter_WBP1' => $this->input->post('stand_meter_WBP1',TRUE),
		'stand_meter_WBP2' => $this->input->post('stand_meter_WBP2',TRUE),
		'stand_meter_total' => $this->input->post('stand_meter_total',TRUE),
		'kvarh' => $this->input->post('kvarh',TRUE),
		'voltage_r' => $this->input->post('voltage_r',TRUE),
		'voltage_s' => $this->input->post('voltage_s',TRUE),
		'voltage_t' => $this->input->post('voltage_t',TRUE),
		'current_r' => $this->input->post('current_r',TRUE),
		'current_s' => $this->input->post('current_s',TRUE),
		'current_t' => $this->input->post('current_t',TRUE),
		'cosphi' => $this->input->post('cosphi',TRUE),
		'panel_condition' => $this->input->post('panel_condition',TRUE),
		'meter_dev_condition' => $this->input->post('meter_dev_condition',TRUE),
		'meter_disp_condition' => $this->input->post('meter_disp_condition',TRUE),
		'shuntrip_condition' => $this->input->post('shuntrip_condition',TRUE),
		'current_limiter' => $this->input->post('current_limiter',TRUE),
		'current_limiter_type' => $this->input->post('current_limiter_type',TRUE),
		'current_limiter_brand' => $this->input->post('current_limiter_brand',TRUE),
		'modem_condition' => $this->input->post('modem_condition',TRUE),
		'modem_imei' => $this->input->post('modem_imei',TRUE),
		'modem_type' => $this->input->post('modem_type',TRUE),
		'modem_brand' => $this->input->post('modem_brand',TRUE),
		'ant_potition' => $this->input->post('ant_potition',TRUE),
		'Ratio_CT' => $this->input->post('Ratio_CT',TRUE),
		'top_panel_door_seal' => $this->input->post('top_panel_door_seal',TRUE),
		'bottom_panel_door_seal' => $this->input->post('bottom_panel_door_seal',TRUE),
		'meter_dev_seal' => $this->input->post('meter_dev_seal',TRUE),
		'modem_seal' => $this->input->post('modem_seal',TRUE),
		'latitude' => $this->input->post('latitude',TRUE),
		'longitude' => $this->input->post('longitude',TRUE),
		'site_allocation' => $this->input->post('site_allocation',TRUE),
		'note' => $this->input->post('note',TRUE),
		'photo_panel' => $this->input->post('photo_panel',TRUE),
		'photo_meter_dev' => $this->input->post('photo_meter_dev',TRUE),
		'photo_shuntrip' => $this->input->post('photo_shuntrip',TRUE),
		'photo_current_limiter' => $this->input->post('photo_current_limiter',TRUE),
		'photo_building' => $this->input->post('photo_building',TRUE),
		'photo_1' => $this->input->post('photo_1',TRUE),
		'photo_2' => $this->input->post('photo_2',TRUE),
		'status' => $this->input->post('status',TRUE),
		'reason' => $this->input->post('reason',TRUE),
	    );

            $this->Work_order_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('work_order'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Work_order_model->get_by_id($id);

        if ($row) {
            $this->Work_order_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('work_order'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('work_order'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('task_id', 'task id', 'trim|required');
	$this->form_validation->set_rules('document_no', 'document no', 'trim|required');
	$this->form_validation->set_rules('date', 'date', 'trim|required');
	$this->form_validation->set_rules('customer_id', 'customer id', 'trim|required');
	$this->form_validation->set_rules('activities', 'activities', 'trim|required');
	$this->form_validation->set_rules('date_meter', 'date meter', 'trim|required');
	$this->form_validation->set_rules('time_meter', 'time meter', 'trim|required');
	$this->form_validation->set_rules('stand_meter_WBP', 'stand meter wbp', 'trim|required|numeric');
	$this->form_validation->set_rules('stand_meter_WBP1', 'stand meter wbp1', 'trim|required|numeric');
	$this->form_validation->set_rules('stand_meter_WBP2', 'stand meter wbp2', 'trim|required|numeric');
	$this->form_validation->set_rules('stand_meter_total', 'stand meter total', 'trim|required|numeric');
	$this->form_validation->set_rules('kvarh', 'kvarh', 'trim|required|numeric');
	$this->form_validation->set_rules('voltage_r', 'voltage r', 'trim|required|numeric');
	$this->form_validation->set_rules('voltage_s', 'voltage s', 'trim|required|numeric');
	$this->form_validation->set_rules('voltage_t', 'voltage t', 'trim|required|numeric');
	$this->form_validation->set_rules('current_r', 'current r', 'trim|required|numeric');
	$this->form_validation->set_rules('current_s', 'current s', 'trim|required|numeric');
	$this->form_validation->set_rules('current_t', 'current t', 'trim|required|numeric');
	$this->form_validation->set_rules('cosphi', 'cosphi', 'trim|required|numeric');
	$this->form_validation->set_rules('panel_condition', 'panel condition', 'trim|required');
	$this->form_validation->set_rules('meter_dev_condition', 'meter dev condition', 'trim|required');
	$this->form_validation->set_rules('meter_disp_condition', 'meter disp condition', 'trim|required');
	$this->form_validation->set_rules('shuntrip_condition', 'shuntrip condition', 'trim|required');
	$this->form_validation->set_rules('current_limiter', 'current limiter', 'trim|required');
	$this->form_validation->set_rules('current_limiter_type', 'current limiter type', 'trim|required');
	$this->form_validation->set_rules('current_limiter_brand', 'current limiter brand', 'trim|required');
	$this->form_validation->set_rules('modem_condition', 'modem condition', 'trim|required');
	$this->form_validation->set_rules('modem_imei', 'modem imei', 'trim|required');
	$this->form_validation->set_rules('modem_type', 'modem type', 'trim|required');
	$this->form_validation->set_rules('modem_brand', 'modem brand', 'trim|required');
	$this->form_validation->set_rules('ant_potition', 'ant potition', 'trim|required');
	$this->form_validation->set_rules('Ratio_CT', 'ratio ct', 'trim|required|numeric');
	$this->form_validation->set_rules('top_panel_door_seal', 'top panel door seal', 'trim|required');
	$this->form_validation->set_rules('bottom_panel_door_seal', 'bottom panel door seal', 'trim|required');
	$this->form_validation->set_rules('meter_dev_seal', 'meter dev seal', 'trim|required');
	$this->form_validation->set_rules('modem_seal', 'modem seal', 'trim|required');
	$this->form_validation->set_rules('latitude', 'latitude', 'trim|required');
	$this->form_validation->set_rules('longitude', 'longitude', 'trim|required');
	$this->form_validation->set_rules('site_allocation', 'site allocation', 'trim|required');
	$this->form_validation->set_rules('note', 'note', 'trim|required');
	$this->form_validation->set_rules('photo_panel', 'photo panel', 'trim|required');
	$this->form_validation->set_rules('photo_meter_dev', 'photo meter dev', 'trim|required');
	$this->form_validation->set_rules('photo_shuntrip', 'photo shuntrip', 'trim|required');
	$this->form_validation->set_rules('photo_current_limiter', 'photo current limiter', 'trim|required');
	$this->form_validation->set_rules('photo_building', 'photo building', 'trim|required');
	$this->form_validation->set_rules('photo_1', 'photo 1', 'trim|required');
	$this->form_validation->set_rules('photo_2', 'photo 2', 'trim|required');
	$this->form_validation->set_rules('status', 'status', 'trim|required');
	$this->form_validation->set_rules('reason', 'reason', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Work_order.php */
/* Location: ./application/controllers/Work_order.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-04-26 09:56:44 */
/* http://harviacode.com */