<?php


class Auth {
    /**
     * Return the user authentication status
     */

    public static function isLoggedIn() {

        return isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'];
    }



    /**
     * Require the user to be logged in, stopping with an unauthorised message if not
     */

    public static function requireLogin() {

        if (!static::isLoggedIn()) {
            die('unauthorised');
        }
    }



    /**
     * Login using the session
     */
    public static function login($user) {

        $_SESSION['firstname'] = $user->first_name;
        $_SESSION['user_id'] = $user->id;
        $_SESSION['is_logged_in'] = true;
        $_SESSION['is_admin'] = $user->is_admin;
        $_SESSION['has_profile'] = $user->has_profile;
        $_SESSION['token'] = bin2hex(random_bytes(35));
    }


    /**
     * Log out using the session
     */
    public static function logout() {
        // Unset all of the session variables.
        $_SESSION = [];

        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        session_destroy();
    }
}
