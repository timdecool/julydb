<?php
namespace App\Controllers;
use App\Controllers\Controller;

/**
 * 
 */

class WordController extends Controller {
    public function index() {
        $data = [];
        $this->render('./views/template_search.phtml',$data);
    }

    public function add() {
        $data = [];
        $this->render('./views/template_addword.phtml',$data);
    }
}