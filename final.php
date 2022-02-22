<?php
    session_start();

    $pagetitle="Final Page";

    include "in.php";

?>
    <main>
        <div class="contianer">
            <h2>You're Done!</h2>
            <p>Congrats! you have complate the test</p>
            <p>Final Score: <?php echo $_SESSION['score'];?></p>
            <a href="logout.php" class="start">End Quiz</a>
        </div>
    </main>

<?php
	include $tpl."footer.php";
	ob_end_flush();

?>