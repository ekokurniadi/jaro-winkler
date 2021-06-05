
 <div class="main-content">
<section class="section">
  <div class="section-header">
    <h1> Level </h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></div>
      <div class="breadcrumb-item"><a href="#"> Level </a></div>
    </div>
  </div>

  <div class="section-body">
  <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
        <div class="card-header">
            <h4>Form Level </h4>
        </div>
        <form action="<?php echo $action; ?>" method="post" class="form-horizontal">
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Level <?php echo form_error('level') ?></label>
                <div class="col-sm-12">
                  <input type="text" readonly class="form-control" name="level" id="level" placeholder="Level" value="<?php echo $level; ?>" />
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Hak Akses</label>
                <div class="col-sm-12">
                 <table class="table table-bordered">
                  <tr>
                    <th>Menu</th>
                    <th>Beri Akses <br> <input type="checkbox" name="select-all" id="select-all" /> <div id="state"></div></th>
                  </tr>
                  <!-- <tr>
                    <th></th>
                    <th></th>
                  </tr> -->
                    <?php  $data=$this->db->query("select * from menu")->result();?>
                  <?php $no=1;foreach($data as $d):?>
                  <?php $cek=$this->db->query("select * from access_level where user_level='$level' AND menu='$d->id'")->row();
                  if(isset($cek)){
                    if($cek->status=='1') $st1="checked";
                    else $st1 ="";
                  }else {
                    $st1="";
                  }
                  ?>
                  <tr>
                    <td><?=$d->menu?></td>
                    <input type="hidden" name="menu<?=$no?>" value="<?php echo $d->id?>">
                    <td>
                       <input type="checkbox" name="status<?=$no?>" id="akses" <?php echo $st1 ?>>
                    </td>
                  </tr>
                  
                  <?php $no++; endforeach;?>
                 </table>
                </div>
                <input type="hidden" name="jum_data" value="<?php echo $no-1 ?>"> 
              </div>
	   
     
        <div class="card-footer text-left">
        <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><span class="fa fa-edit"></span><?php echo $button ?></button> 
	    <a href="<?php echo site_url('level') ?>" class="btn btn-icon icon-left btn-success">Cancel</a>
	
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
</div>

<script>
$('#select-all').click(function(event) {   
    if(this.checked) {
        // Iterate each checkbox
        $(':checkbox').each(function() {
            this.checked = true; 
            document.getElementById('state').innerHTML ="All is Checked";                       
        });
    } else {
        $(':checkbox').each(function() {
            this.checked = false; 
            document.getElementById('state').innerHTML ="";                      
        });
    }
});

</script>
