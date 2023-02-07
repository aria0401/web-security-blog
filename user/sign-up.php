<?php

require_once(__DIR__ . '/../includes/init.php');

$user = new User();
$sent = false;
$accountExists = false;

if (isMethod('post')) {

    $conn = require_once(__DIR__ . '/../includes/db.php');

    $user->firstname = $_POST['first_name'];
    $user->lastname = $_POST['last_name'];
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];
    $user->verification_key = bin2hex(random_bytes(16));
    $user->forgot_password_key = bin2hex(random_bytes(8));
    $userId;


    if ($user->validate()) {

        if (!$user->authenticateEmail($conn)) {
            if ($user->create($conn)) {

                $message = 'A verification message has been sent to ' . $user->email;

                $_message = "Thank you for signing up. 
                    <a href='http://localhost:8888/user/validate-user.php?key=$user->verification_key'>
                    Click here to verify your account
                    </a>";

                $_to_email = $user->email;

                $_subject = 'Thank you for signing up';

                require_once(__DIR__ . '/../vendor/send-email.php');


                $newUser = User::getById($conn, $user->id);
                // var_dump($newUser);
            }
        } else {
            $accountExists = true;
        }
    }
}


?>
<?php $_title = 'User - Sign up';
$_nav = true;
$_headerClass = 'light';
?>
<?php require_once(__DIR__ . '/../includes/header.php');  ?>

<?php if ($message) : ?>
    <div class="container send-message mt-5 py-5">
        <p class=""><?= $message; ?></p>
    </div>
<?php else : ?>
    <div class="container-form-page mt-4 py-5">
        <div class=" form p-4 py-5">
            <h1 class="">Sign up</h1>
            <form method="post" id="formUserValidate">
                <?php if ($accountExists) : ?>
                    <p class="error">An account with these credentials already exists.</p>
                <?php endif; ?>
                <?php if (!empty($user->errors)) : ?>
                    <ul>
                        <?php foreach ($user->errors as $error) : ?>
                            <li class="error"><?= $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <div class="form-group">
                    <label for="first_name">First name</label>
                    <input class="form-control" type="text" name="first_name" id="first_name" value="<?= htmlspecialchars($user->firstname); ?>" required>
                </div>
                <div class="form-group mt-2">
                    <label for="last_name">Last name</label>
                    <input class="form-control" type="text" name="last_name" id="last_name" value="<?= htmlspecialchars($user->lastname); ?>" required>
                </div>
                <div class="form-group mt-2">
                    <label for="email">Email</label>
                    <input class="form-control" type="email" name="email" id="email" value="<?= htmlspecialchars($user->email); ?>" required>
                </div>
                <div class="form-group mt-2">
                    <label for="password">Password</label>
                    <input class="form-control" type="password" name="password" id="password" value="<?= htmlspecialchars($user->password); ?>" minlength="2" maxlength="5" required>
                </div>
                <button class="btn primary_button w-100 mt-3">Sign up</button>
            </form>
            <div class="mt-3">
                <p>Already have an account? <a href="/user/login.php">Log in</a></p>

            </div>
        </div>
    </div>

<?php endif; ?>
<!-- <script>
    $("#formSignUp").validate();
</script> -->
<?php require_once(__DIR__ . '/../includes/footer.php'); ?>