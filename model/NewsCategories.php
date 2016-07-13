<?php
require_once 'model/Services.php';
/**
 * Table data News_Categories.
 * 
 *  OK I'm using old MySQL driver, so kill me ...
 *  This will do for simple apps but for serious apps you should use PDO.
 */

class NewsCategories {
    private $services = NULL;

    public function __construct() {
        $this->services = new Services();
    }
    /**
     ** service lane
     ** =========================================================================
     */
    public function getNewsCatByNewsId($newsId) {
        try {
            $this->services->openDb();
            $res = $this->_selectByNewsId($newsId);
            $this->services->closeDb();
            return $res;
        } catch (Exception $e) {
            $this->services->closeDb();
            throw $e;
        }
    }

   

    /**
     ** gateway lane
     ** =========================================================================
     */
    
    private function _selectByNewsId($newsId) {
        $dbNewsId = mysql_real_escape_string($newsId);
        
        $dbres = mysql_query("SELECT * FROM news_categories WHERE news_id=$dbNewsId");
        
        return mysql_fetch_object($dbres);
		
    }
    
   
}

?>
