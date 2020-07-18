<?= $this->extend('layout\blank') ?>
<?= $this->section('content') ?>
<div class="mt-5 mx-auto" style="max-width: 20rem;">
    <div class="text-center py-3">
        <h1 class="h3 font-weight-light">Login ke sistem</h1>
    </div>
    <?= $this->include('layout\components\alert') ?>
    <div class="card">
        <?= form_open('', ['autocomplete' => 'off']) ?>
        <div class="card-body">
            <div class="form-group">
                <?= form_label('Username', '', ['for' => 'username', 'class' => 'mb-1', 'style' => 'font-weight: 500']) ?>
                <?= form_input('username', old('username', ''), ['class' => 'form-control form-control-sm', 'id' => 'username']) ?>
            </div>
            <div class="form-group">
                <?= form_label('Password', '', ['for' => 'password', 'class' => 'mb-1', 'style' => 'font-weight: 500']) ?>
                <?= form_password('password', '', ['class' => 'form-control form-control-sm', 'id' => 'password']) ?>
            </div>
            <div class="form-group">
                <?= form_button(['type' => 'submit', 'class' => 'btn btn-success btn-sm btn-block', 'style' => 'font-weight: 500'], 'Login') ?>
            </div>
        </div>
        <?= form_close() ?>
    </div>
</div>
<?= $this->endSection() ?>