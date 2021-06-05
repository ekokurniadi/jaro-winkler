<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {
	
	function __construct()
    {
        parent::__construct();
		ini_set('display_errors', 0);
    }
    public function tes_fcm()
	{
		$driver="6";
		$server_key = get_setting('server_fcm_app');
		$token = get_data('petugas','id',"6",'token');
		$title = "Tes Aja";
		$body = "Hai Ini Tes notifikasi";
		$screen ="list_trx";
		$hasil = $this->send_notif($server_key,$token,$title, $body, $screen);
		$result = json_decode($hasil);
		if ($result->success == 1) {
			echo "berhasil";
		} else {
			echo "gagal";
		}

	}

	public function tes_fcm_notif()
	{
		$server_key = get_setting('server_fcm_app');
		$token = get_data('petugas','id',"6",'token');
		$title = "Tes Aja";
		$body = "Hai Ini Tes";
		$screen ="list_notif";
		$hasil = $this->send_notif($server_key,$token,$title, $body, $screen);
		$result = json_decode($hasil);
		if ($result->success == 1) {
			echo "berhasil";
		} else {
			echo "gagal";
		}

	}

	public function inputDataSurvey(){
		if($_POST){
			$id= $this->input->post('id');
			$document_no= $this->input->post('document_no');
			$customerID = $this->input->post('customer_id');
			$activities = $this->input->post('activities');
			$tanggal_survey = $this->input->post('tanggal_survey');
			// input ke data konsumen
			$merkMeter = $this->input->post('merk_meter');
			$gardu = $this->input->post('gardu');
			$lat = $this->input->post('lat');
			$long = $this->input->post('long');
			// Data Pembatas
			$panelCondition = $this->input->post('panel_condition');
			$shuntrip = $this->input->post('shuntrip');
			$currentLimiter = $this->input->post('currentLimiter');
			$currentLimiterType = $this->input->post('currentLimiterType');
			$currentLimiterBrand = $this->input->post('currentLimiterBrand');
			$tahun = $this->input->post('tahun');
			// data meter
			$meterDevCondition = $this->input->post('meterDevCondition');
			$meterDispCondition = $this->input->post('meterDispCondition');
			$dateMeter = $this->input->post('dateMeter');
			$timeMeter = $this->input->post('timeMeter');

			$cosphi = $this->input->post('cosphi');
			$wbp = $this->input->post('wbp');
			$lwbp1 = $this->input->post('lwbp1');
			$lwbp2 = $this->input->post('lwbp2');
			$totalKwh = $this->input->post('totalKwh');
			$kvrah = $this->input->post('kvrah');

			$vr = $this->input->post('vr');
			$vs = $this->input->post('vs');
			$vt = $this->input->post('vt');

			$cr = $this->input->post('cr');
			$cs = $this->input->post('cs');
			$ct = $this->input->post('ct');
			
			// modem
			$modemBrand = $this->input->post('modemBrand');
			$modemType = $this->input->post('modemType');
			$imei = $this->input->post('imei');
			$kondisi = $this->input->post('kondisi');
			$letakAntena = $this->input->post('letakAntena');

			// modem New
			$NewmodemBrand = $this->input->post('NewmodemBrand');
			$NewmodemType = $this->input->post('NewmodemType');
			$Newimei = $this->input->post('Newimei');
			$Newkondisi = $this->input->post('Newkondisi');
			$NewletakAntena = $this->input->post('NewletakAntena');

			// kondisi segel
			$top_panel_door_seal = $this->input->post('top_panel_door_seal');
			$bottom_panel_door_seal = $this->input->post('bottom_panel_door_seal');
			$meter_dev_seal = $this->input->post('meter_dev_seal');
			$modem_seal = $this->input->post('modem_seal');
			$site_allocation = $this->input->post('site_allocation');
			$note = $this->input->post('note');
			$gantiModem = $this->input->post('ganti_modem');

			$dataSurvey = array(
				"document_no"=>$document_no,
				"activities"=>$activities,
				"date_meter"=>$dateMeter,
				"time_meter"=>$timeMeter,
				"stand_meter_WBP"=>$wbp,
				"stand_meter_WBP1"=>$lwbp1,
				"stand_meter_WBP2"=>$lwbp2,
				"stand_meter_total"=>$totalKwh,
				"kvarh"=>$kvrah,
				"voltage_r"=>$vr,
				"voltage_s"=>$vs,
				"voltage_t"=>$vt,
				"current_r"=>$cr,
				"current_s"=>$cs,
				"current_t"=>$ct,
				"cosphi"=>$cosphi,
				"panel_condition"=>$panelCondition,
				"meter_dev_condition"=>$meterDevCondition,
				"meter_disp_condition"=>$meterDispCondition,
				"shuntrip_condition"=>$shuntrip,
				"current_limiter"=>$currentLimiter,
				"current_limiter_type"=>$currentLimiterType,
				"current_limiter_brand"=>$currentLimiterBrand,
				"modem_condition"=>$kondisi,
				"modem_imei"=>$imei,
				"modem_type"=>$modemType,
				"modem_brand"=>$modemBrand,
				"ant_potition"=>$letakAntena,
				"top_panel_door_seal"=>$top_panel_door_seal,
				"bottom_panel_door_seal"=>$bottom_panel_door_seal,
				"meter_dev_seal"=>$meter_dev_seal,
				"modem_seal"=>$modem_seal,
				"latitude"=>$lat,
				"longitude"=>$long,
				"site_allocation"=>$site_allocation,
				"note"=>$note,
				"ganti_modem"=>$gantiModem,
				"new_modem_condition"=>$Newkondisi,
				"tahun"=>$tahun,
				"tanggal_survey"=>$tanggal_survey,
			);

			$this->db->where('task_id',$id);
			$updateTask = $this->db->update('work_order',$dataSurvey);
			if($gantiModem=="Tidak"){
				$dataCustomer = array(
					"merk_meter"=>$merkMeter,
					"gardu"=>$gardu,
					"coordinate"=>$lat,
					"location"=>$long,
					"imei_modem"=>$imei,
					"tipe_modem"=>$modemType,
					"merk_modem"=>$modemBrand
				);
			}else{
				$dataCustomer = array(
					"merk_meter"=>$merkMeter,
					"gardu"=>$gardu,
					"coordinate"=>$lat,
					"location"=>$long,
					"imei_modem"=>$Newimei,
					"tipe_modem"=>$NewmodemType,
					"merk_modem"=>$NewmodemBrand
				);
			}
			$this->db->where('customer_id',$customerID);
			$updateCust = $this->db->update('customer',$dataCustomer);

			echo json_encode(array(
				"status"=>200,
				"message"=>"Berhasil menginput data survey."
			));
		}
	}

	public function updateStatusWO(){
		$taskID = $this->input->post('task_id');
		$status = $this->input->post('status');

		$data = array(
			"status"=>$status
		);
		$data2 = array(
			"task_status"=>$status
		);
		$this->db->where('task_id',$taskID);
		$update = $this->db->update('work_order',$data);
		$this->db->where('task_id',$taskID);
		$updateTasks = $this->db->update('tasklist',$data2);
		if($update){
			echo json_encode(array(
				"status"=>200,
				"data"=>$status,
				"message"=>"Success",
			));
		}else{
			echo json_encode(array(
				"status"=>500,
				"message"=>"Error",
			));
		}
		
		
	}

	public function getActivities(){
		$query = $this->db->query("SELECT * FROM activities");
		$response=array();
		foreach($query->result() as $rows){
			$sub_array=array();
			$sub_array[]=$rows->id;
			$sub_array[]=$rows->aktivitas;
			$response[]=$sub_array;
		}
		
		$result=array(
			"status"=>200,
			"data"=>$response
		);
		echo json_encode($result);

	}

	public function getTaskID(){
		$id = $this->input->post('id');
		
		
		$query = $this->db->query("select cust.customer_id,cust.customer_name,
		cust.address,cust.rate,cust.power,cust.merk_meter,cust.device_type,
		cust.device_id,cust.cellular_no,cust.IP_address,cust.gardu,
		cust.coordinate,cust.location,cust.area_name,wo.panel_condition,
		wo.shuntrip_condition,wo.current_limiter,wo.current_limiter_type,
		wo.current_limiter_brand,wo.tahun,wo.meter_dev_condition,
		wo.meter_disp_condition,wo.date_meter,wo.time_meter,wo.cosphi,
		wo.stand_meter_WBP,wo.stand_meter_WBP1,wo.stand_meter_WBP2,
		wo.stand_meter_total,wo.kvarh,wo.voltage_r,wo.voltage_s,
		wo.voltage_t,wo.current_r,wo.current_s,wo.current_t,
		wo.photo_panel,wo.photo_meter_dev,wo.photo_shuntrip,
		wo.photo_current_limiter,wo.photo_building,wo.photo_1,
		wo.photo_2,wo.modem_brand,wo.modem_type,wo.modem_imei,wo.new_modem_brand,wo.new_modem_type,wo.new_modem_imei,
		wo.modem_condition,wo.ant_potition,wo.top_panel_door_seal,wo.new_ant_potition,
		wo.bottom_panel_door_seal,wo.meter_dev_seal,wo.modem_seal,
		wo.site_allocation,wo.note,wo.activities,wo.ganti_modem,wo.new_modem_condition,wo.tanggal_survey from customer cust left 
		join work_order wo on cust.customer_id=wo.customer_id 
		where wo.task_id='$id'");

		$data=array(

			"customer_id"=>$query->row()->customer_id,
			"customer_name"=>$query->row()->customer_name,
			"customer_address"=>$query->row()->address,
			"rate"=>$query->row()->rate,
			"power"=>$query->row()->power,
			"merk_meter"=>$query->row()->merk_meter,
			"device_type"=>$query->row()->device_type,
			"device_id"=>$query->row()->device_id,
			"cellular_no"=>$query->row()->cellular_no,
			"IP_address"=>$query->row()->IP_address,
			"gardu"=>$query->row()->gardu == "" ? "-" :$query->row()->gardu ,
			"latitude"=>$query->row()->coordinate,
			"longitude"=>str_replace(' ','',$query->row()->location),
			"up3"=>strtoupper($query->row()->area_name),
			"panel_condition"=>$query->row()->panel_condition== "" ? "-" : $query->row()->panel_condition,
			"shuntrip_condition"=>$query->row()->shuntrip_condition== "" ? "-" : $query->row()->shuntrip_condition,
			"current_limiter"=>$query->row()->current_limiter== "" ? "-" : $query->row()->current_limiter,
			"current_limiter_type"=>$query->row()->current_limiter_type== "" ? "-" : $query->row()->current_limiter_type,
			"current_limiter_brand"=>$query->row()->current_limiter_brand== "" ? "-" : $query->row()->current_limiter_brand,
			"tahun"=>$query->row()->tahun== "" ? "-" : $query->row()->tahun,
			"meter_dev_condition"=>$query->row()->meter_dev_condition== "" ? "-" : $query->row()->meter_dev_condition,
			"meter_dev_condition"=>$query->row()->meter_dev_condition== "" ? "-" : $query->row()->meter_dev_condition,
			"meter_disp_condition"=>$query->row()->meter_disp_condition== "" ? "-" : $query->row()->meter_disp_condition,
			"date_meter"=>$query->row()->date_meter== "" ? "-" : $query->row()->date_meter,
			"time_meter"=>$query->row()->time_meter== "" ? "-" : $query->row()->time_meter,
			"cosphi"=>$query->row()->cosphi== "" ? "-" : $query->row()->cosphi,
			"stand_meter_WBP"=>$query->row()->stand_meter_WBP== "" ? "-" : $query->row()->stand_meter_WBP,
			"stand_meter_WBP1"=>$query->row()->stand_meter_WBP1== "" ? "-" : $query->row()->stand_meter_WBP1,
			"stand_meter_WBP2"=>$query->row()->stand_meter_WBP2== "" ? "-" : $query->row()->stand_meter_WBP2,
			"stand_meter_total"=>$query->row()->stand_meter_total== "" ? "-" : $query->row()->stand_meter_total,
			"kvarh"=>$query->row()->kvarh== "" ? "-" : $query->row()->kvarh,
			"voltage_r"=>$query->row()->voltage_r== "" ? "-" : $query->row()->voltage_r,
			"voltage_s"=>$query->row()->voltage_s== "" ? "-" : $query->row()->voltage_s,
			"voltage_t"=>$query->row()->voltage_t== "" ? "-" : $query->row()->voltage_t,
			"current_r"=>$query->row()->current_r== "" ? "-" : $query->row()->current_r,
			"current_s"=>$query->row()->current_s== "" ? "-" : $query->row()->current_s,
			"current_t"=>$query->row()->current_t== "" ? "-" : $query->row()->current_t,
			"photo_panel"=>$query->row()->photo_panel== "" ? "" : $query->row()->photo_panel,
			"photo_meter_dev"=>$query->row()->photo_meter_dev== "" ? "" : $query->row()->photo_meter_dev,
			"photo_shuntrip"=>$query->row()->photo_shuntrip== "" ? "" : $query->row()->photo_shuntrip,
			"photo_current_limiter"=>$query->row()->photo_current_limiter== "" ? "" : $query->row()->photo_current_limiter,
			"photo_building"=>$query->row()->photo_building== "" ? "" : $query->row()->photo_building,
			"photo_1"=>$query->row()->photo_1== "" ? "" : $query->row()->photo_1,
			"photo_2"=>$query->row()->photo_2== "" ? "" : $query->row()->photo_2,
			"modem_brand"=>$query->row()->modem_brand== "" ? "-" : $query->row()->modem_brand,
			"modem_type"=>$query->row()->modem_type== "" ? "-" : $query->row()->modem_type,
			"modem_imei"=>$query->row()->modem_imei== "" ? "-" : $query->row()->modem_imei,
			"new_modem_brand"=>$query->row()->new_modem_brand== "" ? "-" : $query->row()->new_modem_brand,
			"new_modem_type"=>$query->row()->new_modem_type== "" ? "-" : $query->row()->new_modem_type,
			"new_modem_imei"=>$query->row()->new_modem_imei== "" ? "-" : $query->row()->new_modem_imei,
			"modem_condition"=>$query->row()->modem_condition== "" ? "-" : $query->row()->modem_condition,
			"ant_potition"=>$query->row()->ant_potition== "" ? "-" : $query->row()->ant_potition,
			"top_panel_door_seal"=>$query->row()->top_panel_door_seal== "" ? "-" : $query->row()->top_panel_door_seal,
			"new_ant_potition"=>$query->row()->new_ant_potition== "" ? "-" : $query->row()->new_ant_potition,
			"bottom_panel_door_seal"=>$query->row()->bottom_panel_door_seal== "" ? "-" : $query->row()->bottom_panel_door_seal,
			"meter_dev_seal"=>$query->row()->meter_dev_seal== "" ? "-" : $query->row()->meter_dev_seal,
			"modem_seal"=>$query->row()->modem_seal== "" ? "-" : $query->row()->modem_seal,
			"site_allocation"=>$query->row()->site_allocation== "" ? "-" : $query->row()->site_allocation,
			"note"=>$query->row()->note== "" ? "-" : $query->row()->note,
			"activities"=>$query->row()->activities== "" ? "Belum dipilih" : $query->row()->activities,
			"ganti_modem"=>$query->row()->ganti_modem,
			"new_modem_condition"=>$query->row()->new_modem_condition,
			"tanggal_survey"=>$query->row()->tanggal_survey,
		
		);
		echo json_encode(array(
			"status"=>200,
			"data"=>$data
		));
	}

	public function uploadFotoPanel(){
	
		$id = $_POST['id'];
		$image = $_POST['image'];
    	$name = $_POST['name'];
		$folderPath="./image/".$name;
    	$realImage = base64_decode($image);
   		$files = file_put_contents("./image/".$name, $realImage);
		$data = array(
            "photo_panel"=> $name,	
        );
		$this->db->where('task_id',$id);
        $this->db->update('work_order',$data);
		echo json_encode(array(
			"status"=>"1",
			"pesan"=>"Foto berhasil di Upload",  
        ));
    }

	public function uploadFotoMeter(){
	
		$id = $_POST['id'];
		$image = $_POST['image'];
    	$name = $_POST['name'];
		$folderPath="./image/".$name;
    	$realImage = base64_decode($image);
   		$files = file_put_contents("./image/".$name, $realImage);
		$data = array(
            "photo_meter_dev"=> $name,	
        );
		$this->db->where('task_id',$id);
        $this->db->update('work_order',$data);
		echo json_encode(array(
			"status"=>"1",
			"pesan"=>"Foto berhasil di Upload",  
        ));
    }

	public function uploadFotoShuntrip(){
	
		$id = $_POST['id'];
		$image = $_POST['image'];
    	$name = $_POST['name'];
		$folderPath="./image/".$name;
    	$realImage = base64_decode($image);
   		$files = file_put_contents("./image/".$name, $realImage);
		$data = array(
            "photo_shuntrip"=> $name,	
        );
		$this->db->where('task_id',$id);
        $this->db->update('work_order',$data);
		echo json_encode(array(
			"status"=>"1",
			"pesan"=>"Foto berhasil di Upload",  
        ));
    }
	public function uploadFotoLimiter(){
	
		$id = $_POST['id'];
		$image = $_POST['image'];
    	$name = $_POST['name'];
		$folderPath="./image/".$name;
    	$realImage = base64_decode($image);
   		$files = file_put_contents("./image/".$name, $realImage);
		$data = array(
            "photo_current_limiter"=> $name,	
        );
		$this->db->where('task_id',$id);
        $this->db->update('work_order',$data);
		echo json_encode(array(
			"status"=>"1",
			"pesan"=>"Foto berhasil di Upload",  
        ));
    }
	public function uploadFotoBuilding(){
	
		$id = $_POST['id'];
		$image = $_POST['image'];
    	$name = $_POST['name'];
		$folderPath="./image/".$name;
    	$realImage = base64_decode($image);
   		$files = file_put_contents("./image/".$name, $realImage);
		$data = array(
            "photo_building"=> $name,	
        );
		$this->db->where('task_id',$id);
        $this->db->update('work_order',$data);
		echo json_encode(array(
			"status"=>"1",
			"pesan"=>"Foto berhasil di Upload",  
        ));
    }
	public function uploadFoto1(){
	
		$id = $_POST['id'];
		$image = $_POST['image'];
    	$name = $_POST['name'];
		$folderPath="./image/".$name;
    	$realImage = base64_decode($image);
   		$files = file_put_contents("./image/".$name, $realImage);
		$data = array(
            "photo_1"=> $name,	
        );
		$this->db->where('task_id',$id);
        $this->db->update('work_order',$data);
		echo json_encode(array(
			"status"=>"1",
			"pesan"=>"Foto berhasil di Upload",  
        ));
    }
	public function uploadFoto2(){
	
		$id = $_POST['id'];
		$image = $_POST['image'];
    	$name = $_POST['name'];
		$folderPath="./image/".$name;
    	$realImage = base64_decode($image);
   		$files = file_put_contents("./image/".$name, $realImage);
		$data = array(
            "photo_2"=> $name,	
        );
		$this->db->where('task_id',$id);
        $this->db->update('work_order',$data);
		echo json_encode(array(
			"status"=>"1",
			"pesan"=>"Foto berhasil di Upload",  
        ));
    }

    public function login()
	{
		if ($_POST) {
			$nik = $this->input->post('nik');
			$password = $this->input->post('password');
			$token_fcm = $this->input->post('token');
            
			$cek = $this->db->get_where('petugas', array('nik' => $nik, 'password' => $password));

			if ($cek->num_rows() == 1) {
				$data = $cek->row();

				//cek driver aktif
				if ($data->status == "0") {
						$result = array(
							'status' => "0",
							'pesan' => 'Akun kamu belum aktif, silahkan hubungi admin'
						);
						echo json_encode($result);
						exit();
				}

				// update fcm token
				$this->db->where('id', $data->id);
				$this->db->update('petugas', array('token'=>$token_fcm,'status_online'=>'1'));
				$result = array(
                    'status'=>"1",
					'id' => $data->id,
					'nama' => $data->name,
					'nik' => $data->NIK,
					'alamat' => $data->address,
					'noHp' => $data->cellular_no,
					'grup' => $data->groups,
					'area' => $data->area_name,
					'level'=>$data->level,
					'pesan' => "Selamat datang dan selamat beraktifitas $data->name"
				);
				echo json_encode($result);
			} else {
				$result = array(
					'status' => "0",
					'pesan' => 'Gagal, Username atau Password tidak cocok'
				);
				echo json_encode($result);
			}
		}
	}

	public function logOut(){
		if ($_GET) {
			$id = $this->input->get('id');
			$update = $this->db->query("UPDATE petugas SET status_online='0' WHERE id='$id'");
			if ($update) {
				echo "berhasil update $id";
			}
			exit();
		}
	}

	public function getNotification(){
		$area = $_SESSION['area_name'];
		if($_SESSION['level']=="Admin"){
			$notifPendaftaranDriver = $this->db->query("SELECT a.*,b.customer_name FROM tasklist a join customer b on a.customer_id=b.customer_id where a.task_status='belum' order by id desc");
		}else{
			$notifPendaftaranDriver = $this->db->query("SELECT a.*,b.customer_name FROM tasklist a join customer b on a.customer_id=b.customer_id where a.task_status='belum' and a.area_name='$area' order by id desc");
		}
		
		$result=array();
		$data=array();
		
		if($notifPendaftaranDriver->num_rows() > 0){
			foreach($notifPendaftaranDriver->result() as $rows){
				$sub_array=array();
				$sub_array[]=$rows->id;
				$sub_array[]=$rows->customer_name;
				$sub_array[]= base_url()."tasklist/update/".$rows->id;
				$sub_array[]="Target Operasi baru atas nama ".$rows->customer_name.", silahkan cek data nya";
				$data[]=$sub_array;
			}
			echo json_encode(array(
				"total_notif"=>$notifPendaftaranDriver->num_rows(),
				"pesan"=>"Kamu memiliki ".$notifPendaftaranDriver->num_rows()." pemberitahuan",
				"data"=>$data,
			));
		}else{
			echo json_encode(array(
				"total_notif"=>$notifPendaftaranDriver->num_rows(),
				"pesan"=>"Kamu memiliki ".$notifPendaftaranDriver->num_rows()." pemberitahuan",
				"data"=>$data,
			));
		}
	}

	public function ambil_grup()
    {
        $grup = $_POST['grup'];
        $data = $this->db->query("SELECT * FROM grup WHERE id='$grup'")->result();
        foreach($data as $dd)
        {
            $data =array(
                'grup'=>$dd->nama_up3    
            );
            
           echo json_encode($data);
        }
    }

	public function ambil_area()
    {
        $kode = $_POST['kode'];
        $data = $this->db->query("SELECT * FROM area WHERE area_code='$kode' group by area_code")->result();
        foreach($data as $dd)
        {
            $data =array(
                'area_name'=>$dd->area_name    
            );
            
           echo json_encode($data);
        }
    }

	public function getTotalNotif(){
		$id = $this->input->post('id');
		$data = $this->db->query("SELECT * FROM notifikasi WHERE user_id='$id' AND status='0' and deleted='0'");
		$result=array();
		$result = array(
			"status"=>200,
			"total_notif"=>$data->num_rows(),
		);
		echo json_encode($result);
	}

	public function getNotif(){
		if($_POST){
			$id= $this->input->post('id');
			$deleted = $this->input->post('deleted');
			$result=array();
			$data = $this->db->query("SELECT a.*,b.name FROM notifikasi a join petugas b on a.user_id=b.id where a.user_id = '$id' and a.deleted ='$deleted' order by a.id DESC");
			
			$response = array();
			if($data->num_rows() <= 0){
				$result=array(
					"status"=>"0",
					"pesan"=>"Tidak ada notifikasi"
				);
				echo json_encode($result);
			}else{
				foreach($data->result() as $rows){
					$sub_array=array();
					$sub_array[]="Hallo ".$rows->name.", ".$rows->pesan;
					$sub_array[]=$rows->status;
					$sub_array[]=formatTanggal(substr($rows->created,0,10));
					$sub_array[]=substr($rows->created,11,19);
					$sub_array[]=$rows->id;
					$response[]=$sub_array;
				}
				
				$result=array(
					"status"=>"1",
					"pesan"=>"Success",
					"values"=>$response
				);
				echo json_encode($result);
			}
		}
	}

	public function updateStatusNotif(){
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		$deleted = $this->input->post('deleted');

		$update = $this->db->query("UPDATE notifikasi set status = '$status',deleted ='$deleted' where id='$id'");
		if($update){
			echo json_encode(array(
				"status"=>200,
				"message"=>"Berhasil melakukan perubahan data."
			));
		}else{
			echo json_encode(array(
				"status"=>"error",
				"message"=>"Gagal"
			));
		}
	} 

	public function getTask(){
		$groups = $this->input->post("groups");
		$filter = isset($_POST['filter']) ? $_POST['filter'] :'';
		$where ="where a.status='Persiapan'";
		if($filter == ""){
			$where .=" AND a.groups='$groups'";
		}else{
			$where .=" AND a.groups='$groups' and (a.task_id LIKE '%$filter%'
												   OR a.customer_id LIKE '%$filter%'
												   OR b.customer_name LIKE '%$filter%'
												   OR b.address LIKE '%$filter%'
												   OR b.cellular_no LIKE '%$filter%'
												   OR b.rate LIKE '%$filter%'
												   OR b.power LIKE '%$filter%'
												   OR a.status LIKE '%$filter%'
												   OR b.response LIKE '%$filter%'
												   )";
		}
		$where .=" ORDER BY a.date ASC";
		
		$query = $this->db->query("SELECT a.id,a.date,a.task_id,a.customer_id,a.status,b.customer_name,b.address,concat(b.response,' Days Offline') as response,
		b.coordinate as latitude,b.location as longitude,b.cellular_no,b.rate as tarif,b.power as daya 
		from work_order a join customer b on a.customer_id =b.customer_id $where");
		$result=array();
		if($query->num_rows() > 0){
			foreach($query->result() as $rows){
				$sub_array=array();
				$sub_array[]=$rows->id;
				$sub_array[]=$rows->task_id;
				$sub_array[]=$rows->customer_id;
				$sub_array[]=$rows->customer_name;
				$sub_array[]=$rows->address;
				$sub_array[]=$rows->latitude;
				$sub_array[]=$rows->longitude;
				$sub_array[]=$rows->cellular_no;
				$sub_array[]=$rows->tarif;
				$sub_array[]=$rows->daya;
				$sub_array[]=$rows->status;
				$sub_array[]=$rows->response;
				$sub_array[]=tgl_indo($rows->date);

				$result[]=$sub_array;
			}	
			echo json_encode(array(
				"status"=>200,
				"message"=>"Success",
				"data"=>$result
			));
		}else{
			echo json_encode(array(
				"status"=>"error",
				"message"=>"Data tidak ditemukan",
				
			));
		}
	}
	// get task pending
	public function getTaskPending(){
		$groups = $this->input->post("groups");
		$filter = isset($_POST['filter']) ? $_POST['filter'] :'';
		$where ="where a.status in('Pending')";
		if($filter == ""){
			$where .=" AND a.groups='$groups'";
		}else{
			$where .=" AND a.groups='$groups' and (a.task_id LIKE '%$filter%'
												   OR a.customer_id LIKE '%$filter%'
												   OR b.customer_name LIKE '%$filter%'
												   OR b.address LIKE '%$filter%'
												   OR b.cellular_no LIKE '%$filter%'
												   OR b.rate LIKE '%$filter%'
												   OR b.power LIKE '%$filter%'
												   OR a.status LIKE '%$filter%'
												   OR b.response LIKE '%$filter%'
												   )";
		}
		$where .=" ORDER BY a.id DESC";
		
		$query = $this->db->query("SELECT a.id,a.date,a.task_id,a.customer_id,a.status,b.customer_name,b.address,concat(b.response,' Days Offline') as response,
		b.coordinate as latitude,b.location as longitude,b.cellular_no,b.rate as tarif,b.power as daya 
		from work_order a join customer b on a.customer_id =b.customer_id $where");
		$result=array();
		if($query->num_rows() > 0){
			foreach($query->result() as $rows){
				$sub_array=array();
				$sub_array[]=$rows->id;
				$sub_array[]=$rows->task_id;
				$sub_array[]=$rows->customer_id;
				$sub_array[]=$rows->customer_name;
				$sub_array[]=$rows->address;
				$sub_array[]=$rows->latitude;
				$sub_array[]=$rows->longitude;
				$sub_array[]=$rows->cellular_no;
				$sub_array[]=$rows->tarif;
				$sub_array[]=$rows->daya;
				$sub_array[]=$rows->status;
				$sub_array[]=$rows->response;
				$sub_array[]=tgl_indo($rows->date);

				$result[]=$sub_array;
			}	
			echo json_encode(array(
				"status"=>200,
				"message"=>"Success",
				"data"=>$result
			));
		}else{
			echo json_encode(array(
				"status"=>"error",
				"message"=>"Data tidak ditemukan",
				
			));
		}
	}

	// get task cancel
	// get task pending
	public function getTaskCancel(){
		$groups = $this->input->post("groups");
		$filter = isset($_POST['filter']) ? $_POST['filter'] :'';
		$where ="where a.status in('Cancel')";
		if($filter == ""){
			$where .=" AND a.groups='$groups'";
		}else{
			$where .=" AND a.groups='$groups' and (a.task_id LIKE '%$filter%'
												   OR a.customer_id LIKE '%$filter%'
												   OR b.customer_name LIKE '%$filter%'
												   OR b.address LIKE '%$filter%'
												   OR b.cellular_no LIKE '%$filter%'
												   OR b.rate LIKE '%$filter%'
												   OR b.power LIKE '%$filter%'
												   OR a.status LIKE '%$filter%'
												   OR b.response LIKE '%$filter%'
												   )";
		}
		$where .=" ORDER BY a.id DESC";
		
		$query = $this->db->query("SELECT a.id,a.date,a.task_id,a.customer_id,a.status,b.customer_name,b.address,concat(b.response,' Days Offline') as response,
		b.coordinate as latitude,b.location as longitude,b.cellular_no,b.rate as tarif,b.power as daya 
		from work_order a join customer b on a.customer_id =b.customer_id $where");
		$result=array();
		if($query->num_rows() > 0){
			foreach($query->result() as $rows){
				$sub_array=array();
				$sub_array[]=$rows->id;
				$sub_array[]=$rows->task_id;
				$sub_array[]=$rows->customer_id;
				$sub_array[]=$rows->customer_name;
				$sub_array[]=$rows->address;
				$sub_array[]=$rows->latitude;
				$sub_array[]=$rows->longitude;
				$sub_array[]=$rows->cellular_no;
				$sub_array[]=$rows->tarif;
				$sub_array[]=$rows->daya;
				$sub_array[]=$rows->status;
				$sub_array[]=$rows->response;
				$sub_array[]=tgl_indo($rows->date);

				$result[]=$sub_array;
			}	
			echo json_encode(array(
				"status"=>200,
				"message"=>"Success",
				"data"=>$result
			));
		}else{
			echo json_encode(array(
				"status"=>"error",
				"message"=>"Data tidak ditemukan",
				
			));
		}
	}
	// get task cancel

	public function sendLocation(){
		if($_POST){
			$lat  = $this->input->post("latitude");
			$long = $this->input->post("longitude");
			$afc = $this->input->post("afc");
			$id   = $this->input->post("id");

			$data = array(
				"latitude" => $lat,
				"longitude" => $long,
				"afc" => $afc,
			);
			if($lat != "" and $long != ""){
				$this->db->where('id',$id);
				$this->db->update('petugas',$data);
			}
			echo json_encode(array(
				"status"=>200,
				"message"=>"Success",
			));	
		}else{
			echo json_encode(array(
				"status"=>"error",
				"message"=>"Gagal Mendapatkan lokasi",
			));	
		}
	}

	public function all_lokasi()
	{	$area = $_SESSION['area_name'];
		if($_SESSION['level']=="Admin"){
			$data = $this->db->query("SELECT id,name as nama,ifNULL(latitude,0.0) as latitude,ifnull(longitude,0.0) as longitude,0 as bearing,afc from petugas");
		} else{
			$data = $this->db->query("SELECT id,name as nama,ifNULL(latitude,0.0) as latitude,ifnull(longitude,0.0) as longitude,0 as bearing,afc from petugas where area_name='$areatas'");
		}
		$attribs=array('id','nama','latitude','longitude','afc');


	    $dom=new DOMDocument('1.0','utf-8');
	    $dom->formatOutput=true;
	    $dom->standalone=true;
	    $dom->recover=true;

	    $root=$dom->createElement('markers');
	    $dom->appendChild( $root );


	    foreach ($data->result() as $rs) {
	    	$node=$dom->createElement('marker');
	        $root->appendChild( $node );

	        foreach( $attribs as $attrib ){
	            $attr = $dom->createAttribute( $attrib );
	            $value= $dom->createTextNode( $rs->$attrib );
	            $attr->appendChild( $value );
	            $node->appendChild( $attr );
	        }
	    }

	    header("Content-Type: application/xml");
	    echo $dom->saveXML();


	}

	public function getLocation(){
		$data = $this->db->query("SELECT photo,id,name as nama,ifNULL(latitude,0.0) as latitude,ifnull(longitude,0.0) as longitude,afc from petugas");
		$result=array();
		foreach($data->result() as $rows){
			array_push($result,array(
				"id"=>$rows->id,
				"nama"=>$rows->nama,
				"lat"=>$rows->latitude,
				"long"=>$rows->longitude,
				"afc"=>	$rows->afc,
				"photo"=>$rows->photo	
			));
		}
		echo json_encode(array(
			"status"=>200,
			"data"=>$result,
		));
	}

	// get task complete
	public function getTaskComplete(){
		$groups = $this->input->post("groups");
		$filter = isset($_POST['filter']) ? $_POST['filter'] :'';
		$where ="where a.status in('Complete')";
		if($filter == ""){
			$where .=" AND a.groups='$groups'";
		}else{
			$where .=" AND a.groups='$groups' and (a.task_id LIKE '%$filter%'
												   OR a.customer_id LIKE '%$filter%'
												   OR b.customer_name LIKE '%$filter%'
												   OR b.address LIKE '%$filter%'
												   OR b.cellular_no LIKE '%$filter%'
												   OR b.rate LIKE '%$filter%'
												   OR b.power LIKE '%$filter%'
												   OR a.status LIKE '%$filter%'
												   OR b.response LIKE '%$filter%'
												   )";
		}
		$where .=" ORDER BY a.id DESC";
		
		$query = $this->db->query("SELECT a.id,a.date,a.task_id,a.customer_id,a.status,b.customer_name,b.address,concat(b.response,' Days Offline') as response,
		b.coordinate as latitude,b.location as longitude,b.cellular_no,b.rate as tarif,b.power as daya 
		from work_order a join customer b on a.customer_id =b.customer_id $where");
		$result=array();
		if($query->num_rows() > 0){
			foreach($query->result() as $rows){
				$sub_array=array();
				$sub_array[]=$rows->id;
				$sub_array[]=$rows->task_id;
				$sub_array[]=$rows->customer_id;
				$sub_array[]=$rows->customer_name;
				$sub_array[]=$rows->address;
				$sub_array[]=$rows->latitude;
				$sub_array[]=$rows->longitude;
				$sub_array[]=$rows->cellular_no;
				$sub_array[]=$rows->tarif;
				$sub_array[]=$rows->daya;
				$sub_array[]=$rows->status;
				$sub_array[]=$rows->response;
				$sub_array[]=tgl_indo($rows->date);

				$result[]=$sub_array;
			}	
			echo json_encode(array(
				"status"=>200,
				"message"=>"Success",
				"data"=>$result
			));
		}else{
			echo json_encode(array(
				"status"=>"error",
				"message"=>"Data tidak ditemukan",
				
			));
		}
	}

	// get task process
	public function getTaskProcess(){
		$groups = $this->input->post("groups");
		$filter = isset($_POST['filter']) ? $_POST['filter'] :'';
		$where ="where a.status in('Process','Test Dial','OTW')";
		if($filter == ""){
			$where .=" AND a.groups='$groups'";
		}else{
			$where .=" AND a.groups='$groups' and (a.task_id LIKE '%$filter%'
												   OR a.customer_id LIKE '%$filter%'
												   OR b.customer_name LIKE '%$filter%'
												   OR b.address LIKE '%$filter%'
												   OR b.cellular_no LIKE '%$filter%'
												   OR b.rate LIKE '%$filter%'
												   OR b.power LIKE '%$filter%'
												   OR a.status LIKE '%$filter%'
												   OR b.response LIKE '%$filter%'
												   )";
		}
		$where .=" ORDER BY a.id DESC";
		
		$query = $this->db->query("SELECT a.id,a.date,a.task_id,a.customer_id,a.status,b.customer_name,b.address,concat(b.response,' Days Offline') as response,
		b.coordinate as latitude,b.location as longitude,b.cellular_no,b.rate as tarif,b.power as daya 
		from work_order a join customer b on a.customer_id =b.customer_id $where");
		$result=array();
		if($query->num_rows() > 0){
			foreach($query->result() as $rows){
				$sub_array=array();
				$sub_array[]=$rows->id;
				$sub_array[]=$rows->task_id;
				$sub_array[]=$rows->customer_id;
				$sub_array[]=$rows->customer_name;
				$sub_array[]=$rows->address;
				$sub_array[]=$rows->latitude;
				$sub_array[]=$rows->longitude;
				$sub_array[]=$rows->cellular_no;
				$sub_array[]=$rows->tarif;
				$sub_array[]=$rows->daya;
				$sub_array[]=$rows->status;
				$sub_array[]=$rows->response;
				$sub_array[]=tgl_indo($rows->date);
				$result[]=$sub_array;
			}	
			echo json_encode(array(
				"status"=>200,
				"message"=>"Success",
				"data"=>$result
			));
		}else{
			echo json_encode(array(
				"status"=>"error",
				"message"=>"Data tidak ditemukan",
			));
		}
	}

	public function getCurrentUser(){
		$id = $this->input->post('id');
		$data = $this->db->query("SELECT a.id,a.name,a.address,a.cellular_no,a.area_name,a.password,a.area_name,a.NIK,a.photo,b.nama_up3,b.group from petugas a LEFT join grup b on a.groups=b.id where a.id='$id'");
		$result=array();
		if($data->num_rows() > 0){
			$result=array(
				"status"=>200,
				"id"=>$data->row()->id,
				"nama"=>$data->row()->name,
				"alamat"=>$data->row()->address,
				"no_hp"=>$data->row()->cellular_no,
				"up3"=>$data->row()->area_name,
				"grup"=>$data->row()->group == "" || $data->row()->group== null ? "-" : $data->row()->group,
				"username"=>$data->row()->NIK,
				"password"=>$data->row()->password,
				"foto"=>$data->row()->photo
			);
			echo json_encode($result);
		}
	}

	public function updateProfileUser(){
		$id = $this->input->post("id");
		$name = $this->input->post("nama");
		$alamat = $this->input->post("alamat");
		$noHp = $this->input->post("noHp");
		$password = $this->input->post("password");
		$result=array(
			"name"=>$name,
			"address"=>$alamat,
			"cellular_no"=>$noHp,
			"password"=>$password
		);
		$this->db->where('id',$id);
		$update = $this->db->update('petugas',$result);
		if($update){
			echo json_encode(array(
				"status"=>200,
				"message"=>"Berhasil melakukan perubahan data."
			));
		}else{
			echo json_encode(array(
				"status"=>"error",
				"message"=>"Gagal melakukan perubahan data."
			));
		}
	}

 
	public function updateFotoProfile(){
		$id = $_POST['id'];
		$image = $_POST['image'];
    	$name = $_POST['name'];
		$folderPath="./image/".$name;
    	$realImage = base64_decode($image);
   		$files = file_put_contents("./image/profil_user/".$name, $realImage);
		$data = array(
            "photo"=> $name,	
        );
		$this->db->where('id',$id);
        $this->db->update('petugas',$data);
		echo json_encode(array(
			"status"=>"1",
			"pesan"=>"Foto Profil berhasil di perbarui",  
        ));
    }


	public function dashboardWidget(){
		$groups = $this->input->post('groups');
		$complete = $this->db->get_where('work_order',array('status'=>'Complete','groups'=>$groups));
		$pending = $this->db->get_where('work_order',array('status'=>'Pending','groups'=>$groups));
		$cancel = $this->db->get_where('work_order',array('status'=>'Cancel','groups'=>$groups));
		$onGoing = $this->db->query("SELECT * FROM work_order where status in('OTW','Proses','Test Dial','Persiapan') and groups='$groups'");
		$total = ( $complete->num_rows() + $pending->num_rows() + $cancel->num_rows() + $onGoing->num_rows());
		$result=array(
			"complete"=>$complete->num_rows(),
			"pending"=>$pending->num_rows(),
			"cancel"=>$cancel->num_rows(),
			"onGoing"=>$onGoing->num_rows(),
			"total"=>$total,
			"persenComplete"=> round((($complete->num_rows() / $total) * 100)),
			"persenPending"=> round((($pending->num_rows() / $total) * 100)),
			"persenCancel"=> round((($cancel->num_rows() / $total) * 100)),
			"persenOnGoing"=> round((($onGoing->num_rows() / $total) * 100)),
		);

		echo json_encode(array(
			"status"=>200,
			"data"=>$result,
		));
	}

	public function dashboardWidgetAdmin(){
		$area = $this->input->post('area_name');
		$complete = $this->db->get_where('work_order',array('status'=>'Complete','area_name'=>$area));
		$pending = $this->db->get_where('work_order',array('status'=>'Pending','area_name'=>$area));
		$cancel = $this->db->get_where('work_order',array('status'=>'Cancel','area_name'=>$area));
		$onGoing = $this->db->query("SELECT * FROM work_order where status in('OTW','Proses','Test Dial','Persiapan') and area_name='$area'");
		$total = ( $complete->num_rows() + $pending->num_rows() + $cancel->num_rows() + $onGoing->num_rows());
		$result=array(
			"complete"=>$complete->num_rows(),
			"pending"=>$pending->num_rows(),
			"cancel"=>$cancel->num_rows(),
			"onGoing"=>$onGoing->num_rows(),
			"total"=>$total,
			"persenComplete"=> round((($complete->num_rows() / $total) * 100)),
			"persenPending"=> round((($pending->num_rows() / $total) * 100)),
			"persenCancel"=> round((($cancel->num_rows() / $total) * 100)),
			"persenOnGoing"=> round((($onGoing->num_rows() / $total) * 100)),
		);

		echo json_encode(array(
			"status"=>200,
			"data"=>$result,
		));
	}

	public function fetch_data(){
        $starts       = $this->input->post("start");
        $length       = $this->input->post("length");
        $LIMIT        = "LIMIT $starts, $length ";
        $draw         = $this->input->post("draw");
        $search       = $this->input->post('search');
        $orders       = isset($_POST['order']) ? $_POST['order'] : '';
		$referensi    = $this->input->post('ref');
		$level        = $this->input->post('level'); 
		$area         = $this->input->post('area_name');
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
                                )";
              }
          }

        if (isset($orders)) {
            if ($orders != '') {
              $order = $orders;
              $order_column = ['','a.task_id','a.tanggal_survey','a.date','a.customer_id','d.customer_name','a.activities','petugas','a.reason'];
              $order_clm  = $order_column[$order[0]['column']];
              $order_by   = $order[0]['dir'];
              $where .= "  ORDER BY $order_clm $order_by ";
            } else {
              $where .= "ORDER BY a.id ASC ";
            }
          } else {
            $where .= "ORDER BY a.id ASC ";
          }
          if (isset($LIMIT)) {
            if ($LIMIT != '') {
              $where .= ' ' . $LIMIT;
            }
          }
        $index=1;
        $button="";
        $fetch = $this->db->query("SELECT a.id,a.date,a.tanggal_survey,a.reason,a.status,a.task_id,a.document_no,a.customer_id,a.activities,d.customer_name,b.group,b.id as grp FROM work_order a join grup b on a.groups=b.id join petugas c on b.id=c.groups join customer d on d.customer_id=a.customer_id join tasklist e on e.task_id=a.task_id $where");
        $fetch2 = $this->db->query("SELECT a.id,a.date,a.tanggal_survey,a.reason,a.status,a.task_id,a.document_no,a.customer_id,a.activities,d.customer_name,b.group,b.id as grp FROM work_order a join grup b on a.groups=b.id join petugas c on b.id=c.groups join customer d on d.customer_id=a.customer_id join tasklist e on e.task_id=a.task_id where a.area_name='$area'");
        foreach($fetch->result() as $rows){
            
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
			
            // $sub_array[]=$button1." ". $button2;
            $result[]      = $sub_array;
            $index++;
			
        }
		
        $output = array(
          "draw"            =>     intval($this->input->post("draw")),
          "recordsFiltered" =>     $fetch2->num_rows(),
          "data"            =>     $result,
		  "status"			=>     200,
         
        );
        echo json_encode($output);

    }


	public function dashboardWidgetOP(){
		$area = $this->input->post('area_name');
		$complete = $this->db->get_where('work_order',array('status'=>'Complete','area_name'=>$area));
		$pending = $this->db->get_where('work_order',array('status'=>'Pending','area_name'=>$area));
		$cancel = $this->db->get_where('work_order',array('status'=>'Cancel','area_name'=>$area));
		$onGoing = $this->db->query("SELECT * FROM work_order where status in('OTW','Proses','Test Dial','Persiapan') and area_name='$area'");
		$total = ( $complete->num_rows() + $pending->num_rows() + $cancel->num_rows() + $onGoing->num_rows());
		$result=array(
			"complete"=>$complete->num_rows(),
			"pending"=>$pending->num_rows(),
			"cancel"=>$cancel->num_rows(),
			"onGoing"=>$onGoing->num_rows(),
			"total"=>$total,
			"persenComplete"=> round((($complete->num_rows() / $total) * 100)),
			"persenPending"=> round((($pending->num_rows() / $total) * 100)),
			"persenCancel"=> round((($cancel->num_rows() / $total) * 100)),
			"persenOnGoing"=> round((($onGoing->num_rows() / $total) * 100)),
		);

		echo json_encode(array(
			"status"=>200,
			"data"=>$result,
		));
	}


	public function updateStatus(){
		$status = $this->input->post('status');
		$alasan = $this->input->post('alasan');
		$id = $this->input->post('id');
		$result=array();
		$update = $this->db->query("UPDATE work_order set status='$status',reason='$alasan' where task_id='$id'");
		$update_task = $this->db->query("UPDATE tasklist set task_status='$status' where task_id='$id'");
		if($update){
			$result=[
				"status"=>200,
				"message"=>"Berhasil, melakukan perubahan data.",
			];
		}else{
			$result=[
				"status"=>404,
				"message"=>"Error, mohon periksa kembali.",
			];
		}
		echo json_encode($result);
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

	
}

/* End of file Api.php */

?>