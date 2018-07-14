<?php session_start();
if(isset($_SESSION['FBID'])){
$fbid = $_SESSION['FBID'];           
$nama_lengkap = $_SESSION['FULLNAME'];
}else{
	header("Location: ../daftar");
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Facebook Tidak Terdaftar!</title>

	<link rel="canonical" href="https://sukses.family/daftar"/>
	
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

	<link href="../bootstrap3/css/bootstrap.css" rel="stylesheet" />
    <link href="../home/css/ct-paper.css" rel="stylesheet"/>
    <link href="../home/css/demo.css" rel="stylesheet" />
    <link href="../home/css/examples.css" rel="stylesheet" />

    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>

</head>
<body class="full-screen login">
    <nav class="navbar navbar-ct-transparent navbar-fixed-top" role="navigation-demo" id="register-navbar">
      <div class="container">
       
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="www.creative-tim.com.html">Facebook Tidak Terdaftar!</a>
        </div>

        
      
      </div><!-- /.container-->
    </nav>

    <div class="wrapper">
        <div class="background instagram">
            <div class="filter-black"></div>
            <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1 ">
						<div class="card card-user">
                            <div class="image">
                                 <img src="fb.jpg" alt="..."/>
                            </div>
                            <div class="content">
                                <div class="author"> 
                                    <img class="avatar" src="https://graph.facebook.com/<?php echo $fbid; ?>/picture?type=large" alt="..."/>
									<h4 class="title"><?php echo $nama_lengkap; ?></h4>
								</div>
                                <p class="description text-center">
                                    <small>Facebook yang anda gunakan ini tidak terdaftar sebagai member <b>SuksesFamily</b> <i class="text-warning">anda tidak dapat mengakses /catatan </i>dengan akun facebook ini. </smalll></p><p>Klik Tombol dibawah ini + Logout/Keluar dari Facebook dan cobalah buka /catatan anda kembali.
                                </p>
                            </div>
                            <div class="card-footer text-center">
                                <a href="http://fb.com" class="btn btn-icon btn-fill btn-facebook"><i class="fa fa-facebook"></i> Facebook </a>
                            </div>
                        </div> <!-- end card -->
                        </div>
                    </div>
            </div>

            <div class="demo-footer text-center">
                    <h6>SuksesFamily</h6>
            </div>
        </div>
    </div>

</body>

<script src="../home/js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="../home/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>

<script src="../bootstrap3/js/bootstrap.js" type="text/javascript"></script>

<!--  Plugins -->
<script src="../home/js/ct-paper-checkbox.js"></script>
<script src="../home/js/ct-paper-radio.js"></script>
<script src="../home/js/ct-paper-bootstrapswitch.js"></script>

<!--  for fileupload -->
<script src="../home/js/jasny-bootstrap.min.js"></script>

<script src="../home/js/ct-paper.js"></script>

</html>
