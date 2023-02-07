<?php


function isMethod($method) {

    if ($_SERVER['REQUEST_METHOD'] == strtoupper($method)) {
        return true;
    } else {
        return false;
    }
}
