
 <div class="main-content">
<section class="section">
  <div class="section-header">
    <h1> Driver </h1>
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
                <label class="col-sm-2 control-label" for="varchar">Alamat <?php echo form_error('alamat') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat" value="<?php echo $alamat; ?>" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Kota <?php echo form_error('kota') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="kota" id="kota" placeholder="kota" value="<?php echo $kota; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Foto Profil <?php echo form_error('foto_profil') ?></label>
                <?php if($button=="Read"){?>
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-sm-5">
                      <input type="file" class="form-control" name="foto_profil" id="foto_profil" placeholder="Foto Sim" value="<?php echo $foto_profil; ?>" />
                    </div>
                    <div class="col-sm-5">
                        <img src="<?php echo base_url()."/image/".$foto_profil?>" alt="" class="img-fluid">
                    </div>
                  </div>
                    <?php } else {?>
                  <div class="col-sm-12">
                    <input type="file" class="form-control" name="foto_profil" id="foto_profil" placeholder="Foto Stnk" value="<?php echo $foto_profil; ?>" />
                    <?php }?>
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
                <?php if($button=="Read"){?>
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-sm-5">
                      <input type="file" class="form-control" name="foto_sim" id="foto_sim" placeholder="Foto Sim" value="<?php echo $foto_sim; ?>" />
                    </div>
                    <div class="col-sm-5">
                        <img src="<?php echo base_url()."/image/".$foto_sim?>" alt="" class="img-fluid">
                    </div>
                  </div>
                    <?php } else {?>
                  <div class="col-sm-12">
                    <input type="file" class="form-control" name="foto_sim" id="foto_sim" placeholder="Foto Stnk" value="<?php echo $foto_sim; ?>" />
                    <?php }?>
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
                <?php if($button=="Read"){?>
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-sm-5">
                      <input type="file" class="form-control" name="foto_stnk" id="foto_stnk" placeholder="Foto Sim" value="<?php echo $foto_stnk; ?>" />
                    </div>
                    <div class="col-sm-5">
                        <img src="<?php echo base_url()."/image/".$foto_stnk?>" alt="" class="img-fluid">
                    </div>
                  </div>
                    <?php } else {?>
                  <div class="col-sm-12">
                    <input type="file" class="form-control" name="foto_stnk" id="foto_stnk" placeholder="Foto Stnk" value="<?php echo $foto_stnk; ?>" />
                    <?php }?>
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
                <?php if($button=="Read"){?>
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-sm-5">
                      <input type="file" class="form-control" name="foto_kir" id="foto_kir" placeholder="Foto Sim" value="<?php echo $foto_kir; ?>" />
                    </div>
                    <div class="col-sm-5">
                        <img src="<?php echo base_url()."/image/".$foto_kir?>" alt="" class="img-fluid">
                    </div>
                  </div>
                    <?php } else {?>
                  <div class="col-sm-12">
                    <input type="file" class="form-control" name="foto_kir" id="foto_kir" placeholder="Foto Stnk" value="<?php echo $foto_kir; ?>" />
                    <?php }?>
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
	   
              <!-- <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Level <?php echo form_error('level') ?></label>
                <div class="col-sm-12"> -->
                  <input type="hidden" class="form-control" name="level" id="level" placeholder="Level" value="<?php echo $level; ?>" readonly/>
                <!-- </div>
              </div> -->
	   
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
	    <!-- <button type="submit" class="btn btn-primary"><span class="fa fa-edit"></span><?php echo $button ?></button>  -->
	    <a href="<?php echo site_url('driver') ?>" class="btn btn-icon icon-left btn-success">Cancel</a>
	
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
</div>
