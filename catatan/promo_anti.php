<?php
session_start();
include "../conf.php";
if (!isset($_SESSION['FBID'])){
	header("Location: ../catatan");
}
$fbid = $_SESSION['FBID'];
$que = mysqli_query($con,"SELECT `nama_dpn`,`nama_blk`,`no_wa`,`username` FROM `pengguna` WHERE `id_fb`='$fbid'");	
$cek = mysqli_fetch_array($que);
$nama = ucwords($cek['nama_dpn'].' '.$cek['nama_blk']);
$nope = $cek['no_wa'];
$alm = 'http://'.$cek['username'].'.sukses.family';
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Welcome to SuksesFamily</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="apple-touch-icon" sizes="76x76" href="favicon-i.png">
		<link rel="icon" type="image/png" href="favicon.png">
		<meta name="theme-color" content="#4acaa8" />
		<meta name="keywords" content="daftar, sukses, family, sukses family, paytren, yusuf mansyur, UYM, bisnis paytren, bayar bayar, bayar">
		<meta http-equiv="content-language" content="In-Id"/>
		<meta name="geo.placename" content="Indonesia"/>
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="../assets/css/main.css" />
		<link rel="stylesheet" href="../assets/css/notif.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
	</head>
	<body>

		<!-- Header -->
			
			<section id="header">
				<header>
					<span class="image"><img src="../daftar/favicon.png" alt="" /></span>
					<h1 id="logo"><a href="#">Gambar Promo </a></h1>
					<p>Komunitas SuksesFamily komunitas bisnis lintas jaringan.</p>
				</header>
				
				<footer>
					<ul class="icons">
						<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
						<li><a href="https://facebook.com/10211507836106395" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
						<li><a href="" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
						<li><a href="#" class="icon fa-github"><span class="label">Github</span></a></li>
						<li><a href="" class="icon fa-envelope"><span class="label">Email</span></a></li>
					</ul>
				</footer>
			</section> 

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Main -->
					<div id="main">

				
							<section id="one">
								<div class="container">
									
									<header class="major">
									<h4>Saatnya PROMOSI PayTren!</h4> <p>Halaman ini berisi gambar-gambar yang sudah di design oleh tim SF sesuai peruntukanya (profil WA, status WA,iklan FB, iklan Twitter, status Instagram, dll) silahkan download gambar ini dan gunakan sesuai medsos yang anda pilih </p>
										<!-- <span class="image fit"><img src="bayar.png" alt="" /></span> -->

									</header>
									
									<div class="box alt">
										<div class="row 50% uniform">
											<h4>Gambar Promo Untuk FB/WA Posting</h4>
											<span class="image fit"><canvas id="myCanvas" width="626" height="840"></canvas><p></span>
											<ul class="actions">
											<li><a class="button special big" id="download">Download Gambar</a></li>
											</ul>
											
											Selama Uji Coba, halaman ini dapat diakses oleh member paket sewa apapun (28 Maret 2018, halaman ini hanya akan bisa diakses oleh member paket sewa 2th)</p>
										</div>
										
									
									</div>	
								</div>
							</section>		
							
						

					</div>

				<!-- Footer -->
					<section id="footer">
						<div class="container">
							<ul class="copyright">
								<li>&copy; timDTS Jakarta</li>
							</ul>
						</div>
					</section>

			</div>

		<!-- Scripts -->
			<script src="../assets/js/jquery.min.js"></script>
			<!-- <script src="../assets/js/jquery.scrollzer.min.js"></script>
			<script src="../assets/js/jquery.scrolly.min.js"></script> -->
			<script src="../assets/js/skel.min.js"></script>
			<script src="../assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]
			<script src="../assets/js/main.js"></script>-->
			<script>

	window.onload = function(){
     var canvas = document.getElementById("myCanvas");
     var context = canvas.getContext("2d");
     var imageObj = new Image();
     imageObj.setAttribute('crossOrigin', 'anonymous');
	 var imageFT = new Image();
     imageFT.setAttribute('crossOrigin', 'anonymous');
	 imageFT.src = "../poto/<?php echo $fbid; ?>.jpg";
	 function roundedImage(x,y,width,height,radius,ctx){
      ctx.beginPath();
      ctx.moveTo(x + radius, y);
      ctx.lineTo(x + width - radius, y);
      ctx.quadraticCurveTo(x + width, y, x + width, y + radius);
      ctx.lineTo(x + width, y + height - radius);
      ctx.quadraticCurveTo(x + width, y + height, x + width - radius, y + height);
      ctx.lineTo(x + radius, y + height);
      ctx.quadraticCurveTo(x, y + height, x, y + height - radius);
      ctx.lineTo(x, y + radius);
      ctx.quadraticCurveTo(x, y, x + radius, y);
      ctx.closePath();
    }


    imageObj.onload = function(){
         context.drawImage(imageObj, 0, 0);  
		 context.font = "12pt Calibri";
		 context.fillStyle = 'white';
		 //context.rotate(Math.PI / 4);
         context.fillText("<?php echo $alm; ?>", 350,730);
		 context.font = "16pt Arial";
		  context.fillStyle = 'black';
		 context.fillText("<?php echo $nope; ?>", 50,745);
		 context.font = "14pt Calibri";
		 context.fillText("<?php echo $nama; ?>", 50,720);
		roundedImage(220,655,125,125,10,context);
		context.clip();
		 context.drawImage(imageFT,220,655,125,125);
		 context.clip();
		context.restore()
         
		 
		 
		};
	imageObj.src = "sf3.png"; 
	};
	
	function downloadCanvas(link, canvasId, filename) {
		link.href = document.getElementById(canvasId).toDataURL();
		link.download = filename;
	}
	
	document.getElementById('download').addEventListener('click', function() {
    downloadCanvas(this, 'myCanvas', 'SF_ust_syafii3.jpg');
	}, false);
	
</script>
</body>
</html>