<?php

require_once(__DIR__ . '/../includes/init.php');
$conn = require_once(__DIR__ . '/../includes/db.php');

if (isset($_GET['id'])) {

    $article = Article::getById($conn, $_GET['id']);

    if (!$article) {
        die("article not found");
    }
} else {
    die("id not supplied, article not found");
}


$image = new Image();

if (isMethod('post')) {
    require_once(__DIR__ . '/../includes/csrf_validate.php');

    $image->file_error = $_FILES['file']['error'];
    $image->file_size = $_FILES['file']['size'];
    $image->file_name = $_FILES['file']['name'];

    $extension = pathinfo($_FILES['file']['name'])['extension'];


    if ($image->validate()) {
        $folder = "../uploads/articles/";
        $destination = $image->fileName($folder)[0];
        $filename = $image->fileName($folder)[1];

        if (move_uploaded_file($_FILES['file']['tmp_name'], $destination)) {

            $previous_image = $article->image_file;

            if ($article->setImageFile($conn, $filename)) {

                if ($previous_image) {
                    unlink($folder . $previous_image); //to delete a file in PHP
                }
                header('Content-Type: image/' . $extension . '');
                Url::redirect("/user/article.php?id={$article->id}");
            }
        } else {
            echo 'Unable to move uploaded file';
        }
    }
}

?>


<?php
$_title = 'User - Edit Article Image';
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
                <h2 class="col-12"><?= htmlspecialchars($article->title); ?></h2>
                <p class="col-12"><?= htmlspecialchars($article->description); ?></p>
                <?php if ($article->image_file) : ?>
                    <img class="col-3" src="../uploads/articles/<?= $article->image_file; ?>" alt="article image">
                    <a id="deleteBtn" class="col-12" href="delete-article-image.php?id=<?= $article->id; ?>">Delete Image</a>

                <?php endif; ?>
            </article>

        <?php else : ?>
            <p>We could not find this article.</p>
        <?php endif; ?>



        <?php if (!empty($image->errors)) : ?>
            <ul>
                <?php foreach ($image->errors as $error) : ?>
                    <li class="error"><?= $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <form method="post" enctype="multipart/form-data">
            <div>
                <label for="file">Image file</label>
                <input class="btn" type="file" name="file" id="file">
            </div>
            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?? ''; ?>">
            <button class="btn primary_button w-10rem">Upload</button>
        </form>
    </div>
<?php else :
    Url::redirect('/user/login.php');
endif; ?>

<?php require_once(__DIR__ . '/../includes/footer.php'); ?>