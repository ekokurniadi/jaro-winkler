
 <div class="main-content">
<section class="section">
  <div class="section-header">
    <h1> Zakat </h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></div>
      <div class="breadcrumb-item"><a href="#"> Zakat </a></div>
    </div>
  </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                  
                    <!-- 0 -->
                    <div class="col-md-4">
                      <?php echo anchor(site_url('zakat/create'),'<i class="fa fa-plus"></i> Add New', 'class="btn btn-icon icon-left btn-primary"'); ?>
                    </div>

                  <div class="col-md-4 text-center">
                      <div style="margin-top: 8px" id="message">
                       <h5> <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h5>
                      </div>
                  </div>

                  <div class="col-md-1 text-right">
                  </div>

                  <div class="col-md-3 text-right">
                     <form action="<?php echo site_url('zakat/index'); ?>" class="form-inline" method="get">
                          <div class="input-group">
                          <input type="text" class="form-control" name="q" value="<?php echo $q; ?>" placeholder="Enter Keyword">
                          <span class="input-group-btn">
                              <?php 
                                  if ($q <> '')
                                  {
                                      ?>
                                      <a href="<?php echo site_url('zakat'); ?>" class="btn btn-warning"><span class="fa fa-close"> </span> Reset</a>
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
		<th>Tanggal Awal</th>
		<th>Tanggal Akhir</th>
		<th>Total Penjualan</th>
		<th>Total Keuntungan</th>
		<th>Zakat</th>
		<th>Action</th>
                    </tr>
                    </thead><?php
                    foreach ($zakat_data as $zakat)
                    {
                        ?>
                          <tbody>
                          <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo formatTanggal($zakat->tanggal_awal) ?></td>
			<td><?php echo formatTanggal($zakat->tanggal_akhir) ?></td>
			<td><?php echo number_format($zakat->total_penjualan,0,',','.') ?></td>
			<td><?php echo number_format($zakat->total_keuntungan,0,',','.') ?></td>
			<td><?php echo number_format($zakat->zakat,0,',','.') ?></td>
			<td style="text-align:center" width="200px">
				<?php 
				echo anchor(site_url('zakat/read/'.$zakat->id),'<i class="fa fa-eye"></i>',array('title'=>'detail','class'=>'btn btn-icon icon-left btn-light')); 
				echo '  '; 
				echo anchor(site_url('zakat/update/'.$zakat->id),'<i class="fa fa-pencil-square-o"></i>',array('title'=>'edit','class'=>'btn btn-icon icon-left btn-warning')); 
				echo '  '; 
				echo anchor(site_url('zakat/delete/'.$zakat->id),'<i class="fa fa-trash-o"></i>','title="delete" class="btn btn-icon icon-left btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
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
      