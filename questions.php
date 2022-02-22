<?php
    session_start();

    $pagetitle="questions";
if(isset($_SESSION["user_student"])){
	include "in.php";

    $course_number=$_GET['course'];
    $question_number=$_GET['q_n'];
    
    //get questions
    $stmt=mysqli_query($conn,"call getquestions($course_number,$question_number);");
    $question=mysqli_fetch_row($stmt); 
    $conn->next_result();
    $stmt->close();

    //get total number of question with procedur
    $res=mysqli_query($conn,"call numberofquestions($course_number);");
    $total=mysqli_num_rows($res);
    
?>
<main>
    <div class="contianer">
        <div class="current">Question <?php echo $question[0];?> Of <?php echo $total;?></div>
        <h3 class="question">
            <?php echo $question[1]; ?>
        </h3>
        <form action="process.php" method="post">
            <ul class="choices">
                <li><input type="radio" name="choice" value="<?php echo $question[2]?>" /><?php echo $question[2]?></li>
                <li><input type="radio" name="choice" value="<?php echo $question[3]?>" /><?php echo $question[3]?></li>
                <li><input type="radio" name="choice" value="<?php echo $question[4]?>" /><?php echo $question[4]?></li>
            </ul>
            <input type="submit" name="" value="Submit"/>
            <input type="hidden" name="number" value="<?php echo $question_number?>" />
            <input type="hidden" name="course_number" value="<?php echo $course_number?>" />

        </form>
    </div>
</main>
<?php
	include $tpl."footer.php";
	ob_end_flush();
}else{
    header("location:login.php");
    exit();
}
?>