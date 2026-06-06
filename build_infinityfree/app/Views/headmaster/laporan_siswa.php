<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>
<div class="content">
  <div class="container-fluid">
    <div class="row mb-3">
      <div class="col-12">
        <a href="<?= base_url('headmaster') ?>" class="btn btn-secondary btn-sm">
          <i class="material-icons" style="font-size:16px;vertical-align:middle;">arrow_back</i> Kembali
        </a>
        <h4 class="mt-2 font-weight-bold">Laporan Absensi Siswa</h4>
      </div>
    </div>

    <!-- Filter -->
    <div class="card">
      <div class="card-body">
        <form method="GET" action="<?= base_url('headmaster/laporan-siswa') ?>" class="row align-items-end">
          <div class="col-md-3">
            <label>Dari Tanggal</label>
            <input type="date" name="dari" class="form-control" value="<?= $tanggalMulai ?>">
          </div>
          <div class="col-md-3">
            <label>Sampai Tanggal</label>
            <input type="date" name="sampai" class="form-control" value="<?= $tanggalSelesai ?>">
          </div>
          <div class="col-md-3">
            <label>Kelas</label>
            <select name="id_kelas" class="custom-select">
              <option value="">-- Semua Kelas --</option>
              <?php foreach ($kelas as $k): ?>
                <option value="<?= $k['id_kelas'] ?>" <?= $idKelas == $k['id_kelas'] ? 'selected' : '' ?>>
                  <?= $k['kelas'] ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-3">
            <button type="submit" class="btn btn-primary w-100">
              <i class="material-icons" style="font-size:16px;vertical-align:middle;">search</i> Filter
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Tabel Laporan -->
    <div class="card">
      <div class="card-header card-header-primary">
        <h4 class="card-title"><b>Rekap Absensi Siswa</b></h4>
        <p class="card-category"><?= date('d M Y', strtotime($tanggalMulai)) ?> s/d <?= date('d M Y', strtotime($tanggalSelesai)) ?></p>
      </div>
      <div class="card-body table-responsive">
        <?php if (!empty($laporan)): ?>
          <table class="table table-hover table-striped">
            <thead class="text-primary">
              <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Jam Masuk</th>
                <th>Jam Pulang</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; foreach ($laporan as $row): ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= date('d/m/Y', strtotime($row['tanggal'])) ?></td>
                  <td><b><?= esc($row['nama_siswa']) ?></b></td>
                  <td><?= esc($row['kelas'] ?? '-') ?></td>
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
