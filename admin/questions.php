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
		if(isset($_GET["course_id"])&&is_numeric($_GET["course_id"])){//check if get request value is numeric and get the integer value
			$course_id=intval($_GET["course_id"]);
		}else{
			$course_id=0;
		}
		//select all exams
		$stmt=mysqli_query($conn,"call selectquestionsbycourseid($course_id);");
		$rowcount=mysqli_num_rows($stmt); 
		// Gets the Associative array 
		$questions = mysqli_fetch_all($stmt);
		$stmt->close();
        $conn->next_result();
		if (!empty($questions)) {
?>
			<h1 class="text-center">Manage exam</h1>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered manage-avatar">
						<tr>
							<td>Question number</td>
							<td>Question body</td>
							<td>Question answer1</td>
                            <td>Question answer2</td>
                            <td>Question answer3</td>
							<td>True answer</td>
							<td>course id</td>
                            <td>Control</td>
						</tr>
<?php
							for($i=0;$i<$rowcount;$i++){
								echo "<tr>";
									echo "<td>".$questions[$i][0]."</td>";
									echo "<td>".$questions[$i][1]."</td>";
                                    echo "<td>".$questions[$i][2]."</td>";
                                    echo "<td>".$questions[$i][3]."</td>";
                                    echo "<td>".$questions[$i][4]."</td>";
                                    echo "<td>".$questions[$i][5]."</td>";
                                    echo "<td>".$questions[$i][6]."</td>";
                                    echo "<td>
										<a href='questions.php?do=Edit&question_id=".$questions[$i][0]."&courseid=".$course_id."' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
										<a href='questions.php?do=Delete&question_id=".$questions[$i][0]."&courseid=".$course_id."' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";
									echo " </td>";
								echo "</tr>";
							}

?>
					</table>
				</div>
				<?php
				Echo"<a href='questions.php?do=Add&courseid=".$course_id."' class='btn btn-sm btn-primary'><i class='fa fa-plus'></i>";
					Echo "New question";
				Echo"</a>";
				?>			
			</div>
<?php
		}else{
			Echo "<div class='container'>";
				Echo '<div class="nice-message">There\'s No questions To Show</div>';
				Echo"<a href='questions.php?do=Add&courseid=".$course_id."' class='btn btn-sm btn-primary'><i class='fa fa-plus'></i>";
					Echo "New question";
				Echo"</a>";
			Echo"</div>";
		}

	}elseif ($do=='Add') {
		if(isset($_GET["courseid"])&&is_numeric($_GET["courseid"])){//check if get request value is numeric and get the integer value
			$courseid=intval($_GET["courseid"]);
		}else{
			$courseid=0;
		}
?>
		<h1 class="text-center">Add New question</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=Insert" method="POST">
					<input type="hidden" name="c_id" value="<?php Echo $courseid?>">
                    <!--start question number field-->
						<div class="form-group form-group-lg">
							<label class="col-md-2 control-label">Question number</label>
							<div class="col-md-10">
								<input type="number" name="q_n"  class="form-control" autocomplete="off" required="required" placeholder="question number">
							</div>
						</div>
                    <!--end question number field-->
					<!--start question body field-->
					<div class="form-group form-group-lg">
							<label class="col-md-2 control-label">Question body</label>
							<div class="col-md-10">
								<input type="text" name="q_body" class="form-control" autocomplete="off" required="required" placeholder="question body">
							</div>
						</div>
                    <!--end question body field-->
                    <!--start question answer1 field-->
						<div class="form-group form-group-lg">
							<label class="col-md-2 control-label">Question answer1</label>
							<div class="col-md-10">
								<input type="text" name="q_a1" class="form-control" autocomplete="off" required="required" placeholder="question answer1" >
							</div>
						</div>
					<!--end question answer1 field-->
					<!--start question answer2 field-->
					 <div class="form-group form-group-lg">
							<label class="col-md-2 control-label">Question answer2</label>
							<div class="col-md-10">
								<input type="text" name="q_a2" class="form-control" autocomplete="off" required="required" placeholder="question answer2">
							</div>
						</div>
					<!--end question answer2 field-->
					<!--start question answer3 field-->
					<div class="form-group form-group-lg">
							<label class="col-md-2 control-label">Question answer3</label>
							<div class="col-md-10">
								<input type="text" name="q_a3" class="form-control" autocomplete="off" required="required" placeholder="question answer3">
							</div>
					</div>
					<!--end question answer3 field-->
					<!--start question true answer field-->
					<div class="form-group form-group-lg">
							<label class="col-md-2 control-label">true answer</label>
							<div class="col-md-10">
								<input type="text" name="t_answer" class="form-control" autocomplete="off" required="required" placeholder="question true answer">
							</div>
					</div>
                    <!--end question true answer field-->
					<!--start button field-->
						<div class="form-group">
							<div class="col-md-offset-2 col-md-10">
								<input type="submit" value="Add question" class="btn btn-primary btn-sm">
							</div>
						</div>
					<!--end button field-->
				</form>
			</div>

<?php   
	
	}elseif ($do=='Insert') {
		//insert new Item in database
		if($_SERVER["REQUEST_METHOD"]=="POST"){
			echo "<h1 class='text-center'>Insert question</h1>";
 			echo "<div class='container'>";

            //get variables from form
			$question_num=$_POST["q_n"];
            $question_body     =$_POST["q_body"];
			$question_answer1  =$_POST["q_a1"];
			$question_answer2  =$_POST["q_a2"]; 
            $question_answer3  =$_POST["q_a3"]; 
			$question_trueanswer  =$_POST["t_answer"];
			$course_number  =$_POST["c_id"];
            $formerrors = array();
            if(empty($question_body)){
				$formerrors[]="quesetion body can\'t be <strong>Empty</strong>";
			}
			if(empty($question_answer1)){
				$formerrors[]="quesetion answer1 can\'t be <strong>Empty</strong>";
			}
			if(empty($question_answer2)){
				$formerrors[]="quesetion answer2  can\'t be <strong>Empty</strong>";
			}
			if(empty($question_trueanswer)){
				$formerrors[]="quesetion_true answer can\'t be <strong>Empty</strong>";
			}
			if(empty($question_answer3)){
				$formerrors[]="quesetion answer3  can\'t be <strong>Empty</strong>";
			}
			if(empty($course_number)){
				$formerrors[]="course number can\'t be <strong>Empty</strong>";
			}
			//loop into errors array and echo it
			foreach ($formerrors as $error) {
				echo "<div class='alert alert-danger'>". $error."</div>" ;
			}

			//check if there is no error proceed the update opertion
			if (empty($formerrors)) {
				//insert the new question info in database
				$stmt=mysqli_query($conn,"call insertquestion($question_num,'$question_body','$question_answer1','$question_answer2','$question_answer3','$question_trueanswer',$course_number);");
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
		if(isset($_GET["question_id"])&&is_numeric($_GET["question_id"])){//check if get request value is numeric and get the integer value
			$question_id=intval($_GET["question_id"]);
		}else{
			$question_id=0;
		}
		if(isset($_GET["courseid"])&&is_numeric($_GET["courseid"])){//check if get request value is numeric and get the integer value
			$courseid=intval($_GET["courseid"]);
		}else{
			$courseid=0;
		}
		//select all data depend on question id
		$stmt=mysqli_query($conn,"call selectquestiondependonqidcid($question_id,$courseid);");
		$rowcount=mysqli_num_rows($stmt); 
		$question=mysqli_fetch_row($stmt);
		$stmt->close();
        $conn->next_result();
		if ($rowcount>0) { 
?>
			<h1 class="text-center">Edit question</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=Update" method="POST">
					<input type="hidden" name="questionid" value="<?php Echo $question_id?>">
					<input type="hidden" name="c_id" value="<?php Echo $courseid?>">
					<!--start qestion body field-->
					<div class="form-group form-group-lg">
						<label class="col-md-2 control-label">question body</label>
						<div class="col-md-10">
							<input type="text" name="q_body" class="form-control" autocomplete="off" required="required" placeholder="question body" value="<?php Echo $question[1]?>">						
						</div>
					</div>
					<!--end question body field-->
					<!--start question answer1 field-->
					<div class="form-group form-group-lg">
						<label class="col-md-2 control-label">question answer1</label>
						<div class="col-md-10">
							<input type="text" name="q_a1" class="form-control" autocomplete="off" required="required" placeholder="question answer1" value="<?php Echo $question[2]?>">
						</div>
					</div>
					<!--end question answer1 field-->
					<!--start question answer2 field-->
					<div class="form-group form-group-lg">
						<label class="col-md-2 control-label">question answer2</label>
						<div class="col-md-10">
							<input type="text" name="q_a2" class="form-control" autocomplete="off" required="required" placeholder="question answer2" value="<?php Echo $question[3]?>">
						</div>
					</div>
					<!--end question answer2 field-->
					<!--start question answer3 field-->
					<div class="form-group form-group-lg">
						<label class="col-md-2 control-label">question answer3</label>
						<div class="col-md-10">
							<input type="text" name="q_a3" class="form-control" autocomplete="off" required="required" placeholder="question answer3" value="<?php Echo $question[4]?>">
						</div>
					</div>
                    <!--end question answer3 field-->
                    <!--start true answer field-->
					<div class="form-group form-group-lg">
						<label class="col-md-2 control-label">true answer</label>
						<div class="col-md-10">
							<input type="text" name="true_answer" class="form-control" autocomplete="off" required="required" placeholder="True Answer" value="<?php Echo $question[5]?>">
						</div>
					</div>
					<!--end true answer field-->
					<!--start button field-->
						<div class="form-group">
							<div class="col-md-offset-2 col-md-10">
								<input type="submit" value="save question" class="btn btn-primary btn-lg">
							</div>
						</div>
					<!--end button field-->
                </form>
<?php
}
    }elseif ($do=='Update') {
		//Update page
		if($_SERVER["REQUEST_METHOD"]=="POST"){
			echo "<h1 class='text-center'>Update question</h1>";
             echo "<div class='container'>";
             
			 //get variables from form
			$question_num=$_POST["questionid"];
            $question_body =$_POST["q_body"];
            $question_n1=$_POST["q_a1"];
			$question_n2  =$_POST["q_a2"];
			$question_n3 =$_POST["q_a3"];
			$question_t  =$_POST["true_answer"];
            $course_number =$_POST["c_id"]; 
			
			//validate the form in the server side
			$formerrors = array();
            if(empty($question_body)){
				$formerrors[]="quesetion body can\'t be <strong>Empty</strong>";
			}
			if(empty($question_n1)){
				$formerrors[]="quesetion answer1 can\'t be <strong>Empty</strong>";
			}
			if(empty($question_n2)){
				$formerrors[]="quesetion answer2  can\'t be <strong>Empty</strong>";
			}
			if(empty($question_t)){
				$formerrors[]="quesetion_true answer can\'t be <strong>Empty</strong>";
			}
			if(empty($question_n3)){
				$formerrors[]="quesetion answer3  can\'t be <strong>Empty</strong>";
			}
			if(empty($course_number)){
				$formerrors[]="course number can\'t be <strong>Empty</strong>";
			}
			
			//loop into errors array and echo it
			foreach ($formerrors as $error) {
				echo "<div class='alert alert-danger'>". $error."</div>" ;
			}
			//check if there is no error proceed the update opertion
			if (empty($formerrors)) {
				//Update the database with this info
				$res=mysqli_query($conn,"call questionupdate($question_num,'$question_body','$question_n1','$question_n2','$question_n3','$question_t',$course_number);");
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
		echo "<h1 class='text-center'>Delete question</h1>";
		echo "<div class='container'>";
			//check if get request value is numeric and get the integer value
			if(isset($_GET["question_id"]) && is_numeric($_GET['question_id'])){
				$question_id= intval($_GET['question_id']);
			}else{
				$question_id= 0;
			}
			if(isset($_GET["courseid"]) && is_numeric($_GET['courseid'])){
				$courseid= intval($_GET['courseid']);
			}else{
				$courseid= 0;
			}
			//select all data depend on question id
			$stmt=mysqli_query($conn,"call selectquestiondependonqidcid($question_id,$courseid);");
			$rowcount=mysqli_num_rows($stmt); 
			$question=mysqli_fetch_row($stmt);
			$stmt->close();
			$conn->next_result();
    		if($rowcount>0) //to check course id exit or not if exit show form else show message error
    		{
				$stmt=mysqli_query($conn,"call deletequestiondependonidcid($question_id,$courseid);");
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