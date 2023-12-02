<?php
namespace App\Controllers;
use App\Controllers\Controller;
use App\Models\WordManager;

/**
 * 
 */

class WordController extends Controller {
    public function index() {
        $data = [];
        $this->render('./views/template_search.phtml',$data);
    }

    public function add() {
        $errors = [];
        $idMot = 0;

        if(isset($_POST['nouveauMot'])) {
            $manager = new WordManager();
            $mot = $manager->getWord($_POST['mot']);
            if(empty($mot)) {
                $manager->insertWord($_POST['mot']);
                $idMot = $manager->getLastId();
            } else {
                $idMot = $mot['id'];
            }

            foreach($_POST['acceptions'] as $a) {
                $manager->insertDefinition([$idMot,$a['nature'],$a['definition']]);
                $idDef = $manager->getLastId();
                foreach($a['exemples'] as $e) {
                    if(!empty($e)) {
                        $manager->insertExample([$idDef,$e]);
                    }
                }
            }
        }

        $data = ['errors' => $errors];
        $this->render('./views/template_addword.phtml',$data);
    }
}