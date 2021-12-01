<?php 
session_start();
include("../config/db_login.php");


$ERRORS = array('fname' => '', 'lname' =>'', 'email' => '', 'confirm_email' => '', 'password' => '',  'id' => '');
$input = array('fname' => '', 'lname' =>'', 'email' => '', 'confirm_email' => '', 'password' => '',  'id' => '');

if(strtoupper($_SERVER["REQUEST_METHOD"]) == "POST"){
    //validate input
    $is_valid = true;
    foreach($ERRORS as $key => $value){
        $input[$key] = $_POST[$key];
        if(empty(trim(htmlspecialchars($_POST[$key])))){
            $ERRORS[$key] = " *please enter valid input";
            $is_valid = false;
        }
    }

    if($input['email'] != $input['confirm_email']){
        $ERRORS['confirm_email'] = " *email mismatch";
            $is_valid = false;
    }
    if($is_valid){
        $conn = mysqli_connect($server, $user_db, $pass_db, $db);
        $sql = "SELECT * FROM `user` WHERE `email` = '".$input['email']."'";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0){
            $ERRORS['email'] = " *This email is already registered!";
        }
        else{
            $sql = "INSERT INTO `user` (`id`, `fname`, `lname`, `email`, `password`, `type`) 
            VALUES("
            .$input['id'].",'"
            .$input['fname']."','"
            .$input['lname']."','"
            .$input['email']."','"
            .$input['password']."','"
            .$_POST['type']."');"
            ;   
            $result = mysqli_query($conn, $sql);
            mysqli_close($conn);

            if($result){
                $_SESSION['logged'] = true;
                $_SESSION['user'] = $input['email'];
                header("location:".$_POST['type'].".php");
            }
    
            }
        }

}
?>

<html>
    <head>
        <title>Sign Up</title>
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet">
<!-- Bootstrap CSS -->
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'>
<!-- Font Awesome CSS -->
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css'>
<link rel='stylesheet' href='../src/css/master.css'>


        
    </head>
    <body>
        <h1> Registration </h1>
        <div class="hero">
            <h2 id="title"></h2>
            <div class="form-box">
                <div class="Button-box">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="input-group">
                        
                        <div class="fields">
                            <span style="margin-right:150px;color:red"> <?php echo $ERRORS['fname']?></span>
                            <span style="margin-left:50px;color:red"> <?php echo $ERRORS['lname']?></span><br>
                            <input
                                type="text"
                                class="text"
                                name="fname"
                                value="<?php echo $input['fname']; ?>"
                                placeholder="First Name"
                                required
                            />
                            <input
                                type="text"
                                class="text"
                                name="lname"
                                value="<?php echo $input['lname']; ?>"
                                placeholder="Last Name"
                                required
                            />
                             
                        </div>
                
                        <div class="fields">
                            <span style="margin-right:150px;color:red"> <?php echo $ERRORS['email']?></span>
                            <span style="margin-left:50px;color:red"> <?php echo $ERRORS['confirm_email']?></span><br>
                            <input
                                type="email"
                                class="text"
                                name="email"
                                value="<?php echo $input['email']; ?>"
                                placeholder="Email"
                                required
                            />
                            <input
                                type="email"
                                class="text"
                                name="confirm_email"
                                value="<?php echo $input['confirm_email']; ?>"
                                placeholder="Confirm Email"
                                required
                            />
                        </div>
                        <div class="fields">
                            <span style="margin-right:150px;color:red"> <?php echo $ERRORS['password']?></span>
                            <span style="margin-left:50px;color:red"> <?php echo $ERRORS['id']?></span><br>
                            <input
                                type="password"
                                class="text"
                                name="password"
                                placeholder="Password"
                                required
                            />
                            <input
                                type="text"
                                class="text"
                                name="id"
                                value="<?php echo $input['id'];?>"
                                placeholder="User ID"
                                required
                            />
                            <select name="type" id="acc-type">
                                <option disabled  value="">User Type</option>
                                <option value="Instructor">Instructor</option>
                                <option value="Student" selected>Student</option>
                            </select>
                        </div>
                         <input type="submit" value="Sign up"  class="submit-btn"> 
                    </form>
                    <footer>
  
                        <p>Author: Copyrights<br>
  
                    </footer>
                </div>
            </div>
        </div>
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
    background: url("../src/imgs/Coverpage2.jpg");
      /* Full height */
    height: 100%;
      /* Center and scale the image nicely */
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    }


    button {
    background-color: orange;
    border-radius: 30px;
    color: white;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 0;
    cursor: pointer;
    position: center;
    

}

.submit-btn {
    width: 30%;
    border-radius: 30px;
    align-self: center;
    color: white;
    background-color: orange; /* Blue */
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border-width: 0px;
    border: none;
}

.input-group {
    display: flex;
    flex-direction: column;
    text-align: center;
    align-items: center;
    justify-content: center;
    

}

.fields {
    width: 50%;
    text-align: center;
}

input.text {
    width: 45%;
    padding: 10px 15px;
    margin: 10px;
    box-sizing: border-box;
    border-color: #7091a1;
    border-width: 0px;
    border: none;
    border-radius: 30px;
}

.register-view {
    display: flex;
    height: 100%;
    justify-content: center;
    align-items: center;
}

.register-label {
    margin-right: 15px;
    color: aliceblue;
    font-size: 19px;
}

#acc-type {
    width: 45%;
    padding: 10px 15px;
    margin: 10px;
    box-sizing: border-box;
    border-color: #7091a1;
    border-width: 0px;
    border: none;
    border-radius: 30px;
}

.form-box {
    text-align: center; 
    

}
 #title {
    color: white;
    align-self: center;
    margin-top: 15%;
     display: flex;
     align-items: center;
}
    h1 {
  position: absolute;
  left: 600px;
  top: 150px;
        
}
</style>
