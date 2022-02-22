<?php
    session_start();

    $pagetitle="process";
if(isset($_SESSION["user_student"])){
    include "in.php";

    if(!isset($_SESSION['score'])){
        $_SESSION['score']=0;
    }

    if($_SERVER["REQUEST_METHOD"]=='POST'){
        $q_number=$_POST['number'];
        $choice=$_POST['choice'];
        $course_number=$_POST['course_number'];
        $next=$q_number+1;
   
        //get total number of question with function   not work
        // $sql="SELECT totalnumberofquestions('$course_number') AS X;";
        // $total=mysqli_query($conn,$sql);

        //get total number of question with procedure 
        $res=mysqli_query($conn,"call numberofquestions($course_number);");
        $total=mysqli_num_rows($res);
        $res->close();
        $conn->next_result();
    


        // //get correct answer
        $stmt=mysqli_query($conn,"call get_correct_answer($q_number,$course_number);");
        $question=mysqli_fetch_row($stmt);
        $stmt->close();
        $conn->next_result();
        if($question[5]===$_POST['choice']){
            //Answer is correct
            $_SESSION['score']= $_SESSION['score']+1;
        }
        //check if last question or not
        if ($q_number == $total) {
            //insert_score
            $std_id=$_SESSION["student_id"];
            $std_score= $_SESSION['score'];
            //insert in score table not work
            $stmt=mysqli_query($conn,"call insert_score($course_number,$std_id,$std_score);");
            $res->close();
            $conn->next_result();
            //Update the database with this info
            $res=mysqli_query($conn,"call updatestatus($std_id,$course_number);");
            $conn->next_result();
            header("location:final.php");
        } else {
            header("location:questions.php?course=".$course_number."&q_n=".$next);
        }
    }
}else{
    header("location:login.php");
    exit();
}
?>