<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <meta http-equiv="Content-Security-Policy" content="default-src 'self'"> -->
    <link rel="stylesheet" href="/../styles/css/main.css">
    <title><?= $_title ?? 'keazon' ?></title>
</head>

<body class=<?= $_bodyClass ?? null ?>>
    <header class=<?= $_headerClass ?? null ?>>
        <?php if ($_nav) : ?>
            <nav class="navbar">
                <div class="nav-logo">
                    <a class="" href="/">Web Security</a>
                </div>
                <div class="nav-labels d-flex justify-content-end">
                    <a class="" href="/">Articles</a>
                    <a class="" href="/">OWASP Top 10</a>
                    <?php if (Auth::isLoggedIn()) : ?>
                        <a class="" href="/user/account-management.php?id=<?= $_SESSION['user_id']; ?>">Your Account</a>
                        <a class="" href="/user/logout.php">Log out</a>
                    <?php else : ?>
                        <a class="" href="/user/login.php">Log in</a>
                        <a class="" href="/user/sign-up.php">Sign Up</a>
                    <?php endif; ?>
                </div>
            </nav>
        <?php endif; ?>

    </header>