<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Dashboard</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

   <!-- CSS Libraries -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
 
  <!-- load jquery CDN -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
 

  <!-- Template CSS -->
  <link rel="stylesheet" href="<?php echo base_url()?>/assets/css/style.css">
  <link rel="stylesheet" href="<?php echo base_url()?>/assets/css/components.css">

  <!-- komponen text area -->
  <link href="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/js/froala_editor.pkgd.min.js"></script>    
  <link rel="stylesheet" href="<?= base_url()?>/assets/loader.css">
  <script type="text/javascript" src="<?= base_url()?>/assets/loader.js"></script>
</head>
<?php if($_SESSION['username']=="" || $_SESSION['role']==""){
  redirect(site_url('auth'));
}?>
<body oncontextmenu="return true;" class="hold-transition skin-red-light sidebar-mini">

  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>
          <!-- <div class="search-element">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="250">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
          </div> -->
        </form>           
        <ul class="navbar-nav navbar-right">

        
        <div style="color:white;font-weight:bold;" id="banner">
              </div>

          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
          <?php 
          $id=$_SESSION['id'];
          $foto = $this->db->query("select * from user where id='$id'")->row_array();
          ?>
            <img alt="image" src="<?=base_url('/assets/img/avatar/avatar-1.png')?>" class="rounded-circle mr-1">
         
            <div class="d-sm-none d-lg-inline-block">Hi, Sri Rezeki Fitri</div></a>
           
          </li>
        </ul>
      </nav>
      <div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
           <a href="#" class="shadow-light">Control Panel</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
          <div class="img-responsive">
          <img src="<?= base_url()?>image/uin.png" alt="" width="60px">
          </div>
          </div>
          <ul class="sidebar-menu">
              <li class="menu-header">Dashboard</li>
              <li class="nav-item dropdown">
                <a href="<?php echo base_url('dashboard')?>"><i class="fas fa-fire"></i><span>Dashboard</span></a>
              </li>
         
              <li class="menu-header">Menu</li>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-building"></i> <span>Menu Utama</span></a>
                <ul class="dropdown-menu">
                 
                  <li><a class="nav-link" href="<?php echo base_url('user')?>">User</a></li>
                
                </ul>
                
              </li>
             
              </ul> 
        </aside>
     
      </div>
      <script>
      $(document).ready(function() {
          get_notif();
          setTimeout(get_notif, 50000);
          setInterval(get_notif, 50000); // The interval set to 20 seconds

        })

        function get_notif() {
          $.ajax({
            url: "<?php echo site_url('api/getNotification'); ?>",
            cache: false,
            type: "POST",
            dataType: 'JSON',
            success: function(response) {
              showNotif(response);
              
                var beep = document.getElementById('bel');
              if(response.total_notif  <= 0){
                beep.setAttribute('class','nav-link notification-toggle nav-link-lg');
              }else{
                beep.setAttribute('class','nav-link notification-toggle nav-link-lg beep');
                document.getElementById('banner').innerHTML='Anda Mempunyai <span class="jml_notif"></span> Notifikasi Baru';
              }
              // console.log(response);
            },
            complete: function() {
              // Schedule the next request when the current one's complete
              // setInterval(get_notif, 50000); // The interval set to 5 seconds
            }
          });
        }

        function showNotif(response) {
          $("#container-notif-register").html('');
          $('.jml_notif').text(response.total_notif);
          var html = '';
          for (rsp of response.data) {
            html +="<a href='"+rsp[2]+"' class='dropdown-item dropdown-item-unread'><div class='dropdown-item-icon bg-primary text-white'><i class='fas fa-info'></i></div><div class='dropdown-item-desc'>"+rsp[3]+ "</div></a>";  
            // toastr_success(rsp.pesan);        
          }
          // console.log(popup_showed);
          $("#container-notif-register").append(html);
        }

       
       
      </script>