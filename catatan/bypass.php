<?php
session_start();

$_SESSION['FBID'] = '1475592029162362';
$_SESSION['FULLNAME'] = 'Yusriati Yusuf';
$_SESSION['EMAIL'] =  'Nov';
$_SESSION['GENDER'] = 'female';

// var_dump($_SESSION);exit();
// $_SESSION['FBID'] = '1868723123457358';
// $_SESSION['FULLNAME'] = 'Yandi';
// $_SESSION['EMAIL'] =  'Nov';
// $_SESSION['GENDER'] = 'male';
header("Location:anti.php");
?>
