
 <div class="main-content">
<section class="section">
  <div class="section-header">
    <h1> Zakat </h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></div>
      <div class="breadcrumb-item"><a href="#"> Zakat </a></div>
    </div>
  </div>

  <div class="section-body">
  <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
        <div class="card-header">
            <h4>Form Zakat </h4>
        </div>
        <form action="<?php echo $action; ?>" method="post" class="form-horizontal">
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="date">Tanggal Awal <?php echo form_error('tanggal_awal') ?></label>
                <div class="col-sm-12">
                  <input type="date" class="form-control" name="tanggal_awal" id="tanggal_awal" placeholder="Tanggal Awal" value="<?php echo $tanggal_awal; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="date">Tanggal Akhir <?php echo form_error('tanggal_akhir') ?></label>
                <div class="col-sm-12">
                  <input type="date" class="form-control" name="tanggal_akhir" id="tanggal_akhir" placeholder="Tanggal Akhir" value="<?php echo $tanggal_akhir; ?>" />
                </div>
              </div>

              <div class="form-group">
                <div class="col-sm-12">
                 <a class="btn btn-flat btn-primary" type="button" onclick="hitung();" style="color:white;">Generate</a>
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="double">Total Penjualan <?php echo form_error('total_penjualan') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="total_penjualan" id="total_penjualan" placeholder="Total Penjualan" value="<?php echo $total_penjualan; ?>" readonly/>
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="double">Total Keuntungan <?php echo form_error('total_keuntungan') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="total_keuntungan" id="total_keuntungan" placeholder="Total Keuntungan" value="<?php echo $total_keuntungan; ?>" readonly/>
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="double">Zakat <?php echo form_error('zakat') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="zakat" id="zakat" placeholder="Zakat" value="<?php echo $zakat; ?>" readonly/>
                </div>
              </div>
	   
     
        <div class="card-footer text-left">
        <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><span class="fa fa-edit"></span><?php echo $button ?></button> 
	    <a href="<?php echo site_url('zakat') ?>" class="btn btn-icon icon-left btn-success">Cancel</a>
	
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
</div>

<script>
function hitung(){
  var tanggal_awal = $("#tanggal_awal").val();
  var tanggal_akhir = $("#tanggal_akhir").val();
  if(tanggal_awal == '' || tanggal_akhir == '' ){
                alert("Data Belum Lengkap");
                die;
  }else{
    $.ajax({      
    method: "GET",      
    url: "<?php echo base_url('zakat/hitung_zakat')?>", 
    dataType:'json',  
    data:"tanggal_awal="+tanggal_awal+"&tanggal_akhir="+tanggal_akhir,
  
  })
    .done(function( hasilajax) {   
      $("#total_penjualan").val(hasilajax[0][0]);
      $("#total_keuntungan").val(hasilajax[0][1]);
      $("#zakat").val(hasilajax[0][2]);
    });
  }
}
</script>
