<?php
namespace App\Models;
use App\Services\Database;

abstract class AbstractManager {
    protected $db;
    
    public function __construct() {
        $this->db = new Database();
    }
}