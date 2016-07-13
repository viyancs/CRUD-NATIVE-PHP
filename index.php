<?php

require_once 'controller/CategoriesController.php';
require_once 'controller/ReporterController.php';
require_once 'controller/NewsController.php';

$op = isset($_GET['r'])?$_GET['r']:NULL;

try {
     	if ( !$op ) {
            $controller = new NewsController();
			$controller->handleRequest();
        } elseif ( $op == 'categories' ) {
            $controller = new CategoriesController();
			$controller->handleRequest();
        } elseif ( $op == 'reporter' ) {
            $controller = new ReporterController();
            $controller->handleRequest();
        } elseif ( $op == 'news' ) {
            $controller = new NewsController();
            $controller->handleRequest();
        } else {
             $this->showError("Page not found", "Page for operation ".$op." was not found!");
    	}
} catch ( Exception $e ) {
    // some unknown Exception got through here, use application error page to display it
    $this->showError("Application error", $e->getMessage());
}


?>
