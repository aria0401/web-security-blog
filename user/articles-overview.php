<?php

require_once(__DIR__ . '/../includes/init.php');

$conn = require_once(__DIR__ . '/../includes/db.php');
$categories = Category::getAll($conn);
$articles = Article::getByUserID($conn, $_SESSION['user_id']);
?>

<?php
$_title = 'User - Articles Overview';
$_nav = true;
$_overview = 'filter-overview';
$_bodyClass = 'overview-page';
$_headerClass = 'dark';
?>
<?php require_once(__DIR__ . '/../includes/header.php');  ?>

<?php if (Auth::isLoggedIn()) : ?>
    <?php require_once(__DIR__ . '/../includes/user_nav.php'); ?>
    <div class="container-fluid overview-container" id="main-sidebar">
        <div class="row">
            <div class="col-11 col-sm-9 mx-auto main-content">
                <p class="not-found"> <?= empty($articles) ? 'No articles found' : null; ?> </p>
                <div class="d-flex-wrap" id="articlesList">
                    <?php foreach ($articles as $article) : ?>
                        <div class="item  mx-auto p-lg-2 mb-4">
                            <a class="article_a" href="article.php?id=<?= $article['id']; ?>">
                                <article class="d-flex flex-column p-3">
                                    <?php if ($article['image_file']) : ?>
                                        <img class="article_img mb-3" src="/uploads/articles/<?= $article['image_file']; ?>" alt="articles image">
                                    <?php endif; ?>
                                    <p class="article_name f-08r"><?= htmlspecialchars($article['title']); ?></p>
                                    <button class="a-sm-txt see-more">Details</button>
                                </article>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

    </div>
<?php else :
    Url::redirect('/user/login.php');
endif; ?>
<?php require_once(__DIR__ . '/../includes/footer.php'); ?>