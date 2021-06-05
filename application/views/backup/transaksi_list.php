
 <div class="main-content">
<section class="section">
  <div class="section-header">
    <h1> Transaksi </h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></div>
      <div class="breadcrumb-item"><a href="#"> Transaksi </a></div>
    </div>
  </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                  
                    <!-- 0 -->
                    <div class="col-md-4">
                      <?php echo anchor(site_url('transaksi/create'),'<i class="fa fa-plus"></i> Add New', 'class="btn btn-icon icon-left btn-primary"'); ?>
                    </div>

                  <div class="col-md-4 text-center">
                      <div style="margin-top: 8px" id="message">
                       <h5> <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h5>
                      </div>
                  </div>

                  <div class="col-md-1 text-right">
                  </div>

                  <div class="col-md-3 text-right">
                     <form action="<?php echo site_url('transaksi/index'); ?>" class="form-inline" method="get">
                          <div class="input-group">
                          <input type="text" class="form-control" name="q" value="<?php echo $q; ?>" placeholder="Enter Keyword">
                          <span class="input-group-btn">
                              <?php 
                                  if ($q <> '')
                                  {
                                      ?>
                                      <a href="<?php echo site_url('transaksi'); ?>" class="btn btn-warning"><span class="fa fa-close"> </span> Reset</a>
                                      <?php
                                  }
                              ?>
                            <button class="btn btn-primary" type="submit"><span class="fa fa-search"> </span> Search</button>
                          </span>
                          </div>
                      </form>
                  </div>

                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered table-md" id="table-1">
                      <thead>
                      <tr>
                          <th>No</th>
		<th>Kode Transaksi</th>
		<th>Tanggal Transaksi</th>
		<th>Action</th>
                    </tr>
                    </thead><?php
                    foreach ($transaksi_data as $transaksi)
                    {
                        ?>
                          <tbody>
                          <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $transaksi->kode_transaksi ?></td>
			<td><?php echo formatTanggal($transaksi->tanggal_transaksi) ?></td>
			<td style="text-align:center" width="200px">
				<?php 
				echo anchor(site_url('transaksi/read/'.$transaksi->id),'<i class="fa fa-eye"></i>',array('title'=>'detail','class'=>'btn btn-icon icon-left btn-light')); 
				echo '  '; 
				echo anchor(site_url('transaksi/update/'.$transaksi->id),'<i class="fa fa-pencil-square-o"></i>',array('title'=>'edit','class'=>'btn btn-icon icon-left btn-warning')); 
				echo '  '; 
				echo anchor(site_url('transaksi/delete/'.$transaksi->id),'<i class="fa fa-trash-o"></i>','title="delete" class="btn btn-icon icon-left btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
				?>
			</td>
		</tr></tbody>
                          <?php
                      }
                      ?>
                    
                    </table>
                    </div>
                  </div>
                  <div class="card-footer text-right">
                  <?php echo $pagination ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <div class="row">
        <div class="col-md-6">
            <a href="#" class="btn btn-primary">Total Data : <?php echo $total_rows ?></a>
            
	    </div>
       
    </div>
      </div>
      