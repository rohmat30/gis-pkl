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
<?php if (user()->role == 'staff_tu') : ?>
    <div class="d-flex justify-content-between">
        <div>
            <?= anchor('jadwal/tambah', '<i class="far fa-calendar-alt"></i> Tambah jadwal', ['class' => 'btn btn-success']) ?>
        </div>

        <div>
            <?= form_input(['class' => 'form-control form-control-sm', 'placeholder' => 'Pencarian...', 'id' => 'search-box']) ?>
        </div>
    </div>
<?php endif ?>
<div class="table-responsive mt-2">
    <table class="table border table-hover" id="table" data-url="<?= site_url('jadwal/json') ?>">
        <thead>
            <th width="10">#</th>
            <th>Nama Siswa</th>
            <th>Tanggal awal</th>
            <th>Tanggal akhir</th>
            <th>Instansi</th>
            <th>Pembimbing</th>
            <th>Pembimbing lapangan</th>

            <?php if (user()->role == 'staff_tu') : ?>
                <th width="40">Aksi</th>
            <?php endif ?>
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

if (user()->role == 'staff_tu') {
    echo script_tag('assets/js/app/app.jadwal.staff.dt.js');
} else {
    echo script_tag('assets/js/app/app.jadwal.dt.js');
}
echo $this->endSection()
?>