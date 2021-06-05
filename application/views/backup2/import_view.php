      <script src="<?= base_url("assets/vue/vue.min.js") ?>" type="text/javascript"></script>
      <script src="<?= base_url("assets/vue/accounting.js") ?>" type="text/javascript"></script>
      <script src="<?= base_url("assets/vue/vue-numeric.min.js") ?>" type="text/javascript"></script>
      <link href='<?=base_url()?>assets/select2/css/select2.min.css' rel='stylesheet' type='text/css'>
      <script src="<?=base_url()?>assets/jquery/jquery.min.js"></script>
      <script src='<?=base_url()?>assets/select2/js/select2.min.js'></script>    
 <div class="main-content">
<section class="section">
  <div class="section-header">
    <h1> Upload Data Customer </h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></div>
      <div class="breadcrumb-item"><a href="#"> Upload Data Customer </a></div>
    </div>
  </div>
     
  <div class="section-body">
  <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
       
        <div class="card-header">

            <h4>Form Upload  </h4>
        </div>
        <form method="post" class="form-horizontal" id="form_" enctype="multipart/form-data">
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">File CSV</label>
                <div class="col-sm-12">
                <input type="file" accept=".csv" required class="form-control" autofocus name="userfile">
                </div>
              </div>
     
        <div class="card-footer text-left">
     
	      <button type="button" id='submitBtn' name="process" class="btn btn-info btn-flat">Start Upload</button>
	    <a href="<?php echo site_url('customer') ?>" class="btn btn-icon icon-left btn-success">Cancel</a>
	
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
</div>
<script>
        var form_ = new Vue({
          el: '#form_',
          data: {
            error: false,
            error_list: ''
          },
        })
        $('#submitBtn').click(function() {
          var values = new FormData($('#form_')[0]);
          $.ajax({
                beforeSend: function() {
                  $('#submitBtn').html('<i class="fa fa-spinner fa-spin"></i> Process');
                  $('#submitBtn').attr('disabled', true);
                  form_.error = false;
                  form_.error_list = '';
                },
                enctype: 'multipart/form-data',
                url: '<?= base_url('customer/import_data') ?>',
                type: "POST",
                data: values,
                processData: false,
                contentType: false,
                cache: false,
                dataType: 'JSON',
                success: function(response) {
                  if (response.status == 'sukses') {
                    window.location = response.link;
                  } else {
                    if (response.tipe == 'html') {
                      form_.error = true;
                      form_.error_list = response.pesan;
                    } else {
                      alert(response.pesan);
                    }
                    $('#submitBtn').attr('disabled', false);
                  }
                  $('#submitBtn').html('Start Upload');
                },
                error: function() {
                  alert("Something Went Wrong !");
                  $('#submitBtn').html('Start Upload');
                  $('#submitBtn').attr('disabled', false);

                }
              });
        })
      </script>
