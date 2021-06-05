
 <div class="app">
<section class="section">
  <!-- <div class="section-header">
    <h1>Penugasan </h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="#"><i class="fa fa-dashboard"></i> Home</a></div>
      <div class="breadcrumb-item"><a href="#">Penugasan </a></div>
    </div>
  </div> -->

          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                  
                    <!-- 0 -->
                    <div class="col-md-4">
						<h4>Data Penugasan</h4>
                    </div>

                <div class="col-md-9 text-center">
				        <input type="button" name="btn-cari" id="btn-selesai" class="btn btn-light" value="Complete" placeholder="Kata Kunci">
				        <input type="button" name="btn-cari" id="btn-cancel" class="btn btn-light" value="Cancel" placeholder="Kata Kunci">
				        <input type="button" name="btn-reset" id="btn-pending" class="btn btn-light" value="Pending" placeholder="Kata Kunci">
				        <input type="button" name="btn-reset" id="btn-wd" class="btn btn-light" value="Wait Dial" placeholder="Kata Kunci">
				        <input type="button" name="btn-reset" id="btn-otw" class="btn btn-light" value="On The Way" placeholder="Kata Kunci">
				        <input type="button" name="btn-reset" id="btn-ready" class="btn btn-light" value="Ready" placeholder="Kata Kunci">
                        <input type="button" name="btn-reset" id="btn-all" class="btn btn-light" value="All" placeholder="Kata Kunci">
                <input type="hidden" name="ref" id="ref">
                </div>

                  

                  </div>
                  <div class="card-body">
                    <input type="hidden" value="<?=$_GET['level']?>" name="level" id="level">
                    <input type="hidden" value="<?=$_GET['area']?>" name="area" id="area">
                    <div class="table-responsive">
                      <table class="table table-bordered table-md" id="example1" style="min-width:100%">
                      <thead>
                      <tr>
                          	<th>No</th>
							<th>Status</th>
							<th>Nomor Tugas</th>
							<th>Tanggal Survey</th>
							<th>Tanggal Tugas </th>
							<th>ID Pelanggan</th>
							<th>Nama Pelanggan</th>
							<th>Aktivitas</th>
							<th>Petugas</th>
							<th>Alasan</th>
							<th>Action</th>
                    </tr>
                    </thead><tbody></tbody>
                        </table>
                        <script>
                         

                          $(document).ready(function(){
                                $('#btn-selesai').click(function(){
                                  $('#ref').val('Complete');
                                dataTable.draw();
                              });
                            });
                          $(document).ready(function(){
                                $('#btn-cancel').click(function(){
                                  $('#ref').val('Cancel');
                                dataTable.draw();
                              });
                            });
                          $(document).ready(function(){
                                $('#btn-wd').click(function(){
                                  $('#ref').val('Test Dial');
                                dataTable.draw();
                              });
                            });
                          $(document).ready(function(){
                                $('#btn-pending').click(function(){
                                  $('#ref').val('Pending');
                                dataTable.draw();
                              });
                            });
                          $(document).ready(function(){
                                $('#btn-ready').click(function(){
                                  $('#ref').val('Persiapan');
                                dataTable.draw();
                              });
                            });
                          $(document).ready(function(){
                                $('#btn-otw').click(function(){
                                  $('#ref').val('OTW');
                                dataTable.draw();
                              });
                            });
                            $(document).ready(function(){
                                $('#btn-reset').click(function(){
                                  $('#ref').val('');
                                  $('#value_filter').val('');
                                dataTable.draw();
                              });
                            });
                            $(document).ready(function(){
                                $('#btn-all').click(function(){
                                  $('#ref').val('');
                                  $('#value_filter').val('');
                                dataTable.draw();
                              });
                            });

                          $(document).ready(function() {
                          dataTable = $('#example1').DataTable({
                              "processing": true,
                              "serverSide": true,
                              "scrollX": true,
                              "scrollY":true,
                              "paging": true,
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
                                url: "<?php echo site_url('work_order/fetch_data2'); ?>",
                                type: "POST",
                                dataSrc: "data",
                                data: function(d) {
                                  d.ref = $('#ref').val();
                                  d.level = $('#level').val();
                                  d.area = $('#area').val();
                                 
                                },
                              },
                              "columnDefs": [
                                {
                                  "targets": [0],
                                  "className": 'text-center'
                                },
                                { "targets":[0],"orderable":false},
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
      