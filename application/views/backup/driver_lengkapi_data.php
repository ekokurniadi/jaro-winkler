<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Dashboard</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

   <!-- CSS Libraries -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">

  <!-- load library chart js -->
<!--   
  <script src="<?php echo base_url() ?>plugin/chartjs/Chart.js">
  <script src="<?php echo base_url() ?>plugin/chartjs/Chart.min.js"> -->

  <!-- load jquery CDN -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

  <!-- Template CSS -->
  <link rel="stylesheet" href="<?php echo base_url()?>/assets/css/style.css">
  <link rel="stylesheet" href="<?php echo base_url()?>/assets/css/components.css">

  <!-- komponen text area -->
  <link href="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/js/froala_editor.pkgd.min.js"></script>    

 
</head>
01355
<body>
 <div >
<section class="section">
  <div class="section-header">
    <h1> Lengkapi Data Driver </h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></div>
      <div class="breadcrumb-item"><a href="#"> Driver </a></div>
    </div>
  </div>

  <div class="section-body">
  <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
        <div class="card-header">
            <h4>Form Driver </h4>
        </div>
        <form action="<?php echo $action; ?>" method="post" class="form-horizontal" enctype="multipart/form-data">
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Username <?php echo form_error('username') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?php echo $username; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Password <?php echo form_error('password') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo $password; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Nama <?php echo form_error('nama') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama" value="<?php echo $nama; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Foto Profil <?php echo form_error('foto_profil') ?></label>
                <div class="col-sm-12">
                  <input type="file" class="form-control" name="foto_profil" id="foto_profil" placeholder="Foto Profil" value="<?php echo $foto_profil; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Nomor Wa <?php echo form_error('nomor_wa') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="nomor_wa" id="nomor_wa" placeholder="Nomor Wa" value="<?php echo $nomor_wa; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Plat Kendaraan <?php echo form_error('plat_kendaraan') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="plat_kendaraan" id="plat_kendaraan" placeholder="Plat Kendaraan" value="<?php echo $plat_kendaraan; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Jenis Mobil <?php echo form_error('jenis_mobil') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="jenis_mobil" id="jenis_mobil" placeholder="Jenis Mobil" value="<?php echo $jenis_mobil; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Tahun Kendaraan <?php echo form_error('tahun_kendaraan') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="tahun_kendaraan" id="tahun_kendaraan" placeholder="Tahun Kendaraan" value="<?php echo $tahun_kendaraan; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="date">Masa Aktif Sim <?php echo form_error('masa_aktif_sim') ?></label>
                <div class="col-sm-12">
                  <input type="date" class="form-control" name="masa_aktif_sim" id="masa_aktif_sim" placeholder="Masa Aktif Sim" value="<?php echo $masa_aktif_sim; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Foto Sim <?php echo form_error('foto_sim') ?></label>
                <div class="col-sm-12">
                  <input type="file" class="form-control" name="foto_sim" id="foto_sim" placeholder="Foto Sim" value="<?php echo $foto_sim; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="date">Masa Aktif Stnk <?php echo form_error('masa_aktif_stnk') ?></label>
                <div class="col-sm-12">
                  <input type="date" class="form-control" name="masa_aktif_stnk" id="masa_aktif_stnk" placeholder="Masa Aktif Stnk" value="<?php echo $masa_aktif_stnk; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Foto Stnk <?php echo form_error('foto_stnk') ?></label>
                <div class="col-sm-12">
                  <input type="file" class="form-control" name="foto_stnk" id="foto_stnk" placeholder="Foto Stnk" value="<?php echo $foto_stnk; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="date">Masa Aktif Kir <?php echo form_error('masa_aktif_kir') ?></label>
                <div class="col-sm-12">
                  <input type="date" class="form-control" name="masa_aktif_kir" id="masa_aktif_kir" placeholder="Masa Aktif Kir" value="<?php echo $masa_aktif_kir; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Foto Kir <?php echo form_error('foto_kir') ?></label>
                <div class="col-sm-12">
                  <input type="file" class="form-control" name="foto_kir" id="foto_kir" placeholder="Foto Kir" value="<?php echo $foto_kir; ?>" />
                </div>
              </div>
	   
              <!-- <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Token <?php echo form_error('token') ?></label>
                <div class="col-sm-12"> -->
                  <input type="hidden" class="form-control" name="token" id="token" placeholder="Token" value="<?php echo $token; ?>" />
                <!-- </div>
              </div> -->
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="int">Status <?php echo form_error('status') ?></label>
                <div class="col-sm-12">
                <select name="status" id="status" class="form-control">
                <option value="<?=$status?>" selected>Aktif</option>
                <option value="0" selected>Tidak Aktif</option>
                <option value="1" selected>Aktif</option>
                </select>
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Level <?php echo form_error('level') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="level" id="level" placeholder="Level" value="<?php echo $level; ?>" readonly/>
                </div>
              </div>
	   
              <!-- <div class="form-group">
                <label class="col-sm-2 control-label" for="int">Status Online <?php echo form_error('status_online') ?></label>
                <div class="col-sm-12"> -->
                  <input type="hidden" class="form-control" name="status_online" id="status_online" placeholder="Status Online" value="<?php echo $status_online; ?>" />
                <!-- </div>
              </div> -->
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="double">Saldo <?php echo form_error('saldo') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="saldo" id="saldo" placeholder="Saldo" value="<?php echo $saldo; ?>" readonly/>
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="int">Confirm <?php echo form_error('confirm') ?></label>
                <div class="col-sm-12">
                <select name="confirm" id="confirm" class="form-control">
                <option value="<?=$confirm?>" selected>Confirmed</option>
                <option value="0" selected>Unconfirm</option>
                <option value="1" selected>Confirmed</option>
                </select>
                </div>
              </div>
	   
     
        <div class="card-footer text-left">
        <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><span class="fa fa-edit"></span><?php echo $button ?></button> 
	    <a href="<?php echo site_url('driver') ?>" class="btn btn-icon icon-left btn-success">Cancel</a>
	
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
</div>
  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="<?php echo base_url()?>/assets/js/stisla.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modal.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modal.min.js"></script>

  <!-- load script chart js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
  <!-- Template JS File -->
  <script src="<?php echo base_url()?>/assets/js/scripts.js"></script>
  <script src="<?php echo base_url()?>/assets/js/custom.js"></script>

  <!-- Page Specific JS File -->
 <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
 <script src=" https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script> 
 <script src=" https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script> 
 <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
 <script src="assets/js/page/forms-advanced-forms.js"></script>
  
  <script>
  // In your Javascript (external .js resource or <script> tag)
  $(document).ready(function() {
    // load select2
    $('#pilihan').select2(
      {
      width: 'resolve',
      placeholder:"Select an option"
    }
    );

  });
  $(document).ready(function() {
    // load select2
    $('#kode_barang').select2(
      {
      width: 'resolve',
      placeholder:"Select an option"
    }
    );

  });

  $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4'
        });
  $('#datepicker2').datepicker({
            uiLibrary: 'bootstrap4'
        });
  </script>
 
 <script>
