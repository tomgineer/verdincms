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

    // Send confirmation email
    $this->sendConfirmationEmail($email, $token);

    return [
        'success' => true,
        'message' => 'Ευχαριστούμε για την εγγραφή! Έλεγξε το email σου για επιβεβαίωση.'
    ];
}

/**
 * Send confirmation email with unique token (HTML version).
 *
 * @param string $email
 * @param string $token
 * @return bool
 */
protected function sendConfirmationEmail(string $email, string $token): bool {
    // Build confirmation link
    $confirmUrl = site_url('newsletter/confirm?token=' . urlencode($token) . '&email=' . urlencode($email));

    $emailService = \Config\Services::email();
    $config       = config('Email');

    // Use values from Email.php directly
    $fromEmail = $config->fromEmail;
    $fromName  = $config->fromName;

    $emailService->setFrom($fromEmail, $fromName);
    $emailService->setTo($email);
    $emailService->setSubject('Επιβεβαίωση εγγραφής στο newsletter του Χάρτινου Τσίρκου');

    // HTML message
    $message = '
        <html lang="el">
        <head>
            <meta charset="UTF-8">
            <style>
                body { font-family: Arial, sans-serif; background-color: #f9f9f9; color: #222; }
                .container { max-width: 600px; margin: 20px auto; background: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
                h1 { color: #333; font-size: 20px; }
                p { line-height: 1.6; }
                a.button {
                    display: inline-block;
                    padding: 10px 20px;
                    margin-top: 15px;
                    background: #007bff;
                    color: #fff !important;
                    text-decoration: none;
                    border-radius: 5px;
                }
                a.button:hover { background: #0056b3; }
                .footer { font-size: 12px; color: #777; margin-top: 20px; }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>Επιβεβαίωση εγγραφής στο Newsletter</h1>
                <p>Γεια σου,</p>
                <p>Σε ευχαριστώ που έκανες εγγραφή στο newsletter μου. Για να ολοκληρώσεις την εγγραφή σου, κάνε κλικ στο παρακάτω κουμπί:</p>
                <p><a href="' . $confirmUrl . '" class="button">Επιβεβαίωση Εγγραφής</a></p>
                <p>Αν δεν έκανες εσύ αυτή την εγγραφή, μπορείς να αγνοήσεις αυτό το μήνυμα.</p>
                <p class="footer">Με εκτίμηση,<br>' . esc($fromName) . '</p>
            </div>
        </body>
        </html>
    ';

    $emailService->setMessage($message);

    if (! $emailService->send()) {
        log_message('error', 'Newsletter confirmation email failed: ' . $emailService->printDebugger(['headers', 'subject']));
        return false;
    }

    return true;
}

/**
 * Confirm a newsletter subscription using token and email.
 *
 * @param string $email
 * @param string $token
 * @return array ['success' => bool, 'message' => string]
 */
public function confirmSubscription(string $email, string $token): array {
    $email = trim(strtolower($email));
    $token = trim($token);

    if ($email === '' || $token === '') {
        return [
            'success' => false,
            'message' => 'Μη έγκυρα δεδομένα επιβεβαίωσης.'
        ];
    }

    $builder = $this->db->table('newsletter');

    // Find subscriber by email + token + not confirmed
    $subscriber = $builder->where('email', $email)
                          ->where('confirmation_token', $token)
                          ->where('confirmed', 0)
                          ->get()
                          ->getRowArray();

    if (! $subscriber) {
        return [
            'success' => false,
            'message' => 'Ο σύνδεσμος επιβεβαίωσης δεν είναι έγκυρος ή έχει ήδη χρησιμοποιηθεί.'
        ];
    }

    // Generate unsubscribe token for later use in emails
    $unsubscribeToken = bin2hex(random_bytes(16)); // 32-char secure token

    // Update confirmation
    $updated = $builder->where('id', $subscriber['id'])->update([
        'confirmed'          => 1,
        'confirmed_at'       => date('Y-m-d H:i:s'),
        'confirmation_token' => null,
        'unsubscribe_token'  => $unsubscribeToken,
        'unsubscribed'       => 0,
        'unsubscribed_at'    => null,
    ]);

    if (! $updated) {
        return [
            'success' => false,
            'message' => 'Η επιβεβαίωση απέτυχε. Προσπάθησε ξανά αργότερα.'
        ];
    }

    return [
        'success' => true,
        'message' => 'Η εγγραφή σου στο newsletter επιβεβαιώθηκε με επιτυχία. Σε ευχαριστούμε!'
    ];
}

/**
 * Unsubscribe a user from the newsletter using a unique token.
 *
 * Used by the unsubscribe link in each email:
 * e.g. https://your-site.tld/newsletter/unsubscribe?token=...
 *
 * @param string $token Unique unsubscribe token.
 * @return array ['success' => bool, 'message' => string, 'email' => string|null]
 */
public function unsubscribeByToken(string $token): array {
    $token = trim($token);

    if ($token === '') {
        return [
            'success' => false,
            'message' => 'Μη έγκυρος σύνδεσμος διαγραφής.',
            'email'   => null,
        ];
    }

    $builder = $this->db->table('newsletter');

    // Find subscriber by token and ensure they are not already unsubscribed
    $subscriber = $builder->where('unsubscribe_token', $token)
                          ->where('unsubscribed', 0)
                          ->get()
                          ->getRowArray();

    if (! $subscriber) {
        return [
            'success' => false,
            'message' => 'Ο σύνδεσμος διαγραφής δεν είναι έγκυρος ή έχει ήδη χρησιμοποιηθεί.',
            'email'   => null,
        ];
    }

    // Mark as unsubscribed
    $updated = $builder->where('id', $subscriber['id'])->update([
        'unsubscribed'      => 1,
        'unsubscribed_at'   => date('Y-m-d H:i:s'),
        'unsubscribe_token' => null, // optional: make the token one-time use
    ]);

    if (! $updated) {
        return [
            'success' => false,
            'message' => 'Η διαδικασία διαγραφής απέτυχε. Προσπάθησε ξανά αργότερα.',
            'email'   => $subscriber['email'] ?? null,
        ];
    }

    return [
        'success' => true,
        'message' => 'Η διεύθυνση email διαγράφηκε με επιτυχία από το newsletter.',
        'email'   => $subscriber['email'],
    ];
}

// protected function buildNewsletterHtml(string $unsubscribeUrl): string {
//     return '
//     <html>
//         <head><meta charset="UTF-8"></head>
//         <body style="font-family: Arial, sans-serif; background:#f8f8f8; color:#333; padding:20px;">
//             <div style="max-width:600px; margin:auto; background:#fff; border-radius:8px; padding:20px;">
//                 <h2 style="color:#222;">🎪 Νέο από το Χάρτινο Τσίρκο</h2>
//                 <p>...your content here...</p>

//                 ' . $this->newsletterFooter($unsubscribeUrl) . '
//             </div>
//         </body>
//     </html>';
// }

// protected function newsletterFooter(string $unsubscribeUrl): string {
//     return '
//         <hr style="border:none; border-top:1px solid #ddd; margin:30px 0;">
//         <p style="font-size:13px; color:#777; line-height:1.5; text-align:center;">
//             Λαμβάνεις αυτό το email επειδή έχεις εγγραφεί στο newsletter μας.<br>
//             Αν δεν επιθυμείς να λαμβάνεις πλέον ενημερώσεις,
//             μπορείς να <a href="' . esc($unsubscribeUrl) . '" style="color:#555;">διαγραφείς εδώ</a>.
//         </p>
//         <p style="font-size:11px; color:#999; text-align:center; margin-top:10px;">
//             &copy; ' . date('Y') . ' Χάρτινο Τσίρκο — Όλα τα δικαιώματα διατηρούνται.
//         </p>';
// }

} // ─── End of Class ───