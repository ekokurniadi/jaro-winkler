<?php 


defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

    function __construct() {
        parent::__construct(); 
        require_once APPPATH.'third_party/dompdf/dompdf_config.inc.php';
    }

    public function index()
    {
        $this->load->view('header');
        $this->load->view('laporan_view');
        $this->load->view('footer');
    }

    public function download(){

        $startDate=$_GET['start'];
        $endDate=$_GET['end'];
        $jenisReport=$_GET['jenis_report'];
        
        $data=array(
            "startDate"=>$startDate,
            "endDate"=>$endDate
        );

        if($jenisReport == 'excel'){     
            $this->load->view('laporan_penjualan',$data);
        }else{
            $dompdf= new Dompdf();
            $html=$this->load->view('laporan_penjualan_pdf',$data,true);
            $dompdf->load_html($html);
            $dompdf->set_paper('A4','potrait');
            $dompdf->render();
            $pdf = $dompdf->output();
            $dompdf->stream('Laporan Penjualan.pdf',array("Attachment"=>FALSE));
        }

    }

}

/* End of file Laporan.php */


?>