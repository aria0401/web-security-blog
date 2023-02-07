<?php
require_once(__DIR__ . '/../includes/init.php');

$conn = require_once(__DIR__ . '/../includes/db.php');
$newUser = new User();

$email;
$old_email;
$authenticated = true;

if (isMethod('get')) {
    if ($_GET['id'] == $_SESSION['user_id']) {
        $current_user = User::getById($conn, $_GET['id']);
        //display current values in the form
        $email = $current_user->email;
    } else {
        $authenticated = false;
    }
}

if (isMethod('post')) {

    require_once(__DIR__ . '/../includes/csrf_validate.php');

    $newUser->email = $_POST['email'];
    $newUser->password = $_POST['password'];
    $newUser->id = $_SESSION['user_id'];

    //display new values in the form.
    $email = $newUser->email;


    if ($newUser->validate()) {

        if ($newUser->getById($conn, $newUser->id)) {

            if ($newUser->updateLogin($conn)) {

                $message = 'Your login has been updated';
            }
        }
    }
}

$_title = 'User - Edit login';
$_nav = true;
$_headerClass = 'dark';
?>

<?php require_once(__DIR__ . '/../includes/header.php'); ?>
<?php if (Auth::isLoggedIn()) : ?>

    <?php require_once(__DIR__ . '/../includes/user_nav.php'); ?>
    <?php if ($message) : ?>
        <div class="container-form-page send-message mt-4 py-5">
            <div class="form p-4 py-5">
                <h4 class=""><?= $message; ?></h4>
            </div>
        </div>
    <?php else : ?>
        <div class="container-form-page mt-4 py-5">
            <?php if ($authenticated) : ?>
                <div class=" form p-4 py-5">
                    <h1 class="">Edit Login</h1>
                    <?php if (!empty($user_not_found)) : ?>
                        <p class="mt-3" class="error"><?= $user_not_found; ?></p>
                    <?php endif; ?>
                    <form method="post">

                        <?php if (!empty($newUser->errors)) : ?>
                            <ul>
                                <?php foreach ($newUser->errors as $error) : ?>
                                    <li class="error"><?= $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        <div class="form-group mt-2">
                            <label for="email">Email</label>
                            <input class="form-control" type="text" name="email" id="email" value="<?= htmlspecialchars($email); ?>" placeholder="New email">
                        </div>
                        <div class="form-group mt-2">
                            <label for="password">Password</label>
                            <input class="form-control" type="password" name="password" id="password" value="<?= htmlspecialchars($newUser->password); ?>" placeholder="New password">
                        </div>
                        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?? ''; ?>">
                        <button class="btn primary_button w-100 mt-3">Edit Login</button>
                    </form>
                </div>
            <?php else : ?>
                <h2>You don't have permission to edit this user.</h2>
            <?php endif; ?>
        </div>
    <?php endif; ?>

<?php else :
    Url::redirect('/user/login.php');
endif; ?>
<?php require_once(__DIR__ . '/../includes/footer.php'); ?>