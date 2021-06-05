<?php

$string ="
 <div class=\"main-content\">
<section class=\"section\">
  <div class=\"section-header\">
    <h1> ".ucfirst(str_replace('_',' ',$table_name))." </h1>
    <div class=\"section-header-breadcrumb\">
      <div class=\"breadcrumb-item active\"><a href=\"<?php echo base_url(); ?>dashboard\"><i class=\"fa fa-dashboard\"></i> Home</a></div>
      <div class=\"breadcrumb-item\"><a href=\"#\"> ".ucfirst(str_replace('_',' ',$table_name))." </a></div>
    </div>
  </div>

          <div class=\"section-body\">
            <div class=\"row\">
              <div class=\"col-12\">
                <div class=\"card\">
                  <div class=\"card-header\">
                  
                    <!-- 0 -->
                    <div class=\"col-md-4\">
                      <?php echo anchor(site_url('".$c_url."/create'),'<i class=\"fa fa-plus\"></i> Add New', 'class=\"btn btn-icon icon-left btn-primary\"'); ?>
                    </div>

                  <div class=\"col-md-4 text-center\">
                      <div style=\"margin-top: 8px\" id=\"message\">
                       <h5> <?php echo \$this->session->userdata('message') <> '' ? \$this->session->userdata('message') : ''; ?></h5>
                      </div>
                  </div>

                  <div class=\"col-md-1 text-right\">
                  </div>

                  <div class=\"col-md-3 text-right\">
                     <form action=\"<?php echo site_url('$c_url/index'); ?>\" class=\"form-inline\" method=\"get\">
                          <div class=\"input-group\">
                          <input type=\"text\" class=\"form-control\" name=\"q\" value=\"<?php echo \$q; ?>\" placeholder=\"Enter Keyword\">
                          <span class=\"input-group-btn\">
                              <?php 
                                  if (\$q <> '')
                                  {
                                      ?>
                                      <a href=\"<?php echo site_url('$c_url'); ?>\" class=\"btn btn-warning\"><span class=\"fa fa-close\"> </span> Reset</a>
                                      <?php
                                  }
                              ?>
                            <button class=\"btn btn-primary\" type=\"submit\"><span class=\"fa fa-search\"> </span> Search</button>
                          </span>
                          </div>
                      </form>
                  </div>

                  </div>
                  <div class=\"card-body\">
                    <div class=\"table-responsive\">
                      <table class=\"table table-bordered table-md\" id=\"table-1\">
                      <thead>
                      <tr>
                          <th>No</th>";
        foreach ($non_pk as $row) {
            $string .= "\n\t\t<th>" . label($row['column_name']) . "</th>";
        }
        $string .= "\n\t\t<th>Action</th>
                    </tr>
                    </thead>";
        $string .= "<?php
                    foreach ($" . $c_url . "_data as \$$c_url)
                    {
                        ?>
                          <tbody>
                          <tr>";
          
          $string .= "\n\t\t\t<td width=\"80px\"><?php echo ++\$start ?></td>";
          foreach ($non_pk as $row) {
              $string .= "\n\t\t\t<td><?php echo $" . $c_url ."->". $row['column_name'] . " ?></td>";
          }
          
          
          $string .= "\n\t\t\t<td style=\"text-align:center\" width=\"200px\">"
                  . "\n\t\t\t\t<?php "
                  . "\n\t\t\t\techo anchor(site_url('".$c_url."/read/'.$".$c_url."->".$pk."),'<i class=\"fa fa-eye\"></i>',array('title'=>'detail','class'=>'btn btn-icon icon-left btn-light')); "
                  . "\n\t\t\t\techo '  '; "
                  . "\n\t\t\t\techo anchor(site_url('".$c_url."/update/'.$".$c_url."->".$pk."),'<i class=\"fa fa-pencil-square-o\"></i>',array('title'=>'edit','class'=>'btn btn-icon icon-left btn-warning')); "
                  . "\n\t\t\t\techo '  '; "
                  . "\n\t\t\t\techo anchor(site_url('".$c_url."/delete/'.$".$c_url."->".$pk."),'<i class=\"fa fa-trash-o\"></i>','title=\"delete\" class=\"btn btn-icon icon-left btn-danger\" onclick=\"javasciprt: return confirm(\\'Are You Sure ?\\')\"'); "
                  . "\n\t\t\t\t?>"
                  . "\n\t\t\t</td>";
          
          $string .=  "\n\t\t</tr></tbody>
                          <?php
                      }
                      ?>
                    
                    </table>
                    </div>
                  </div>
                  <div class=\"card-footer text-right\">
                  <?php echo \$pagination ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <div class=\"row\">
        <div class=\"col-md-6\">
            <a href=\"#\" class=\"btn btn-primary\">Total Data : <?php echo \$total_rows ?></a>
            ";
if ($export_excel == '1') {
$string .= "\n\t\t<?php echo anchor(site_url('".$c_url."/excel'), '<i class=\"fa fa-file-excel-o\"></i> Excel', 'class=\"btn btn-icon btn-success\"'); ?>";
}
if ($export_word == '1') {
$string .= "\n\t\t<?php echo anchor(site_url('".$c_url."/word'), '<i class=\"fa fa-file-word-o\"></i> Word', 'class=\"btn btn-icon btn-info\"'); ?>";
}
if ($export_pdf == '1') {
$string .= "\n\t\t<?php echo anchor(site_url('".$c_url."/pdf'), 'PDF', 'class=\"btn btn-primary\"'); ?>";
}
$string .= "\n\t    </div>
       
    </div>
      </div>
      ";
$hasil_view_list = createFile($string, $target."views/" . $v_list_file);

?>