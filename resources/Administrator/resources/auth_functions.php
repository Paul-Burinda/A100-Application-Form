<?php

    function authUser($conn,$username,$password){

        $hashpwd = password_hash($password, PASSWORD_DEFAULT);
        $sqlStmt = "SELECT email FROM users WHERE role_id = 1 and  first_name = 'l".$username."'" ;
        $result = $conn->prepare($sqlStmt);
        $result->execute();
        $rownum = $result->rowCount();

        if ($rownum > 0){
            return "success";
            break;
        }else{
            return "failed";
            break;
        }
    }

    function duplicateUsers($username,$conn){
        $sqlStmt = "Select first_name from users where first_name = '".$username."'";
        $result = $conn->prepare($sqlStmt);
        $result -> execute(array(":username" => $username));

        if ($r_contents = $result->fetch()) {
            do {
                return true;
            }
            while ($r_contents = $result->fetch());
        }
        else {
            return false;
        }
    }

    function newUser($username,$password,$conn){
        $sqlStmt = "INSERT INTO users (first_name, password,role_id) VALUES (:username, :password, 1)";

        $hashpwd = password_hash($password, PASSWORD_DEFAULT);
        $result = $conn ->prepare($sqlStmt);
        try{
            $result -> execute(array(
            ":username" => $username,
            ":password" => $hashpwd));
        }
        catch (Exception $e){
            echo "Error: ".$e;
        }

    }
?>
