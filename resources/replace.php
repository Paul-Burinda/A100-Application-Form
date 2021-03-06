<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>A100 Application - New Applicant Update-Save Page</title>
		<link href="../public_html/css/bootstrap.css" rel="stylesheet">
		<link href="../public_html/css/signin.css" rel="stylesheet">
		<link href="../public_html/css/form.css" rel="stylesheet">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,800italic,300italic,600italic,400,300,600,700,800|Montserrat:400,700' rel='stylesheet' type='text/css'>
    	<link href="public_html/css/font-awesome.min.css" rel="stylesheet">

	</head>

	<body>

		<div class="container-fluid">

			<div class="row form">

				<?php
					include "../admin/db_conn.php";
					include "Insert_PDOParam.php";
					include "Insert_SQL.php";

					print_r($_POST);


					 	try{

						$dbh = dbconn();
						$sqlStmt = "SELECT user_id,applicant_id,referral_id,schedule_id,experience_id,material_id FROM applications INNER JOIN users
							ON applications.applicant_id = users.user_id WHERE users.email = ".$_POST["email"];

       					$getKeys = $dbh->prepare($sqlStmt);
       					$getKeys->execute();
       					$theKeys = $getKeys->fetch(PDO::FETCH_ASSOC);


       					$user_id = $theKeys['user_id'];
       					$applicant_id = $theKeys['applicant_id'];
       					$referral_id = $theKeys['referral_id'];
       					$schedule_id = $theKeys['schedule_id'];
       					$experience_id = $theKeys['experience_id'];
       					$material_id = $theKeys['material_id'];

       					$keyinfo = array('user_id','referral_id','schedule_id','experience_id','material_id','applicant_id');



					 	if(array_key_exists("submit", $_POST)){
					 		$Required = $dbh->prepare(getReqFields());
					 		$Required->execute();
					 		$RequiredFields = $Required->fetchAll(PDO::FETCH_ASSOC);
					 		foreach($RequiredFields as $Row=>$Field){
					 			if(empty($_POST[$RequiredFields[$Row]["field_name"]])){
					 			 	throw new Exception ("<p>Missing requried field from form.</p>");
					 			}
					 		}
					 		$_POST["is_complete"] = TRUE;

					 	} else if (array_key_exists("save", $_POST)){
					 		if(empty($_POST["email"]) || empty($_POST["password"])){
					 			throw new Exception("<p>Missing email and/or password</p>");
					 		}
					 		$_POST["is_complete"] = FALSE;
					 		$email = $_POST["email"];
				 			$subject = "Thank you for your interest in Apprentice 100";
							$Message = "
							<html>
							<head>
							<title>HTML email</title>
							</head>
							<body>
							<p>Thank you for your continued interest in the Apprentice 100 program. </p>
							<p>We look forward to receiving your completed application</p>
							<p>Sincerely <br/ >A100 Developers</p>
							</body>
							</html>";
							$headers = "MIME-Version: 1.0" . "\r\n";
							$headers .= "Content-type: text/html; charset=iso-8859-1"."\r\n";
					 		mail($email, $subject, $Message, $headers);
					 	}

						$applicationSqlInsert = "NULL";
						$tableInfo = array('users', 'referrals','schedules', 'experiences',
						 'materials', 'applicants');

						for($x=0;$x<count($tableInfo);$x++){
							$TableDesc = $dbh->prepare("DESCRIBE ".$tableInfo[$x]);
							$TableDesc->execute();
							$Fields = $TableDesc->fetchAll(PDO::FETCH_ASSOC);
							$submitSqltable = $tableInfo[$x];
							$submitTableKey = $keyinfo[$x];
							$submitSqlField = "";
							$submitSqlRecord = "";
							$PrimKey = "";
							$sqlFirst = 0;
							$submitSQLField = array();
							foreach ($Fields as $row) {
								$fieldval = null;
								if($sqlFirst != 0){
									$submitSqlField .= ", ";
								}
								foreach ($row as $col => $value) {
									if($col == "Field"){
										if(!fnmatch("*" . "_id", $value)) {//strip out xxx_id fields
										$submitSqlField .= $value;
										$fieldval = $value;
										} else {
											$submitSQLField = $submitSQLField;
										}
									}
								}//end 2nd ForEach

								if(empty($_POST[$fieldval])) {
									if($fieldval == "is_complete"){
										$submitSqlRecord .= "\"".((int)$_POST[$fieldval])."\"";
									} else {
					        			$sqlFirst++;
									}

						        } else {
						        	if($submitSqltable !== "applications"){
							        	$submitSqlRecord .= $fieldval . '=' . "'" .$_POST[$fieldval] . "'" . ",";
						        	} else {
						        		$submitSqlRecord .= "\"".$_POST[$fieldval]."\"";
						        	}
						        }
							}//end top Foreach

							 $submitSqlRecord = rtrim($submitSqlRecord,", ");

							 $submitSql = "UPDATE $submitSqltable SET $submitSqlRecord
				 				WHERE $submitSqltable.$keyinfo[$x] = '$user_id'";


							$update = $dbh->prepare($submitSql);

							if($update->execute()){
								if($submitSqltable != "applications"){
									$_POST[$PrimKey] = $dbh->lastInsertId();
								}
							} else throw new Exception("Error executing update: ".$submitSql);
						}
					} catch (PDOException $e) {
						echo "Connection issue: ".$e->getMessage();
					} catch (Exception $e) {
						echo $e->getMessage();
					} finally {
						$dbh = null;
					}
				?>

			</div>

			<div class="row form">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bottomMargin">
					<h4><a href="../index.php">Return to Application Form login</a></h4>
					<h4><a href="http://www.indie-soft.com/a100">Return to A100 Program website</a></h4>
				</div>
			</div>

		</div>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="public_html/js/bootstrap.js"></script>

	</body>

</html>