<div class=" user-nav d-flex">
    <div class="d-flex">
        <a href="new-article.php">Create new article</a>
        <a href="articles-overview.php">View your articles</a>
        <a href="edit-login.php?id=<?= $_SESSION['user_id']; ?>">Edit Name and Login</a>
        <?php if ($_SESSION['has_profile']) : ?>
            <a href="edit-profile-when-you-have-one.php?id=<?= $_SESSION['user_id']; ?>">Edit Profile (under development)</a>
        <?php else : ?>
            <a href="create-profile.php?id=<?= $_SESSION['user_id']; ?>">Create Profile</a>
        <?php endif; ?>
    </div>
</div>