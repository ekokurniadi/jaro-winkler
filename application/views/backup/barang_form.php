
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
        <form action="<?php echo $action; ?>" method="post" class="form-horizontal">
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Kode Barang <?php echo form_error('kode_barang') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="kode_barang" id="kode_barang" placeholder="Kode Barang" value="<?php echo $kode_barang; ?>" readonly/>
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Nama Barang <?php echo form_error('nama_barang') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="nama_barang" id="nama_barang" placeholder="Nama Barang" value="<?php echo $nama_barang; ?>" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Satuan <?php echo form_error('nama_barang') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="satuan" id="satuan" placeholder="Satuan" value="<?php echo $satuan; ?>" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Harga Modal <?php echo form_error('nama_barang') ?></label>
                <div class="col-sm-12">
                <input type="text" class="form-control" name="harga_modal" id="harga_modal" placeholder="Harga Modal" value="<?php echo $harga_modal; ?>" />
                </div>
              </div>
	   
            
                
              
	   
            
                  <input type="hidden" class="form-control" name="harga_terjual" id="harga_terjual" placeholder="Harga Terjual" value="<?php echo $harga_terjual; ?>" />
              
	   
             
                  <input type="hidden" class="form-control" name="qty_terjual" id="qty_terjual" placeholder="Qty Terjual" value="<?php echo $qty_terjual; ?>" />
              
	   
     
        <div class="card-footer text-left">
        <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><span class="fa fa-edit"></span><?php echo $button ?></button> 
	    <a href="<?php echo site_url('barang') ?>" class="btn btn-icon icon-left btn-success">Cancel</a>
	
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
</div>


<script>
var fnf = document.getElementById("harga_modal");
fnf.addEventListener('keyup', function(evt){
    var n = parseInt(this.value.replace(/\D/g,''),10) || 0;
    fnf.value = n.toLocaleString();
}, false);
var fnf1 = document.getElementById("harga_terjual");
fnf1.addEventListener('keyup', function(evt){
    var n = parseInt(this.value.replace(/\D/g,''),10) || 0;
    fnf1.value = n.toLocaleString();
}, false);
var fnf2 = document.getElementById("qty_terjual");
fnf2.addEventListener('keyup', function(evt){
    var n = parseInt(this.value.replace(/\D/g,''),10) || 0;
    fnf2.value = n.toLocaleString();
}, false);
</script>