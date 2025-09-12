<?php namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\SystemCore;

/**
 * ****************************************************
 * Admin Model — Voralis Core 2026 Edition
 * ****************************************************
 *
 * Manages all administrative operations related to user and system control,
 * including dashboard data, admin-only tools, maintenance utilities,
 * and quick system-level queries.
 *
 * Version : Voralis Core 2026
 * Author  : Tom Papatolis
 * GitHub  : https://github.com/tomgineer/verdincms
 * License : MIT
 *
 * Notes:
 * - Built for administrative use only, not exposed to public controllers.
 * - Optimized for security and performance.
 * - Fully compatible with CodeIgniter 4.x and PHP 8.3.
 *
 * ****************************************************
 */

class AdminModel extends Model {

    protected $db;

    public function __construct() {
        $this->db = \Config\Database::connect();
    }

/**
 * Retrieves a specific column value from a block by its alias.
 *
 * @param string $alias  The alias of the block.
 * @param string $column The column to retrieve from the block record.
 * @return string The value of the specified column, or an empty string if not found.
 */
private function getBlockPart(string $alias, string $column): string {
    $block = $this->db->table('blocks')
                      ->where('alias', $alias)
                      ->get()
                      ->getRow();

    return $block->{$column} ?? '';
}

/**
 * Sends notification emails to active members about a published post.
 *
 * @param int $post_id Post ID to notify members about.
 * @return string Composed message or error notice.
 */
public function sendNotificationEmails(int $post_id = 0): string {
    $post = $this->getSinglePost($post_id);
    if (($post['status'] ?? 0) !== 1) {
        return 'Post is not Published!';
    }

    $placeholders = [
        '{post_title}'     => $post['title'],
        '{post_subtitle}'  => $post['subtitle'],
        '{post_link}'      => site_url('post/' . $post_id),
        '{company_name}'   => setting('company.name'),
        '{company_email}'  => setting('company.email'),
        '{company_website}'=> base_url(),
        '{members_only}'   => ($post['accessibility'] ?? 0) != 0 ? '<b>This post is for MEMBERS ONLY.</b>' : '',
        '{hr}'             => '<hr>',
    ];

    $email = \Config\Services::email();
    $msg   = str_replace(
        array_keys($placeholders),
        array_values($placeholders),
        $this->getBlockPart('notify_members', 'body')
    );

    $sent = $email->setFrom($placeholders['{company_email}'], $placeholders['{company_name}'])
                  ->setTo($placeholders['{company_email}'])
                  ->setBCC($this->getMembersEmails())
                  ->setSubject($this->getBlockPart('notify_members', 'title'))
                  ->setMessage($msg)
                  ->send();

    if (! $sent) {
        log_message('error', 'Failed to send notification email for post ID ' . $post_id);
    }

    return $msg;
}

} // ─── End of Class ───