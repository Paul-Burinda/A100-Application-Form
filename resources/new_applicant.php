<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>A100 Application - New Applicant Form</title>

	<!-- Bootstrap -->
	<link href="../public_html/css/bootstrap.css" rel="stylesheet">

	<!-- Signin stylesheet -->
	<link href="../public_html/css/signin.css" rel="stylesheet">

	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,800italic,300italic,600italic,400,300,600,700,800|Montserrat:400,700' rel='stylesheet' type='text/css'>
	<link href="public_html/css/font-awesome.min.css" rel="stylesheet">

	</head>

	<body>

		<div class="container-fluid">

			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bottomMargin">
					<h1>A100 Application Form</h1>
				</div>
			</div>

			<div class="row">
				<form method="post" id ="new_applicant_form" enctype="multipart/form-data" action="handler" onsubmit="return validateMyForm();">

					<?php

					// put query string params into qs array
					parse_str($_SERVER['QUERY_STRING'], $qsParams);
					// print_r($qsParams);


					include "cred_int.php";
					include "Insert_SQL.php";

							//Create connection
					$appCon = mysqli_connect(HOST, USER, PASSWORD, DATABASE_NAME);
						// Check connection
					if (mysqli_connect_errno()) {
						echo "Failed to connect to form_db MySQL: " . mysqli_connect_error();
					}

						//sorts content by section on sections.arrange
					$qstnSql = getSectionSQL($qsParams['section']);

					// print_r($qstnSql);
					$qstnArray = mysqli_query($appCon, $qstnSql);

					$arrangeCounter = 0;
					while($row = mysqli_fetch_array($qstnArray))
					{
						// if($row['section_id']==1){
						// checks if moving to a new section, if counter is less than section.arrange, print header and body if available
						if($arrangeCounter<$row['arrange'])
						{

							if($row['pre_text']==NULL && $row['post_text']==NULL)
							{
								echo "<h3>" . $row['section_name'] . "*</h3>";
							}else
							{
								echo "<h3>" . $row['section_name'] . "</h3>";
							}
							echo "<b>" . $row['section_description'] . "</b>";
							$arrangeCounter = $row['arrange'];
						}

						//if($row['is_active']==X){  //flag functionality not working right now due to ambiguous column headers
						//	echo "is active flag:" . $row['is_active'];
						//}else
						if($row['is_required']==1 && $row['post_text']==NULL && $row['pre_text']!= NULL){
							echo "<h4>" . $row['pre_text'] . "*</h4>";
						}else
						{
							echo "<h4>" . $row['pre_text'] . "</h4>";
						}

							$insideText = "";  //variable to hold inside text content/reduce need for " and '
							$fieldName = $row['field_name'];  //variable to hold DB name content/reduce need for " and '
							$fieldId = $row['field_id'];  //variable to hold DB name content/reduce need for " and '

							if($row['inside_text']!=NULL){
								$insideText = $row['inside_text'];
							}



						// Switch code

							switch ($row['options_target']){
								case NULL:
								echo "<input class='applicant-data form-control' type='text' name='$fieldName' placeholder='$insideText'>";
								break;

								case 'email':
								echo "<input class='applicant-data form-control' type='email' id='email' name='$fieldName' placeholder='Valid email' required autofocus>";
								break;

								case 'textarea':
								echo "</br><textarea class='applicant-data form-control' name='$fieldName' placeholder='$insideText'></textarea>";
								break;

								case 'password':
								echo "<input class='applicant-data form-control' type='".$row['options_target']."' id ='psw1' name='$fieldName' placeholder=Password>";
								echo "<h4> Verify Password </h4>";
								echo "<input class='applicant-data form-control' type='".$row['options_target']."' id ='psw2' placeholder='Verify password'>";
								echo "<p id=report_password></p>";
								break;

								case 'file':
								echo "<input type='file' class='applicant-data' name=" . $fieldName . " id=" . $fieldName . "><br>";
								break;

								case 'question_options':
									//handles multiple choice options reading from question_options table
								$optnSql="SELECT * FROM fields INNER JOIN question_options
								WHERE fields.field_name = '$fieldName' AND question_options.field_name='$fieldName'";
								$optnArray = mysqli_query($appCon, $optnSql);

								while($optnRow=mysqli_fetch_array($optnArray)) {
									$optnInputType = $optnRow['input_type'];
										//$optnFieldId=$optnRow['field_id'];
									$optnId=$optnRow['q_option_id'];
									$optnName=$optnRow['option_name'];
									if ($optnInputType != NULL) {
										echo "<input type='$optnInputType' class='applicant-data' name='$fieldName' value='$optnId'>$optnName";
									}
									echo "</br>";
								}
								break;

								default:
								$targetTable = $row['options_target'];
								$dropDownSql = "SELECT * FROM $targetTable";
								$dropDownArray = mysqli_query($appCon,$dropDownSql);
								echo "</br>";
								echo "<select name='$fieldName' class='applicant-data'>";
								echo "<option>Select a value</option>";
								while($dropDownRow = mysqli_fetch_array($dropDownArray)){
									//echo "test";
									$dropDownValue = $dropDownRow['name'];
									echo "<option value='$dropDownValue'>$dropDownValue</option>";
								}
								echo "</select>";
								break;
							}


							echo "</br>";
							if($row['post_text']!=NULL)
							{
								if($row['is_required']==1){
									echo $row['post_text'] . "*";
								}else{
									echo $row['post_text'];
								}
							}
						}

						?>


					</form>

				</div>

			</div>

		</body>

		</html>
