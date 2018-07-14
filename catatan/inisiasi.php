 <?php //inisiasi transfer cashback
	session_start();
	include "../conf.php"; 
	$fbid = $_SESSION['FBID'];           
	$nama_lengkap = $_SESSION['FULLNAME'];
	
	
 //cek user
	function cek($con,$fbid){
	 $qc = mysqli_query($con,"SELECT `username` FROM `pengguna` WHERE `id_fb` = '$fbid' AND `tgl_lunas` IS NOT NULL ");
	 $ada = mysqli_fetch_array($qc);
	if ($ada['username']){
		$hsl = $ada['username'];
	}else{
		$hsl = 'no';
	}
	return $hsl ;		
	}
 
	function pembayaran($con,$db,$usr,$th1,$th2,$k_2th,$k_1th,$k_6bln){
		$list_pengguna =''; $np =0;
		$list_upgrade = ''; $nu =0;
	$q= "SELECT `username`,`no_wa`,`tgl_exp`,`id_fb`,`nama_fb`,`nama_dpn`,`paytren_id`,`nominal`,`tgl_lunas` FROM `$db`.`pengguna`  WHERE `referal` = '$usr' AND `tgl_lunas` IS NOT NULL AND `web_training` ='tidak' ";
	$quq = mysqli_query($con,$q);
	$hsl =''; $tabelh=''; $komisi_n =0;
	$no_urut =1;
	while($pgg = mysqli_fetch_array($quq)){	
	if($np == 0){
	$list_pengguna = $list_pengguna.$pgg['username'];
	}else{
	$list_pengguna = $list_pengguna.','.$pgg['username'];	
	}	
	$np++ ;
		$angg = $pgg['nominal']; 
		if($angg + 40000 >= $th2){
			$sewa ='2th ';		
			$komisi = $k_2th;
		}else if($angg + 40000 >= $th1){
			$sewa ='1th ';
			$komisi = $k_1th;
		}else{
			$sewa ='6bln ';
			$komisi = $k_6bln;
		}
		$komisi_n = $komisi_n+$komisi;
		$rp_nom = $komisi/1000;
		$hsl = $hsl.'
								<tr>
                                    <td class="text-center">'.$no_urut.'</td>
                                    <td>'.$pgg['username'].'</td>
                                    <td>Replika '.$sewa.'</td>
                                    <td>'.$rp_nom.'K</td>
                                </tr>
			';
		$no_urut++	;
	}
	$q_u = mysqli_query($con,"SELECT `idfb`,`username`,`nominal_up`,`upgrade`,`bagi_hasil` FROM `upgrade` WHERE `referal` ='$usr' AND `tgl_lunas` IS NOT NULL AND `basil_dibayar` IS NULL");
	while($up = mysqli_fetch_array($q_u)){
	if($nu == 0){
	$list_upgrade = $list_upgrade.$up['username'];
	}else{
	$list_upgrade = $list_upgrade.','.$up['username'];	
	}	
	$nu++ ;	
		$k_up = $up['bagi_hasil'];
		$denom_k = $k_up/1000;
		$komisi_n = $komisi_n + $k_up;
		$hsl = $hsl.'
								<tr>
                                    <td class="text-center">'.$no_urut.'</td>
                                    <td>'.$up['username'].'</td>
                                    <td>Upgrade</td>
                                    <td>'.$denom_k.'K</td>
                                </tr>
			';
		$no_urut++;
	}
	return array('tabel' => $hsl, 'komisi' => $komisi_n, 'list_pengguna' => $list_pengguna, 'list_upgrade' => $list_upgrade);
}
$notif =''; $notifikasi='';
$ck = cek($con,$fbid);
if( $ck == 'no'){
	$tabel =''; $komisi =0;
	header("Location: ../daftar");
	//echo $ck;
}else{
	$usr = $ck;
	//input rekening
	if(isset($_POST['rek'])){
		//cek validasi
		$xbank = $_POST['bank'];
		$xnorek = $_POST['norek'];
		$xcab = $_POST['cab'];
		$xpem =$_POST['pem'];
		
		if($xbank == "no"){
			$notif=$notif.'1';
		}
		if(!ctype_digit($xnorek)){
			$notif=$notif.'2';
		}
		if(strlen($xcab) < 4){
			$notif=$notif.'3';
		}
		if(strlen($xpem) < 3){
			$notif=$notif.'4';
		}
		
		if($notif == ''){
			//kode_rekening
		$kd_bank = array(
		'mandiri' => '008',
		'bsm' => '451',
		'bca' => '014',
		'bcas' => '536',
		'bni' => '009',
		'bnis' => '009',
		'bri' =>'002',
		'bris' => '422',
		'cimb' => '022',
		'cimbs' => '022',
		'muam'=> '147',
		'btn' => '200',
		'dan' => '011',
		'citi' => '031',
		'lain' => '000'
		);
		$hrek = $kd_bank[$xbank].'_'.$xnorek;
		$akun ='dbank_'.$usr;
		//simpan data
			$inp_q ="INSERT INTO `parameter` (`id_param`, `nama`, `param1`, `param2`, `param3`) VALUES (NULL, '$akun', '$hrek', '$xcab', '$xpem')";
			mysqli_query($con,$inp_q);
			//$notifikasi = $inp_q;
		}
	}
	
	$data= pembayaran($con,$db,$usr,$th1,$th2,$k_2th,$k_1th,$k_6bln);
	$tabel = $data['tabel'];
	$komisi = $data['komisi'];
}
//notifikasi

