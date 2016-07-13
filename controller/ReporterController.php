<?php

require_once 'model/Reporter.php';

class ReporterController {
    
    private $reporter = NULL;
    
    public function __construct() {
        $this->reporter = new Reporter();
    }
    
    public function redirect($location) {
        header('Location: '.$location);
    }
    
    public function handleRequest() {
        $op = isset($_GET['op'])?$_GET['op']:NULL;
        try {
            if ( !$op || $op == 'list' ) {
                $this->lists();
            } elseif ( $op == 'create' ) {
                $this->save();
            } elseif ( $op == 'update' ) {
                $this->update();
            } elseif ( $op == 'delete' ) {
                $this->delete();
            } elseif ( $op == 'show' ) {
                $this->show();
            } else {
                $this->showError("Page not found", "Page for operation ".$op." was not found!");
            }
        } catch ( Exception $e ) {
            // some unknown Exception got through here, use application error page to display it
            $this->showError("Application error", $e->getMessage());
        }
    }
    
    public function lists() {
        $orderby = isset($_GET['orderby'])?$_GET['orderby']:'id';
        $reporter = $this->reporter->getAllreporter($orderby);
        include 'view/reporter/index.php';
    }
    
    public function save() {
       
        $title = 'Add new Reporter';
        $name = '';
        $email = '';
        $alamat = '';
        $errors = array();
        
        if ( isset($_POST['form-submitted']) ) {
            
            $name = isset($_POST['name']) ?   $_POST['name']  :NULL;
            $email = isset($_POST['email']) ?   $_POST['email']  :NULL;
            $alamat = isset($_POST['alamat']) ?   $_POST['alamat']  :NULL;
            
            try {
                $this->reporter->createNewReporter($name,$email,$alamat);
                $this->redirect('index.php?&r=reporter');
                return;
            } catch (ValidationException $e) {
                $errors = $e->getErrors();
            }
        }
        
        include 'view/reporter/form.php';
    }

    public function update() {
       
        $title = 'Update reporter';
        $name = '';
        $id = isset($_GET['id']) ? $_GET['id']  :NULL;;
        $errors = array();
        if ( !$id ) {
            throw new Exception('Internal error.');
        }

        //get singgle data
        $cat = $this->reporter->getRepById($id);
        if ( empty($cat) ) {
            throw new Exception('ID NOT FOUND.');
        }

        //set value
        $name = $cat->nama;
        $email = $cat->email;
        $alamat = $cat->alamat;
        
        if ( isset($_POST['form-submitted']) ) {
            
            $name = isset($_POST['name']) ?   $_POST['name']  :NULL;
            $email = isset($_POST['email']) ?   $_POST['email']  :NULL;
            $alamat = isset($_POST['alamat']) ?   $_POST['alamat']  :NULL;
            
            $id = isset($_POST['id']) ?   $_POST['id']  :NULL;
            if ( !$id ) {
                throw new Exception('Internal error.');
            }
            
            try {
                $this->reporter->updateReporter($id,$name,$email,$alamat);
                $this->redirect('index.php?&r=reporter');
                return;
            } catch (ValidationException $e) {
                $errors = $e->getErrors();
            }
        }
        
        include 'view/reporter/form.php';
    }
    
    public function delete() {
        $id = isset($_GET['id'])?$_GET['id']:NULL;
        if ( !$id ) {
            throw new Exception('Internal error.');
        }
        
        $this->reporter->delete($id);
        
        $this->redirect('index.php?&r=reporter');
    }
    
    public function show() {
        $id = isset($_GET['id'])?$_GET['id']:NULL;
        if ( !$id ) {
            throw new Exception('Internal error.');
        }
        $reporter = $this->reporter->getRepById($id);
        
        include 'view/reporter/view.php';
    }
    
    public function showError($title, $message) {
        include 'view/error.php';
    }
    
}
?>
