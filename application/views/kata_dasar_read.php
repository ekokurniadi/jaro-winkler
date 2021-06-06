
 <div class="main-content">
<section class="section">
  <div class="section-header">
    <h1> Kata Dasar </h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></div>
      <div class="breadcrumb-item"><a href="#"> Kata Dasar </a></div>
    </div>
  </div>

  <div class="section-body">
  <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
        <div class="card-header">
            <h4>Form Kata Dasar </h4>
        </div>
        <form class="form-horizontal">
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Kata <?php echo form_error('kata') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="kata" id="kata" placeholder="Kata" value="<?php echo $kata; ?>" readonly />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Arti <?php echo form_error('arti') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="arti" id="arti" placeholder="Arti" value="<?php echo $arti; ?>" readonly />
                </div>
              </div>
	   
     
        <div class="card-footer text-left">
        <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <a href="<?php echo site_url('kamus') ?>" class="btn btn-icon icon-left btn-success">Cancel</a>
	
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
</div>
