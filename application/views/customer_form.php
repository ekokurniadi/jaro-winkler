
 <div class="main-content">
<section class="section">
  <div class="section-header">
    <h1> Customer </h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></div>
      <div class="breadcrumb-item"><a href="#"> Customer </a></div>
    </div>
  </div>

  <div class="section-body">
  <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
        <div class="card-header">
            <h4>Form Customer </h4>
        </div>
        <form action="<?php echo $action; ?>" method="post" class="form-horizontal">
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Customer Id <?php echo form_error('customer_id') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="customer_id" id="customer_id" placeholder="Customer Id" value="<?php echo $customer_id; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Customer Name <?php echo form_error('customer_name') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="customer_name" id="customer_name" placeholder="Customer Name" value="<?php echo $customer_name; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Address <?php echo form_error('address') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="address" id="address" placeholder="Address" value="<?php echo $address; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Rate <?php echo form_error('rate') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="rate" id="rate" placeholder="Rate" value="<?php echo $rate; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Power <?php echo form_error('power') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="power" id="power" placeholder="Power" value="<?php echo $power; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Device Id <?php echo form_error('device_id') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="device_id" id="device_id" placeholder="Device Id" value="<?php echo $device_id; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Device Type <?php echo form_error('device_type') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="device_type" id="device_type" placeholder="Device Type" value="<?php echo $device_type; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Server <?php echo form_error('server') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="server" id="server" placeholder="Server" value="<?php echo $server; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Cellular No <?php echo form_error('cellular_no') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="cellular_no" id="cellular_no" placeholder="Cellular No" value="<?php echo $cellular_no; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">IP Address <?php echo form_error('IP_address') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="IP_address" id="IP_address" placeholder="IP Address" value="<?php echo $IP_address; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Coordinate <?php echo form_error('coordinate') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="coordinate" id="coordinate" placeholder="Coordinate" value="<?php echo $coordinate; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Location <?php echo form_error('location') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="location" id="location" placeholder="Location" value="<?php echo $location; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Area Name <?php echo form_error('area_name') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="area_name" id="area_name" placeholder="Area Name" value="<?php echo $area_name; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Area Code <?php echo form_error('area_code') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="area_code" id="area_code" placeholder="Area Code" value="<?php echo $area_code; ?>" />
                </div>
              </div>
	   
     
        <div class="card-footer text-left">
        <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><span class="fa fa-edit"></span><?php echo $button ?></button> 
	    <a href="<?php echo site_url('customer') ?>" class="btn btn-icon icon-left btn-success">Cancel</a>
	
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
</div>
