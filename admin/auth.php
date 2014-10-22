<?php
session_start();
session_regenerate_id();

include "resources/db_conn.php";
include "resources/php_func/auth_functions.php";

$dbh = dbconn();


$username = $_POST['username'];
$password = $_POST['password'];

   if(isset($_POST['create']))
    {
       if (duplicateUsers($username,$dbh)==true){
            echo "User with this username already exists <br>";
            echo "Click on the link to go back to the create user page <br>";
            echo '<a href="create_user.php">User Creation Page</a>';
            session_destroy();
       }
       else{
            newUser($username,$password,$dbh);
            echo "User has been successfully created.<br>";
            echo "Click on the line below to go back to the login page <br>";
            echo '<a href="index.php">Login Page</a>';
            session_destroy();
       }
    }
    else if (isset($_POST['login'])){
        $log_attempt = authUser($dbh,$username,$password);
        if ($log_attempt == "success"){
            $_SESSION['username'] = $username;
            $_SESSION['status'] = 1;
             header("Location:/code_lab/2ndProject/admin/admin_login.php");
        }
        else{
            session_destroy();
        }

        //echo "We're working on it <br>";
    }

?>