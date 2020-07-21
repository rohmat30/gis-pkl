<?php
echo $this->extend('layout\app');

echo $this->section('head_assets');
echo link_tag('assets/lib/leaflet/leaflet.css');
echo script_tag('assets/lib/leaflet/leaflet.js');
echo link_tag('assets/lib/leaflet-control-geocoder/Control.Geocoder.css');
echo script_tag('assets/lib/leaflet-control-geocoder/Control.Geocoder.min.js');
echo $this->endSection();

// content
echo $this->section('content');
?>
<div class="row">
    <div class="col-md-3 mb-3">
        <?= form_label('Gambar preview', '', ['for' => 'foto', 'class' => 'mb-1', 'style' => 'font-weight: 500']) ?>
        <div class="img-thumbnail text-center">
            <div style="background: #eee;height: 240px;line-height: 240px;max-height: 100%;overflow:hidden">
                <img src="<?= base_url((isset($default_foto) && file_exists(ROOTPATH . '/public/uploads/' . $default_foto)) ? '/uploads/' . $default_foto : '/assets/img/image-preview.png') ?>" alt="Gambar preview" id="img-preview" style="max-width: 100%; max-height: 240px;">
            </div>
            <div class="progress" id="img-progress" style="display: none;">
                <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>
    <div class="col-md-5">
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
        <div class="form-group">
            <?= form_label('Nama Instansi', '', ['for' => 'nama', 'class' => 'mb-1', 'style' => 'font-weight: 500']) ?>
            <?= form_input('nama_instansi', $nama_instansi ?? '', ['class' => 'form-control form-control-sm' . ($validation->hasError('nama_instansi') ? ' is-invalid' : ''), 'id' => 'nama_instansi', 'placeholder' => 'Ketik nama instansi']) ?>
            <div class="invalid-feedback">
                <?= $validation->getError('nama_instansi') ?>
            </div>
        </div>

        <div class="form-group mt-n2">
            <?= form_label('Status instansi', '', ['for' => 'status', 'class' => 'mb-1', 'style' => 'font-weight: 500']) ?>
            <?= form_input('status', $status ?? '', ['class' => 'form-control form-control-sm' . ($validation->hasError('status') ? ' is-invalid' : ''), 'id' => 'status', 'placeholder' => 'Ketik status instansi']) ?>
            <div class="invalid-feedback">
                <?= $validation->getError('status') ?>
            </div>
        </div>

        <div class="form-group mt-n2">
            <?= form_label('Koordinat', '', ['for' => 'koordinat', 'class' => 'mb-1', 'style' => 'font-weight: 500']) ?> <i class="fas fa-info-circle text-muted ml-1" rel="tooltip" data-placement="bottom" data-html="true" title="Kordinat menggunakan latitude dan longitude<br>Format: latitude, longitude (dipisah dengan tanda koma)"></i>
            <?= form_input('koordinat', $koordinat ?? '', ['class' => 'form-control form-control-sm' . ($validation->hasError('latitude') || $validation->hasError('longitude') ? ' is-invalid' : ''), 'id' => 'koordinat', 'placeholder' => 'Ketik koordinat, contoh: -6.12345,107.98762']) ?>
            <div class="invalid-feedback">
                <?= $validation->getError('latitude') ? $validation->getError('latitude') : $validation->getError('longitude') ?>
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
            <?= form_textarea(['name' => 'alamat', 'rows' => 2], $alamat ?? '', ['class' => 'form-control form-control-sm' . ($validation->hasError('alamat') ? ' is-invalid' : ''), 'id' => 'alamat', 'placeholder' => 'Ketik alamat']) ?>
            <div class="invalid-feedback">
                <?= $validation->getError('alamat') ?>
            </div>
        </div>

        <div class="form-group mt-n2">
            <?= form_label('Keterangan', '', ['for' => 'keterangan', 'class' => 'mb-1', 'style' => 'font-weight: 500']) ?>
            <?= form_input('keterangan', $keterangan ?? '', ['class' => 'form-control form-control-sm' . ($validation->hasError('keterangan') ? ' is-invalid' : ''), 'id' => 'keterangan', 'placeholder' => 'Ketik keterangan']) ?>
            <div class="invalid-feedback">
                <?= $validation->getError('keterangan') ?>
            </div>
        </div>
        <?= form_button(['type' => 'submit', 'class' => 'btn btn-success btn-sm'], '<i class="far fa-save"></i> Simpan') ?>
        <?= anchor('lokasi', '<i class="far fa-times-circle"></i> Batal', ['class' => 'btn btn-secondary btn-sm']) ?>
        <?= form_close() ?>
    </div>
    <div class="col-md-4">
        <div id="map" style="height: 320px"></div>
    </div>
</div>
<?php
echo $this->endSection();

// bottom assets
echo $this->section('bottom_assets');
echo script_tag('assets/js/app/app.lokasi.form.image.preview.js');
echo script_tag('assets/js/app/app.marker.icon.js');
echo script_tag('assets/js/app/app.instansi.map.js');
echo $this->endSection()
?>