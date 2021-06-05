
 <div class="main-content">
<section class="section">
  <div class="section-header">
    <h1> Laba </h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></div>
      <div class="breadcrumb-item"><a href="#"> Laba </a></div>
    </div>
  </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                  
                    <!-- 0 -->

                    <?php if($_SESSION['role']=='Admin'){?>
                    <div class="col-md-4">
                    <form action="<?php echo base_url('laba/reset')?>" method="post">
                        <button type="submit" onclick="return confirm('Are You Sure')" class="btn btn-danger btn-flat">Reset Data
                    </form>
                    </div>
                    <?php } else { ?>
                      <div class="col-md-4">
                   
                    </div>
                    <?php } ?>
                  <div class="col-md-4 text-center">
                      <div style="margin-top: 8px" id="message">
                       <h5> <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h5>
                      </div>
                  </div>

                  <div class="col-md-1 text-right">
                  </div>

                  <div class="col-md-3 text-right">
                     <form action="<?php echo site_url('barang/index'); ?>" class="form-inline" method="get">
                          <div class="input-group">
                          <input type="text" class="form-control" name="q" value="<?php echo $q; ?>" placeholder="Enter Keyword">
                          <span class="input-group-btn">
                              <?php 
                                  if ($q <> '')
                                  {
                                      ?>
                                      <a href="<?php echo site_url('barang'); ?>" class="btn btn-warning"><span class="fa fa-close"> </span> Reset</a>
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
                      <?php if($_SESSION['role']=='Admin'){?>
                      <table class="table table-bordered table-md" id="table-1">
                      <thead>
                      <tr>
                          <th>No</th>
                          <th>Kode Barang</th>
                          <th>Nama Barang</th>
                          <th>Satuan Barang</th>
                          <th>Harga Modal</th>
                          <th>Harga Jual</th>
                          <th>Qty Terjual</th>
                          <th>Keuntungan</th>
                    </tr>
                    </thead><?php
                    foreach ($barang_data as $barang)
                    {
                      $keuntungan = ($barang->harga_terjual * $barang->qty_terjual) - ($barang->harga_modal * $barang->qty_terjual);
                        ?>
                          <tbody>
                          <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $barang->kode_barang ?></td>
			<td><?php echo $barang->nama_barang ?></td>
			<td><?php echo $barang->satuan ?></td>
			<td><?php echo number_format($barang->harga_modal,0,',','.') ?></td>
			<td><?php echo number_format($barang->harga_terjual,0,',','.') ?></td>
			<td><?php echo number_format($barang->qty_terjual,0,',','.') ?></td>
			<td><?php echo number_format($barang->laba,0,',','.') ?></td>
			<!-- <td style="text-align:center" width="200px">
				<?php 
				echo anchor(site_url('barang/read/'.$barang->id),'<i class="fa fa-eye"></i>',array('title'=>'detail','class'=>'btn btn-icon icon-left btn-light')); 
				echo '  '; 
				echo anchor(site_url('barang/update/'.$barang->id),'<i class="fa fa-pencil-square-o"></i>',array('title'=>'edit','class'=>'btn btn-icon icon-left btn-warning')); 
				echo '  '; 
				echo anchor(site_url('barang/delete/'.$barang->id),'<i class="fa fa-trash-o"></i>','title="delete" class="btn btn-icon icon-left btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
				?>
			</td> -->
		</tr></tbody>
                          <?php
                      }
                      ?>
                    
                    </table>
<?php } else {?>
  <table class="table table-bordered table-md" id="table-1">
                      <thead>
                      <tr>
                          <th>No</th>
                          <th>Kode Barang</th>
                          <th>Nama Barang</th>
                          <th>Qty Terjual</th>
                    </tr>
                    </thead><?php
                    foreach ($barang_data as $barang)
                    {
                        ?>
                          <tbody>
                          <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $barang->kode_barang ?></td>
			<td><?php echo $barang->nama_barang ?></td>
			<td><?php echo number_format($barang->qty_terjual,0,',','.') ?></td>
		</tr></tbody>
                          <?php
                      }
                      ?>
                    
                    </table>
    <?php } ?>
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
      