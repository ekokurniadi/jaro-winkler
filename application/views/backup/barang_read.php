
 <div class="main-content">
<section class="section">
  <div class="section-header">
    <h1> Barang </h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></div>
      <div class="breadcrumb-item"><a href="#"> Barang </a></div>
    </div>
  </div>

  <div class="section-body">
  <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
        <div class="card-header">
            <h4>Form Barang </h4>
        </div>
        <form class="form-horizontal">
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Kode Barang <?php echo form_error('kode_barang') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="kode_barang" id="kode_barang" placeholder="Kode Barang" value="<?php echo $kode_barang; ?>" readonly />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Nama Barang <?php echo form_error('nama_barang') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="nama_barang" id="nama_barang" placeholder="Nama Barang" value="<?php echo $nama_barang; ?>" readonly />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Satuan <?php echo form_error('nama_barang') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="satuan" id="satuan" placeholder="Satuan" value="<?php echo $satuan; ?>" readonly />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="double">Harga Modal <?php echo form_error('harga_modal') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="harga_modal" id="harga_modal" placeholder="Harga Modal" value="<?php echo $harga_modal; ?>" readonly />
                </div>
              </div>
	   
            
	   
     
        <div class="card-footer text-left">
        <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <a href="<?php echo site_url('barang') ?>" class="btn btn-icon icon-left btn-success">Cancel</a>
	
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
</div>
