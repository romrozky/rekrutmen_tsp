<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" href="<?= base_url() ?>images/fav.png">
    <title>PT. XYZ </title>
    <!-- Bootstrap Core CSS -->
    <link href="<?= base_url() ?>assets/bootstrap.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url() ?>assets/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="<?= base_url() ?>assets/colors/blue.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

    <style type="text/css">
            
            html, body, #wrapper {
                height: 100%;
            }
    </style>
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <section id="wrapper">
        <div class="login-register">
            <div class="login-box">
                <center>
                    <img src="<?= base_url() ?>images/logo-login.png" alt="user" class="img-responsive" alt="Login JMS" style="padding-bottom: 2%;"/>
                </center>
                <div class="card-body" style="background-color: transparent;">
                   <form accept-charset="UTF-8" role="form" id='xyz' class="form-signin">
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control btn-rounded" type="text" required="" placeholder="Username"  name="username"> </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control btn-rounded" type="password" required="" placeholder="Password"  name="password"> </div>
                        </div>
						<div class="form-group">
                            <div class="col-xs-12">
                                <center><img src='<?=site_url('Login/capcay')?>'></center>
								<input class="form-control btn-rounded" type="text" required="" placeholder="Captcha"  name="capcay"> </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12 font-14">
                                    <button class="btn waves-effect waves-light btn-rounded text-uppercase btn-block text-white" type="button" id='login' style="padding-left: 30px; padding-right: 30px;background-color: #d51b43;">
                                        MASUK
                                    </button>   
                                
                            </div>
                        </div>
						</form>
						
                        
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="<?= base_url() ?>assets/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?= base_url() ?>assets/popper.min.js"></script>
    <script src="<?= base_url() ?>assets/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?= base_url() ?>assets/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="<?= base_url() ?>assets/waves.js"></script>
    <!--Menu sidebar -->
    <script src="<?= base_url() ?>assets/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="<?= base_url() ?>assets/sticky-kit.min.js"></script>
    <script src="<?= base_url() ?>assets/jquery.sparkline.min.js"></script>
    <!--Custom JavaScript -->
    <script src="<?= base_url() ?>assets/custom.min.js"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="<?= base_url() ?>assets/jQuery.style.switcher.js"></script>
</body>
<div id="modal_form" class="modal" data-width="600">
        <div id="tampil_form"></div>
    </div>
<script>
$(document).ready(function(){ 
    $("input").attr("autocomplete", "off"); 
});
$('#xyz').attr('autocomplete', 'off');
$(document).on('click','#forget',function(){
	$('#tampil_form').load("<?=site_url()?>/Login/forget/",function(){
	$('#modal_form').modal('show');
	});
});
$(document).on('click','#register',function(){
	location.href= '<?=site_url('Login/register')?>';
});
	$(document).ready(function() {
		$('#login').click(function () {
                $("#loading").show();
				var formData = $('#xyz').serialize();
                $.ajax({
                    url: "<?=site_url('Login/proses')?>",
                    type: "POST",
                    dataType: 'json',
                    data: formData,
                    error: function () {
                        alert('Gagal simpan data');
                        $("#loading").hide();
                    },
                    success: function (respon) {
                        $("#loading").hide();
                        if (respon.status == 'berhasil') {
//                            alert(respon.alert);
							window.location.href = respon.link;
                        } else {
                            alert(respon.alert);
							window.location.href = respon.link;
                        }
                    }

                })
        });
		$('#password').keypress(function (e) {
			 var key = e.which;
			 if(key == 13)  // the enter key code
			  {
				$("#loading").show();
				var formData = $('#xyz').serialize();
                $.ajax({
                    url: "<?=site_url('Login/proses')?>",
                    type: "POST",
                    dataType: 'json',
                    data: formData,
                    error: function () {
                        alert('Gagal simpan data');
                        $("#loading").hide();
                    },
                    success: function (respon) {
                        $("#loading").hide();
                        if (respon.status == 'berhasil') {
  //                          alert(respon.alert);
							window.location.href = respon.link;
                        } else {
                            alert(respon.alert);
							window.location.href = respon.link;
                        }
                    }

                })  
			  }
		});
		$('#captcha').keypress(function (e) {
			 var key = e.which;
			 if(key == 13)  // the enter key code
			  {
				$("#loading").show();
				var formData = $('#xyz').serialize();
                $.ajax({
                    url: "<?=site_url('Login/proses')?>",
                    type: "POST",
                    dataType: 'json',
                    data: formData,
                    error: function () {
                        alert('Gagal simpan data');
                        $("#loading").hide();
                    },
                    success: function (respon) {
                        $("#loading").hide();
                        if (respon.status == 'berhasil') {
    //                        alert(respon.alert);
							window.location.href = respon.link;
                        } else {
                            alert(respon.alert);
							window.location.href = respon.link;
                        }
                    }

                })  
			  }
		});
});

</script>
</html>