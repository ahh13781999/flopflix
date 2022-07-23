<?php

require "./database/conn.php";
require "./config/config.php";
require "./class/Sanitizer.php";
require "./class/Account.php";
require "./class/Constants.php";
require "./middleware/auth.php";
require "./class/PreviewProvider.php";
require "./class/Entity.php";
require "./class/CategoryContainer.php";
require "./class/EntityProvider.php";
require "./class/ErrorMessage.php";
require "./class/SeasonProvider.php";
require "./class/Season.php";
require "./class/Video.php";
require "./class/VideoProvider.php";
require "./class/User.php";



// if(!isset($_SESSION['variable'])){
// 	header("Location: login.php");
// }

?>

<!DOCTYPE html>
<html class="h-full">
<head>
	<meta charset="utf-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/fbd12ab0ab.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="./src/style.css">
	<title>Flopflix</title>
</head>
<body onscroll="scrollNavBar()" class="overflow-y-auto overflow-x-hidden h-full bg-[#141414]">
   <main class="w-full h-full relative"> 
<?php
if(!isset($hideNavBar)){

   include "./includes/navBar.php";
}


?>