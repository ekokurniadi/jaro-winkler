<?php


function stem($kata){
	global $rules;
	
	$rules = array();
	$kataAsal = strtolower($kata);
	
	// if (cekAdaKamus($kata)) {
	// 	//return array('result'=>$kata, 'rules'=>$rules, 'is_basicword'=>true);
	// 	return array('input'=>$kataAsal,'result'=>$kata, 'is_basicword'=>true);
	// }
	
	/* 3. Buang Akhiran  */
	$kata = Hapus_Akhiran($kata);
	
	/* 4. Buang Awalan */
	$kata = Hapus_Awalan($kata);

	//TAMBAHAN: pergunakan kata original atau nyatakan tidak punya kata dasar
	//return $kata;
	if (cekKamus($kata)) {
		// Jika ada kembalikan
		//return array('result'=>$kata, 'rules'=>$rules, 'is_basicword'=>true); 
		return array('input'=>$kataAsal,'result'=>$kata, 'is_basicword'=>true);
	} else {
		// Jika tidak ada kembalikan "" atau $kataAsal sesuai kebutuhan
		//return array('result'=>$kataAsal, 'rules'=>$rules, 'is_basicword'=>false); 
		return array('input'=>$kataAsal,'result'=>$kata, 'is_basicword'=>false);
	}
}

function cekKamus($kata){
	$kataKamus=array();
	$CI =& get_instance();
	$data = $CI->db->query("SELECT * FROM kata_dasar where kata ='$kata'");
	foreach($data->result() as $rows){
		$kataKamus[$rows->kata] = $rows->kata == null  || $rows->kata == "" ? $kata : $rows->kata ;
	} 
	return isset($kataKamus[$kata]) ? true : false;
}

// function cekKamus($kata){
// 	global $basicWords;
	
// 	return isset($basicWords[$kata]) ? true : false;
// }


/*============= Stemming dengan Algorithm ===============================*/

// Hapus Inflection Suffixes (“-lah”, “-kah”, “-ku”, “-mu”, atau “-nya”)


// Hapus Derivation Suffixes (“-i”, “-an” atau “-kan”)

