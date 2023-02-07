<?php
require_once(__DIR__ . '/../includes/init.php');

$user = new User();

if (isMethod('post')) {

    $conn = require_once(__DIR__ . '/../includes/db.php');
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];

    if ($user->validate()) {

        if ($user->authenticateLogin($conn, $user->password)) {

            if ($user->checkVerified($conn)) {

                $userObj = User::getByEmail($conn, $user->email);

                if ($userObj->is_admin) {

                    Auth::login($userObj);

                    Url::redirect('/admin/index.php');
                } else {
                    $error = 'Login incorrect. Make sure you have the right credentials.';
                }
            } else {
                $error = 'You have not verified your account yet.';
            }
        } else {
            $error = 'Login incorrect. Make sure you have the right credentials.';
        }
    }
}
?>
<?php $_title = 'Admin - Log in';
?>
<?php require_once(__DIR__ . '/includes/header.php');  ?>

<div class="container-form-page mt-4 py-5">
    <div class="form p-4 py-5">
        <h1>Log in</h1>
        <form method="post" id="formUserValidate">
            <?php if (!empty($error)) : ?>
                <p class="error"><?= $error; ?></p>
            <?php endif; ?>
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
            <div class="form-group mt-2">
                <label for="password">password</label>
                <input class="form-control" type="password" name="password" id="password" value="<?= htmlspecialchars($user->password); ?>" minlength="2" maxlength="5" required>
            </div>
            <button class="btn primary_button w-100 mt-3">Log in</button>
        </form>
    </div>
</div>


<?php require_once(__DIR__ . '/../includes/footer.php'); ?>