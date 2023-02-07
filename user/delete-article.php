<?php

require_once(__DIR__ . '/../includes/init.php');
$conn = require_once(__DIR__ . '/../includes/db.php');

$authenticated = true;


if (isset($_GET['id'])) {

    $article = Article::getById($conn, $_GET['id']);

    if ($article->user_id !== $_SESSION['user_id']) {
        $authenticated = false;
    }

    if (!$article) {
        die("article not found");
    }
} else {
    die("id not supplied, article not found");
}

if (isMethod('post')) {
    require_once(__DIR__ . '/../includes/csrf_validate.php');

    if ($article->delete($conn)) {
        Url::redirect("/user/articles-overview.php");
    }
}

?>


<?php $_title = 'User - Delete Article';
$_nav = true;
$_headerClass = 'dark';
?>
<?php require_once(__DIR__ . '/../includes/header.php'); ?>
<?php require_once(__DIR__ . '/../includes/modal.php'); ?>
<?php if (Auth::isLoggedIn()) : ?>
    <?php require_once(__DIR__ . '/../includes/user_nav.php'); ?>
    <?php if ($authenticated) : ?>
        <h2>Delete Article</h2>
        <form method="post">
            <p>Are you sure you want to delete this article: <?= $article->title; ?> ?</p>
            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?? ''; ?>">
            <button class="btn">Delete</button>
            <a href="article.php?id=<?= $article->id; ?>">Cancel</a>
        </form>
    <?php else : ?>
        <h2>You don't have permission to edit this article.</h2>
    <?php endif; ?>
<?php else :
    Url::redirect('/user/login.php');
endif; ?>


<?php require_once(__DIR__ . '/../includes/footer.php'); ?>