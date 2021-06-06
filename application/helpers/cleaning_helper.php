<?php

function cleaningWords($text){
     $text = preg_replace('/[@]+([A-Za-z0-9-_.]+)/i', '', $text);

    //remove hashtag------------------------------------------------
    $text = preg_replace('/[#]+([A-Za-z0-9-_.]+)/i', '', $text);

    //remove URL------------------------------------------------------
    $text = preg_replace('/(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/i', '', $text);

    //remove tanda baca, angka, simbol (cleaning)-------------------------------------------------
    $text = str_replace(array('.', ',', '"', "'", '?', '!', '€', '™', '+', '[', ']', '*', '^', '&', '=', '/', '|', '(', ')', '_', ':', ';', '!', '%', '#', '~', '@', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '-'), ' ', $text);
    // $text = str_replace(array('-'), '', $text);
    $text = preg_replace('/[\x00-\x1F\x80-\xFF]/', ' ', $text);
    $words = preg_split('/[ .,:;&>="!?(){}]/', $text);
    foreach ($words as $word) {
        if (trim($word) == "") {
            continue;
        }
        $result[] = $word;
    }
    return implode(' ', $result);
}
?>