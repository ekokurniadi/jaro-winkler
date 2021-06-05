
<body onload="load_data_temp();sum();"></body>

</style>

<!-- Content Header (Page header) -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

<script type="text/javascript">
function load_data_temp()
        {
            var kode_transaksi  =  $("#kode_transaksi").val();
            $.ajax({
                type:"GET",
                url:"<?php echo base_url('transaksi/load_temp')?>",
                data:"kode_transaksi="+kode_transaksi,
                success:function(hasilajax){
                    $('#list_ku').html(hasilajax);
                    $("#kode_barang").val('');
                    document.getElementById("kode_barang").focus();
                }
            });
            
        }

         function hapus(id)
        {
            $.ajax({
                type:"GET",
                url:"<?php echo base_url('transaksi/hapus_temp')?>",
                data:"id="+id,
                success:function(html){
                  $("#dataku"+id).hide(100);
                  load_data_temp();
                }
            });
        }

        function add_barang()
        {
                var kode_transaksi     = $("#kode_transaksi").val();
                var tanggal_transaksi = $("#tanggal_transaksi").val();
                var kode_barang       = $("#kode_barang").val();
                var harga_jual        = $("#harga_jual").val();
                var qty_jual          = $("#qty_jual").val();
                var total             = $("#total").val();
                var harga_modal       = $("#harga_modal").val();
                var laba              = $("#modal_laba").val();
            
               
            if(kode_transaksi == '' || qty_jual == '' || kode_barang == '' || total== '' ){
                alert("Data Belum Lengkap");
                die;
            }
            else
            {
             $.ajax({
                type:"GET",
                url:"<?php echo base_url('transaksi/input_ajax')?>",
                data:"kode_transaksi="+kode_transaksi+"&tanggal_transaksi="+tanggal_transaksi+"&kode_barang="+kode_barang+"&harga_jual="+harga_jual+"&qty_jual="+qty_jual+"&total="+total+"&harga_modal="+harga_modal+"&laba="+laba,
                success:function(html){
                   load_data_temp();
                   $('select[name="kode_barang"]').val('');
                    $("#harga_jual").val('0');
                    $("#qty_jual").val('');
                    $("#total").val('0');
                    $("#harga_modal").val('0');
                    $("#laba").val('0');
                    $("#modal_laba").val('0');
                  
                    document.getElementById("kode_barang").focus();
                   
                }
             });
        }
}

    </script>



 <div class="main-content">
<section class="section">
  <div class="section-header">
    <h1> Transaksi </h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></div>
      <div class="breadcrumb-item"><a href="#"> Transaksi </a></div>
    </div>
  </div>

  <div class="section-body">
  <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
        <div class="card-header">
            <h4>Form Transaksi </h4>
        </div>
        <form action="<?php echo $action; ?>" method="post" class="form-horizontal">
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Kode Transaksi <?php echo form_error('kode_transaksi') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="kode_transaksi" id="kode_transaksi" placeholder="Kode Transaksi" value="<?php echo $kode_transaksi; ?>" readonly/>
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="date">Tanggal Transaksi <?php echo form_error('tanggal_transaksi') ?></label>
                <div class="col-sm-12">
                  <input type="date" class="form-control" name="tanggal_transaksi" id="tanggal_transaksi" placeholder="Tanggal Transaksi" value="<?php echo $tanggal_transaksi; ?>"/>
                </div>
              </div>

              <div class="form-group">
                <div class="col-sm-12">
                  <input type="button" readonly class="btn btn-flat btn-block btn-danger" value="Detail Transaksi">
                </div>
              </div>

              <div class="form-group">
                <div class="container-fluid">
                  <div class="row">
                      <div class="col-sm-4">
                      Pilih Barang
                        <select name="kode_barang" id="kode_barang" class="form-control">
                          <option value="" selected>Choose</option>
                          <?php foreach($this->db->get("barang")->result() as $rows):?>
                          <option value="<?php echo $rows->kode_barang?>"><?php echo $rows->kode_barang?> | <?php echo $rows->nama_barang?> | <?=$rows->satuan?></option>
                          <?php endforeach;?>
                        </select>
                      </div>
                      <div class="col-sm-2">
                        Harga Jual
                        <input type="text" name="harga_jual" id="harga_jual" class="form-control">
                      </div>
                      <div class="col-sm-2">
                        Qty Jual
                        <input type="number" name="qty_jual" id="qty_jual" class="form-control">
                      </div>
                      <div class="col-sm-2">
                        Total
                        <input type="text" name="total" id="total" class="form-control" onkeyup="sum();">
                        <input type="hidden" name="harga_modal" id="harga_modal" class="form-control" readonly>
                        <input type="hidden" name="laba" id="laba" class="form-control" readonly>
                        <input type="hidden" name="modal_laba" id="modal_laba" class="form-control" readonly>
                      </div>
                      <div class="col-sm-2">
                        Aksi
                        <br>
                       <a type="button" href="#" class="btn btn-sm btn-flat btn-success" onclick="add_barang();"><i class="fa fa-plus"></i> Tambah</a>
                      </div>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-12">
                  <div id="list_ku" class="table-responsive">
                </div>
              </div>
	   
     
        <div class="card-footer text-left">
        <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><span class="fa fa-edit"></span><?php echo $button ?></button> 
	    <a href="<?php echo site_url('transaksi') ?>" class="btn btn-icon icon-left btn-success">Cancel</a>
	
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

<script type="text/javascript">
$(document).ready(function(){

$('#kode_barang').change(function(){    
var kode_barangnya = $('#kode_barang').val(); 

$.ajax({      
    method: "POST",      
    url: "<?php echo base_url('barang/ambil_data_barang')?>", 
    dataType:'json',  
    data: { kode_barang: kode_barangnya}
  
  })
    .done(function( hasilajax) {   
      $("#harga_modal").val(hasilajax.harga_modal);
    });
})
});


function sum() {
  var txtFirst = $('#qty_jual').val();
      var txtSecond = $('#harga_jual').val();
      var modal = $('#harga_modal').val();
      var total = $('#total').val();
      var laba = $('#laba').val();
      var result = parseInt(total);
        if (!isNaN(result)) {
            document.getElementById('total').value = result;
        }else{
            document.getElementById('total').value=0;     
        }

      var hasil = parseInt(txtFirst) * parseInt(modal);
      if(!isNaN(hasil)){
        document.getElementById('laba').value = hasil;
      }else{
        document.getElementById('laba').value = 0;
      }

      var modal_laba = result - hasil;
      if(!isNaN(modal_laba)){
        document.getElementById('modal_laba').value = modal_laba;
      }else{
        document.getElementById('modal_laba').value = 0;
      }
    }

    </script>
