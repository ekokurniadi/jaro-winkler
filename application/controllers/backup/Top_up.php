<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Top_up extends MY_Controller {

    // protected $access = array('Admin', 'Pimpinan','Finance');
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('Top_up_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'top_up/index.dart?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'top_up/index.dart?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'top_up/index.dart';
            $config['first_url'] = base_url() . 'top_up/index.dart';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Top_up_model->total_rows($q);
        $top_up = $this->Top_up_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'top_up_data' => $top_up,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('header');
        $this->load->view('top_up_list', $data);
        $this->load->view('footer');
    }

    public function read($id) 
    {
        $row = $this->Top_up_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'driver' => $row->driver,
		'tanggal_top_up' => $row->tanggal_top_up,
		'nominal_top_up' => $row->nominal_top_up,
		'status' => $row->status,
	    );
            $this->load->view('header');
            $this->load->view('top_up_read', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('top_up'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('top_up/create_action'),
	    'id' => set_value('id'),
	    'driver' => set_value('driver'),
	    'tanggal_top_up' => set_value('tanggal_top_up'),
	    'nominal_top_up' => set_value('nominal_top_up'),
	    'status' => set_value('status'),
	);

        $this->load->view('header');
        $this->load->view('top_up_form', $data);
        $this->load->view('footer');
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
		CURLOPT_POSTFIELDS => '{"notification": {"body": "'.$body.'","title": "'.$title.'","sound": "default","badge":"1"}, "priority": "high", "data": {"click_action": "FLUTTER_NOTIFICATION_CLICK", "screen": "", "status": "done"}, "to": "'.$token.'"}', # attached post data dalam bentuk JSON String,
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
			$send = '{"notification": {"body": "'.$body.'","title": "'.$title.'","sound": "default","badge":"1"}, "priority": "high", "data": {"click_action": "FLUTTER_NOTIFICATION_CLICK", "screen": "", "status": "done"}, "to": "'.$token.'"}';
			$this->db->insert('log_notif', array('log'=>$send,'resp'=>$resp));
			return $resp;
		} else {
		  # selain itu request gagal (contoh: error 404 page not found)
		  // echo 'Error HTTP Code : '.$http_code."\n";
		  
			$send = '{"notification": {"body": "'.$body.'","title": "'.$title.'","sound": "default","badge":"1"}, "priority": "high", "data": {"click_action": "FLUTTER_NOTIFICATION_CLICK", "screen": "", "status": "done"}, "to": "'.$token.'"}';
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

    
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'driver' => $this->input->post('driver',TRUE),
		'tanggal_top_up' => $this->input->post('tanggal_top_up',TRUE),
		'nominal_top_up' => $this->input->post('nominal_top_up',TRUE),
		'status' => $this->input->post('status',TRUE),
	    );
                $driver = $this->input->post('driver');
               	$server_key = get_setting('server_fcm_driver');
		        $token = get_data('driver','id',$driver,'token');
		        $title = "Top Up Success";
	        	$body = "Top Up mu berhasil";
		        $screen ="list_notif";
		        
		        $hasil = $this->send_notif($server_key,$token,$title, $body, $screen);
				
				$insertNotif =array(
					"driver"=>$driver,
					"pesan"=>$body,
					"status"=>"1",
					"deleted"=>"0"
				);
             
             $this->db->insert('notifikasi',$insertNotif);
            
            $insert = $this->Top_up_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('top_up'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Top_up_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('top_up/update_action'),
		'id' => set_value('id', $row->id),
		'driver' => set_value('driver', $row->driver),
		'tanggal_top_up' => set_value('tanggal_top_up', $row->tanggal_top_up),
		'nominal_top_up' => set_value('nominal_top_up', $row->nominal_top_up),
		'status' => set_value('status', $row->status),
	    );
            $this->load->view('header');
            $this->load->view('top_up_form', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('top_up'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'driver' => $this->input->post('driver',TRUE),
		'tanggal_top_up' => $this->input->post('tanggal_top_up',TRUE),
		'nominal_top_up' => $this->input->post('nominal_top_up',TRUE),
		'status' => $this->input->post('status',TRUE),
	    );

            $this->Top_up_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('top_up'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Top_up_model->get_by_id($id);

        if ($row) {
            $this->Top_up_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('top_up'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('top_up'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('driver', 'driver', 'trim|required');
	$this->form_validation->set_rules('tanggal_top_up', 'tanggal top up', 'trim|required');
	$this->form_validation->set_rules('nominal_top_up', 'nominal top up', 'trim|required|numeric');
	$this->form_validation->set_rules('status', 'status', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Top_up.php */
/* Location: ./application/controllers/Top_up.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-03-17 03:24:01 */
/* http://harviacode.com */