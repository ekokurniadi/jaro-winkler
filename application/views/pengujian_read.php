
 <div class="main-content">
<section class="section">
  <div class="section-header">
    <h1> Pengujian </h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></div>
      <div class="breadcrumb-item"><a href="#"> Pengujian </a></div>
    </div>
  </div>

  <div class="section-body">
  <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
        <div class="card-header bg-primary">
            <h4 style="color:white;">Detail Normalisasi </h4>
        </div>

        <div class="card-header bg-warning" style="color:white">
            <h4 style="color:white;">Kalimat </h4>
            <input type="text" class="form-control" name="kata2" readonly id="kata2" placeholder="Kalimat" value="<?=$kalimat_asal?>">
            <input type="hidden" class="form-control" name="kata" readonly id="kata" placeholder="Kalimat" value="<?=$kalimat?>">
            <input type="hidden" class="form-control" name="generateId" id="generateId" placeholder="Kalimat">
        </div>
          <div class="card-body">
          <div>
            <button onclick="back();" class="btn btn-primary btn-flat"><span class="fa fa-arrow-left"></span> Back</button>
          </div>
          <br>
          <div style="text-align:center;vertical-align: middle;" id="loading">
                        <img src="<?=base_url('image/loading.gif')?>" alt="" class="img-fluid">
                        <p>Sedang Memproses...</p>
                      </div>
                    <div class="row">
                          <div class="col-md-12 text-center">
                            <div style="margin-top: 8px" id="message">
                                <div class="alert alert-success alert-dismissable">
                                  <strong>Successfully</strong>
                                  <button class="close" onclick="hideNotif();" data-dismiss="alert">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                  </button>
                                </div>
                            </div>
                          </div>
                      </div>
                      <div class="table-responsive">
                           <div id="list_ku"></div>
                        </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</div>
<script>
        function back(){
          history.back();
        }
        function load_data_temp(response)
        {
            var kalimat = $('#kata2').val();
            $.ajax({
                type:"POST",
                url:"<?php echo base_url('pengujian/load_template2')?>",
                data:{result:response,kalimat:kalimat},
                beforeSend:function(){
                  $('#loading').show();
                },
                success:function(ajaxHtml){
                    $('#list_ku').html(ajaxHtml);
                    $('#loading').hide();
                }
            });
            
        }
        $('#loading').hide();
        $('#message').hide();
        $(document).ready(function() {
      
        var kalimat = $("#kata").val(); 
        var id = $("#generateId").val(); 
        var html ='';
        if(kalimat == ""){
            alert('Kalimat masih kosong');
            return false;
        }else{
            $.ajax({
          type:'POST',
          dataType:'JSON', 
          data:{kalimat:kalimat,id:id},
          url:'<?php echo base_url('pengujian/uji')?>',
          beforeSend: function() {
                  $('#loading').show();
                  $('#submitBtn').html('<i class="fa fa-spinner fa-spin"></i> Process');
                  $('#submitBtn').attr('disabled', true);
                },
          success:function(response) {
                  load_data_temp(response);
                 
                  $('#submitBtn').html('Start');
                  $('#submitBtn').attr('disabled', false);
                
                  dataTable.draw();
                  $('#message').show();
                  generate();
                
          },
          error: function() {
                  $('#loading').hide();
                  // alert("Something Went Wrong !");
                  $('#submitBtn').html('Start');
                  $('#submitBtn').attr('disabled', false);
                
                  dataTable.draw();
                  generate();
                }
        });
        }
      });
      function generate(){
        var number = parseInt(10);
        $.ajax({
          type:'POST',
          dataType:'JSON',
          data:{},
          url:'<?php echo base_url('pengujian/acak/10')?>',
          success:function(response){
            $('#generateId').val(response.data);
          }
        });
      }
      function hideNotif(){
        $('#message').hide();
      }
      </script>