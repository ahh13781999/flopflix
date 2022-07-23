<?php 
require "../database/conn.php";
require "../class/SearchResultsProvider.php";
require "../class/EntityProvider.php";
require "../class/Entity.php";
require "../class/PreviewProvider.php";

if(isset($_POST['term']) && isset($_POST['username'])){
     $srp = new SearchResultsProvider($conn,$_POST['username']);
     echo $srp->getResults($_POST['term']);
     
}else{
 	echo "No term or username passed into file";
}



?>