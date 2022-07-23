<?php


Class ErrorMessage {

    public static function show($text)
    {
    	exit("<div class='flex flex-row h-full items-center justify-center'><p class='text-2xl text-white font-semibold capitalize'>".$text."</p></div>");
    }





}