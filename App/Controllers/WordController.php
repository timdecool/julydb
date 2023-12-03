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

            header('Location:?page=word&method=details&id='.$idMot);
        }

        $data = ['errors' => $errors];
        $this->render('./views/template_addword.phtml',$data);
    }

    public function details() {
        if(isset($_GET['id'])) {
            $wordId = $_GET['id'];
            $manager = new WordManager();
            $manager->updateViews($wordId);
            $wordDetails = $manager-> getWordDetails($wordId);
            $definitions = [];             
            $id_def = 0;
            foreach($wordDetails as $d) {
                if($d["id_definition"] != $id_def) {
                    $id_def = $d["id_definition"];
                    $definitions[$id_def]["nature"] = $d["nature"];
                    $definitions[$id_def]["definition"] = $d["definition"];
                }
                $definitions[$id_def]["exemples"][] = $d["exemple"];

            }

            $data = ["mot" => $wordDetails[0]['mot'],"definitions"=>$definitions, "wordDetails" => $wordDetails];
            $this->render('./views/template_worddetails.phtml',$data);
        }
        else {
            header('Location:?page=home');
        }
        
    }

    public function search() {
        $manager = new WordManager();
        $words = $manager->searchWords($_GET['query']);
        $data = ["words" => $words];
        $this->render('./views/template_search.phtml',$data);
    }
}