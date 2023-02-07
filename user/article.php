<?php

require_once(__DIR__ . '/../includes/init.php');
$conn = require_once(__DIR__ . '/../includes/db.php');

if (isset($_GET['id'])) {

    $article = Article::getWithCategories($conn, $_GET['id']);
} else {
    $article = null;
}

?>


<?php
$_title = 'User - Article';
$_nav = true;
$_headerClass = 'dark';
?>

<?php require_once(__DIR__ . '/../includes/header.php'); ?>
<?php require_once(__DIR__ . '/../includes/modal.php'); ?>
<?php if (Auth::isLoggedIn()) : ?>
    <?php require_once(__DIR__ . '/../includes/user_nav.php'); ?>
    <div class="container py-5">

        <?php if ($article) : ?>
            <article class="row py-5">
                <?php if ($article[0]['image_file']) : ?>
                    <img class="col-4" src="../uploads/articles/<?= $article[0]['image_file']; ?>" alt="articles image">
                <?php endif; ?>
                <div class="col-8">
                    <h2 class=""><?= htmlspecialchars($article[0]['title']); ?></h2>
                    <p class=""><?= htmlspecialchars($article[0]['description']); ?></p>
                    <?php if ($article[0]['category_name']) : ?>
                        <h5 class="">Categories:</h5>
                        <ul>
                            <?php foreach ($article as $a) : ?>
                                <li><?= htmlspecialchars($a['category_title']); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </article>

        <?php else : ?>
            <p>We could not find this article.</p>
        <?php endif; ?>
        <div class="mt-4">
            <a class="btn primary_button w-10rem" href="edit-article.php?id=<?= $article[0]['id']; ?>">Edit</a>
            <a id="" class="btn primary_button w-10rem" href="delete-article.php?id=<?= $article[0]['id']; ?>">Delete</a>
            <!-- <a id="deleteBtn" class="btn" href="delete-article.php?id=<?= $article[0]['id']; ?>">Delete</a> -->
            <a class="btn primary_button w-10rem" href="edit-article-image.php?id=<?= $article[0]['id']; ?>"><?= $article[0]['image_file'] ? 'Edit Image' : 'Add Image'; ?></a>

        </div>
    </div>
<?php else :
    Url::redirect('/user/login.php');
endif; ?>

<?php require_once(__DIR__ . '/../includes/footer.php'); ?>