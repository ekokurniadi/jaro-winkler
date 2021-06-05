
 <div class="main-content">
<section class="section">
  <div class="section-header">
    <h1> Grup </h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></div>
      <div class="breadcrumb-item"><a href="#"> Grup </a></div>
    </div>
  </div>

  <div class="section-body">
  <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
        <div class="card-header">
            <h4>Form Grup </h4>
        </div>
        <form action="<?php echo $action; ?>" method="post" class="form-horizontal">
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Kode Up3 <?php echo form_error('kode_up3') ?></label>
                <div class="col-sm-12">
                  <select name="kode_up3" id="kode_up3" class="form-control select2">
                    <option value="<?=$kode_up3?>">Choose</option>
                    <?php $data = $this->db->query("SELECT * FROM area group by area_code")->result()?>
                    <?php foreach($data as $rows):?>
                      <option value="<?=$rows->area_code?>"><?=$rows->area_code?> [ <?=$rows->area_name?> ]  </option>
                    <?php endforeach;?>
                  </select>
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Nama Up3 <?php echo form_error('nama_up3') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="nama_up3" id="nama_up3" placeholder="Nama Up3" value="<?php echo $nama_up3; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="enum">Group <?php echo form_error('group') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="group" id="group" placeholder="Group" value="<?php echo $group; ?>" />
                </div>
              </div>
	   
     
        <div class="card-footer text-left">
        <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><span class="fa fa-edit"></span><?php echo $button ?></button> 
	    <a href="<?php echo site_url('grup') ?>" class="btn btn-icon icon-left btn-success">Cancel</a>
	
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
</div>

<script type="text/javascript">
$(document).ready(function(){

$('#kode_up3').change(function(){    
var kode = $('#kode_up3').val(); 

$.ajax({      
    method: "POST",      
    url: "<?php echo base_url('api/ambil_area')?>", 
    dataType:'json',  
    data: { kode: kode}
  
  })
    .done(function( hasilajax) {   
      $("#nama_up3").val(hasilajax.area_name);
    });
})
});
</script>
