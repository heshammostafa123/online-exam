<?php 

	include "admin/connect.php";

	$sessionuser='';
	if(isset($_SESSION["student_username"]))
		$sessionuser=$_SESSION['student_username'];


	//rotes 
	$tpl='include/templates/'; //template directory
	$func="include/functions/";  //template directory
	$css="layout/css/";	//css directory
	$js="layout/js/";	//js directory
	

	include $func."functions.php";
	

	if(!isset($login)){
		include $tpl."header.php";
 	}else{
		include $tpl."login_header.php";
	}

 ?>