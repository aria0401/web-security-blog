<?php
require_once(__DIR__ . '/../includes/init.php');

Auth::logout();
Url::redirect('/');
