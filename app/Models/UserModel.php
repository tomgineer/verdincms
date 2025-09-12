<?php namespace App\Models;

use CodeIgniter\Model;

/**
 * ****************************************************
 * User Model — Voralis Core 2026 Edition
 * ****************************************************
 *
 * Handles all operations related to users,
 * including authentication, registration, activation,
 * user group handling, and system-level maintenance.
 *
 * Version : Voralis Core 2026
 * Author  : Tom Papatolis
 * GitHub  : https://github.com/tomgineer/verdincms
 * License : MIT
 *
 * Notes:
 * - Supports unified operations across 'users' and 'members'.
 * - Includes advanced registration and activation mechanisms.
 * - Fully compatible with CodeIgniter 4.x and PHP 8.3.
 *
 * ****************************************************
 */

class UserModel extends Model {

    protected $db;

    public function __construct() {
        $this->db = \Config\Database::connect();
    }

/**
 * Retrieves an active user's data by email address.
 *
 * Queries the `users` table joined with `user_groups` to fetch
 * the user's data along with their group tier. Only users with
 * an active status (`status = 1`) are considered.
 *
 * @param string $email The email address to search for.
 * @return array|null The user data as an associative array, or null if not found.
 */
public function getUserByEmail(string $email): ?array {
    $userData = $this->db->table('users u')
                         ->select('u.*, g.tier')
                         ->join('user_groups g', 'g.id = u.user_group_id')
                         ->where(['u.status' => 1, 'u.email' => $email])
                         ->get()->getRowArray();
    return $userData ?: null;
}

} // ─── End of Class ───