<?
session_start();
include "db_conn.php";

$user_ok    = false;
$log_id     = "";
$log_username   = "";
$log_password   = "";
$conn = dbconn();

function evalLoggedUser ($conn,$u){
    $sqlStmt = "select email from users where first_name = '$u' limit 1";
    $query = $conn->prepare($sqlStmt);
    $query->execute();
    $numrows = $query->rowCount();
    if ($numrows > 0){
        return true;
    }
}
function stayLogged(){
    if (isset($_SESSION["userid"]) && isset($_SESSION["username"])){

    }else{
        session_destroy();
        header("Location: /admin/admin_login.php");
    }
}

?>