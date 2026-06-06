<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>
<div class="content">
  <div class="container-fluid">
    <div class="row mb-3">
      <div class="col-12">
        <a href="<?= base_url('headmaster') ?>" class="btn btn-secondary btn-sm">
          <i class="material-icons" style="font-size:16px;vertical-align:middle;">arrow_back</i> Kembali
        </a>
        <h4 class="mt-2 font-weight-bold">Laporan Absensi Guru</h4>
      </div>
    </div>

    <div class="card">
      <div class="card-body">
        <form method="GET" action="<?= base_url('headmaster/laporan-guru') ?>" class="row align-items-end">
          <div class="col-md-4">
            <label>Dari Tanggal</label>
            <input type="date" name="dari" class="form-control" value="<?= $tanggalMulai ?>">
          </div>
          <div class="col-md-4">
            <label>Sampai Tanggal</label>
            <input type="date" name="sampai" class="form-control" value="<?= $tanggalSelesai ?>">
          </div>
          <div class="col-md-4">
            <button type="submit" class="btn btn-success w-100">
              <i class="material-icons" style="font-size:16px;vertical-align:middle;">search</i> Filter
            </button>
          </div>
        </form>
      </div>
    </div>

    <div class="card">
      <div class="card-header card-header-success">
        <h4 class="card-title"><b>Rekap Absensi Guru</b></h4>
        <p class="card-category"><?= date('d M Y', strtotime($tanggalMulai)) ?> s/d <?= date('d M Y', strtotime($tanggalSelesai)) ?></p>
      </div>
      <div class="card-body table-responsive">
        <?php if (!empty($laporan)): ?>
          <table class="table table-hover table-striped">
            <thead class="text-success">
              <tr>
                <th>No</th><th>Tanggal</th><th>Nama Guru</th><th>Kode Guru</th>
                <th>Jam Masuk</th><th>Jam Pulang</th><th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; foreach ($laporan as $row): ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= date('d/m/Y', strtotime($row['tanggal'])) ?></td>
                  <td><b><?= esc($row['nama_guru']) ?></b></td>
                  <td><?= esc($row['kode_guru'] ?? '-') ?></td>
                  <td><?= $row['jam_masuk'] ?? '-' ?></td>
                  <td><?= $row['jam_keluar'] ?? '-' ?></td>
                  <td>
                    <span class="badge badge-<?= $row['jam_masuk'] ? 'success' : 'secondary' ?>">
                      <?= $row['kehadiran'] ?? 'Hadir' ?>
                    </span>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php else: ?>
          <p class="text-center text-danger mt-3">Tidak ada data pada rentang tanggal ini</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
