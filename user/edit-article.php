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

$category_ids = array_column($article->getCategories($conn), 'id');
$categories = Category::getAll($conn);

if (isMethod('post')) {
    require_once(__DIR__ . '/../includes/csrf_validate.php');


    $article->title = $_POST['title'];
    $article->description = $_POST['description'];
    $article->is_visible = $_POST['status'];

    $category_ids = $_POST['category'] ?? [];

    if ($article->validate()) {

        if ($article->update($conn)) {

            $article->setCategories($conn, $category_ids);

            Url::redirect("/user/article.php?id={$article->id}");
        }
    }
}

?>


<?php $_title = 'User - Edit Article';
$_nav = true;
$_headerClass = 'dark';
?>

<?php require_once(__DIR__ . '/../includes/header.php'); ?>

<?php if (Auth::isLoggedIn()) : ?>
    <?php require_once(__DIR__ . '/../includes/user_nav.php'); ?>
    <?php if ($authenticated) : ?>
        <div class="container mb-5">
            <h2 class="my-3">Edit Article</h2>
            <?php require_once(__DIR__ . '/../includes/article-form.php'); ?>
        </div>
    <?php else : ?>
        <h2>You don't have permission to edit this article.</h2>
    <?php endif; ?>
<?php else :
    Url::redirect('/user/login.php');
endif; ?>

<?php require_once(__DIR__ . '/../includes/footer.php'); ?>