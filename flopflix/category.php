<?php

require "./includes/header.php";

if(isset($_GET['id'])){
     $categoryId = $_GET['id'];

     $preview = new PreviewProvider($conn,$_SESSION['userEmail']);
     echo $preview->createcategoryPreviewVideo($categoryId);
     $categories = new CategoryContainer($conn,$_SESSION['userEmail']); 
}else{
	 ErrorMessage::show('no id passed into page');
}

?>
   <div class="flex flex-col bg-[#141414]">
      <?= $categories->showCagtegory($categoryId) ?>
    </div>
  </main>
<script type="text/javascript" src="./src/script.js"></script>
</body>
</html>