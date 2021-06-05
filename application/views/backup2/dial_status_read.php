
 <div class="main-content">
<section class="section">
  <div class="section-header">
    <h1> Dial Status </h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></div>
      <div class="breadcrumb-item"><a href="#"> Dial Status </a></div>
    </div>
  </div>

  <div class="section-body">
  <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
        <div class="card-header">
            <h4>Form Dial Status </h4>
        </div>
        <form class="form-horizontal">
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Customer Id <?php echo form_error('customer_Id') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="customer_Id" id="customer_Id" placeholder="Customer Id" value="<?php echo $customer_Id; ?>" readonly />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Dial Status <?php echo form_error('dial_status') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="dial_status" id="dial_status" placeholder="Dial Status" value="<?php echo $dial_status; ?>" readonly />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Area Name <?php echo form_error('area_name') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="area_name" id="area_name" placeholder="Area Name" value="<?php echo $area_name; ?>" readonly />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Area Code <?php echo form_error('area_code') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="area_code" id="area_code" placeholder="Area Code" value="<?php echo $area_code; ?>" readonly />
                </div>
              </div>
	   
     
        <div class="card-footer text-left">
        <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <a href="<?php echo site_url('dial_status') ?>" class="btn btn-icon icon-left btn-success">Cancel</a>
	
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
</div>
