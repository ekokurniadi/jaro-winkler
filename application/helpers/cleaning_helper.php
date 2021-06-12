<?php

function cleaningWords($text){
    
    $a = preg_replace('/\W/', '', $text);
    $b = preg_replace('/(@)+([A-Za-z0-9-_.]+)/i', '', $a);
    
    //remove hashtag------------------------------------------------
    $c = preg_replace('/(#)+([A-Za-z0-9-_.]+)/i', '', $b);
    
    //remove URL------------------------------------------------------
    $d = preg_replace('/(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/i', '', $c);

    //remove tanda baca, angka, simbol (cleaning)-------------------------------------------------
    $e = str_replace(array('.', ',', '"', "'", '?', '!', '€', '™', '+', '[', ']', '*', '^', '&', '=', '/', '|', '(', ')', '_', ':', ';', '!', '%', '#', '~', '@', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '-'), ' ', $d);
    // $text = str_replace(array('-'), '', $text);
    $f = preg_replace('/[\x00-\x1F\x80-\xFF]/', ' ', $e);
    $words = preg_split('/[ .,:;&>="!?(){}]/', $f);
    foreach ($words as $word) {
        $result[] = $word;
    }
    return implode(' ', $result);
}
?>