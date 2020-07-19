<?php
$breacrumb = site()->getBreadcrumb();
$key = array_keys($breacrumb);
?>
<?php if (!empty($breacrumb)) : ?>
    <div class="bg-light">
        <nav aria-label="breadcrumb" class="container-md">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= site_url() ?>"><i class="fas fa-home"></i> Beranda</a></li>
                <?php foreach ($breacrumb as $url => $caption) : ?>
                    <?php if (is_numeric($url)) : ?>
                        <li class="breadcrumb-item<?= end($key) === $url ? ' active' : NULL ?>" aria-current="page"><?= $caption ?></li>
                    <?php else : ?>
                        <li class="breadcrumb-item<?= end($key) === $url ? ' active' : NULL ?>"><a href="<?= site_url($url) ?>"><?= $caption ?></a></li>
                    <?php endif ?>
                <?php endforeach ?>
            </ol>
        </nav>
    </div>
<?php endif ?>