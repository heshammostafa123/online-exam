
<?php 
	session_start(); //start session
?>
	<p>Final Score: <?php echo $_SESSION['score'];?></p>
<?php
	session_unset(); //unset the data

	session_destroy(); //destory the session

	header("location:login.php");

	exit();
?>