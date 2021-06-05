<?php 

$string = "
<!-- Content Header (Page header) -->
    <section class=\"content-header\">
      <h1>
        ".ucfirst($table_name)." 
        <small>Control panel</small>
      </h1>
      <ol class=\"breadcrumb\">
        <li><a href=\"<?php echo base_url(); ?>dashboard\"><i class=\"fa fa-dashboard\"></i> Home</a></li>
        <li class=\"active\">".ucfirst($table_name)."</li>
      </ol>
    </section>


<!-- column -->
        <div class=\"col-md-12\">
          <!-- Horizontal Form -->
          <div class=\"box box-info\">
            <div class=\"box-header with-border\">
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action=\"<?php echo \$action; ?>\" method=\"post\" class=\"form-horizontal\">";     
foreach ($non_pk as $row) {
    if ($row["data_type"] == 'text')
    {
    $string .= "\n\t    
    <div class=\"box-body\">
        <div class=\"form-group\">
            <label class=\"col-sm-2 control-label\" for=\"".$row["column_name"]."\">".label($row["column_name"])." <?php echo form_error('".$row["column_name"]."') ?></label>
            <div class=\"col-sm-6\">
                <textarea class=\"ckeditor\" rows=\"3\" name=\"".$row["column_name"]."\" id=\"".$row["column_name"]."\" placeholder=\"".label($row["column_name"])."\"><?php echo $".$row["column_name"]."; ?></textarea>
            </div>
        </div>
    </div>";
    
    } else
    {
    $string .= "\n\t   
    <div class=\"box-body\"> 
        <div class=\"form-group\">
            <label class=\"col-sm-2 control-label\" for=\"".$row["data_type"]."\">".label($row["column_name"])." <?php echo form_error('".$row["column_name"]."') ?></label>
            <div class=\"col-sm-6\">
                <input type=\"text\" class=\"form-control\" name=\"".$row["column_name"]."\" id=\"".$row["column_name"]."\" placeholder=\"".label($row["column_name"])."\" value=\"<?php echo $".$row["column_name"]."; ?>\" />
            </div>
        </div>
    </div>";
    }
}
$string .= "\n\t    
<div class=\"box-footer\">
    <input type=\"hidden\" name=\"".$pk."\" value=\"<?php echo $".$pk."; ?>\" /> ";
$string .= "\n\t    <button type=\"submit\" class=\"btn btn-success\"><?php echo \$button ?></button> ";
$string .= "\n\t    <a href=\"<?php echo site_url('".$c_url."') ?>\" class=\"btn btn-default\">Cancel</a>";

$string .= "\n\t
</div>
</form>
</div>
</div>
</div>
";

$hasil_view_form = createFile($string, $target."views/" . $v_form_file);

?>