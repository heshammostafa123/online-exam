<?php 
    function getTitle(){
        global $pagetitle;
        if(isset($pagetitle)){
            echo $pagetitle;
        }else{
            echo "Default";
        }
    }
    function redirectHome($themsg,$url=null,$seconds=3){
		if ($url===null) {
			$url="index.php";
			$link="Home page";
		}else{
			//redirect to referer if it found or back to index.php if not found
			if(isset($_SERVER['HTTP_REFERER'])&&$_SERVER['HTTP_REFERER']!==''){
				$url=$_SERVER['HTTP_REFERER'];
				$link="Previous page";
			}else{
				$url='index.php';
				$link="Home page";
			}
		}
		echo $themsg;
		echo "<div class='alert alert-info'>You Will Be Redirected To $link After $seconds seconds.</div>";
		header("refresh:$seconds;url=$url");
		exit();
	
	}

?>