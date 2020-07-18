<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->include('layout\includes\head') ?>
</head>

<body>
    <?= $this->include('layout\includes\app-header') ?>
    <?= $this->include('layout\includes\app-navbar') ?>

    <div class="container-md">
        <div class="d-md-flex justify-content-md-between">
            <div class="page-title mt-3">
                <h1 class="h4 font-weight-normal"><?= site()->getTitle() ?? 'Dashboard' ?></h1>
            </div>
            <div class="d-none d-md-block">
                <?= $this->include('layout\includes\app-breadcrumb') ?>
            </div>
        </div>
        <?= $this->renderSection('content') ?>
    </div>

    <?= $this->include('layout\includes\app-footer') ?>
    <?= $this->include('layout\includes\scripts') ?>
</body>

</html>