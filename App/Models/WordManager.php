<?php
namespace App\Models;
use App\Models\AbstractManager;

class WordManager extends AbstractManager {
    public function getAll(?string $col="*") {
        $mots = [];
        $select = 'SELECT '.$col.' FROM mots ORDER BY id DESC';
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

    public function insertWord($mot) {
        $this->db->query("INSERT INTO mots SET mot = ?",[$mot]);
    }

    public function insertDefinition($infos) {
        $this->db->query("INSERT INTO definition SET id_mot = ?, nature = ?, definition = ?",$infos);
    }

    public function insertExample($infos) {
        $this->db->query("INSERT INTO exemple SET id_definition = ?, exemple = ?",$infos);
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