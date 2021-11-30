<?php 
session_start();

// configuer database
$server = "localhost";
$user_db = "root";
$pass_db = "";
$db = "learn";

$message = "";
$conn = mysqli_connect($server, $user_db, $pass_db, $db);


if(strtoupper($_SERVER["REQUEST_METHOD"]) == "POST"){
  $sql = "DELETE FROM `registration` WHERE `student`='".$_SESSION['user']."' AND `course`='".$_POST['dropped_course']."'";
  $drop_result = mysqli_query($conn, $sql);
  if($drop_result > 0)
    $message = "Courses have been dropped";
}
$sql = "SELECT `course`,`instructor` FROM `registration` WHERE `student` = '".$_SESSION['user']."'";
$result = mysqli_query($conn, $sql);
?>
<!doctype html>
<html>

<head>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet">
  <!-- Bootstrap CSS -->
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'>
  <!-- Font Awesome CSS -->
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css'>

  <link rel='stylesheet' href='master.css'>


</head>

<body id="std-body">

  <!--<h1 style= "color:white">Let us Learn</h1>-->

  <ul>
    <li><a class="active" href="file:///Users/nawafalshuhail/Desktop/Login%20Page%20files/Login.html">Home</a></li>
    <li><a href="#news">News</a></li>
    <li><a href="#contact">Contact us</a></li>
    <li><a href="#about">Link 1</a></li>
    <li><a href="#about">Link 2</a></li>
    <li><a href="#about">About</a></li>
    <li style="float:right"><a class="active" href="Logout.php">Log out</a></li>
  </ul>
  <div class="container">
    <div class="content1">
      <div class="vertical-menu">
        <a href="#" class="active">Dashboard</a>
        <a href="Register-course.php">View
          Courses/Registration</a>
        <a href="Courses-List.php">My Courses</a>
      </div>
      <div class="calender">
        <div class="month">
          <ul>
            <li>
              JUNE<br>
              <span style="font-size:18px">2021</span>
            </li>
          </ul>
        </div>

        <ul class="weekdays">
          <li>Mo</li>
          <li>Tu</li>
          <li>We</li>
          <li>Th</li>
          <li>Fr</li>
          <li>Sa</li>
          <li>Su</li>
        </ul>

        <ul class="days">
          <li>1</li>
          <li>2</li>
          <li>3</li>
          <li>4</li>
          <li>5</li>
          <li>6</li>
          <li>7</li>
          <li>8</li>
          <li>9</li>
          <li>10</li>
          <li>11</li>
          <li>12</li>
          <li>13</li>
          <li>14</li>
          <li>15</li>
          <li>16</li>
          <li>17</li>
          <li>18</li>
          <li>19</li>
          <li>20</li>
          <li>21</li>
          <li>22</li>
          <li>23</li>
          <li>24</li>
          <li><span class="active">25</span></li>
          <li>26</li>
          <li>27</li>
          <li>28</li>
          <li>29</li>
          <li>30</li>
          <li>31</li>
        </ul>
      </div>
    </div>

    <body>
        <header>
            <h1>My Courses </h1>
            <hr>
            <article>
                <h2>Registered Courses</h2>
              
                <?php
                echo'<table class="table-courses"><thead><tr><th>Course</th> <th>Instructor Name</th><th>Instructor Email</th><th>Drop</th><th>Time</th><th>Date</th></tr></thead><tbody>';
                $counter = 0;
                  while($row = mysqli_fetch_assoc($result)){
                    //get instructor name
                    $sql = "SELECT * FROM user WHERE email = '".$row['instructor']."'";
                    $instructor_list = mysqli_query($conn, $sql);
                    $instructor =mysqli_fetch_assoc($instructor_list);
                    $instructor = $instructor['fname']." ".$instructor['lname'];
                    //get course date and time
                    $sql = "SELECT `date`,`time` FROM course WHERE course_title = '".$row['course']."'";
                    $date = mysqli_query($conn, $sql);
                    $date =mysqli_fetch_assoc($date);
                    $time = $date['time'];
                    $date = $date['date'];
                    echo'<tr><td>'.$row['course'].'</td><td>'.$instructor.'</td><td>'.$row['instructor'].'</td><td>'.$time.'</td><td>'.$date.'</td><td><form action='.htmlspecialchars($_SERVER["PHP_SELF"]).' method="post"><input type="hidden" name="dropped_course" value="'.$row['course'].'"><input type="submit" value="Drop Course" class="submit-btn-dropp" title="drop"> </form></td></tr>';
                    $counter++;  
                  }
                  echo"</tbody></table>";
                  if($counter < 1)
                    echo"<p style='color:red;font-weight:bold;'>No Registered Course Yet!</p>";
                ?>
                <span style="color:green"><?php echo $message; ?></span>
            </article>
        </header>
        
    </body>

  </div>


  <script src="slide_show.js" defer></script>
</body>
    <footer>
        <p> Contact us </p>
                <p>Author: Copyrights<br></footer>
    
</html>