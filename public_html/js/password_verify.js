$(document).ready(function(){
	//alert("upload");
	var report_password = $('#report_password');

	$('#psw1, #psw2').keyup(function(){
		var password=$('#psw1').val();
		var check_password =$('#psw2').val();


		if (password!="" && password==check_password) {
			report_password.text("Password match!");
			report_password.css("color","green");
		}
		else{
			report_password.text("Password does not match!");
			report_password.css("color","red");
		}
	});
});