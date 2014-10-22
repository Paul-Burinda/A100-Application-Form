<?php
    session_start();
    session_regenerate_id();

    if (isset($_SESSION["userid"]) && isset($_SESSION["username"])){

    }else{
        session_destroy();
        header("Location:/code_lab/2ndProject/admin/admin_login.php");
    }
?>

<!DOCTYPE HTML>
<html>

    <meta http-equiv="Content-Type" content = "text/html; charset=utf-8">

    <link rel = "stylesheet" href="css/regit.css" >

    <!-- Title -->
    <title> Create User</title>

    <!-- Body -->
    <section  class ="regit">
    <h1>This is for creating Admin Users</h1>
        <!-- Input Field -->
        <form action="auth.php" method="post">
            <label>Name</label>
            <input name="username" type="text" placeholder="Type Username Here" required autofocus>

            <label>Password</label>
            <input name="password" type="password" placeholder="Type Password Here" required autocomplete="off" >

            <input id="submit" name="create" type="submit" value="submit">
        </form>

    </section>
</html>
