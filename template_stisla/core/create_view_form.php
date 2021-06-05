<?php

$string="
 <div class=\"main-content\">
<section class=\"section\">
  <div class=\"section-header\">
    <h1> ".ucwords(str_replace('_',' ',$table_name))." </h1>
    <div class=\"section-header-breadcrumb\">
      <div class=\"breadcrumb-item active\"><a href=\"<?php echo base_url(); ?>dashboard\"><i class=\"fa fa-dashboard\"></i> Home</a></div>
      <div class=\"breadcrumb-item\"><a href=\"#\"> ".ucwords(str_replace('_',' ',$table_name))." </a></div>
    </div>
  </div>

  <div class=\"section-body\">
  <div class=\"row\">
      <div class=\"col-12 col-md-12 col-lg-12\">
        <div class=\"card\">
        <div class=\"card-header\">
            <h4>Form ".ucwords(str_replace('_',' ',$table_name))." </h4>
        </div>
        <form action=\"<?php echo \$action; ?>\" method=\"post\" class=\"form-horizontal\">";
        foreach ($non_pk as $row) {
            if ($row["data_type"] == 'text')
            {

            $string .= "\n\t      
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"".$row["column_name"]."\">".label($row["column_name"])." <?php echo form_error('".$row["column_name"]."') ?></label>
                <div class=\"col-sm-12\">
                    <textarea class=\"form-control\" rows=\"3\" name=\"".$row["column_name"]."\" id=\"".$row["column_name"]."\" placeholder=\"".label($row["column_name"])."\"><?php echo $".$row["column_name"]."; ?></textarea>
                </div>
              </div>";
            }else{

            $string .= "\n\t   
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"".$row["data_type"]."\">".label($row["column_name"])." <?php echo form_error('".$row["column_name"]."') ?></label>
                <div class=\"col-sm-12\">
                  <input type=\"text\" class=\"form-control\" name=\"".$row["column_name"]."\" id=\"".$row["column_name"]."\" placeholder=\"".label($row["column_name"])."\" value=\"<?php echo $".$row["column_name"]."; ?>\" />
                </div>
              </div>";
            }
        }
        $string .= "\n\t   
     
        <div class=\"card-footer text-left\">
        <input type=\"hidden\" name=\"".$pk."\" value=\"<?php echo $".$pk."; ?>\" /> ";
        $string .= "\n\t    <button type=\"submit\" class=\"btn btn-primary\"><span class=\"fa fa-edit\"></span><?php echo \$button ?></button> ";
        $string .= "\n\t    <a href=\"<?php echo site_url('".$c_url."') ?>\" class=\"btn btn-icon icon-left btn-success\">Cancel</a>";
        
        $string .= "\n\t
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
</div>
";

$hasil_view_form = createFile($string, $target."views/" . $v_form_file);

?>