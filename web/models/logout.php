<?php
include_once("commons.php");

class LogoutModel extends Model
{
    public function handleData($data)
    {
        session_start();

        if (isset($_COOKIE[session_name()])) {
            /* Destroy the cookie associated with this session */
            $params = session_get_cookie_params();
            setcookie(session_name(), '', 1, $params['path'], $params['domain'], $params['secure'], isset($params['httponly']));
        }

        session_unset();
        session_destroy();

        header("Location: http://" . $_SERVER['HTTP_HOST'] . "/" . "index.php");
    }
}

$model = new LogoutModel();
