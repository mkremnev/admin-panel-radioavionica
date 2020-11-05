<?php
namespace App\Security;

class SessionManager
{
    const SESSION_DURATION = 20 * 60;

    public function __construct()
    {
        ini_set('session.gc_maxlifetime', self::SESSION_DURATION);
        session_start();
        $now = time();
        if ($this->exists('invalidate_at') && $now > $this->get('invalidate_at')) {
            session_unset();
            session_destroy();
            session_start();
            session_regenerate_id();
            $_SESSION = [];
        }
        $this->put('invalidate_at', $now + self::SESSION_DURATION);
    }

    public function exists($key) {
        return isset($_SESSION[$key]);
    }

    public function get($key) {
        return $this->exists($key) ? $_SESSION[$key] : null;
    }

    public function put($key, $value) {
        $_SESSION[$key] = $value;
    }

    public function delete($key) {
        unset($_SESSION[$key]);
    }

}
