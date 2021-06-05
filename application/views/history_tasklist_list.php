
 <div class="main-content">
<section class="section">
  <div class="section-header">
    <h1> History Tasklist </h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></div>
      <div class="breadcrumb-item"><a href="#"> History Tasklist </a></div>
    </div>
  </div>

  <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                  <div class="container">
                  <div class="row">
                      <div class="col-md-4">
                        <?php echo anchor(site_url('tasklist'),'<i class="fa fa-arrow-left"></i> Back', 'class="btn btn-icon icon-left btn-success"'); ?>
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
                    <table id="example1" class="table " style="min-width:100%;">
                      <thead>
                      <tr>
                          <th>No</th>
                          <!-- <th>Nomor Tugas</th> -->
                          <th>Tanggal</th>
                          <th>ID Pelanggan</th>
                          <th>Nomor Meter</th>
                          <th>Nama Pelanggan</th>
                          <th>Alamat</th>
                          <th>Indikasi</th>
                          <th>Klasifikasi</th>
                          <th>Status</th>
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
                                url: "<?php echo site_url('tasklist/history_fetch_data'); ?>",
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
      