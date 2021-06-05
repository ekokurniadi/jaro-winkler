
 <div class="main-content">
<section class="section">
  <div class="section-header">
    <h1> Petugas </h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></div>
      <div class="breadcrumb-item"><a href="#"> Petugas </a></div>
    </div>
  </div>

          <div class="section-body">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                  
                    <!-- 0 -->
                    <div class="col-md-4">
                      <?php echo anchor(site_url('petugas/create'),'<i class="fa fa-plus"></i> Add New', 'class="btn btn-icon icon-left btn-primary"'); ?>
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
                    <table id="example1" class="table">
                          <thead>
                            <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Alamat</th>
                            <th>No. HP</th>
                            <th>Grup</th>
                            <th>Nama UP3</th>
                            <th>Password</th>
                            <th>Level</th>
                            <th>Status</th>
                            <th>Photo</th>
                            <th>Action</th>
                            </tr>
                          </thead>
                          <tbody></tbody>
                        </table>
                        <script>
                          $(document).ready(function() {
                          dataTable = $('#example1').DataTable({
                              "processing": true,
                              "paging": true,
                              "serverSide": true,
                              "scrollX": true,
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
                                url: "<?php echo site_url('petugas/fetch_data'); ?>",
                                type: "POST",
                                dataSrc: "data",
                                data: function(d) {
                                  return d;
                                },
                              },
                              "columnDefs": [
                                {
                                  "targets": [5],
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
      