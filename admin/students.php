<?php 

/*
	-items pages
	-you can add /edit /delete member from here
*/
session_start();
$PageTitle="Students Page";
if(isset($_SESSION['admin_username'])){
	include "in.php";

	$do="";
	if(isset($_GET['do'])){
			$do=$_GET['do'];
	}else{
			$do='Manage';
	}
	//start manage page
	if($do=="Manage"){
		//select all students
		$stmt=mysqli_query($conn,"call selectallstudents();");
		$rowcount=mysqli_num_rows($stmt); 
		// Gets the Associative array 
		$students = mysqli_fetch_all($stmt);
		$stmt->close();
        $conn->next_result();
		if (!empty($students)) {
?>
			<h1 class="text-center">Manage students</h1>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered manage-avatar">
						<tr>
							<td>#ID</td>
							<td>Username</td>
							<td>Password</td>
                            <td>Control</td>
						</tr>
<?php
							for($i=0;$i<$rowcount;$i++){
								echo "<tr>";
									echo "<td>".$students[$i][0]."</td>";
									echo "<td>".$students[$i][1]."</td>";
                                    echo "<td>".$students[$i][2]."</td>";
                                    echo "<td>
										<a href='students.php?do=Edit&student_id=".$students[$i][0]."' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
										<a href='students.php?do=Delete&student_id=".$students[$i][0]."' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";
									echo " </td>";
								echo "</tr>";
							}

?>
					</table>
				</div>
				<a href='students.php?do=Add' class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>New student</a>
			</div>
<?php
		}else{
			Echo "<div class='container'>";
				Echo '<div class="nice-message">There\'s No students To Show</div>';
				Echo"<a href='students.php?do=Add' class='btn btn-sm btn-primary'><i class='fa fa-plus'></i>";
					Echo "New Student";
				Echo"</a>";
			Echo"</div>";
		}

	}elseif ($do=='Add') {
?>
		<h1 class="text-center">Add New Student</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=Insert" method="POST">
					<!--start name field-->
						<div class="form-group form-group-lg">
							<label class="col-md-2 control-label">User Name</label>
							<div class="col-md-10">
								<input type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="Name Of Student">
							</div>
						</div>
					<!--end name field-->
					<!--start password field-->
						<div class="form-group form-group-lg">
							<label class="col-md-2 control-label">Password</label>
							<div class="col-md-10">
								<input type="password" name="password" class="form-control" autocomplete="off" required="required" placeholder="Password Of Student">
							</div>
						</div>
					<!--end password field-->
					<!--start button field-->
						<div class="form-group">
							<div class="col-md-offset-2 col-md-10">
								<input type="submit" value="Add Student" class="btn btn-primary btn-sm">
							</div>
						</div>
					<!--end button field-->
				</form>
			</div>

<?php   
	
	}elseif ($do=='Insert') {
		//insert new Item in database
		if($_SERVER["REQUEST_METHOD"]=="POST"){
			echo "<h1 class='text-center'>Insert Student</h1>";
 			echo "<div class='container'>";

			//get variables from form
			$name  =$_POST["name"];
            $password =$_POST["password"]; 
            //to hash the pass
			$hashpass=sha1($_POST["password"]);

			$formerrors = array();
			if(empty($name)){
				$formerrors[]="Name can\'t be <strong>Empty</strong>";
			}
			if(empty($password)){
				$formerrors[]="password  can\'t be <strong>Empty</strong>";
			}
			//loop into errors array and echo it
			foreach ($formerrors as $error) {
				echo "<div class='alert alert-danger'>". $error."</div>" ;
			}

			//check if there is no error proceed the update opertion
			if (empty($formerrors)) {
				//insert the new student info in database
				$res=mysqli_query($conn,"call insertstudent('$name','$hashpass');");
				$conn->next_result();
				//Echo success message
				$themsg= "<div class='alert alert-success'>Record Insert</div>" ;
				redirectHome($themsg,"back");
				
			}
			
		}
		else{
			echo "<div class='container'>";
			$themsg= "<div class='alert alert-danger'>sorry you cant Browse this page directly</div>";
			redirectHome($themsg);
			echo "</div>";
		}

		echo '</div>';
	}elseif ($do=='Edit') {
		//Edit Page
		if(isset($_GET["student_id"])&&is_numeric($_GET["student_id"])){//check if get request value is numeric and get the integer value
			$student_id=intval($_GET["student_id"]);
		}else{
			$student_id=0;
		}
		//select all data depend on item id
		$stmt=mysqli_query($conn,"call selectstudentwithid($student_id);");
		$count=mysqli_num_rows($stmt); 
		$student=mysqli_fetch_row($stmt); 
		$stmt->close();
		$conn->next_result();
		if ($count>0) { 
?>

			<h1 class="text-center">Edit student</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=Update" method="POST">
					<input type="hidden" name="studentid" value="<?php Echo $student[0]?>">
					<!--start username field-->
					<div class="form-group form-group-lg">
						<label class="col-md-2 control-label">Username</label>
						<div class="col-md-10">
							<input type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="Name Of student" value="<?php Echo $student[1]?>">						
						</div>
					</div>
					<!--end username field-->
					<!--start password field-->
					<div class="form-group form-group-lg">
						<label class="col-md-2 control-label">Password</label>
						<div class="col-md-10">
							<input type="password" name="password" class="form-control" autocomplete="off" required="required" placeholder="password Of User" value="<?php Echo  $student[2]?>">
						</div>
					</div>
					<!--end password field-->
					<!--start button field-->
						<div class="form-group">
							<div class="col-md-offset-2 col-md-10">
								<input type="submit" value="Update data" class="btn btn-primary btn-lg">
							</div>
						</div>
					<!--end button field-->
                </form>
<?php
}
    }elseif ($do=='Update') {
		//Update page
		if($_SERVER["REQUEST_METHOD"]=="POST"){
			echo "<h1 class='text-center'>Update student</h1>";
 			echo "<div class='container'>";
			//get variables from form
			$studentid    		=$_POST["studentid"];
			$name 	    =$_POST["name"];
            $password 		=$_POST["password"];
            //to hash the pass
			$hashpass=sha1($_POST["password"]);

			//validate the form in the server side
			$formerrors = array();
			if(empty($name)){
				$formerrors[]="Name can\'t be <strong>Empty</strong>";
			}
			if(empty($password)){
				$formerrors[]="password  can\'t be <strong>Empty</strong>";
			}
			
			//loop into errors array and echo it
			foreach ($formerrors as $error) {
				echo "<div class='alert alert-danger'>". $error."</div>" ;
			}
			//check if there is no error proceed the update opertion
			if (empty($formerrors)) {
				//Update the database with this info

					$res=mysqli_query($conn,"call studentupdate('$name','$hashpass',$studentid);");
					$conn->next_result();
					echo "<div class='container'>";
					$themsg= "<div class='alert alert-success'>Record Updated</div>" ;
					echo "</div>";
					redirectHome($themsg,"back");
			}
		}
		else{
			echo "<div class='container'>";
				$themsg= "<div class='alert alert-danger'>sorry you cant Browse this page directly</div>";
			echo "</div>";
			redirectHome($themsg);
		}

		echo '</div>';
	}elseif ($do=='Delete') {
		//delete student from database
		echo "<h1 class='text-center'>Delete Student</h1>";
		echo "<div class='container'>";
			//check if get request value is numeric and get the integer value
			if(isset($_GET["student_id"]) && is_numeric($_GET['student_id'])){
				$studentid= intval($_GET['student_id']);
			}else{
				$studentid= 0;
			}
				$stmt=mysqli_query($conn,"call deleteonestudent($studentid);");
				$conn->next_result();
    			$themsg= "<div class='alert alert-success'>Record Deleted</div>" ;
    			redirectHome($themsg,'back');
    		
		echo "</div>";
	}
	include $tpl."footer.php";

	}else{
		header("location:index.php");
		exit();
	}
?>