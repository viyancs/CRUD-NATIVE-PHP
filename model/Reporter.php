<?php
require_once 'model/Services.php';
/**
 * Table data Reporter.
 * 
 *  OK I'm using old MySQL driver, so kill me ...
 *  This will do for simple apps but for serious apps you should use PDO.
 */

class Reporter {
    private $services = NULL;

    public function __construct() {
        $this->services = new Services();
    }
    /**
     ** service lane
     ** =========================================================================
     */
    public function getRepById($id) {
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

    public function getAllReporter($order) {
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

    public function createNewReporter($name,$email,$alamat) {
        try {
            $this->services->openDb();
            $this->validateReporterParams($name,$email);
            $res = $this->_insert($name,$email,$alamat);
            $this->services->closeDb();
            return $res;
        } catch (Exception $e) {
            $this->services->closeDb();
            throw $e;
        }
    }

    public function updateReporter($id,$name,$email,$alamat) {
        try {
            $this->services->openDb();
            $this->validateReporterParams($name,$email);
            $res = $this->_update($id,$name,$email,$alamat);
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

    private function validateReporterParams( $name,$email) {
        $errors = array();
        if ( !isset($name) || empty($name) ) {
            $errors[] = 'Name is required';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email Not Valid';
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
        $dbres = mysql_query("SELECT * FROM Reporter where status = 1 ORDER BY $dbOrder ASC");
        
        $Reporter = array();
        while ( ($obj = mysql_fetch_object($dbres)) != NULL ) {
            $Reporter[] = $obj;
        }
        
        return $Reporter;
    }
    
    private function _selectById($id) {
        $dbId = mysql_real_escape_string($id);
        
        $dbres = mysql_query("SELECT * FROM Reporter WHERE id=$dbId");
        
        return mysql_fetch_object($dbres);
		
    }
    
    private function _insert($name,$email,$alamat) {
        
        $dbName = ($name != NULL)?"'".mysql_real_escape_string($name)."'":'NULL';
        $dbEmail = ($email != NULL)?"'".mysql_real_escape_string($email)."'":'NULL';
        $dbAlamat = ($alamat != NULL)?"'".mysql_real_escape_string($alamat)."'":'NULL';
        
        mysql_query("INSERT INTO Reporter (nama, email, alamat,status,created_at, updated_at) VALUES ($dbName,$dbEmail,$dbAlamat, 1, date(now()), null)");
        return mysql_insert_id();
    }

    private function _update( $id,$name,$email,$alamat) {
        
        $dbName = ($name != NULL)?"'".mysql_real_escape_string($name)."'":'NULL';
        $dbEmail = ($email != NULL)?"'".mysql_real_escape_string($email)."'":'NULL';
        $dbAlamat = ($alamat != NULL)?"'".mysql_real_escape_string($alamat)."'":'NULL';

        mysql_query("update Reporter set nama = $dbName,email = $dbEmail,alamat = $dbAlamat, updated_at = date(now()) where id = $id");
    }
    
    public function _delete($id) {
        $dbId = mysql_real_escape_string($id);
        mysql_query("DELETE FROM Reporter WHERE id=$dbId");
    }
   
}

?>
