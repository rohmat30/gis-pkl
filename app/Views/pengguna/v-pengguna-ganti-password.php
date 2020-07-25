<?= $this->extend('layout\app') ?>
<?= $this->section('content') ?>
<?= $this->include('layout\components\alert'); ?>
<?= form_open() ?>
<div class="form-row">
    <div class="form-group col-md-7">
        <?= form_label('Password lama', '', ['for' => 'password_lama', 'class' => 'mb-1', 'style' => 'font-weight: 500']) ?>
        <?= form_password('password_lama', $password_lama ?? '', ['class' => 'form-control form-control-sm' . ($validation->hasError('password_lama') ? ' is-invalid' : ''), 'id' => 'password_lama', 'placeholder' => 'Ketik password lama']) ?>
        <div class="invalid-feedback">
            <?= $validation->getError('password_lama') ?>
        </div>
    </div>
    <div class="form-group col-md-7">
        <?= form_label('Password baru', '', ['for' => 'password_baru', 'class' => 'mb-1', 'style' => 'font-weight: 500']) ?>
        <?= form_password('password_baru', '', ['class' => 'form-control form-control-sm' . ($validation->hasError('password_baru') ? ' is-invalid' : ''), 'id' => 'password_baru', 'placeholder' => 'Ketik password baru']) ?>
        <div class="invalid-feedback">
            <?= $validation->getError('password_baru') ?>
        </div>
    </div>
    <div class="form-group col-md-7">
        <?= form_label('Ulang password baru', '', ['for' => 'password_ulang', 'class' => 'mb-1', 'style' => 'font-weight: 500']) ?>
        <?= form_password('password_ulang', '', ['class' => 'form-control form-control-sm' . ($validation->hasError('password_ulang') ? ' is-invalid' : ''), 'id' => 'password_ulang', 'placeholder' => 'Ketik ulang password baru']) ?>
        <div class="invalid-feedback">
            <?= $validation->getError('password_ulang') ?>
        </div>
    </div>
</div>
<button type="submit" class="btn btn-sm btn-success"><i class="fas fa-lock"></i> Ganti password</button>
<?= form_close() ?>
<?= $this->endSection() ?>