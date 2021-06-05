<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Orders extends MY_Controller {

    protected $access = array('Admin', 'Pimpinan','Finance');
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('Orders_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'orders/index.dart?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'orders/index.dart?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'orders/index.dart';
            $config['first_url'] = base_url() . 'orders/index.dart';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Orders_model->total_rows($q);
        $orders = $this->Orders_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'orders_data' => $orders,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('header');
        $this->load->view('orders_list', $data);
        $this->load->view('footer');
    }

    public function read($id) 
    {
        $row = $this->Orders_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('orders/update_action'),
		'id' => set_value('id', $row->id),
		'kode_order' => set_value('kode_order', $row->kode_order),
		'nama_customer' => set_value('nama_customer', $row->nama_customer),
		'nomor_wa' => set_value('nomor_wa', $row->nomor_wa),
		'jadwal_kirim' => set_value('jadwal_kirim', $row->jadwal_kirim),
		'jam' => set_value('jam', $row->jam),
		'kota' => set_value('kota', $row->kota),
		'lantai' => set_value('lantai', $row->lantai),
		'parkir_mobil' => set_value('parkir_mobil', $row->parkir_mobil),
		'kota_kirim' => set_value('kota_kirim', $row->kota_kirim),
		'lantai_kirim' => set_value('lantai_kirim', $row->lantai_kirim),
		'parkir_mobil_kirim' => set_value('parkir_mobil_kirim', $row->parkir_mobil_kirim),
		'bantuan_customer' => set_value('bantuan_customer', $row->bantuan_customer),
		'barang_customer' => set_value('barang_customer', $row->barang_customer),
		'bantuan_driver' => set_value('bantuan_driver', $row->bantuan_driver),
		'bantuan_kenek' => set_value('bantuan_kenek', $row->bantuan_kenek),
		'biaya_tol' => set_value('biaya_tol', $row->biaya_tol),
		'biaya_overload' => set_value('biaya_overload', $row->biaya_overload),
		'waktu_tunggu' => set_value('waktu_tunggu', $row->waktu_tunggu),
		'total_customer_bayar' => set_value('total_customer_bayar', $row->total_customer_bayar),
		'cara_pembayaran' => set_value('cara_pembayaran', $row->cara_pembayaran),
		'catatan' => set_value('catatan', $row->catatan),
		'status' => set_value('status', $row->status),
		'ongkos_driver' => set_value('ongkos_driver', $row->ongkos_driver),
		'biaya_layanan' => set_value('biaya_layanan', $row->biaya_layanan),
		'status_pengantaran' => set_value('status_pengantaran', $row->status_pengantaran),
		'driver' => set_value('driver', $row->driver),
		'created_at' => set_value('created_at', $row->created_at),
		'alamat_antar' => set_value('alamat_antar', $row->alamat_antar),
		'alamat_jemput' => set_value('alamat_jemput', $row->alamat_jemput),
	    );
            $this->load->view('header');
            $this->load->view('orders_read', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('orders'));
        }
    }

    public function kode()
    {   
        $get_data = $this->db
        ->from('orders')
        ->limit(1)
        ->order_by('id', 'desc')
        ->get();
            
        if ($get_data->num_rows()>0) {
            $row        = $get_data->row();
            $kode_transaksi= substr($row->kode_order, -5);
            $new_kode = "TR" . sprintf("%'.05d", $kode_transaksi+1);
        } else {
            $new_kode   = "TR00001";
        }
        return strtoupper($new_kode);
    }


    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('orders/create_action'),
	    'id' => set_value('id'),
	    'kode_order' => $this->kode(),
	    'nama_customer' => set_value('nama_customer'),
	    'nomor_wa' => set_value('nomor_wa'),
	    'jadwal_kirim' => set_value('jadwal_kirim'),
	    'jam' => set_value('jam'),
	    'kota' => set_value('kota'),
	    'lantai' => set_value('lantai'),
	    'parkir_mobil' => set_value('parkir_mobil'),
	    'kota_kirim' => set_value('kota_kirim'),
	    'lantai_kirim' => set_value('lantai_kirim'),
	    'parkir_mobil_kirim' => set_value('parkir_mobil_kirim'),
	    'bantuan_customer' => set_value('bantuan_customer'),
	    'barang_customer' => set_value('barang_customer'),
	    'bantuan_driver' => set_value('bantuan_driver'),
	    'bantuan_kenek' => set_value('bantuan_kenek'),
	    'biaya_tol' => set_value('biaya_tol'),
	    'biaya_overload' => set_value('biaya_overload'),
	    'waktu_tunggu' => set_value('waktu_tunggu'),
	    'total_customer_bayar' => set_value('total_customer_bayar'),
	    'biaya_layanan' => set_value('biaya_layanan'),
	    'ongkos_driver' => set_value('ongkos_driver'),
	    'cara_pembayaran' => set_value('cara_pembayaran'),
	    'catatan' => set_value('catatan'),
	    'status' => set_value('status'),
	    'status_pengantaran' => set_value('status_pengantaran'),
	    'driver' => set_value('driver'),
	    'created_at' => set_value('created_at'),
	    'alamat_antar' => set_value('alamat_antar'),
	    'alamat_jemput' => set_value('alamat_jemput'),
	    'rt_jemput' => set_value('rt_jemput'),
	    'blok_jemput' => set_value('blok_jemput'),
	    'no_jemput' => set_value('no_jemput'),
	    'kelurahan_jemput' => set_value('kelurahan_jemput'),
	    'kecamatan_jemput' => set_value('kecamatan_jemput'),
	    'provinsi_jemput' => set_value('provinsi_jemput'),
	    'rt_antar' => set_value('rt_antar'),
	    'blok_antar' => set_value('blok_antar'),
	    'no_antar' => set_value('no_antar'),
	    'kelurahan_antar' => set_value('kelurahan_antar'),
	    'kecamatan_antar' => set_value('kecamatan_antar'),
	    'provinsi_antar' => set_value('provinsi_antar'),
	    'total_bayar' => set_value('total_bayar'),
	);
		
        $this->load->view('header');
        $this->load->view('orders_form', $data);
        $this->load->view('footer');
    }
    
    public function create_action() 
    {
		date_default_timezone_set("Asia/Jakarta");
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'kode_order' => $this->input->post('kode_order',TRUE),
		'nama_customer' => $this->input->post('nama_customer',TRUE),
		'nomor_wa' => $this->input->post('nomor_wa',TRUE),
		'jadwal_kirim' => $this->input->post('jadwal_kirim',TRUE),
		'jam' => $this->input->post('jam',TRUE),
		'kota' => $this->input->post('kota',TRUE),
		'lantai' => $this->input->post('lantai',TRUE),
		'parkir_mobil' => $this->input->post('parkir_mobil',TRUE),
		'kota_kirim' => $this->input->post('kota_kirim',TRUE),
		'lantai_kirim' => $this->input->post('lantai_kirim',TRUE),
		'parkir_mobil_kirim' => $this->input->post('parkir_mobil_kirim',TRUE),
		'bantuan_customer' => $this->input->post('bantuan_customer',TRUE),
		'barang_customer' => $this->input->post('barang_customer',TRUE),
		'bantuan_driver' => str_replace(',','',$this->input->post('bantuan_driver',TRUE)),
		'bantuan_kenek' => str_replace(',','',$this->input->post('bantuan_kenek',TRUE)),
		'biaya_tol' => str_replace(',','',$this->input->post('biaya_tol',TRUE)),
		'biaya_overload' =>str_replace(',','',$this->input->post('biaya_overload',TRUE)),
		'waktu_tunggu' => str_replace(',','',$this->input->post('waktu_tunggu',TRUE)),
		'total_customer_bayar' => str_replace(',','',$this->input->post('total_customer_bayar',TRUE)),
		'total_bayar' => str_replace(',','',$this->input->post('total_bayar',TRUE)),
		'biaya_layanan' =>str_replace(',','',$this->input->post('biaya_layanan',TRUE)),
		'ongkos_driver' => str_replace(',','',$this->input->post('ongkos_driver',TRUE)),
		'cara_pembayaran' => $this->input->post('cara_pembayaran',TRUE),
		'catatan' => $this->input->post('catatan',TRUE),
		'status' => "new_order",
		'status_pengantaran' => NULL,
		'driver' => NULL,
		'created_at' => date('Y-m-d H:i:s'),
		'alamat_jemput' => $this->input->post('alamat_jemput',TRUE),
		'alamat_antar' => $this->input->post('alamat_antar',TRUE),
		'rt_jemput' => $this->input->post('rt_jemput',TRUE),
	    'blok_jemput' => $this->input->post('blok_jemput',TRUE),
	    'no_jemput' => $this->input->post('no_jemput',TRUE),
	    'kelurahan_jemput' => $this->input->post('kelurahan_jemput',TRUE),
	    'kecamatan_jemput' => $this->input->post('kecamatan_jemput',TRUE),
	    'provinsi_jemput' => $this->input->post('provinsi_jemput',TRUE),
	    'rt_antar' => $this->input->post('rt_antar',TRUE),
	    'blok_antar' => $this->input->post('blok_antar',TRUE),
	    'no_antar' => $this->input->post('no_antar',TRUE),
	    'kelurahan_antar' => $this->input->post('kelurahan_antar',TRUE),
	    'kecamatan_antar' => $this->input->post('kecamatan_antar',TRUE),
	    'provinsi_antar' => $this->input->post('provinsi_antar',TRUE),
	    'total_bayar' =>str_replace(',','',$this->input->post('total_bayar',TRUE)),
	    );
			$kode_order = $this->input->post('kode_order');
			$kota = $this->input->post('kota');
			$this->blastOrders($kode_order);
            $this->Orders_model->insert($data);
            redirect(site_url('orders'));
        }
    }

	public function blastOrdersAgain($kode_order){
		date_default_timezone_set("Asia/Jakarta");
	
		$dataOrders = $this->db->get_where('orders',array('driver'=>NULL,'status'=>'new_order','status_pengantaran'=>NULL,'kode_order'=>$kode_order));

		$kota = $dataOrders->row()->kota;
		$tanggalSekarang = date($dataOrders->row()->created);
		$tanggalCreated15Detik  = date($dataOrders->row()->created, strtotime("+15 seconds"));

		$waktu15Detik = strtotime($tanggalCreated15Detik);
		$waktuAwal= strtotime($tanggalSekarang);
		$data=array();

		
			$driverOnSameArea = $this->db->query("select * from driver where status='1' and black_list ='0' and saldo >= 20000  and confirm ='1' and not EXISTS(select a.driver from orders a where a.status_pengantaran ='process')");
				foreach($driverOnSameArea->result() as $rows ){
					$sub_array=array();
					$sub_array[]=$dataOrders->row()->id;
					$sub_array[]=$dataOrders->row()->kode_order;
					$sub_array[]=$dataOrders->row()->nama_customer;
					$sub_array[]=$rows->nama;
					$sub_array[]=$rows->token;
					$data[]=$sub_array;	
				}
			
			echo json_encode(array("result"=>$data));
	}


	

	public function orderViewDetails(){

	}

	public function orderOnProcessViewByDriver(){

	}

	public function orderCancelByDriver(){

	}
	public function orderCompleteByDriver(){

	}

	public function blastOrders($kode_order,$kota){
		date_default_timezone_set("Asia/Jakarta");
	
		$data=array();

		
			$driverOnSameArea = $this->db->query("select * from driver where kota ='$kota' status='1' and black_list ='0' and saldo >= 20000 and confirm ='1' and id not in(select a.driver from orders a where a.status_pengantaran ='process')");
			if($driverOnSameArea->num_rows() > 0){
				foreach($driverOnSameArea->result() as $rows ){
					$sub_array=array();
					$server_key = get_setting('server_fcm_driver');
					$token=$rows->token;
					$title = "New Order";
					$body = "Hai, ".$rows->nama." kamu mendapatkan Orderan, ayo segera terima orderan mu.";
					$screen ="list_trx";
					$hasil = $this->send_notif($server_key,$token,$title, $body, $screen);
					$data[]=$sub_array;	
				}
				$this->session->set_flashdata('message', 'Order berhasil dibuat dan sudah di kirimkan ke driver');
				// redirect(site_url('orders'));
				echo json_encode(array("result"=>$data));
			}else{
				$this->session->set_flashdata('message', 'Order berhasil dibuat, namun tidak ada driver yang menerima order, silahkan klik tombol kirim ulang untuk kirim order');
				// redirect(site_url('orders'));
			}
	}

	public function blastOrdering($kode_order){
		date_default_timezone_set("Asia/Jakarta");
	
		$dataOrders = $this->db->get_where('orders',array('kode_order'=>$kode_order));
		$update = $this->db->query("UPDATE orders set status='new_order', driver = NULL where kode_order='$kode_order'");

		$kota = $dataOrders->row()->kota;
		$tanggalSekarang = date($dataOrders->row()->created);
		$tanggalCreated15Detik  = date($dataOrders->row()->created, strtotime("+15 seconds"));

		$waktu15Detik = strtotime($tanggalCreated15Detik);
		$waktuAwal= strtotime($tanggalSekarang);
		$data=array();

		
			$driverOnSameArea = $this->db->query("select * from driver where status='1' and black_list ='0' and saldo >= 20000 and status_online ='1' and confirm ='1' and not EXISTS(select a.driver from orders a where a.status_pengantaran ='process' AND a.kode_order='$kode_order')");
			if($driverOnSameArea->num_rows() > 0){
				foreach($driverOnSameArea->result() as $rows ){
					$sub_array=array();
					$server_key = get_setting('server_fcm_driver');
					$token=$rows->token;
					$title = "New Order";
					$body = "Hai, ".$rows->nama." kamu mendapatkan Orderan, ayo segera terima orderan mu.";
					$screen ="list_trx";
					$hasil = $this->send_notif($server_key,$token,$title, $body, $screen);
					$sub_array[]=$dataOrders->row()->id;
					$sub_array[]=$dataOrders->row()->kode_order;
					$sub_array[]=$dataOrders->row()->nama_customer;
					$sub_array[]=$rows->nama;
					$sub_array[]=$rows->token;
					$data[]=$sub_array;	
				}
				$this->session->set_flashdata('message', 'Order berhasil dibuat dan sudah di kirimkan ke driver');
				redirect(site_url('orders'));
				echo json_encode(array("result"=>$data));
			}else{
				$this->session->set_flashdata('message', 'Order berhasil dibuat, namun tidak ada driver yang menerima order, silahkan klik tombol kirim ulang untuk kirim order');
			redirect(site_url('orders'));
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
			// return $resp;
		} else {
		  # selain itu request gagal (contoh: error 404 page not found)
		  // echo 'Error HTTP Code : '.$http_code."\n";
		  
			$send = '{"notification": {"body": "'.$body.'","title": "'.$title.'","sound": "default","badge":"1"}, "priority": "high", "data": {"click_action": "FLUTTER_NOTIFICATION_CLICK", "screen": "", "status": "done"}, "to": "'.$token.'"}';
			$this->db->insert('log_notif', array('log'=>$send,'resp'=>$resp));
			// return $resp;
		}
		} else {
		# jika curl error (contoh: request timeout)
		# Daftar kode error : https://curl.haxx.se/libcurl/c/libcurl-errors.html
		// echo "Error while sending request, reason:".curl_error($ch);
		}

		# tutup CURL
		curl_close($ch);
	}


    public function update($id) 
    {
        $row = $this->Orders_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('orders/update_action'),
		'id' => set_value('id', $row->id),
		'kode_order' => set_value('kode_order', $row->kode_order),
		'nama_customer' => set_value('nama_customer', $row->nama_customer),
		'nomor_wa' => set_value('nomor_wa', $row->nomor_wa),
		'jadwal_kirim' => set_value('jadwal_kirim', $row->jadwal_kirim),
		'jam' => set_value('jam', $row->jam),
		'kota' => set_value('kota', $row->kota),
		'lantai' => set_value('lantai', $row->lantai),
		'parkir_mobil' => set_value('parkir_mobil', $row->parkir_mobil),
		'kota_kirim' => set_value('kota_kirim', $row->kota_kirim),
		'lantai_kirim' => set_value('lantai_kirim', $row->lantai_kirim),
		'parkir_mobil_kirim' => set_value('parkir_mobil_kirim', $row->parkir_mobil_kirim),
		'bantuan_customer' => set_value('bantuan_customer', $row->bantuan_customer),
		'barang_customer' => set_value('barang_customer', $row->barang_customer),
		'bantuan_driver' => set_value('bantuan_driver', $row->bantuan_driver),
		'bantuan_kenek' => set_value('bantuan_kenek', $row->bantuan_kenek),
		'biaya_tol' => set_value('biaya_tol', $row->biaya_tol),
		'biaya_overload' => set_value('biaya_overload', $row->biaya_overload),
		'waktu_tunggu' => set_value('waktu_tunggu', $row->waktu_tunggu),
		'total_customer_bayar' => set_value('total_customer_bayar', $row->total_customer_bayar),
		'cara_pembayaran' => set_value('cara_pembayaran', $row->cara_pembayaran),
		'catatan' => set_value('catatan', $row->catatan),
		'status' => set_value('status', $row->status),
		'ongkos_driver' => set_value('ongkos_driver', $row->ongkos_driver),
		'biaya_layanan' => set_value('biaya_layanan', $row->biaya_layanan),
		'status_pengantaran' => set_value('status_pengantaran', $row->status_pengantaran),
		'driver' => set_value('driver', $row->driver),
		'created_at' => set_value('created_at', $row->created_at),
		'alamat_antar' => set_value('alamat_antar', $row->alamat_antar),
		'alamat_jemput' => set_value('alamat_jemput', $row->alamat_jemput),
		'rt_jemput' => set_value('rt_jemput',$row->rt_jemput),
	    'blok_jemput' => set_value('blok_jemput',$row->blok_jemput),
	    'no_jemput' => set_value('no_jemput',$row->no_jemput),
	    'kelurahan_jemput' => set_value('kelurahan_jemput',$row->kelurahan_jemput),
	    'kecamatan_jemput' => set_value('kecamatan_jemput',$row->kecamatan_jemput),
	    'provinsi_jemput' => set_value('provinsi_jemput',$row->provinsi_jemput),
	    'rt_antar' => set_value('rt_antar',$row->rt_antar),
	    'blok_antar' => set_value('blok_antar',$row->blok_antar),
	    'no_antar' => set_value('no_antar',$row->no_antar),
	    'kelurahan_antar' => set_value('kelurahan_antar',$row->kelurahan_antar),
	    'kecamatan_antar' => set_value('kecamatan_antar',$row->kecamatan_antar),
	    'provinsi_antar' => set_value('provinsi_antar',$row->provinsi_antar),
	    'total_bayar' => set_value('total_bayar',$row->total_bayar),
	    );
            $this->load->view('header');
            $this->load->view('orders_form', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('orders'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'kode_order' => $this->input->post('kode_order',TRUE),
		'nama_customer' => $this->input->post('nama_customer',TRUE),
		'nomor_wa' => $this->input->post('nomor_wa',TRUE),
		'jadwal_kirim' => $this->input->post('jadwal_kirim',TRUE),
		'jam' => $this->input->post('jam',TRUE),
		'kota' => $this->input->post('kota',TRUE),
		'lantai' => $this->input->post('lantai',TRUE),
		'parkir_mobil' => $this->input->post('parkir_mobil',TRUE),
		'kota_kirim' => $this->input->post('kota_kirim',TRUE),
		'lantai_kirim' => $this->input->post('lantai_kirim',TRUE),
		'parkir_mobil_kirim' => $this->input->post('parkir_mobil_kirim',TRUE),
		'bantuan_customer' => $this->input->post('bantuan_customer',TRUE),
		'barang_customer' => $this->input->post('barang_customer',TRUE),
		'bantuan_driver' => $this->input->post('bantuan_driver',TRUE),
		'bantuan_kenek' => $this->input->post('bantuan_kenek',TRUE),
		'biaya_tol' => $this->input->post('biaya_tol',TRUE),
		'biaya_overload' => $this->input->post('biaya_overload',TRUE),
		'waktu_tunggu' => $this->input->post('waktu_tunggu',TRUE),
		'total_customer_bayar' => str_replace(',','',$this->input->post('total_customer_bayar',TRUE)),
		'biaya_layanan' =>str_replace(',','',$this->input->post('biaya_layanan',TRUE)),
		'ongkos_driver' => str_replace(',','',$this->input->post('ongkos_driver',TRUE)),
		'cara_pembayaran' => $this->input->post('cara_pembayaran',TRUE),
		'catatan' => $this->input->post('catatan',TRUE),
		'status' => $this->input->post('status',TRUE),
		'status_pengantaran' => $this->input->post('status_pengantaran',TRUE),
		'driver' => $this->input->post('driver',TRUE),
		'created_at' => $this->input->post('created_at',TRUE),
		'alamat_jemput' => $this->input->post('alamat_jemput',TRUE),
		'alamat_antar' => $this->input->post('alamat_antar',TRUE),
		'rt_jemput' => $this->input->post('rt_jemput',TRUE),
	    'blok_jemput' => $this->input->post('blok_jemput',TRUE),
	    'no_jemput' => $this->input->post('no_jemput',TRUE),
	    'kelurahan_jemput' => $this->input->post('kelurahan_jemput',TRUE),
	    'kecamatan_jemput' => $this->input->post('kecamatan_jemput',TRUE),
	    'provinsi_jemput' => $this->input->post('provinsi_jemput',TRUE),
	    'rt_antar' => $this->input->post('rt_antar',TRUE),
	    'blok_antar' => $this->input->post('blok_antar',TRUE),
	    'no_antar' => $this->input->post('no_antar',TRUE),
	    'kelurahan_antar' => $this->input->post('kelurahan_antar',TRUE),
	    'kecamatan_antar' => $this->input->post('kecamatan_antar',TRUE),
	    'provinsi_antar' => $this->input->post('provinsi_antar',TRUE),
	    'total_bayar' =>str_replace(',','',$this->input->post('total_bayar',TRUE)),
	    );

            $this->Orders_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('orders'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Orders_model->get_by_id($id);

        if ($row) {
            $this->Orders_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('orders'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('orders'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('kode_order', 'kode order', 'trim');
	$this->form_validation->set_rules('nama_customer', 'nama customer', 'trim|required');
	$this->form_validation->set_rules('nomor_wa', 'nomor wa', 'trim');
	$this->form_validation->set_rules('jadwal_kirim', 'jadwal kirim', 'trim|required');
	$this->form_validation->set_rules('jam', 'jam', 'trim|required');
	$this->form_validation->set_rules('kota', 'kota', 'trim|required');
	$this->form_validation->set_rules('lantai', 'lantai', 'trim');
	$this->form_validation->set_rules('parkir_mobil', 'parkir mobil', 'trim');
	$this->form_validation->set_rules('kota_kirim', 'kota kirim', 'trim|required');
	$this->form_validation->set_rules('alamat_jemput', 'alamat penjemputan', 'trim|required');
	$this->form_validation->set_rules('alamat_antar', 'alamat pengiriman', 'trim|required');
	$this->form_validation->set_rules('lantai_kirim', 'lantai kirim', 'trim');
	$this->form_validation->set_rules('parkir_mobil_kirim', 'parkir mobil kirim', 'trim');
	$this->form_validation->set_rules('barang_customer', 'barang customer', 'trim|required');
// 	$this->form_validation->set_rules('rt_jemput', 'RT Penjemputan', 'trim|required');
// 	$this->form_validation->set_rules('blok_jemput', 'Blok Penjemputan', 'trim|required');
// 	$this->form_validation->set_rules('no_jemput', 'No Penjemputan', 'trim|required');
// 	$this->form_validation->set_rules('kelurahan_jemput', 'Kelurahan Penjemputan', 'trim|required');
// 	$this->form_validation->set_rules('kecamatan_jemput', 'Kecamatan Penjemputan', 'trim|required');
// 	$this->form_validation->set_rules('provinsi_jemput', 'Provinsi Penjemputan', 'trim|required');
//     $this->form_validation->set_rules('rt_antar', 'RT Pengantaran', 'trim|required');
// 	$this->form_validation->set_rules('blok_antar', 'Blok Pengantaran', 'trim|required');
// 	$this->form_validation->set_rules('no_antar', 'No Pengantaran', 'trim|required');
// 	$this->form_validation->set_rules('kelurahan_antar', 'Kelurahan Pengantaran', 'trim|required');
// 	$this->form_validation->set_rules('kecamatan_antar', 'Kecamatan Pengantaran', 'trim|required');
// 	$this->form_validation->set_rules('provinsi_antar', 'Provinsi Pengantaran', 'trim|required');

	$this->form_validation->set_rules('total_customer_bayar', 'total customer bayar', 'trim|required');
	$this->form_validation->set_rules('total_bayar', 'total customer bayar', 'trim|required');
	$this->form_validation->set_rules('cara_pembayaran', 'cara pembayaran', 'trim|required');
	$this->form_validation->set_rules('catatan', 'catatan', 'trim');
	$this->form_validation->set_rules('status', 'status', 'trim');
	$this->form_validation->set_rules('status_pengantaran', 'status pengantaran', 'trim');
	$this->form_validation->set_rules('driver', 'driver', 'trim');
	$this->form_validation->set_rules('created_at', 'created at', 'trim');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Orders.php */
/* Location: ./application/controllers/Orders.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-03-17 03:23:12 */
/* http://harviacode.com */