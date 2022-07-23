<?php

require "./includes/header.php";

if(isset($_GET['id'])){
     $entityId = $_GET['id'];
     $entity = new Entity($conn,$entityId);
     $preview = new PreviewProvider($conn,$_SESSION['userEmail']);
     $showEntity = $preview->createVideoPreview($entity);

     $seasons = new SeasonProvider($conn,$_SESSION['userEmail']);
     $categoryContainer = new CategoryContainer($conn,$_SESSION['userEmail']);
}else{
	 ErrorMessage::show('no id passed into page');
}

?>
   <?php
             echo $showEntity;
   ?>
   <div class="flex flex-col bg-[#141414]">
     
      <?= $seasons->create($entity); ?>
      <?= $categoryContainer->showCagtegory($entity->getAttribute('categoryId'), "You Might Also Like"); ?>

    </div>
  </main>
<script type="text/javascript" src="./src/script.js"></script>
</body>
</html>