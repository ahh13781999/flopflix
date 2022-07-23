<?php
Class CategoryContainer {
       
      private $conn, $userEmail;

      public function __construct($conn,$userEmail)
      {
      	 $this->conn = $conn;
      	 $this->userEmail = $userEmail;
      }

      public function showAllCategories()
      {
      	$query = $this->conn->prepare("SELECT * FROM categories");
      	$query->execute();

        $html = "<div class='flex flex-col gap-y-10 my-8'>";
      	while($row = $query->fetch(PDO::FETCH_ASSOC)){
          $html .= $this->getCategoryHtml($row, null, true, true);
      	}
      	return $html."</div>";
      }

      public function showTVShowCategories()
      {
        $query = $this->conn->prepare("SELECT * FROM categories");
        $query->execute();

        $html = "<div class='flex flex-col gap-y-10 my-8'>
                  <h1 class='text-3xl text-[#e5e5e5] font-semibold ml-6 my-4'>TV Shows</h1>";
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
          $html .= $this->getCategoryHtml($row, null, true, false);
        }
        return $html."</div>";
      }

      public function showMoviesCategories()
      {
        $query = $this->conn->prepare("SELECT * FROM categories");
        $query->execute();

        $html = "<div class='flex flex-col gap-y-10 my-8'>
                  <h1 class='text-3xl text-[#e5e5e5] font-semibold ml-6 my-4'>Movies</h1>";
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
          $html .= $this->getCategoryHtml($row, null, false, true);
        }
        return $html."</div>";
      }

      public function showCagtegory($categoryId, $title = null)
      {
          $query = $this->conn->prepare("SELECT * FROM categories WHERE id=:id");
          $query->bindValue(":id",$categoryId);
          $query->execute();

         $html = "<div class='flex flex-col gap-y-10 my-8'>";
          while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
              $html .= $this->getCategoryHtml($row, $title, true, true);
          }
        return $html."</div>";
      }

      private function getCategoryHtml($sqlData, $title, $tvShows, $movies)
      {
      	$categoryId = $sqlData['id'];
      	$title = $title == null ? $sqlData['name'] : $title;

        if($tvShows && $movies){
           $entities = EntityProvider::getEntites($this->conn, $categoryId, 30);
        }
        else if($tvShows) {
          $entities = EntityProvider::getTVShowEntites($this->conn, $categoryId, 30);
        }
        else {
          $entities = EntityProvider::getMoviesEntites($this->conn, $categoryId, 30);
        }

        if(sizeof($entities) == 0){
            return;
        }

        $entitiesHtml = "<div class='ml-6'>
          <h3 class='text-white font-semibold text-2xl hover:opacity-70'>
             <a href='category.php?id=$categoryId'>$title</a>
          </h3>
        </div>";

        $entitiesHtml .= "<div class='flex flex-row flex-nowrap w-full overflow-x-scroll px-4'>";

        $previewProvider = new PreviewProvider($this->conn, $this->userEmail);

        foreach ($entities as $entity) {
            $entitiesHtml .= $previewProvider->createEntityProviderSquare($entity);
        }

      	return $entitiesHtml."</div>";

      }

}
?>