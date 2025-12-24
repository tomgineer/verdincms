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

/**
 * Handles newsletter subscription confirmation.
 *
 * Retrieves the token and email from the query string,
 * verifies the subscription via the NewsletterModel,
 * and returns the confirmation result view.
 *
 * @return \CodeIgniter\HTTP\Response|string
 */
public function confirm() {
    $request = service('request');
    $token = (string) $request->getGet('token');
    $email = (string) $request->getGet('email');

    $model  = new NewsletterModel();
    $result = $model->confirmSubscription($email, $token);

    // Merge arrays using spread syntax (PHP 7.4+)
    $data = [
        'success' => $result['success'],
        'message' => $result['message'],
    ];

    return view('frontend/pages/newsletter_set', $data);
}

/**
 * Handles newsletter unsubscribe via token link.
 *
 * Reads the token from the query string, delegates the logic
 * to the NewsletterModel, and returns a result view.
 *
 * @return \CodeIgniter\HTTP\Response|string
 */
public function unsubscribe() {
    $request = service('request');
    $token   = (string) $request->getGet('token');

    $model  = new NewsletterModel();
    $result = $model->unsubscribeByToken($token);

    // Merge base controller data (if any) with unsubscribe result
    $data = [
        'success' => $result['success'] ?? false,
        'message' => $result['message'] ?? 'Προέκυψε σφάλμα κατά τη διαγραφή από το newsletter.',
        'email'   => $result['email'] ?? null,
    ];

    return view('frontend/pages/newsletter_unsub', $data);
}




} // ─── End of Class ───

