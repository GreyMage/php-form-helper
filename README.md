php-form-helper
===============

This code is intended for personal use, however if ou find it useful, please conider donating!

[![Donate](https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=2V9VFPX38V3A2)

Example Implementation
	
	$fb = new formBuilder();
	$fb->add(new formElement("Company Name"));
	$fb->add(new formElement("Company Address"));
	$fb->add(new formElement("Company Contact"));

	$fg = new formGroup("Primary Industry");
	$cbdeault = array("type"=>"checkbox");
	$fg->add(new formElement("Screen printing","op1",$cbdeault));
	$fg->add(new formElement("Embroidery","op2",$cbdeault));
	$fg->add(new formElement("Sign making","op3",$cbdeault));
	$fg->add(new formElement("Awards","op4",$cbdeault));
	$fg->add(new formElement("Sublimation","op5",$cbdeault));
	$fg->add(new formElement("Direct to garment","op6",$cbdeault));
	$fg->add(new formElement("Promotional items","op7",$cbdeault));
	$fg->add(new formElement("Other","op8",$cbdeault));
	$fb->add($fg);

	$fb->add(new formElement("Whatever"));
	$fb->add(new formElement("You"));
	$fb->add(new formElement("Want"));
	$fb->add(new formElement("Really"));

	$fb->addAsButton(new formElement("Submit"));

	echo $fb->getHTML();