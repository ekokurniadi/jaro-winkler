
 <div class="main-content">
<section class="section">
  <div class="section-header">
    <h1> Work order </h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></div>
      <div class="breadcrumb-item"><a href="#"> Work order </a></div>
    </div>
  </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                  
                    <!-- 0 -->
                    <div class="col-md-4">
						<h4>DATA WORK ORDER</h4>
                    </div>

                <div class="col-md-9 text-center">
				        <input type="button" name="btn-cari" id="btn-selesai" class="btn btn-light" value="Complete" placeholder="Kata Kunci">
				        <input type="button" name="btn-cari" id="btn-cancel" class="btn btn-light" value="Cancel" placeholder="Kata Kunci">
				        <input type="button" name="btn-reset" id="btn-pending" class="btn btn-light" value="Pending" placeholder="Kata Kunci">
				        <input type="button" name="btn-reset" id="btn-wd" class="btn btn-light" value="Wait Dial" placeholder="Kata Kunci">
				        <input type="button" name="btn-reset" id="btn-otw" class="btn btn-light" value="On The Way" placeholder="Kata Kunci">
				        <input type="button" name="btn-reset" id="btn-ready" class="btn btn-light" value="Ready" placeholder="Kata Kunci">
                <input type="hidden" name="ref" id="ref">
                </div>

                  

                  </div>
                  <div class="card-body">
				  	<div class="container-fluid">
						<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label class="col-sm-3 control-label" for="varchar">Filter <?php echo form_error('dial_status') ?></label>
										<div class="col-sm-12">
											<select name="filter" id="filter" class="form-control">
												<option value="">Choose Filter</option>
												<option value="a.customer_id">Nomor Tugas</option>
												<option value="b.customer_name">Nomor BA</option>
											</select>
										</div>
								</div>
							</div>
							
							<div class="col-md-4">
                          		<div class="form-group">
                            		<label class="col-sm-4 control-label" for="varchar">Kata Kunci <?php echo form_error('dial_status') ?></label>
                            			<div class="col-sm-12">
                                			<input type="text" name="value_filter" id="value_filter" class="form-control" placeholder="Kata Kunci">
                            		   </div>
                               </div>
                           </div>
						   	<div class="col-md-4">
								<div class="form-group">
									<label class="col-sm-4 control-label" for="varchar">&nbsp;</label>
									<div class="col-sm-12">
										<input type="button" name="btn-cari" id="btn-cari" class="btn btn-primary" value="Search" placeholder="Kata Kunci">
										<input type="button" name="btn-reset" id="btn-reset" class="btn btn-warning" value="Reset" placeholder="Kata Kunci">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label class="col-sm-4 control-label" for="varchar"></label>
									<div class="col-sm-12">
										<input type="button" name="btn-cari" id="btn-cari" class="btn btn-success" value="Download xls" placeholder="Kata Kunci">
									</div>
								</div>
							</div>
						</div>  
					</div>
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

                          $(document).ready(function() {
                          dataTable = $('#example1').DataTable({
                              "processing": true,
                              "serverSide": true,
                              "scrollX": true,
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
                                url: "<?php echo site_url('work_order/fetch_data'); ?>",
                                type: "POST",
                                dataSrc: "data",
                                data: function(d) {
                                  d.ref = $('#ref').val();
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
      