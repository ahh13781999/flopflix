<?php 

require "./includes/header.php";

if(!isset($_SESSION['userEmail'])){
    header("Location: login.php");
}

?>

<?php
          $preview = new PreviewProvider($conn,$_SESSION['userEmail']);
          echo $entity = $preview->createVideoPreview(null);

         $categories = new CategoryContainer($conn,$_SESSION['userEmail']);
?>

   <div class="flex flex-col bg-[#141414]">
      <?= $categories->showAllCategories(null); ?>
   </div>
  </main>
<script type="text/javascript" src="./src/script.js"></script>
</body>
</html>