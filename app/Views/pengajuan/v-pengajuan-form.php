<?php
echo $this->extend('layout\app');

// content
echo $this->section('content');
?>
<div class="row">
    <div class="col-md-3 mb-3">
        <?= form_label('Gambar preview', '', ['for' => 'foto', 'class' => 'mb-1', 'style' => 'font-weight: 500']) ?>
        <div class="img-thumbnail text-center">
            <div style="background: #eee;height: 240px;line-height: 240px;max-height: 100%;overflow:hidden">
                <img src="<?= base_url('assets/img/image-preview.png') ?>" alt="Gambar preview" id="img-preview" style="max-width: 100%; max-height: 240px;">
            </div>
            <div class="progress" id="img-progress" style="display: none;">
                <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <?= form_open_multipart('', ['autocomplete' => 'off']) ?>
        <div class="form-group">
            <?= form_label('Foto', '', ['for' => 'foto', 'class' => 'mb-1', 'style' => 'font-weight: 500']) ?> <i class="fas fa-info-circle text-muted ml-1" rel="tooltip" data-placement="bottom" data-html="true" title="Format file: JPG atau PNG<br>Ukuran file maks. 2MB"></i>
            <div class="custom-file">
                <?= form_upload('foto', '', ['class' => 'custom-file-input' . ($validation->hasError('foto') ? ' is-invalid' : ''), 'id' => 'foto', 'placeholder' => 'Ketik PIC']) ?>
                <div class="invalid-feedback">
                    <?= $validation->getError('foto') ?>
                </div>
                <?= form_label('Pilih foto', '', ['for' => 'foto', 'class' => 'custom-file-label']) ?>
            </div>
        </div>
        <div class="form-group mt-n2">
            <?= form_label('Nama Instansi', '', ['for' => 'nama', 'class' => 'mb-1', 'style' => 'font-weight: 500']) ?>
            <?= form_input('nama', $nama ?? '', ['class' => 'form-control form-control-sm' . ($validation->hasError('nama') ? ' is-invalid' : ''), 'id' => 'nama', 'placeholder' => 'Ketik nama lengkap']) ?>
            <div class="invalid-feedback">
                <?= $validation->getError('nama') ?>
            </div>
        </div>
        <div class="form-group mt-n2">
            <?= form_label('PIC', '', ['for' => 'pic', 'class' => 'mb-1', 'style' => 'font-weight: 500']) ?>
            <?= form_input('pic', $pic ?? '', ['class' => 'form-control form-control-sm' . ($validation->hasError('pic') ? ' is-invalid' : ''), 'id' => 'pic', 'placeholder' => 'Ketik PIC']) ?>
            <div class="invalid-feedback">
                <?= $validation->getError('pic') ?>
            </div>
        </div>
        <div class="form-group mt-n2">
            <?= form_label('Alamat', '', ['for' => 'alamat', 'class' => 'mb-1', 'style' => 'font-weight: 500']) ?>
            <?= form_textarea(['name' => 'alamat', 'rows' => 3], $alamat ?? '', ['class' => 'form-control form-control-sm' . ($validation->hasError('alamat') ? ' is-invalid' : ''), 'id' => 'alamat', 'placeholder' => 'Ketik alamat']) ?>
            <div class="invalid-feedback">
                <?= $validation->getError('alamat') ?>
            </div>
        </div>
        <?= form_button(['type' => 'submit', 'class' => 'btn btn-success btn-sm'], '<i class="far fa-save"></i> Simpan') ?>
        <?= anchor('pengajuan', '<i class="far fa-times-circle"></i> Batal', ['class' => 'btn btn-secondary btn-sm']) ?>
        <?= form_close() ?>
    </div>
</div>
<?php
echo $this->endSection();

// bottom assets
echo $this->section('bottom_assets');
echo script_tag('assets/js/app/app.pengajuan.form.js');
echo $this->endSection()
?>