var ctx = document.getElementById('barChart').getContext('2d');
var data_nama =[];
var data_stok =[];

$.post("<?php echo base_url('dashboard/get_data') ?>",
  function(data){
    var obj = JSON.parse(data);
    $.each(obj,function(test,item){
      data_nama.push(item.nama_barang);
      data_stok.push(item.qty);
    });
  
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: data_nama,
        datasets: [{
            label: 'Jumlah barang',
            data:data_stok ,
            backgroundColor: [
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)',
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)'
            ],
            borderColor: [
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)',
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        layout: {
            padding: {
                left: 0,
                right: 0,
                top: 0,
                bottom: 0
            }
        }
    }
});

});
</script> 

<script>
var ctx2 = document.getElementById('barChart2').getContext('2d');
var data_nama2 =[];
var data_stok2 =[];

$.post("<?php echo base_url('dashboard/get_data') ?>",
  function(data2){
    var obj = JSON.parse(data2);
    $.each(obj,function(test,item){
      data_nama2.push(item.nama_barang);
      data_stok2.push(item.qty);


    });
  
var myChart2 = new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: data_nama2,
        datasets: [{
            label: 'Jumlah barang',
            data:data_stok2 ,
            backgroundColor: [
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)',
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)'
            ],
            borderColor: [
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)',
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        layout: {
            padding: {
                left: 0,
                right: 0,
                top: 0,
                bottom: 0
            }
        }
    }
});

});
</script> 
</body>
</html>