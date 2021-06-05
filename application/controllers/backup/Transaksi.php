<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transaksi extends MY_Controller {

    // protected $access = array('Admin', 'Pimpinan','Finance');
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('Transaksi_model');
        $this->load->library('form_validation');
    }


    function kode()
    {
             $this->db->select('RIGHT(transaksi.kode_transaksi,2) as kode_transaksi', FALSE);
             $this->db->order_by('kode_transaksi','DESC');    
             $this->db->limit(1);    
             $query = $this->db->get('transaksi');  //cek dulu apakah ada sudah ada kode di tabel.    
             if($query->num_rows() <> 0){      
                  //cek kode jika telah tersedia    
                  $data = $query->row();      
                  $kode = intval($data->kode_transaksi) + 1; 
             }
             else{      
                  $kode = 1;  //cek jika kode belum terdapat pada table
             }  
                date_default_timezone_set("Asia/Jakarta");
                 $tgl=date("dYm");
                 $sessi=strtoupper($_SESSION['nama']); 
                 $angka_acak=rand(100,1000);
                 $batas = str_pad($kode, 3, "0", STR_PAD_LEFT);    
                 $kodetampil = "TRX-".$batas;  //format kode
                 return $kodetampil;  
   }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'transaksi/index.dart?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'transaksi/index.dart?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'transaksi/index.dart';
            $config['first_url'] = base_url() . 'transaksi/index.dart';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Transaksi_model->total_rows($q);
        $transaksi = $this->Transaksi_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'transaksi_data' => $transaksi,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('header');
        $this->load->view('transaksi_list', $data);
        $this->load->view('footer');
    }

    public function read($id) 
    {
        $row = $this->Transaksi_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'kode_transaksi' => $row->kode_transaksi,
		'tanggal_transaksi' => $row->tanggal_transaksi,
	    );
            $this->load->view('header');
            $this->load->view('transaksi_read', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('transaksi'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('transaksi/create_action'),
	    'id' => set_value('id'),
	    'kode_transaksi' => $this->kode(),
	    'tanggal_transaksi' => set_value('tanggal_transaksi'),
	);

        $this->load->view('header');
        $this->load->view('transaksi_form', $data);
        $this->load->view('footer');
    }

    public function hapus_temp()
    {
        $id=$_GET['id'];
        $this->db->query("DELETE FROM detail_transaksi where id='$id'");
    }
    
    // fungsi ajax
    public function load_temp()
    {
        echo " <table class='table table-bordered table-striped table-hover'>
                       <thead>
                       <tr>
                       <th>No</th>
                       <th>Kode Barang</th>
                       <th>Nama Barang</th>
                       <th>Harga Jual</th>
                       <th>Qty Jual</th>
                       <th>Total</th>
                       <th>Action</th>
                       </tr>
                   </thead>";
                    $id=$_GET['kode_transaksi'];
                    $no=1;
                    $data = $this->db->query("SELECT * FROM detail_transaksi where kode_transaksi='$id'")->result();
                 
                  
                    foreach ($data as $d) {
                        $nama = $this->db->query("SELECT nama_barang from barang where kode_barang ='$d->kode_barang'")->row();
                        echo "<tbody><tr id='dataku$d->id'>
                                <td>$no</td>
                                <td>$d->kode_barang</td>
                                <td>$nama->nama_barang</td> <td>";
                                echo number_format($d->harga_jual,0,',','.');
                               echo "</td>
                                <td>$d->qty</td> <td>";
                                echo number_format($d->total,0,',','.');
                                echo "<td><button type ='button' class='btn btn-icon btn-sm btn-danger' onClick='hapus($d->id)'><i class='fa fa-close'></i> Batal</td>
                             </tr>
                           </tbody>  ";
                        $no++;
                        
                    }
                    echo "</table>";  
                   
    }


    function input_ajax()
    {
 
         $kode_transaksi       = $_GET['kode_transaksi'];
         $tanggal_transaksi    = $_GET['tanggal_transaksi'];
         $kode_barang          = $_GET['kode_barang'];
         $harga_jual           = $_GET['harga_jual'];
         $qty_jual             = $_GET['qty_jual'];
         $total                = $_GET['total'];
         $harga_modal          = $_GET['harga_modal'];
         $laba                 = $_GET['laba'];   
         $data=array(
            'kode_transaksi'=>$kode_transaksi,
            'kode_barang'=>$kode_barang,
            'tanggal_transaksi'=>$tanggal_transaksi,
            'harga_jual'=>$harga_jual,
            'qty'=>$qty_jual,
            'total'=>$total,
            'harga_modal'=>$harga_modal,
            'laba'=>$laba,
           
              
            );
        $this->db->insert('detail_transaksi',$data);

       
    }

    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'kode_transaksi' => $this->input->post('kode_transaksi',TRUE),
		'tanggal_transaksi' => $this->input->post('tanggal_transaksi',TRUE),
	    );

            $this->Transaksi_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('transaksi'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Transaksi_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('transaksi/update_action'),
		'id' => set_value('id', $row->id),
		'kode_transaksi' => set_value('kode_transaksi', $row->kode_transaksi),
		'tanggal_transaksi' => set_value('tanggal_transaksi', $row->tanggal_transaksi),
	    );
            $this->load->view('header');
            $this->load->view('transaksi_form', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('transaksi'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'kode_transaksi' => $this->input->post('kode_transaksi',TRUE),
		'tanggal_transaksi' => $this->input->post('tanggal_transaksi',TRUE),
	    );

            $this->Transaksi_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('transaksi'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Transaksi_model->get_by_id($id);
        $data = $this->db->query("SELECT * from transaksi where id='$id'")->row();
        if ($row) {
            $this->Transaksi_model->delete($id);
            $this->db->query("DELETE FROM detail_transaksi where kode_transaksi='$data->kode_transaksi'");
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('transaksi'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('transaksi'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('kode_transaksi', 'kode transaksi', 'trim|required');
	$this->form_validation->set_rules('tanggal_transaksi', 'tanggal transaksi', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Transaksi.php */
/* Location: ./application/controllers/Transaksi.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-02-16 15:40:55 */
/* http://harviacode.com */