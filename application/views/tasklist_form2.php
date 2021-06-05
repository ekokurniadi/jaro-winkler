
 <div class="main">
  <div class="section-body">
  <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
        <div class="card-header">
        
            <h4>Target Operasi </h4>
        </div>
        <form action="<?php echo base_url('tasklist/update_action2')?>" method="post" class="form-horizontal">
	   
             
                  <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Nomor Tugas <?php echo form_error('Nomor Tugas') ?></label>
                <div class="col-sm-12">
                  <!-- <input type="text" class="form-control" name="klasifikasi" id="klasifikasi" readonly placeholder="Klasifikasi" value="<?php echo $klasifikasi; ?>" /> -->
                  <input type="text" class="form-control" name="task_id" id="task_id" readonly placeholder="Nomor Tugas" value="<?php echo $task_id; ?>" />
                </div>
              </div>
	   
              <div class="form-group" id="datetimepicker3" data-target-input="nearest">
                <label class="col-sm-2 control-label" for="date">Tanggal <?php echo form_error('date') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker3" data-toggle="datetimepicker" name="date" id="date" placeholder="Date" value="<?php echo $date; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Grup <?php echo form_error('groups') ?></label>
                <div class="col-sm-12">
                <select name="groups" id="groups" class="form-control">
                <option value="<?=$groups?>">Choose</option>
                <?php 
                    if($_SESSION['level']=="Admin"){
                      $data = $this->db->query("SELECT * from grup");
                    }else{
                      $data = $this->db->query("SELECT * from grup where nama_up3='$area'");
                    }
                  ?>
                  <?php foreach($data->result() as $rows):?>
                    <option value="<?=$rows->id?>"><?=$rows->group?> (<?=$rows->nama_up3?>)</option>
                  <?php endforeach;?>
                 </select>
                </div>
              </div>
	   
              <div class="form-group">
                <!-- <label class="col-sm-2 control-label" for="varchar">Id Pelanggan <?php echo form_error('customer_id') ?></label>
                <label class="col-sm-3 control-label" for="varchar">Nama Pelanggan <?php echo form_error('customer_id') ?></label>
                <label class="col-sm-3 control-label" for="varchar">Alamat <?php echo form_error('customer_id') ?></label>
                <label class="col-sm-2 control-label" for="varchar">Status Panggilan <?php echo form_error('customer_id') ?></label> -->
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-sm-2">
                    Id Pelanggan
                      <input type="text" class="form-control" readonly name="customer_id" id="customer_id" placeholder="Id Pelanggan" value="<?php echo $customer_id; ?>" />
                    </div>
                    <div class="col-sm-3">
                    Nama Pelanggan
                      <input type="text" class="form-control" readonly name="customer_name" id="customer_name" placeholder="Nama Pelanggan" value="<?=$customer_name?>" />
                    </div>
                    <div class="col-sm-3">
                    Alamat
                      <input type="text" class="form-control" readonly name="address" id="address" placeholder="Alamat" value="<?=$address?>" />
                    </div>
                    <div class="col-sm-2">
                    Status Panggilan
                      <input type="text" class="form-control" readonly name="dial_status" id="dial_status" placeholder="Status Panggilan" value="<?=$dial_status?>" />
                    </div>
                   
                  </div> 
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Indikasi <?php echo form_error('indikasi') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="indikasi" id="indikasi" placeholder="Indikasi" value="<?php echo $indikasi; ?>" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Lama Offline (Hari) <?php echo form_error('klasifikasi') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="klasifikasi" id="klasifikasi" readonly placeholder="Klasifikasi" value="<?php echo $klasifikasi; ?>" />
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Status <?php echo form_error('task_status') ?></label>
                <div class="col-sm-12">
                <?php if($button != "Update"){?>
                  <select name="task_status" id="task_status" class="form-control" readonly>
                    <option value="<?=$task_status == "" ? "Belum" : $task_status ?>"><?=$task_status == "" ? "Belum" : $task_status ?></option>
                    <option value="Belum">Belum</option>
                    <option value="OTW">OTW</option>
                    <option value="Proses">Proses</option>
                    <option value="Selesai">Selesai</option>
                  </select>
                  <?php } else{ ?>
                    <input type="text" id="task_status" name="task_status" value="<?=$task_status?>" class="form-control" readonly>
                  <?php } ?>
                </div>
              </div>
              
     
        <div class="card-footer text-left">
        <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
        <input type="hidden" name="level" value="<?php echo $level; ?>" /> 
        <input type="hidden" name="area" value="<?php echo $area; ?>" /> 
	    <button type="submit" class="btn btn-primary"><span class="fa fa-edit"></span><?php echo $button ?></button> 
	
	    <a href="#" onclick="history.go(-1)" class="btn btn-icon icon-left btn-success">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
</div>

<script>
function getCustomer(id) {
          $.ajax({
            beforeSend: function() {
              $('#searchCustomer').attr('disabled', true);
              $('#searchCustomer').html('<i class="fa fa-spinner fa-spin">');
            },
            url: '<?= base_url('dial_status/getById') ?>',
            type: "POST",
            data: {id},
            cache: false,
            dataType: 'JSON',
            success: function(response) {
              console.log(response);
              if (response.status == 'sukses') {
                $('#customer_id').val(response.value.id);   
                $('#customer_name').val(response.value.name);   
                $('#address').val(response.value.address);   
                $('#dial_status').val(response.value.dial_state);   
                $('#klasifikasi').val(response.value.klasifikasi);   
              } else {
                alert(response.pesan);
              }
              $('#searchCustomer').attr('disabled', false);
              $('#searchCustomer').html('<i class="fa fa-search">');
            },
            error: function() {
              alert("Something Went Wrong !");
              $('#searchCustomer').attr('disabled', false);
              $('#searchCustomer').html('<i class="fa fa-search">');

            }
          });
        }

</script>