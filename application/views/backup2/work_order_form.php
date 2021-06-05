
 <div class="main-content">
<section class="section">
  <div class="section-header">
    <h1> Work Order </h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></div>
      <div class="breadcrumb-item"><a href="#"> Work Order </a></div>
    </div>
  </div>

  <div class="section-body">
  <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
        <div class="card-header">
            <h4>Form Work Order </h4>
        </div>
        <form action="<?php echo $action; ?>" method="post" class="form-horizontal">
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Task Id <?php echo form_error('task_id') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="task_id" id="task_id" placeholder="Task Id" value="<?php echo $task_id; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Document No <?php echo form_error('document_no') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="document_no" id="document_no" placeholder="Document No" value="<?php echo $document_no; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="date">Date <?php echo form_error('date') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="date" id="date" placeholder="Date" value="<?php echo $date; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Customer Id <?php echo form_error('customer_id') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="customer_id" id="customer_id" placeholder="Customer Id" value="<?php echo $customer_id; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Activities <?php echo form_error('activities') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="activities" id="activities" placeholder="Activities" value="<?php echo $activities; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="date">Date Meter <?php echo form_error('date_meter') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="date_meter" id="date_meter" placeholder="Date Meter" value="<?php echo $date_meter; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="time">Time Meter <?php echo form_error('time_meter') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="time_meter" id="time_meter" placeholder="Time Meter" value="<?php echo $time_meter; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="double">Stand Meter WBP <?php echo form_error('stand_meter_WBP') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="stand_meter_WBP" id="stand_meter_WBP" placeholder="Stand Meter WBP" value="<?php echo $stand_meter_WBP; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="double">Stand Meter WBP1 <?php echo form_error('stand_meter_WBP1') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="stand_meter_WBP1" id="stand_meter_WBP1" placeholder="Stand Meter WBP1" value="<?php echo $stand_meter_WBP1; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="double">Stand Meter WBP2 <?php echo form_error('stand_meter_WBP2') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="stand_meter_WBP2" id="stand_meter_WBP2" placeholder="Stand Meter WBP2" value="<?php echo $stand_meter_WBP2; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="double">Stand Meter Total <?php echo form_error('stand_meter_total') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="stand_meter_total" id="stand_meter_total" placeholder="Stand Meter Total" value="<?php echo $stand_meter_total; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="double">Kvarh <?php echo form_error('kvarh') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="kvarh" id="kvarh" placeholder="Kvarh" value="<?php echo $kvarh; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="double">Voltage R <?php echo form_error('voltage_r') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="voltage_r" id="voltage_r" placeholder="Voltage R" value="<?php echo $voltage_r; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="double">Voltage S <?php echo form_error('voltage_s') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="voltage_s" id="voltage_s" placeholder="Voltage S" value="<?php echo $voltage_s; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="double">Voltage T <?php echo form_error('voltage_t') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="voltage_t" id="voltage_t" placeholder="Voltage T" value="<?php echo $voltage_t; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="double">Current R <?php echo form_error('current_r') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="current_r" id="current_r" placeholder="Current R" value="<?php echo $current_r; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="double">Current S <?php echo form_error('current_s') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="current_s" id="current_s" placeholder="Current S" value="<?php echo $current_s; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="double">Current T <?php echo form_error('current_t') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="current_t" id="current_t" placeholder="Current T" value="<?php echo $current_t; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="double">Cosphi <?php echo form_error('cosphi') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="cosphi" id="cosphi" placeholder="Cosphi" value="<?php echo $cosphi; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Panel Condition <?php echo form_error('panel_condition') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="panel_condition" id="panel_condition" placeholder="Panel Condition" value="<?php echo $panel_condition; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Meter Dev Condition <?php echo form_error('meter_dev_condition') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="meter_dev_condition" id="meter_dev_condition" placeholder="Meter Dev Condition" value="<?php echo $meter_dev_condition; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Meter Disp Condition <?php echo form_error('meter_disp_condition') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="meter_disp_condition" id="meter_disp_condition" placeholder="Meter Disp Condition" value="<?php echo $meter_disp_condition; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Shuntrip Condition <?php echo form_error('shuntrip_condition') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="shuntrip_condition" id="shuntrip_condition" placeholder="Shuntrip Condition" value="<?php echo $shuntrip_condition; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Current Limiter <?php echo form_error('current_limiter') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="current_limiter" id="current_limiter" placeholder="Current Limiter" value="<?php echo $current_limiter; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Current Limiter Type <?php echo form_error('current_limiter_type') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="current_limiter_type" id="current_limiter_type" placeholder="Current Limiter Type" value="<?php echo $current_limiter_type; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Current Limiter Brand <?php echo form_error('current_limiter_brand') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="current_limiter_brand" id="current_limiter_brand" placeholder="Current Limiter Brand" value="<?php echo $current_limiter_brand; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Modem Condition <?php echo form_error('modem_condition') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="modem_condition" id="modem_condition" placeholder="Modem Condition" value="<?php echo $modem_condition; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Modem Imei <?php echo form_error('modem_imei') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="modem_imei" id="modem_imei" placeholder="Modem Imei" value="<?php echo $modem_imei; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Modem Type <?php echo form_error('modem_type') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="modem_type" id="modem_type" placeholder="Modem Type" value="<?php echo $modem_type; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Modem Brand <?php echo form_error('modem_brand') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="modem_brand" id="modem_brand" placeholder="Modem Brand" value="<?php echo $modem_brand; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Ant Potition <?php echo form_error('ant_potition') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="ant_potition" id="ant_potition" placeholder="Ant Potition" value="<?php echo $ant_potition; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="double">Ratio CT <?php echo form_error('Ratio_CT') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="Ratio_CT" id="Ratio_CT" placeholder="Ratio CT" value="<?php echo $Ratio_CT; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Top Panel Door Seal <?php echo form_error('top_panel_door_seal') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="top_panel_door_seal" id="top_panel_door_seal" placeholder="Top Panel Door Seal" value="<?php echo $top_panel_door_seal; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Bottom Panel Door Seal <?php echo form_error('bottom_panel_door_seal') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="bottom_panel_door_seal" id="bottom_panel_door_seal" placeholder="Bottom Panel Door Seal" value="<?php echo $bottom_panel_door_seal; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Meter Dev Seal <?php echo form_error('meter_dev_seal') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="meter_dev_seal" id="meter_dev_seal" placeholder="Meter Dev Seal" value="<?php echo $meter_dev_seal; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Modem Seal <?php echo form_error('modem_seal') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="modem_seal" id="modem_seal" placeholder="Modem Seal" value="<?php echo $modem_seal; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Latitude <?php echo form_error('latitude') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="latitude" id="latitude" placeholder="Latitude" value="<?php echo $latitude; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Longitude <?php echo form_error('longitude') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="longitude" id="longitude" placeholder="Longitude" value="<?php echo $longitude; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Site Allocation <?php echo form_error('site_allocation') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="site_allocation" id="site_allocation" placeholder="Site Allocation" value="<?php echo $site_allocation; ?>" />
                </div>
              </div>
	      
              <div class="form-group">
                <label class="col-sm-2 control-label" for="note">Note <?php echo form_error('note') ?></label>
                <div class="col-sm-12">
                    <textarea class="form-control" rows="3" name="note" id="note" placeholder="Note"><?php echo $note; ?></textarea>
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Photo Panel <?php echo form_error('photo_panel') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="photo_panel" id="photo_panel" placeholder="Photo Panel" value="<?php echo $photo_panel; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Photo Meter Dev <?php echo form_error('photo_meter_dev') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="photo_meter_dev" id="photo_meter_dev" placeholder="Photo Meter Dev" value="<?php echo $photo_meter_dev; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Photo Shuntrip <?php echo form_error('photo_shuntrip') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="photo_shuntrip" id="photo_shuntrip" placeholder="Photo Shuntrip" value="<?php echo $photo_shuntrip; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Photo Current Limiter <?php echo form_error('photo_current_limiter') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="photo_current_limiter" id="photo_current_limiter" placeholder="Photo Current Limiter" value="<?php echo $photo_current_limiter; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Photo Building <?php echo form_error('photo_building') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="photo_building" id="photo_building" placeholder="Photo Building" value="<?php echo $photo_building; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Photo 1 <?php echo form_error('photo_1') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="photo_1" id="photo_1" placeholder="Photo 1" value="<?php echo $photo_1; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Photo 2 <?php echo form_error('photo_2') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="photo_2" id="photo_2" placeholder="Photo 2" value="<?php echo $photo_2; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Status <?php echo form_error('status') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="status" id="status" placeholder="Status" value="<?php echo $status; ?>" />
                </div>
              </div>
	      
              <div class="form-group">
                <label class="col-sm-2 control-label" for="reason">Reason <?php echo form_error('reason') ?></label>
                <div class="col-sm-12">
                    <textarea class="form-control" rows="3" name="reason" id="reason" placeholder="Reason"><?php echo $reason; ?></textarea>
                </div>
              </div>
	   
     
        <div class="card-footer text-left">
        <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><span class="fa fa-edit"></span><?php echo $button ?></button> 
	    <a href="<?php echo site_url('work_order') ?>" class="btn btn-icon icon-left btn-success">Cancel</a>
	
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
</div>
