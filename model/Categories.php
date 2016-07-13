<?php
require_once 'model/Services.php';
/**
 * Table data Categories.
 * 
 *  OK I'm using old MySQL driver, so kill me ...
 *  This will do for simple apps but for serious apps you should use PDO.
 */

class Categories {
    private $services = NULL;

    public function __construct() {
        $this->services = new Services();
    }
    /**
     ** service lane
     ** =========================================================================
     */
    public function getCatById($id) {
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

    public function getAllCategories($order) {
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

    public function createNewCategory( $name) {
        try {
            $this->services->openDb();
            $this->validateCategoryParams($name);
            $res = $this->_insert($name);
            $this->services->closeDb();
            return $res;
        } catch (Exception $e) {
            $this->services->closeDb();
            throw $e;
        }
    }

    public function updateCategory($id,$name) {
        try {
            $this->services->openDb();
            $this->validateCategoryParams($name);
            $res = $this->_update($id,$name);
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

    private function validateCategoryParams( $name) {
        $errors = array();
        if ( !isset($name) || empty($name) ) {
            $errors[] = 'Name is required';
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
        $dbres = mysql_query("SELECT * FROM categories where status = 1 ORDER BY $dbOrder ASC");
        
        $categories = array();
        while ( ($obj = mysql_fetch_object($dbres)) != NULL ) {
            $categories[] = $obj;
        }
        
        return $categories;
    }
    
    private function _selectById($id) {
        $dbId = mysql_real_escape_string($id);
        
        $dbres = mysql_query("SELECT * FROM categories WHERE id=$dbId");
        
        return mysql_fetch_object($dbres);
		
    }
    
    private function _insert( $name) {
        
        $dbName = ($name != NULL)?"'".mysql_real_escape_string($name)."'":'NULL';
        
        mysql_query("INSERT INTO categories (name, status, created_at, updated_at) VALUES ($dbName, 1, date(now()), null)");
        return mysql_insert_id();
    }

    private function _update( $id,$name) {
        
        $dbName = ($name != NULL)?"'".mysql_real_escape_string($name)."'":'NULL';
        mysql_query("update categories set name = $dbName, updated_at = date(now()) where id = $id");
    }
    
    public function _delete($id) {
        $dbId = mysql_real_escape_string($id);
        mysql_query("DELETE FROM categories WHERE id=$dbId");
    }
   
}

?>
