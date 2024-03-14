<?php
class Session
{
    const SESSION_STARTED = TRUE;
    const SESSION_NOT_STARTED = FALSE;

    private $sessionState = self::SESSION_NOT_STARTED;

    private static $instance;


    private function __construct()
    {
    }

    public function __set($name, $value)
    {
        $_SESSION[$name] = $value;
    }
    public function __get($name)
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        } else {
            echo "<p class='alerte'> no such value in {$_SESSION[$name]}</p>";
        }
    }
    public function __isset($name)
    {
        return isset($_SESSION[$name]);
    }
    public function __unset($name)
    {
        unset($_SESSION[$name]);
    }

    public function startSession()
    {
        if ($this->sessionState == self::SESSION_NOT_STARTED) {
            $this->sessionState = session_start();
        }
        return $this->sessionState;
    }
}

?>