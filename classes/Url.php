<?php

/**
 * URL
 * Response methods
 */

class Url {

    /** Redirect to another URL on the same site */

    public static function redirect($path) {

        //standar way of checking if the server is using http or https
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
            $protocol = 'https';
        } else {
            $protocol = 'http';
        }

        header("Location: $protocol://" . $_SERVER['HTTP_HOST'] . $path);
        exit;
    }
}
