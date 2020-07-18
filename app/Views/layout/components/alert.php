<?php if (session('alert.type') == 'info') : ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <?= session('alert.mess') ?>
        <button type="button" class="close font-weight-normal" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>
<?php if (session('alert.type') == 'success') : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session('alert.mess') ?>
        <button type="button" class="close font-weight-normal" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>
<?php if (session('alert.type') == 'warning') : ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <?= session('alert.mess') ?>
        <button type="button" class="close font-weight-normal" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>
<?php if (session('alert.type') == 'danger') : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session('alert.mess') ?>
        <button type="button" class="close font-weight-normal" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>