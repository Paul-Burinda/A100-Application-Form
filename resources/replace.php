<?php
    include "db_conn.php";
    include "AdminPage_SQL.php";

    $dbh = dbconn();
    $array=InsertArray();
    $tableJoin=dbTables();

    for ($counter=0; $counter<count($tableJoin);$counter++){
        $query = "SELECT * from ".$tableJoin[$counter]."WHERE application_id=".$array['email'];
        $result = $dbh->prepare($query);
        $result->execute();

        if ($result){
            while (sizeof($result)>1){

                if($sqlFirst!=0){
                $submitSqlField = $submitSqlField . ",";
                $submitSqlRecord = $submitSqlRecord . ",";
                            }
            }
        }
    }

?>

<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>A100 Application - Existing Applicant Submit-Save Page</title>

        <!-- Bootstrap -->
        <link href="../public_html/css/bootstrap.css" rel="stylesheet">

        <!-- Signin stylesheet -->
        <link href="../public_html/css/signin.css" rel="stylesheet">

        <!-- Custom CSS for Application Form -->
        <link href="../public_html/css/form.css" rel="stylesheet">


        <!-- Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,800italic,300italic,600italic,400,300,600,700,800|Montserrat:400,700' rel='stylesheet' type='text/css'>
        <link href="public_html/css/font-awesome.min.css" rel="stylesheet">

    </head>

    <body>

        <div class="container-fluid">

            <div class="row form">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bottomMargin">
                    <h4><a href="../index.php">Return to Application Form login</a></h4>
                    <h4><a href="http://www.indie-soft.com/a100">Return to A100 Program website</a></h4>
                </div>
            </div>

        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="public_html/js/bootstrap.js"></script>

    </body>

</html>