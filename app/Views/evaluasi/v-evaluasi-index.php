<?php
echo $this->extend('layout\app');

// head assets
echo $this->section('head_assets');
echo link_tag('assets/lib/datatables-bs4/css/dataTables.bootstrap4.min.css');
echo $this->endSection();


// content
echo $this->section('content');
echo $this->include('layout\components\alert');
?>
<div class="d-sm-flex justify-content-sm-between">
    <?php if (user()->role == 'kajur') : ?>
        <div class="mb-sm-0 mb-2">
            <?= anchor('evaluasi/tambah', '<i class="fas fa-vector-square"></i> Tambah', ['class' => 'btn btn-success']) ?>
        </div>
    <?php endif ?>
    <div>
        <?= form_input(['class' => 'form-control form-control-sm', 'placeholder' => 'Pencarian...', 'id' => 'search-box']) ?>
    </div>
</div>
<div class="table-responsive mt-2">
    <table class="table border table-hover" id="table" data-url="<?= site_url('evaluasi/json') ?>">
        <thead>
            <th width="10">#</th>
            <th>Nama Siswa</th>
            <th>Total Nilai</th>
            <th>Keterangan</th>
            <th>Kelulusan</th>
            <th>Hasil Evaluasi</th>
            <?php if (user()->role == 'kajur') : ?>
                <th width=32>Aksi</th>
            <?php endif ?>
        </thead>
        <tbody></tbody>
    </table>
</div>
<?php
echo $this->include('layout\components\modal-delete');
echo $this->endSection();

// bottom assets
echo $this->section('bottom_assets');
echo script_tag('assets/lib/datatables/js/jquery.dataTables.min.js');
echo script_tag('assets/lib/datatables-bs4/js/dataTables.bootstrap4.min.js');
if (user()->role == 'kajur') {
    echo script_tag('assets/js/app/app.evaluasi.kelola.dt.js');
} else {
    echo script_tag('assets/js/app/app.evaluasi.dt.js');
}
echo $this->endSection()
?>