if($notif != ''){
	$not = str_split($notif);
	foreach($not as $er){
		if($er == '1'){
			$al = 'mohon pilih akun Bank yang anda miliki';
			$ty = 'info';
		}else if($er == '2'){
			$al = 'Nomor rekening harus berupa angka, tanpa spasi tanpa tanda apapun!';
			$ty = 'warning';
		}else if($er == '3'){
			$al = 'masukan nama bank beserta lokasi cabang pembukaan rekening';
			$ty = 'success';
		}else{
			$al = 'periksa kembali kotak isian nama pemilik rekening, harus sesuai yang tertera pada buku tabungan';
			$ty ='danger';
		}
		
		$notifikasi = $notifikasi.'
		<div class="alert alert-'.$ty.' alert-with-icon" data-notify="container">
            <div class="container">
                <div class="alert-wrapper">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <i class="alert-icon ti-bell"></i>
                    <div class="message">'.$al.'</div>
                </div>
            </div>
        </div>
		';
	}
	$status = 'error';
}


//tabel tujuan transfer

$isi_rek ='
<div class="row">
                       <div class="col-md-8 col-md-offset-2">
					   <form method="post">
						   <div class="form-group">
						   <p> Anda akan dikenakan biaya administrasi bank untuk pencairan ke rekening selain mandiri, <b>Pilih Bank</b> Mandiri jika anda memiliki rekening bank tersebut</p>
								<select name="bank" class="selectpicker" data-style="no-style form-control" data-menu-style="">
									<option value="no"> Pilih Bank</option>
									<option value="mandiri">Mandiri</option>
									<option value="bsm">Syariah Mandiri</option>
									<option value="bca">BCA</option>
									<option value="bcas">BCA Syariah</option>
									<option value="bni">BNI</option>
									<option value="bnis">BNI Syariah</option>
									<option value="bri">BRI </option>			
									<option value="bris">BRI Syariah</option>
									<option value="cimb">CIMB Niaga </option>
									<option value="cimbs">CIMB Niaga Syariah</option>
									<option value="muam">Muamalat</option>
									<option value="btn">BTN </option>
									<option value="dan">Danamon </option>
									<option value="citi">Citibank</option>
									<option value="lain">Bank Lain</option>
								</select>
							</div>
							<div class="form-group">
                                <h6>Nomor Rekening <span class="icon-danger">*</span></h6>
                                <input type="text" name="norek" class="form-control border-input" placeholder="masukan angka tanpa spasi, tanda - atau titik">
                            </div>
							<div class="form-group">
                                <h6>Nama Bank Cabang Pembukaan Rekening <span class="icon-danger">*</span></h6>
                                <input type="text" name="cab" class="form-control border-input" placeholder="contoh : BRI Rawamangun">
                            </div>
							<div class="form-group">
                                <h6>Nama Pemilik Rekening <span class="icon-danger">*</span></h6>
                                <input type="text" name="pem" class="form-control border-input" placeholder="pemilik rekening sesuai buku tabungan">
                            </div>
							<button type="submit" name="rek" class="btn btn-fill"><i class="fa fa-settings"></i>Kirim Formulir</button>
							</form>
						</div>
					</div>				
