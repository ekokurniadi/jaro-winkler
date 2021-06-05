<?php 

$string = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');




        \$config['query_string_segment'] = 'start';


        \$config['first_link']       = 'First';
        \$config['last_link']        = 'Last';
        \$config['next_link']        = '<i class=\"fas fa-chevron-right\"></i>';
        \$config['prev_link']        = '<i class=\"fas fa-chevron-left\"></i>';
        \$config['full_tag_open']    = '<div class=\"pagging text-right\"><nav class=\"d-inline-block\"><ul class=\"pagination justify-content-right\">';
        \$config['full_tag_close']   = '</ul></nav></div>';
        \$config['num_tag_open']     = '<li class=\"page-item\"><span class=\"page-link\">';
        \$config['num_tag_close']    = '</span></li>';
        \$config['cur_tag_open']     = '<li class=\"page-item active\"><span class=\"page-link\">';
        \$config['cur_tag_close']    = '<span class=\"sr-only\">(current)</span></span></li>';
        \$config['next_tag_open']    = '<li class=\"page-item\"><span class=\"page-link\">';
        \$config['next_tagl_close']  = '<span aria-hidden=\"true\">&raquo;</span></span></li>';
        \$config['prev_tag_open']    = '<li class=\"page-item\"><span class=\"page-link\">';
        \$config['prev_tagl_close']  = '</span>Next</li>';
        \$config['first_tag_open']   = '<li class=\"page-item\"><span class=\"page-link\">';
        \$config['first_tagl_close'] = '</span></li>';
        \$config['last_tag_open']    = '<li class=\"page-item\"><span class=\"page-link\">';
        \$config['last_tagl_close']  = '</span></li>';
       ";



$hasil_config_pagination = createFile($string, $target."config/pagination.php");

?>