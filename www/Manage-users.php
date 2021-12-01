<?php
include("../config/db_login.php");
session_start();

// configuer database


$message = "";
$conn = mysqli_connect($server, $user_db, $pass_db, $db);
$ERRORS = array('fname' => '', 'lname' => '', 'email' => '', 'confirm_email' => '', 'password' => '',  'id' => '');
$input = array('fname' => '', 'lname' => '', 'email' => '', 'confirm_email' => '', 'password' => '',  'id' => '');


if (strtoupper($_SERVER["REQUEST_METHOD"]) == "POST") {

  if ($_POST['submit'] == "Remove User") {
    $sql = "DELETE FROM `user` WHERE `email`='" . $_POST['removed_user'] . "'";
    $drop_result = mysqli_query($conn, $sql);
    if ($drop_result > 0)
      $message = "User has been Removed";
  }
  if ($_POST['submit'] == "Add User") {
    //validate input
    $is_valid = true;
    foreach ($ERRORS as $key => $value) {
      $input[$key] = $_POST[$key];
      if (empty(trim(htmlspecialchars($_POST[$key])))) {
        $ERRORS[$key] = " *please enter valid input";
        $is_valid = false;
      }
    }

    if ($input['email'] != $input['confirm_email']) {
      $ERRORS['confirm_email'] = " *email mismatch";
      $is_valid = false;
    }
    if ($is_valid) {
      $conn = mysqli_connect($server, $user_db, $pass_db, $db);
      $sql = "SELECT * FROM `user` WHERE `email` = '" . $input['email'] . "'";
      $result = mysqli_query($conn, $sql);
      if (mysqli_num_rows($result) > 0) {
        $ERRORS['email'] = " *This email is already registered!";
      } else {
        $sql = "INSERT INTO `user` (`id`, `fname`, `lname`, `email`, `password`, `type`) 
                VALUES("
          . $input['id'] . ",'"
          . $input['fname'] . "','"
          . $input['lname'] . "','"
          . $input['email'] . "','"
          . $input['password'] . "','"
          . $_POST['type'] . "');";
        $result = mysqli_query($conn, $sql);
        $message = "User has been added";
        $input = array('fname' => '', 'lname' => '', 'email' => '', 'confirm_email' => '', 'password' => '',  'id' => '');
      }
    }
  }
}
$sql = "SELECT * FROM `user` WHERE `email` != '' And `type` != 'Admin' ORDER BY `id` ASC";
$users = mysqli_query($conn, $sql);
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
  <link rel='stylesheet' href='manage_users.css'>


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
        <a href="Admin.php" class="active">Dashboard</a>
        <a href="#">Manage Users</a>
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
        <h1>Manage Users </h1>
        <hr>
        <article>


          <?php
          echo '<table class="table-courses"><thead><tr><th>ID</th> <th>Full Name</th><th>Email</th><th>Password</th><th>Role</th><th>Remove</th></tr></thead><tbody>';
          $counter = 0;
          while ($row = mysqli_fetch_assoc($users)) {
            echo '<tr><td>' . $row['id'] . '</td><td>' . $row['fname'] . ' ' . $row['lname'] . '</td><td>' . $row['email'] . '</td><td>' . $row['password'] . '</td><td>' . $row['type'] . '</td><td><form action=' . htmlspecialchars($_SERVER["PHP_SELF"]) . ' method="post"><input type="hidden" name="removed_user" value="' . $row['email'] . '"><input type="submit" name="submit" value="Remove User" class="submit-btn-dropp" title="drop"> </form></td></tr>';
            $counter++;
          }

          ?>
          </tbody>
          </table>
          <?php
          if ($counter < 1)
            echo "<p style='color:red;font-weight:bold;'>No Registered Users Yet!</p>";
          ?>
          <span style="color:green"><?php echo $message; ?></span>

          <!-- Trigger/Open The Modal -->
          <button id="Trigger">Add New User</button>

          <!-- The Modal -->
          <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
              <div class="modal-header">
                <span class="close">&times;</span>
                <h2>Add New User</h2>
              </div>
              <div class="modal-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="input-group">
                  <div class="fields">
                    <span style="margin-right:150px;color:red"> <?php echo $ERRORS['fname'] ?></span>
                    <span style="margin-left:50px;color:red"> <?php echo $ERRORS['lname'] ?></span><br>
                    <input type="text" class="text" name="fname" value="<?php echo $input['fname']; ?>" placeholder="First Name" required />
                    <input type="text" class="text" name="lname" value="<?php echo $input['lname']; ?>" placeholder="Last Name" required />

                  </div>

                  <div class="fields">
                    <span style="margin-right:150px;color:red"> <?php echo $ERRORS['email'] ?></span>
                    <span style="margin-left:50px;color:red"> <?php echo $ERRORS['confirm_email'] ?></span><br>
                    <input type="email" class="text" name="email" value="<?php echo $input['email']; ?>" placeholder="Email" required />
                    <input type="email" class="text" name="confirm_email" value="<?php echo $input['confirm_email']; ?>" placeholder="Confirm Email" required />
                  </div>
                  <div class="fields">
                    <span style="margin-right:150px;color:red"> <?php echo $ERRORS['password'] ?></span>
                    <span style="margin-left:50px;color:red"> <?php echo $ERRORS['id'] ?></span><br>
                    <input type="password" class="text" name="password" placeholder="Password" required />
                    <input type="text" class="text" name="id" value="<?php echo $input['id']; ?>" placeholder="User ID" required />
                    <select name="type" id="acc-type">
                      <option disabled value="">User Type</option>
                      <option value="Admin">Admin</option>
                      <option value="Instructor">Instructor</option>
                      <option value="Student" selected>Student</option>
                    </select>
                  </div>
                  <div class="fields">
                    <input type="submit" name="submit" value="Add User" class="submit-btn">
                    <input type="reset" name="clear" value="Clear" class="submit-btn">
                  </div>
                </form>

              </div>
              <div class="modal-footer">
                <h3></h3>
              </div>
            </div>

          </div>
        </article>
      </header>

    </body>

  </div>


  <script src="slide_show.js" defer></script>
  <footer>
    <p> Contact us </p>
    <p>Author: Copyrights<br>
  </footer>
  <script>
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("Trigger");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal 
    btn.onclick = function() {
      modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
      modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
  </script>
</body>

</html>