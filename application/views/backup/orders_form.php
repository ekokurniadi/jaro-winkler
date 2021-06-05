<body onload="onloading();">
  
</body>
 <div class="main-content">
<section class="section">
  <div class="section-header">
    <h1> Orders </h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></div>
      <div class="breadcrumb-item"><a href="#"> Orders </a></div>
    </div>
  </div>

  <div class="section-body">
  <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
        <div class="card-header">
            <h4>Form Orders </h4>
        </div>
        <form action="<?php echo $action; ?>" method="post" class="form-horizontal">
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Kode Order <?php echo form_error('kode_order') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="kode_order" id="kode_order" placeholder="Kode Order" value="<?php echo $kode_order; ?>" readonly/>
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Nama Customer <?php echo form_error('nama_customer') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="nama_customer" id="nama_customer" placeholder="Nama Customer" value="<?php echo $nama_customer; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Nomor Wa <?php echo form_error('nomor_wa') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="nomor_wa" id="nomor_wa" placeholder="Nomor Wa" value="<?php echo $nomor_wa; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="date">Jadwal Kirim <?php echo form_error('jadwal_kirim') ?></label>
                <div class="col-sm-12">
                  <input type="date" class="form-control" name="jadwal_kirim" id="jadwal_kirim" placeholder="Jadwal Kirim" value="<?php echo $jadwal_kirim; ?>" />
                </div>
              </div>
	   
              <div class="form-group" id="datetimepicker3" data-target-input="nearest">
                <label class="col-sm-2 control-label" for="time">Jam <?php echo form_error('jam') ?></label>
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-md-12 col-sm-8 col-xs-8" >
                      <input type="text" class="form-control datetimepicker-input" id="jam" name="jam" data-target="#datetimepicker3" data-toggle="datetimepicker" value="<?=$jam?>"/>
                    </div>
                  </div>
                </div>
               
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Kota/Kabupaten Penjemputan <?php echo form_error('kota') ?></label>
                <div class="col-sm-12" style="text-transform: uppercase">
                    <select name="kota" id="kota" class="form-control">
                        <option value="<?=$kota?>"><?=$kota == null ? "Choose" : $kota ?></option>
                        <option value="Bekasi">Bekasi</option>
                        <option value="Jakarta Timur">Jakarta Timur</option>
                        <option value="Jakarta Utara">Jakarta Utara</option>
                        <option value="Jakarta Pusat">Jakarta Pusat</option>
                        <option value="Jakarta Barat">Jakarta Barat</option>
                        <option value="Jakarta Selatan">Jakarta Selatan</option>
                        <option value="Depok">Depok</option>
                        <option value="Tangerang Kota">Tangerang Kota</option>
                        <option value="Tangerang Selatan">Tangerang Selatan</option>
                        <option value="Bogor Kota">Bogor Kota</option>
                        <option value="Bogor Kabupaten">Bogor Kabupaten</option>
                    </select>
                 
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="catatan">Alamat Penjemputan <?php echo form_error('alamat_jemput') ?></label>
                <div class="col-sm-12">
                    <textarea class="form-control" rows="6" name="alamat_jemput" id="alamat_jemput" placeholder="Alamat Penjemputan"><?php echo $alamat_jemput; ?></textarea>
                </div>
              </div>
              
             
                  <input type="hidden" class="form-control" oninput="myFunction();" name="blok_jemput" id="blok_jemput" placeholder="Blok" value="<?php echo $blok_jemput; ?>" />
             
              
             
                  <input type="hidden" class="form-control" oninput="myFunction();" name="no_jemput" id="no_jemput" placeholder="No Rumah Penjemputan" value="<?php echo $no_jemput; ?>" />
           
                  <input type="hidden" class="form-control" oninput="myFunction();" name="rt_jemput" id="rt_jemput" placeholder="RT/RW Penjemputan" value="<?php echo $rt_jemput; ?>" />
               
              
           
                  <input type="hidden" class="form-control" oninput="myFunction();" name="kelurahan_jemput" id="kelurahan_jemput" placeholder="Kelurahan Penjemputan" value="<?php echo $kelurahan_jemput; ?>" />
                
          
                  <input type="hidden" class="form-control" oninput="myFunction();" name="kecamatan_jemput" id="kecamatan_jemput" placeholder="Kecamatan Penjemputan" value="<?php echo $kecamatan_jemput; ?>" />
               
             
                  <input type="hidden" class="form-control" oninput="myFunction();" name="provinsi_jemput" id="provinsi_jemput" placeholder="Provinsi Penjemputan" value="<?php echo $provinsi_jemput; ?>" />
               
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Lantai Penjemputan <?php echo form_error('lantai') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="lantai" id="lantai" placeholder="Lantai" value="<?php echo $lantai; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Parkir Mobil Penjemputan <?php echo form_error('parkir_mobil') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="parkir_mobil" id="parkir_mobil" placeholder="Parkir Mobil" value="<?php echo $parkir_mobil; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Kota/Kabupaten Pengiriman <?php echo form_error('kota_kirim') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="kota_kirim" id="kota_kirim" placeholder="Kota/Kabupaten Pengiriman" value="<?php echo $kota_kirim; ?>" />
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="catatan">Alamat Pengantaran <?php echo form_error('alamat_antar') ?></label>
                <div class="col-sm-12">
                    <textarea class="form-control" rows="6" name="alamat_antar" id="alamat_antar" placeholder="Alamat Pengantaran"><?php echo $alamat_antar; ?></textarea>
                </div>
              </div>
              
              
             
                  <input type="hidden" class="form-control" oninput="myFunction();" name="blok_antar" id="blok_antar" placeholder="Blok Pengantaran" value="<?php echo $blok_antar; ?>" />
               
              
             
                  <input type="hidden" class="form-control" oninput="myFunction();" name="no_antar" id="no_antar" placeholder="No Rumah Pengantaran" value="<?php echo $no_antar; ?>" />
                
              
                  <input type="hidden" class="form-control" oninput="myFunction();" name="rt_antar" id="rt_antar" placeholder="RT/RW Pengantaran" value="<?php echo $rt_antar; ?>" />
               
              
             
                  <input type="hidden" class="form-control" oninput="myFunction();" name="kelurahan_antar" id="kelurahan_antar" placeholder="Kelurahan Pengantaran" value="<?php echo $kelurahan_antar; ?>" />
              
             
                  <input type="hidden" class="form-control" oninput="myFunction();" name="kecamatan_antar" id="kecamatan_antar" placeholder="Kecamatan Pengantaran" value="<?php echo $kecamatan_antar; ?>" />
              
              
                  <input type="hidden" class="form-control" oninput="myFunction();" name="provinsi_antar" id="provinsi_antar" placeholder="Provinsi Pengantaran" value="<?php echo $provinsi_antar; ?>" />
               

              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Lantai Pengiriman <?php echo form_error('lantai_kirim') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="lantai_kirim" id="lantai_kirim" placeholder="Lantai Kirim" value="<?php echo $lantai_kirim; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Parkir Mobil Pengiriman <?php echo form_error('parkir_mobil_kirim') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="parkir_mobil_kirim" id="parkir_mobil_kirim" placeholder="Parkir Mobil Kirim" value="<?php echo $parkir_mobil_kirim; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="double">Orang Bantuan Customer <?php echo form_error('bantuan_customer') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="bantuan_customer" id="bantuan_customer" placeholder="Bantuan Customer" value="<?php echo $bantuan_customer; ?>" />
                </div>
              </div>
	      
              <div class="form-group">
                <label class="col-sm-2 control-label" for="barang_customer">Barang Customer <?php echo form_error('barang_customer') ?></label>
                <div class="col-sm-12">
                    <textarea class="form-control" rows="3" name="barang_customer" id="barang_customer" placeholder="Barang Customer"><?php echo $barang_customer; ?></textarea>
                </div>
              </div>
	   
            
                 
             
	   
           
                 
            
	   
              
              
              
	   
            
              
              
	   
              
             
              
              
             
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="double">Argo <?php echo form_error('total_customer_bayar') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="total_customer_bayar" id="total_customer_bayar" placeholder="Argo" value="<?php echo $total_customer_bayar; ?>" onkeyup="sum()"/>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="double">Biaya Layanan <?php echo form_error('total_customer_bayar') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="biaya_layanan" id="biaya_layanan" placeholder="Biaya Layanan" value="<?php echo $biaya_layanan; ?>" readonly/>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="double">Ongkos Driver <?php echo form_error('total_customer_bayar') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="ongkos_driver" id="ongkos_driver" placeholder="Ongkos Driver" value="<?php echo $ongkos_driver; ?>" readonly/>
                </div>
              </div>
              
               <div class="form-group">
                <label class="col-sm-2 control-label" for="double">Biaya Tambahan</label>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-4">
                            Bantuan Driver
                         <input type="text" class="form-control" name="bantuan_driver" id="bantuan_driver" placeholder="Bantuan Driver" value="<?php echo $bantuan_driver; ?>" />
                        </div>
                        <div class="col-sm-4">
                             Bantuan Kenek
                         <input type="text" class="form-control" name="bantuan_kenek" id="bantuan_kenek" placeholder="Bantuan Kenek" value="<?php echo $bantuan_kenek; ?>" />
                        </div>
                         <div class="col-sm-4">
                             Biaya Tol
                          <input type="text" class="form-control" name="biaya_tol" id="biaya_tol" placeholder="Biaya Tol" value="<?php echo $biaya_tol; ?>" />
                        </div>
                         <div class="col-sm-4">
                             Biaya Overload
                          <input type="text" class="form-control" name="biaya_overload" id="biaya_overload" placeholder="Biaya Overload" value="<?php echo $biaya_overload; ?>" />
                        </div>
                         <div class="col-sm-4">
                            Waktu Tunggu
                              <input type="text" class="form-control" name="waktu_tunggu" id="waktu_tunggu" placeholder="Waktu Tunggu" value="<?php echo $waktu_tunggu; ?>" />
                        </div>
                         <div class="col-sm-4">
                           Hitung Pembayaran Customer
                              <input type="button" class="btn btn-danger btn-flat" value="Hitung Pembayaran Customer" onclick="hitung_total();"/>
                        </div>
                         <div class="col-sm-12">
                            Total Customer Bayar <?php echo form_error('total_bayar') ?>
                              <input type="text" class="form-control" name="total_bayar" required id="total_bayar"  placeholder="Total Customer Bayar" value="<?php echo $total_bayar; ?>" readonly/>
                        </div>
                    </div>
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Cara Pembayaran <?php echo form_error('cara_pembayaran') ?></label>
                <div class="col-sm-12">
                  <!-- <input type="text" class="form-control" name="cara_pembayaran" id="cara_pembayaran" placeholder="Cara Pembayaran" value="<?php echo $cara_pembayaran; ?>" /> -->
                  <select name="cara_pembayaran" id="cara_pembayaran" class="form-control">
                    <option value="<?=$cara_pembayaran?>" selected><?=$cara_pembayaran?></option>
                    <option value="CASH">CASH</option>
                    <option value="TRANSFER">TRANSFER</option>
                  </select>
                </div>
              </div>
	      
              <div class="form-group">
                <label class="col-sm-2 control-label" for="catatan">Catatan <?php echo form_error('catatan') ?></label>
                <div class="col-sm-12">
                    <textarea class="form-control" rows="3" name="catatan" id="catatan" placeholder="Catatan"><?php echo $catatan; ?></textarea>
                </div>
              </div>
	   
              <!-- <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Status <?php echo form_error('status') ?></label>
                <div class="col-sm-12"> -->
                  <input type="hidden" class="form-control" name="status" id="status" placeholder="Status" value="<?php echo $status; ?>" readonly/>
                <!-- </div>
              </div> -->
	   
              <!-- <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Status Pengantaran <?php echo form_error('status_pengantaran') ?></label>
                <div class="col-sm-12"> -->
                  <input type="hidden" class="form-control" name="status_pengantaran" id="status_pengantaran" placeholder="Status Pengantaran" value="<?php echo $status_pengantaran; ?>" readonly/>
                <!-- </div>
              </div> -->
	   
              <!-- <div class="form-group">
                <label class="col-sm-2 control-label" for="int">Driver <?php echo form_error('driver') ?></label>
                <div class="col-sm-12"> -->
                  <input type="hidden" class="form-control" name="driver" id="driver" placeholder="Driver" value="<?php echo $driver; ?>" readonly/>
                <!-- </div>
              </div> -->
	   
             
                  <input type="hidden" class="form-control" name="created_at" id="created_at" placeholder="Created At" value="<?php echo $created_at; ?>" />
               
	   
     
        <div class="card-footer text-left">
        <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><span class="fa fa-edit"></span><?php echo $button ?></button> 
	    <a href="<?php echo site_url('orders') ?>" class="btn btn-icon icon-left btn-success">Cancel</a>
	
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
</div>
<script>
var fnf = document.getElementById('total_customer_bayar');

