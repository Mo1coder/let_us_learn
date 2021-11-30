<?php 
session_start();

include("../config/db_login.php");

$message = "";
$conn = mysqli_connect($server, $user_db, $pass_db, $db);
$sql = "SELECT * FROM course";
$courses = mysqli_query($conn, $sql);
if(strtoupper($_SERVER["REQUEST_METHOD"]) == "POST"){
    if($_SESSION['logged']){
        foreach($_POST as $key => $value){
          $sql = "SELECT instructor FROM course WHERE course_title = '".$value."'";
          $result = mysqli_query($conn, $sql);
          $instructor ='';
          $instructor = mysqli_fetch_assoc($result)['instructor'];
          $sql = "INSERT INTO `registration` VALUES('".$_SESSION['user']."','".$value."','".$instructor."')";
          $result = mysqli_query($conn, $sql);
        }
        $message = "Courses Added successfuly";
    }
        

}
?>
<html>
    <head>
        <title>Register Course</title>
        <link rel="stylesheet" href="Register-course.css" />
        <link rel="stylesheet" href="modal.css" />
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet">
        <!-- Bootstrap CSS -->
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'>
        <!-- Font Awesome CSS -->
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css'>
        <link rel='stylesheet' href='master.css'>
        
        
    </head>
    <body id="std-body">
    <body>
   

  <!--<h1 style= "color:white">Let us Learn</h1>-->

  <ul>
    <li><a class="active" href="Login.php">Home</a></li>
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

        
        <main>
            <article>
                
                    <form class="input-group" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <?php
                          echo'<table class="table-courses"><thead><tr><th>Course</th> <th>Instructor Name</th><th>Time</th><th>Date</th></tr></thead><tbody>';
                          while($row = mysqli_fetch_assoc($courses)){
                            echo'<tr><td><input
                                        type="checkbox"
                                        id="'.$row['course_title'].'"
                                        name="'.$row['course_title'].'"
                                        value="'.$row['course_title'].'"
                                    />
                                    <label for="'.$row['course_title'].'">'.$row['course_title'].'</label></td><td>'.$row['instructor'].'</td><td>'.$row['time'].'</td><td>'.$row['date'].'</td></tr>';
                          }
                          echo'</tbody></table><input type="submit" value="Register" class="submit-btn">';
                        ?>
                        
                        <span style="color:green"><?php echo $message; ?></span>
                    </form>
                     
                
            </article>
        </main>
        <!-- <div id="myModal" class="modal"> -->
            <!-- Modal content -->
            <!-- <div class="modal-content">
                <span class="close">&times;</span>
                <p>Tutor Name: Ahmed Ali</p>
                <p>Date: ....</p>
                <p>Time: 2:30-3:20 PM</p>
            </div>
        </div>
        <script src="modal.js"></script> -->
    </body>
</html>

<style>
    body {
   /* background: #152733;  /* fallback for old browsers */
   /* background: -webkit-linear-gradient(to right, #4ca2cd, #67B26F);  /* Chrome 10-25, Safari 5.1-6 */
    /* background: linear-gradient(to right, #4ca2cd, #67B26F); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    padding: 0;
    margin: 0;
    font-family: 'Lato', sans-serif;
    color: #000;
      /* The image used */
    background: url("Coverpage2.jpg");
      /* Full height */
    height: 100%;
      /* Center and scale the image nicely */
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;}
}