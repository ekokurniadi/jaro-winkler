
 <div class="main-content">
<section class="section">
  <div class="section-header">
    <h1> Dial status </h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></div>
      <div class="breadcrumb-item"><a href="#"> Dial status </a></div>
    </div>
  </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                  <div class="container-fluid">
                  <div class="row">
                      <div class="col-md-4">
                        <?php echo anchor(site_url('dial_status/create'),'<i class="fa fa-plus"></i> Add New', 'class="btn btn-icon icon-left btn-primary"'); ?>
                        <?php echo anchor(site_url('dial_status/uploads'),'<i class="fa fa-download"></i> Upload CSV', 'class="btn btn-icon icon-left btn-success"'); ?>
                      </div>
                    </div>
                 
                    
                    <!-- 0 -->
                    
                   <div class="row">
                    <div class="col-md-12 text-center">
                      <div style="margin-top: 8px" id="message">
                      <?php
                        if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {
                        ?>
                          <div class="alert alert-<?php echo $_SESSION['tipe'] ?> alert-dismissable">
                            <strong><?php echo $_SESSION['pesan'] ?></strong>
                            <button class="close" data-dismiss="alert">
                              <span aria-hidden="true">&times;</span>
                              <span class="sr-only">Close</span>
                            </button>
                          </div>
                        <?php
                        }
                        $_SESSION['pesan'] = '';

                        ?>
                      </div>
                  </div>
                    </div>
                   </div>
                  </div>
                  <div class="container-fluid">
                        <div class="row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="varchar">Filter <?php echo form_error('dial_status') ?></label>
                            <div class="col-sm-12">
                              <select name="filter" id="filter" class="form-control">
                                <option value="">Choose Filter</option>
                                <option value="a.customer_Id">ID Pelanggan</option>
                                <option value="b.customer_name">Nama Pelanggan</option>
                                <option value="b.response">Status Koneksi</option>
                                <option value="c.ULP">Nama ULP</option>
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
                  </div>
                  <div class="card-body">
                  <div class="table-responsive">
                  <table id="example1" class="table" style="min-width:100%;">
                      <thead>
                      <tr>
                          <th>No</th>
                          <th>ID Pelanggan</th>
                          <th>Nama Pelanggan</th>
                          <th>Alamat</th>
                          <th>Tarif/Daya</th>
                          <th>No Meter</th>
                          <th>No HP</th>
                          <th>Alamat IP</th>
                          <th>Titik Lokasi</th>
                          <th>Status Koneksi</th>
                          <th>Nama ULP</th>
                          <th>Dial Status</th>
                          <th>Action</th>
                    </tr>
                    </thead> <tbody></tbody>
                        </table>
                        <script>
                         

                            $(document).ready(function(){
                                $('#btn-cari').click(function(){
                                    dataTable.draw();
                                });
                            });
                            $(document).ready(function(){
                                $('#btn-reset').click(function(){
                                  $('#filter').val('');
                                  $('#value_filter').val('');
                                });
                            });
                            $(document).ready(function(){
                              var filter = $('#filter').val();
                              var values  = $('#value_filter').val();
                              $('#value_filter').keydown(function (e){
                                if(e.keyCode == 13){
                                  dataTable.draw();
                                  }
                              });
                            });
                            
                        </script>
                        <script>
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
                                url: "<?php echo site_url('dial_status/fetch_data'); ?>",
                                type: "POST",
                                dataSrc: "data",
                                data: function(d) {
                                  d.filter_columns=$('#filter').val();
                                  d.filter_value=$('#value_filter').val();
                                },
                              },
                              "columnDefs": [
                                { "targets":[0],"orderable":false},
                                { "targets":[8],"orderable":false},
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
      