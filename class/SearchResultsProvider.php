<?php 

class SearchResultsProvider{
 
      private $conn;
      private $username;
      public $inputText;

      public function __construct($conn, $username)
      {
      	$this->conn = $conn;
      	$this->username = $username;
      }

      public function getResults($inputText)
      {
          $entities = EntityProvider::getSearchEntites($this->conn, $inputText);
          $html = "<div class='flex flex-col items-center justify-center gap-y-10 my-8 h-full'>";
          $html .= $this->getResultsHtml($entities);
          return $html."</div>";
      }

      private function getResultsHtml($entities)
      {
        if(sizeof($entities) == 0){
            return "<h2 class='text-center text-2xl font-semibold'>nothing found!</h2";
        }

        $entitiesHtml = "<div class='self-start ml-6 py-2'>
          <h3 class='text-start text-white font-semibold text-2xl hover:opacity-70'>
             ".sizeof($entities)." Results found : 
          </h3>
        </div>";

        $entitiesHtml .= "<div class='flex flex-row flex-wrap w-full px-4 h-full'>";

        $previewProvider = new PreviewProvider($this->conn, $this->username);

        foreach ($entities as $entity) {
            $entitiesHtml .= $previewProvider->createEntityProviderSquare($entity);
        }

            return $entitiesHtml."</div>";
      }
}
?>