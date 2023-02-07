<?php

require_once(__DIR__ . '/includes/init.php');

$conn = require_once(__DIR__ . '/includes/db.php');
$categories = Category::getAll($conn);

if (isMethod('get')) {

    $articles = Article::getByCategory($conn, $_GET['category']);

    foreach ($categories as $category) {
        if ($category['name'] == $_GET['category']) {
            $categoryTitle = $category['title'];
        }
    }
}



?>
<?php
$_title = 'Articles Overview';
$_nav = true;
$_overview = 'filter-overview';
$_bodyClass = 'overview-page';
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
        <div class="col-11 col-sm-9 mx-auto main-content">
            <h2 class="category-title mt-5"> <?= htmlspecialchars($categoryTitle); ?> </h2>
            <p class="not-found"> <?= empty($articles) ? 'No articles found' : null; ?> </p>

            <div class="d-flex-wrap" id="articlesList">
                <?php foreach ($articles as $article) : ?>
                    <?php if ($article['is_visible']) : ?>
                        <div class="item p-lg-2 mb-4">
                            <a class="article_a" href="article.php?id=<?= $article['id']; ?>">
                                <article class="d-flex flex-row p-3">
                                    <?php if ($article['image_file']) : ?>
                                        <div>
                                            <img class="article_img mb-3" src="/uploads/articles/<?= $article['image_file']; ?>" alt="articles image">
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <h2 class="article_name"><?= htmlspecialchars($article['title']); ?></h2>
                                        <p class="article_description"><?= htmlspecialchars($article['description']); ?></p>
                                        <button class="a-sm-txt see-more">Read more</button>
                                    </div>
                                </article>
                            </a>
                        </div>
                <?php endif;
                endforeach; ?>
            </div>

            <template class="article-template">
                <div class="item p-lg-2 mb-4">
                    <a class="article_a" href="">
                        <article class="d-flex flex-row p-3">
                            <div>
                                <img class="article_img mb-3" src="" alt="">
                            </div>
                            <div>
                                <h2 class="article_name"></h2>
                                <p class="article_description"></p>
                                <button class="a-sm-txt see-more">Read more</button>
                            </div>
                        </article>
                    </a>
                </div>
            </template>
        </div>
    </div>

</div>

<?php require_once(__DIR__ . '/includes/footer.php'); ?>