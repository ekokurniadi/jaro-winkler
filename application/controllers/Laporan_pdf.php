  <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This controller can be accessed 
 * for all logged in users
 */
class Laporan_pdf extends MY_Controller {

   

   function __construct() {
        parent::__construct();
        // $this->load->model('Sopir_model');
        // $this->load->model('User_model');
        // $this->load->model('Kendaraan_model');
        // $this->load->model('Petugas_model');
     
        
        require_once APPPATH.'third_party/dompdf/dompdf_config.inc.php';
    }
    
   
      public function cetak_user()
      {
          $dompdf= new Dompdf();
        
          $data['user_data']=  $this->User_model->get_all();
          $data['start']=0;
          $html=$this->load->view('user_doc',$data,true);
         
          $dompdf->load_html($html);
          $dompdf->set_paper('A4','potrait');
          $dompdf->render();
         
          $pdf = $dompdf->output();
   
          $dompdf->stream('Data User.pdf',array("Attachment"=>FALSE));
       }

      // public function cetak_anggota()
      // {
      //     $dompdf= new Dompdf();
        
      //     $data['petugas_data']=  $this->Petugas_model->get_all();
      //     $data['start']=0;
      //     $html=$this->load->view('petugas_doc',$data,true);
         
      //     $dompdf->load_html($html);
      //     $dompdf->set_paper('A4','potrait');
      //     $dompdf->render();
         
      //     $pdf = $dompdf->output();
   
      //     $dompdf->stream('Data Petugas.pdf',array("Attachment"=>FALSE));
      //  }

      // public function cetak_sopir()
      // {
      //     $dompdf= new Dompdf();
        
      //     $data['sopir_data']=  $this->Sopir_model->get_all();
      //     $data['start']=0;
      //     $html=$this->load->view('sopir_doc',$data,true);
         
      //     $dompdf->load_html($html);
      //     $dompdf->set_paper('A4','potrait');
      //     $dompdf->render();
         
      //     $pdf = $dompdf->output();
   
      //     $dompdf->stream('Data Sopir.pdf',array("Attachment"=>FALSE));
      //  }

      // public function cetak_kendaraan()
      // {
      //     $dompdf= new Dompdf();
        
      //     $data['kendaraan_data']=  $this->Kendaraan_model->get_all();
      //     $data['start']=0;
      //     $html=$this->load->view('kendaraan_doc',$data,true);
         
      //     $dompdf->load_html($html);
      //     $dompdf->set_paper('A4','potrait');
      //     $dompdf->render();
         
      //     $pdf = $dompdf->output();
   
      //     $dompdf->stream('Data Kendaraan.pdf',array("Attachment"=>FALSE));
      //  }

      // public function Laporan_penjualan_view()
      // {
      //   $query="select brand from sku group by brand order by brand";
      //   $rows=$this->db->query($query)->result();
      //   $data=array(
      //       'brand_data'=>$rows,
      //       'brand'=>set_value('brand'),
      //       'bulan'=>set_value('bulan')
      //   ); 
      //   $this->load->view('header');
      //    $this->load->view('laporan_penjualan_view',$data);
      //    $this->load->view('footer');
         
      //  }

    //   public function Laporan_penjualan_action()
    //   {
        
    //     $brand=$this->input->post('brand');
    //     $bulan=$this->input->post('bulan');
    //     $tahun=$this->input->post('tahun');
    //     $dompdf= new Dompdf();
    //     if($brand=='ALL'){
    //         $data['jual_data']=  $this->Temp_transaksi_model->dapatkan4($bulan,$tahun);
        
    //         $html=$this->load->view('laporan_jual_view',$data,true);
            
    //         $dompdf->load_html($html);
    //         $dompdf->set_paper('A4','potrait');
    //         $dompdf->render();
            
    //         $pdf = $dompdf->output();
    
    //         $dompdf->stream('Data Penjualan Bulanan Per Brand.pdf',array("Attachment"=>FALSE));
    //     }else{
    //     $data['jual_data']=  $this->Temp_transaksi_model->dapatkan($brand,$bulan,$tahun);
        
    //     $html=$this->load->view('laporan_jual_view',$data,true);
        
    //     $dompdf->load_html($html);
    //     $dompdf->set_paper('A4','potrait');
    //     $dompdf->render();
        
    //     $pdf = $dompdf->output();

    //     $dompdf->stream('Data Penjualan Bulanan Per Brand.pdf',array("Attachment"=>FALSE));
    //    }
    // }

      // public function Laporan_penerimaan_view()
      // {
      //   $query="select brand from sku group by brand order by brand";
      //   $rows=$this->db->query($query)->result();
      //   $data=array(
      //       'brand_data'=>$rows,
      //       'brand'=>set_value('brand'),
      //       'bulan'=>set_value('bulan')
      //   ); 
      //   $this->load->view('header');
      //    $this->load->view('laporan_penerimaan_view',$data);
      //    $this->load->view('footer');
         
