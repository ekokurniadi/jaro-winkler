
 <div class="main-content">
<section class="section">
  <div class="section-header">
    <h1> Top Up </h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></div>
      <div class="breadcrumb-item"><a href="#"> Top Up </a></div>
    </div>
  </div>

  <div class="section-body">
  <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
        <div class="card-header">
            <h4>Form Top Up </h4>
        </div>
        <form action="<?php echo $action; ?>" method="post" class="form-horizontal">
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="int">Driver <?php echo form_error('driver') ?></label>
                <div class="col-sm-12">
                <select name="driver" id="driver" class="form-control">
                  <option value="<?=$driver?>" selected><?=$driver?></option>
                  <?php foreach($this->db->get('driver')->result() as $rows){?>
                    <option value="<?=$rows->id?>"><?=$rows->id?> | <?=$rows->nama?></option>
                  <?php } ?>
                </select>
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="date">Tanggal Top Up <?php echo form_error('tanggal_top_up') ?></label>
                <div class="col-sm-12">
                  <input type="date" class="form-control" name="tanggal_top_up" id="tanggal_top_up" placeholder="Tanggal Top Up" value="<?php echo $tanggal_top_up; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="double">Nominal Top Up <?php echo form_error('nominal_top_up') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="nominal_top_up" id="nominal_top_up" placeholder="Nominal Top Up" value="<?php echo $nominal_top_up; ?>" />
                </div>
              </div>
	   
              <!-- <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Status <?php echo form_error('status') ?></label>
                <div class="col-sm-12"> -->
                  <input type="hidden" class="form-control" name="status" id="status" placeholder="Status" value="new" />
                <!-- </div>
              </div>
	    -->
     
        <div class="card-footer text-left">
        <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><span class="fa fa-edit"></span><?php echo $button ?></button> 
	    <a href="<?php echo site_url('top_up') ?>" class="btn btn-icon icon-left btn-success">Cancel</a>
	
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
</div>
