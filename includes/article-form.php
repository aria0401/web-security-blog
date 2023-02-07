<div class="container">
    <?php if (!empty($article->errors)) : ?>
        <ul>
            <?php foreach ($article->errors as $error) : ?>
                <li class="error"><?= $error; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <form method="POST" id="formArticle">
        <div class="form-group pb-4">
            <label for="title">
                <h4>Title</h4>
            </label>
            <input class="form-control" name="title" type="text" id="title" placeholder="article title" value="<?= htmlspecialchars($article->title); ?>">
        </div>
        <div class="form-group pb-4">
            <label for="description">
                <h4>Description</h4>
            </label>
            <textarea class="form-control" name="description" id="" cols="30" rows="10" placeholder="article description"><?= htmlspecialchars($article->description); ?></textarea>
        </div>
        <fieldset class="pb-4">
            <legend>
                <h4>Categories</h4>
            </legend>
            <?php foreach ($categories as $category) : ?>
                <div>
                    <input type="checkbox" name="category[]" value="<?= $category['id']; ?>" id="category<?= $category['id']; ?>" <?php if (in_array($category['id'], $category_ids)) : ?>checked <?php endif; ?>>
                    <label for="category<?= $category['id']; ?>"><?= htmlspecialchars($category['title']); ?></label>
                </div>
            <?php endforeach; ?>

        </fieldset>
        <fieldset class="mt-4 pb-4">
            <legend>
                <div>
                    <p>Status</p>
                    <input type="radio" id="private" name="status" value="0" <?php if (!$article->is_visible) : ?>checked <?php endif; ?>>
                    <label for="private">Private</label><br>
                    <input type="radio" id="public" name="status" value="1" <?php if ($article->is_visible) : ?>checked <?php endif; ?>>
                    <label for="public">Public</label><br>
                </div>
            </legend>
        </fieldset>
        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?? ''; ?>">
        <button class="btn primary_button w-10rem">Save</button>
    </form>
</div>