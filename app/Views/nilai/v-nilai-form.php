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
        <div class="form-group">
            <?= form_label('Nama Siswa', '', ['for' => 'jadwal_id', 'class' => 'mb-1', 'style' => 'font-weight: 500']) ?>
            <?php if (empty($nilai_id)) : ?>
                <?= form_dropdown('jadwal_id', $jadwal, $jadwal_id ?? '', ['class' => 'form-control form-control-sm' . ($validation->hasError('jadwal_id') ? ' is-invalid' : ''), 'id' => 'jadwal_id', 'placeholder' => 'Ketik nama siswa', 'data-url' => site_url('nilai/select2')]) ?>
                <div class="invalid-feedback">
                    <?= $validation->getError('jadwal_id') ?>
                </div>
            <?php else : ?>
                <?= form_input('', $nama_siswa, ['class' => 'form-control form-control-sm', 'id' => 'nama_siswa', 'readonly' => true]) ?>
            <?php endif ?>
        </div>

        <div class="form-group">
            <?= form_label('Tanggal', '', ['for' => 'tanggal', 'class' => 'mb-1', 'style' => 'font-weight: 500']) ?>
            <?= form_input('tanggal', $tanggal ?? '', ['class' => 'form-control datepicker form-control-sm' . ($validation->hasError('tanggal') ? ' is-invalid' : ''), 'id' => 'tanggal', 'readonly' => true]) ?>
            <div class="invalid-feedback">
                <?= $validation->getError('tanggal') ?>
            </div>
        </div>

        <div class="form-group">
            <?= form_label('Kehadiran', '', ['for' => 'kehadiran', 'class' => 'mb-1', 'style' => 'font-weight: 500']) ?>
            <div class="input-group input-group-sm">
                <?= form_input(['type' => 'number', 'name' => 'kehadiran'], $kehadiran ?? '', ['class' => 'form-control form-control-sm' . ($validation->hasError('kehadiran') ? ' is-invalid' : ''), 'id' => 'kehadiran', 'placeholder' => 'Ketik jumlah kehadiran', 'min' => 0]) ?>
                <div class="invalid-feedback order-3">
                    <?= $validation->getError('kehadiran') ?>
                </div>
                <div class="input-group-append">
                    <span class="input-group-text">hari</span>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-6">
                <?= form_label('Nilai kehadiran', '', ['for' => 'nilai_kehadiran', 'class' => 'mb-1', 'style' => 'font-weight: 500']) ?> <i class="fas fa-info-circle text-muted ml-1" rel="tooltip" data-placement="bottom" title="Range nilai 1 sampai 100"></i>
                <?= form_input(['type' => 'number', 'name' => 'nilai_kehadiran'], $nilai_kehadiran ?? '', ['class' => 'form-control form-control-sm' . ($validation->hasError('nilai_kehadiran') ? ' is-invalid' : ''), 'id' => 'nilai_kehadiran', 'placeholder' => 'Ketik nilai kehadiran', 'min' => 0, 'max' => '100']) ?>
                <div class="invalid-feedback">
                    <?= $validation->getError('nilai_kehadiran') ?>
                </div>
            </div>

            <div class="form-group col-6">
                <?= form_label('Nilai lapangan', '', ['for' => 'nilai_lapangan', 'class' => 'mb-1', 'style' => 'font-weight: 500']) ?> <i class="fas fa-info-circle text-muted ml-1" rel="tooltip" data-placement="bottom" title="Range nilai 1 sampai 100"></i>
                <?= form_input(['type' => 'number', 'name' => 'nilai_lapangan'], $nilai_lapangan ?? '', ['class' => 'form-control form-control-sm' . ($validation->hasError('nilai_lapangan') ? ' is-invalid' : ''), 'id' => 'nilai_lapangan', 'placeholder' => 'Ketik nilai lapangan', 'min' => 0, 'max' => '100']) ?>
                <div class="invalid-feedback">
                    <?= $validation->getError('nilai_lapangan') ?>
                </div>
            </div>

            <div class="form-group col-6">
                <?= form_label('Nilai keterampilan', '', ['for' => 'nilai_keterampilan', 'class' => 'mb-1', 'style' => 'font-weight: 500']) ?> <i class="fas fa-info-circle text-muted ml-1" rel="tooltip" data-placement="bottom" title="Range nilai 1 sampai 100"></i>
                <?= form_input(['type' => 'number', 'name' => 'nilai_keterampilan'], $nilai_keterampilan ?? '', ['class' => 'form-control form-control-sm' . ($validation->hasError('nilai_keterampilan') ? ' is-invalid' : ''), 'id' => 'nilai_keterampilan', 'placeholder' => 'Ketik nilai keterampilan', 'min' => 0, 'max' => '100']) ?>
                <div class="invalid-feedback">
                    <?= $validation->getError('nilai_keterampilan') ?>
                </div>
            </div>

            <div class="form-group col-6">
                <?= form_label('Nilai grade', '', ['for' => 'grade', 'class' => 'mb-1', 'style' => 'font-weight: 500']) ?>
                <?= form_dropdown('grade', ['' => '- Pilih -', 'a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D', 'e' => 'E'], $grade ?? '', ['class' => 'form-control form-control-sm' . ($validation->hasError('grade') ? ' is-invalid' : ''), 'id' => 'grade', 'placeholder' => 'Ketik nilai grade']) ?>
                <div class="invalid-feedback">
                    <?= $validation->getError('grade') ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <?= form_label('Keterangan', '', ['for' => 'keterangan', 'class' => 'mb-1', 'style' => 'font-weight: 500']) ?>
            <?= form_input('keterangan', $keterangan ?? '', ['class' => 'form-control form-control-sm' . ($validation->hasError('keterangan') ? ' is-invalid' : ''), 'id' => 'keterangan', 'placeholder' => 'Ketik keterangan']) ?>
            <div class="invalid-feedback">
                <?= $validation->getError('keterangan') ?>
            </div>
        </div>


        <?= form_button(['type' => 'submit', 'class' => 'btn btn-success btn-sm'], '<i class="far fa-save"></i> Simpan' . (isset($nilai_id) ? ' Perubahan' : '')) ?>
        <?= anchor('nilai', '<i class="far fa-times-circle"></i> Batal', ['class' => 'btn btn-secondary btn-sm']) ?>
        <?= form_close() ?>
    </div>
</div>
<?php
echo $this->endSection();

echo $this->section('bottom_assets');
echo script_tag('assets/lib/bootstrap-datepicker/js/bootstrap-datepicker.min.js');
echo script_tag('assets/lib/bootstrap-datepicker/locales/bootstrap-datepicker.id.min.js');
echo script_tag('assets/lib/select2/js/select2.min.js');

echo script_tag('assets/js/app/app.nilai.form.select2.js');
echo script_tag('assets/js/app/app.nilai.form.tanggal.js');
echo $this->endSection();


?>