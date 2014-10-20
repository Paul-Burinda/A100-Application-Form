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

		<!-- Custom CSS for Application Form -->
		<link href="../public_html/css/form.css" rel="stylesheet">

	   <!-- Custom CSS -->

    	<link href="../public_html/css/simple-sidebar.css" rel="stylesheet">
    </head>

	<body>
		<div id="wrapper">

			<!-- Sidebar -->
			<div id="sidebar-wrapper">
			    <ul class="sidebar-nav">

            	    <li class="sidebar-brand">

	                    <a href="#">  A100 Application  </a>

                	</li>

                	<li>

                    	<a id="userLink" data-section="1" class="selected" href="taiwo_new_applicant.php?section=1">User</a>

                    </li>

                	<li>

                    	<a id="personalLink" section-id="2" href="taiwo_new_applicant.php?section=2">Personal Details</a>

                	</li>

                	<li>

                    	<a id="referLink" section-id="3" href="taiwo_new_applicant.php?section=3">Referrals</a>

                	</li>

                	<li>

                   		<a id="scheduleLink" schedule-id="4" href="taiwo_new_applicant.php?section=4">Schedule Information</a>

                	</li>

                	<li>

                    	<a id="experienceLink" experience-id="5" href="taiwo_new_applicant.php?section=5">Technical Experience</a>

                	</li>

                	<li>

                    	<a id="materialLink" material-id="6" href="taiwo_new_applicant.php?section=6">Supplemental Materials</a>

                	</li>

                	<?php

                		echo "<li><a id='new-db-link' href='taiwo_new_applicant.php?section=99'>Something new</a></li>";
                		/*hope to automate getting section this way*/
                	?>

            	</ul>
            </div>

    	    <!-- /#sidebar-wrapper -->
        	<!-- Page Content -->

        	<!--div id="page-content-wrapper" -->

         	<div class="container-fluid">

				<div class="row">

					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bottomMargin">

						<h1>A100 Application Form</h1>

					</div>

				</div>

				<div class="row">

					<form action="insert.php" method="post" enctype="multipart/form-data">

						<?php

							// put query string params into qs array

							parse_str($_SERVER['QUERY_STRING'], $qsParams);

							error_reporting(-1);

							ini_set("display_errors", "On");

							include "cred_int.php";

							include "../admin/db_conn.php";

							$appform= dbconn();

							$qstnSql = "SELECT * FROM fields INNER JOIN sections 
								ON fields.section_id=sections.section_id
								where fields.section_id = " . $qsParams['section'] . " ORDER BY sections.arrange"; 

							$query = $appform->prepare($qstnSql);

							$query->execute();

							$results=$query->fetchAll(PDO::FETCH_OBJ);

							// print_r($results);


							$arrangeCounter = 0;

							if (isset($_GET['section'])){

								$arrangeCounter =$_GET['section']; 

							}

							$titlehasbeendisplayed = false;

							foreach ($results as $row) {

	                            if ($row->arrange > $arrangeCounter){ 

								    break;

								} else if ($row->arrange < $arrangeCounter){ 

								    continue;

							    }

							

								if(!$titlehasbeendisplayed)	{

									echo "<h3>".$row->section_name. "*</h3>";

									echo "<b>" . $row->section_description. "</b>";

									$titlehasbeendisplayed=true;

								}



								if($row->is_required==1 && $row->post_text==NULL && $row->pre_text!= NULL){

										echo "<h4>" . $row->pre_text . "*</h4>";

									}else{

										echo "<h4>" . $row->pre_text . "</h4>";
									}



								$insideText = "";  

								$fieldName = $row->field_name;  

								$fieldId = $row->field_id;  

								

								if($row->inside_text!=NULL){

									$insideText = $row->inside_text;

								}

								switch ($row->options_target){

									case NULL:

									echo "<input class='form-control' type='text' name='$fieldName' placeholder='$insideText'>";

									break;

									case 'textarea':

									echo "</br><textarea class='form-control' name='$fieldName' placeholder='$insideText'></textarea>";

									break;

									case 'password':

									echo "<input class='form-control' type='".$row->options_target."' name='$fieldName' placeholder='$insideText'>";

									break;

									case 'file':

									echo "<input type='file' name=" . $fieldName . " id=" . $fieldName . "><br>";

									break;

									case 'question_options':

										//handles multiple choice options reading from question_options table

									$optnSql="SELECT * FROM fields INNER JOIN question_options
										WHERE fields.field_name = '$fieldName' AND question_options.field_name='$fieldName'";

									$optnArray = $appform->prepare($optnSql);

									$optnArray->execute();

									foreach($optnArray->fetchAll(PDO::FETCH_OBJ) as $optnRow){

										$optnInputType = $optnRow->input_type;

										//$optnFieldId=$optnRow['field_id'];

										$optnId=$optnRow->q_option_id;

										$optnName=$optnRow->option_name;

										if($optnInputType!=NULL){

											echo "<input type='$optnInputType' name='$fieldName' value='$optnId'>$optnName";	

										}else{

											echo "$optnName <input type='$optnInputType' name='$fieldName'>";
										}

										echo "</br>";

									}

									break;

									default:

									$targetTable = $row->options_target;

									$dropDownSql = "SELECT * FROM $targetTable";

									$dropDownArray=$appform->prepare($dropDownSql);

									$dropDownArray->execute();

									echo "</br>";

									echo "<select name='$fieldName'>";

									echo "<option>Select a value</option>";

									foreach($dropDownArray->fetchAll(PDO::FETCH_OBJ) as $dropDownRow){

										echo "test";

										$dropDownValue = $dropDownRow->name;

										echo "<option value='$dropDownValue'>$dropDownValue</option>";

										}

									echo "</select>";

									break;

								}

								echo "</br>";

								if($row->post_text!=NULL)

								{

									if($row->is_required==1){

										echo $row->post_text. "*";

									}else{

										echo $row->post_text;

									}

								}

							}
						
						?>

						<!-- <div class="css-format"> -->
							<!-- <div class="bootstrap paramss"> -->
								<!-- <button class="css-format"> -->
									<a href="taiwo_new_applicant.php?section=<?php echo $_GET['section'] + 1; ?>"> NEXT </a>
								<!-- </button> -->
								<!-- <button class="css-format"> -->
									<a href="taiwo_new_applicant.php?section=<?php echo $_GET['section'] - 1; ?>"> PREVIOUS </a>
								<!-- </button> -->
							<!-- </div> -->
						<!-- <div class="css-format"> -->	

						<div class="row form">

							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 topMarginSmall bottomMargin">

								<button class="btn btn-lg btn-primary btn-block" type="submit" name ="submit" Value ="submit">

									Submit Completed Application</button>

								<button class="btn btn-lg btn-primary btn-block" type="submit" name ="save" Value ="save">

									Save Application to Complete Later</button>

							</div>

						</div>

					</form>

				</div>

			</div>

    	</div>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

		<!-- Include all compiled plugins (below), or include individual files as needed -->

		<script src="public_html/js/bootstrap.js"></script>

	</body>


    <script src="../public_html/js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->

    <script src="../public_html/js/bootstrap.min.js"></script>

    <script src="../public_html/js/section_form.js"></script>

    <!-- Menu Toggle Script -->

    <script>

    $("#menu-toggle").click(function(e) {

        e.preventDefault();

        $("#wrapper").toggleClass("toggled");

    });

     </script>

</html>

