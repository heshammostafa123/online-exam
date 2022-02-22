<?php 

/*
	-items pages
	-you can add /edit /delete member from here
*/
session_start();
$PageTitle="Courses Page";
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
		//select all Courses
		$stmt=mysqli_query($conn,"call selectallcourses();");
		$rowcount=mysqli_num_rows($stmt); 
		// Gets the Associative array 
		$courses = mysqli_fetch_all($stmt);
		$stmt->close();
        $conn->next_result();
		if (!empty($courses)) {
?>
			<h1 class="text-center">Manage courses</h1>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered manage-avatar">
						<tr>
							<td>courser id</td>
							<td>Douctor id</td>
							<td>Student id</td>
                            <td>course name</td>
                            <td>Control</td>
						</tr>
<?php
							for($i=0;$i<$rowcount;$i++){
								echo "<tr>";
									echo "<td>".$courses[$i][0]."</td>";
									echo "<td>".$courses[$i][1]."</td>";
                                    echo "<td>".$courses[$i][2]."</td>";
                                    echo "<td>".$courses[$i][3]."</td>";
                                    echo "<td>
										<a href='courses.php?do=Edit&course_id=".$courses[$i][0]."' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
										<a href='courses.php?do=Delete&course_id=".$courses[$i][0]."' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";
									echo " </td>";
								echo "</tr>";
							}

?>
					</table>
				</div>
				<a href='courses.php?do=Add' class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>New course</a>
			</div>
<?php
		}else{
			Echo "<div class='container'>";
				Echo '<div class="nice-message">There\'s No courses To Show</div>';
				Echo"<a href='courses.php?do=Add' class='btn btn-sm btn-primary'><i class='fa fa-plus'></i>";
					Echo "New course";
				Echo"</a>";
			Echo"</div>";
		}

	}elseif ($do=='Add') {
?>
		<h1 class="text-center">Add New course</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=Insert" method="POST">
					<!--start student id field-->
					<div class="form-group form-group-lg">
							<label class="col-md-2 control-label">student name</label>
							<div class="col-md-10">
								<select name="s_id">
									<option value="0">....</option>
									<?php
										//select all student
										$stmt=mysqli_query($conn,"call selectallstudents();");
										$rowcount=mysqli_num_rows($stmt); 
										// Gets the Associative array 
										$students = mysqli_fetch_all($stmt);
										$stmt->close();
										$conn->next_result();
										for($i=0;$i<$rowcount;$i++){
											Echo "<option value='".$students[$i][0]."'>".$students[$i][1]."</option>";
										}
									?>
								</select>
							</div>
						</div>
					<!--end student id field-->
                    <!--start course name field-->
						<div class="form-group form-group-lg">
							<label class="col-md-2 control-label">course Name</label>
							<div class="col-md-10">
								<input type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="Name Of course">
							</div>
						</div>
                    <!--end course name field-->
					<!--start button field-->
						<div class="form-group">
							<div class="col-md-offset-2 col-md-10">
								<input type="submit" value="Add course" class="btn btn-primary btn-sm">
							</div>
						</div>
					<!--end button field-->
				</form>
			</div>

<?php   
	
	}elseif ($do=='Insert') {
		//insert new Item in database
		if($_SERVER["REQUEST_METHOD"]=="POST"){
			echo "<h1 class='text-center'>Insert course</h1>";
 			echo "<div class='container'>";

            //get variables from form
            $doctor_id=$_SESSION["admin_id"];
			$student_id  =$_POST["s_id"];
            $course_name =$_POST["name"]; 

            $formerrors = array();
            if(empty($doctor_id)){
				$formerrors[]="doctor id  can\'t be <strong>Empty</strong>";
			}
			if(empty($student_id)){
				$formerrors[]="student id can\'t be <strong>Empty</strong>";
			}
			if(empty($course_name)){
				$formerrors[]="course name  can\'t be <strong>Empty</strong>";
			}
			//loop into errors array and echo it
			foreach ($formerrors as $error) {
				echo "<div class='alert alert-danger'>". $error."</div>" ;
			}

			//check if there is no error proceed the update opertion
			if (empty($formerrors)) {
				//insert the new member info in database
				$res=mysqli_query($conn,"call insertcourse($doctor_id,$student_id,'$course_name');");
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
		if(isset($_GET["course_id"])&&is_numeric($_GET["course_id"])){//check if get request value is numeric and get the integer value
			$course_id=intval($_GET["course_id"]);
		}else{
			$course_id=0;
		}
		//select all data depend on course  id
		$stmt=mysqli_query($conn,"call selectacoursewithid($course_id);");
		$rowcount=mysqli_num_rows($stmt);
		$course=mysqli_fetch_row($stmt); 
		$stmt->close();
        $conn->next_result();
		if ($rowcount>0) { 
?>

			<h1 class="text-center">Edit course</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=Update" method="POST">
					<input type="hidden" name="courseid" value="<?php Echo $course[0]?>">
					<!--start doctor id field-->
					<div class="form-group form-group-lg">
						<label class="col-md-2 control-label">Doctor id</label>
						<div class="col-md-10">
							<input type="text" name="d_id" class="form-control" autocomplete="off" required="required" placeholder="Doctor id" value="<?php Echo $course[1]?>">						
						</div>
					</div>
					<!--end doctor id field-->
					<!--start student id field-->
					<div class="form-group form-group-lg">
						<label class="col-md-2 control-label">Student id</label>
						<div class="col-md-10">
							<input type="text" name="s_id" class="form-control" autocomplete="off" required="required" placeholder="Student id" value="<?php Echo $course[2]?>">
						</div>
					</div>
                    <!--end password field-->
                    <!--start course name field-->
					<div class="form-group form-group-lg">
						<label class="col-md-2 control-label">course name</label>
						<div class="col-md-10">
							<input type="text" name="course_name" class="form-control" autocomplete="off" required="required" placeholder="Course name" value="<?php Echo $course[3]?>">
						</div>
					</div>
					<!--end course name field-->
					<!--start button field-->
						<div class="form-group">
							<div class="col-md-offset-2 col-md-10">
								<input type="submit" value="save course" class="btn btn-primary btn-lg">
							</div>
						</div>
					<!--end button field-->
                </form>
<?php
}
    }elseif ($do=='Update') {
		//Update page
		if($_SERVER["REQUEST_METHOD"]=="POST"){
			echo "<h1 class='text-center'>Update Course</h1>";
             echo "<div class='container'>";
             
             //get variables from form
            $course_id =$_POST["courseid"];
            $doctor_id=$_POST["d_id"];
			$student_id  =$_POST["s_id"];
            $course_name =$_POST["course_name"]; 
			

			//validate the form in the server side
			$formerrors = array();
            if(empty($doctor_id)){
				$formerrors[]="doctor id  can\'t be <strong>Empty</strong>";
			}
			if(empty($student_id)){
				$formerrors[]="student id can\'t be <strong>Empty</strong>";
			}
			if(empty($course_name)){
				$formerrors[]="course name  can\'t be <strong>Empty</strong>";
			}
			
			//loop into errors array and echo it
			foreach ($formerrors as $error) {
				echo "<div class='alert alert-danger'>". $error."</div>" ;
			}
			//check if there is no error proceed the update opertion
			if (empty($formerrors)) {
				//Update the database with this info
				$res=mysqli_query($conn,"call courseupdate($doctor_id,$student_id,'$course_name',$course_id);");
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
		//delete course from database
		echo "<h1 class='text-center'>Delete course</h1>";
		echo "<div class='container'>";
			//check if get request value is numeric and get the integer value
			if(isset($_GET["course_id"]) && is_numeric($_GET['course_id'])){
				$course_id= intval($_GET['course_id']);
			}else{
				$course_id= 0;
			}
			//select all data depend on course  id
			$stmt=mysqli_query($conn,"call selectacoursewithid($course_id);");
			$rowcount=mysqli_num_rows($stmt); 
			$stmt->close();
			$conn->next_result();
    		if($rowcount>0) //to check course id exit or not if exit show form else show message error
    		{
				$stmt=mysqli_query($conn,"call deleteonecourse($course_id);");
				$conn->next_result();
    			$themsg= "<div class='alert alert-success'>Record Deleted</div>" ;
    			redirectHome($themsg,'back');
    		}else{
    			$themsg= "<div class='alert alert-danger'>This Id Is Not Exit</div>";
    			redirectHome($themsg);
    		}
		echo "</div>";
	}
	include $tpl."footer.php";

}else{
		header("location:index.php");
		exit();
	}
?>