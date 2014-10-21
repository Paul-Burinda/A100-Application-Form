<?php

	function ExportCSVStatement() {
		$statement = "SELECT users.user_id, users.first_name, users.last_name, users.email, applicants.major,

		applicants.school_id, applicants.graduation_date, applicants.street_address, applicants.city, applicants.state_id,

		applicants.zipcode, applicants.phone_number, applicants.linkedin, applicants.portfolio, applicants.age_check,
		applicants.legal_status, schedules.weekly_hours, schedules.commitments, experiences.programming_option,
		experiences.work_option, experiences.job_title, experiences.front_end_experience, experiences.lamp_stack_experience,
		experiences.mobile_experience, experiences.cms_experience, experiences.other_experience, materials.additional_info,
		referrals.referral_1, referrals.referral_2, referrals.referral_3, referrals.referral_4, referrals.referral_5,
		referrals.referral_6, referrals.referral_7, referrals.referral_8, referrals.referral_9, referrals.referral_10,
		referrals.referral_11,
		applications.is_complete
		FROM applications
		INNER JOIN applicants ON applications.applicant_id=applicants.applicant_id
		INNER JOIN users ON applicants.user_id=users.user_id
		INNER JOIN referrals ON applications.referral_id=referrals.referral_id
		INNER JOIN schedules ON applications.schedule_id=schedules.schedule_id
		INNER JOIN experiences ON applications.experience_id=experiences.experience_id
		INNER JOIN materials ON applications.material_id=materials.material_id";

		return $statement;
	}

	function AdminTableSQL() {
		$statement = "SELECT applications.application_id, users.first_name, users.last_name, users.email,
		applications.submit_timestamp, applications.is_complete
		FROM applications
		INNER JOIN applicants ON applications.applicant_id=applicants.applicant_id
		INNER JOIN users ON applicants.user_id=users.user_id";

		return $statement;
	}

	function InsertArray(){
		$statement = Array (
			'first_name' => 'John',
			'last_name' => 'Bull',
			'email' => 'John@gmail.com',
			'password' => 'password',
			'school_id' => 'Southern Connecticut State University',
			'major' => 'Computer Science',
			'graduation_date' => 'January 2015',
			'cohort_name' => 'Cohort 6 - Spring 2015',
			'street_address' => '82 Wtharic Ave',
			'city' => 'West Haven',
			'state' => 'Connecticut',
			'zipcode' => 06516,
			'phone_number' => 1234567890,
			'linkedin' => 'NONE',
			'portfolio' => 'NONE',
			'age_check' => 1,
			'legal_status' => 3,
			'referral_1' => 5,
			'referral_2' => 6,
			'referral_3' => 7,
			'referral_4' => 8,
			'referral_5' => 9,
			'referral_6' => 10,
			'referral_7' => 11,
			'referral_8' => 'Bob',
			'referral_9' => 'Fischer',
			'referral_10' => 14,
			'referral_11' => 'Krishna',
			'weekly_hours' => 15,
			'commitments' => 'Unavailable Sundays',
			'programming_option' => 17,
			'work_option' => 22,
			'job_title' => 'Mr. Awesome',
			'front_end_experience' => 'Built Webpage',
			'lamp_stack_experience' => 'Building form',
			'cms_experience' => 'None',
			'mobile_experience' => 'Very little',
			'other_experience' => 'Hire me for relevant info',
			'reference_list' => 'Joe Smith',
			'additional_info' =>' Do it!',
			'submit' => 'submit'
		);
		return $statement;
	}

	function dbTables(){
		$statement = array('applicants', 'identity', 'referrals','schedules', 'experiences', 'materials');
		return $statement;
	}

?>