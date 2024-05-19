<?php

require_once $root . '/includes/database.php';
require_once $root . '/includes/auth.php';

if (!function_exists('dd')) {
    function dd()
    {
        foreach (func_get_args() as $arg) {
            var_dump($arg);
        }
        die;
    }
}

if (!function_exists('old')) {
    function old($name, $default = '')
    {
        return $_SESSION['old'][$name] ?? $default;
    }
}
