<?php
echo $this->extend('layout\app');

echo $this->section('head_assets');
echo link_tag('assets/lib/select2/css/select2.min.css');
echo link_tag('assets/lib/select2-bs4/select2-bootstrap4.min.css');

echo $this->endSection();

// content
echo $this->section('content');
?>
<div class="row">
    <div class="col-md-7">
        <?= form_open('', ['autocomplete' => 'off']) ?>
        <div class="form-group">
            <?= form_label('Nama siswa', '', ['for' => 'nilai_id', 'class' => 'mb-1', 'style' => 'font-weight: 500']) ?>
            <?php if (empty($evaluasi_id)) : ?>
                <?= form_dropdown('nilai_id', $nilai, $nilai_id ?? '', ['class' => 'form-control form-control-sm' . ($validation->hasError('nilai_id') ? ' is-invalid' : ''), 'id' => 'nilai_id', 'placeholder' => 'Ketik nama siswa', 'data-url' => site_url('evaluasi/select2')]) ?>
                <div class="invalid-feedback">
                    <?= $validation->getError('nilai_id') ?>
                </div>
            <?php else : ?>
                <?= form_input('', $nama_siswa, ['class' => 'form-control form-control-sm', 'readonly' => true]) ?>
            <?php endif ?>
        </div>

        <div class="form-group">
            <?= form_label('Keterangan', '', ['for' => 'keterangan', 'class' => 'mb-1', 'style' => 'font-weight: 500']) ?>
            <?= form_input('keterangan', $keterangan ?? '', ['class' => 'form-control form-control-sm' . ($validation->hasError('keterangan') ? ' is-invalid' : ''), 'id' => 'keterangan', 'placeholder' => 'Ketik keterangan']) ?>
            <div class="invalid-feedback">
                <?= $validation->getError('keterangan') ?>
            </div>
        </div>

        <div class="form-group">
            <?= form_label('Kelulusan', '', ['for' => 'kelulusan', 'class' => 'mb-1', 'style' => 'font-weight: 500']) ?>
            <?= form_input('kelulusan', $kelulusan ?? '', ['class' => 'form-control form-control-sm' . ($validation->hasError('kelulusan') ? ' is-invalid' : ''), 'id' => 'kelulusan', 'placeholder' => 'Ketik kelulusan']) ?>
            <div class="invalid-feedback">
                <?= $validation->getError('kelulusan') ?>
            </div>
        </div>

        <div class="form-group">
            <?= form_label('Hasil evaluasi', '', ['for' => 'hasil_evaluasi', 'class' => 'mb-1', 'style' => 'font-weight: 500']) ?>
            <?= form_input('hasil_evaluasi', $hasil_evaluasi ?? '', ['class' => 'form-control form-control-sm' . ($validation->hasError('hasil_evaluasi') ? ' is-invalid' : ''), 'id' => 'hasil_evaluasi', 'placeholder' => 'Ketik hasil evaluasi']) ?>
            <div class="invalid-feedback">
                <?= $validation->getError('hasil_evaluasi') ?>
            </div>
        </div>
        <?= form_button(['type' => 'submit', 'class' => 'btn btn-success btn-sm'], '<i class="far fa-save"></i> Simpan' . (isset($evaluasi_id) ? ' perubahan' : '')) ?>
        <?= anchor('evaluasi', '<i class="far fa-times-circle"></i> Batal', ['class' => 'btn btn-secondary btn-sm']) ?>
        <?= form_close() ?>
    </div>
</div>
<?php
echo $this->endSection();

if (empty($evaluasi_id)) {
    echo $this->section('bottom_assets');
    echo script_tag('assets/lib/select2/js/select2.min.js');

    echo script_tag('assets/js/app/app.evaluasi.form.select2.js');
    echo $this->endSection();
}

?>