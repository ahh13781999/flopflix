<?php


class Sanitizer
{
	
	function __construct($inputText)
	{
		$this->inputText = $inputText;
	}


	public static function stringSanitizer($inputText){
              
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ", "", $inputText);
        $inputText = strtolower($inputText);
        $inputText = ucfirst($inputText);
        return $inputText;
	}

	public static function emailSanitizer($inputText){
              
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ", "", $inputText);
        $inputText = strtolower($inputText);
        $inputText = filter_var($inputText,FILTER_VALIDATE_EMAIL);
        return $inputText;
	}

	public static function passwordSanitizer($inputText){

		$inputText = strip_tags($inputText);
        return $inputText;
	}
}






?>