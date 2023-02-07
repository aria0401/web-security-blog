<?php

require_once(__DIR__ . '/../includes/init.php');

?>
<?php
$_title = 'User Account';
$_nav = true;
$_headerClass = 'dark';
?>
<?php require_once(__DIR__ . '/../includes/header.php');  ?>



<?php if (Auth::isLoggedIn()) : ?>
<?php require_once(__DIR__ . '/../includes/user_nav.php');
endif; ?>