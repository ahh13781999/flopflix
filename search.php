<?php 
require "./includes/header.php";

if(!isset($_SESSION['userEmail'])){
    header("Location: login.php");
}

?>
<div class="flex flex-col py-44 px-24 gap-y-8 h-full">
<div id="textboxContainer">
	<input onkeyup="searchInputFun(this,'<?= $_SESSION["userEmail"]; ?>')" type="text" id="searchInput" name="" placeholder="Search for Something" class="border-white w-full md:w-2/3 lg:w-1/2 bg-transparent border-2 h-16 border-[#dedede] pl-4 text-white rounded text-lg">
</div>
<div id="results" class="text-white h-full overflow-y-auto">

	
</div>
</div>
 </main>
<script type="text/javascript" src="./src/script.js"></script>
</body>
</html>