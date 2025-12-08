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

/**
 * Inserts or updates a record via AJAX.
 * Hashes non-empty passwords and preserves existing ones if empty.
 *
 * @param string $table Target database table name.
 * @param array  $data  Form data including 'id'.
 * @return array Result with success, message, id, and mode.
 */
public function ajaxSaveForm(string $table, array $data): array {
    $builder = $this->db->table($table);

    // Grab id and remove it from the data array
    $id = $data['id'] ?? null;
    unset($data['id']);

    // Handle password hashing
    if (isset($data['password'])) {
        $password = trim($data['password']);

        if ($password !== '') {
            // hash only non-empty passwords
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        } else {
            // empty password field → don't overwrite existing one
            unset($data['password']);
        }
    }

    // Automatically set modified timestamp if the field exists
    if (array_key_exists('modified', $data)) {
        $data['modified'] = date('Y-m-d H:i:s');
    }

    // Automatically set created timestamp if it's a new record
    if ($id === 'new' && array_key_exists('created', $data)) {
        $data['created'] = date('Y-m-d H:i:s');
    }

    // NEW RECORD: id is "new"
    if ($id === 'new') {
        $success = $builder->insert($data);

        if (!$success) {
            return [
                'success' => false,
                'message' => 'Insert failed',
            ];
        }

        $newId = $this->db->insertID();

        return [
            'success' => true,
            'message' => 'Record created successfully',
            'id'      => $newId,
            'mode'    => 'insert',
        ];
    }

    // EXISTING RECORD: id is something else → UPDATE
    $success = $builder->where('id', $id)->update($data);

    if (!$success) {
        return [
            'success' => false,
            'message' => 'Update failed',
        ];
    }

    return [
        'success' => true,
        'message' => 'Record updated successfully',
        'id'      => $id,
        'mode'    => 'update',
    ];
}


} // ─── End of Class ───