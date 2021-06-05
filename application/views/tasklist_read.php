
 <div class="main-content">
<section class="section">
  <div class="section-header">
    <h1> Tasklist </h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></div>
      <div class="breadcrumb-item"><a href="#"> Tasklist </a></div>
    </div>
  </div>

  <div class="section-body">
  <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
        <div class="card-header">
            <h4>Form Tasklist </h4>
        </div>
        <form class="form-horizontal">
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Task Id <?php echo form_error('task_id') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="task_id" id="task_id" placeholder="Task Id" value="<?php echo $task_id; ?>" readonly />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="date">Date <?php echo form_error('date') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="date" id="date" placeholder="Date" value="<?php echo $date; ?>" readonly />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Groups <?php echo form_error('groups') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="groups" id="groups" placeholder="Groups" value="<?php echo $groups; ?>" readonly />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Customer Id <?php echo form_error('customer_id') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="customer_id" id="customer_id" placeholder="Customer Id" value="<?php echo $customer_id; ?>" readonly />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Task Status <?php echo form_error('task_status') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="task_status" id="task_status" placeholder="Task Status" value="<?php echo $task_status; ?>" readonly />
                </div>
              </div>
	   
     
        <div class="card-footer text-left">
        <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <a href="<?php echo site_url('tasklist') ?>" class="btn btn-icon icon-left btn-success">Cancel</a>
	
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
</div>
