<style>
body .modal-dialog { 
    max-width: 70%;
 
}
</style>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cari Data Customer</h5>
        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Filter Dial Status <?php echo form_error('customer_id') ?></label>
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-sm-8">
                        <select name="filter" id="filter" class="form-control">
                            <option value="">Choose an Option</option>
                            <option value="O">Success</option>
                            <option value="L">Login Timeout</option>
                            <option value="X">RTO</option>
                            <option value="-">-</option>
                        </select>
                    </div>
                  </div> 
                </div>
              </div>
      <div class="table-responsive">
                  <table id="example1" class="table" style="width:100% !important;table-layout:auto">
                    <thead>
                    <tr>
                          <th>No</th>
                          <th>Tanggal</th>
                          <th>ID Pelanggan</th>
                          <th>Nama Pelanggan</th>
                          <th>Alamat</th>
                          <th>Status Koneksi</th>
                          <th>Klasifikasi</th>
                          <th>Action</th>
                    </tr>
                    </thead> 
                    <tbody></tbody>
                    </table>
                        <script>
                            $(document).ready(function(){
                                $('#filter').on("change", (function(){
                                    dataTable.draw();
                                }));
                            });
                        </script>
                        <script>
                          $(document).ready(function() {
                          dataTable = $('#example1').DataTable({
                              "processing": true,
                              "serverSide": true,
                              "scrollX": false,
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
                                url: "<?php echo site_url('dial_status/fetch_data_modals'); ?>",
                                type: "POST",
                                dataSrc: "data",
                                data: function(d) {
                                    d.filter = $('#filter').val();
                                },
                              },
                              "columnDefs": [
                                { "targets":[2],"orderable":false},
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
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>