<?php

require_once(__DIR__ . '/../includes/init.php');

$user = new User();
$expiredKey = false;
$updated = false;

if (!isset($_GET['key']) || strlen($_GET['key']) != 16) {

    Url::redirect('/');
} else {
    $conn = require_once(__DIR__ . '/../includes/db.php');
    $user->forgot_password_key = $_GET['key'];

    if (!$user->authenticateKey($conn)) {

        $expiredKey = true;
    } else {
        if (isMethod('post')) {

            $user->newPassword = $_POST['new_password'];
            $user->confirmPassword = $_POST['confirm_password'];

            if ($user->validate()) {
                if ($user->updatePassword($conn)) {

                    $updated = true;
                }
            }
        }
    }
}


$_title = 'User - Reset Password';
$_nav = true;
?>

<?php require_once(__DIR__ . '/../includes/header.php'); ?>

<?php if ($updated) : ?>

    <div class="container-form-page send-message mt-4">
        <div class="form p-4">
            <h4 class="">Your password has been succesfully changed.</h4>
            <p class="mt-4">You can log in now!!!</p>
            <div class="mt-3">
                <a href="/user/login.php">
                    <button class="btn w-100 primary_button">Log in</button>
                </a>
            </div>
        </div>
    </div>
<?php else : ?>

    <div class="container-form-page mt-4">
        <div class="form p-4">
            <h1 class="">Reset your password</h1>
            <form method="post">
                <?php if ($expiredKey) : ?>
                    <p class="error">This link has expired.</p>
                <?php endif; ?>
                <?php if (!empty($user->errors)) : ?>
                    <ul>
                        <?php foreach ($user->errors as $error) : ?>
                            <li class="error"><?= $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <div class="form-group">
                    <label for="new_password">New password</label>
                    <input class="form-control" type="text" name="new_password" id="new_password" value="<?= htmlspecialchars($user->newPassword); ?>">
                </div>
                <div class="form-group mt-2">
                    <label for="confirm_password">Confirm password</label>
                    <input class="form-control" type="text" name="confirm_password" id="confirm_password" value="<?= htmlspecialchars($user->confirmPassword); ?>">
                </div>
                <button class="btn primary_button w-100 mt-3">Reset</button>
            </form>
        </div>
    </div>


<?php endif; ?>

<?php require_once(__DIR__ . '/../includes/footer.php'); ?>