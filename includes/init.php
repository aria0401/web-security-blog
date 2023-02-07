<?php

/**
 * Iniatilisations
 * register an autoloader, start or resume a session etc
 * This function is called whenever a new object of a class that hasn't been required yet is created
 */
spl_autoload_register(function ($class) {

    require dirname(__DIR__) . "/classes/{$class}.php";
});

require_once(__DIR__ . '/functions.php');

session_start();
