<?php 

/*
	-items pages
	-you can add /edit /delete member from here
*/
session_start();
$PageTitle="Exams page";
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
			<h1 class="text-center">View Courses</h1>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered manage-avatar">
						<tr>
							<td>course id</td>
                            <td>course name</td>
                            <td>Control</td>
						</tr>
<?php
							for($i=0;$i<$rowcount;$i++){
								echo "<tr>";
									echo "<td>".$courses[$i][0]."</td>";
                                    echo "<td>".$courses[$i][3]."</td>";
                                    echo "<td>
										<a href='questions.php?do=Manage&course_id=".$courses[$i][0]."' class='btn btn-success'>View Questions</a>";
									echo " </td>";
								echo "</tr>";
							}

?>
					</table>
				</div>
			</div>
<?php
		}else{
			Echo "<div class='container'>";
				Echo '<div class="nice-message">There\'s No courses To Show</div>';
			Echo"</div>";
		}
	}
	include $tpl."footer.php";

	}else{
		header("location:index.php");
		exit();
	}
?>