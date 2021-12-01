<?php 
include("../config/db_login.php");
session_start();
session_destroy();
header("location: Login.php");
?>