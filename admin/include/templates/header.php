<html>
    <header>
        <meta charset="utf-8">
        <title><?php echo getTitle();?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo $css; ?>bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $css; ?>css.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $css; ?>font-awesome.min.css">
    </header>
    <body>
<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Home</a>
    </div>
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav count">
        <li><a href="students.php">Student</a></li>
        <li><a href="courses.php">Courses</a></li>
        <li><a href="exams.php">Exams</a></li>
        <li><a href="scores.php">Score</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['admin_username'] ?><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>