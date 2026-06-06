<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>

<div class="content">
  <div class="container-fluid">

    <!-- Header -->
    <div class="row mb-4">
      <div class="col-12">
        <div class="card" style="background: linear-gradient(135deg, #1a237e 0%, #283593 100%); color:white; border-radius:16px; border:none;">
          <div class="card-body py-4 px-4">
            <div class="d-flex align-items-center">
              <i class="material-icons" style="font-size:48px; opacity:.8;">school</i>
              <div class="ml-3">
                <h3 class="mb-0 font-weight-bold">Selamat Datang, Kepala Sekolah</h3>
                <p class="mb-0" style="opacity:.8;">Pantau kehadiran siswa dan guru secara real-time</p>
                <small style="opacity:.7;">Tanggal: <?= date('d F Y', strtotime($today)) ?></small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row">
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card">
          <div class="card-header card-header-warning card-header-icon">
            <div class="card-icon"><i class="material-icons">people</i></div>
            <p class="card-category">Total Siswa</p>
            <h3 class="card-title"><?= $totalSiswa ?></h3>
          </div>
          <div class="card-footer"><div class="stats"><i class="material-icons">person</i> Terdaftar</div></div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card">
          <div class="card-header card-header-success card-header-icon">
            <div class="card-icon"><i class="material-icons">supervisor_account</i></div>
            <p class="card-category">Total Guru</p>
            <h3 class="card-title"><?= $totalGuru ?></h3>
          </div>
          <div class="card-footer"><div class="stats"><i class="material-icons">school</i> Terdaftar</div></div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon"><i class="material-icons">how_to_reg</i></div>
            <p class="card-category">Siswa Hadir Hari Ini</p>
            <h3 class="card-title"><?= $absenSiswaHariIni ?></h3>
          </div>
          <div class="card-footer"><div class="stats"><i class="material-icons">today</i> <?= date('d/m/Y') ?></div></div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card">
          <div class="card-header card-header-danger card-header-icon">
            <div class="card-icon"><i class="material-icons">assignment_turned_in</i></div>
            <p class="card-category">Guru Hadir Hari Ini</p>
            <h3 class="card-title"><?= $absenGuruHariIni ?></h3>
          </div>
          <div class="card-footer"><div class="stats"><i class="material-icons">today</i> <?= date('d/m/Y') ?></div></div>
        </div>
      </div>
    </div>

    <!-- Quick Links -->
    <div class="row mb-3">
      <div class="col-12">
        <a href="<?= base_url('headmaster/laporan-siswa') ?>" class="btn btn-primary mr-2">
          <i class="material-icons mr-1">assessment</i> Laporan Absensi Siswa
        </a>
        <a href="<?= base_url('headmaster/laporan-guru') ?>" class="btn btn-success">
          <i class="material-icons mr-1">bar_chart</i> Laporan Absensi Guru
        </a>
      </div>
    </div>

    <div class="row">
      <!-- Tabel Absen Siswa Hari Ini -->
      <div class="col-md-6">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title"><b>Kehadiran Siswa Hari Ini</b></h4>
            <p class="card-category"><?= count($dataSiswaHariIni) ?> siswa sudah absen</p>
          </div>
          <div class="card-body table-responsive" style="max-height:350px;overflow-y:auto;">
            <?php if (!empty($dataSiswaHariIni)): ?>
              <table class="table table-hover table-sm">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Masuk</th>
                    <th>Pulang</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($dataSiswaHariIni as $row): ?>
                    <tr>
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
              <p class="text-center text-muted mt-3">Belum ada siswa yang absen hari ini</p>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- Tabel Absen Guru Hari Ini -->
      <div class="col-md-6">
        <div class="card">
          <div class="card-header card-header-success">
            <h4 class="card-title"><b>Kehadiran Guru Hari Ini</b></h4>
            <p class="card-category"><?= count($dataGuruHariIni) ?> guru sudah absen</p>
          </div>
          <div class="card-body table-responsive" style="max-height:350px;overflow-y:auto;">
            <?php if (!empty($dataGuruHariIni)): ?>
              <table class="table table-hover table-sm">
                <thead>
                  <tr>
                    <th>Nama Guru</th>
                    <th>Kode</th>
                    <th>Masuk</th>
                    <th>Pulang</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($dataGuruHariIni as $row): ?>
                    <tr>
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
              <p class="text-center text-muted mt-3">Belum ada guru yang absen hari ini</p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
<?= $this->endSection() ?>
