<?php
session_start();
include "../conf.php";
include "fungsi.php"; $notif_cl = '';

$fbid = $_SESSION['FBID'];
$nama_lengkap = $_SESSION['FULLNAME'];
$batas = 10;
$judul ='SuksesFamily';
$pencairan='';

if(isset($_GET['h'])){
	$halaman = $_GET['h'];
}else{
	$halaman = 0;
}
$usr = cek($con,$db,$fbid);
// var_dump($_GET);exit();

$t_cair ='';
if($usr != 'no'){
	if(isset($_GET['t'])){
		$hala = $_GET['t'];
		if($hala == 'dp'){
			$dts = pembayaran($con,$db,$usr,$th1,$th2,$k_2th,$k_1th,$k_6bln);
			$data_pgg = $dts['tabel'];
			$cair = pencairan($con,$usr,$fbid);
			$pencairan = $cair['tabel_riwayat'];
			$judul = rp($dts['komisi']);
			if(date("d") == '13' OR date("d") == "14"){
				if($cair['norek'] == 'no'){
					if($dts['komisi'] >= 100000){
						$t_cair ='<a href="inisiasi.php" class="btn btn-danger btn-sm">Pencairan</a><small>tombol ini hanya muncul setiap tanggal 13 dan 14 </small>';
					}
				}
			}else{
				$t_cair='';
			}
		}

		if($hala == 'mt'){
			$dts = calon_mitra($con,$db,$usr,$halaman,$batas);
			$data_pgg = $dts;
			$judul = "Calon Mitra";
		}
	}else{
		$judul = 'Daftar Tagihan';
		$data_pgg = tagihan($con,$db,$usr,$halaman,$batas,$th1,$th2);
	}
}else{
	$judul ='';
	$data_pgg ='';
	header("Location: ganti_fb.php");
}

//jika ada yg claim mitra
if(isset($_POST['claim'])){


	//analisa formatnya
$mit = $_POST['claim'];
$frm = explode('.',$mit);
if(count($frm) == 3){
	if($frm[1] == 'sukses' and $frm[2]	== 'family'){
		//format benar
		$cl_user = $frm[0];
		$ada = mysqli_fetch_array(mysqli_query($con,"SELECT `tgl_lunas`,`referal` FROM `pengguna` WHERE `username`='$cl_user'"));
		if($ada){
			//ada

			if($ada['referal'] =='mandiri'){
			mysqli_query($con,"UPDATE `pengguna` SET `email` = NULL, `referal` = '$usr',`web_training`='tidak' WHERE `username` = '$cl_user'");

			$notif_cl = $notif_cl.'<div class="alert alert-success alert-with-icon" data-notify="container">
					<div class="container">
						<div class="alert-wrapper">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
							<i class="alert-icon fa fa-thumbs-up"></i>
							<div class="message"><b>Claim Berhasil! </b> Web Replika yang anda maksud sudah kami tambahkan ke /catatan ini refresh halaman ini dan cek di menu Home atau Komisi</div>
						</div>
					</div>
				</div>
				';
			}else{
				$notif_cl = $notif_cl.'<div class="alert alert-success alert-with-icon" data-notify="container">
					<div class="container">
						<div class="alert-wrapper">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
							<i class="alert-icon fa fa-lock"></i>
							<div class="message"><b>Claim Ditolak! </b> Web Replika yang anda maksud tidak mengalami gangguan sinyal/kendala teknis, replika tersebut mendaftar melalui replika lain (bukan replika anda). </div>
						</div>
					</div>
				</div>
				';
			}
		}else{
			//tdk ada
			$notif_cl = $notif_cl.'<div class="alert alert-info alert-with-icon" data-notify="container">
            <div class="container">
                <div class="alert-wrapper">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <i class="alert-icon fa fa-eye-slash"></i>
                    <div class="message"><b>Web Replika Tidak Terdaftar! </b> Mungkin anda salah ketik, silahkan ulangi lagi</div>
                </div>
            </div>
        </div>
		';
		}

	}else{
		//format salah
		$notif_cl = $notif_cl.'
		<div class="alert alert-warning alert-with-icon" data-notify="container">
            <div class="container">
                <div class="alert-wrapper">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <i class="alert-icon fa fa-bell"></i>
                    <div class="message"><b>Anda Salah Ketik! </b>ulangi sekali lagi, contoh : alamat web http://mitra.sukses.family maka masukan <b>mitra.sukses.family</b> dalam kotak "Claim Mitra" </div>
                </div>
            </div>
        </div>
		';
	}
}else{
	$notif_cl = $notif_cl.'
		<div class="alert alert-danger alert-with-icon" data-notify="container">
            <div class="container">
                <div class="alert-wrapper">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <i class="alert-icon fa fa-exclamation-circle"></i>
                    <div class="message"><b>Format Salah! </b>contoh : alamat web http://mitra.sukses.family maka masukan <b>mitra.sukses.family</b> dalam kotak "Claim Mitra" </div>
                </div>
            </div>
        </div>
		';
}
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="../assets/bootstrap3/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/bootstrap-tour/css/bootstrap-tour.min.css" rel="stylesheet">
  </head>

  <body>
    <br>
    <div class="container">
      <div class="row">

        <!-- satu -->
        <div class="col-md-4">
          <div class="panel panel-default" id="panel1">
            <div class="panel-heading">
              <h3 class="panel-heading">judul 1 </h3>
            </div>
            <div class="panel-body">
              content 1
            </div>
          </div>
        </div>
        <!-- satu -->

        <!-- dua -->
        <div class="col-md-4">
          <div class="panel panel-default" id="panel2">
            <div class="panel-heading">
              <h3 class="panel-heading">judul 2 </h3>
            </div>
            <div class="panel-body">
              content 2
            </div>
          </div>
        </div>
        <!-- dua -->

        <!-- tiga -->
        <div class="col-md-4">
          <div class="panel panel-default" id="panel3">
            <div class="panel-heading">
              <h3 class="panel-heading">judul 3 </h3>
            </div>
            <div class="panel-body">
              content 3
            </div>
          </div>
        </div>
        <!-- tiga -->

        <!-- empat -->
        <div class="col-md-4">
          <div class="panel panel-default" id="panel4">
            <div class="panel-heading">
              <h3 class="panel-heading">judul 4 </h3>
            </div>
            <div class="panel-body">
              content 4
            </div>
          </div>
        </div>
        <!-- empat -->

      </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../assets/bootstrap3/js/jquery.min.js"></script>
    <script src="../assets/bootstrap3/js/bootstrap.min.js"></script>
    <script src="../assets/bootstrap-tour/js/bootstrap-tour.min.js"></script>
    <script>
      // Instance the tour
      var tour = new Tour({
        // name:'sukses family',
        backdrop:true,
        steps: [{
          element: "#panel1",
          title: "new user",
          content: "pertama klik ini 1"
        },{
          element: "#panel2",
          title: "new user",
          content: "kemudia ini 2"
        },{
          element: "#panel3",
          title: "new user",
          content: "lanjut ini  3"
        },{
          element: "#panel4",
          title: "new user",
          content: "dan ini 4"
        }]
      });

      // Initialize the tour
      tour.init();

      // Start the tour
      tour.start();
    </script>
  </body>
</html>
