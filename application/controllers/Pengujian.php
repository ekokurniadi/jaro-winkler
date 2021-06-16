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
        set_time_limit(9000000);
        ini_set('memory_limit', -1);
        ini_set('max_execution_time', 0);
        ini_set('max_input_vars', 30000);
        ini_set('display_errors', 0);
    }


    public function uji(){
        $kata = $this->input->post('kalimat');
        $id   = $this->input->post('id');
        $pecah_kalimat = explode(" ", $kata);
        $result = array();
        $progress=0;
        $urutan =1;
        foreach($pecah_kalimat as $key){
            if(preg_match("/^@/", $key)){
                $kt ="";
            }elseif(preg_match("/^https/",$key)){
                $kt="";
            }elseif(preg_match("/^http/",$key)){
                $kt="";
            }elseif(preg_match("/^ftp/",$key)){
                $kt="";
            }elseif(preg_match("/^file/",$key)){
                $kt="";
            }elseif(preg_match("/^folder/",$key)){
                $kt="";
            }elseif(preg_match("/^#/",$key)){
                $kt="";
            }else{
                $kt=$key;
            }
            
            $cleaning = cleaningWords(trim($kt));
            $casefolding = casefolding($cleaning);
            $tokenizing = tokenizing($casefolding);
            $stemming = $this->stemmingFunc($tokenizing);
            $cek = $this->cekKamusData($stemming);
            $awalan = $this->ambil_Awalan($tokenizing);
            $akhiran = $this->ambil_Akhiran($tokenizing);
            $kataPembanding="";
            $jaroWinkler = array();
            $cekData = $this->db->query("SELECT * FROM kata_dasar where kata like'%$stemming%'");
            if($cekData->num_rows() > 0){
               foreach($cekData->result() as $rows){
                   $pembanding =  $cekData->num_rows() <= 0 ? $stemming : $rows->kata;
                   $respon = array(
                       "urutan"=>$urutan,
                       "kata_asal"=>$tokenizing,
                       "kata_stemming"=>$stemming,
                       "kamus"=>$rows->kata,
                       "jaro_winkler"=>JaroWinkler($tokenizing,$pembanding),
                       "awalan"=>$awalan,
                       "akhiran"=>$akhiran
                    );
                    array_push($jaroWinkler,$respon);
               }
            }else{
                $regex = substr($stemming,1);
            $cekDataRegex = $this->db->query("SELECT * FROM kata_dasar where kata REGEXP '$regex$'");
            if($cekDataRegex->num_rows() > 0){
                foreach($cekDataRegex->result() as $rows){
                    $pembanding =  $cekDataRegex->num_rows() <= 0 ? $stemming : $rows->kata;
                    $respon = array(
                        "id_pengujian"=>$id,
                        "urutan"=>$urutan,
                        "kata_asal"=>$tokenizing,
                        "kata_stemming"=>$stemming,
                        "kamus"=>$rows->kata,
                        "jaro_winkler"=>JaroWinkler($tokenizing,$pembanding),
                        "awalan"=>$awalan,
                        "akhiran"=>$akhiran
                     );
                     array_push($jaroWinkler,$respon);
                }
            }else{
                if($tokenizing != null || $tokenizing !=""){
                    $regex = substr($stemming,0,3);
                    $cekRegAwal = $this->db->query("SELECT * FROM kata_dasar where kata like '%$regex%'"); 
                    foreach($cekRegAwal->result() as $rows){
                        $pembanding =  $cekRegAwal->num_rows() <= 0 ? $stemming : $rows->kata;
                        $respon = array(
                            "id_pengujian"=>$id,
                            "urutan"=>$urutan,
                            "kata_asal"=>$tokenizing,
                            "kata_stemming"=>$stemming,
                            "kamus"=>$rows->kata,
                            "jaro_winkler"=>JaroWinkler($tokenizing,$pembanding),
                            "awalan"=>$awalan,
                            "akhiran"=>$akhiran
                         );
                         
                         array_push($jaroWinkler,$respon);
                    }
                }
            }
            
        }
            $jw="";
            if(!is_array($jaroWinkler)){
                $jw = $jaroWinkler;
            }else{
                $jw = array_unique($jaroWinkler, SORT_REGULAR);
            }
            $data=array(
                "urutan"=>$urutan,
                "kataAsal"=>trim($kt),
                "cleaning"=>$cleaning,
                "casefolding"=>$cleaning,
                "tokenizing"=>$tokenizing,
                "stemming"=>$stemming == null || $stemming=="" ? $tokenizing : $stemming,
                "cekKamus"=>$cek,
                "jarwo"=>$jw,
            );
            $urutan++;
            array_push($result,$data);
            // $this->load_temp($result);
        }
        echo json_encode($result);
    }


    public function uji_pengujian(){
        $kata = $this->input->post('kalimat');
        $id   = $this->input->post('id');
        $pecah_kalimat = explode(" ", $kata);
        $result = array();
        $progress=0;
        $urutan =1;
        foreach($pecah_kalimat as $key){
            if(preg_match("/^@/", $key)){
                $kt ="";
            }elseif(preg_match("/^https/",$key)){
                $kt="";
            }elseif(preg_match("/^http/",$key)){
                $kt="";
            }elseif(preg_match("/^ftp/",$key)){
                $kt="";
            }elseif(preg_match("/^file/",$key)){
                $kt="";
            }elseif(preg_match("/^folder/",$key)){
                $kt="";
            }elseif(preg_match("/^#/",$key)){
                $kt="";
            }else{
                $kt=$key;
            }
            
            $cleaning = cleaningWords(trim($kt));
            $casefolding = casefolding($cleaning);
            $tokenizing = tokenizing($casefolding);
            $stemming = $this->stemmingFunc($tokenizing);
            $cek = $this->cekKamusData($stemming);
            $awalan = $this->ambil_Awalan($tokenizing);
            $akhiran = $this->ambil_Akhiran($tokenizing);
            $kataPembanding="";
            $jaroWinkler = array();
            $cekData = $this->db->query("SELECT * FROM kata_dasar where kata like'%$stemming%'");
            if($cekData->num_rows() > 0){
               foreach($cekData->result() as $rows){
                   $pembanding =  $cekData->num_rows() <= 0 ? $stemming : $rows->kata;
                   $respon = array(
                       "id_pengujian"=>$id,
                       "urutan"=>$urutan,
                       "kata_asal"=>$tokenizing,
                       "kata_stemming"=>$stemming,
                       "kamus"=>$rows->kata,
                       "jaro_winkler"=>JaroWinkler($tokenizing,$pembanding),
                       "awalan"=>$awalan,
                       "akhiran"=>$akhiran
                    );
                    array_push($jaroWinkler,$respon);
               }
            }else{
                $regex = substr($stemming,1);
                $cekDataRegex = $this->db->query("SELECT * FROM kata_dasar where kata REGEXP '$regex$'");
                if($cekDataRegex->num_rows() > 0){
                    foreach($cekDataRegex->result() as $rows){
                        $pembanding =  $cekDataRegex->num_rows() <= 0 ? $stemming : $rows->kata;
                        $respon = array(
                            "id_pengujian"=>$id,
                            "urutan"=>$urutan,
                            "kata_asal"=>$tokenizing,
                            "kata_stemming"=>$stemming,
                            "kamus"=>$rows->kata,
                            "jaro_winkler"=>JaroWinkler($tokenizing,$pembanding),
                            "awalan"=>$awalan,
                            "akhiran"=>$akhiran
                         );
                         array_push($jaroWinkler,$respon);
                    }
                }else{
                    if($tokenizing != null || $tokenizing !=""){
                        $regex = substr($stemming,0,3);
                        $cekRegAwal = $this->db->query("SELECT * FROM kata_dasar where kata like '%$regex%'"); 
                        foreach($cekRegAwal->result() as $rows){
                            $pembanding =  $cekRegAwal->num_rows() <= 0 ? $stemming : $rows->kata;
                            $respon = array(
                                "id_pengujian"=>$id,
                                "urutan"=>$urutan,
                                "kata_asal"=>$tokenizing,
                                "kata_stemming"=>$stemming,
                                "kamus"=>$rows->kata,
                                "jaro_winkler"=>JaroWinkler($tokenizing,$pembanding),
                                "awalan"=>$awalan,
                                "akhiran"=>$akhiran
                             );
                             
                             array_push($jaroWinkler,$respon);
                        }
                    }
                }
                
            }
            $jw="";
            if(!is_array($jaroWinkler)){
                $jw = $jaroWinkler;
            }else{
                $jw = array_unique($jaroWinkler, SORT_REGULAR);
            }
            $data=array(
                "urutan"=>$urutan,
                "kataAsal"=>$kt,
                "cleaning"=>$cleaning,
                "casefolding"=>$cleaning,
                "tokenizing"=>$tokenizing,
                "stemming"=>$stemming == null || $stemming=="" ? $tokenizing : $stemming,
                "cekKamus"=>$cek,
                "jarwo"=>$jw,
            );
            array_push($result,$data);
            $insertAsal = $this->db->insert('kata_asal',array("id_pengujian"=>$id,"teks"=>$kt));
            $insertCleaning = $this->db->insert('cleaning',array("id_pengujian"=>$id,"cleaning"=>$cleaning));
            $insertCase= $this->db->insert('casefolding',array("id_pengujian"=>$id,"casefolding"=>$casefolding));
            $insertToken= $this->db->insert('tokenizing',array("id_pengujian"=>$id,"tokenizing"=>$tokenizing));
            $stemming= $this->db->insert('stemming',array("id_pengujian"=>$id,"stemming"=>$stemming));
            $urutan++;
            $key = array_search('0', $jw);
            unset($jw[$key]);
            $array = $jw;
            array_unique($array, SORT_REGULAR);
            $keys = array_column($jw, 'jaro_winkler');
            array_multisort($keys, SORT_DESC,$jw);
            $jarwo = array_slice($jw, 0, 5);
            
            $insertJaro = $this->db->insert_batch('jaro_winkler',$jarwo);
        }
        echo json_encode($result);
    }

    
     public function load_temp()
     {   ini_set('max_input_vars', 30000);
         $result = $this->input->post('result');
        
         echo " <table class='table' id='example1'>
                        <thead>
                        <tr>
                        <th>No</th>
                        <th>Kata Asal</th>
                        <th>Cleaning</th>
                        <th>Case Folding</th>
                        <th>Tokenizing</th>
                        <th>Stemming</th>
                        <th>Kata Tidak Normal</th>
                        <th>Rekomendasi</th>
                        </tr>
                    </thead>";
                   
                     $no=1;
                   
                     $unNormal ="";
                     $key = array_search("", array_column($result,'kataAsal'));
                     unset($result[$key]);
                     foreach ($result as $d) {
                        if($d['cekKamus']=="true"){
                            $unNormal ="";
                        }else{
                            $unNormal= $d['stemming'];
                        }
                        $array = $d['jarwo'];
                        array_unique($array, SORT_REGULAR);
                        $keys = array_column($d['jarwo'], 'jaro_winkler');
                        array_multisort($keys, SORT_DESC,$d['jarwo']);
                        $jarwo = array_slice($d['jarwo'], 0, 5);
                         echo "<tbody>
                         <tr id='dataku'>
                                 <td>$no</td>
                                 <td>".$d['kataAsal']."</td>
                                 <td>".$d['cleaning']."</td>
                                 <td>".$d['casefolding']."</td>
                                 <td>".$d['tokenizing']."</td>
                                 <td>".$d['stemming']."</td>
                                 <td>".$unNormal."</td>
                                 <td>";
                                 $key = array_search(0, array_column('jaro_winkler',$jarwo));
                                 unset($jarwo[$key]);
                                 foreach($jarwo as $j){
                                     echo "<b>".$j['awalan']." ".$j['kamus']." ".$j['akhiran']."</b><br>";
                                 }
                                echo "</td>
                              </tr>
                            </tbody>  ";
                         $no++;
                         
                     }
                     echo "</table>";  
                    
     }

     public function load_template()
     {   ini_set('max_input_vars', 300000);
         $result = $this->input->post('result');
       
         echo " <table class='table table-bordered table-hover' id='example1'>
                        <thead>";
                       echo" <tr><td width='200px;' style='background-color:#9d72ff;color:white;font-weight:bold;'>Kata Asal</td><td>";
                            $kataAs = array_column($result,'kataAsal');
                            $penyambungAsal="";
                            $penyambungAsalTutup="";
                            foreach($result as $ks){
                                if($ks['kataAsal']!=""){
                                    $penyambungAsal ="[ ";
                                    $penyambungAsalTutup =" ], ";
                                }else{
                                    $penyambungAsal="";
                                    $penyambungAsalTutup="";
                                }
                                echo $penyambungAsal.$ks['kataAsal'].$penyambungAsalTutup;
                             }
                        echo "</td></tr>";
                        
                        echo "<tr><td style='background-color:#9d72ff;color:white;font-weight:bold;'>Cleaning</td>
                        <td>";
                        $kataAs = array_column($result,'kataAsal');
                        $penyambungCleaning="";
                        $penyambungCleaningTutup="";
                        foreach($result as $ks){
                            if($ks['cleaning']!=""){
                                $penyambungCleaning ="[ ";
                                $penyambungCleaningTutup =" ], ";
                            }else{
                                $penyambungCleaning="";
                                $penyambungCleaningTutup="";
                            }
                            echo $penyambungCleaning.$ks['cleaning'].$penyambungCleaningTutup;
                         }
                        echo "</td></tr>";

                        echo "<tr> <td style='background-color:#9d72ff;color:white;font-weight:bold;'>Casefolding</td>
                        <td>";
                        $kataAs = array_column($result,'kataAsal');
                        $penyambungCase="";
                        $penyambungCaseTutup="";
                        foreach($result as $ks){
                            if($ks['casefolding']!=""){
                                $penyambungCase ="[ ";
                                $penyambungCaseTutup =" ], ";
                            }else{
                                $penyambungCase="";
                                $penyambungCaseTutup="";
                            }
                            echo $penyambungCase.$ks['casefolding'].$penyambungCaseTutup;
                         }
                        echo "</td></tr>";
                       
                        echo "<tr> <td style='background-color:#9d72ff;color:white;font-weight:bold;'>Tokenizing</td>
                        <td>";
                        // $kataAs32 = array_search("",array_column($result,'kataAsal'));
                        // unset($result[$kataAs32]);
                        // array_filter($result);
                        $penyambungToken="";
                        $penyambungTokenTutup="";
                        foreach($result as $ks){
                            if($ks['tokenizing']!=""){
                                $penyambungToken ="[ ";
                                $penyambungTokenTutup =" ], ";
                            }else{
                                $penyambungToken="";
                                $penyambungTokenTutup="";
                            }
                            echo $penyambungToken.$ks['tokenizing'].$penyambungTokenTutup;
                         }
                        echo "</td></tr>";

                        echo "<tr> <td style='background-color:#9d72ff;color:white;font-weight:bold;'>Stemming</td>
                        <td>";
                        $kataAs = array_column($result,'kataAsal');
                        $penyambungStem="";
                        $penyambungStemTutup="";
                        foreach($result as $ks){
                            if($ks['stemming']!=""){
                                $penyambungStem ="[ ";
                                $penyambungStemTutup =" ], ";
                            }else{
                                $penyambungStem="";
                                $penyambungStemTutup="";
                            }
                            echo $penyambungStem.$ks['stemming'].$penyambungStemTutup;
                         }
                        echo "</td></tr>";

                        echo "<tr> <td style='background-color:#9d72ff;color:white;font-weight:bold;'>Kata Tidak Normal</td>
                        <td>[ ";
                        $kataAs2 = array_search("",array_column($result,'kataAsal'));
                        unset($result[$kataAs2]);
                        foreach($result as $ks){
                            if($ks['cekKamus']=="false"){
                                    $unNormal= $ks['stemming'];
                            }else{
                                $unNormal="";
                            }
                            echo trim($unNormal).", ";
                         }
                        echo " ]</td></tr>";
                        echo "<tr>
                        <td style='background-color:#9d72ff;color:white;font-weight:bold;'>Kata Rekomendasi</td>
                        <td>";
                        foreach($result as $ks){
                            $array = $ks['jarwo'];
                            array_unique($array, SORT_REGULAR);
                            $keys = array_column($ks['jarwo'], 'jaro_winkler');
                            array_multisort($keys, SORT_DESC,$ks['jarwo']);
                            $jarwo = $ks['jarwo'];
                            $kataAss2 = array_search("",array_column($ks['jarwo'],'kata_asal'));
                            unset($jarwo[$kataAss2]);
                           foreach($jarwo as $j){
                            echo "<b>[".$j['awalan']."".$j['kamus']."".$j['akhiran']."]</b>, ";
                           }
                         }
                        echo "</td></tr>";
            echo "</thead>";
                    
                     $no=1;
                   
                     $unNormal ="";
                      $key = array_search("", array_column($result,'kataAsal'));
                      unset($result[$key]);
                     
                      $kataAs = array_column($result,'kataAsal');
                    //   print_r($kataAs);
                      echo "<tbody>";
                      echo "<tr>";
                      foreach($kataAsal as $ks){
                         echo "<td>".$ks[0]."</td>";
                      }
                      echo "</tr>";
                    //  foreach ($result as $d) {
                    //     if($d['cekKamus']=="true"){
                    //         $unNormal ="";
                    //     }else{
                    //         $unNormal= $d['stemming'];
                    //     }
                    //     $array = $d['jarwo'];
                    //     array_unique($array, SORT_REGULAR);
                    //     $keys = array_column($d['jarwo'], 'jaro_winkler');
                    //     array_multisort($keys, SORT_DESC,$d['jarwo']);
                    //     $jarwo = array_slice($d['jarwo'], 0, 5);
                    //      echo "<tbody>
                    //      <tr id='dataku'>
                    //              <td>$no</td>
                    //              <td>".$d['kataAsal']."</td>
                    //              <td>".$d['cleaning']."</td>
                    //              <td>".$d['casefolding']."</td>
                    //              <td>".$d['tokenizing']."</td>
                    //              <td>".$d['stemming']."</td>
                    //              <td>".$unNormal."</td>
                    //              <td>";
                    //              $key = array_search(0, array_column('jaro_winkler',$jarwo));
                    //              unset($jarwo[$key]);
                    //              foreach($jarwo as $j){
                    //                  echo "<b>".$j['awalan']." ".$j['kamus']." ".$j['akhiran']."</b><br>";
                    //              }
                    //             echo "</td>
                    //           </tr>
                    //         </tbody>  ";
                    //      $no++;
                         
                    //  }
                     echo " </tbody></table>";  
                    
     }

     public function load_temp_pengujian(){
        ini_set('max_input_vars', 300000);
        $result = $this->input->post('result');

        echo "<table>
                <tr>
                    <th>Kata Asal</th>
                </tr>
                <tr>
                    <th>Kata Asal</th>
                </tr>
        </table>";
     }

    public function stemmingFunc($stem){
        if($this->cekKamusData($stem)){
            return $stem;
        }else{
            return $this->hapus_Awalan($stem);
        }
    }

    public function hapus_Akhiran($kata){
        $kataAsal = $kata;
        $hasilAkhir = "";
        $partikel =""; 
        if(preg_match("/do\z/i",$kataAsal)){
            $partikel = "do";
            $hasilAkhir = preg_replace("/do\z/","",$kataAsal);
            if($this->cekKamusData($hasilAkhir)){
                return $hasilAkhir;
            }else{
                return $hasilAkhir;
            }
        }
        if(preg_match("/ma\z/i",$kataAsal)){
            $partikel = "ma";
            $hasilAkhir = preg_replace("/ma\z/","",$kataAsal);
            if($this->cekKamusData($hasilAkhir)){
                return $hasilAkhir;
            }else{
                return $hasilAkhir;
            }
        }
        if(preg_match("/pe\z/i",$kataAsal)){
            $partikel = "pe";
            $hasilAkhir = preg_replace("/pe\z/","",$kataAsal);
            if($this->cekKamusData($hasilAkhir)){
                return $hasilAkhir;
            }else{
                return $hasilAkhir;
            }
        }
        if(preg_match("/hon\z/i",$kataAsal)){
            $partikel = "hon";
            $hasilAkhir = preg_replace("/hon\z/","",$kataAsal);
            if($this->cekKamusData($hasilAkhir)){
                return $hasilAkhir;
            }else{
                return $hasilAkhir;
            }
        }
        if(preg_match("/an\z/i",$kataAsal)){
            $partikel = "an";
            $hasilAkhir = preg_replace("/an\z/","",$kataAsal);
            if($this->cekKamusData($hasilAkhir)){
                return $hasilAkhir;
            }else{
                return $hasilAkhir;
            }
        }
        if(preg_match("/si\z/i",$kataAsal)){
            $partikel = "si";
            $hasilAkhir = preg_replace("/si\z/","",$kataAsal);
            if($this->cekKamusData($hasilAkhir)){
                return $hasilAkhir;
            }else{
                return $hasilAkhir;
            }
        }
        if(preg_match("/i\z/i",$kataAsal)){
            $partikel = "i";
            $hasilAkhir = preg_replace("/i\z/","",$kataAsal);
            if($this->cekKamusData($hasilAkhir)){
                return $hasilAkhir;
            }else{
                return $hasilAkhir;
            }
        }
        if(preg_match("/hu\z/i",$kataAsal)){
            $partikel = "hu";
            $hasilAkhir = preg_replace("/hu\z/","",$kataAsal);
            if($this->cekKamusData($hasilAkhir)){
                return $hasilAkhir;
            }else{
                return $hasilAkhir;
            }
        }
        if(preg_match("/na\z/i",$kataAsal)){
            $partikel = "na";
            $hasilAkhir = preg_replace("/na\z/","",$kataAsal);
            if($this->cekKamusData($hasilAkhir)){
                return $hasilAkhir;
            }else{
                return $hasilAkhir;
            }
        }
        if(preg_match("/hmu\z/i",$kataAsal)){
            $partikel = "mu";
            $hasilAkhir = preg_replace("/hmu\z/","hamu",$kataAsal);
            if($this->cekKamusData($hasilAkhir)){
                return $hasilAkhir;
            }else{
                return $hasilAkhir;
            }
        }
        if(preg_match("/mu\z/i",$kataAsal)){
            $partikel = "mu";
            $hasilAkhir = preg_replace("/mu\z/","",$kataAsal);
            if($this->cekKamusData($hasilAkhir)){
                return $hasilAkhir;
            }else{
                return $hasilAkhir;
            }
        }
        if(preg_match("/ta\z/i",$kataAsal)){
            $partikel = "ta";
            $hasilAkhir = preg_replace("/ta\z/","",$kataAsal);
            if($this->cekKamusData($hasilAkhir)){
                return $hasilAkhir;
            }else{
                return $hasilAkhir;
            }
        }
        if(preg_match("/nami\z/i",$kataAsal)){
            $partikel = "nami";
            $hasilAkhir = preg_replace("/nami\z/","",$kataAsal);
            if($this->cekKamusData($hasilAkhir)){
                return $hasilAkhir;
            }else{
                return $hasilAkhir;
            }
        }
        if(preg_match("/on\z/i",$kataAsal)){
            $partikel = "on";
            $hasilAkhir = preg_replace("/on\z/","",$kataAsal);
            if($this->cekKamusData($hasilAkhir)){
                return $hasilAkhir;
            }else{
                return $hasilAkhir;
            }
        }
        if(preg_match("/nasida\z/i",$kataAsal)){
            $partikel = "nasida";
            $hasilAkhir = preg_replace("/nasida\z/","",$kataAsal);
            if($this->cekKamusData($hasilAkhir)){
                return $hasilAkhir;
            }else{
                return $hasilAkhir;
            }
        }
        return $kataAsal;
    }


    public function ambil_Akhiran($kata){
        $kataAsal = $kata;
        $hasilAkhir = "";
        $partikel =""; 
        if(preg_match("/do\z/i",$kataAsal)){
            $partikel = "do";
            $hasilAkhir = preg_replace("/do\z/","",$kataAsal);
            if($this->cekKamusData($hasilAkhir)){
                return $partikel;
            }else{
                return $partikel;
            }
        }
        if(preg_match("/ma\z/i",$kataAsal)){
            $partikel = "ma";
            $hasilAkhir = preg_replace("/ma\z/","",$kataAsal);
            if($this->cekKamusData($hasilAkhir)){
                return $partikel;
            }else{
                return $partikel;
            }
        }
        if(preg_match("/pe\z/i",$kataAsal)){
            $partikel = "pe";
            $hasilAkhir = preg_replace("/pe\z/","",$kataAsal);
            if($this->cekKamusData($hasilAkhir)){
                return $partikel;
            }else{
                return $partikel;
            }
        }
        if(preg_match("/hon\z/i",$kataAsal)){
            $partikel = "hon";
            $hasilAkhir = preg_replace("/hon\z/","",$kataAsal);
            if($this->cekKamusData($hasilAkhir)){
                return $partikel;
            }else{
                return $partikel;
            }
        }
        if(preg_match("/an\z/i",$kataAsal)){
            $partikel = "an";
            $hasilAkhir = preg_replace("/an\z/","",$kataAsal);
            if($this->cekKamusData($hasilAkhir)){
                return $partikel;
            }else{
                return $partikel;
            }
        }
        if(preg_match("/si\z/i",$kataAsal)){
            $partikel = "si";
            $hasilAkhir = preg_replace("/si\z/","",$kataAsal);
            if($this->cekKamusData($hasilAkhir)){
                return $partikel;
            }else{
                return $partikel;
            }
        }
        if(preg_match("/i\z/i",$kataAsal)){
            $partikel = "i";
            $hasilAkhir = preg_replace("/i\z/","",$kataAsal);
            if($this->cekKamusData($hasilAkhir)){
                return $partikel;
            }else{
                return $partikel;
            }
        }
        if(preg_match("/hu\z/i",$kataAsal)){
            $partikel = "hu";
            $hasilAkhir = preg_replace("/hu\z/","",$kataAsal);
            if($this->cekKamusData($hasilAkhir)){
                return $partikel;
            }else{
                return $partikel;
            }
        }
        if(preg_match("/na\z/i",$kataAsal)){
            $partikel = "na";
            $hasilAkhir = preg_replace("/na\z/","",$kataAsal);
            if($this->cekKamusData($hasilAkhir)){
                return $partikel;
            }else{
                return $partikel;
            }
        }
        if(preg_match("/hamu\z/i",$kataAsal)){
            $partikel = "";
            $hasilAkhir = preg_replace("/hamu\z/","hamu",$kataAsal);
            if($this->cekKamusData($hasilAkhir)){
                return $partikel;
            }else{
                return $partikel;
            }
        }
        if(preg_match("/mu\z/i",$kataAsal)){
            $partikel = "";
            $hasilAkhir = preg_replace("/mu\z/","",$kataAsal);
            if($this->cekKamusData($hasilAkhir)){
                return $partikel;
            }else{
                return $partikel;
            }
        }
        if(preg_match("/ta\z/i",$kataAsal)){
            $partikel = "ta";
            $hasilAkhir = preg_replace("/ta\z/","",$kataAsal);
            if($this->cekKamusData($hasilAkhir)){
                return $partikel;
            }else{
                return $partikel;
            }
        }
        if(preg_match("/nami\z/i",$kataAsal)){
            $partikel = "nami";
            $hasilAkhir = preg_replace("/nami\z/","",$kataAsal);
            if($this->cekKamusData($hasilAkhir)){
                return $partikel;
            }else{
                return $partikel;
            }
        }
        if(preg_match("/on\z/i",$kataAsal)){
            $partikel = "on";
            $hasilAkhir = preg_replace("/on\z/","",$kataAsal);
            if($this->cekKamusData($hasilAkhir)){
                return $partikel;
            }else{
                return $partikel;
            }
        }
        if(preg_match("/nasida\z/i",$kataAsal)){
            $partikel = "nasida";
            $hasilAkhir = preg_replace("/nasida\z/","",$kataAsal);
            if($this->cekKamusData($hasilAkhir)){
                return $partikel;
            }else{
                return $partikel;
            }
        }
        return "";
    }
   

    public function hapus_Awalan($kata){
        $kataAsal = $kata;
        $hasilStem = "";
        $awalan ="";
        
        if(preg_match("/^mang/i",$kataAsal)){
            $awalan = "mang";
            $hasilStem = preg_replace("/^mang/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            } 
        }
        if(preg_match("/^dihm/i",$kataAsal)){
            $awalan = "di";
            $hasilStem = preg_replace("/^dihm/","ham",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            } 
        }
        if(preg_match("/^ma\S/i",$kataAsal)){
            $awalan = "ma";
            $hasilStem = preg_replace("/^ma\S/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }  
        }
        if(preg_match("/^mans\S/i",$kataAsal)){
            $awalan = "man";
            $hasilStem = preg_replace("/^mans/","man",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            } 
        }
        if(preg_match("/^mar/i",$kataAsal)){
            $awalan = "mar";
            $hasilStem = preg_replace("/^mar/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            } 
        }
       
        if(preg_match("/^pan/i",$kataAsal)){
            $awalan = "pan";
            $hasilStem = preg_replace("/^pan/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            } 
        }
        if(preg_match("/^pam/i",$kataAsal)){
            $awalan = "pam";
            $hasilStem = preg_replace("/^pam/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            } 
        }
        if(preg_match("/^par/i",$kataAsal)){
            $awalan = "par";
            $hasilStem = preg_replace("/^par/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^di/i",$kataAsal)){
            $awalan = "di";
            $hasilStem = preg_replace("/^di/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^tar/i",$kataAsal)){
            $awalan = "tar";
            $hasilStem = preg_replace("/^tar/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        
        if(preg_match("/^hu/i",$kataAsal)){
            $awalan = "hu";
            $hasilStem = preg_replace("/^hu/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^tu/i",$kataAsal)){
            $awalan = "tu";
            $hasilStem = preg_replace("/^tu/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^um/i",$kataAsal)){
            $awalan = "um";
            $hasilStem = preg_replace("/^um/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^hina/i",$kataAsal)){
            $awalan = "hina";
            $hasilStem = preg_replace("/^hina/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^si/i",$kataAsal)){
            $awalan = "si";
            $hasilStem = preg_replace("/^si/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^dipang/i",$kataAsal)){
            $awalan = "dipang";
            $hasilStem = preg_replace("/^dipang/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^dipangk/i",$kataAsal)){
            $awalan = "dipangk";
            $hasilStem = preg_replace("/^dipangk/","h",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^sima/i",$kataAsal)){
            $awalan = "sima";
            $hasilStem = preg_replace("/^sima/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^sam/i",$kataAsal)){
            $awalan = "sam";
            $hasilStem = preg_replace("/^sam/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^sodi/i",$kataAsal)){
            $awalan = "sodi";
            $hasilStem = preg_replace("/^sodi/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^san/i",$kataAsal)){
            $awalan = "san";
            $hasilStem = preg_replace("/^san/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^sipa/i",$kataAsal)){
            $awalan = "sipa";
            $hasilStem = preg_replace("/^sipa/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^sipar/i",$kataAsal)){
            $awalan = "sipar";
            $hasilStem = preg_replace("/^sipar/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^siparsa/i",$kataAsal)){
            $awalan = "siparsa";
            $hasilStem = preg_replace("/^siparsa/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^siha/i",$kataAsal)){
            $awalan = "siha";
            $hasilStem = preg_replace("/^siha/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^sapang/i",$kataAsal)){
            $awalan = "sapang";
            $hasilStem = preg_replace("/^sapang/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^sapangk/i",$kataAsal)){
            $awalan = "sapangk";
            $hasilStem = preg_replace("/^sapangk/","h",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^simanga/i",$kataAsal)){
            $awalan = "simanga";
            $hasilStem = preg_replace("/^simanga/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^dipar/i",$kataAsal)){
            $awalan = "dipar";
            $hasilStem = preg_replace("/^dipa/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^dipa/i",$kataAsal)){
            $awalan = "dipa";
            $hasilStem = preg_replace("/^dipa/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
       
        if(preg_match("/^hi/i",$kataAsal)){
            $awalan = "hi";
            $hasilStem = preg_replace("/^hi/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^napa/i",$kataAsal)){
            $awalan = "napa";
            $hasilStem = preg_replace("/^napa/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^hupa/i",$kataAsal)){
            $awalan = "hupa";
            $hasilStem = preg_replace("/^hupa/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^huma/i",$kataAsal)){
            $awalan = "huma";
            $hasilStem = preg_replace("/^huma/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^hum/i",$kataAsal)){
            $awalan = "hum";
            $hasilStem = preg_replace("/^hum/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^ni/i",$kataAsal)){
            $awalan = "ni";
            $hasilStem = preg_replace("/^ni/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^pina/i",$kataAsal)){
            $awalan = "pina";
            $hasilStem = preg_replace("/^pina/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^panga/i",$kataAsal)){
            $awalan = "panga";
            $hasilStem = preg_replace("/^panga/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^tuma/i",$kataAsal)){
            $awalan = "tuma";
            $hasilStem = preg_replace("/^tuma/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^tinar/i",$kataAsal)){
            $awalan = "tinar";
            $hasilStem = preg_replace("/^tinar/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^tar/i",$kataAsal)){
            $awalan = "tar";
            $hasilStem = preg_replace("/^tar/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^tarha/i",$kataAsal)){
            $awalan = "tarha";
            $hasilStem = preg_replace("/^tarha/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^tarpar/i",$kataAsal)){
            $awalan = "tarpar";
            $hasilStem = preg_replace("/^tarpar/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^tarpa/i",$kataAsal)){
            $awalan = "tarpa";
            $hasilStem = preg_replace("/^tarpa/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^mam/i",$kataAsal)){
            $awalan = "mam";
            $hasilStem = preg_replace("/^mam/","p",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        
        if(preg_match("/^man/i",$kataAsal)){
            $awalan = "man";
            $hasilStem = preg_replace("/^man/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^mang/i",$kataAsal)){
            $awalan = "mang";
            $hasilStem = preg_replace("/^mang/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^mangk/i",$kataAsal)){
            $awalan = "mangk";
            $hasilStem = preg_replace("/^mangk/","h",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^mangha/i",$kataAsal)){
            $awalan = "mangha";
            $hasilStem = preg_replace("/^mangha/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^manga/i",$kataAsal)){
            $awalan = "manga";
            $hasilStem = preg_replace("/^manga/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^(ma){3}/i",$kataAsal)){
            $awalan = "ma";
            $hasilStem = preg_replace("/^ma/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^marsi/i",$kataAsal)){
            $awalan = "marsi";
            $hasilStem = preg_replace("/^marsi/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^marna/i",$kataAsal)){
            $awalan = "marna";
            $hasilStem = preg_replace("/^marna/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^marni/i",$kataAsal)){
            $awalan = "marni";
            $hasilStem = preg_replace("/^marni/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^marha/i",$kataAsal)){
            $awalan = "marha";
            $hasilStem = preg_replace("/^marha/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^marpanga/i",$kataAsal)){
            $awalan = "marpanga";
            $hasilStem = preg_replace("/^marpanga/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^marsa/i",$kataAsal)){
            $awalan = "marsa";
            $hasilStem = preg_replace("/^marsa/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^masi/i",$kataAsal)){
            $awalan = "masi";
            $hasilStem = preg_replace("/^masi/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^masipa/i",$kataAsal)){
            $awalan = "masipa";
            $hasilStem = preg_replace("/^masipa/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^masiha/i",$kataAsal)){
            $awalan = "masiha";
            $hasilStem = preg_replace("/^masiha/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^mansi/i",$kataAsal)){
            $awalan = "mansi";
            $hasilStem = preg_replace("/^mansi/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^mampar/i",$kataAsal)){
            $awalan = "mampar";
            $hasilStem = preg_replace("/^mampar/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^pai/i",$kataAsal)){
            $awalan = "pai";
            $hasilStem = preg_replace("/^pai/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^pam/i",$kataAsal)){
            $awalan = "pam";
            $hasilStem = preg_replace("/^pam/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        if(preg_match("/^pana/i",$kataAsal)){
            $awalan = "pana";
            $hasilStem = preg_replace("/^pana/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
                return $hasilStem; 
            }else{
                return $this->hapus_Akhiran($hasilStem);
            }
        }
        
        return $this->hapus_Akhiran($kataAsal);
    }


    public function ambil_Awalan($kata){
        $kataAsal = $kata;
        $hasilStem = "";
        $awalan ="";
        
        if(preg_match("/^mang/i",$kataAsal)){
            $awalan = "mang";
            $hasilStem = preg_replace("/^mang/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            } 
        }
        if(preg_match("/^dihm/i",$kataAsal)){
            $awalan = "di";
            $hasilStem = preg_replace("/^dihm/","ham",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            } 
        }
        if(preg_match("/^ma\S/i",$kataAsal)){
            $awalan = "ma";
            $hasilStem = preg_replace("/^ma\S/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }  
        }
        if(preg_match("/^mans\S/i",$kataAsal)){
            $awalan = "man";
            $hasilStem = preg_replace("/^mans/","man",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            } 
        }
        if(preg_match("/^mar/i",$kataAsal)){
            $awalan = "mar";
            $hasilStem = preg_replace("/^mar/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            } 
        }
       
        if(preg_match("/^pan/i",$kataAsal)){
            $awalan = "pan";
            $hasilStem = preg_replace("/^pan/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            } 
        }
        if(preg_match("/^pam/i",$kataAsal)){
            $awalan = "pam";
            $hasilStem = preg_replace("/^pam/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            } 
        }
        if(preg_match("/^par/i",$kataAsal)){
            $awalan = "par";
            $hasilStem = preg_replace("/^par/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^di/i",$kataAsal)){
            $awalan = "di";
            $hasilStem = preg_replace("/^di/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^tar/i",$kataAsal)){
            $awalan = "tar";
            $hasilStem = preg_replace("/^tar/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        
        if(preg_match("/^hu/i",$kataAsal)){
            $awalan = "hu";
            $hasilStem = preg_replace("/^hu/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^tu/i",$kataAsal)){
            $awalan = "tu";
            $hasilStem = preg_replace("/^tu/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^um/i",$kataAsal)){
            $awalan = "um";
            $hasilStem = preg_replace("/^um/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^hina/i",$kataAsal)){
            $awalan = "hina";
            $hasilStem = preg_replace("/^hina/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^si/i",$kataAsal)){
            $awalan = "si";
            $hasilStem = preg_replace("/^si/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^dipang/i",$kataAsal)){
            $awalan = "dipang";
            $hasilStem = preg_replace("/^dipang/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^dipangk/i",$kataAsal)){
            $awalan = "dipangk";
            $hasilStem = preg_replace("/^dipangk/","h",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^sima/i",$kataAsal)){
            $awalan = "sima";
            $hasilStem = preg_replace("/^sima/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^sam/i",$kataAsal)){
            $awalan = "sam";
            $hasilStem = preg_replace("/^sam/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^sodi/i",$kataAsal)){
            $awalan = "sodi";
            $hasilStem = preg_replace("/^sodi/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^san/i",$kataAsal)){
            $awalan = "san";
            $hasilStem = preg_replace("/^san/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^sipa/i",$kataAsal)){
            $awalan = "sipa";
            $hasilStem = preg_replace("/^sipa/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^sipar/i",$kataAsal)){
            $awalan = "sipar";
            $hasilStem = preg_replace("/^sipar/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^siparsa/i",$kataAsal)){
            $awalan = "siparsa";
            $hasilStem = preg_replace("/^siparsa/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^siha/i",$kataAsal)){
            $awalan = "siha";
            $hasilStem = preg_replace("/^siha/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^sapang/i",$kataAsal)){
            $awalan = "sapang";
            $hasilStem = preg_replace("/^sapang/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^sapangk/i",$kataAsal)){
            $awalan = "sapangk";
            $hasilStem = preg_replace("/^sapangk/","h",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^simanga/i",$kataAsal)){
            $awalan = "simanga";
            $hasilStem = preg_replace("/^simanga/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^dipar/i",$kataAsal)){
            $awalan = "dipar";
            $hasilStem = preg_replace("/^dipa/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^dipa/i",$kataAsal)){
            $awalan = "dipa";
            $hasilStem = preg_replace("/^dipa/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
       
        if(preg_match("/^hi/i",$kataAsal)){
            $awalan = "hi";
            $hasilStem = preg_replace("/^hi/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^napa/i",$kataAsal)){
            $awalan = "napa";
            $hasilStem = preg_replace("/^napa/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^hupa/i",$kataAsal)){
            $awalan = "hupa";
            $hasilStem = preg_replace("/^hupa/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^huma/i",$kataAsal)){
            $awalan = "huma";
            $hasilStem = preg_replace("/^huma/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^hum/i",$kataAsal)){
            $awalan = "hum";
            $hasilStem = preg_replace("/^hum/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^ni/i",$kataAsal)){
            $awalan = "ni";
            $hasilStem = preg_replace("/^ni/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^pina/i",$kataAsal)){
            $awalan = "pina";
            $hasilStem = preg_replace("/^pina/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^panga/i",$kataAsal)){
            $awalan = "panga";
            $hasilStem = preg_replace("/^panga/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^tuma/i",$kataAsal)){
            $awalan = "tuma";
            $hasilStem = preg_replace("/^tuma/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^tinar/i",$kataAsal)){
            $awalan = "tinar";
            $hasilStem = preg_replace("/^tinar/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^tar/i",$kataAsal)){
            $awalan = "tar";
            $hasilStem = preg_replace("/^tar/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^tarha/i",$kataAsal)){
            $awalan = "tarha";
            $hasilStem = preg_replace("/^tarha/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^tarpar/i",$kataAsal)){
            $awalan = "tarpar";
            $hasilStem = preg_replace("/^tarpar/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^tarpa/i",$kataAsal)){
            $awalan = "tarpa";
            $hasilStem = preg_replace("/^tarpa/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^mam/i",$kataAsal)){
            $awalan = "mam";
            $hasilStem = preg_replace("/^mam/","p",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        
        if(preg_match("/^man/i",$kataAsal)){
            $awalan = "man";
            $hasilStem = preg_replace("/^man/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^mang/i",$kataAsal)){
            $awalan = "mang";
            $hasilStem = preg_replace("/^mang/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^mangk/i",$kataAsal)){
            $awalan = "mangk";
            $hasilStem = preg_replace("/^mangk/","h",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^mangha/i",$kataAsal)){
            $awalan = "mangha";
            $hasilStem = preg_replace("/^mangha/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^manga/i",$kataAsal)){
            $awalan = "manga";
            $hasilStem = preg_replace("/^manga/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^(ma){3}/i",$kataAsal)){
            $awalan = "ma";
            $hasilStem = preg_replace("/^ma/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^marsi/i",$kataAsal)){
            $awalan = "marsi";
            $hasilStem = preg_replace("/^marsi/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^marna/i",$kataAsal)){
            $awalan = "marna";
            $hasilStem = preg_replace("/^marna/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^marni/i",$kataAsal)){
            $awalan = "marni";
            $hasilStem = preg_replace("/^marni/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^marha/i",$kataAsal)){
            $awalan = "marha";
            $hasilStem = preg_replace("/^marha/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^marpanga/i",$kataAsal)){
            $awalan = "marpanga";
            $hasilStem = preg_replace("/^marpanga/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^marsa/i",$kataAsal)){
            $awalan = "marsa";
            $hasilStem = preg_replace("/^marsa/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^masi/i",$kataAsal)){
            $awalan = "masi";
            $hasilStem = preg_replace("/^masi/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^masipa/i",$kataAsal)){
            $awalan = "masipa";
            $hasilStem = preg_replace("/^masipa/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^masiha/i",$kataAsal)){
            $awalan = "masiha";
            $hasilStem = preg_replace("/^masiha/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^mansi/i",$kataAsal)){
            $awalan = "mansi";
            $hasilStem = preg_replace("/^mansi/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^mampar/i",$kataAsal)){
            $awalan = "mampar";
            $hasilStem = preg_replace("/^mampar/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^pai/i",$kataAsal)){
            $awalan = "pai";
            $hasilStem = preg_replace("/^pai/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^pam/i",$kataAsal)){
            $awalan = "pam";
            $hasilStem = preg_replace("/^pam/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        if(preg_match("/^pana/i",$kataAsal)){
            $awalan = "pana";
            $hasilStem = preg_replace("/^pana/","",$kataAsal);
              if($this->cekKamusData($hasilStem)){
               return $awalan;
            }else{
                return $awalan;
            }
        }
        
        return $awalan="";
    }

    public function cekKamusData($dictionary){
        $implode = $dictionary;
        $wordFromDictionary="";
        if(is_array($implode)==1){
            foreach($implode as $key =>$value ){
                $word = $this->db->query("SELECT * FROM kata_dasar where kata ='$value'");
                if($word->num_rows() > 0){
                    $wordFromDictionary = true;
                }else{
                    $wordFromDictionary = false;
                }
            }
        }else{
            $word = $this->db->query("SELECT * FROM kata_dasar where kata ='$implode'");
                if($word->num_rows() > 0){
                    $wordFromDictionary = true;
                }else{
                    $wordFromDictionary = false;
                }
        }
        return $wordFromDictionary;
    }


    function acak($panjang)
    {
      $karakter= 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789';
      $string = '';
      for ($i = 0; $i < $panjang; $i++) {
        $pos = rand(0, strlen($karakter)-1);
        $string .= $karakter{$pos};
      }
      echo json_encode(array(
          "data"=>$string,
      ));
    }

    public function fetch_data(){
        $starts       = $this->input->post("start");
        $length       = $this->input->post("length");
        $LIMIT        = "LIMIT  $starts, $length ";
        $draw         = $this->input->post("draw");
        $search       = $this->input->post('search')['value'];
        $orders       = isset($_POST['order']) ? $_POST['order'] : ''; 
        
        $where ="WHERE 1=1";
        $searchingColumn;
        $result=array();
        if (isset($search)) {
          if ($search != '') {
             $searchingColumn = $search;
                $where .= " AND (teks LIKE '%$search%' 
                                )";
              }
          }

        if (isset($orders)) {
            if ($orders != '') {
              $order = $orders;
              $order_column = ['teks'];
              $order_clm  = $order_column[$order[0]['column']];
              $order_by   = $order[0]['dir'];
              $where .= " GROUP BY id_pengujian ORDER BY $order_clm $order_by ";
            } else {
              $where .= " GROUP BY id_pengujian ORDER BY id ASC ";
            }
          } else {
            $where .= " GROUP BY id_pengujian ORDER BY id ASC ";
          }
          if (isset($LIMIT)) {
            if ($LIMIT != '') {
              $where .= ' ' . $LIMIT;
            }
          }
        $index=1;
        $button="";
        $fetch = $this->db->query("SELECT id,id_pengujian,teks,GROUP_CONCAT(DISTINCT(teks) SEPARATOR '<br>') as kata FROM kata_asal $where");
        $fetch2 = $this->db->query("SELECT id,id_pengujian,teks,GROUP_CONCAT(DISTINCT(teks) SEPARATOR '<br>') as kata FROM kata_asal GROUP BY id_pengujian");
        foreach($fetch->result() as $rows){
            $cleaning = $this->db->query("SELECT GROUP_CONCAT(DISTINCT(cleaning) SEPARATOR '<br>') as teks FROM cleaning where id_pengujian='$rows->id_pengujian' group by id_pengujian");
            $case = $this->db->query("SELECT GROUP_CONCAT(DISTINCT(casefolding) SEPARATOR '<br>') as teks FROM casefolding where id_pengujian='$rows->id_pengujian' group by id_pengujian");
            $token = $this->db->query("SELECT GROUP_CONCAT(DISTINCT(tokenizing) SEPARATOR '<br>') as teks FROM tokenizing where id_pengujian='$rows->id_pengujian' group by id_pengujian");
            $stem = $this->db->query("SELECT GROUP_CONCAT(DISTINCT(stemming) SEPARATOR '<br>') as teks FROM stemming where id_pengujian='$rows->id_pengujian' group by id_pengujian");
            $jaro = $this->db->query("SELECT kamus as teks,jaro_winkler FROM jaro_winkler where id_pengujian='$rows->id_pengujian' group by kamus order by urutan ASC")->result();
            $button = "<a href=".base_url('pengujian/read/'.$rows->id_pengujian)." class='btn btn-icon icon-left btn-danger btn-block'><i class='fa fa-eye'> View</i></a>";
           
            $sub_array=array();
            $sub_array[]=$index;
            $sub_array[]=$rows->id_pengujian;
            $sub_array[]=$rows->kata;
            $sub_array[]=$cleaning->row()->teks;
            $sub_array[]=$case->row()->teks;
            $sub_array[]=$token->row()->teks;
            $sub_array[]=$stem->row()->teks;
            
             
            $sub_array[]=$button;
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

    public function index()
    {
        
        $this->load->view('header');
        $this->load->view('pengujian_list');
        $this->load->view('footer');
    }
    public function normalisasi()
    {
        
        $this->load->view('header');
        $this->load->view('normalisasi');
        $this->load->view('footer');
    }

    public function read($id) 
    {   
        $search = $this->db->query("SELECT id,id_pengujian,teks,GROUP_CONCAT(DISTINCT(teks) SEPARATOR ' ') 
        as kata FROM kata_asal where id_pengujian='$id' GROUP BY id_pengujian")->row();
        $data=array(
            "kalimat"=>$search->kata,
        );
        $this->load->view('header');
        $this->load->view('pengujian_read',$data);
        $this->load->view('footer');
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