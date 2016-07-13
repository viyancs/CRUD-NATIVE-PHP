<?php
require_once 'model/Services.php';
require_once 'model/Reporter.php';
require_once 'model/Categories.php';
require_once 'model/NewsCategories.php';
/**
 * Table data News.
 * 
 *  OK I'm using old MySQL driver, so kill me ...
 *  This will do for simple apps but for serious apps you should use PDO.
 */

class News {
    private $services = NULL;
    private $reporter = NULL;
    private $categories = NULL;
    private $newsCategories = NULL;

    public function __construct() {
        $this->services = new Services();
        $this->reporter = new Reporter();
        $this->categories = new Categories();
        $this->newsCategories = new NewsCategories();
    }
    /**
     ** service lane
     ** =========================================================================
     */
    public function getNewsById($id) {
        try {
            $this->services->openDb();
            $res = $this->_selectById($id);
            $this->services->closeDb();
            return $res;
        } catch (Exception $e) {
            $this->services->closeDb();
            throw $e;
        }
    }

    public function getAllNews($order) {
        try {
            $this->services->openDb();
            $res = $this->_selectAll($order);
            $this->services->closeDb();
            return $res;
        } catch (Exception $e) {
            $this->services->closeDb();
            throw $e;
        }
    }

    public function createNewNews($author,$title,$content,$cat) {
        try {
            
            $this->validateNewsParams($author,$cat);
            $this->services->openDb();
            $res = $this->_insert($author,$title,$content);
            $resCat = $this->_insert_cat($cat,$res);
            $this->services->closeDb();
            return $res;
        } catch (Exception $e) {
            $this->services->closeDb();
            throw $e;
        }
    }

    public function updateNews($id,$author,$title,$content,$cat) {
        try {
            
            $this->validateNewsParams($author,$cat);
            $oldCat = $this->newsCategories->getNewsCatByNewsId($id);
            $this->services->openDb();
            $res = $this->_update($id,$author,$title,$content);
            $res = $this->_update_cat($cat,$id,$oldCat->cat_id);
            $this->services->closeDb();
            return $id;
        } catch (Exception $e) {
            $this->services->closeDb();
            throw $e;
        }
    }

    public function delete($id) {
        try {
            $this->services->openDb();
            $res = $this->_delete($id);
            $this->services->closeDb();
            return $id;
        } catch (Exception $e) {
            $this->services->closeDb();
            throw $e;
        }
    }

    private function validateNewsParams( $author,$cat) {
        $errors = array();
        if ( !isset($author) || empty($author) ) {
            $errors[] = 'Author is required';
        }
        else {
            //validation exist
            $rep = $this->reporter->getRepById($author);
            if ( empty($rep) ) {
                $errors[] = 'Reporter Not Found';
            }
        }

        if ( !isset($cat) || empty($cat) ) {
            $errors[] = 'Category is required';
        }
        else {
            //validation exist
            $rep = $this->categories->getCatById($cat);
            if ( empty($rep) ) {
                $errors[] = 'Category Not Found';
            }
        }

        if ( empty($errors) ) {
            return;
        }
        throw new ValidationException($errors);
    }

    /**
     ** gateway lane
     ** =========================================================================
     */
    private function _selectAll($order) {
        if ( !isset($order) ) {
            $order = "name";
        }
        $dbOrder =  mysql_real_escape_string($order);
        $dbres = mysql_query("SELECT n.*,c.name as 'category_name',c.id as 'cat_id',r.nama as 'author_name' FROM news n 
        join reporter r on r.id = n.author_id
        join news_categories nc on nc.news_id = n.id
        join categories c on c.id = nc.cat_id where n.status = 1 ORDER BY $dbOrder ASC");
        
        $News = array();
        while ( ($obj = mysql_fetch_object($dbres)) != NULL ) {
            $News[] = $obj;
        }
        
        return $News;
    }
    
    private function _selectById($id) {
        $dbId = mysql_real_escape_string($id);
        
        $dbres = mysql_query("SELECT n.*,c.name as 'category_name',c.id as 'cat_id',r.nama as 'author_name' FROM news n 
        join reporter r on r.id = n.author_id
        join news_categories nc on nc.news_id = n.id
        join categories c on c.id = nc.cat_id where n.status = 1 and n.id = $dbId");
        
        return mysql_fetch_object($dbres);
		
    }
    
    private function _insert($author,$title,$content) {
        
        $dbAuthor = ($author != NULL)?"'".mysql_real_escape_string($author)."'":'NULL';
        $dbTitle = ($title != NULL)?"'".mysql_real_escape_string($title)."'":'NULL';
        $dbContent = ($content != NULL)?"'".mysql_real_escape_string($content)."'":'NULL';
        
        mysql_query("INSERT INTO news (author_id, title, content,status,created_at, updated_at) VALUES ($dbAuthor,$dbTitle,$dbContent, 1, date(now()), null)");
        return mysql_insert_id();
    }

    private function _insert_cat($catId,$newsId) {
        
        $dbCat = ($catId != NULL)?"'".mysql_real_escape_string($catId)."'":'NULL';
        $dbNews = ($newsId != NULL)?"'".mysql_real_escape_string($newsId)."'":'NULL';
        
        mysql_query("INSERT INTO news_categories (news_id, cat_id,updated_at) VALUES ($dbNews,$dbCat,null)");
        return mysql_insert_id();
    }

    private function _update( $id,$author,$title,$content) {
        
        $dbAuthor = ($author != NULL)?"'".mysql_real_escape_string($author)."'":'NULL';
        $dbTitle = ($title != NULL)?"'".mysql_real_escape_string($title)."'":'NULL';
        $dbContent = ($content != NULL)?"'".mysql_real_escape_string($content)."'":'NULL';

        mysql_query("update news set author_id = $dbAuthor,title = $dbTitle,content = $dbContent, updated_at = date(now()) where id = $id");
    }

    private function _update_cat($catId,$newsId,$oldCat) {
        
        $dbCat = ($catId != NULL)?"'".mysql_real_escape_string($catId)."'":'NULL';
        $dbNews = ($newsId != NULL)?"'".mysql_real_escape_string($newsId)."'":'NULL';
        $dbOldCat = ($oldCat != NULL)?"'".mysql_real_escape_string($oldCat)."'":'NULL';
        
        mysql_query("update news_categories set cat_id = $dbCat ,updated_at = date(now()) where cat_id = $dbOldCat and news_id = $dbNews");

    }
    
    public function _delete($id) {
        $dbId = mysql_real_escape_string($id);
        mysql_query("update news set status = 0, updated_at = date(now()) where id = $id");
    }
   
}

?>
