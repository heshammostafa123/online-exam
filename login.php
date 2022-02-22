<?php
	ob_start();
	$PageTitle="Login";
	//variable to not set navbar in login page
	$login="";
	session_start();
	if(isset($_SESSION["user_student"])){
		header("location: index.php");//redirect to index 
	}
	include 'in.php';
	if ($_SERVER["REQUEST_METHOD"]=='POST') {
		if(isset($_POST['login'])){
			$username=$_POST['username'];
			$password=$_POST['password'];
			
			//Encryption of password
	    	$hashedpass=sha1($password);
			//check if person is exit in database
			//  $sql="SELECT checkstudentexisting('$username','$hashedpass');";
			//  $count=mysqli_query($conn,$sql);
			//  $row=mysqli_fetch_row($count); 
			//  $count->close();
			//  $conn->next_result();
			$stmt=mysqli_query($conn,"call checkstudentexisting('$username','$hashedpass');");
			$row=mysqli_fetch_row($stmt);
			$count=mysqli_num_rows($stmt);

	    	if($count>0){
	    		$_SESSION["user_student"]=$username;//Register session name
	    		$_SESSION["student_id"]=$row[0];//Register session id to used in advertisement of the user
	    		header("location:index.php");
	    		exit();
	    	}
   		}
	}
?>
<!--start login form-->
	<form class="login" action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
		<h4 class="text-center">Student Login</h4>
		<input class="form-control" type="text" name="username" placeholder="Username" autocomplete="off" required>
        <i class="fa fa-user fa-fw"></i>
		<input class="form-control" type="password" name="password" placeholder="password" autocomplete="new-password">
        <i class="fa fa-lock fa-fw"></i>
		<input class="btn btn-primary btn-block" name="login" type="submit" value="login">
	</form>
<!--end login form-->


<?php
	include $tpl."footer.php";
	ob_end_flush();

?>