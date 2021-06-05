
 <div class="main-content">
<section class="section">
  <div class="section-header">
    <h1> Operator Selular </h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></div>
      <div class="breadcrumb-item"><a href="#"> Operator Selular </a></div>
    </div>
  </div>

  <div class="section-body">
  <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
        <div class="card-header">
            <h4>Form Operator Selular </h4>
        </div>
        <form action="<?php echo $action; ?>" method="post" class="form-horizontal">
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Kode Operator <?php echo form_error('kode_operator') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="kode_operator" id="kode_operator" placeholder="Kode Operator" value="<?php echo $kode_operator; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Nama Operator <?php echo form_error('nama_operator') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="nama_operator" id="nama_operator" placeholder="Nama Operator" value="<?php echo $nama_operator; ?>" />
                </div>
              </div>
	   
     
        <div class="card-footer text-left">
        <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><span class="fa fa-edit"></span><?php echo $button ?></button> 
	    <a href="<?php echo site_url('operator_selular') ?>" class="btn btn-icon icon-left btn-success">Cancel</a>
	
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
</div>
