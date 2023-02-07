<?php 
    $token = filter_input(INPUT_POST, 'token', FILTER_UNSAFE_RAW);

    if (!$token || $token !== $_SESSION['token']) {
        echo 'Error: invalid form submission';
        header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
        exit;
    }
