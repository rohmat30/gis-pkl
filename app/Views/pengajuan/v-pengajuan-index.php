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
        <?= anchor('pengajuan/tambah', '<i class="fas fa-university"></i> Buat pengajuan', ['class' => 'btn btn-success']) ?>
    </div>
</div>
<div class="table-responsive mt-2">
    <table class="table border table-hover" id="table" data-url="<?= site_url('pengajuan/json') ?>">
        <thead>
            <th width="10">#</th>
            <th width="32">Foto</th>
            <th>Nama instansi</th>
            <th>Alamat</th>
            <th>PIC</th>
            <th width="50">Status</th>
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
echo script_tag('assets/js/app/app.pengajuan.dt.js');
echo $this->endSection()
?>