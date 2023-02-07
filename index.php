<?php

require_once(__DIR__ . '/includes/init.php');

$conn = require_once(__DIR__ . '/includes/db.php');

$categories = Category::getAll($conn);

?>
<?php
$_title = 'Home';
$_nav = true;
$_bodyClass = 'index-page';
?>
<?php require_once(__DIR__ . '/includes/header.php');  ?>

<div class="container-fluid p-0">
    <div class="hero-banner">
        <div class="hero-header">
            <h1 class="mb-4">Expand your knowledge about web security.</h1>
            <?php if (Auth::isLoggedIn()) : ?>
                <div class="dots mt-5">
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                </div>
            <?php else : ?>
                <p class="mb-5">Sign up to publish your own articles</p>
                <button class="main_btn">Sign Up</button>
            <?php endif; ?>
        </div>
        <div class="hero-image">
            <img src="/media/site-images/splash-image.png">
        </div>
    </div>
    <div class="container my-5 py-5">
        <?php if (empty($categories)) : ?>
            <p>No articles found.</p>
        <?php else : ?>
            <div class="categories-wrapper row">
                <?php foreach ($categories as $category) : ?>
                    <div class="category-box mb-3">
                        <a class="category-cta" href="articles-overview.php?category=<?= $category['name']; ?>">
                            <div class="category-image d-flex align-items-center justify-content-center">
                                <img class="w-50" src="/media/category-icons/icon.png">
                            </div>
                            <div class="category-text">
                                <h4><?= htmlspecialchars($category['title']); ?></h4>
                                <p><?= substr(htmlspecialchars($category['description']), 0, 130) . ' ...'; ?></p>
                                <button class="cta tertiary_button"><?= htmlspecialchars($category['cta']); ?></button>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

</div>

<?php require_once(__DIR__ . '/includes/footer.php'); ?>