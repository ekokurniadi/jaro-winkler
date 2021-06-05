
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>USER AUTHENTICATION</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="<?php echo base_url()?>/node_modules/bootstrap-social/bootstrap-social.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="<?php echo base_url()?>/assets/css/style.css">
  <link rel="stylesheet" href="<?php echo base_url()?>/assets/css/components.css">
  <link rel="shortcut icon" href="<?php echo base_url().'image/logo_hond.png'?>">
</head>

<body style="background-image:url('<?php echo base_url()?>image/bg.jpg');background-size: cover; background-repeat: no-repeat;background-position: center;height:100%'">
  <div id="app" style="margin:auto;">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
            <div class="login-brand">
              <img src="image/uin.png" alt="logo" width="100"  style="margin-top:0px">
            <h3 style="color:red;">JARO WINKLER</h3>
            <p style="color:whitesmoke;text-shadow: 2px 2px black;">DISTANCE</p>
            </div>
            </div>
          
            <div class="card card-primary" style="margin-top:-25px">
            <div class="card-header"><h4 style="text-align:center;">User Authentication</h4></div>
            <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
              <div class="card-body">
                <form method="POST" action="#" class="needs-validation" novalidate="">
                <form accept-charset="UTF-8" role="form" class="form-signin">
                  <div class="form-group">
                    <label for="email">Username</label>
                    <input id="username" type="text" class="form-control" autocomplete="off" name="username" tabindex="1" required>
                    <div class="invalid-feedback">
                      Please fill in your Username 
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="d-block">
                    	<label for="password" class="control-label">Password</label>
                      <!-- <div class="float-right">
                        <a href="auth-forgot-password.html" class="text-small">
                          Forgot Password?
                        </a>
                      </div> -->
                    </div>
                    <input id="password" autocomplete="off" type="password" class="form-control" name="password" tabindex="2" required>
                    <div class="invalid-feedback">
                      please fill in your password
                    </div>
                  </div>
                  <div class="form-group" >
                  <div class="d-block">
                  <table>
                    <tr>
                    <th><p id="captImg" class="captcha-img" style="width:130px;"><?php echo $captchaImg; ?></p></th>
                    <th>  <a href="#" class="btn btn-primary btn-block btn-sm" id='refreshCaptcha' style="margin-bottom:15px;"><i class="fa fa-history"></i> re-Captcha</a> </th>
                    </tr>
                  </table>
                    
                  
                  <div>
                  </div>

                <div class="row">
                  <div class="col-md-12">
                  <input type="text" class="form-control" name="captcha" placeholder="Ketik ulang kode di atas" style="margin-bottom: 10px" autocomplete="off"/>
                  </div>
                </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-danger btn-lg btn-block" tabindex="4">
                      Login
                    </button>
                  </div> 
                </form>
                </div>
              </div>
              </div>
            </div>
            <!-- <div class="simple-footer" style="margin-top:-20px;color:white">
              Copyright &copy <?php echo date('Y')?> Allright reserved.
            </div> -->
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="<?php echo base_url()?>/assets/js/stisla.js"></script>
  

  <!-- JS Libraies -->

  <!-- Template JS File -->
  <script src="<?php echo base_url()?>/assets/js/scripts.js"></script>
  <script src="<?php echo base_url()?>/assets/js/custom.js"></script>
<!-- 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->

<!-- captcha refresh code -->
<script>
$(document).ready(function(){
    $('#refreshCaptcha').on('click', function(){
        $.get('<?php echo base_url().'auth/refresh'; ?>', function(data){
            $('#captImg').html(data);
        });
    });
});
</script>

<script>
		$('.toast').toast('show');
</script>
<script>
$(document).ready(function(){
    $(".toast").click(function(){
        $(".toast").toast('hide');
    });
});
</script>

  <!-- Page Specific JS File -->
</body>
</html>

    