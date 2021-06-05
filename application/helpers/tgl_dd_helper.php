<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('tgl_dd'))
{
function formatTanggal($date){
    // ubah string menjadi format tanggal
    return date('d/m/Y', strtotime($date));
   }
}

