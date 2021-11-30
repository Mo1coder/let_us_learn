<?php 
include("../config/db_login.php");

session_start();



$ERRORS = array('email' => '', 'password' => '');
$input = array('email' => '', 'password' => '');
$message = '';
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

    if($is_valid){
        $conn = mysqli_connect($server, $user_db, $pass_db, $db);
        $sql = "SELECT * FROM `user` WHERE `email` = '".$input['email']."' AND `password` = '".$input['password']."'";
        $result = mysqli_query($conn, $sql);
        // print_r(mysqli_fetch_assoc($result));
        if(mysqli_num_rows($result) > 0){
            $_SESSION['logged'] = true;
            $_SESSION['user'] = $input['email'];
            header("location:".mysqli_fetch_assoc($result)['type'].".php");
        }
        else{
            $message = " *invalid username or password!";
        }
    }

}
?>
<html>

<head>
    <title>Log In</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'>
    <!-- Font Awesome CSS -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css'>
    <link rel='stylesheet' href='../src/css/master.css'>


</head>



<body>
    <h1> Log In </h1>
    <div class="hero">
        <h2 id="title"></h2>
        <div class="form-box">
            <div class="Button-box">
                <form class="input-group" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                    <div class="fields">
                    <span style="color:red"> <?php echo $message;?> </span><br>
                        <input type="emial" class="text" name="email" value="<?php echo $input['email']; ?>" placeholder="Email" required />
                        <input type="password" class="text" name="password" placeholder="Password" value="<?php echo $input['password']; ?>" required /><br>
                        <span style="margin-right:150px;color:red"> <?php echo $ERRORS['email']?></span>
                        <span style="margin-left:50px;color:red"> <?php echo $ERRORS['password']?></span>
                        
                    </div>


                    <input type="submit" value="Log in" name='submit' class="submit-btn">
                    <div class="register-view">

                        <p class="register-label">Dont have account, register today!</p>
                        <a href="Register.php" class="button">Register</a>
                    </div>
                </form>

            </div>

        </div>
    </div>
    <footer>

        <p>Author: Copyrights<br>

    </footer>
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
        background-color: orange;
        /* Blue */
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
        left: 650px;
        top: 150px;

    }
</style>