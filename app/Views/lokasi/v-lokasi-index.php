<?php
echo $this->extend('layout\app');

// head assets
echo $this->section('head_assets');
echo link_tag('assets/lib/datatables-bs4/css/dataTables.bootstrap4.min.css');
echo $this->endSection();


// content
echo $this->section('content');
echo $this->include('layout\components\alert');
echo $this->include('layout\components\js\alert');
?>
<div class="d-flex justify-content-between">
    <div>
        <?= anchor('lokasi/tambah', '<i class="fas fa-university"></i> Tambah lokasi', ['class' => 'btn btn-success']) ?>
    </div>

    <div>
        <?= form_input(['class' => 'form-control form-control-sm', 'placeholder' => 'Pencarian...', 'id' => 'search-box']) ?>
    </div>
</div>
<div class="table-responsive mt-2">
    <table class="table border table-hover" id="table" data-url="<?= site_url('lokasi/json') ?>">
        <thead>
            <th width="10">#</th>
            <th width="32">Foto</th>
            <th>Nama instansi</th>
            <th>Alamat</th>
            <th>PIC</th>
            <th>Status</th>
            <th>Latitude</th>
            <th>Longitude</th>
            <th>Keterangan</th>
            <th width="40">Aksi</th>
        </thead>
        <tbody></tbody>
    </table>
</div>

<?php
echo $this->include('layout\components\modal-delete');
echo $this->include('layout\components\modal-image');
echo $this->endSection();

// bottom assets
echo $this->section('bottom_assets');
echo script_tag('assets/lib/datatables/js/jquery.dataTables.min.js');
echo script_tag('assets/lib/datatables-bs4/js/dataTables.bootstrap4.min.js');
echo script_tag('assets/js/app/app.lokasi.dt.js');
echo $this->endSection()
?>