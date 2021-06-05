<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
   <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>
  
    
  <!-- </body> -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Dashboard</h1>
          </div>
          <div class="row">
         
            <div class="col-lg-4 col-md-4 col-sm-4 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                  <i class="fas fa-bar-chart"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Target Operasi</h4>
                  </div>
                  <div class="card-body">
                  <?php
                  if($_SESSION['level']!="Admin"){
                   echo number_format($this->db->get_where('tasklist',array('task_status'=>'belum','area_name'=>$_SESSION['area_name']))->num_rows(),0,'.',',');
                  }else{
                   echo number_format($this->db->get_where('tasklist',array('task_status'=>'belum'))->num_rows(),0,'.',',');
                  }
                  ?>
                  </div>
                </div>
              </div>
            </div> 
            <div class="col-lg-4 col-md-4 col-sm-4 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                <i class="fas fa-bar-chart"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Selesai</h4>
                  </div>
                  <div class="card-body">
                  <?php 
                  if($_SESSION['level']!= "Admin"){
                    echo number_format($this->db->get_where('tasklist',array('task_status'=>'Complete','area_name'=>$_SESSION['area_name']))->num_rows(),0,'.',',');
                  }else{
                    echo number_format($this->db->get_where('tasklist',array('task_status'=>'Complete'))->num_rows(),0,'.',',');
                  }?>
                  </div>
                </div>
              </div>
            </div> 
            <div class="col-lg-4 col-md-4 col-sm-4 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                  <i class="fas fa-globe"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Belum Progress</h4>
                  </div>
                  <div class="card-body">
                  <?php if($_SESSION['level'] != "Admin"){?>
                  <?=number_format($this->db->get_where('tasklist',array('task_status'=>'Belum','area_name'=>$_SESSION['area_name']))->num_rows() - $this->db->get_where('tasklist',array('task_status'=>'Complete','area_name'=>$_SESSION['area_name']))->num_rows(),0,'.',',');?>
                  <?php } else { ?>
                  <?=number_format($this->db->get_where('tasklist',array('task_status'=>'Belum'))->num_rows() - $this->db->get_where('tasklist',array('task_status'=>'Complete'))->num_rows(),0,'.',',');?>
                 <?php }?>
                  </div>
                </div>
              </div>
            </div> 

          
            <!-- <style>
              tbody {
                  display:block; 
                  height:230px;
                  overflow-y:scroll;
              }
              tr {
                  display:block;
              } 
              th, td {
                  width:250px;
              }
            </style> -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-12" >
              <div class="card bg-dark" >
                
                <div class="card-wrap">
                  <div class="card-header">
                  <h4 class="text-white">STATUS PER PETUGAS SAAT INI <br><?=tgl_indo('Y-m-d')?></h4>
                  </div>
                  <div class="card-body">
                    <div class="table">
                      <table id="example1" class="table" style="min-width:100%" >
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>ID Pelanggan</th>
                            <th>Nama Pelanggan</th>
                            <th>Alamat</th>
                            <!-- <th>Indikasi</th> -->
                            <th>Nama Petugas</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody></tbody>
                      </table>
                      <script>
                          $(document).ready(function() {
                          dataTable = $('#example1').DataTable({
                              "processing": true,
                              "serverSide": true,
                              "scrollX": true,
                              "scrollY": false,
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
                                url: "<?php echo site_url('dashboard/fetch_data'); ?>",
                                type: "POST",
                                dataSrc: "data",
                                data: function(d) {
                                  return d;
                                },
                              },
                              "columnDefs": [
                                { "targets":[0],"orderable":false},
                                
                                {
                                  "targets": [0,1,2,3,4,5],
                                  "className": 'text-white'
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
                </div>
              </div>
            </div> 
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
              <div class="card">
                
                <div class="card-wrap">
                  <div class="card-header">
                    <div class="container-fluid">
                    <div class="row">
	<div class="col-md-12">
		<h2>Lokasi Petugas</h2>
		<div style="height: 800px;" id="map"></div>
        <script>
          //global array to store our markers
        var markersArray = [];
        var map;
        function load() {
            map = new google.maps.Map(document.getElementById("map"), {
                center : new google.maps.LatLng(-2.0566440354721145, 120.62327289188507),
                zoom : 4,
                mapTypeId : 'roadmap'
            });
            var infoWindow = new google.maps.InfoWindow;

            // your first call to get & process inital data

            downloadUrl("<?php echo base_url() ?>api/all_lokasi", processXML);
        }

        function processXML(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName("marker");
            //clear markers before you start drawing new ones
            resetMarkers(markersArray)
            for(var i = 0; i < markers.length; i++) {
                var host = markers[i].getAttribute("id");
                var type = markers[i].getAttribute("nama");
                var bearing = markers[i].getAttribute("afc");
                var lastupdate = "<?php echo get_waktu() ?>"; //markers[i].getAttribute("lastupdate");
                var point = new google.maps.LatLng(parseFloat(markers[i].getAttribute("latitude")), parseFloat(markers[i].getAttribute("longitude")));
                var html = "<b>" + "Host: </b>" + host + "<br><b>"+ "Petugas: </b>" + type + "<br>" + "<b>Lokasi Terakhir: </b>" + bearing + "<br>" + "<br>" + "<b>Update Terakhir: </b>" + lastupdate + "<br>";
                console.log(point+" "+html);
                // var icon = customIcons[type] || {};
                var infoWindow = new google.maps.InfoWindow;
                var marker =  new google.maps.Marker({
                icon: {
                  anchor: new google.maps.Point(6, 15),
                  path: 'M12 0c-3.148 0-6 2.553-6 5.702 0 3.148 2.602 6.907 6 12.298 3.398-5.391 6-9.15 6-12.298 0-3.149-2.851-5.702-6-5.702zm0 8c-1.105 0-2-.895-2-2s.895-2 2-2 2 .895 2 2-.895 2-2 2zm4 14.5c0 .828-1.79 1.5-4 1.5s-4-.672-4-1.5 1.79-1.5 4-1.5 4 .672 4 1.5z',
                  // path: "<?php echo base_url() ?>images/log.png",
                  
                  scale: 2,
                  strokeColor: 'red'
                },
            position: point,
            map: map
          });
                //store marker object in a new array
                markersArray.push(marker);
                bindInfoWindow(marker, map, infoWindow, html);


            }
                // set timeout after you finished processing & displaying the first lot of markers. Rember that requests on the server can take some time to complete. SO you want to make another one
                // only when the first one is completed.
                setTimeout(function() {
                    downloadUrl("<?php echo base_url() ?>api/all_lokasi", processXML);
                }, 5000);
        }

    //clear existing markers from the map
    function resetMarkers(arr){
        for (var i=0;i<arr.length; i++){
            arr[i].setMap(null);
        }
        //reset the main marker array for the next call
        arr=[];
    }
    var infoWindow = new google.maps.InfoWindow;
        function bindInfoWindow(marker, map, infoWindow, html) {
            google.maps.event.addListener(marker, 'click', function() {
                infoWindow.setContent(html);
                infoWindow.open(map, marker);
            });
        }

        function downloadUrl(url, callback) {
            var request = window.ActiveXObject ? new ActiveXObject('Microsoft.XMLHTTP') : new XMLHttpRequest;

            request.onreadystatechange = function() {
                if(request.readyState == 4) {
                    request.onreadystatechange = doNothing;
                    callback(request, request.status);
                }
            };

            request.open('GET', url, true);
            request.send(null);
        }
        function doNothing() {}

        </script>
        <script defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAyfmnFvhRQqjFSW7euy935Pm8gVq9GE0&callback=load">
        </script>
      </div>
                            </div>
                          </div>
                    </div>
                    </div>
                   
                  </div>
                  <div class="card-body">
                  <div style="height: 730px;min-width:100%" id="map"></div>
                  </div>
                </div>
              </div>
            </div> 
           
          </div>  
        </section>
      </div>

     