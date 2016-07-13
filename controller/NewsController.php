<?php

require_once 'model/News.php';
require_once 'model/Reporter.php';
require_once 'model/Categories.php';
require_once 'model/NewsCategories.php';

class NewsController {
    
    private $news = NULL;
    private $reporter = NULL;
    private $categories = NULL;
    private $newsCategories = NULL;
    
    public function __construct() {
        $this->news = new News();
        $this->reporter = new Reporter();
        $this->categories = new Categories();
        $this->newsCategories = new NewsCategories();
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
        $news = $this->news->getAllNews($orderby);
        include 'view/News/index.php';
    }
    
    public function save() {
       
        $title = 'Add new News';
        $author = '';
        $content = '';
        $orderby = isset($_GET['orderby'])?$_GET['orderby']:'id';
        $listReporter = $this->reporter->getAllReporter($orderby);
        $listCategory = $this->categories->getAllCategories($orderby);
        $ct_id = '';
        $errors = array();
        
        if ( isset($_POST['form-submitted']) ) {
            
            $author = isset($_POST['author']) ?   $_POST['author']  :NULL;
            $title = isset($_POST['title']) ?   $_POST['title']  :NULL;
            $content = isset($_POST['content']) ?   $_POST['content']  :NULL;
            $cat = isset($_POST['cat']) ?   $_POST['cat']  :NULL;
            
            try {
                $test = $this->news->createNewNews($author,$title,$content,$cat);
                $this->redirect('index.php?&r=news');
                return;
            } catch (ValidationException $e) {
                $errors = $e->getErrors();
            }
        }
        
        include 'view/news/form.php';
    }

    public function update() {
       
        $orderby = isset($_GET['orderby'])?$_GET['orderby']:'id';
        $listReporter = $this->reporter->getAllReporter($orderby);
        $listCategory = $this->categories->getAllCategories($orderby);
        $title = 'Update Category';
        $name = '';
        $id = isset($_GET['id']) ? $_GET['id']  :NULL;;
        $errors = array();
        if ( !$id ) {
            throw new Exception('Internal error.');
        }

        //get singgle data
        $ne = $this->news->getNewsById($id);
        if ( empty($ne) ) {
            throw new Exception('ID NOT FOUND.');
        }

        $ct = $this->newsCategories->getNewsCatByNewsId($ne->id);
        if ( empty($ct) ) {
            throw new Exception('Cat ID NOT FOUND.');
        }

        //set value
        $title = $ne->title;
        $author = $ne->author_id;
        $content = $ne->content;
        $ct_id = $ct->cat_id;

        
        if ( isset($_POST['form-submitted']) ) {
            
            $author = isset($_POST['author']) ?   $_POST['author']  :NULL;
            $title = isset($_POST['title']) ?   $_POST['title']  :NULL;
            $content = isset($_POST['content']) ?   $_POST['content']  :NULL;
            $cat = isset($_POST['cat']) ?   $_POST['cat']  :NULL;
            $id = isset($_POST['id']) ?   $_POST['id']  :NULL;
            if ( !$id ) {
                throw new Exception('Internal error.');
            }
            
            try {
                $this->news->updateNews($id,$author,$title,$content,$cat);
                $this->redirect('index.php?&r=news');
                return;
            } catch (ValidationException $e) {
                $errors = $e->getErrors();
            }
        }
        
        include 'view/news/form.php';
    }
    
    public function delete() {
        $id = isset($_GET['id'])?$_GET['id']:NULL;
        if ( !$id ) {
            throw new Exception('Internal error.');
        }
        
        $this->news->delete($id);
        
        $this->redirect('index.php?&r=news');
    }
    
    public function show() {
        $id = isset($_GET['id'])?$_GET['id']:NULL;
        if ( !$id ) {
            throw new Exception('Internal error.');
        }
        $news = $this->news->getNewsById($id);
        
        include 'view/news/view.php';
    }
    
    public function showError($title, $message) {
        include 'view/error.php';
    }
    
}
?>
