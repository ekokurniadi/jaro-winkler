<body onload="generate();hideNotif();load_data_temp();">
<div class="main-content">
<section class="section">
  <div class="section-header">
    <h1> Normalisasi </h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></div>
      <div class="breadcrumb-item"><a href="#">Normalisasi </a></div>
    </div>
  </div>
  

          <div class="section-body">
          
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Form Input</h4>
                  </div>
                  
                  <div class="card-body">
                      <form action="" method="post">
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="varchar">Kalimat</label>
                        <div class="col-sm-12">
                          <input type="text" class="form-control" name="kata" id="kata" placeholder="Kalimat"/>
                          <input type="hidden" class="form-control" name="generateId" id="generateId" placeholder="Kata"/>
                        
                        </div>
                      </div>
                      <div style="text-align:center;vertical-align: middle;" id="loading">
                        <img src="<?=base_url('image/loading.gif')?>" alt="" class="img-fluid">
                        <p>Sedang Memproses...</p>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="varchar"></label>
                        <div class="col-sm-12">
                        <button type="button" id='submitBtn' name="process" class="btn btn-info btn-flat">Start</button>
                        </div>
                      </div>
                      </form>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="varchar"></label>
                        <div class="col-sm-12">
                            Hasil Normalisasi
                        </div>
                        <div class="col-sm-12">
                        <div class="table-responsive">
                           <div id="list_ku"></div>
                        </div>
                        </div>
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
                  </div>
                 
                </div>
                
              </div>
            </div>
            
            <!-- <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <div class="container-fluid">
                        <div class="row">
                          <div class="col-md-4">
                            <h5>Hasil Pengujian</h5>
                          </div>
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
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                    <table id="example1" class="table" style="min-width:100%;">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>ID Pengujian</th>
                          <th>Teks</th>
                          <th>Cleaning</th>
                          <th>Casefolding</th>
                          <th>Tokenizing</th>
                          <th>Stemming</th>
                          <th>Rekomendasi</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody></tbody>
                    </table>
                    <script>
                          $(document).ready(function() {
                          dataTable = $('#example1').DataTable({
                              "processing": true,
                              "serverSide": true,
                              "scrollX": false,
                              "language": {
                                "infoFiltered": "",
                                "processing": "",
                              },
                              "order": [],
                              "lengthMenu": [
                                [10, 25, 50, 75, 100],
                                [10, 25, 50, 75, 100]
                              ],
                              "ajax": {
                                url: "<?php echo site_url('pengujian/fetch_data'); ?>",
                                type: "POST",
                                dataSrc: "data",
                                data: function(d) {
                                  return d;
                                },
                              },
                              "columnDefs": [
                                {
                                  "targets": [0],
                                  "className": 'text-center'
                                },
                              ],
                            });
                            dataTable.on('draw.dt', function() {
                            var info = dataTable.page.info();
                            dataTable.column(0, {
                                search: 'applied',
                                order: 'applied',
                                page: 'applied'
                            }).nodes().each(function(cell, i) {
                                cell.innerHTML = i + 1 + info.start + ".";
                            });
                          });
                          });
                        </script>
                    </div>
                  </div>
                  <div class="card-footer text-right">
             
                  </div>
                </div>
              </div>
            </div> -->
          </div>
        </section>
        <div class="row">
        <div class="col-md-6">
          
	    </div>
       
    </div>
      </div>

      <script>
        function load_data_temp(response)
        {
            $.ajax({
                type:"POST",
                url:"<?php echo base_url('pengujian/load_template')?>",
                data:{result:response},
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
        $("#submitBtn").click(function(e) {
        e.preventDefault();
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
                  $("#kata").val('');
                  dataTable.draw();
                  $('#message').show();
                  generate();
                
          },
          error: function() {
                  $('#loading').hide();
                  // alert("Something Went Wrong !");
                  $('#submitBtn').html('Start');
                  $('#submitBtn').attr('disabled', false);
                  $("#kata").val('');
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
      