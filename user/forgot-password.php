<?php

require_once(__DIR__ . '/../includes/init.php');

$user = new User();
$sent = false;


if (isMethod('post')) {

    $conn = require_once(__DIR__ . '/../includes/db.php');

    $user->email = $_POST['email'];

    if ($user->validate()) {

        $key = User::getByEmail($conn, $user->email, 'forgot_password_key');


        if ($user->authenticateEmail($conn)) {

            $message = 'A link to reset your password has been sent to ' . $user->email;

            $_message = "A last new message from reset your password. 
                <a href='http://localhost:8888/user/reset-password.php?key={$key->forgot_password_key}'>
                Click here to reset your password.
                </a>";

            $_to_email = $user->email;

            $_subject = 'Reset password request';

            require_once(__DIR__ . '/../vendor/send-email.php');
        } else {
            $user_not_found = 'It seems like you do not have an account yet';
        }
    }
}



$_title = 'User - Forgot Password';
$_nav = true;
$_headerClass = 'light';
?>

<?php require_once(__DIR__ . '/../includes/header.php'); ?>

<?php if ($message) : ?>
    <div class="container mt-5">
        <p class="send-message"><?= $message; ?></p>
    </div>
<?php else : ?>

    <div class="container-form-page mt-4 py-5">
        <div class=" form p-4 py-5">
            <h1 class="">Forgot password?</h1>
            <?php if (!empty($user_not_found)) : ?>
                <p class="mt-3 error"><?= $user_not_found; ?></p>
            <?php else : ?>
                <p>You can reset your password here.</p>
            <?php endif; ?>
            <form method="post" id="formUserValidate">
                <?php if (!empty($user->errors)) : ?>
                    <ul>
                        <?php foreach ($user->errors as $error) : ?>
                            <li class="error"><?= $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-control" type="email" name="email" id="email" value="<?= htmlspecialchars($user->email); ?>" required>
                </div>
                <button class="btn primary_button w-100 mt-3">Reset</button>
            </form>
        </div>
    </div>

<?php endif; ?>


<?php require_once(__DIR__ . '/../includes/footer.php'); ?>