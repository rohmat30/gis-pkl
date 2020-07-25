<table class="table table-borderless">
    <tr>
        <th>Nama Siswa</th>
        <td>:</td>
        <td><?= $row->nama_siswa ?></td>
    </tr>
    <tr>
        <th>Nama Instansi</th>
        <td>:</td>
        <td><?= $row->nama_instansi ?></td>
    </tr>
    <tr>
        <th>Nama Pembimbing</th>
        <td>:</td>
        <td><?= $row->nama_pembimbing ?></td>
    </tr>
    <tr>
        <th>Nama Pembimbing Lapangan</th>
        <td>:</td>
        <td><?= $row->nama_pl ?></td>
    </tr>
    <tr>
        <th>Tanggal</th>
        <td>:</td>
        <td><?= $row->tanggal ?? 'Belum dinilai' ?></td>
    </tr>
    <tr>
        <th>Kehadiran</th>
        <td>:</td>
        <td><?= $row->kehadiran ?? 0 ?></td>
    </tr>
    <tr>
        <th>Nilai kehadiran</th>
        <td>:</td>
        <td><?= $row->nilai_kehadiran ?? 0 ?></td>
    </tr>
    <tr>
        <th>Nilai lapangan</th>
        <td>:</td>
        <td><?= $row->nilai_lapangan ?? 0 ?></td>
    </tr>
    <tr>
        <th>Nilai keterampilan</th>
        <td>:</td>
        <td><?= $row->nilai_keterampilan ?? 0 ?></td>
    </tr>
    <tr>
        <th>Nilai total</th>
        <td>:</td>
        <td><?= $row->nilai_total ?? 0 ?></td>
    </tr>
    <tr>
        <th>Nilai grade</th>
        <td>:</td>
        <td><?= $row->grade ?? '-' ?></td>
    </tr>
    <tr>
        <th>Keterangan</th>
        <td>:</td>
        <td><?= $row->keterangan ?? '-' ?></td>
    </tr>
</table>