<?php
class Test extends MY_Controller{

    function __construct() {
        parent::__construct();
        
    }
    public function index(){
        $this->load->view('test');
    }

    public function test_stemming(){
        $kata = $this->input->post('kalimat');
        $pecah_kalimat = explode(" ", $kata);
        $result = array();
        foreach($pecah_kalimat as $key){
            
            $cleaning = cleaningWords($key);
            $casefolding = casefolding($cleaning);
            $tokenizing = tokenizing($casefolding);
            $cekData = $this->db->query("SELECT * FROM kata_dasar where kata ='$tokenizing'");
            $_cek = $cekData->num_rows() > 0 ? $array[] = array() : $array[] = $cekData->row()->kata;
            
            $x['cleaning'] = $cleaning;
            $x['casefolding']=$casefolding;
            $x['tokenizing']=$tokenizing;
            $x['stemming']=array();
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
                  
                   array_push($x['stemming'],$resp);

               }
                $marks = array();
                $array = array_unique($x['stemming']);
                foreach ($x['stemming'] as $keys => $rs)
                {
                    $marks[$keys] = $rs['nilai_jaro_winkler'];
                    
                }
                array_values(array_unique(array_multisort($marks, SORT_DESC, $x['stemming'])));
                array_push($result,$x);

        }
        echo json_encode(array(
            "status"=>200,
            "result"=>$result,
        ));
    }
   
}
?>