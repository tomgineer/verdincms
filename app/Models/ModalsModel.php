<?php namespace App\Models;

use CodeIgniter\Model;

class ModalsModel extends Model {

    protected $db;

    public function __construct() {
        $this->db = \Config\Database::connect();
    }

/**
 * Retrieves id and a specified column from the given table.
 *
 * Builds and executes a SELECT query returning all rows,
 * ordered by the given column in ascending order.
 *
 * @param string $table  Name of the database table
 * @param string $column Column to retrieve alongside id
 * @return array<int,array<string,mixed>> Result set as an array of rows
 */
public function ajaxModalFillSelect(string $table, string $column):?array {

    // Check if the table exists
    if (!$this->db->tableExists($table)) {
        return null;
    }

    $results = $this->db->table($table)
                        ->select(['id', $column])
                        ->orderBy($column, 'ASC')
                        ->get()
                        ->getResultArray();
    return $results;
}

/**
 * Retrieve a single database record by ID for use in modal form autofill.
 *
 * @param int    $id    Primary key value of the record to fetch.
 * @param string $table Database table name to query.
 *
 * @return array|null   Associative array of the record if found, otherwise null.
 */
public function ajaxModalFillForm(int $id, string $table):?array {
    return $this->db->table($table)
                    ->where('id', $id)
                    ->get()
                    ->getRowArray();
}

public function ajaxSaveForm(string $table, array $data): array {
    if (empty($data['id'])) {
        return ['success' => false, 'message' => 'Missing ID'];
    }

    $id = $data['id'];
    unset($data['id']);

    // Update
    $success = $this->db->table($table)->where('id', $id)->update($data);

    if (!$success) {
        return [
            'success' => false,
            'message' => 'Update failed',
        ];
    }

    return [
        'success' => true,
        'message' => 'Record updated successfully',
        'id' => $id,
    ];
}


} // ─── End of Class ───