<?php 

/*
	-items pages
	-you can add /edit /delete member from here
*/
session_start();
$PageTitle="Home Page";
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
		$stmt=mysqli_query($conn,"call selectallstudentswithjoin();");
		$rowcount=mysqli_num_rows($stmt); 
		// Gets the Associative array 
		$scores = mysqli_fetch_all($stmt);
		$stmt->close();
        $conn->next_result();
		if (!empty($scores)) {
?>
			<h1 class="text-center">students scores</h1>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered manage-avatar">
						<tr>
							<td>Student Id</td>
							<td>Student Username</td>
							<td>Student course</td>
                            <td>Student score</td>
						</tr>
<?php
							for($i=0;$i<$rowcount;$i++){
								echo "<tr>";
									echo "<td>".$scores[$i][1]."</td>";
									echo "<td>".$scores[$i][2]."</td>";
                                    echo "<td>".$scores[$i][3]."</td>";
                                    echo "<td>".$scores[$i][0]."</td>";
								echo "</tr>";
							}
?>
					</table>
				</div>
			</div>
<?php
		}else{
			Echo "<div class='container'>";
				Echo '<div class="nice-message">There\'s No Scores To Show</div>';
			Echo"</div>";
		}

	}
	include $tpl."footer.php";

	}else{
		header("location:login.php");
		exit();
	}
?>