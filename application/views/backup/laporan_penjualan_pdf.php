<!doctype html>
<html>
    <head>
        <title>Laporan Penjualan</title>
        <style>
            .word-table {
                border:1px solid black !important; 
                border-collapse: collapse !important;
                width: 100%;
            }
            .word-table tr th, .word-table tr td{
                border:1px solid black !important; 
                padding: 5px 10px;
                text-align:center;
            }
        </style>
    </head>
    <body>
        <h2>Laporan Penjualan Periode : <?=formatTanggal($startDate)?> s/d <?=formatTanggal($endDate)?></h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Kode Barang</th>
		<th>Nama Barang</th>
		<th>Satuan</th>
		<th>Harga Modal</th>
		<th>Harga Terjual</th>
		<th>Qty Terjual</th>
		<th>Keuntungan</th>
            </tr><?php
            $data = $this->db->query("SELECT * FROM barang");
            $start =0;
            foreach ($data->result() as $rows)
            {
                $qty_terjual = $this->db->query("SELECT COALESCE(SUM(qty)) as qty_terjual,COALESCE(SUM(laba)) as laba from detail_transaksi where kode_barang ='$rows->kode_barang' and tanggal_transaksi between '$startDate' and '$endDate'")->row();
                $harga_terjual = $this->db->query("SELECT harga_jual from detail_transaksi where kode_barang='$rows->kode_barang' and tanggal_transaksi between '$startDate' and '$endDate' order by tanggal_transaksi DESC LIMIT 1")->row();
                ?>  
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $rows->kode_barang ?></td>
		      <td><?php echo $rows->nama_barang ?></td>
		      <td><?php echo $rows->satuan ?></td>
		      <td><?php echo $rows->harga_modal ?></td>
		      <td><?php echo $harga_terjual->harga_jual ?></td>
		      <td><?php echo $qty_terjual->qty_terjual ?></td>
		      <td><?php echo $qty_terjual->laba ?></td>
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>