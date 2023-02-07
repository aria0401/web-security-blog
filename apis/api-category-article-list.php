<?php

require_once(__DIR__ . '/../includes/init.php');
$conn = require_once(__DIR__ . '/../includes/db.php');

if (isset($_POST['category'])) {


    $articles = Article::getByCategory($conn, $_POST['category']);

    $encode = json_encode($articles, JSON_PRETTY_PRINT);
    header('Content-Type: application/json');
    echo $encode;
}
