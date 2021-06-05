
 <div class="main-content">
<section class="section">
  <div class="section-header">
    <h1> Laporan Penjualan </h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></div>
      <div class="breadcrumb-item"><a href="#"> Laporan Penjualan </a></div>
    </div>
  </div>

  <div class="section-body">
  <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
        <div class="card-header">
            <h4>Laporan Penjualan </h4>
        </div>
        <form action="<?php echo base_url('laporan/download')?>" method="get" class="form-horizontal" enctype="multipart/form-data">
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Start Date <?php echo form_error('nama') ?></label>
                <div class="col-sm-6">
                  <input type="date" class="form-control" name="start" id="start" placeholder="Nama" />
                </div>
                <label class="col-sm-2 control-label" for="varchar">End Date <?php echo form_error('nama') ?></label>
                <div class="col-sm-6">
                  <input type="date" class="form-control" name="end" id="end" placeholder="Nama" />
                </div>
                <label class="col-sm-2 control-label" for="varchar">Jenis Report <?php echo form_error('nama') ?></label>
                <div class="col-sm-6">
                    <select name="jenis_report" id="jenis_report" class="form-control">
                    <option value="excel" selected>Pilih Jenis Report</option>
                    <option value="excel">Excel</option>
                    <option value="pdf">PDF</option>
                    </select>
                </div>
              </div>
     
        <div class="card-footer text-left">
	    <button type="submit" class="btn btn-success"><span class="fa fa-download"></span> Download Report</button> 
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
</div>
