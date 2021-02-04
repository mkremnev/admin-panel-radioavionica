<?php

declare(strict_types=1);

namespace App\Security;

use function ini_set;
use function session_destroy;
use function session_regenerate_id;
use function session_start;
use function session_unset;
use function time;

class SessionManager
{
    public function __construct(string $lifetime, string $sessionName)
    {
        ini_set('session.gc_maxlifetime', (string)$lifetime);
        session_start();
        $now = time();
        if ($this->exists($sessionName) && $now > $this->get($sessionName)) {
            session_unset();
            session_destroy();
            session_start();
            session_regenerate_id();
            $_SESSION = [];
        }
        $this->put($sessionName, $now + (int)$lifetime);
    }

    public function exists($key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function get($key)
    {
        return $this->exists($key) ? $_SESSION[$key] : null;
    }

    public function put($key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function delete($key): void
    {
        unset($_SESSION[$key]);
    }
}
