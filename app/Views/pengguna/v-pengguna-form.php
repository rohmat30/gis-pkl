<?php
echo $this->extend('layout\app');

// content
echo $this->section('content');
?>
<div class="row">
    <div class="col-md-7">
        <?= form_open('', ['autocomplete' => 'off']) ?>
        <div class="form-group">
            <?= form_label('Nama lengkap', '', ['for' => 'nama', 'class' => 'mb-1', 'style' => 'font-weight: 500']) ?>
            <?= form_input('nama', $nama ?? '', ['class' => 'form-control form-control-sm' . ($validation->hasError('nama') ? ' is-invalid' : ''), 'id' => 'nama', 'placeholder' => 'Ketik nama lengkap']) ?>
            <div class="invalid-feedback">
                <?= $validation->getError('nama') ?>
            </div>
        </div>
        <div class="form-group mt-n2">
            <?= form_label('Username', '', ['for' => 'username', 'class' => 'mb-1', 'style' => 'font-weight: 500']) ?>
            <?= form_input('username', $username ?? '', ['class' => 'form-control form-control-sm' . ($validation->hasError('username') ? ' is-invalid' : ''), 'id' => 'username', 'placeholder' => 'Ketik username']) ?>
            <div class="invalid-feedback">
                <?= $validation->getError('username') ?>
            </div>
        </div>
        <div class="form-group mt-n2">
            <?= form_label('Password', '', ['for' => 'password', 'class' => 'mb-1', 'style' => 'font-weight: 500']) ?> <i class="fas fa-info-circle text-muted ml-1" rel="tooltip" data-placement="bottom" data-html="true" title="<small><?= isset($edit_id) ? 'Kosongkan jika tidak ingin mengubah password' : 'Password default <i class=\'text-success\'>12345</i> jika form tidak diisi.' ?></small>"></i>
            <?= form_input('password', $password ?? '', ['class' => 'form-control form-control-sm' . ($validation->hasError('password') ? ' is-invalid' : ''), 'id' => 'password', 'placeholder' => 'Ketik password']) ?>
            <div class="invalid-feedback">
                <?= $validation->getError('password') ?>
            </div>
        </div>
        <div class="form-group mt-n2">
            <?= form_label('Level user', '', ['for' => 'role', 'class' => 'mb-1', 'style' => 'font-weight: 500']) ?>
            <?= form_dropdown('role', array_merge(['' => '- Pilih -'], $roles), $role, ['class' => 'form-control form-control-sm' . ($validation->hasError('role') ? ' is-invalid' : ''), 'id' => 'role']); ?>
            <div class="invalid-feedback">
                <?= $validation->getError('role') ?>
            </div>
        </div>
        <?= form_button(['type' => 'submit', 'class' => 'btn btn-success btn-sm'], '<i class="far fa-save"></i> Simpan') ?>
        <?= anchor('pengguna', '<i class="far fa-times-circle"></i> Batal', ['class' => 'btn btn-secondary btn-sm']) ?>
        <?= form_close() ?>
    </div>
</div>
<?php
echo $this->endSection();
?>