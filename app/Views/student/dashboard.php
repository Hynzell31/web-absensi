<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('styles') ?>
<style>
.stat-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: var(--primary-light);
    color: var(--primary);
    border-radius: 100px;
    padding: 4px 14px;
    font-size: 12.5px;
    font-weight: 600;
}
.attendance-row {
    transition: var(--transition);
    cursor: default;
}
.attendance-row:hover { background: var(--bg-body); }
.status-hadir { color: var(--success); font-weight: 600; }
.status-sakit { color: var(--warning); font-weight: 600; }
.status-izin  { color: var(--info); font-weight: 600; }
.status-alfa  { color: var(--danger); font-weight: 600; }
.qr-preview-box {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    border-radius: var(--radius-xl);
    padding: 32px;
    text-align: center;
    color: white;
}
.qr-preview-box img {
    border-radius: var(--radius-md);
    border: 4px solid rgba(255,255,255,0.25);
    background: white;
    padding: 8px;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content">
    <div class="container-fluid">

        <?php if (empty($siswa)): ?>
        <!-- Akun belum terhubung -->
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card text-center" style="padding: 60px 40px;">
                    <div style="font-size:72px;margin-bottom:16px;">🔗</div>
                    <h4 style="font-weight:700;color:var(--text-dark);">Akun Belum Terhubung</h4>
                    <p style="color:var(--text-light);max-width:340px;margin:0 auto 24px;">
                        Akun Anda belum terhubung ke data siswa. Silahkan hubungi administrator sekolah untuk menghubungkan akun Anda.
                    </p>
                    <div class="alert alert-info" style="display:inline-block;max-width:360px;margin:0 auto;">
                        <i class="material-icons" style="vertical-align:middle;font-size:16px;">info</i>
                        Beritahu admin username Anda: <b><?= user()->username ?></b>
                    </div>
                    <div class="mt-4">
                        <a href="https://wa.me/62085869786858" target="_blank" class="btn btn-success">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="#fff" style="vertical-align:middle;margin-right:6px;"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            Hubungi Admin via WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <?php else: ?>
        <!-- Dashboard Siswa -->
        <div class="row">
            <!-- Info & QR Card -->
            <div class="col-lg-4">
                <div class="qr-preview-box mb-4">
                    <p style="font-size:13px;opacity:0.8;margin-bottom:8px;">QR Code Absensi Saya</p>
                    <?php
                    // Generate QR code on-the-fly for display
                    $qrDataUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=' . urlencode($siswa['unique_code']);
                    ?>
                    <img src="<?= $qrDataUrl ?>" alt="QR Code" width="160" height="160" class="mb-3">
                    <h5 style="font-weight:700;margin-bottom:4px;"><?= esc($siswa['nama_siswa']) ?></h5>
                    <p style="opacity:0.75;font-size:13px;margin-bottom:20px;">
                        Kelas <?= esc($kelas->kelas ?? '-') ?>
                    </p>
                    <a href="<?= base_url('student/qr/download') ?>" class="btn"
                       style="background:rgba(255,255,255,0.2);color:#fff;border:1.5px solid rgba(255,255,255,0.4);width:100%;">
                       <i class="material-icons" style="font-size:16px;vertical-align:middle;">download</i>
                       Download QR Code Saya
                    </a>
                </div>

                <!-- Info Card -->
                <div class="card">
                    <div class="card-body">
                        <h6 style="font-weight:700;color:var(--text-dark);margin-bottom:14px;">Informasi Saya</h6>
                        <table style="width:100%;font-size:13px;">
                            <tr>
                                <td style="color:var(--text-light);padding:5px 0;width:40%;">Nama</td>
                                <td style="font-weight:600;color:var(--text-dark);"><?= esc($siswa['nama_siswa']) ?></td>
                            </tr>
                            <tr>
                                <td style="color:var(--text-light);padding:5px 0;">Kelas</td>
                                <td style="font-weight:600;"><?= esc($kelas->kelas ?? '-') ?></td>
                            </tr>
                            <tr>
                                <td style="color:var(--text-light);padding:5px 0;">Jenis Kelamin</td>
                                <td style="font-weight:600;"><?= esc($siswa['jenis_kelamin'] ?? '-') ?></td>
                            </tr>
                            <tr>
                                <td style="color:var(--text-light);padding:5px 0;">No. HP</td>
                                <td style="font-weight:600;"><?= esc($siswa['no_hp'] ?? '-') ?></td>
                            </tr>
                            <tr>
                                <td style="color:var(--text-light);padding:5px 0;">Username</td>
                                <td style="font-weight:600;"><?= esc(user()->username) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Absensi & Riwayat -->
            <div class="col-lg-8">
                <!-- Absensi Hari Ini -->
                <div class="card mb-4">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title"><b>Absensi Hari Ini</b></h4>
                        <p class="card-category"><?= date('d F Y') ?></p>
                    </div>
                    <div class="card-body text-center" style="padding:30px;">
                        <?php if (!empty($presensiHariIni)): ?>
                            <div class="row">
                                <div class="col-6 border-right">
                                    <p style="color:var(--text-light);font-size:12px;margin-bottom:4px;">JAM MASUK</p>
                                    <h3 style="font-weight:700;color:var(--success);">
                                        <?= $presensiHariIni['jam_masuk'] ?? '-' ?>
                                    </h3>
                                </div>
                                <div class="col-6">
                                    <p style="color:var(--text-light);font-size:12px;margin-bottom:4px;">JAM PULANG</p>
                                    <h3 style="font-weight:700;color:<?= !empty($presensiHariIni['jam_keluar']) ? 'var(--warning)' : 'var(--text-light)' ?>;">
                                        <?= $presensiHariIni['jam_keluar'] ?? 'Belum pulang' ?>
                                    </h3>
                                </div>
                            </div>
                            <div class="mt-3">
                                <span class="badge badge-success" style="font-size:13px;padding:8px 20px;">✓ Sudah Absen</span>
                            </div>
                        <?php else: ?>
                            <div style="padding:20px 0;">
                                <i class="material-icons" style="font-size:48px;color:var(--border-color);">event_busy</i>
                                <p style="color:var(--text-light);margin-top:12px;font-size:14px;">Belum absen hari ini</p>
                                <p style="color:var(--text-light);font-size:12px;">Tunjukkan QR Code Anda kepada petugas scanner</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Riwayat Absensi 30 hari -->
                <div class="card">
                    <div class="card-header card-header-info">
                        <h4 class="card-title"><b>Riwayat Absensi (30 Hari Terakhir)</b></h4>
                    </div>
                    <div class="card-body p-0">
                        <?php if (empty($riwayat)): ?>
                            <div class="text-center py-4">
                                <p style="color:var(--text-light);">Belum ada data absensi</p>
                            </div>
                        <?php else: ?>
                        <div style="max-height:340px;overflow-y:auto;">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Pulang</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($riwayat as $r):
                                        $statusClass = match($r['id_kehadiran'] ?? 0) {
                                            1 => 'status-hadir',
                                            2 => 'status-sakit',
                                            3 => 'status-izin',
                                            default => 'status-alfa',
                                        };
                                    ?>
                                    <tr class="attendance-row">
                                        <td><?= date('d M Y', strtotime($r['tanggal'])) ?></td>
                                        <td><?= $r['jam_masuk'] ?? '-' ?></td>
                                        <td><?= $r['jam_keluar'] ?? '-' ?></td>
                                        <td><span class="<?= $statusClass ?>"><?= $r['kehadiran'] ?? '-' ?></span></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>
<?= $this->endSection() ?>
