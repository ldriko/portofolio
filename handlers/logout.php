<?php

$root = '..';

require_once $root . '/includes/includes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_destroy();
    header("Location: {$root}/index.php");
}
