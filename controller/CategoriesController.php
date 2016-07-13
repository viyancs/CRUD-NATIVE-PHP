<?php

require_once 'model/Categories.php';

class CategoriesController {
    
    private $categories = NULL;
    
    public function __construct() {
        $this->categories = new Categories();
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
        $categories = $this->categories->getAllCategories($orderby);
        include 'view/categories/index.php';
    }
    
    public function save() {
       
        $title = 'Add new Category';
        $name = '';
        $errors = array();
        
        if ( isset($_POST['form-submitted']) ) {
            
            $name       = isset($_POST['name']) ?   $_POST['name']  :NULL;
            
            try {
                $this->categories->createNewCategory($name);
                $this->redirect('index.php?&r=categories');
                return;
            } catch (ValidationException $e) {
                $errors = $e->getErrors();
            }
        }
        
        include 'view/categories/form.php';
    }

    public function update() {
       
        $title = 'Update Category';
        $name = '';
        $id = isset($_GET['id']) ? $_GET['id']  :NULL;;
        $errors = array();
        if ( !$id ) {
            throw new Exception('Internal error.');
        }

        //get singgle data
        $cat = $this->categories->getCatById($id);
        if ( empty($cat) ) {
            throw new Exception('ID NOT FOUND.');
        }

        //set value
        $name = $cat->name;
        
        if ( isset($_POST['form-submitted']) ) {
            
            $name = isset($_POST['name']) ?   $_POST['name']  :NULL;
            $id = isset($_POST['id']) ?   $_POST['id']  :NULL;
            if ( !$id ) {
                throw new Exception('Internal error.');
            }
            
            try {
                $this->categories->updateCategory($id,$name);
                $this->redirect('index.php?&r=categories');
                return;
            } catch (ValidationException $e) {
                $errors = $e->getErrors();
            }
        }
        
        include 'view/categories/form.php';
    }
    
    public function delete() {
        $id = isset($_GET['id'])?$_GET['id']:NULL;
        if ( !$id ) {
            throw new Exception('Internal error.');
        }
        
        $this->categories->delete($id);
        
        $this->redirect('index.php?&r=categories');
    }
    
    public function show() {
        $id = isset($_GET['id'])?$_GET['id']:NULL;
        if ( !$id ) {
            throw new Exception('Internal error.');
        }
        $category = $this->categories->getCatById($id);
        
        include 'view/categories/view.php';
    }
    
    public function showError($title, $message) {
        include 'view/error.php';
    }
    
}
?>
