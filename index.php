<?php
    session_start();

    $pagetitle="Home";
if(isset($_SESSION["user_student"])){
	include "in.php";

    $studentid=$_SESSION["student_id"];
    //getallcourses
    $stmt=mysqli_query($conn,"call studentcourses($studentid);");
    $rowcount=mysqli_num_rows($stmt); 
    // Gets the Associative array 
    $courses = mysqli_fetch_all($stmt); 
    if($rowcount>0){
?>
<main>
    <div class="contianer">
        <h2>Test Your Knowledge</h2>
        <p>This is a multiple choice quize to test your knowledge</p>
    </div>
    <div class="container">
    <ul class="choices">
        <?php for($i=0;$i<$rowcount;$i++){?>
            <li><input type="radio" name="course" value="<?php echo $courses[$i][0];?>" /><a href="questions.php?course=<?php echo $courses[$i][0] ?>&q_n=1" ><?php echo $courses[$i]['3']; ?></a></li>
        <?php }?>
    </ul>
</div>
</main>
<?php
    }else{
        Echo "<div class='contianer'>";
            Echo '<div class="nice-message">There\'s No Exams To Show</div>';
        Echo"</div>";
    }
	include $tpl."footer.php";
    ob_end_flush();
}else{
    header("location:login.php");
    exit();
}

?>