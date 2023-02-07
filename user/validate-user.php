<?php

require_once(__DIR__ . '/../includes/init.php');


if (!isset($_GET['key']) || strlen($_GET['key']) != 32) {

    Url::redirect('/');
} else {
    if (isMethod('get')) {

        $conn = require_once(__DIR__ . '/../includes/db.php');

        $user = new User();
        $verified_user = $user->verifyKey($conn, $_GET['key']);

        if ($verified_user['verification_key'] === $_GET['key']) {

            if ($user->verified($conn, $verified_user['id'])) {

                $message =  'Congrats! Your account is verified';
            }
        }
    }
}


?>

<?php $_title = 'User - Validate User';
$_nav = true;
?>
<?php require_once(__DIR__ . '/../includes/header.php');  ?>

<?php if ($message) : ?>
    <div class="container-form-page send-message mt-4">
        <div class="form p-4">
            <h4 class=""><?= $message; ?></h4>
            <p class="mt-4">You can log in now!!!</p>
            <div class="mt-3">
                <a href="/user/login.php">
                    <button class="btn w-100 primary_button">Log in</button>
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php require_once(__DIR__ . '/../includes/footer.php'); ?>