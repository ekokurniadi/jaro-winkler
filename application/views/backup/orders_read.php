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
        <form action="" method="post" class="form-horizontal">
	   
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
                <label class="col-sm-2 control-label" for="varchar">Kota Penjemputan <?php echo form_error('kota') ?></label>
                <div class="col-sm-12" style="text-transform: uppercase">
                  <input type="text" class="form-control" oninput="myFunction();" name="kota" id="kota" placeholder="Kota" value="<?php echo $kota; ?>" />
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="catatan">Alamat Penjemputan <?php echo form_error('catatan') ?></label>
                <div class="col-sm-12">
                    <textarea class="form-control" rows="3" name="alamat_jemput" id="alamat_jemput" placeholder="Alamat Penjemputan"><?php echo $alamat_jemput; ?></textarea>
                </div>
              </div>
	   
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
                <label class="col-sm-2 control-label" for="varchar">Kota Pengiriman <?php echo form_error('kota_kirim') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="kota_kirim" id="kota_kirim" placeholder="Kota Kirim" value="<?php echo $kota_kirim; ?>" />
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="catatan">Alamat Pengantaran <?php echo form_error('catatan') ?></label>
                <div class="col-sm-12">
                    <textarea class="form-control" rows="3" name="alamat_antar" id="alamat_antar" placeholder="Alamat Pengantaran"><?php echo $alamat_antar; ?></textarea>
                </div>
              </div>

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
                <label class="col-sm-2 control-label" for="double">Biaya Bantuan Driver <?php echo form_error('bantuan_driver') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="bantuan_driver" id="bantuan_driver" placeholder="Bantuan Driver" value="<?php echo $bantuan_driver; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="double">Biaya Bantuan Kenek <?php echo form_error('bantuan_kenek') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="bantuan_kenek" id="bantuan_kenek" placeholder="Bantuan Kenek" value="<?php echo $bantuan_kenek; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="double">Biaya Biaya Tol <?php echo form_error('biaya_tol') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="biaya_tol" id="biaya_tol" placeholder="Biaya Tol" value="<?php echo $biaya_tol; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="double">Biaya Biaya Overload <?php echo form_error('biaya_overload') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="biaya_overload" id="biaya_overload" placeholder="Biaya Overload" value="<?php echo $biaya_overload; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="double">Biaya Waktu Tunggu <?php echo form_error('waktu_tunggu') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="waktu_tunggu" onkeyup="sum()" id="waktu_tunggu" placeholder="Waktu Tunggu" value="<?php echo $waktu_tunggu; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="double">Total Customer Bayar <?php echo form_error('total_customer_bayar') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="total_customer_bayar" id="total_customer_bayar" placeholder="Total Customer Bayar" value="<?php echo $total_customer_bayar; ?>" readonly/>
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
	    
	    <a href="<?php echo site_url('orders') ?>" class="btn btn-icon icon-left btn-success">Cancel</a>
	
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
</div>
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
      var result = parseFloat(bantuan_driver) + parseFloat(bantuan_kenek) + parseFloat(biaya_tol) + parseFloat(biaya_overload) + parseFloat(waktu_tunggu);

      if (!isNaN(result)) {
            document.getElementById('total_customer_bayar').value = result;
            document.getElementById('biaya_layanan').value = ((result * biaya_layanan) / 100);
            document.getElementById('ongkos_driver').value = result - document.getElementById('biaya_layanan').value;
            
        }else{
            document.getElementById('total_customer_bayar').value=0;     
            document.getElementById('biaya_layanan').value=0;     
            document.getElementById('ongkos_driver').value=0;     
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