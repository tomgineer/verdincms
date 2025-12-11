<?php namespace App\Models;

use CodeIgniter\Model;

class NewsletterModel extends Model {

    protected $db;

    public function __construct() {
        $this->db = \Config\Database::connect();
    }

/**
 * Subscribe a user to the newsletter.
 *
 * Validates and sanitizes the provided email address,
 * checks for duplicates, generates a confirmation token,
 * and inserts a new record into the `newsletter` table.
 *
 * @param string $email User's email address.
 * @return array ['success' => bool, 'message' => string]
 */
public function subscribe(string $email): array {
    $email = trim(strtolower($email));

    // Validate email format
    if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return [
            'success' => false,
            'message' => 'Μη έγκυρη διεύθυνση email.'
        ];
    }

    // Check if already subscribed
    $exists = $this->db->table('newsletter')
                       ->where('email', $email)
                       ->countAllResults();

    if ($exists > 0) {
        return [
            'success' => false,
            'message' => 'Αυτό το email είναι ήδη εγγεγραμμένο.'
        ];
    }

    // Generate confirmation token
    $token = bin2hex(random_bytes(16)); // 32-character secure token

    // Insert into DB
    $inserted = $this->db->table('newsletter')->insert([
        'email' => $email,
        'confirmation_token' => $token,
        'subscribed_at' => date('Y-m-d H:i:s'),
        'confirmed' => 0,
        'unsubscribed' => 0
    ]);

    if (! $inserted) {
        return [
            'success' => false,
            'message' => 'Η εγγραφή απέτυχε. Προσπάθησε ξανά.'
        ];
    }

    // TODO: Send confirmation email
    // e.g. $this->sendConfirmationEmail($email, $token);

    return [
        'success' => true,
        'message' => 'Ευχαριστούμε για την εγγραφή! Έλεγξε το email σου για επιβεβαίωση.'
    ];
}



} // ─── End of Class ───