<?php
namespace App\Models;
use App\Models\AbstractManager;

class WordManager extends AbstractManager {

    public function getAll(?string $col="*", $order="id", $limit="") {
        $mots = [];

        $select = 'SELECT '.$col.' FROM mots ORDER BY '.$order.' DESC '.$limit;
        $mots = $this->db->query($select,[],"all");
        return $mots;       
    }

    public function getLastId() {
        $id = 0;
        $select = "SELECT LAST_INSERT_ID()";
        $id = $this->db->query($select, [], "col");
        return $id;
    }

    public function getWord($mot) {
        $motExistant = [];
        $select = "SELECT * FROM mots WHERE mot LIKE ?";
        $motExistant = $this->db->query($select, [$mot], "row");
        return $motExistant;
    }

    public function searchWords($q) {
        $words = [];
        $select = "SELECT * FROM mots WHERE mot LIKE '%".$q."%' ORDER BY id DESC";
        $words = $this->db->query($select,[],"all");
        return $words;
    }

    public function getWordDetails($id) {
        $word = [];
        $select = "SELECT * FROM mots
        INNER JOIN definition ON mots.id = definition.id_mot
        INNER JOIN exemple ON definition.id = exemple.id_definition
        WHERE mots.id=?";
        $word = $this->db->query($select, [$id], "all");
        return $word;
    }

    public function insertWord($mot) {
        $this->db->query("INSERT INTO mots SET mot = ?",[$mot]);
    }

    public function insertDefinition($infos) {
        $this->db->query("INSERT INTO definition SET id_mot = ?, nature = ?, definition = ?",$infos);
    }

    public function insertExample($infos) {
        $this->db->query("INSERT INTO exemple SET id_definition = ?, exemple = ?",$infos);
    }

    public function updateViews($id) {
        $this->db->query("UPDATE mots SET views=views+1 WHERE id=?", [$id]);
    }

    public function updateUser($firstName, $lastName, $mail, $id) {
        $this->db->query("UPDATE mots SET first_name = ?, last_name = ?, mail = ?, date_updated = ? WHERE id=?",[$firstName, $lastName, $mail, date('Y-m-d H:i:s'), $id]);
    }

    public function updateRole($role, $id) {
        $this->db->query("UPDATE mots SET role=?,date_updated=? WHERE id=?",[$role,date('Y-m-d H:i:s'),$id]);
    }

    public function deleteUser($id) {
        $this->db->query("DELETE FROM mots WHERE id=?",[$id]);
    }
}