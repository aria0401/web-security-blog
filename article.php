<?php

require_once(__DIR__ . '/includes/init.php');

$conn = require_once(__DIR__ . '/includes/db.php');
$categories = Category::getAll($conn);
$art = new Article();

if (isset($_GET['id'])) {

    $article = Article::getById($conn, $_GET['id']);
    $comments = Article::getComments($conn, $_GET['id']);
} else {
    $article = null;
}



if (isMethod('post')) {

    $art->user_id = $_SESSION['user_id'];
    $art->article_id = $article->id;
    $art->comment = $_POST['comment'];

    if ($art->validate()) {

        if ($art->createComment($conn)) {
            $art->comment = '';
            $comments = Article::getComments($conn, $art->article_id);
        }
    }
}


?>
<?php
$_title = 'Article';
$_nav = true;
?>
<?php require_once(__DIR__ . '/includes/header.php');  ?>

<div class="container-fluid overview-container" id="main-sidebar">
    <button class="openbtn d-none-desktop" id="openNav">☰ See more categories</button>
    <div id="mySidebar" class="sidebar d-none-desktop">
        <?php require(__DIR__ . '/includes/sidebar.php');  ?>
    </div>

    <div class="row">
        <div class="col-3 sidebar-desktop d-none-mobile">
            <?php require(__DIR__ . '/includes/sidebar.php');  ?>
        </div>
        <div class="col-12 col-sm-9 main-content mt-5">

            <div class="mt-5">
                <?php if ($article) : ?>

                    <article class="row">
                        <?php if ($article->image_file) : ?>
                            <div class="col-11 col-lg-4 mx-auto">
                                <img class="mb-3" src="../uploads/articles/<?= $article->image_file; ?>" alt="articles image">
                            </div>
                        <?php endif; ?>
                        <div class="col-11 col-lg-8 mx-auto row">
                            <h2 class="w-lg-75 mb-4 p-0 px-md-2"><?= htmlspecialchars($article->title); ?></h2>
                            <p class="w-lg-75 p-0 px-md-2"><?= htmlspecialchars($article->description); ?></p>
                        </div>
                    </article>

                    <?php if ($comments) : ?>
                        <div class="comments-wrapper mt-5">
                            <?php foreach ($comments as $comment) : ?>
                                <div class="comment mb-3">
                                    <p class="mt-2 mb-0"><?= htmlspecialchars($comment['comment']); ?></p>
                                    <span class="small"><?= $comment['username'] ? htmlspecialchars($comment['username']) : htmlspecialchars($comment['first_name']); ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (Auth::isLoggedIn()) : ?>
                        <div>

                            <form id="form-comment" class="mt-5" method="POST">
                                <div class="form-group">
                                    <label for="comment">
                                        <h4>Leave a Comment</h4>
                                    </label>
                                    <?php if (!empty($art->errors)) : ?>
                                        <ul>
                                            <?php foreach ($art->errors as $error) : ?>
                                                <li class="error"><?= $error; ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                    <textarea class="form-control" name="comment" id="comment" cols="30" rows="4"><?= htmlspecialchars($art->comment); ?></textarea>
                                </div>
                                <button class="btn primary_button w-10rem mt-3">Post</button>
                            </form>
                        </div>
                    <?php endif; ?>
                <?php else : ?>
                    <p>We could not find this article.</p>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>





<?php require_once(__DIR__ . '/includes/footer.php'); ?>