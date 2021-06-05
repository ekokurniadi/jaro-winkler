<!DOCTYPE html>
  <html>

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet"> 
    <title>Cetak</title>
    <style>
      @media print {
        @page {
                sheet-size: 210mm 297mm;
                margin-left: 1cm;
                margin-right: 1cm;
                margin-bottom: 0cm;
                margin-top: 0.5cm;
            }

        .text-center {
          text-align: center;
        }

        .bold {
          font-weight: bold;
        }

        .table {
          width: 100%;
          max-width: 100%;
          border-collapse: collapse;
          border-collapse: separate;
        }

        .table-bordered tr td {
          border: 0.01em solid black;
          padding-left: 5px;
          padding-right: 3px;
          padding-top:10px;
          padding-bottom:10px;
        }

        .table-nonborder {
            margin-top:10px;
            border-collapse: collapse;
            /* border-collapse: separate; */
        }
        .table-nonborder tr td{
          font-family: "Arial";
          font-size: 11px;
          vertical-align: text-top
        }

        body {
          font-family: "Arial";
          /* font-size: 10pt; */
        }
      }
    </style>
  </head>
      <?php
		  require_once APPPATH.'third_party/phpqrcode/qrlib.php'; 
      ?>
  <body>
      <table>
        <tr>
            <td><img src="image/Logo pln-bak.png" alt="" width="60px"  style="margin-top:-5px"></td>
            <td style="vertical-align: text-top;font-weight:bold;font-family:Arial, Helvetica, sans-serif;font-size:11px;">
                PT PLN (PERSERO)
                <br>
                <?php echo $header->reg_name?>
                <br>
                <?php echo $header->area_name?>
            </td>
        </tr>
      </table>
      <div style="text-align:center;background-color:#d9d9d9;padding:5px;font-size:11px; margin-top:10px;font-weight:bold;font-family:'Poppins', sans-serif;">
      BERITA ACARA PEMELIHARAAN DAN PERBAIKAN KOMUNIKASI AMR
      </div>
      <div style="font-size:11px;margin-top:11px">
      Pada hari ini,  <?=tgl_indo_hari($details->tanggal_survey)?>   Tanggal  <?=substr($details->tanggal_survey,8,2)?>  Bulan  <?=tgl_indo_bulan($details->tanggal_survey)?>  Tahun  <?=tgl_indo_tahun($details->tanggal_survey)?>,  telah dilakukan pemeliharaan dan perbaikan komunikasi AMR dengan data pendukung sebagai berikut :
      </div>

      <table width ="100%" class="table-nonborder">
        <tr>
            <th colspan="6" style="text-align:left;font-size:11px">DATA PELANGGAN</th>
            <th colspan="6" style="text-align:left;font-size:11px">DATA PEMBATAS</th>
        </tr>
        <tr>
            <td>ID Pelanggan</td>
            <td style="text-align:center">:</td>
            <td colspan="4"><?=$details->customer_id?></td>
            <td>Box APP</td>
            <td style="text-align:center">:</td>
            <td colspan="4"><?=$details->panel_condition?></td>
        </tr>
        <tr>
            <td>Nama Pelanggan</td>
            <td style="text-align:center">:</td>
            <td colspan="4"><?=$customerData->customer_name?></td>
            <td>Shuntrip</td>
            <td style="text-align:center">:</td>
            <td colspan="4"><?=$details->shuntrip_condition?></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td style="text-align:center">:</td>
            <td colspan="4"><?=$customerData->address?></td>
            <td>Arus Pembatas</td>
            <td style="text-align:center">:</td>
            <td colspan="4"><?=$details->current_limiter?></td>
        </tr>
        <tr>
            <td>Tarif/Daya</td>
            <td style="text-align:center">:</td>
            <td colspan="4"><?=$customerData->rate?>/<?=$customerData->power?></td>
            <td>Pembatas</td>
            <td style="text-align:center">:</td>
            <td colspan="4"><?=$details->current_limiter_type?></td>
        </tr>
        <tr>
            <td>Merk/Type Meter</td>
            <td style="text-align:center">:</td>
            <td colspan="4"><?=$customerData->merk_meter?>/<?=$customerData->device_type?></td>
            <td>Merk/Tahun</td>
            <td style="text-align:center">:</td>
            <td colspan="4"><?=$details->current_limiter_brand?> / <?=$details->tahun?></td>
        </tr>
        <tr>
            <td>Nomor Meter</td>
            <td style="text-align:center">:</td>
            <td colspan="4"><?=$customerData->device_id?></td>
            <td rowspan="6">Map Lokasi</td>
            <td rowspan="6" style="text-align:center;">:</td>
            <?php 
            $tempdir = "./temp/"; //Nama folder tempat menyimpan file qrcode
            if (!file_exists($tempdir)) //Buat folder bername temp
            mkdir($tempdir);
      
            //isi qrcode jika di scan
            $codeContents = "$details->latitude,$details->longitude";
            //nama file qrcode yang akan disimpan
            $namaFile="$details->task_id".".png";
            //ECC Level
            $level=QR_ECLEVEL_H;
            //Ukuran pixel
            $UkuranPixel=4;
            //Ukuran frame
            $UkuranFrame=1;
             QRcode::png($codeContents, $tempdir.$namaFile, $level, $UkuranPixel, $UkuranFrame);
            
            ?>
            <td colspan="4" rowspan="6" > <img src="<?php echo $tempdir.$namaFile?>" width="80px"/>
              <br>
              Scan menggunakan Aplikasi
            </td>
        </tr>
        <tr>
            <td>Nomor GSM</td>
            <td style="text-align:center">:</td>
            <td colspan="4"><?=$customerData->cellular_no?></td>
        </tr>
        <tr>
            <td>IP Address</td>
            <td style="text-align:center">:</td>
            <td colspan="4"><?=$customerData->IP_address?></td>
        </tr>
        <tr>
            <td>Gardu/Tiang</td>
            <td style="text-align:center">:</td>
            <td colspan="4"><?=$customerData->gardu?></td>
        </tr>
        <tr>
            <td>Koordinat</td>
            <td style="text-align:center">:</td>
            <td colspan="4"><?=$details->latitude?>,<?=$details->longitude?></td>
        </tr>
        <tr>
            <td>ULP</td>
            <td style="text-align:center">:</td>
            <td colspan="4"><?=ucwords($customerData->area_name)?></td>
        </tr>
        <tr>
          <th colspan="12" style="text-align:center;font-size:11px">&nbsp;</th>
        </tr>
        <tr>
          <th colspan="12" style="text-align:center;font-size:11px">DATA METER PADA SAAT DIPERIKSA</th>
        </tr>
        <tr>
            <td>Fisik Meter</td>
            <td style="text-align:center">:</td>
            <td colspan="4"><?=$details->meter_dev_condition?></td>
            <td>Total KWH</td>
            <td style="text-align:center">:</td>
            <td colspan="4"><?=$details->stand_meter_total?></td>
        </tr>
        <tr>
            <td>Display</td>
            <td style="text-align:center">:</td>
            <td colspan="4"><?=$details->meter_disp_condition?></td>
            <td>KVARH</td>
            <td style="width:20px;text-align:center" >:</td>
            <td colspan="4"><?=$details->kvarh?></td>
        </tr>
        <tr>
            <td>Tanggal Meter</td>
            <td style="text-align:center">:</td>
            <td colspan="4"><?=tgl_indo($details->date_meter)?></td>
            <td colspan="2" style="border:1;text-align:center;border-collapse:collapse">Phase</td>
            <td style="border:1;text-align:center;border-collapse:collapse">R</td>
            <td style="border:1;text-align:center;border-collapse:collapse">S</td>
            <td style="border:1;text-align:center;border-collapse:collapse">T</td>
            <td></td>
        </tr>
        <tr>
            <td>Jam Meter</td>
            <td style="text-align:center">:</td>
            <td colspan="4"><?=$details->time_meter?></td>
            <td style="border-collapse:collapse">Tegangan</td>
            <td style="text-align:center">:</td>
            <td style="text-align:center;border-collapse:collapse"><?=$details->voltage_r?></td>
            <td style="text-align:center;border-collapse:collapse"><?=$details->voltage_s?></td>
            <td style="text-align:center;border-collapse:collapse"><?=$details->voltage_t?></td>
            <td></td>
        </tr>
        <tr>
            <td>PF</td>
            <td style="text-align:center">:</td>
            <td colspan="4"><?=$details->cosphi?></td>
            <td style="border-collapse:collapse">Arus</td>
            <td style="text-align:center">:</td>
            <td style="text-align:center;border-collapse:collapse"><?=$details->current_r?></td>
            <td style="text-align:center;border-collapse:collapse"><?=$details->current_s?></td>
            <td style="text-align:center;border-collapse:collapse"><?=$details->current_t?></td>
            <td></td>
        </tr>
        <tr>
            <td>KWH (WBP)</td>
            <td style="text-align:center">:</td>
            <td colspan="4"><?=$details->stand_meter_WBP?></td>
            <td style="border-collapse:collapse"></td>
            <td></td>
            <td style="text-align:center;border-collapse:collapse"></td>
            <td style="text-align:center;border-collapse:collapse"></td>
            <td style="text-align:center;border-collapse:collapse"></td>
            <td></td>
        </tr>
        <tr>
            <td>KWH (LWBP1)</td>
            <td style="text-align:center">:</td>
            <td colspan="4"><?=$details->stand_meter_WBP1?></td>
            <td style="border-collapse:collapse"></td>
            <td></td>
            <td style="text-align:center;border-collapse:collapse"></td>
            <td style="text-align:center;border-collapse:collapse"></td>
            <td style="text-align:center;border-collapse:collapse"></td>
            <td></td>
        </tr>
        <tr>
            <td>KWH (LWBP2)</td>
            <td style="text-align:center">:</td>
            <td colspan="4"><?=$details->stand_meter_WBP2?></td>
            <td style="border-collapse:collapse"></td>
            <td></td>
            <td style="text-align:center;border-collapse:collapse"></td>
            <td style="text-align:center;border-collapse:collapse"></td>
            <td style="text-align:center;border-collapse:collapse"></td>
            <td></td>
        </tr>
        <tr>
            <td>Foto Lokasi</td>
            <td style="width:20px;text-align:center">:</td>
            <td colspan="10" align="center" style="border:1;margin:1px;">
              <!-- photo panel -->
              <img src="image/<?php echo $details->photo_panel == "" ? 'no-image.png': $details->photo_panel?>" alt="" width="70px" height="100px">
               <!-- photo meter dev -->
              <img src="image/<?php echo $details->photo_meter_dev == "" ? 'no-image.png': $details->photo_meter_dev?>" alt="" width="70px" height="100px">
               <!-- photo shuntrip -->
              <img src="image/<?php echo $details->photo_shuntrip == "" ? 'no-image.png': $details->photo_shuntrip?>" alt="" width="70px" height="100px">
              <!-- PhotoCurrentimiter -->
              <img src="image/<?php echo $details->photo_current_limiter == "" ? 'no-image.png': $details->photo_current_limiter?>" alt="" width="70px" height="100px">
              <!-- PhotoBuilding -->
              <img src="image/<?php echo $details->photo_building == "" ? 'no-image.png': $details->photo_building?>" alt="" width="70px" height="100px">
              <!-- photo 1 -->
              <img src="image/<?php echo $details->photo_1 == "" ? 'no-image.png': $details->photo_1?>" alt="" width="70px" height="100px">
              <!-- photo 2 -->
              <img src="image/<?php echo $details->photo_2 == "" ? 'no-image.png': $details->photo_2?>" alt="" width="70px" height="100px">
            </td>
        </tr>
        <tr>
        <th colspan="12" style="text-align:center;font-size:11px">&nbsp;</th>
        </tr>
        <tr>
          <th colspan="12" style="text-align:center;font-size:11px">DATA MODEM PADA SAAT DIPERIKSA</th>
        </tr>
        
        <tr>
          <td colspan="2" style="text-align:center;font-size:11px;border:1">Keterangan</td>
          <td colspan="4" style="text-align:center;font-size:11px;border:1">Modem Dibongkar</td>
          <td colspan="4" style="text-align:center;font-size:11px;border:1">Modem Terpasang/Dipasang</td>
          <td></td>
          <td></td>
        </tr>
        <tr>
            <td>Merk / Type Modem</td>
            <td style="text-align:center">:</td>
            <td colspan="4" style="text-align:center"><?=$details->modem_brand?>/<?=$details->modem_brand?></td>
            <td colspan="4" style="text-align:center"><?=$details->new_modem_brand?><?php echo $details->new_modem_brand=="" ? "" :"/"?><?=$details->new_modem_brand?></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Nomor Imei</td>
            <td style="text-align:center">:</td>
            <td colspan="4" style="text-align:center"><?=$details->modem_imei?></td>
            <td colspan="4" style="text-align:center"><?=$details->new_modem_imei?></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Kondisi</td>
            <td style="text-align:center">:</td>
            <td colspan="4" style="text-align:center"><?=$details->modem_condition?></td>
            <td colspan="4" style="text-align:center"><?=$details->new_modem_condition?></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Letak Antena</td>
            <td style="text-align:center">:</td>
            <td colspan="4" style="text-align:center"><?=$details->ant_potition?></td>
            <td colspan="4" style="text-align:center"><?=$details->new_ant_potition?></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
          <th colspan="12" style="text-align:center;font-size:11px">&nbsp;</th>
        </tr>
        <tr>
            <th colspan="6" style="text-align:left;font-size:11px">KONDISI SEGEL SAAT DIPERIKSA</th>
            <th colspan="6" style="text-align:left;font-size:11px">KESIMPULAN</th>
        </tr>
        <tr>
            <td>Pintu Luar Atas</td>
            <td style="text-align:center">:</td>
            <td colspan="4"><?=$details->top_panel_door_seal?></td>
            <td rowspan="2">Pembatas</td>
            <td style="text-align:center" rowspan="2">:</td>
            <td colspan="4" rowspan="2" style="border:1"><?=$details->site_allocation?></td>
        </tr>
        <tr>
            <td>Pintu Luar Bawah</td>
            <td style="text-align:center">:</td>
            <td colspan="4"><?=$details->bottom_panel_door_seal?></td>
        </tr>
        <tr>
            <td>Tutup Terminal KWH</td>
            <td style="text-align:center">:</td>
            <td colspan="4"><?=$details->top_panel_door_seal?></td>
            <td rowspan="2">Catatan</td>
            <td style="text-align:center" rowspan="2">:</td>
            <td colspan="4" rowspan="2" style="border:1"><?=$details->note?></td>
        </tr>
        <tr>
            <td>Pintu Modem</td>
            <td style="text-align:center">:</td>
            <td colspan="4"><?=$details->bottom_panel_door_seal?></td>
        </tr>
        <tr>
          <th colspan="12" style="text-align:center;font-size:11px">&nbsp;</th>
        </tr>
        <tr>
          <th colspan="12" style="text-align:center;font-size:11px">&nbsp;</th>
        </tr>
        <tr>
          <td colspan="12" style="text-align:left;font-size:11px">Demikian berita acara ini dibuat dengan sebenarnya dan disaksikan pihak pelanggan untuk dipergunakan sebagaimana mestinya</t>
        </tr>
        <tr>
          <th colspan="12" style="text-align:center;font-size:11px">&nbsp;</th>
        </tr>
        <tr>
          <td style="text-align:center;font-size:11px" colspan="3">Pelanggan</td>
          <td colspan="4">&nbsp;</td>
          <td style="text-align:center;font-size:11px" colspan="5">Petugas</td>
          
        </tr>
        <tr>
          <th colspan="12" style="text-align:center;font-size:11px">&nbsp;</th>
        </tr>
        <tr>
          <th colspan="12" style="text-align:center;font-size:11px">&nbsp;</th>
        </tr>
        <tr>
          <th colspan="12" style="text-align:center;font-size:11px">&nbsp;</th>
        </tr>
        <tr>
          <th colspan="12" style="text-align:center;font-size:11px">&nbsp;</th>
        </tr>
       
        <tr>
          <?php
          $no=1;
          $petugasnya = $this->db->query("SELECT * FROM petugas where groups ='$details->groups'");?>
          <td style="text-align:center;font-size:11px" colspan="3">( <?php echo $customerData->customer_name?> )</td>
          <td colspan="4"></td>
          <td style="text-align:center;font-size:11px" colspan="5">
            <table>
              <tr>
                <?php foreach($petugasnya->result() as $row){
                  $no++;
                  if($no==3 || $no==4){
                    $penyambung ="";
                  }else{
                    $penyambung="/";
                  }
                  echo '<td>'.'('.$row->name.')'.'</td><td>'.$penyambung.'</td>';
                  if($i==2){
                    echo '<tr></tr>';
                  }
                }
                 ?>
                  
              </tr>
            </table> 
           
          </td>
        
        </tr>
      </table>
  </body>
  
  </html>   