<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>
<div class="content">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-8">

        <!-- Profile Header -->
        <div class="card" style="background:linear-gradient(135deg,#667eea,#764ba2);color:white;border:none;border-radius:16px;margin-bottom:20px;">
          <div class="card-body text-center py-5">
            <div style="width:80px;height:80px;border-radius:50%;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:36px;font-weight:700;">
              <?= strtoupper(substr(user()->username, 0, 1)) ?>
            </div>
            <h4 style="font-weight:700;margin-bottom:4px;">
              <?= esc($siswa['nama_siswa'] ?? user()->username) ?>
            </h4>
            <p style="opacity:0.8;margin-bottom:0;font-size:14px;">
              <?php if (!empty($siswa)): ?>
                Siswa · Kelas <?= esc($siswa['kelas'] ?? '-') ?>
              <?php else: ?>
                Siswa (Belum terhubung ke data)
              <?php endif; ?>
            </p>
          </div>
        </div>

        <!-- Info Card -->
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title"><b>Data Profil</b></h4>
          </div>
          <div class="card-body">
            <?php if (!empty($siswa)): ?>
              <table class="table table-borderless">
                <tr>
                  <td style="color:#777;width:40%;">Nama Lengkap</td>
                  <td><b><?= esc($siswa['nama_siswa']) ?></b></td>
                </tr>
                <tr>
                  <td style="color:#777;">Kelas</td>
                  <td><b><?= esc($siswa['kelas'] ?? '-') ?></b></td>
                </tr>
                <tr>
                  <td style="color:#777;">Jenis Kelamin</td>
                  <td><b><?= esc($siswa['jenis_kelamin'] ?? '-') ?></b></td>
                </tr>
                <tr>
                  <td style="color:#777;">No. HP</td>
                  <td><b><?= esc($siswa['no_hp'] ?? '-') ?></b></td>
                </tr>
              </table>
              <hr>
            <?php else: ?>
              <div class="alert alert-warning">
                <i class="material-icons" style="font-size:16px;vertical-align:middle;">warning</i>
                Akun belum terhubung ke data siswa. Hubungi admin untuk menghubungkan akun Anda.
              </div>
              <hr>
            <?php endif; ?>

            <h6 style="font-weight:700;margin-bottom:12px;">Informasi Akun</h6>
            <table class="table table-borderless">
              <tr>
                <td style="color:#777;width:40%;">Username</td>
                <td><b><?= esc($user->username) ?></b></td>
              </tr>
              <tr>
                <td style="color:#777;">Email</td>
                <td><b><?= esc($user->email) ?></b></td>
              </tr>
              <tr>
                <td style="color:#777;">Status Akun</td>
                <td>
                  <span class="badge badge-<?= $user->active ? 'success' : 'danger' ?>">
                    <?= $user->active ? 'Aktif' : 'Tidak Aktif' ?>
                  </span>
                </td>
              </tr>
            </table>

            <div class="mt-3">
              <a href="<?= base_url('student/qr/download') ?>" class="btn btn-primary">
                <i class="material-icons" style="font-size:16px;vertical-align:middle;">qr_code</i>
                Download QR Code Saya
              </a>
              <a href="<?= base_url('student/dashboard') ?>" class="btn btn-secondary ml-2">
                <i class="material-icons" style="font-size:16px;vertical-align:middle;">arrow_back</i>
                Kembali ke Dashboard
              </a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
