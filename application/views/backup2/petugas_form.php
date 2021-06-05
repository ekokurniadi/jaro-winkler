<?php
	ini_set('display_errors', 0);
?>
 <div class="main-content">
<section class="section">
  <div class="section-header">
    <h1> Petugas </h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></div>
      <div class="breadcrumb-item"><a href="#"> Petugas </a></div>
    </div>
  </div>

  <div class="section-body">
  <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
        <div class="card-header">
            <h4>Form Petugas </h4>
        </div>
        <form action="<?php echo $action; ?>" method="post" class="form-horizontal" enctype="multipart/form-data">
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Nama Lengkap <?php echo form_error('name') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="name" id="name" placeholder="Nama Lengkap" value="<?php echo $name; ?>" />
                </div>
              </div>
	   
           
	      
              <div class="form-group">
                <label class="col-sm-2 control-label" for="address">Alamat <?php echo form_error('address') ?></label>
                <div class="col-sm-12">
                    <textarea class="form-control" rows="3" name="address" id="address" placeholder="Alamat"><?php echo $address; ?></textarea>
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">No. HP <?php echo form_error('cellular_no') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="cellular_no" id="cellular_no" placeholder="No. HP" value="<?php echo $cellular_no; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Grup <?php echo form_error('groups') ?></label>
                <div class="col-sm-12">
                 <select name="groups" id="groups" class="form-control">
                  <?php 
                      $data = $this->db->query("SELECT * from grup");
                  ?>
                  <?php $val = $this->db->get_where('grup',array('id'=>$groups))->row() ?>
                  <option value="">Choose</option>
                  <?php foreach($data->result() as $rows):?>
                    <option value="<?=$rows->id?>"><?=$rows->group?> (<?=$rows->nama_up3?>)</option>
                  <?php endforeach;?>
                 </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Nama UP3 <?php echo form_error('area_name') ?></label>
                <div class="col-sm-12">
                <select name="area_name" id="area_name" class="form-control">
                <?php 
                      $data = $this->db->query("SELECT * from area group by area_name");
                  ?>
                  <option value="<?=$area_name?>"><?=$area_name == "" ?"Choose" : $area_name?></option>
                  <?php foreach($data->result() as $rows):?>
                  <option value="<?=$rows->area_name?>"><?=$rows->area_name?></option>
                  <?php endforeach;?>
                </select>
                    <!-- <input type="text" name="area_name" id="area_name" value="<?=$area_name?>" class="form-control" readonly/> -->
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Username <?php echo form_error('NIK') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="NIK" id="NIK" placeholder="Username" value="<?php echo $NIK; ?>" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Password <?php echo form_error('password') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo $password; ?>" />
                </div>
              </div>
            
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Level <?php echo form_error('level') ?></label>
                <div class="col-sm-12">
                 <select name="level" id="level" class="form-control">
                  <option value="<?= $level?>"><?=$level == "" ? "Choose an option" : $level ?></option>
                    <?php foreach($levelOptions as $rows):?>
                      <option value="<?=$rows->level?>"><?=$rows->level?></option>
                    <?php endforeach;?>
                 </select>
                </div>
              </div>
            
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Foto User <?php echo form_error('photo') ?></label>
                <div class="col-sm-12">
                  <input type="file" class="form-control" name="photo" id="photo" placeholder="Photo" value="<?php echo $photo; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="int">Status <?php echo form_error('status') ?></label>
                <div class="col-sm-12">
                <select name="status" id="status" class="form-control">
                  <option value="<?= $status?>"><?=$status == "" ? "Choose" : ($status == "1" ? "Active" : "Non Active") ?></option>
                  <option value="1">Active</option>
                  <option value="0">NonActive</option>
                 </select>
                </div>
              </div>
	   
     
        <div class="card-footer text-left">
        <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><span class="fa fa-edit"></span><?php echo $button ?></button> 
      <a href="<?php echo site_url('dashboard') ?>" class="btn btn-icon icon-left btn-success">Cancel</a>
	
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

$('#groups').change(function(){    
var grup = $('#groups').val(); 

$.ajax({      
    method: "POST",      
    url: "<?php echo base_url('api/ambil_grup')?>", 
    dataType:'json',  
    data: { grup: grup}
  
  })
    .done(function( hasilajax) {   
      $("#area_name").val(hasilajax.grup);
    });
})
});
</script>