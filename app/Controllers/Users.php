<?php namespace App\Controllers;
use App\Models\UserModel;
use App\Models\ContentModel;

class Users extends BaseController {

    private $user;
    private $content;

    function __construct() {
        $this->user = new UserModel();
        $this->content = new ContentModel();
    }

/**
 * Renders the login page.
 *
 * Prepares and passes data to the login view, then renders
 * the page.
 *
 * @return string
 */
public function login_page() {
    $data = [];
    $data['blocks'] = $this->content->getBlocks(['login']);
    return view('frontend/pages/login',$data);
}

/**
 * Handles user login logic and session initialization.
 *
 * Behavior:
 * - Validates submitted credentials.
 * - Starts session on successful login.
 * - Displays error view on failed login.
 *
 * Notes:
 * - Sanitizes and validates email and password fields.
 * - Loads dynamic login content blocks and error status on failure.
 *
 * @return \CodeIgniter\HTTP\RedirectResponse|string|null
 */
public function login() {

    if( $this->request->is('post') ) { // Submitted
        // Get raw input data
	    $login_data = $this->request->getRawInput();

        // Sanitize input data
        $login_data['email']    = filter_var($login_data['email'], FILTER_SANITIZE_EMAIL);
        $login_data['password'] = trim($login_data['password']);

        // Validate form data
        $validationRules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[3]',
        ];

        if ($this->validate($validationRules)) {
            // Validated successfully, proceed with login
            $email    = $login_data['email'];
            $password = $login_data['password'];

            // Perform Members
            $userData = $this->user->getUserByEmail($email);

            if ($userData && password_verify($password, $userData['password'])) {
                $session = session();
                $userSessionData = [
                    'user_id'   => $userData['id'],
                    'firstname' => $userData['first_name'],
                    'lastname'  => $userData['last_name'],
                    'avatar'    => pathinfo($userData['avatar'] ?? 'avatar', PATHINFO_FILENAME),
                    'tier'      => $userData['tier'] ?? 1,
                    'logged_in' => TRUE
                ];
                $session->set($userSessionData);

                // Redirect to home page
                return redirect()->to('/');
            } else {
                // Invalid credentials, display error
                $data = [
                    'nav_style'  => 'dynamic',
                    'site_title' => 'Invalid Credentials',
                    'blocks'     => $this->content->getBlocks(['login']),
                    'error'      => TRUE
                ];
                return view('frontend/pages/login', $data);
            }
        } else {
            // Validation failed, display error
            $data = [
                'nav_style'  => 'dynamic',
                'site_title' => 'Invalid Credentials',
                'blocks'     => $this->content->getBlocks(['login']),
                'error'      => TRUE
            ];
            return view('frontend/pages/login', $data);
        }
    }
}

/**
 * Logs out the current user by clearing session variables.
 *
 * Behavior:
 * - Removes authentication-related session data.
 * - Destroys the session entirely.
 * - Redirects to homepage.
 *
 * Restrictions:
 * - Skips if user tier is 0 (not logged in).
 *
 * @return \CodeIgniter\HTTP\RedirectResponse
 */
public function logout() {
	if ( tier() == 0 ) {return redirect()->to('/');}
	$session = session();

	$session_items = ['user_id', 'firstname', 'lastname', 'avatar', 'tier', 'logged_in'];
	$session->remove($session_items);

	$session->destroy();
	return redirect()->to('/');
}

} // ─── End of Class ───

