<?php if ($categories) : ?>
    <ul class="mt-5">
        <li> <a href="javascript:void(0)" class="closebtn d-none-desktop " id="openNav">×</a></li>
        <?php foreach ($categories as $category) : ?>
            <li class="sidebar-li mb-1 py-2" data-action=<?= $_overview ?? "filter-single-page"; ?> data-filter=<?= $category['name']; ?>><?= $category['title']; ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <script src="js/sidebar.js"></script>
<?php endif; ?>