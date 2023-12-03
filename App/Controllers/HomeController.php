<?php
namespace App\Controllers;
use App\Controllers\Controller;
use App\Models\WordManager;

/**
 * 
 */

class HomeController extends Controller {
    public function index() {

        $manager = new WordManager();
        $lastCreated = $manager->getAll("*","id","LIMIT 5");
        $mostViewed = $manager->getAll("*","views","LIMIT 5");

        $data = ['lastCreated' => $lastCreated, 'mostViewed' => $mostViewed];
        $this->render('./views/template_home.phtml',$data);
    }
}