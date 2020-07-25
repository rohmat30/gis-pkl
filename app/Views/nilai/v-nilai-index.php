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

<div class="d-flex justify-content-between">
    <?php if (user()->role != 'siswa') : ?>
        <div class="mb-sm-0 mb-2">
            <?= anchor('nilai/tambah', '<i class="fas fa-pen"></i> Tambah', ['class' => 'btn btn-success']) ?>
        </div>
    <?php endif ?>
    <div>
        <?= form_input(['class' => 'form-control form-control-sm', 'placeholder' => 'Pencarian...', 'id' => 'search-box']) ?>
    </div>
</div>
<div class="table-responsive mt-2">
    <table class="table border table-hover" id="table" data-url="<?= site_url('nilai/json') ?>">
        <thead>
            <tr class="text-center">
                <th rowspan="2" class="align-middle" width="10">#</th>
                <th rowspan="2" class="border-left text-nowrap align-middle">Nama Siswa</th>
                <th rowspan="2" class="border-left text-nowrap align-middle">Tanggal</th>
                <th rowspan="2" class="border-left text-nowrap align-middle text-center">Kehadiran</th>
                <th colspan="3" class="border-left text-nowrap align-middle">Nilai</th>
                <th rowspan="2" class="border-left text-nowrap align-middle text-center">Total</th>
                <th rowspan="2" class="border-left text-nowrap align-middle">Grade</th>
                <th rowspan="2" class="border-left text-nowrap align-middle">Keterangan</th>
                <th rowspan="2" class="border-left text-nowrap align-middle" width="20">Aksi</th>
            </tr>
            <tr>
                <th class="border-left text-center border-top">Kehadiran</th>
                <th class="border-left text-center border-top">Lapangan</th>
                <th class="border-left text-center border-top">Keterampilan</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>


<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="show-detail">
    <div class="modal-dialog shadow-lg" role="document">
        <div class="modal-content">
            <div class="modal-header m-0 py-2">
                <h5 class="modal-title font-weight-normal">Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer py-2">
                <?php if (user()->role == 'staff_tu' || user()->role == 'pembimbing_lapangan') : ?>
                    <a href="" class="btn btn-primary change"><i class="fas fa-edit"></i> Edit nilai</a>
                <?php endif ?>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
            </div>
        </div>
    </div>
</div>
<?php
echo $this->endSection();

// bottom assets
echo $this->section('bottom_assets');
echo script_tag('assets/lib/datatables/js/jquery.dataTables.min.js');
echo script_tag('assets/lib/datatables-bs4/js/dataTables.bootstrap4.min.js');
echo script_tag('assets/js/app/app.nilai.dt.js');

echo $this->endSection()
?>