$(document).ready(function() {
    $('#total_customer_bayar').on('keyup', formatNumberField);
    $('#bantuan_driver').on('keyup', formatNumberField);
    $('#bantuan_kenek').on('keyup', formatNumberField);
    $('#biaya_tol').on('keyup', formatNumberField);
    $('#biaya_overload').on('keyup', formatNumberField);
    $('#waktu_tunggu').on('keyup', formatNumberField);
});

    function formatNumberField() {
    // unformat the value
    var value = this.value.replace(/\D/g,'');

    // split value into (leading digits, 3*x digits, decimal part)
    // also allows numbers like ',5'; if you don't want that,
    // use /^(\d{1,3})((?:\d{3})*))((?:,\d*)?)$/ instead
    var matches = /^(?:(\d{1,3})?((?:\d{3})*))((?:,\d*)?)$/.exec(value);

    if (!matches) {
        // invalid format; deal with it however you want to
        // this just stops trying to reformat the value
        return;
    }

    // add a space before every group of three digits
    var spaceified = matches[2].replace(/(\d{3})/g, ',$1');

    // now splice it all back together
    this.value = [matches[1], spaceified, matches[3]].join('');
}

</script>
<script type="text/javascript">
      $(function () {
          $('#datetimepicker3').datetimepicker({
            use24hours: true,
            format:'HH:mm:ss'
          });
      });

 $(function() {
    $('input').keyup(function() {
        // Uppercase-ize contents
        this.value = this.value.toLocaleUpperCase();
    });
      $('select').keyup(function() {
        // Uppercase-ize contents
        this.value = this.value.toLocaleUpperCase();
    });
    $('#catatan').keyup(function() {
        // Uppercase-ize contents
        this.value = this.value.toLocaleUpperCase();
    });
    $('#alamat_antar').keyup(function() {
        // Uppercase-ize contents
        this.value = this.value.toLocaleUpperCase();
    });
    $('#alamat_jemput').keyup(function() {
        // Uppercase-ize contents
        this.value = this.value.toLocaleUpperCase();
    });
});


