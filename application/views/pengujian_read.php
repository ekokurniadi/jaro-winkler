
 <div class="main-content">
<section class="section">
  <div class="section-header">
    <h1> Pengujian </h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></div>
      <div class="breadcrumb-item"><a href="#"> Pengujian </a></div>
    </div>
  </div>

  <div class="section-body">
  <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
        <div class="card-header">
            <h4>Form Pengujian </h4>
        </div>
        <form class="form-horizontal">
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Teks <?php echo form_error('teks') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="teks" id="teks" placeholder="Teks" value="<?php echo $teks; ?>" readonly />
                </div>
              </div>
	      
            <div class="card-body">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="cleaning">Cleaning <?php echo form_error('cleaning') ?></label>
                <div class="col-sm-12">
                    <textarea class="form-control" rows="3" name="cleaning" id="cleaning" placeholder="Cleaning"><?php echo $cleaning; ?></textarea>
                </div>
              </div>
	      
            <div class="card-body">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="casefolding">Casefolding <?php echo form_error('casefolding') ?></label>
                <div class="col-sm-12">
                    <textarea class="form-control" rows="3" name="casefolding" id="casefolding" placeholder="Casefolding"><?php echo $casefolding; ?></textarea>
                </div>
              </div>
	      
            <div class="card-body">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="tokenizing">Tokenizing <?php echo form_error('tokenizing') ?></label>
                <div class="col-sm-12">
                    <textarea class="form-control" rows="3" name="tokenizing" id="tokenizing" placeholder="Tokenizing"><?php echo $tokenizing; ?></textarea>
                </div>
              </div>
	      
            <div class="card-body">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="stemming">Stemming <?php echo form_error('stemming') ?></label>
                <div class="col-sm-12">
                    <textarea class="form-control" rows="3" name="stemming" id="stemming" placeholder="Stemming"><?php echo $stemming; ?></textarea>
                </div>
              </div>
	      
            <div class="card-body">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="rekomendasi">Rekomendasi <?php echo form_error('rekomendasi') ?></label>
                <div class="col-sm-12">
                    <textarea class="form-control" rows="3" name="rekomendasi" id="rekomendasi" placeholder="Rekomendasi"><?php echo $rekomendasi; ?></textarea>
                </div>
              </div>
	   
     
        <div class="card-footer text-left">
        <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <a href="<?php echo site_url('pengujian') ?>" class="btn btn-icon icon-left btn-success">Cancel</a>
	
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
</div>
