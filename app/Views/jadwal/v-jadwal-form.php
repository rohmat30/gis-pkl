<?php
echo $this->extend('layout\app');

echo $this->section('head_assets');
echo link_tag('assets/lib/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
echo link_tag('assets/lib/bootstrap-datepicker/css/bootstrap-datepicker3.standalone.min.css');
echo link_tag('assets/lib/select2/css/select2.min.css');
echo link_tag('assets/lib/select2-bs4/select2-bootstrap4.min.css');

echo $this->endSection();

// content
echo $this->section('content');
?>
<div class="row">
    <div class="col-md-7">
        <?= form_open('', ['autocomplete' => 'off']) ?>
        <div class="form-row" id="tanggal">
            <div class="form-group col-6">
                <?= form_label('Tanggal awal', '', ['for' => 'tanggal_awal', 'class' => 'mb-1', 'style' => 'font-weight: 500']) ?>
                <?= form_input('tanggal_awal', $tanggal_awal ?? '', ['class' => 'form-control datepicker form-control-sm' . ($validation->hasError('tanggal_awal') ? ' is-invalid' : ''), 'id' => 'tanggal_awal', 'readonly' => true]) ?>
                <div class="invalid-feedback">
                    <?= $validation->getError('tanggal_awal') ?>
                </div>
            </div>
            <div class="form-group col-6">
                <?= form_label('Tanggal akhir', '', ['for' => 'tanggal_akhir', 'class' => 'mb-1', 'style' => 'font-weight: 500']) ?>
                <?= form_input('tanggal_akhir', $tanggal_akhir ?? '', ['class' => 'form-control datepicker form-control-sm' . ($validation->hasError('tanggal_akhir') ? ' is-invalid' : ''), 'id' => 'tanggal_akhir', 'readonly' => true]) ?>
                <div class="invalid-feedback">
                    <?= $validation->getError('tanggal_akhir') ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <?= form_label('Siswa', '', ['for' => 'siswa_id', 'class' => 'mb-1', 'style' => 'font-weight: 500']) ?>
            <?= form_dropdown('siswa_id', $siswa, $siswa_id ?? '', ['class' => 'form-control form-control-sm' . ($validation->hasError('siswa_id') ? ' is-invalid' : ''), 'id' => 'siswa_id', 'data-url' => site_url('/jadwal/select2/user/siswa'), 'placeholder' => 'Pilih siswa']) ?>
            <div class="invalid-feedback">
                <?= $validation->getError('siswa_id') ?>
            </div>
        </div>

        <div class="form-group">
            <?= form_label('Instansi', '', ['for' => 'instansi_id', 'class' => 'mb-1', 'style' => 'font-weight: 500']) ?>
            <?= form_dropdown('instansi_id', $instansi, $instansi_id ?? '', ['class' => 'form-control form-control-sm' . ($validation->hasError('instansi_id') ? ' is-invalid' : ''), 'id' => 'instansi_id', 'data-url' => site_url('/jadwal/select2/instansi'), 'placeholder' => 'Pilih instansi']) ?>
            <div class="invalid-feedback">
                <?= $validation->getError('instansi_id') ?>
            </div>
        </div>

        <div class="form-group">
            <?= form_label('Pembimbing', '', ['for' => 'pembimbing_id', 'class' => 'mb-1', 'style' => 'font-weight: 500']) ?>
            <?= form_dropdown('pembimbing_id', $pembimbing, $pembimbing_id ?? '', ['class' => 'form-control form-control-sm' . ($validation->hasError('pembimbing_id') ? ' is-invalid' : ''), 'id' => 'pembimbing_id', 'data-url' => site_url('/jadwal/select2/user/pembimbing'), 'placeholder' => 'Pilih pembimbing']) ?>
            <div class="invalid-feedback">
                <?= $validation->getError('pembimbing_id') ?>
            </div>
        </div>

        <div class="form-group">
            <?= form_label('Pembimbing lapangan', '', ['for' => 'pl_id', 'class' => 'mb-1', 'style' => 'font-weight: 500']) ?>
            <?= form_dropdown('pl_id', $pl, $pl_id ?? '', ['class' => 'form-control form-control-sm' . ($validation->hasError('pl_id') ? ' is-invalid' : ''), 'id' => 'pl_id', 'data-url' => site_url('/jadwal/select2/user/pembimbing-lapangan'), 'placeholder' => 'Pilih pembimbing lapangan']) ?>
            <div class="invalid-feedback">
                <?= $validation->getError('pl_id') ?>
            </div>
        </div>

        <?= form_button(['type' => 'submit', 'class' => 'btn btn-success btn-sm'], '<i class="far fa-save"></i> Simpan') ?>
        <?= anchor('pengguna', '<i class="far fa-times-circle"></i> Batal', ['class' => 'btn btn-secondary btn-sm']) ?>
        <?= form_close() ?>
    </div>
</div>
<?php
echo $this->endSection();

echo $this->section('bottom_assets');
echo script_tag('assets/lib/bootstrap-datepicker/js/bootstrap-datepicker.min.js');
echo script_tag('assets/lib/bootstrap-datepicker/locales/bootstrap-datepicker.id.min.js');
echo script_tag('assets/lib/select2/js/select2.min.js');

echo script_tag('assets/js/app/app.jadwal.form.tanggal.js');
echo script_tag('assets/js/app/app.jadwal.form.select2.js');
echo $this->endSection();


?>