function Hapus_Akhiran($kata){
	global $rules;
	
	$kataAsal = $kata;
	/*-----------------start kata berakhiran i------------------------ */
		if (preg_match('/(i)$/i',$kata)){				
			$__kata = preg_replace('/(nai)$/i','',$kata);
			if(cekKamus($__kata)){ // Cek Kamus	
			$rules[] = '-na + -i ';
			return $__kata;
			}	
			$__kata__ = preg_replace('/(hi)$/i','k',$kata);
			if(cekKamus($__kata__)){ // Cek Kamus
				$rules [] = '-hi -> k ';
				return $__kata__;
			}
			$__kata__ = preg_replace('/(hi)$/i','',$kata);
			if(cekKamus($__kata__)){ // Cek Kamus
				$rules [] = '-hi';
				return $__kata__;
			}
			$__kata = preg_replace('/(ni)$/i','',$kata);		
			if(cekKamus($__kata)){ // Cek Kamus			
				$rules[] = '-ni';
				return $__kata;
			}					
			$__kata__ = preg_replace('/(ani)$/i','',$kata);
			if(cekKamus($__kata__)){ // Cek Kamus
				$rules [] = '-an + -i ';
				return $__kata__;
			}			
			$__kata = preg_replace('/(nami)$/i','',$kata);
			if(cekKamus($__kata)){ // Cek Kamus	
			$rules[] = '-nami';
			return $__kata;
			}
			$__kata = preg_replace('/(onnami)$/i','',$kata);
			if(cekKamus($__kata)){ // Cek Kamus	
			$rules[] = '-on + -nami ';
			return $__kata;
			}
			$__kata = preg_replace('/(annami)$/i','',$kata);
			if(cekKamus($__kata)){ // Cek Kamus	
			$rules[] = '-an + -nami';
			return $__kata;
			}
			$__kata = preg_replace('/(hononnami)$/i','',$kata);
			if(cekKamus($__kata)){ // Cek Kamus	
			$rules[] = '-hon + -on + -nami';
			return $__kata;
			}
			$__kata = preg_replace('/(i)$/i','',$kata);
			if(cekKamus($__kata)){ // Cek Kamus	
			$rules[] = '-i ';
			return $__kata;
			}else if (substr($__kata,0,strlen($__kata)/2) == substr($__kata,strlen($__kata)/2)  && cekKamus(substr($__kata,0,strlen($__kata)/2))) { //penggandaan kata dasar
				$rules[] = 'kata dasar x 2';
				return substr($__kata,0,strlen($__kata)/2); // Jika ada balik
			}
		}
	/*-----------------end kata dengan akhiran i---------------------*/
	/*-----------------start kata dengan akhiran mu---------------------*/
		if (preg_match('/(mu)$/i',$kata)){			
			$__kata = preg_replace('/(mu)$/i','',$kata);
			if(cekKamus($__kata)){ // Cek Kamus	
			$rules[] = '-mu';
			return $__kata;
			}
			$__kata = preg_replace('/(hononmu)$/i','',$kata);
			if(cekKamus($__kata)){ // Cek Kamus	
			$rules[] = '-hon + -on + -mu';
			return $__kata;
			}			
			$__kata = preg_replace('/(anmu)$/i','',$kata);
			if(cekKamus($__kata)){ // Cek Kamus	
			$rules[] = '-an + -mu';
			return $__kata;
			}		
			$__kata = preg_replace('/(onmu)$/i','',$kata);
			if(cekKamus($__kata)){ // Cek Kamus	
			$rules[] = '-on + -mu';
			return $__kata;
			}
		}
	/*-----------------end kata dengan akhiran mu---------------------*/
	/*-----------------start kata dengan akhiran an---------------------*/
		if (preg_match('/(an)$/i',$kata)){			
			$__kata = preg_replace('/(an)$/i','',$kata);
			if(cekKamus($__kata)){ // Cek Kamus	
			$rules[] = '-an';
			return $__kata;
			}
			else if (substr($__kata,1,2) == 'in' && cekKamus(substr($__kata,0,1).substr($__kata, 3))) {
				$rules[] = '-in-';
				return substr($__kata,0,1).substr($__kata, 3); // Jika ada balik
			}
			else if (substr($__kata,0,strlen($__kata)/2) == substr($__kata,strlen($__kata)/2)  && cekKamus(substr($__kata,0,strlen($__kata)/2))) { //penggandaan kata dasar
				$rules[] = 'kata dasa x 2';
				return substr($__kata,0,strlen($__kata)/2); // Jika ada balik
			}			
			$__kata = preg_replace('/(han)$/i','k',$kata);
			if(cekKamus($__kata)){ // Cek Kamus
				$rules [] = '-han -> k ';
				return $__kata;
			}			
			$__kata = preg_replace('/(han)$/i','',$kata);
			if(cekKamus($__kata)){ // Cek Kamus
				$rules [] = '-han';
				return $__kata;
			}
		}
	/*-----------------end kata dengan akhiran an---------------------*/
	/*-----------------start kata dengan akhiran na---------------------*/
		if (preg_match('/(na)$/i',$kata)){			
			$__kata = preg_replace('/(na)$/i','',$kata);
			if(cekKamus($__kata)){ // Cek Kamus
			$rules[] = '-na';
			return $__kata;
			}else if (substr($__kata,0,strlen($__kata)/2) == substr($__kata,strlen($__kata)/2)  && cekKamus(substr($__kata,0,strlen($__kata)/2))) { //penggandaan kata dasar
				$rules[] = 'kata dasar x 2';
				return substr($__kata,0,strlen($__kata)/2); // Jika ada balik
			}else if (substr($__kata,1,2) == 'in' && cekKamus(substr($__kata,0,1).substr($__kata, 3))) {
				$rules[] = '-in- ';
				return substr($__kata,0,1).substr($__kata, 3); // Jika ada balik
			}
			$__kata = preg_replace('/(anna)$/i','',$kata);
			if(cekKamus($__kata)){ // Cek Kamus
			$rules[] = '-an + -na ';
			return $__kata;
			}else if (substr($__kata,0,strlen($__kata)/2) == substr($__kata,strlen($__kata)/2)  && cekKamus(substr($__kata,0,strlen($__kata)/2))) { //penggandaan kata dasar
				$rules[] = 'kata dasa x 2';
				return substr($__kata,0,strlen($__kata)/2); // Jika ada balik
			}else if (substr($__kata,1,2) == 'in' && cekKamus(substr($__kata,0,1).substr($__kata, 3))) {
				$rules[] = '-in-';
				return substr($__kata,0,1).substr($__kata, 3); // Jika ada balik
			}
			$__kata = preg_replace('/(onna)$/i','',$kata);
			if(cekKamus($__kata)){ // Cek Kamus
			$rules[] = '-on + -na';
			return $__kata;
			}
			$__kata = preg_replace('/(honna)$/i','',$kata);
			if(cekKamus($__kata)){ // Cek Kamus
			$rules[] = '-hon + -na';
			return $__kata;
			}else if (substr($__kata,0,strlen($__kata)/2) == substr($__kata,strlen($__kata)/2)  && cekKamus(substr($__kata,0,strlen($__kata)/2))) { //penggandaan kata dasar
				$rules[] = 'kata dasa x 2';
				return substr($__kata,0,strlen($__kata)/2); // Jika ada balik
			}
			$__kata = preg_replace('/(honna)$/i','k',$kata);
			if(cekKamus($__kata)){ // Cek Kamus
			$rules[] = '-hon + -na ->k ';
			return $__kata;
			}else if (substr($__kata,0,strlen($__kata)/2) == substr($__kata,strlen($__kata)/2)  && cekKamus(substr($__kata,0,strlen($__kata)/2))) { //penggandaan kata dasar
				$rules[] = 'kata dasar x 2';
				return substr($__kata,0,strlen($__kata)/2); // Jika ada balik
			}
			$__kata = preg_replace('/(konna)$/i','',$kata);
			if(cekKamus($__kata)){ // Cek Kamus
			$rules[] = '-kon + -na';
			return $__kata;
			}
			$__kata = preg_replace('/(kononna)$/i','',$kata);
			if(cekKamus($__kata)){ // Cek Kamus
			$rules[] = '-kon + -on + -na';
			return $__kata;
			}
			$__kata = preg_replace('/(hononna)$/i','',$kata);
			if(cekKamus($__kata)){ // Cek Kamus
			$rules[] = '-hon + -on + -na';
			return $__kata;
			}
			$__kata = preg_replace('/(muna)$/i','',$kata);
			if(cekKamus($__kata)){ // Cek Kamus	
			$rules[] = '-muna';
			return $__kata;
			}else if (substr($__kata,0,strlen($__kata)/2-1) == substr($__kata,strlen($__kata)/2,strlen($__kata)/2-1)  && cekKamus(substr($__kata,strlen($__kata)/2))) { //penggandaan kata dasar
				$rules[] = 'kata dasa x 2';
				return substr($__kata,strlen($__kata)/2); // Jika ada balik
			}	
			$__kata = preg_replace('/(onmuna)$/i','',$kata);
			if(cekKamus($__kata)){ // Cek Kamus	
			$rules[] = '-on + -muna';
			return $__kata;
			}
			$__kata = preg_replace('/(kononmuna)$/i','',$kata);
			if(cekKamus($__kata)){ // Cek Kamus	
			$rules[] = '-kon + -on + -muna';
			return $__kata;
			}
			$__kata = preg_replace('/(honmuna)$/i','k',$kata);
			if(cekKamus($__kata)){ // Cek Kamus	
			$rules[] = '-hon + -muna';
			return $__kata;
			}
			$__kata = preg_replace('/(honmuna)$/i','',$kata);
			if(cekKamus($__kata)){ // Cek Kamus	
			$rules[] = '-hon + -muna';
			return $__kata;
			}
			$__kata = preg_replace('/(hanmuna)$/i','',$kata);
			if(cekKamus($__kata)){ // Cek Kamus	
			$rules[] = '-han + -muna';
			return $__kata;
			}
			$__kata = preg_replace('/(hanna)$/i','',$kata);
			if(cekKamus($__kata)){ // Cek Kamus	
			$rules[] = '-han + -na';
			return $__kata;
			}
			$__kata = preg_replace('/(anmuna)$/i','',$kata);
			if(cekKamus($__kata)){ // Cek Kamus	
			$rules[] = '-an + -muna';
			return $__kata;
			}else if (substr($__kata,0,strlen($__kata)/2) == substr($__kata,strlen($__kata)/2)  && cekKamus(substr($__kata,0,strlen($__kata)/2))) { //penggandaan kata dasar
				$rules[] = 'kata dasa x 2';
				return substr($__kata,0,strlen($__kata)/2); // Jika ada balik
			}
			$__kata = preg_replace('/(muna)$/i','',$kata);
			if(cekKamus($__kata)){ // Cek Kamus	
			$rules[] = '-muna';
			return $__kata;
			}else if(substr($__kata,1,2) =='in' && cekKamus(substr($__kata,0,1).substr($__kata, 3))) { //sisipan -in-
				$rules[] = '-in-';
				return substr($__kata,0,1).substr($__kata, 3); // Jika ada balik
			}
			$__kata = preg_replace('/(hononmuna)$/i','',$kata);
			if(cekKamus($__kata)){ // Cek Kamus	
			$rules[] = '-hon + -on + -muna';
			return $__kata;
			}
			$__kata = preg_replace('/(anhononmuna)$/i','',$kata);
			if(cekKamus($__kata)){ // Cek Kamus	
			$rules[] = '-an + -hon + -on + -muna';
			return $__kata;
			}
		}
	/*-----------------end kata dengan akhiran na---------------------*/
		if(preg_match('/(nasida)$/i',$kata)){ // Cek Inflection Suffixes
			$rules[] = '-nasida ';
			$__kata = preg_replace('/(nasida)$/i','',$kata);			
			if(preg_match('/(nasida)$/i',$kata)){ // Jika berupa particles (“-lah”, “-kah”, “-tah” atau “-pun”)
				if(preg_match('/(kon|on)$/i',$__kata)){ // Hapus Possesive Pronouns (“-ku”, “-mu”, atau “-nya”)
					$rules[] = '-kon';
					$__kata__ = preg_replace('/(kon|on)$/i','',$__kata);
					return $__kata__;
				}
			}
			return $__kata;	
		}
		if(preg_match('/(ku)$/i',$kata)){ // Cek Inflection Suffixes
			$rules[] = '-ku';
			$__kata = preg_replace('/(ku)$/i','',$kata);			
			if(preg_match('/(ku)$/i',$kata)){ // Jika berupa particles (“-lah”, “-kah”, “-tah” atau “-pun”)
				if(preg_match('/(on)$/i',$__kata)){ // Hapus Possesive Pronouns (“-ku”, “-mu”, atau “-nya”)
					$rules[] = '-on';
					$__kata__ = preg_replace('/(on)$/i','',$__kata);
					return $__kata__;
				}
			}
			return $__kata;	
		}
	
		if(preg_match('/(hu)$/i',$kata)){
			$__kata = preg_replace('/(hu)$/i','',$kata);		
			if(cekKamus($__kata)){ // Cek Kamus			
				$rules[] = '-hu';
				return $__kata;
			}
		}
	/*-----------------start kata dengan akhiran on---------------------*/
		if(preg_match('/(on)$/i',$kata)){
			$__kata = preg_replace('/(on)$/i','',$kata);		
			if(cekKamus($__kata)){ // Cek Kamus			
				$rules[] = '-on';
				return $__kata;
			}else if (substr($__kata,1,2) == 'in' && cekKamus(substr($__kata,0,1).substr($__kata, 3))) {
				$rules[] = '-in-';
				return substr($__kata,0,1).substr($__kata, 3); // Jika ada balik
			}else if (substr($__kata,0,strlen($__kata)/2) == substr($__kata,strlen($__kata)/2)  && cekKamus(substr($__kata,0,strlen($__kata)/2))) { //penggandaan kata dasar
				$rules[] = 'kata dasa x 2';
				return substr($__kata,0,strlen($__kata)/2); // Jika ada balik
			}			
			$__kata__ = preg_replace('/(hon)$/i','',$kata);
			if(cekKamus($__kata__)){ // Cek Kamus
				$rules [] = '-hon';
				return $__kata__;
			}else if (substr($__kata__,1,2) == 'in' && cekKamus(substr($__kata__,0,1).substr($__kata__, 3))) {
				$rules[] = '-in-';
				return substr($__kata__,0,1).substr($__kata__, 3); // Jika ada balik
			}else if (substr($__kata__,1,2) == 'um' && cekKamus(substr($__kata__,0,1).substr($__kata__, 3))) {
				$rules[] = '-um-';
				return substr($__kata__,0,1).substr($__kata__, 3); // Jika ada balik
			}else if (substr($__kata__,0,strlen($__kata__)/2) == substr($__kata__,strlen($__kata__)/2)  && cekKamus(substr($__kata__,0,strlen($__kata__)/2))) { //penggandaan kata dasar
				$rules[] = 'kata dasa x 2';
				return substr($__kata__,0,strlen($__kata__)/2); // Jika ada balik
			}
			$__kata = preg_replace('/(hononhon)$/i','',$kata);		
			if(cekKamus($__kata)){ // Cek Kamus			
				$rules[] = '-hon + -on + -hon';
				return $__kata;
			}			
			$__kata__ = preg_replace('/(hon)$/i','k',$kata);
			if(cekKamus($__kata__)){ // Cek Kamus
				$rules [] = '-hon -> k ';
				return $__kata__;
			}				
			$__kata__ = preg_replace('/(kononhon)$/i','',$kata);
			if(cekKamus($__kata__)){ // Cek Kamus
				$rules [] = '-kon + -on + -hon';
				return $__kata__;
			}				
			$__kata__ = preg_replace('/(konon)$/i','',$kata);
			if(cekKamus($__kata__)){ // Cek Kamus
				$rules [] = '-kon + -on';
				return $__kata__;
			}				
			$__kata__ = preg_replace('/(honon)$/i','',$kata);
			if(cekKamus($__kata__)){ // Cek Kamus
				$rules [] = '-hon + -on';
				return $__kata__;
			}				
			$__kata__ = preg_replace('/(ion)$/i','',$kata);
			if(cekKamus($__kata__)){ // Cek Kamus
				$rules [] = '-i + -on';
				return $__kata__;
			}			
			$__kata__ = preg_replace('/(kon)$/i','',$kata);
			if(cekKamus($__kata__)){ // Cek Kamus
				$rules [] = '-kon';
				return $__kata__;
			}
		}
	/*-----------------end kata dengan akhiran on---------------------*/
	/*-----------------start kata dengan akhiran sa---------------------*/
		if(preg_match('/(sa)$/i',$kata)){
			$__kata = preg_replace('/(sa)$/i','',$kata);		
			if(cekKamus($__kata)){ // Cek Kamus			
				$rules[] = '-sa';
				return $__kata;
			}else if (substr($__kata,1,2) == 'in' && cekKamus(substr($__kata,0,1).substr($__kata, 3))) {
				$rules[] = '-in-';
				return substr($__kata,0,1).substr($__kata, 3); // Jika ada balik
			}else if (substr($__kata,0,strlen($__kata)/2) == substr($__kata,strlen($__kata)/2)  && cekKamus(substr($__kata,0,strlen($__kata)/2))) { //penggandaan kata dasar
				$rules[] = 'kata dasa x 2';
				return substr($__kata,0,strlen($__kata)/2); // Jika ada balik
			}				
			$__kata__ = preg_replace('/(hisa)$/i','k',$kata);
			if(cekKamus($__kata__)){ // Cek Kamus
				$rules [] = '-hisa -> k';
				return $__kata__;
			}				
			$__kata__ = preg_replace('/(isa)$/i','',$kata);
			if(cekKamus($__kata__)){ // Cek Kamus
				$rules [] = '-isa';
				return $__kata__;
			}				
			$__kata__ = preg_replace('/(honsa)$/i','',$kata);
			if(cekKamus($__kata__)){ // Cek Kamus
				$rules [] = '-hon + -sa';
				return $__kata__;
			}				
			$__kata__ = preg_replace('/(konsa)$/i','',$kata);
			if(cekKamus($__kata__)){ // Cek Kamus
				$rules [] = '-kon + -sa';
				return $__kata__;
			}
		}
	/*-----------------end kata dengan akhiran sa---------------------*/
		/*-- Jika Tidak ditemukan di kamus --*/
		if(preg_match('/(kan)$/i',$kata)){ // cek -kan 				
			$__kata__ = preg_replace('/(kan)$/i','',$kata);
			if(cekKamus($__kata__)){ // Cek Kamus
				$rules [] = '-kan';
				return $__kata__;
			}
		}

	return $kataAsal;		
}


