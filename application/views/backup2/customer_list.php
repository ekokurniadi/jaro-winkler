<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
 <div class="main-content">
<section class="section">
  <div class="section-header">
    <h1> Customer </h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></div>
      <div class="breadcrumb-item"><a href="#"> Customer </a></div>
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
                        <?php echo anchor(site_url('customer/create'),'<i class="fa fa-plus"></i> Add New', 'class="btn btn-icon icon-left btn-primary"'); ?>
                        <?php echo anchor(site_url('customer/uploads'),'<i class="fa fa-download"></i> Upload CSV', 'class="btn btn-icon icon-left btn-success"'); ?>
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
                  <div class="card-body">
                    <div class="table-responsive">
                    <table id="example1" class="table" style="min-width:100%;">
                      <thead>
                      <tr>
                          <th>No</th>
                          <th>ID Pelanggan</th>
                          <th>Nama Pelanggan</th>
                          <th>Alamat</th>
                          <th>Tarif</th>
                          <th>Daya</th>
                          <th>No Meter</th>
                          <th>Tipe Meter</th>
                          <th>Server</th>
                          <th>No. HP</th>
                          <th>Nama Operator</th>
                          <th>No. IP</th>
                          <th>Imei Modem</th>
                          <th>Tipe Modem</th>
                          <th>Merk Modem</th>
                          <th>Gardu</th>
                          <th>Latitude</th>
                          <th>Longitude</th>
                          <th>Nama UP3</th>
                          <th>Kode UP3</th>
                          <th>Action</th>
                    </tr>
                    </thead> <tbody></tbody>
                        </table>
                        <script>
                          $(document).ready(function() {
                          dataTable = $('#example1').DataTable({
                              "processing": true,
                              "serverSide": true,
                              "scrollX": true,
                              "paging": true,
                              "autoWidth":true,
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
                                url: "<?php echo site_url('customer/fetch_data'); ?>",
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
      