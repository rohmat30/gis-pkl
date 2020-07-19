<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->include('layout\includes\head') ?>
</head>

<body>
    <?= $this->include('layout\includes\app-header') ?>
    <?= $this->include('layout\includes\app-navbar') ?>

    <?= $this->include('layout\includes\app-breadcrumb') ?>
    <div class="container-md">
        <div class="main-content">
            <div class="page-title">
                <h1 class="h4 font-weight-normal"><?= site()->getTitle() ?? 'Dashboard' ?></h1>
            </div>
            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <?= $this->include('layout\includes\app-footer') ?>
    <?= $this->include('layout\includes\scripts') ?>
</body>

</html>