';
//kontrol tampilan
if($ck != 'no'){
	//sudah ada no rek blm?
	$nm_akun = 'dbank_'.$ck;
	$qck = mysqli_query($con,"SELECT * FROM `parameter` WHERE `nama`='$nm_akun'");
	$akunb = mysqli_fetch_array($qck);
	if($akunb['param1']){
		$akunbrek = explode('_',$akunb['param1']);
		if($akunbrek[0] != "008"){
		$komisi1 = intval($komisi) - 6500;
		$kurang = 'Rp 6.500';
		}else{
		$komisi1 = $komisi;	
		$kurang = 'Rp 0';
		}
		$tampil ='
  <div class="row">
                       <div class="col-md-8 col-md-offset-2">
					   <div class="info info-horizontal">
                            <div class="icon">
                               
                            </div>
                            <div class="description">
                                <h4> '.$nama_lengkap.'</h4>
                                <p>'.$akunb['param2'].' | '.$akunbrek[1].' | a.n '.$akunb['param3'].' <br/> Kami akan melakukan transfer <b class="text-success">'.rp($komisi1).'</b> sebagai pencairan komisi bulan ini sebagaimana tabel  berikut : <br/> <i> Screenshoot</i> halaman ini sebagai arsip anda.</p>
                                
                            </div>
                       </div> 
					   </div>
					   </div>
					<div class="row">
                    <div class="col-md-8 col-md-offset-2">   
                    <h4><small>Pencairan Bulan Ini</small></h4>
                        <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Komisi</th>
                                    <th>Jenis</th>
                                    <th>Nominal</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
							'.$tabel.'
                                <tr>
                                    <td colspan="2" class="text-right">Komisi Total</td>
									<td> : </td>
									<td>'.rp($komisi).'</td>
                                </tr>
								 <tr>
                                    <td colspan="2" class="text-right">Administrasi Bank</td>
									<td> : </td>
									<td class="text-danger">'.$kurang.'</td>
                                </tr>
								 <tr>
                                    <td colspan="2" class="text-right">Total ditransfer</td>
									<td> : </td>
									<td class="text-success">'.rp($komisi1).'</td>
                                </tr>
                             </tbody>
                        </table>
                        </div>
					</div>
					   <div class="col-md-6 col-xs-12 text-center">
						<small>Setelah anda screenshot, klik tombol dibawah ini untuk proses pencairan.</small>
				<a href="anti.php" class="btn btn-danger btn-sm">OK! Cairkan</a>
						</div>
                    </div>
                
';
//isi data pencairan
$ls_pengguna = $data['list_pengguna'];
$ls_upg = $data['list_upgrade'];
$bulan = date("M");
$qcair = "INSERT INTO `pencairan` (`id_pencairan`, `username`, `nominal`, `pengguna_list`, `upgrade_list`, `tgl_inisiasi`, `tgl_transfer`, `status`, `bukti_transfer`, `group_pencairan`) VALUES (NULL, '$usr', '$komisi1', '$ls_pengguna', '$ls_upg', NOW(), NULL, 'inisiasi', NULL, '$bulan')";
mysqli_query($con,$qcair);
	}else{
		$tampil = $isi_rek;
	}
}
 ?>
 <!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="../home/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Catatan Sukses Family</title>

	<!-- Canonical SEO -->
	<link rel="canonical" href="https://sukses.family/catatan"/>
	
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <link href="../bootstrap3/css/bootstrap.css" rel="stylesheet" />
    <link href="../home/css/ct-paper.css" rel="stylesheet"/>
    <link href="../home/css/demo.css" rel="stylesheet" />
    <link href="../home/css/examples.css" rel="stylesheet" />

    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
	<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '380529232367084');
  fbq('track', 'DataRekening');
  
</script>
</head>
<body class="search">
    <nav class="navbar navbar-relative navbar-ct-transparent navbar-burger" role="navigation-demo">
      <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
            <span class="sr-only">Tombol</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Lembar Pencairan</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-white-collapse" id="navigation-example-2">
          <ul class="nav navbar-nav navbar-right">
                <li><a class="btn btn-simple btn-neutral">SuksesFamily</a></li>
                <li><a class="btn btn-simple btn-neutral">2017</a></li>
                <li><a  target="_blank" class="btn btn-simple btn-neutral"><i class="fa fa-twitter"></i></a></li>
                <li><a  target="_blank" class="btn btn-simple btn-neutral"><i class="fa fa-facebook"></i></a></li>
           </ul>
		  
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-->
    </nav>
	<?php echo $notifikasi; ?>
    <div class="wrapper">

        <div class="main">
            <div class="section section-white section-search">
                <div class="container">
                <?php echo $tampil;?>
				
				</div>
            </div>
        </div>

    </div>
    <footer class="footer-demo section-white-gray">
        <div class="container">
            <nav class="pull-left">
                <ul>
                    <li>
                        <a href="anti.php" >
                            Home
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="copyright pull-right">
                &copy; DTS Jakarta
            </div>
        </div>
    </footer>


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