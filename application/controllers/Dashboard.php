<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Dashboard extends MY_Controller {

    // protected $access=array('Admin');
    public function __construct()
    {
        parent::__construct();
        // $this->load->library('form_validation');
    }
    
	public function index()
	{	
        $data=array(
            'user'=>$this->db->get('user'),  
        );
       
        $this->load->view('header');
        $this->load->view('index',$data);
        // $this->load->view('footer');
    }  
    

    public function fetch_data(){
        $starts       = $this->input->post("start");
        $length       = $this->input->post("length");
        $LIMIT        = "LIMIT  $starts, $length ";
        $draw         = $this->input->post("draw");
        $search       = $this->input->post('search')['value'];
        $orders       = isset($_POST['order']) ? $_POST['order'] : ''; 
        
       
        if($_SESSION['level']=="Admin"){
            $where ="WHERE 1=1 ";
        }elseif ($_SESSION['level']=="Operator") {
            $where ="WHERE 1=1 AND b.area_name='{$_SESSION['area_name']}'";
        }elseif ($_SESSION['level']=="Lapangan") {
            $where ="WHERE 1=1 AND b.area_name='{$_SESSION['area_name']}'";
        }
        if($_SESSION['level']=="Admin"){
          $where2 ="WHERE 1=1 ";
        }elseif ($_SESSION['level']=="Operator") {
          $where2 ="WHERE 1=1 AND b.area_name='{$_SESSION['area_name']}'";
        }elseif ($_SESSION['level']=="Lapangan") {
          $where2 ="WHERE 1=1 AND b.area_name='{$_SESSION['area_name']}'";
        }
        $searchingColumn;
        $result=array();
        if (isset($search)) {
          if ($search != '') {
             $searchingColumn = $search;
                $where .= " AND (a.task_id LIKE '%$search%'
                                OR a.date LIKE '%$search%'
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
              $order_column = ['','a.customer_id','b.customer_name','b.address','a.indikasi','a.klasifikasi','a.task_status'];
              $order_clm  = $order_column[$order[0]['column']];
              $order_by   = $order[0]['dir'];
              $where .= " ORDER BY $order_clm $order_by ";
            } else {
              $where .= " ORDER BY c.status DESC ";
            }
          } else {
            $where .= " ORDER BY c.status DESC ";
          }
          if (isset($LIMIT)) {
            if ($LIMIT != '') {
              $where .= ' ' . $LIMIT;
            }
          }
        $index=1;
        $button="";
        $fetch = $this->db->query("SELECT a.*,b.customer_name,b.address,b.device_id,c.status as states FROM tasklist a join customer b on a.customer_id=b.customer_id left join work_order c on c.task_id=a.task_id $where");
        $fetch2 = $this->db->query("SELECT a.*,b.customer_name,b.address,b.device_id,c.status as states FROM tasklist a join customer b on a.customer_id=b.customer_id left join work_order c on c.task_id=a.task_id $where2");
        foreach($fetch->result() as $rows){
            $sub_array=array();
            $sub_array[]=$index;
            $sub_array[]=$rows->customer_id;
            $sub_array[]=$rows->customer_name;
            $sub_array[]=$rows->address;
            // $sub_array[]=$rows->indikasi;
            $petugas = $this->db->query("SELECT GROUP_CONCAT(name) as nama from petugas where groups='$rows->groups' and groups != ''");
            $sub_array[]=$petugas->row()->nama == null ||$petugas->row()->nama == "" ? "Belum ditentukan" : $petugas->row()->nama;
             
            $sub_array[]="<span style='color:lime;font-weight:bold'>".$rows->task_status."</span>";
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


}
?>