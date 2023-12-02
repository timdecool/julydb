<?php
namespace App\Controllers;
use App\Controllers\Controller;

/**
 * 
 */

class HomeController extends Controller {
    public function index() {
        $data = [];
        $this->render('./views/template_home.phtml',$data);
    }
}