// Hapus Derivation Prefix (“di-”, “ke-”, “se-”, “te-”, “be-”, “me-”, atau “pe-”)
function Hapus_Awalan($kata){
	global $rules;
	
	$kataAsal = $kata;		
		$__kata = $kata;
		if(substr($__kata,0,strlen($__kata)/2) == substr($__kata,strlen($__kata)/2)  && cekKamus(substr($__kata,0,strlen($__kata)/2))) { //penggandaan kata dasar
				$rules[] = 'kata dasar x 2';
				return substr($__kata,0,strlen($__kata)/2); // Jika ada balik
		}
		$__kata__ = Hapus_Akhiran($__kata);
		if(cekKamus($__kata__)){
			return $__kata__;
		}
		$__kata = $kata;
		if(substr($__kata,1,strlen($__kata)/2-1) == substr($__kata,strlen($__kata)/2+1)  && cekKamus(substr($__kata,0,strlen($__kata)/2))) { //penggandaan kata dasar
				$rules[] = 'kata dasar x 2';
				return substr($__kata,0,strlen($__kata)/2); // Jika ada balik
		}	
	if(preg_match('/^(di|s[aio])/i',$kata)){ // Jika di-,sa-,si-
		$__kata = preg_replace('/^(di|s[aio])/i','',$kata); //aturan bahasa batak
		if(cekKamus($__kata)){
			$rules[] = 'di-|sa-|si-|so-';
			return $__kata; // Jika ada balik
		}else if(substr($__kata,0,strlen($__kata)/2) == substr($__kata,strlen($__kata)/2)  && cekKamus(substr($__kata,0,strlen($__kata)/2))) { //penggandaan kata dasar
			$rules[] = 'kata dasar x 2 ';
			return substr($__kata,0,strlen($__kata)/2); // Jika ada balik
		}
		$__kata__ = Hapus_Akhiran($__kata);
		if(cekKamus($__kata__)){
			return $__kata__;
		}
		$__kata = preg_replace('/^(diha)/i','',$kata); // aturan 30. bahasa batak
		if(cekKamus($__kata)){
			$rules[] = 'di- + ha-';
			return $__kata; // Jika ada balik
		}
		$__kata__ = Hapus_Akhiran($__kata);
		if(cekKamus($__kata__)){
			return $__kata__;
		}
		$__kata = preg_replace('/^(dipang)/i','',$kata); // aturan 30. bahasa batak
		if(cekKamus($__kata)){
			$rules[] = 'dipang- ';
			return $__kata; // Jika ada balik
		}
		$__kata__ = Hapus_Akhiran($__kata);
		if(cekKamus($__kata__)){
			return $__kata__;
		}
		$__kata = preg_replace('/^(dipangk)/i','h',$kata); // aturan 30. bahasa batak
		if(cekKamus($__kata)){
			$rules[] = 'dipangk- -> h';
			return $__kata; // Jika ada balik
		}
		$__kata__ = Hapus_Akhiran($__kata);
		if(cekKamus($__kata__)){
			return $__kata__;
		}
		$__kata = preg_replace('/^(sima)/i','',$kata); // aturan 30. bahasa batak
		if(cekKamus($__kata)){
			$rules[] = 'si- + ma-';
			return $__kata; // Jika ada balik
		}
		$__kata__ = Hapus_Akhiran($__kata);
		if(cekKamus($__kata__)){
			return $__kata__;
		}
		$__kata = preg_replace('/^(sam)/i','',$kata); // aturan 30. bahasa batak
		if(cekKamus($__kata)){
			$rules[] = 'sam- ';
			return $__kata; // Jika ada balik
		}
		$__kata__ = Hapus_Akhiran($__kata);
		if(cekKamus($__kata__)){
			return $__kata__;
		}
		$__kata = preg_replace('/^(sodi)/i','',$kata); // aturan 30. bahasa batak
		if(cekKamus($__kata)){
			$rules[] = 'sodi- ';
			return $__kata; // Jika ada balik
		}
		$__kata__ = Hapus_Akhiran($__kata);
		if(cekKamus($__kata__)){
			return $__kata__;
		}
		$__kata = preg_replace('/^(san)/i','',$kata); // aturan 30. bahasa batak
		if(cekKamus($__kata)){
			$rules[] = 'san-';
			return $__kata; // Jika ada balik
		}
		$__kata__ = Hapus_Akhiran($__kata);
		if(cekKamus($__kata__)){
			return $__kata__;
		}
		$__kata = preg_replace('/^(sipa)/i','',$kata); // aturan 30. bahasa batak
		if(cekKamus($__kata)){
			$rules[] = 'si- + pa-';
			return $__kata; // Jika ada balik
		}
		$__kata__ = Hapus_Akhiran($__kata);
		if(cekKamus($__kata__)){
			return $__kata__;
		}
		$__kata = preg_replace('/^(sipar)/i','',$kata); // aturan 30. bahasa batak
		if(cekKamus($__kata)){
			$rules[] = 'si- + par- ';
			return $__kata; // Jika ada balik
		}
		$__kata__ = Hapus_Akhiran($__kata);
		if(cekKamus($__kata__)){
			return $__kata__;
		}
		$__kata = preg_replace('/^(siparsa)/i','',$kata); // aturan 30. bahasa batak
		if(cekKamus($__kata)){
			$rules[] = 'si- + par- + sa- ';
			return $__kata; // Jika ada balik
		}
		$__kata__ = Hapus_Akhiran($__kata);
		if(cekKamus($__kata__)){
			return $__kata__;
		}
		$__kata = preg_replace('/^(siha)/i','',$kata); // aturan 30. bahasa batak
		if(cekKamus($__kata)){
			$rules[] = 'si- + ha-';
			return $__kata; // Jika ada balik
		}
		$__kata__ = Hapus_Akhiran($__kata);
		if(cekKamus($__kata__)){
			return $__kata__;
		}
		$__kata = preg_replace('/^(sapang)/i','',$kata); // aturan 30. bahasa batak
		if(cekKamus($__kata)){
			$rules[] = 'sa- + pang-';
			return $__kata; // Jika ada balik
		}
		$__kata__ = Hapus_Akhiran($__kata);
		if(cekKamus($__kata__)){
			return $__kata__;
		}
		$__kata = preg_replace('/^(sapangk)/i','h',$kata); // aturan 30. bahasa batak
		if(cekKamus($__kata)){
			$rules[] = '^sa- + pangk- -> h';
			return $__kata; // Jika ada balik
		}
		$__kata__ = Hapus_Akhiran($__kata);
		if(cekKamus($__kata__)){
			return $__kata__;
		}
		$__kata = preg_replace('/^(simanga)/i','',$kata); // aturan 30. bahasa batak
		if(cekKamus($__kata)){
			$rules[] = 'si- + manga-';
			return $__kata; // Jika ada balik
		}
		$__kata__ = Hapus_Akhiran($__kata);
		if(cekKamus($__kata__)){
			return $__kata__;
		}
		$__kata = preg_replace('/^(dipa)/i','',$kata); // aturan 23. bahasa batak
		if(cekKamus($__kata)){
			$rules[] = 'di- + pa-';
			return $__kata; // Jika ada balik
		}else if (substr($__kata,0,strlen($__kata)/2) == substr($__kata,strlen($__kata)/2)  && cekKamus(substr($__kata,0,strlen($__kata)/2))) { //penggandaan kata dasar
			$rules[] = 'kata dasar x 2';
			return substr($__kata,0,strlen($__kata)/2); // Jika ada balik
		}
		$__kata__ = Hapus_Akhiran($__kata);
		if(cekKamus($__kata__)){
			return $__kata__;
		}
		$__kata = preg_replace('/^(dipar)/i','',$kata);
		if(cekKamus($__kata)){
			$rules[] = 'di- + par-';
			return $__kata; // Jika ada balik
		}
		$__kata__ = Hapus_Akhiran($__kata);
		if(cekKamus($__kata__)){
			return $__kata__;
		}
	}


	if(preg_match('/^([hpn][aiu])/i',$kata)){ // Jika hi-,pi,ni-,ha-,pa-,na-, hu-
			if(preg_match('/^(ha)/i',$kata)){ // Jika -ha 
				$__kata = preg_replace('/^(ha)/i','',$kata); // aturan 11. bahasa batak
				if(cekKamus($__kata)){
					$rules[] = 'ha-';
					return $__kata; // Jika ada balik
				}else if (substr($__kata,0,2) == substr($__kata,2,2) && cekKamus(substr($__kata, 2))) {
					$rules[] = 'ha- + sukukata 1';
					return substr($__kata, 2); // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
			}
			if(preg_match('/^(hi)/i',$kata)){ // Jika -ha 
				$__kata = preg_replace('/^(hi)/i','',$kata); // aturan 11. bahasa batak
				if(cekKamus($__kata)){
					$rules[] = 'hi-';
					return $__kata; // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
			}
			if(preg_match('/^(na)/i',$kata)){ // Jika -ha 
				$__kata = preg_replace('/^(na)/i','',$kata); // aturan 11. bahasa batak
				if(cekKamus($__kata)){
					$rules[] = 'na-';
					return $__kata; // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
				$__kata = preg_replace('/^(napa)/i','',$kata); // aturan 11. bahasa batak
				if(cekKamus($__kata)){
					$rules[] = 'napa-';
					return $__kata; // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
			}
			if(preg_match('/^(hu)/i',$kata)){ // Jika -ha 
				$__kata = preg_replace('/^(hu)/i','',$kata); // aturan 11. bahasa batak
				if(cekKamus($__kata)){
					$rules[] = 'hu-';
					return $__kata; // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
					if(cekKamus($__kata__)){
						return $__kata__;
				}
				$__kata = preg_replace('/^(hupa)/i','',$kata); // aturan 11. bahasa batak
				if(cekKamus($__kata)){
					$rules[] = 'hu- + pa- ';
					return $__kata; // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
					if(cekKamus($__kata__)){
						return $__kata__;
				}

				$__kata = preg_replace('/^(hum)/i','',$kata); // aturan 11. bahasa batak
				if(cekKamus($__kata)){
					$rules[] = 'hum- ';
					return $__kata; // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
					if(cekKamus($__kata__)){
						return $__kata__;
				}
				$__kata = preg_replace('/^(huma)/i','',$kata); // aturan 11. bahasa batak
				if(cekKamus($__kata)){
					$rules[] = 'hu- + ma- ';
					return $__kata; // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
					if(cekKamus($__kata__)){
						return $__kata__;
				}
			}
			if(preg_match('/^(ni)\S{1,}/',$kata)){ // aturan 17. bahasa batak
				$__kata = preg_replace('/^(ni)/','',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'ni- ';
					return $__kata; // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
			}
			if(preg_match('/^(hina)\S{1,}/',$kata)){ // aturan 18. bahasa batak
				$__kata = preg_replace('/^(hina)/','',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'hina-';
					return $__kata; // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
			}
			if(preg_match('/^(pina)\S{1,}/',$kata)){ // aturan 17. bahasa batak
				$__kata = preg_replace('/^(pina)/','',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'pina-';
					return $__kata; // Jika ada balik
				}
				else if (substr($__kata,0,strlen($__kata)/2) == substr($__kata,strlen($__kata)/2)  && cekKamus(substr($__kata,0,strlen($__kata)/2))) { //penggandaan kata dasar
					$rules[] = 'kata dasar x 2';
					return substr($__kata,0,strlen($__kata)/2); // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
			}
	}

	if(preg_match('/^(ni|[tmbpn][aui])/i',$kata)){ //Jika awalannya adalah “te-”, “ma-”, “be-”, atau “pe-”
	/*------------ Awalan “be-”, ---------------------------------------------*/
		if(preg_match('/^(panga)[l]\S{1,}/',$kata)){ // aturan 22. bahasa batak
				$__kata = preg_replace('/^(panga)/','',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'panga-';
					return $__kata; // Jika ada balik
				}else if (substr($__kata,0,strlen($__kata)/2) == substr($__kata,strlen($__kata)/2)  && cekKamus(substr($__kata,0,strlen($__kata)/2))) { //penggandaan kata dasar
					$rules[] = 'kata dasar x 2';
					return substr($__kata,0,strlen($__kata)/2); // Jika ada balik
			}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
		}
		if(preg_match('/^(tuma)\S{1,}/',$kata)){ // aturan 29. bahasa batak
				$__kata = preg_replace('/^(tuma)/','',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'tu- + ma- ';
					return $__kata; // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
		}
		if(preg_match('/^(tinar)\S{1,}/',$kata)){ // aturan 29. bahasa batak
				$__kata = preg_replace('/^(tinar)/','',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'tinar-';
					return $__kata; // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
		}
/*------------ Awalan “tar-”, ---------------------------------------------*/
		if(preg_match('/^(tar)\S{1,}/',$kata)){ // Jika awalan “tar-”,
			if(preg_match('/^(tar)\S{1,}/',$kata)){ // aturan 6.
				$__kata = preg_replace('/^(tar)/','',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'tar-';
					return $__kata; // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
				$__kata = preg_replace('/^(tarha)/','',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'tar- + ha-';
					return $__kata; // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
				$__kata = preg_replace('/^(tarpar)/','',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'tar- + par- ';
					return $__kata; // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
				$__kata = preg_replace('/^(tarpa)/','',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'tar- + pa-';
					return $__kata; // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
			}
		}
		/*------------end “tar-”, ---------------------------------------------*/		
		/*------------ Awalan “ma-”, ---------------------------------------------*/
		if(preg_match('/^(ma)\S{1,}/',$kata)){ // Jika awalan “ma-”,

			if(preg_match('/^(mam)/',$kata)){
				$__kata = preg_replace('/^(mam)/','b',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'mam- -> b';
					return $__kata; // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
			}
			if(preg_match('/^(ma)/',$kata)){ // aturan bahasa batak 10
				$__kata = preg_replace('/^(ma)/','',$kata);
				if(cekKamus($__kata)){
					$rules[] = 'ma- ';
					return $__kata; // Jika ada balik
				}				
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
				$__kata = preg_replace('/^(mam)/','',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'mam-';
					return $__kata; // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
			}	
			if(preg_match('/^(man)[cdjnz]\S{1,}/',$kata)){ // aturan 12. bahasa batak
				$__kata = preg_replace('/^(man)/','',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'man- ';
					return $__kata; // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
			}
			if(preg_match('/^(mang)[aiueoghkw]\S{1,}/',$kata)){ // aturan 11. bahasa batak
				$__kata = preg_replace('/^(mang)/','',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'mang-';
					return $__kata; // Jika ada balik
				}else if (substr($__kata,0,strlen($__kata)/2-1) == substr($__kata,strlen($__kata)/2,strlen($__kata)/2-1)  && cekKamus(substr($__kata,strlen($__kata)/2))) { //penggandaan kata dasar
				$rules[] = 'kata dasar x 2';
				return substr($__kata,strlen($__kata)/2); // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
				$__kata = preg_replace('/^(mangk)/','h',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'mangk- -> h ';
					return $__kata; // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
				$__kata = preg_replace('/^(mangha)/','',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'mang- + ha-';
					return $__kata; // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
			}
			if(preg_match('/^(mam)\S{1,}/',$kata)){ // aturan 13. bahasa batak
				$__kata = preg_replace('/^(mam)/','p',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'mam- -> p ';
					return $__kata; // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
			}
			if(preg_match('/^(manga)[blr]\S{1,}/',$kata)){ // aturan 15. bahasa batak
				$__kata = preg_replace('/^(manga)/','',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'manga-';
					return $__kata; // Jika ada balik
				}
				else if (substr($__kata,0,strlen($__kata)/2) == substr($__kata,strlen($__kata)/2)  && cekKamus(substr($__kata,0,strlen($__kata)/2))) { //penggandaan kata dasar
					$rules[] = 'kata dasar x 2';
					return substr($__kata,0,strlen($__kata)/2); // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
			}
			if (preg_match('/^(man)\S{1,}/',$kata)){//aturan 14. bahasa batak				
				$__kata = preg_replace('/^(man)/','s',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'man- -> s';
					return $__kata; // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
				$__kata = preg_replace('/^(man)/','t',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'man- -> t';
					return $__kata; // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
			}
			
			if(preg_match('/^(mar)\S{1,}/',$kata)){ // aturan 20 bahasa batak
				$__kata = preg_replace('/^(mar)/','',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'mar- ';
					return $__kata; // Jika ada balik
				}else if (substr($__kata,1,2) == 'in' && cekKamus(substr($__kata,0,1).substr($__kata, 3))) {
					$rules[] = 'mar- + -in-';
					return substr($__kata,0,1).substr($__kata, 3); // Jika ada balik
				}else if (substr($__kata,1,2) == 'ar' && cekKamus(substr($__kata,0,1).substr($__kata, 3))) {
					$rules[] = 'mar- + -ar-';
					return substr($__kata,0,1).substr($__kata, 3); // Jika ada balik
				}else if (substr($__kata,0,strlen($__kata)/2) == substr($__kata,strlen($__kata)/2)  && cekKamus(substr($__kata,0,strlen($__kata)/2))) { //penggandaan kata dasar
					$rules[] = 'kata dasar x 2';
					return substr($__kata,0,strlen($__kata)/2); // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
			}
			if(preg_match('/^(marsi)\S{1,}/',$kata)){ // aturan 20.1 bahasa batak
				$__kata = preg_replace('/^(marsi)/','',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'marsi-';
					return $__kata; // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
			}

			if(preg_match('/^(marna)\S{1,}/',$kata)){ // aturan 20.2 bahasa batak
				$__kata = preg_replace('/^(marna)/','',$kata);
				if(cekKamus($__kata)){			
					$rules[] = '^marna -> ';
					return $__kata; // Jika ada balik
				}else if (substr($__kata,1,2) == 'um' && cekKamus(substr($__kata,0,1).substr($__kata, 3))) {
					$rules[] = 'mar- + na- + -um-';
					return substr($__kata,0,1).substr($__kata, 3); // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
			}
			if(preg_match('/^(marni)\S{1,}/',$kata)){ // aturan 20.3 bahasa batak
				$__kata = preg_replace('/^(marni)/','',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'marni-';
					return $__kata; // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
			}
			if(preg_match('/^(marha)\S{1,}/',$kata)){ // aturan 20.5 bahasa batak
				$__kata = preg_replace('/^(marha)/','',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'mar- + ha-';
					return $__kata; // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
			}
			if(preg_match('/^(marpanga)\S{1,}/',$kata)){ // aturan 20.5 bahasa batak
				$__kata = preg_replace('/^(marpanga)/','',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'mar- + panga-';
					return $__kata; // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
			}
			if(preg_match('/^(marsa)\S{1,}/',$kata)){ // aturan 20.1 bahasa batak
				$__kata = preg_replace('/^(marsa)/','',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'mar- + sa-';
					return $__kata; // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
			}
			if(preg_match('/^(masi)\S{1,}/',$kata)){ // aturan 10.3 bahasa batak
				$__kata = preg_replace('/^(masi)/','',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'masi- ';
					return $__kata; // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
			}
			if(preg_match('/^(masipa)\S{1,}/',$kata)){ // aturan 10.3 bahasa batak
				$__kata = preg_replace('/^(masipa)/','',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'masipa-';
					return $__kata; // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
			}
			if(preg_match('/^(masiha)\S{1,}/',$kata)){ // aturan 10.3 bahasa batak
				$__kata = preg_replace('/^(masiha)/','',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'masiha- ';
					return $__kata; // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
			}
			if(preg_match('/^(mansi)\S{1,}/',$kata)){ // aturan 10.3 bahasa batak
				$__kata = preg_replace('/^(mansi)/','',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'mansi- ';
					return $__kata; // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
			}
			if(preg_match('/^(mampar)\S{1,}/',$kata)){ // aturan 16 bahasa batak
				$__kata = preg_replace('/^(mampar)/','',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'mam- + par-';
					return $__kata; // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
			}
		}

		/*------------end “ma-”, ---------------------------------------------*/		
/*------------ Awalan “pa-”, ---------------------------------------------*/
		if(preg_match('/^(pa)\S{1,}/',$kata)){ // Jika awalan “pa-”,
			if(preg_match('/^(pa)\S{1,}/',$kata)){ // aturan 20.
				$__kata = preg_replace('/^(pa)/','',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'pa-';
					return $__kata; // Jika ada balik
				}else if (substr($__kata,0,strlen($__kata)/2) == substr($__kata,strlen($__kata)/2)  && cekKamus(substr($__kata,0,strlen($__kata)/2))) { //penggandaan kata dasar
					$rules[] = 'kata dasar x 2';
					return substr($__kata,0,strlen($__kata)/2); // Jika ada balik
				}				
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
				$__kata = preg_replace('/^(pai)/','',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'pai-';
					return $__kata; // Jika ada balik
				}				
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
				$__kata = preg_replace('/^(pam)/','',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'pam- ';
					return $__kata; // Jika ada balik
				}				
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
				$__kata = preg_replace('/^(pana)/','',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'pana- ';
					return $__kata; // Jika ada balik
				}				
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
				$__kata = preg_replace('/^(pang)/','',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'pang- ';
					return $__kata; // Jika ada balik
				}				
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
				$__kata = preg_replace('/^(pam)/','p',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'pam- -> p ';
					return $__kata; // Jika ada balik
				}				
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}				
			}
			if (preg_match('/^(pan)\S{1,}/',$kata)){//aturan 14. bahasa batak				
				$__kata = preg_replace('/^(pan)/','s',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'pan- -> s';
					return $__kata; // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
				$__kata = preg_replace('/^(pan)/','t',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'pan- -> t';
					return $__kata; // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
				$__kata = preg_replace('/^(pan)/','',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'pan- ';
					return $__kata; // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
			}
			if(preg_match('/^(par)\S{1,}/',$kata)){ // aturan 20.
				$__kata = preg_replace('/^(par)/','',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'par-';
					return $__kata; // Jika ada balik
				}
				else if (substr($__kata,1,2) == 'in' && cekKamus(substr($__kata,0,1).substr($__kata, 3))) {
					$rules[] = 'par- + -in-';
					return substr($__kata,0,1).substr($__kata, 3); // Jika ada balik
				}else if (substr($__kata,1,2) == 'ar' && cekKamus(substr($__kata,0,1).substr($__kata, 3))) {
					$rules[] = 'par- + -ar-';
					return substr($__kata,0,1).substr($__kata, 3); // Jika ada balik
				}else if (substr($__kata,0,strlen($__kata)/2) == substr($__kata,strlen($__kata)/2)  && cekKamus(substr($__kata,0,strlen($__kata)/2))) { //penggandaan kata dasar
					$rules[] = 'kata dasar x 2 ';
					return substr($__kata,0,strlen($__kata)/2); // Jika ada balik
				}				
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}
				$__kata = preg_replace('/^(parsa)/','',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'parsa-';
					return $__kata; // Jika ada balik
				}
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}			
			}
			if(preg_match('/^(panga)[lr]\S{1,}/',$kata)){ // aturan 20.
				$__kata = preg_replace('/^(panga)/','',$kata);
				if(cekKamus($__kata)){			
					$rules[] = 'panga-';
					return $__kata; // Jika ada balik
				}				
				$__kata__ = Hapus_Akhiran($__kata);
				if(cekKamus($__kata__)){
					return $__kata__;
				}				
			}
		}
	}
		/*------------end “pe-”, ---------------------------------------------*/	
/*----------------------- Awalan “um-”, ---------------------------------------*/
	if(preg_match('/^(um)\S{1,}/',$kata)){ // Jika awalan “ma-”,
		if(preg_match('/^(um)/',$kata)){ // aturan bahasa batak 10
			$__kata = preg_replace('/^(um)/','',$kata);
			if(cekKamus($__kata)){
				$rules[] = 'um-';
				return $__kata; // Jika ada balik
			}else if (substr($__kata,0,strlen($__kata)/2) == substr($__kata,strlen($__kata)/2)  && cekKamus(substr($__kata,0,strlen($__kata)/2))) { //penggandaan kata dasar
				$rules[] = '^kata dasar x 2';
				return substr($__kata,0,strlen($__kata)/2); // Jika ada balik
			}		
			$__kata__ = Hapus_Akhiran($__kata);
			if(cekKamus($__kata__)){
				return $__kata__;
			}
		}
		if(preg_match('/^(umpa)/',$kata)){ // aturan bahasa batak 10
			$__kata = preg_replace('/^(umpa)/','',$kata);
			if(cekKamus($__kata)){
				$rules[] = 'um- + pa-';
				return $__kata; // Jika ada balik
			}				
			$__kata__ = Hapus_Akhiran($__kata);
			if(cekKamus($__kata__)){
				return $__kata__;
			}
		}
	}
/*---------------------------end "um"----------------------------------------*/
/*---------------------sisipn-----------------------------*/		

	if(preg_match('/^([^aiueo](in|um|ar|al))/i',$kata)){ // Jika -in-	
		$__kata = $kata;
		if(substr($__kata,1,2) =='in' && cekKamus(substr($__kata,0,1).substr($__kata, 3))) { //sisipan -in-
				$rules[] = '-in- ';
				return substr($__kata,0,1).substr($__kata, 3); // Jika ada balik
		}
		$__kata__ = Hapus_Akhiran($__kata);
		if(cekKamus($__kata__)){
			return $__kata__;
		}
		$__kata = $kata;
		if(substr($__kata,1,4) =='inar' && cekKamus(substr($__kata,0,1).substr($__kata, 5))) { //sisipan -in-
				$rules[] = '^in^ + -ar- -> ';
				return substr($__kata,0,1).substr($__kata, 5); // Jika ada balik
		}
		$__kata__ = Hapus_Akhiran($__kata);
		if(cekKamus($__kata__)){
			return $__kata__;
		}
		$__kata = $kata;
		if(substr($__kata,1,4) =='inal' && cekKamus(substr($__kata,0,1).substr($__kata, 5))) { //sisipan -in-
				$rules[] = '-in- + -al-';
				return substr($__kata,0,1).substr($__kata, 5); // Jika ada balik
		}
		$__kata__ = Hapus_Akhiran($__kata);
		if(cekKamus($__kata__)){
			return $__kata__;
		}
		$__kata = $kata;
		if(substr($__kata,1,2) =='um' && cekKamus(substr($__kata,0,1).substr($__kata, 3))) { //sisipan -um-
				$rules[] = '-um-';
				return substr($__kata,0,1).substr($__kata, 3); // Jika ada balik
				$__kata2 = substr($__kata,0,1).substr($__kata, 3);

		}$__kata2 = substr($__kata,0,1).substr($__kata, 3);
		if (substr($__kata2,0,strlen($__kata2)/2) == substr($__kata2,strlen($__kata2)/2)  && cekKamus(substr($__kata2,0,strlen($__kata2)/2))) { //penggandaan kata dasar
				$rules[] = '^kata dasar x 2';
				return substr($__kata2,0,strlen($__kata2)/2); // Jika ada balik
		}
		$__kata__ = Hapus_Akhiran($__kata);
		if(cekKamus($__kata__)){
			return $__kata__;
		}
		$__kata = $kata;
		if(substr($__kata,1,4) =='umar' && cekKamus(substr($__kata,0,1).substr($__kata, 5))) { //sisipan -in-
				$rules[] = '-um- + -ar-';
				return substr($__kata,0,1).substr($__kata, 5); // Jika ada balik
		}
		$__kata__ = Hapus_Akhiran($__kata);
		if(cekKamus($__kata__)){
			return $__kata__;
		}
		$__kata = $kata;
		if(substr($__kata,1,4) =='umal' && cekKamus(substr($__kata,0,1).substr($__kata, 5))) { //sisipan -in-
				$rules[] = '-um- + -al-';
				return substr($__kata,0,1).substr($__kata, 5); // Jika ada balik
		}
		$__kata__ = Hapus_Akhiran($__kata);
		if(cekKamus($__kata__)){
			return $__kata__;
		}
		$__kata = $kata;
		if(substr($__kata,1,2) =='al' && cekKamus(substr($__kata,0,1).substr($__kata, 3))) { //sisipan -al-
				$rules[] = '-al-';
				return substr($__kata,0,1).substr($__kata, 3); // Jika ada balik
		}
		$__kata__ = Hapus_Akhiran($__kata);
		if(cekKamus($__kata__)){
			return $__kata__;
		}
		$__kata = $kata;
		if(substr($__kata,1,2) =='ar' && cekKamus(substr($__kata,0,1).substr($__kata, 3))) { //sisipan -ar-
				$rules[] = '-ar- ';
				return substr($__kata,0,1).substr($__kata, 3); // Jika ada balik
		}
		$__kata__ = Hapus_Akhiran($__kata);
		if(cekKamus($__kata__)){
			return $__kata__;
		}
	}
	/*--------------------end sisipan------------------------*/
	
	return $kataAsal;
}
?>