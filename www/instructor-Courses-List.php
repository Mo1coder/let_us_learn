<?php 
session_start();

// configuer database
$server = "localhost";
$user_db = "root";
$pass_db = "";
$db = "learn";

$message = "";
$conn = mysqli_connect($server, $user_db, $pass_db, $db);

// print_r($_SESSION);
// print_r($_POST);

if(strtoupper($_SERVER["REQUEST_METHOD"]) == "POST"){
  $sql = "UPDATE `course` SET instructor = ' ' WHERE `course_title`='".$_POST['dropped_course']."'";
  $drop_result = mysqli_query($conn, $sql);
  if($drop_result > 0)
    $message = "Coreses have benn dropped";
  $sql = "UPDATE `registration` SET instructor = ' ' WHERE course = '".$_POST['dropped_course']."'";
  $result = mysqli_query($conn, $sql);
    
}

$sql = "SELECT `course_title` FROM `course` WHERE `instructor` = '".$_SESSION['user']."'";
$courses_list = mysqli_query($conn, $sql);
$data = array();
while($row = mysqli_fetch_assoc($courses_list)){
  $data[$row['course_title']] = array();
}

$sql = "SELECT `course`,`student` FROM `registration` WHERE `instructor` = '".$_SESSION['user']."'";
$registration = mysqli_query($conn, $sql);
while($row = mysqli_fetch_assoc($registration)){
  // print_r($row);echo"<br>";
  // if(!array_key_exists($row['course'] ,  $data))
  //   $data[$row['course']] = array();
  
  $data[$row['course']][] = $row['student'];
}
// echo"<pre>";
// print_r($data);
// echo"</pre>";
// echo count($data);
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
        <a href="instructor-Register-course.php">View
          Courses/Registration</a>
        <a href="instructor-Courses-List.php">My Courses</a>
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
                echo'<table class="table-courses"><thead><tr><th>Course</th> <th>Studnet Name</th><th>Student Email</th><th>Drop Course</th></tr></thead><tbody>';
                $counter = 0;
                foreach ($data as $course => $students) {
                  $std = '--';
                  $std_email = '--';
                  $row_span = 1;
                  if(count($students) > 0){
                    $sql = "SELECT fname,lname FROM user WHERE email = '".$students[0]."'";
                    $std = mysqli_query($conn, $sql);
                    $std = mysqli_fetch_assoc($std);
                    $std = $std['fname']." ".$std['lname'];
                    $std_email = $students[0];
                    $row_span = count($students);
                  }
                  echo'<tr><td rowspan="'.$row_span.'">'.$course.'</td> ';
                  echo '<td>'.$std.'</td><td>'.$std_email.'</td><td rowspan="'.$row_span.'"><form action='.htmlspecialchars($_SERVER["PHP_SELF"]).' method="post"><input type="hidden" name="dropped_course" value="'.$course.'"><input type="submit" value="Drop Course" class="submit-btn-dropp" title="drop"> </form></td></tr><tr>';
                  for ($i=1; $i < count($students); $i++) {
                    $sql = "SELECT fname,lname FROM user WHERE email = '".$students[$i]."'";
                    $std = mysqli_query($conn, $sql);
                    $std = mysqli_fetch_assoc($std);
                    $std = $std['fname']." ".$std['lname'];
                    echo '<td>'.$std.'</td><td>'.$students[$i].'</td></tr><tr>';
                  }
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