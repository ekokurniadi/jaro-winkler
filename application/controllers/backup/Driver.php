<?php

// if (!defined('BASEPATH'))
//     exit('No direct script access allowed');

class Driver extends MY_Controller {

    // protected $access = array('Admin', 'Pimpinan','Finance');
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('Driver_model');
        $this->load->library('form_validation');
		$this->load->library('upload');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'driver/index.dart?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'driver/index.dart?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'driver/index.dart';
            $config['first_url'] = base_url() . 'driver/index.dart';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Driver_model->total_rows($q);
        $driver = $this->Driver_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'driver_data' => $driver,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('header');
        $this->load->view('driver_list', $data);
        $this->load->view('footer');
    }

    public function read($id) 
    {
        $row = $this->Driver_model->get_by_id($id);
        if ($row) {
            $data = array(
			'button' => 'Read',
			'action' => "",
		'id' => $row->id,
		'username' => $row->username,
		'password' => $row->password,
		'nama' => $row->nama,
		'foto_profil' => $row->foto_profil,
		'nomor_wa' => $row->nomor_wa,
		'plat_kendaraan' => $row->plat_kendaraan,
		'jenis_mobil' => $row->jenis_mobil,
		'tahun_kendaraan' => $row->tahun_kendaraan,
		'masa_aktif_sim' => $row->masa_aktif_sim,
		'foto_sim' => $row->foto_sim,
		'masa_aktif_stnk' => $row->masa_aktif_stnk,
		'foto_stnk' => $row->foto_stnk,
		'masa_aktif_kir' => $row->masa_aktif_kir,
		'foto_kir' => $row->foto_kir,
		'token' => $row->token,
		'status' => $row->status,
		'level' => $row->level,
		'status_online' => $row->status_online,
		'saldo' => $row->saldo,
		'confirm' => $row->confirm,
		'alamat' => $row->alamat,
		'kota' => $row->kota,
	    );
            $this->load->view('header');
            $this->load->view('driver_read', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('driver'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('driver/create_action'),
	    'id' => set_value('id'),
	    'username' => set_value('username'),
	    'password' => set_value('password'),
	    'nama' => set_value('nama'),
	    'foto_profil' => set_value('foto_profil'),
	    'nomor_wa' => set_value('nomor_wa'),
	    'plat_kendaraan' => set_value('plat_kendaraan'),
	    'jenis_mobil' => set_value('jenis_mobil'),
	    'tahun_kendaraan' => set_value('tahun_kendaraan'),
	    'masa_aktif_sim' => set_value('masa_aktif_sim'),
	    'foto_sim' => set_value('foto_sim'),
	    'masa_aktif_stnk' => set_value('masa_aktif_stnk'),
	    'foto_stnk' => set_value('foto_stnk'),
	    'masa_aktif_kir' => set_value('masa_aktif_kir'),
	    'foto_kir' => set_value('foto_kir'),
	    'token' => set_value('token'),
	    'status' => set_value('status'),
	    'level' => set_value('level'),
	    'status_online' => set_value('status_online'),
	    'saldo' => set_value('saldo'),
	    'confirm' => set_value('confirm'),
		'alamat' => set_value('alamat'),
		'kota' => set_value('kota'),
		'black_list' => set_value('black_list'),
		'no_rekening' => set_value('no_rekening'),
		'nama_bank' => set_value('nama_bank'),
		'nama_rekening' => set_value('nama_rekening'),
	);

        $this->load->view('header');
        $this->load->view('driver_form', $data);
        $this->load->view('footer');
    }
    
	public function create_action() 
    {

        $config['upload_path'] 			= './image/';
		$config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf|doc|docx|xls|xlsx';
        
		$config2['upload_path'] 		= './image/';
        $config2['allowed_types'] = 'jpg|png|jpeg|bmp|pdf|doc|docx|xls|xlsx';
        
		$config3['upload_path'] 		= './image/';
        $config3['allowed_types'] = 'jpg|png|jpeg|bmp|pdf|doc|docx|xls|xlsx';
        
		$config4['upload_path'] 		= './image/';
        $config4['allowed_types'] = 'jpg|png|jpeg|bmp|pdf|doc|docx|xls|xlsx';
        
		$type_profil = $_FILES["foto_profil"]["type"];
		$type_sim = $_FILES["foto_sim"]["type"];
		$type_stnk = $_FILES["foto_stnk"]["type"];
		$type_kir = $_FILES["foto_kir"]["type"];
		

		
		if ($type_profil == 'image/jpeg' or $type_profil == 'image/png' or $type_profil == 'image/jpg') {
			$format_foto = "ok";
		} else {
			$format_foto = "salah";
		}
		if ($type_sim == 'image/jpeg' or $type_sim == 'image/png' or $type_sim == 'image/jpg') {
			$format_kk = "ok";
		} else {
			$format_kk = "salah";
		}
		if ($type_stnk == 'image/jpeg' or $type_stnk == 'image/png' or $type_stnk == 'image/jpg') {
			$format_kk = "ok";
		} else {
			$format_kk = "salah";
		}
		if ($type_kir == 'image/jpeg' or $type_kir == 'image/png' or $type_kir == 'image/jpg') {
			$format_kk = "ok";
		} else {
			$format_kk = "salah";
		}
	

		$file_foto_profil ='';
		$file_foto_sim ='';
		$file_foto_stnk ='';
		$file_foto_kir ='';
	

		$this->upload->initialize($config);
		if (!$this->upload->do_upload('foto_profil')) {
			$file_foto_profil = "gagal";
		} else {
			$file_foto_profil = $this->upload->file_name;
		}

		$this->upload->initialize($config2);
		if (!$this->upload->do_upload('foto_sim')) {
			$file_foto_sim = "gagal";
		} else {
			$file_foto_sim = $this->upload->file_name;
		}
		
		$this->upload->initialize($config3);
		if (!$this->upload->do_upload('foto_stnk')) {
			$file_foto_stnk = "gagal";
		} else {
			$file_foto_stnk = $this->upload->file_name;
		}
		
		$this->upload->initialize($config4);
		if (!$this->upload->do_upload('foto_kir')) {
			$file_foto_kir = "gagal";
		} else {
			$file_foto_kir = $this->upload->file_name;
		}
        
       
            $data = array(
				'username' => $this->input->post('username',TRUE),
				'password' => $this->input->post('password',TRUE),
				'nama' => $this->input->post('nama',TRUE),
				'foto_profil' => $file_foto_profil,
				'nomor_wa' => $this->input->post('nomor_wa',TRUE),
				'plat_kendaraan' => $this->input->post('plat_kendaraan',TRUE),
				'jenis_mobil' => $this->input->post('jenis_mobil',TRUE),
				'tahun_kendaraan' => $this->input->post('tahun_kendaraan',TRUE),
				'masa_aktif_sim' => $this->input->post('masa_aktif_sim',TRUE),
				'foto_sim' => $file_foto_sim,
				'masa_aktif_stnk' => $this->input->post('masa_aktif_stnk',TRUE),
				'foto_stnk' => $file_foto_stnk,
				'masa_aktif_kir' => $this->input->post('masa_aktif_kir',TRUE),
				'foto_kir' => $file_foto_kir,
				'token' => $this->input->post('token',TRUE),
				'status' => $this->input->post('status',TRUE),
				'level' => "driver",
				'status_online' => $this->input->post('status_online',TRUE),
				'saldo' => $this->input->post('saldo',TRUE),
				'confirm' => $this->input->post('confirm',TRUE),
				'alamat'=>$this->input->post('alamat'),
				'kota'=>$this->input->post('kota'),
				'black_list'=>$this->input->post('black_list'),
				'no_rekening'=>$this->input->post('no_rekening'),
				'nama_bank'=>$this->input->post('nama_bank'),
				'nama_rekening'=>$this->input->post('nama_rekening'),
	    );

            $this->Driver_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('driver'));
        
    }
    
    public function update($id) 
    {
        $row = $this->Driver_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('driver/update_action'),
		'id' => set_value('id', $row->id),
		'username' => set_value('username', $row->username),
		'password' => set_value('password', $row->password),
		'nama' => set_value('nama', $row->nama),
		'foto_profil' => set_value('foto_profil', $row->foto_profil),
		'nomor_wa' => set_value('nomor_wa', $row->nomor_wa),
		'plat_kendaraan' => set_value('plat_kendaraan', $row->plat_kendaraan),
		'jenis_mobil' => set_value('jenis_mobil', $row->jenis_mobil),
		'tahun_kendaraan' => set_value('tahun_kendaraan', $row->tahun_kendaraan),
		'masa_aktif_sim' => set_value('masa_aktif_sim', $row->masa_aktif_sim),
		'foto_sim' => set_value('foto_sim', $row->foto_sim),
		'masa_aktif_stnk' => set_value('masa_aktif_stnk', $row->masa_aktif_stnk),
		'foto_stnk' => set_value('foto_stnk', $row->foto_stnk),
		'masa_aktif_kir' => set_value('masa_aktif_kir', $row->masa_aktif_kir),
		'foto_kir' => set_value('foto_kir', $row->foto_kir),
		'token' => set_value('token', $row->token),
		'status' => set_value('status', $row->status),
		'level' => set_value('level', $row->level),
		'status_online' => set_value('status_online', $row->status_online),
		'saldo' => set_value('saldo', $row->saldo),
		'confirm' => set_value('confirm', $row->confirm),
		'alamat' => set_value('alamat', $row->alamat),
		'kota' => set_value('kota', $row->kota),
		'black_list' => set_value('black_list',$row->black_list),
		'no_rekening' => set_value('no_rekening',$row->no_rekening),
		'nama_bank' => set_value('nama_bank',$row->nama_bank),
		'nama_rekening' => set_value('nama_rekening',$row->nama_rekening),
	    );
            $this->load->view('header');
            $this->load->view('driver_form', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('driver'));
        }
    }
    
	public function update_action() 
    {
		$config['upload_path'] 			= './image/';
		$config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf|doc|docx|xls|xlsx';
        
		$config2['upload_path'] 		= './image/';
        $config2['allowed_types'] = 'jpg|png|jpeg|bmp|pdf|doc|docx|xls|xlsx';
        
		$config3['upload_path'] 		= './image/';
        $config3['allowed_types'] = 'jpg|png|jpeg|bmp|pdf|doc|docx|xls|xlsx';
        
		$config4['upload_path'] 		= './image/';
        $config4['allowed_types'] = 'jpg|png|jpeg|bmp|pdf|doc|docx|xls|xlsx';
        
		$type_profil = $_FILES["foto_profil"]["type"];
		$type_sim = $_FILES["foto_sim"]["type"];
		$type_stnk = $_FILES["foto_stnk"]["type"];
		$type_kir = $_FILES["foto_kir"]["type"];

		
		if ($type_profil == 'image/jpeg' or $type_profil == 'image/png' or $type_profil == 'image/jpg') {
			$format_foto = "ok";
		} else {
			$format_foto = "salah";
		}
		if ($type_sim == 'image/jpeg' or $type_sim == 'image/png' or $type_sim == 'image/jpg') {
			$format_kk = "ok";
		} else {
			$format_kk = "salah";
		}
		if ($type_stnk == 'image/jpeg' or $type_stnk == 'image/png' or $type_stnk == 'image/jpg') {
			$format_kk = "ok";
		} else {
			$format_kk = "salah";
		}
		if ($type_kir == 'image/jpeg' or $type_kir == 'image/png' or $type_kir == 'image/jpg') {
			$format_kk = "ok";
		} else {
			$format_kk = "salah";
		}
	

		$file_foto_profil ='';
		$file_foto_sim ='';
		$file_foto_stnk ='';
		$file_foto_kir ='';
	

        if($_FILES['foto_profil']['name']=="" && $_FILES['foto_sim']['name']==""  && $_FILES['foto_stnk']['name']==""  && $_FILES['foto_kir']['name']=="")
        {
            $data = array(
                'username' => $this->input->post('username',TRUE),
				'password' => $this->input->post('password',TRUE),
				'nama' => $this->input->post('nama',TRUE),
				'nomor_wa' => $this->input->post('nomor_wa',TRUE),
				'plat_kendaraan' => $this->input->post('plat_kendaraan',TRUE),
				'jenis_mobil' => $this->input->post('jenis_mobil',TRUE),
				'tahun_kendaraan' => $this->input->post('tahun_kendaraan',TRUE),
				'masa_aktif_sim' => $this->input->post('masa_aktif_sim',TRUE),
				'masa_aktif_stnk' => $this->input->post('masa_aktif_stnk',TRUE),
				'masa_aktif_kir' => $this->input->post('masa_aktif_kir',TRUE),
				'token' => $this->input->post('token',TRUE),
				'status' => $this->input->post('status',TRUE),
				'level' => $this->input->post('level',TRUE),
				'status_online' => $this->input->post('status_online',TRUE),
				'saldo' => $this->input->post('saldo',TRUE),
				'confirm' => $this->input->post('confirm',TRUE),
				'alamat'=>$this->input->post('alamat'),
				'kota'=>$this->input->post('kota'),
				'black_list'=>$this->input->post('black_list'),
				'no_rekening'=>$this->input->post('no_rekening'),
				'nama_bank'=>$this->input->post('nama_bank'),
				'nama_rekening'=>$this->input->post('nama_rekening'),
                );
        
				$this->Driver_model->update($this->input->post('id', TRUE), $data);
				$this->session->set_flashdata('message', 'Update Record Success');
				redirect(site_url('driver'));

        } else if($_FILES['foto_profil']['name']=="" && $_FILES['foto_stnk']['name']=="" && $_FILES['foto_kir']['name']==""){
            $this->upload->initialize($config2);
            if (!$this->upload->do_upload('foto_sim')) {
                $file_foto_sim = $this->upload->file_name;
            } else {
                $file_foto_sim = $this->upload->file_name;
            }
            $data = array(
				'username' => $this->input->post('username',TRUE),
				'password' => $this->input->post('password',TRUE),
				'nama' => $this->input->post('nama',TRUE),
				'nomor_wa' => $this->input->post('nomor_wa',TRUE),
				'plat_kendaraan' => $this->input->post('plat_kendaraan',TRUE),
				'jenis_mobil' => $this->input->post('jenis_mobil',TRUE),
				'tahun_kendaraan' => $this->input->post('tahun_kendaraan',TRUE),
				'masa_aktif_sim' => $this->input->post('masa_aktif_sim',TRUE),
				'foto_sim' => $file_foto_sim,
				'masa_aktif_stnk' => $this->input->post('masa_aktif_stnk',TRUE),
				'masa_aktif_kir' => $this->input->post('masa_aktif_kir',TRUE),
				'token' => $this->input->post('token',TRUE),
				'status' => $this->input->post('status',TRUE),
				'level' => "driver",
				'status_online' => $this->input->post('status_online',TRUE),
				'saldo' => $this->input->post('saldo',TRUE),
				'confirm' => $this->input->post('confirm',TRUE),
				'alamat'=>$this->input->post('alamat'),
				'kota'=>$this->input->post('kota'),
				'black_list'=>$this->input->post('black_list'),
				'no_rekening'=>$this->input->post('no_rekening'),
				'nama_bank'=>$this->input->post('nama_bank'),
				'nama_rekening'=>$this->input->post('nama_rekening'),
                );
        
				$this->Driver_model->update($this->input->post('id', TRUE), $data);
				$this->session->set_flashdata('message', 'Update Record Success');
				redirect(site_url('driver'));

        } else if ($_FILES['foto_sim']['name']=="" && $_FILES['foto_stnk']['name']=="" && $_FILES['foto_kir']['name']==""){
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('foto_profil')) {
                $file_foto_profil = "gagal";
            } else {
                $file_foto_profil = $this->upload->file_name;
            }
            $data = array(
                'username' => $this->input->post('username',TRUE),
				'password' => $this->input->post('password',TRUE),
				'nama' => $this->input->post('nama',TRUE),
				'foto_profil' => $file_foto_profil,
				'nomor_wa' => $this->input->post('nomor_wa',TRUE),
				'plat_kendaraan' => $this->input->post('plat_kendaraan',TRUE),
				'jenis_mobil' => $this->input->post('jenis_mobil',TRUE),
				'tahun_kendaraan' => $this->input->post('tahun_kendaraan',TRUE),
				'masa_aktif_sim' => $this->input->post('masa_aktif_sim',TRUE),
				// 'foto_sim' => $file_foto_sim,
				'masa_aktif_stnk' => $this->input->post('masa_aktif_stnk',TRUE),
				// 'foto_stnk' => $file_foto_stnk,
				'masa_aktif_kir' => $this->input->post('masa_aktif_kir',TRUE),
				// 'foto_kir' => $file_foto_kir,
				'token' => $this->input->post('token',TRUE),
				'status' => $this->input->post('status',TRUE),
				'level' => "driver",
				'status_online' => $this->input->post('status_online',TRUE),
				'saldo' => $this->input->post('saldo',TRUE),
				'confirm' => $this->input->post('confirm',TRUE),
				'alamat'=>$this->input->post('alamat'),
				'kota'=>$this->input->post('kota'),
				'black_list'=>$this->input->post('black_list'),
				'no_rekening'=>$this->input->post('no_rekening'),
				'nama_bank'=>$this->input->post('nama_bank'),
				'nama_rekening'=>$this->input->post('nama_rekening'),
                );
        
				$this->Driver_model->update($this->input->post('id', TRUE), $data);
				$this->session->set_flashdata('message', 'Update Record Success');
				redirect(site_url('driver'));

		} else if ($_FILES['foto_stnk']['name']=="" && $_FILES['foto_sim']['name']=="" && $_FILES['foto_profil']['name']==""){
					$this->upload->initialize($config4);
					if (!$this->upload->do_upload('foto_kir')) {
						$file_foto_kir = "gagal";
					} else {
						$file_foto_kir = $this->upload->file_name;
					}
					$data = array(
						'username' => $this->input->post('username',TRUE),
						'password' => $this->input->post('password',TRUE),
						'nama' => $this->input->post('nama',TRUE),
						// 'foto_profil' => $file_foto_profil,
						'nomor_wa' => $this->input->post('nomor_wa',TRUE),
						'plat_kendaraan' => $this->input->post('plat_kendaraan',TRUE),
						'jenis_mobil' => $this->input->post('jenis_mobil',TRUE),
						'tahun_kendaraan' => $this->input->post('tahun_kendaraan',TRUE),
						'masa_aktif_sim' => $this->input->post('masa_aktif_sim',TRUE),
						// 'foto_sim' => $file_foto_sim,
						'masa_aktif_stnk' => $this->input->post('masa_aktif_stnk',TRUE),
						// 'foto_stnk' => $file_foto_stnk,
						'masa_aktif_kir' => $this->input->post('masa_aktif_kir',TRUE),
						'foto_kir' => $file_foto_kir,
						'token' => $this->input->post('token',TRUE),
						'status' => $this->input->post('status',TRUE),
						'level' => "driver",
						'status_online' => $this->input->post('status_online',TRUE),
						'saldo' => $this->input->post('saldo',TRUE),
						'confirm' => $this->input->post('confirm',TRUE),
						'alamat'=>$this->input->post('alamat'),
						'kota'=>$this->input->post('kota'),
						'black_list'=>$this->input->post('black_list'),
						'no_rekening'=>$this->input->post('no_rekening'),
						'nama_bank'=>$this->input->post('nama_bank'),
						'nama_rekening'=>$this->input->post('nama_rekening'),
						);
				
						$this->Driver_model->update($this->input->post('id', TRUE), $data);
						$this->session->set_flashdata('message', 'Update Record Success');
						redirect(site_url('driver'));

			} else if ($_FILES['foto_kir']['name']=="" && $_FILES['foto_profil']['name']=="" && $_FILES['foto_sim']['name']==""){
						$this->upload->initialize($config3);
						if (!$this->upload->do_upload('foto_stnk')) {
							$file_foto_stnk = "gagal";
						} else {
							$file_foto_stnk = $this->upload->file_name;
						}
						$data = array(
							'username' => $this->input->post('username',TRUE),
							'password' => $this->input->post('password',TRUE),
							'nama' => $this->input->post('nama',TRUE),
							// 'foto_profil' => $file_foto_profil,
							'nomor_wa' => $this->input->post('nomor_wa',TRUE),
							'plat_kendaraan' => $this->input->post('plat_kendaraan',TRUE),
							'jenis_mobil' => $this->input->post('jenis_mobil',TRUE),
							'tahun_kendaraan' => $this->input->post('tahun_kendaraan',TRUE),
							'masa_aktif_sim' => $this->input->post('masa_aktif_sim',TRUE),
							// 'foto_sim' => $file_foto_sim,
							'masa_aktif_stnk' => $this->input->post('masa_aktif_stnk',TRUE),
							'foto_stnk' => $file_foto_stnk,
							'masa_aktif_kir' => $this->input->post('masa_aktif_kir',TRUE),
							// 'foto_kir' => $file_foto_kir,
							'token' => $this->input->post('token',TRUE),
							'status' => $this->input->post('status',TRUE),
							'level' => "driver",
							'status_online' => $this->input->post('status_online',TRUE),
							'saldo' => $this->input->post('saldo',TRUE),
							'confirm' => $this->input->post('confirm',TRUE),
							'alamat'=>$this->input->post('alamat'),
							'kota'=>$this->input->post('kota'),
							'black_list'=>$this->input->post('black_list'),
							'no_rekening'=>$this->input->post('no_rekening'),
							'nama_bank'=>$this->input->post('nama_bank'),
							'nama_rekening'=>$this->input->post('nama_rekening'),
							);
					
							$this->Driver_model->update($this->input->post('id', TRUE), $data);
							$this->session->set_flashdata('message', 'Update Record Success');
							redirect(site_url('driver'));
        } else {
            $this->upload->initialize($config);
		if (!$this->upload->do_upload('foto_profil')) {
			$file_foto_profil = "gagal";
		} else {
			$file_foto_profil = $this->upload->file_name;
		}

		$this->upload->initialize($config2);
		if (!$this->upload->do_upload('foto_sim')) {
			$file_foto_sim = "gagal";
		} else {
			$file_foto_sim = $this->upload->file_name;
		}
		
		$this->upload->initialize($config3);
		if (!$this->upload->do_upload('foto_stnk')) {
			$file_foto_stnk = "gagal";
		} else {
			$file_foto_stnk = $this->upload->file_name;
		}
		
		$this->upload->initialize($config4);
		if (!$this->upload->do_upload('foto_kir')) {
			$file_foto_kir = "gagal";
		} else {
			$file_foto_kir = $this->upload->file_name;
		}

             $data = array(
				'username' => $this->input->post('username',TRUE),
				'password' => $this->input->post('password',TRUE),
				'nama' => $this->input->post('nama',TRUE),
				'foto_profil' => $file_foto_profil,
				'nomor_wa' => $this->input->post('nomor_wa',TRUE),
				'plat_kendaraan' => $this->input->post('plat_kendaraan',TRUE),
				'jenis_mobil' => $this->input->post('jenis_mobil',TRUE),
				'tahun_kendaraan' => $this->input->post('tahun_kendaraan',TRUE),
				'masa_aktif_sim' => $this->input->post('masa_aktif_sim',TRUE),
				'foto_sim' => $file_foto_sim,
				'masa_aktif_stnk' => $this->input->post('masa_aktif_stnk',TRUE),
				'foto_stnk' => $file_foto_stnk,
				'masa_aktif_kir' => $this->input->post('masa_aktif_kir',TRUE),
				'foto_kir' => $file_foto_kir,
				'token' => $this->input->post('token',TRUE),
				'status' => $this->input->post('status',TRUE),
				'level' => "driver",
				'status_online' => $this->input->post('status_online',TRUE),
				'saldo' => $this->input->post('saldo',TRUE),
				'confirm' => $this->input->post('confirm',TRUE),
				'alamat'=>$this->input->post('alamat'),
				'kota'=>$this->input->post('kota'),
				'black_list'=>$this->input->post('black_list'),
				'no_rekening'=>$this->input->post('no_rekening'),
				'nama_bank'=>$this->input->post('nama_bank'),
				'nama_rekening'=>$this->input->post('nama_rekening'),
	    );

            $this->Driver_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('driver'));
        } 
        
    }
    
    public function delete($id) 
    {
        $row = $this->Driver_model->get_by_id($id);

        if ($row) {
            $this->Driver_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('driver'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('driver'));
        }
    }

	public function driver_lengkapi_data()

	{
		$id= $_GET['id'];
		$row = $this->Driver_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('driver/update_action'),
		'id' => set_value('id', $row->id),
		'username' => set_value('username', $row->username),
		'password' => set_value('password', $row->password),
		'nama' => set_value('nama', $row->nama),
		'foto_profil' => set_value('foto_profil', $row->foto_profil),
		'nomor_wa' => set_value('nomor_wa', $row->nomor_wa),
		'plat_kendaraan' => set_value('plat_kendaraan', $row->plat_kendaraan),
		'jenis_mobil' => set_value('jenis_mobil', $row->jenis_mobil),
		'tahun_kendaraan' => set_value('tahun_kendaraan', $row->tahun_kendaraan),
		'masa_aktif_sim' => set_value('masa_aktif_sim', $row->masa_aktif_sim),
		'foto_sim' => set_value('foto_sim', $row->foto_sim),
		'masa_aktif_stnk' => set_value('masa_aktif_stnk', $row->masa_aktif_stnk),
		'foto_stnk' => set_value('foto_stnk', $row->foto_stnk),
		'masa_aktif_kir' => set_value('masa_aktif_kir', $row->masa_aktif_kir),
		'foto_kir' => set_value('foto_kir', $row->foto_kir),
		'token' => set_value('token', $row->token),
		'status' => set_value('status', $row->status),
		'level' => set_value('level', $row->level),
		'status_online' => set_value('status_online', $row->status_online),
		'saldo' => set_value('saldo', $row->saldo),
		'confirm' => set_value('confirm', $row->confirm),
	    );
		$this->load->view("driver_lengkapi_data",$data);
	}
}

    public function _rules() 
    {
	$this->form_validation->set_rules('username', 'username', 'trim');
	$this->form_validation->set_rules('password', 'password', 'trim');
	$this->form_validation->set_rules('nama', 'nama', 'trim');
	$this->form_validation->set_rules('foto_profil', 'foto profil', 'trim');
	$this->form_validation->set_rules('nomor_wa', 'nomor wa', 'trim');
	$this->form_validation->set_rules('plat_kendaraan', 'plat kendaraan', 'trim');
	$this->form_validation->set_rules('jenis_mobil', 'jenis mobil', 'trim');
	$this->form_validation->set_rules('tahun_kendaraan', 'tahun kendaraan', 'trim');
	$this->form_validation->set_rules('masa_aktif_sim', 'masa aktif sim', 'trim');
	$this->form_validation->set_rules('foto_sim', 'foto sim', 'trim');
	$this->form_validation->set_rules('masa_aktif_stnk', 'masa aktif stnk', 'trim');
	$this->form_validation->set_rules('foto_stnk', 'foto stnk', 'trim');
	$this->form_validation->set_rules('masa_aktif_kir', 'masa aktif kir', 'trim');
	$this->form_validation->set_rules('foto_kir', 'foto kir', 'trim');
	$this->form_validation->set_rules('token', 'token', 'trim');
	$this->form_validation->set_rules('status', 'status', 'trim');
	$this->form_validation->set_rules('level', 'level', 'trim');
	$this->form_validation->set_rules('status_online', 'status online', 'trim');
	$this->form_validation->set_rules('saldo', 'saldo', 'trim|numeric');
	$this->form_validation->set_rules('confirm', 'confirm', 'trim');
	$this->form_validation->set_rules('black_list', 'black_list', 'trim');
	$this->form_validation->set_rules('no_rekening', 'no_rekening', 'trim');
	$this->form_validation->set_rules('nama_bank', 'nama_bank', 'trim');
	$this->form_validation->set_rules('nama_rekening', 'nama_rekening', 'trim');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Driver.php */
/* Location: ./application/controllers/Driver.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-03-16 07:04:58 */
/* http://harviacode.com */