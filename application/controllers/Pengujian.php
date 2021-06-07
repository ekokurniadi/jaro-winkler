<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pengujian extends MY_Controller {

    // protected $access = array('Admin', 'Pimpinan','Finance');
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('Pengujian_model');
        $this->load->library('form_validation');
    }

    public function pengujian_kalimat(){
        $kata = $this->input->post('kalimat');
        $id   = $this->input->post('id');

        $pecah_kalimat = explode(" ", $kata);
        $result = array();
        foreach($pecah_kalimat as $key){
            
            $cleaning = cleaningWords($key);
            $casefolding = casefolding($cleaning);
            $tokenizing = tokenizing($casefolding);
            $cekData = $this->db->query("SELECT * FROM kata_dasar where kata ='$tokenizing'");
            $stemming = stem($tokenizing);
            $_cek = $cekData->num_rows() > 0 ? $array[] = array() : $array[] = $cekData->row()->kata;
            $x['kataAsal'] = $key;
            $x['cleaning'] = $cleaning;
            $x['casefolding']=$casefolding;
            $x['tokenizing']=$tokenizing;
            $x['stemming']=$stemming;
            $x['jaroW']=array();
            $data2 = $this->db->query("SELECT DISTINCT(kata) AS kata,arti from kata_dasar where kata like'%$key%' order by kata DESC"); 
               foreach($data2->result() as $row){
                   $_kata ="";
                   if($row->kata=="" || $row->kata== null){
                       $_kata = $key;
                   }else{
                       $_kata = $row->kata;
                   }
                   $resp=array(
                       "kata" => $key,
                       "kamus"=> $_kata,
                       "arti"=> $row->arti,
                       "nilai_jaro_winkler"=>JaroWinkler($key,$_kata),
                   );
                   
                       $insertJaroWinkler=array(
                        "id_pengujian" => $id,
                        "rekomendasi"=> $_kata,
                        "nilai_jaro_winkler"=>JaroWinkler($key,$_kata),
                        );
                        $this->db->insert("jaro_winkler",$insertJaroWinkler);
                   
                   array_push($x['jaroW'],$resp);

               }
                $marks = array();
                
                foreach ($x['jaroW'] as $keys => $rs)
                {
                    $marks[$keys] = $rs['nilai_jaro_winkler'];
                    
                }
                array_values(array_unique(array_multisort($marks, SORT_DESC, $x['jaroW'])));
                array_push($result,$x);
                $insertKataAsal=array(
                    "id_pengujian"=>$id,
                    "teks"=>$x['kataAsal'],
                );
                $this->db->insert("kata_asal",$insertKataAsal);
                $insertCleaning=array(
                    "id_pengujian"=>$id,
                    "cleaning"=>$x['cleaning'],
                );
                $this->db->insert("cleaning",$insertCleaning);
                $insertCaseFolding=array(
                    "id_pengujian"=>$id,
                    "casefolding"=>$x['casefolding'],
                );
                $this->db->insert("casefolding",$insertCaseFolding);
                $insertTokenizing=array(
                    "id_pengujian"=>$id,
                    "tokenizing"=>$x['tokenizing'],
                );
                $this->db->insert("tokenizing",$insertTokenizing);
                // $insertStemming=array(
                //     "id_pengujian"=>$id,
                //     "stemming"=>$x['stemming'],
                // );
                // $this->db->insert("stemming",$insertStemming);
                print_r($x['stemming']);
               
        }
        echo json_encode(array(
            "data"=>$result,
        ));
    }

    function acak($panjang)
    {
      $karakter= 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789';
      $string = '';
      for ($i = 0; $i < $panjang; $i++) {
        $pos = rand(0, strlen($karakter)-1);
        $string .= $karakter{$pos};
      }
      return $string;
    }

    public function index()
    {
        $data['generatedID'] = $this->acak(10);
        $this->load->view('header');
        $this->load->view('pengujian_list', $data);
        $this->load->view('footer');
    }

    public function read($id) 
    {
        $row = $this->Pengujian_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'teks' => $row->teks,
		'cleaning' => $row->cleaning,
		'casefolding' => $row->casefolding,
		'tokenizing' => $row->tokenizing,
		'stemming' => $row->stemming,
		'rekomendasi' => $row->rekomendasi,
	    );
            $this->load->view('header');
            $this->load->view('pengujian_read', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pengujian'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('pengujian/create_action'),
	    'id' => set_value('id'),
	    'teks' => set_value('teks'),
	    'cleaning' => set_value('cleaning'),
	    'casefolding' => set_value('casefolding'),
	    'tokenizing' => set_value('tokenizing'),
	    'stemming' => set_value('stemming'),
	    'rekomendasi' => set_value('rekomendasi'),
	);

        $this->load->view('header');
        $this->load->view('pengujian_form', $data);
        $this->load->view('footer');
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'teks' => $this->input->post('teks',TRUE),
		'cleaning' => $this->input->post('cleaning',TRUE),
		'casefolding' => $this->input->post('casefolding',TRUE),
		'tokenizing' => $this->input->post('tokenizing',TRUE),
		'stemming' => $this->input->post('stemming',TRUE),
		'rekomendasi' => $this->input->post('rekomendasi',TRUE),
	    );

            $this->Pengujian_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('pengujian'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Pengujian_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('pengujian/update_action'),
		'id' => set_value('id', $row->id),
		'teks' => set_value('teks', $row->teks),
		'cleaning' => set_value('cleaning', $row->cleaning),
		'casefolding' => set_value('casefolding', $row->casefolding),
		'tokenizing' => set_value('tokenizing', $row->tokenizing),
		'stemming' => set_value('stemming', $row->stemming),
		'rekomendasi' => set_value('rekomendasi', $row->rekomendasi),
	    );
            $this->load->view('header');
            $this->load->view('pengujian_form', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pengujian'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'teks' => $this->input->post('teks',TRUE),
		'cleaning' => $this->input->post('cleaning',TRUE),
		'casefolding' => $this->input->post('casefolding',TRUE),
		'tokenizing' => $this->input->post('tokenizing',TRUE),
		'stemming' => $this->input->post('stemming',TRUE),
		'rekomendasi' => $this->input->post('rekomendasi',TRUE),
	    );

            $this->Pengujian_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('pengujian'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Pengujian_model->get_by_id($id);

        if ($row) {
            $this->Pengujian_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('pengujian'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pengujian'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('teks', 'teks', 'trim|required');
	$this->form_validation->set_rules('cleaning', 'cleaning', 'trim|required');
	$this->form_validation->set_rules('casefolding', 'casefolding', 'trim|required');
	$this->form_validation->set_rules('tokenizing', 'tokenizing', 'trim|required');
	$this->form_validation->set_rules('stemming', 'stemming', 'trim|required');
	$this->form_validation->set_rules('rekomendasi', 'rekomendasi', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Pengujian.php */
/* Location: ./application/controllers/Pengujian.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-06-06 03:12:43 */
/* http://harviacode.com */