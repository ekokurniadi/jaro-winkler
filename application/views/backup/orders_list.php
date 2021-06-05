
 <div class="main-content">
<section class="section">
  <div class="section-header">
    <h1> Orders </h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></div>
      <div class="breadcrumb-item"><a href="#"> Orders </a></div>
    </div>
  </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                  
                    <!-- 0 -->
                    <div class="col-md-4">
                      <?php echo anchor(site_url('orders/create'),'<i class="fa fa-plus"></i> Add New', 'class="btn btn-icon icon-left btn-primary"'); ?>
                    </div>

                  <div class="col-md-4 text-center">
                      <div style="margin-top: 8px" id="message">
                       <h5> <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h5>
                      </div>
                  </div>

                  <div class="col-md-1 text-right">
                  </div>

                  <div class="col-md-3 text-right">
                     <form action="<?php echo site_url('orders/index'); ?>" class="form-inline" method="get">
                          <div class="input-group">
                          <input type="text" class="form-control" name="q" value="<?php echo $q; ?>" placeholder="Enter Keyword">
                          <span class="input-group-btn">
                              <?php 
                                  if ($q <> '')
                                  {
                                      ?>
                                      <a href="<?php echo site_url('orders'); ?>" class="btn btn-warning"><span class="fa fa-close"> </span> Reset</a>
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
		<th>Kode Order</th>
		<th>Nama Customer</th>
		<th>Nomor Wa</th>
		<th>Jadwal Kirim</th>
		<th>Jam</th>
		<th>Kota Penjemputan</th>
		<!-- <th>Lantai</th>
		<th>Parkir Mobil</th>
		<th>Kota Kirim</th>
		<th>Lantai Kirim</th>
		<th>Parkir Mobil Kirim</th>
		<th>Bantuan Customer</th>
		<th>Barang Customer</th>
		<th>Bantuan Driver</th>
		<th>Bantuan Kenek</th>
		<th>Biaya Tol</th>
		<th>Biaya Overload</th>
		<th>Waktu Tunggu</th> -->
		<th>Total Customer Bayar</th>
		<th>Ongkos Driver</th>
		<th>Cara Pembayaran</th>
		<th>Catatan</th>
		<th>Status</th>
		<th>Status Pengantaran</th>
		<th>Driver</th>
		<th>Created At</th>
		<th>Action</th>
                    </tr>
                    </thead><?php
                    foreach ($orders_data as $orders)
                    {
                      $driver = $this->db->query("SELECT * FROM driver where id='$orders->driver'")->row();
                        ?>
                          <tbody>
                          <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $orders->kode_order ?></td>
			<td><?php echo $orders->nama_customer ?></td>
			<td><?php echo $orders->nomor_wa ?></td>
			<td><?php echo formatTanggal($orders->jadwal_kirim) ?></td>
			<td><?php echo $orders->jam ?></td>
			<td><?php echo $orders->kota ?></td>
			<!-- <td><?php echo $orders->lantai ?></td>
			<td><?php echo $orders->parkir_mobil ?></td>
			<td><?php echo $orders->kota_kirim ?></td>
			<td><?php echo $orders->lantai_kirim ?></td>
			<td><?php echo $orders->parkir_mobil_kirim ?></td>
			<td><?php echo $orders->bantuan_customer ?></td>
			<td><?php echo $orders->barang_customer ?></td>
			<td><?php echo $orders->bantuan_driver ?></td>
			<td><?php echo $orders->bantuan_kenek ?></td>
			<td><?php echo $orders->biaya_tol ?></td>
			<td><?php echo $orders->biaya_overload ?></td>
			<td><?php echo $orders->waktu_tunggu ?></td> -->
			<td><?php echo number_format($orders->total_bayar,0,',','.') ?></td>
			<td><?php echo number_format($orders->ongkos_driver,0,',','.') ?></td>
			<td><?php echo $orders->cara_pembayaran ?></td>
			<td><?php echo $orders->catatan ?></td>
			<td><?php echo $orders->status ?></td>
			<td><?php echo $orders->status_pengantaran ?></td>
      
			<td><?php echo $orders->driver == NULL ? "":$driver->nama ?></td>
			<td><?php echo $orders->created_at ?></td>
			<td style="text-align:center" width="200px">
				<?php 
				echo anchor(site_url('orders/read/'.$orders->id),'<i class="fa fa-eye"></i>',array('title'=>'detail','class'=>'btn btn-icon icon-left btn-light')); 
				echo '  '; 
        if($orders->status=="new_order" || $orders->status=="canceled"){
				echo anchor(site_url('orders/update/'.$orders->id),'<i class="fa fa-pencil-square-o"></i>',array('title'=>'edit','class'=>'btn btn-icon icon-left btn-warning')); 
				echo '  '; 
				echo anchor(site_url('orders/delete/'.$orders->id),'<i class="fa fa-trash-o"></i>','title="delete" class="btn btn-icon icon-left btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
        echo '  '; 
          echo anchor(site_url('orders/blastOrdering/'.$orders->kode_order),'<i class="fa fa-send"></i>','title="Kirim Ulang" class="btn btn-icon icon-left btn-success" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
        }
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
      