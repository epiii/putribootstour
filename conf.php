<?php //config file
date_default_timezone_set('Asia/Jakarta');
$host_p ="localhost";
$usernm_p ="root";
$pass_p ="9kali9=81ub";
$db ="sf_db019";
// $usernm_p ="pmauser";
// $pass_p ="28";
// isi nama host, username mysql, dan password mysql anda
$con = mysqli_connect($host_p, $usernm_p, $pass_p, $db);
// var_dump($con);
$bank_akun = "Bank Mandiri 1550004139237 a.n Iman Jaya";
$bank = array('mandiri' => "Bank Mandiri 1550004139237 a.n Iman Jaya", 'bca' => "Bank BCA 7641032020 a.n Iman Jaya");

//harga paket
$bln6 = 75000;
$th1 = 200000;
$th2 = 350000;
//komisi
$k_6bln =20000;
$k_1th =50000;
$k_2th=75000;

function rp($angka){
	$hsl = 'Rp '.number_format($angka,0);
	return $hsl;
}

function rp_url($angka){
	$hsl = 'Rp%20'.number_format($angka,0);
	return $hsl;
}

function ke_wa($no){
	$ptn = "/^0/";  // Regex
	$wa = preg_replace($ptn, "62", $no);
	return $wa;
}

function nm($nm){
	$hsl = ucwords($nm);
	return $hsl;
}

function kecil($str){
	$hsl = strtolower($str);
	return $hsl;
}
function bersihin($str){
$hsl = preg_replace('/[^A-Za-z0-9\-]/', ' ', $str);
return $hsl;
}
/*
if ($con->connect_error) {
  echo $con->connect_error;
} else {
  echo "Halloooo";
}
*/
?>
