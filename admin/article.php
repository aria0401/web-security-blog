<?php

require_once(__DIR__ . '/../includes/init.php');
$conn = require_once(__DIR__ . '/../includes/db.php');

if (isset($_GET['id'])) {

    $article = Article::getWithCategories($conn, $_GET['id']);
} else {
    $article = null;
}

?>


<?php $_title = 'Admin/article';
$_bodyClass = 'admin-article';
?>
<?php require_once(__DIR__ . '/includes/header.php'); ?>
<?php require_once(__DIR__ . '/includes/modal.php'); ?>
<?php if (Auth::isLoggedIn() && $_SESSION['is_admin']) : ?>
    <?php require_once(__DIR__ . '/includes/admin_nav.php'); ?>
    <div class="container py-5">

        <?php if ($article) : ?>
            <article class="row py-5">
                <?php if ($article[0]['image_file']) : ?>
                    <div class="col-3 align-items-start d-flex">
                        <img class="w-75" src="../uploads/articles/<?= $article[0]['image_file']; ?>" alt="articles image">
                    </div>
                <?php endif; ?>
                <div class="col-7">
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
            <a id="deleteBtn" class="btn primary_button" href="delete-article.php?id=<?= $article[0]['id']; ?>">Delete</a>
        </div>
    </div>
<?php else :
    Url::redirect('/admin/login.php');
endif; ?>
<?php require_once(__DIR__ . '/includes/footer.php'); ?>