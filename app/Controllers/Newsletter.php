<?php namespace App\Controllers;
use App\Models\NewsletterModel;
use CodeIgniter\API\ResponseTrait;

class Newsletter extends BaseController {

	use ResponseTrait;

/**
 * Handles AJAX newsletter subscription.
 *
 * Expects JSON { "email": string } and validates the X-CSRF-TOKEN header.
 * Returns a JSON response indicating success or failure.
 *
 * @return \CodeIgniter\HTTP\ResponseInterface
 */
public function subscribe() {
    // Ensure it's an AJAX request
    if (!$this->request->isAJAX()) {
        return $this->failForbidden('Not an AJAX request');
    }

    // Manual CSRF validation (newsletter/* is excluded from the global CSRF filter)
    $security     = service('security');
    $sessionToken = $security->getHash();
    $sentToken    = $this->request->getHeaderLine('X-CSRF-TOKEN'); // from csrf_meta() via JS

    if ($sentToken === '' || ! hash_equals($sessionToken, $sentToken)) {
        return $this->failForbidden('Invalid CSRF token.');
    }

    // JSON body
    $payload = $this->request->getJSON(true) ?? [];
    $email   = (string) ($payload['email'] ?? '');

    $result = (new NewsletterModel())->subscribe($email);

    if (! empty($result['success'])) {
        return $this->response->setJSON([
            'success' => true,
            'message' => $result['message'] ?? 'Subscription successful.',
        ]);
    }

    return $this->response->setJSON([
        'success' => false,
        'message' => $result['message'] ?? 'Subscription failed.',
    ]);
}



} // ─── End of Class ───
