<?php
    session_start();
    session_regenerate_id();
?>
<!DOCTYPE HTML>
<html>

    <meta http-equiv="Content-Type" content = "text/html; charset=utf-8">

    <link rel = "stylesheet" href="css/regit.css" >

    <!-- Title -->
    <title> Admin Login</title>

    <!-- Body -->
    <section  class ="regit">
        <h1 class="status"> </h1>
        <!-- Input Field -->
        <form action="auth.php" method="post">
            <label>Name</label>
            <input id = "username" name="username" type="text" placeholder="Type Username Here" required autofocus>

            <label>Password</label>
            <input id = "password" name="password" type="password" placeholder="Type Password Here" required autocomplete="off" >

            <input id="submit" name="login" type="submit" value="submit">

            <!-- In Testing: The Use of Ajax to create a more dynamic experience -->
            <!-- <button id = "login">Click Me to submit</button> -->
        </form>
    </section>
    <script src="js/main.js" type="text/javascript"></script>
</html>
