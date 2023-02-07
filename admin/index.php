<?php

require_once(__DIR__ . '/../includes/init.php');

$conn = require_once(__DIR__ . '/../includes/db.php');

$articles = Article::getAll($conn);

?>
<?php
$_title = 'Home-Admin';
$_bodyClass = 'admin-index';
?>

<?php require_once(__DIR__ . '/includes/header.php'); ?>
<?php if (Auth::isLoggedIn() && $_SESSION['is_admin']) : ?>
    <?php require_once(__DIR__ . '/includes/admin_nav.php'); ?>
    <div class="container py-5">

        <h2 class="my-3">Articles overview</h2>
        <?php if (empty($articles)) : ?>
            <p>No articles found.</p>
        <?php else : ?>
            <div class="row py-5">
                <?php foreach ($articles as $article) : ?>
                    <div class="col-11 col-md-5 col-lg-4 col-xl-3 mx-auto mt-3 mb-5 p-lg-3">
                        <article>
                            <a class="hover-color" href="article.php?id=<?= $article['id'] ?>">
                                <?php if ($article['image_file']) : ?>
                                    <img class="article_img mb-3" src="/../uploads/articles/<?= $article['image_file']; ?>" alt="articles image">
                                <?php endif; ?>
                                <p class="min-h-100"><?= htmlspecialchars($article['title']); ?></p>
                                <?php if ($article['image_file']) : ?>
                                    <img class="mb-2" src="/../uploads/<?= $article['image_file']; ?>" alt="">
                                <?php endif; ?>
                            </a>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>


        <?php endif; ?>
    </div>
<?php else :
    Url::redirect('/admin/login.php');
endif; ?>

<?php require_once(__DIR__ . '/includes/footer.php'); ?>