<?php

	if(isset($_GET['control']) AND $_GET['control'] == 'password' ){
		$ctd->set("otp_desc", __( 'Before you can change your password, you must enter the verification code received by e-mail', 'app_rank4win' ) );
		$ctd->set("type_otp", 'password');
		
	}else{
		$ctd->set("otp_desc", __( 'Before you can use your account you must, please enter the verification code received by e-mail', 'app_rank4win' ) );
		$ctd->set("type_otp", 'email');
	}
	
	$ctd->set("placeholder_password", __( 'password', 'app_rank4win' ) );
	$ctd->set("placeholder_confirm_password", __( 'confirm password', 'app_rank4win') );
	$ctd->set("r4w_url_privacy", 'https://rank4win.fr/politique-de-confidentialite/');