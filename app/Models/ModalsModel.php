<?php namespace App\Models;

use CodeIgniter\Model;

class ModalsModel extends Model {

    protected $db;

    public function __construct() {
        $this->db = \Config\Database::connect();
    }



} // ─── End of Class ───