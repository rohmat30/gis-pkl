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
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" id="pengajuan-tab" data-toggle="tab" href="#pengajuan" role="tab" aria-controls="pengajuan" aria-selected="true">Pengajuan</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="persetujuan-tab" data-toggle="tab" href="#persetujuan" role="tab" aria-controls="persetujuan" aria-selected="false">Disetujui</a>
    </li>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="pengajuan" role="tabpanel" aria-labelledby="pengajuan-tab">
        <div class="d-sm-flex justify-content-sm-between mt-3">
            <div>
                <?= form_input(['class' => 'form-control form-control-sm', 'placeholder' => 'Pencarian...', 'id' => 'search-box']) ?>
            </div>
        </div>
        <div class="table-responsive mt-2">
            <table class="table border table-hover" id="table-pengajuan" data-url="<?= site_url('pengajuan/json') ?>">
                <thead>
                    <th width="10">#</th>
                    <th width="32">Foto</th>
                    <th>ID Siswa</th>
                    <th>Nama Siswa</th>
                    <th>Nama Instansi</th>
                    <th>Alamat</th>
                    <th>PIC</th>
                    <th width="20">Aksi</th>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <div class="tab-pane fade" id="persetujuan" role="tabpanel" aria-labelledby="persetujuan-tab">
        <div class="d-sm-flex justify-content-sm-between mt-3">
            <div>
                <?= form_input(['class' => 'form-control form-control-sm', 'placeholder' => 'Pencarian...', 'id' => 'search-box-setuju']) ?>
            </div>
        </div>
        <div class="table-responsive mt-2">
            <table class="table border table-hover" id="table-setuju" data-url="<?= site_url('persetujuan/json') ?>">
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
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<?php
echo $this->include('layout\components\modal-delete');
echo $this->include('layout\components\modal-image');
echo $this->endSection();

// bottom assets
echo $this->section('bottom_assets');
echo script_tag('assets/lib/datatables/js/jquery.dataTables.min.js');
echo script_tag('assets/lib/datatables-bs4/js/dataTables.bootstrap4.min.js');
echo script_tag('assets/js/app/app.persetujuan.pengajuan.dt.js');
echo script_tag('assets/js/app/app.persetujuan.instansi.dt.js');
echo $this->endSection()
?>