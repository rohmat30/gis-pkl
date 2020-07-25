<?= $this->extend('layout\app') ?>
<?= $this->section('content') ?>
<div class="alert alert-primary">
    <p class="m-0">
        Selamat datang di <strong><?= site()->appName ?></strong>
    </p>
</div>
<?= $this->endSection() ?>