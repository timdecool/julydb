<?php 
namespace App\Services;

/**
 * Simple class to get the page to insert in the general layout based on $_GET['page']
 **/

class Router {
    // Properties
    private $page;
    private $action;
    private $class;

    // Constructor
    public function __construct() {
        $this->setPage();
        $this->setClass();        
        $this->setAction();
    }

    // Methods
    public function setPage() {
        $this->page = isset($_GET['page']) && file_exists('./App/Controllers/'.ucfirst($_GET['page']).'Controller.php') ? strtolower($_GET['page']):'home';
    }
    
    public function getPage() {
        return $this->page;
    }

    public function setAction() {
        $this->action = isset($_GET['method']) && method_exists($this->getClass(),$_GET['method']) ? strtolower($_GET['method']):'index';
    }

    public function getAction() {
        return $this->action;
    }

    public function setClass() {
        $this->class='App\Controllers\\'.ucfirst($this->getPage()).'Controller';
    }

    public function getClass() {
        return $this->class;
    }

    public function run() {
        // Détermination de la route ?page
        $action = $this->getAction();
        $controllerName = $this->getClass();
        $controller = new $controllerName();
        $controller->$action();
    }
}