function sum() {
  <?php $i = $this->db->query("SELECT * FROM setting_potongan where status='Active' Limit 1")->row()->potongan;?>
      var bantuan_driver = $('#bantuan_driver').val();
      var bantuan_kenek = $('#bantuan_kenek').val();
      var biaya_tol = $('#biaya_tol').val();
      var biaya_overload = $('#biaya_overload').val();
      var waktu_tunggu = $('#waktu_tunggu').val();
      var str = $('#total_customer_bayar').val();
      var result = str.replace(/,/g, '');
      var biaya_layanan ="<?= $i?>";
      if(bantuan_driver == undefined || bantuan_driver== ""){
        bantuan_driver = 0;
        $('#bantuan_driver').val(0);
      }
      if(bantuan_kenek==undefined || bantuan_kenek ==""){
        bantuan_kenek=0;
        $('#bantuan_kenek').val(0);
      }
       if(biaya_tol==undefined || biaya_tol == ""){
        biaya_tol=0;
        $('#biaya_tol').val(0);
      }
       if(biaya_overload==undefined || biaya_overload==""){
        biaya_overload=0;
        $('#biaya_overload').val(0);
      }
       if(waktu_tunggu==undefined || waktu_tunggu==""){
        waktu_tunggu=0;
        $('#waktu_tunggu').val(0);
      }

      if (!isNaN(result)) {
            var biaya_layanans = ((result * biaya_layanan) / 100);
          
            document.getElementById('biaya_layanan').value = biaya_layanans.toLocaleString();
            var ongkos = result - biaya_layanans;
            document.getElementById('ongkos_driver').value = ongkos.toLocaleString();
            
        }else{
            // document.getElementById('total_customer_bayar').value=0;     
            document.getElementById('biaya_layanan').value=0;     
            document.getElementById('ongkos_driver').value=0;     
        }

    }


    function hitung_total(){
      var bantuan_driver = $('#bantuan_driver').val();
      var bantuan_kenek = $('#bantuan_kenek').val();
      var biaya_tol = $('#biaya_tol').val();
      var biaya_overload = $('#biaya_overload').val();
      var waktu_tunggu = $('#waktu_tunggu').val();
      var argo = $('#total_customer_bayar').val();
      var result = parseFloat(argo.replace(/,/g, '')) + parseFloat(bantuan_driver.replace(/,/g, '')) + parseFloat(bantuan_kenek.replace(/,/g, '')) + parseFloat(biaya_tol.replace(/,/g, '')) + parseFloat(biaya_overload.replace(/,/g, '')) + parseFloat(waktu_tunggu.replace(/,/g, ''))
      
      if (!isNaN(result)) {
            document.getElementById('total_bayar').value = result.toLocaleString();
      }else{
           document.getElementById('total_bayar').value = 0;
      }
    }


    function onloading(){
      var bantuan_driver = $('#bantuan_driver').val();
      var bantuan_kenek = $('#bantuan_kenek').val();
      var biaya_tol = $('#biaya_tol').val();
      var biaya_overload = $('#biaya_overload').val();
      var waktu_tunggu = $('#waktu_tunggu').val();
      var biaya_layanan ="<?= $i?>";
      if(bantuan_driver == undefined || bantuan_driver== ""){
        bantuan_driver = 0;
        $('#bantuan_driver').val(0);
      }
      if(bantuan_kenek==undefined || bantuan_kenek ==""){
        bantuan_kenek=0;
        $('#bantuan_kenek').val(0);
      }
       if(biaya_tol==undefined || biaya_tol == ""){
        biaya_tol=0;
        $('#biaya_tol').val(0);
      }
       if(biaya_overload==undefined || biaya_overload==""){
        biaya_overload=0;
        $('#biaya_overload').val(0);
      }
       if(waktu_tunggu==undefined || waktu_tunggu==""){
        waktu_tunggu=0;
        $('#waktu_tunggu').val(0);
      }
    }
</script>
    <?php $potongan = $this->db->query("SELECT * FROM setting_potongan where status='Active' LIMIT 1")->row();?>
    <?php if($potongan->potongan ==null || $potongan->potongan ==""){
      echo "<script>
        confirm('Setting potongan biaya layanan belum dilakukan, mohon untuk melakukan setting terlebih dahulu');
        if(confirm){
          window.location='"; echo base_url('setting_potongan')."';";
        echo "}
      </script>";
    }?>