      //  }

    //   public function Laporan_penerimaan_action()
    //   {
        
    //     $brand=$this->input->post('brand');
    //     $bulan=$this->input->post('bulan');
    //     $tahun=$this->input->post('tahun');
        
    //     $dompdf= new Dompdf();
    //     if($brand =='ALL')
    //     {
    //     $data['jual_data']=  $this->Penerimaan_model->dapatkan3($bulan,$tahun);
    //     $html=$this->load->view('laporan_terima_view',$data,true);
        
    //     $dompdf->load_html($html);
    //     $dompdf->set_paper('A4','potrait');
    //     $dompdf->render();
        
    //     $pdf = $dompdf->output();

    //     $dompdf->stream('Data Penjualan Penerimaan Per Brand.pdf',array("Attachment"=>FALSE));
    //     }else{
    //     $data['jual_data']=  $this->Penerimaan_model->dapatkan2($brand,$bulan,$tahun);
        
    //     $html=$this->load->view('laporan_terima_view',$data,true);
        
    //     $dompdf->load_html($html);
    //     $dompdf->set_paper('A4','potrait');
    //     $dompdf->render();
        
    //     $pdf = $dompdf->output();

    //     $dompdf->stream('Data Penjualan Penerimaan Per Brand.pdf',array("Attachment"=>FALSE));
    //    }
    // }
    public function index2()
    {
       
      $dompdf= new Dompdf();
      if(isset($_GET['cetak']))
      {
        $data['set']                   	= 'cetak';            
        $data['tanggal2']              	= $this->input->get('tanggal2');      
        $data['tanggal3']              	= $this->input->get('tanggal3');     
      $html=$this->load->view('laporan_penerimaan',$data,true);
      
      $dompdf->load_html($html);
      $dompdf->set_paper('A4','potrait');
      $dompdf->render();
      
      $pdf = $dompdf->output();

      $dompdf->stream('Laporan Penerimaan Barang.pdf',array("Attachment"=>FALSE));
      }else{
        $data['set'] = "view";		
       $this->template($data);
        
     }
  }
    public function index3()
    {
       
      $dompdf= new Dompdf();
      if(isset($_GET['cetak']))
      {
        $data['set']                = 'cetak';            
        $data['sup']              	= $this->input->get('sup');          
      $html=$this->load->view('laporan_penerimaan_suplier',$data,true);
      
      $dompdf->load_html($html);
      $dompdf->set_paper('A4','potrait');
      $dompdf->render();
      
      $pdf = $dompdf->output();

      $dompdf->stream('Laporan Penerimaan Barang PerSupplier.pdf',array("Attachment"=>FALSE));
      }else{
        $data['set'] = "view";		
       $this->template2($data);
        
     }
  }
    public function index4()
    {
       
      $dompdf= new Dompdf();
      if(isset($_GET['cetak']))
      {
        $data['set']                = 'cetak';            
        $data['fak']              	= $this->input->get('fak');          
      $html=$this->load->view('laporan_pengeluaran_barang',$data,true);
      
      $dompdf->load_html($html);
      $dompdf->set_paper('A4','potrait');
      $dompdf->render();
      
      $pdf = $dompdf->output();

      $dompdf->stream('Laporan Pengeluaran Barang .pdf',array("Attachment"=>FALSE));
      }else{
        $data['set'] = "view";		
       $this->template3($data);
        
     }
  }
    public function index5()
    {
       
      $dompdf= new Dompdf();
      if(isset($_GET['cetak']))
      {
        $data['set']                    = 'cetak'; 
        $data['tanggal2']              	= $this->input->get('tanggal2');      
        $data['tanggal3']              	= $this->input->get('tanggal3');         
      $html=$this->load->view('laporan_pengeluaran_pertanggal',$data,true);
      
      $dompdf->load_html($html);
      $dompdf->set_paper('A4','potrait');
      $dompdf->render();
      
      $pdf = $dompdf->output();

      $dompdf->stream('Laporan Pengeluaran Barang .pdf',array("Attachment"=>FALSE));
      }else{
        $data['set'] = "view";		
       $this->template4($data);
        
     }
  }

 protected function template($data)
	{
		
			$this->load->view('header');	
			$this->load->view('laporan_penerimaan',$data);		
			$this->load->view('footer');
	}
 protected function template2($data)
	{
		
			$this->load->view('header');	
			$this->load->view('laporan_penerimaan_suplier',$data);		
			$this->load->view('footer');
	}
 protected function template3($data)
	{
		
			$this->load->view('header');	
			$this->load->view('laporan_pengeluaran_barang',$data);		
			$this->load->view('footer');
	}
 protected function template4($data)
	{
		
			$this->load->view('header');	
			$this->load->view('laporan_pengeluaran_pertanggal',$data);		
			$this->load->view('footer');
	}
    
}


