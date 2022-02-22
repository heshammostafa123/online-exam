<?php
	ob_start();
	$PageTitle="Admin Login";
	$login="";
	session_start();
	if(isset($_SESSION["admin_username"])){
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
			// $sql="SELECT checklecturerexisting('$username','$hashedpass');";
			// $count=mysqli_query($conn,$sql);
			// $row=mysqli_fetch_row($count);
			$stmt=mysqli_query($conn,"call checklecturerexisting('$username','$hashedpass');");
			$row=mysqli_fetch_row($stmt);
			$count=mysqli_num_rows($stmt);
			$stmt->close();
        	$conn->next_result();
	    	//if couunt >0 this mean database contain record about this username
	    	if($count>0){
	    		$_SESSION["admin_username"]=$username;//Register session name
	    		$_SESSION["admin_id"]=$row[0];//Register session id to used in advertisement of the user
	    		header("location:index.php");
	    		exit();
	    	}
   		}
	}
?>
<!--start login form-->
	<form class="login" action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
		<h4 class="text-center">Admin Login</h4>
		<input class="form-control" type="text" name="username" placeholder="Username" autocomplete="off" placeholder="UserName" required>
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