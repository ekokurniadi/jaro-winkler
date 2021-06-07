
<div class="main-content">
<section class="section">
  <div class="section-header">
    <h1> Pengujian </h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></div>
      <div class="breadcrumb-item"><a href="#">Pengujian </a></div>
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
                        <label class="col-sm-2 control-label" for="varchar">Kata</label>
                        <div class="col-sm-12">
                          <input type="text" class="form-control" name="kata" id="kata" placeholder="Kata"/>
                          <input type="text" class="form-control" name="generateId" id="generateId" placeholder="Kata" value="<?=$generatedID?>"/>
                        
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="varchar"></label>
                        <div class="col-sm-12">
                          <input type="button" name="update" id="update" value="Mulai" class="btn btn-danger btn-md">
                        </div>
                      </div>
                      </form>
                  </div>
                 
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <div class="col-md-4">
                      <h5>Hasil Pengujian</h5>
                    </div>
                  <div class="col-md-4 text-center">
                      <div style="margin-top: 8px" id="message">
                       <h5> <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h5>
                      </div>
                  </div>

                  <div class="col-md-1 text-right">
                  </div>

                  <div class="col-md-3 text-right">
                    
                  </div>

                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                    <table id="example1" class="table" style="min-width:100%;">
                      <thead>
                        <tr>
                          <th>No</th>
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
                    </table><script>
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
            </div>
          </div>
        </section>
        <div class="row">
        <div class="col-md-6">
          
	    </div>
       
    </div>
      </div>

      <script>
        $("#update").click(function(e) {
        e.preventDefault();
        var kalimat = $("#kata").val(); 
        var id = $("#generateId").val(); 
        $.ajax({
          type:'POST',
          data:{kalimat:kalimat,id:id},
          dataType:'JSON', 
          url:'<?php echo base_url('pengujian/pengujian_kalimat')?>',
          success:function(response) {
            for(var i=0;i<response.data.length;i++){
              console.warn("cleaning "+ i + response.data[i].cleaning);
              console.warn("casefolding" + i +response.data[i].casefolding);
              console.warn("tokenizing" + i +response.data[i].tokenizing);
            
            for(var a=0;a < response.data[i].stemming.length;a++){
              console.warn("kata : " + a +response.data[i].stemming[a].kata);
              console.warn("kamus : " + a +response.data[i].stemming[a].kamus);
              console.warn("arti :" + a +response.data[i].stemming[a].arti);
              console.warn("nilai :" + a +response.data[i].stemming[a].nilai_jaro_winkler);
              // stemmingKata = response.data[i].stemming[a].kata.join();
              stemmingKamus = response.data[i].stemming[a].kamus;
            }
            // makeElement(response);
            
            }
            
          }
        });
      });
      </script>
      