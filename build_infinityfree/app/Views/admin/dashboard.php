<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('styles') ?>
<style>
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="content">
    <div class="container-fluid">
        <!-- REKAP JUMLAH DATA -->
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <a href="<?= base_url('admin/siswa'); ?>" style="text-decoration:none;">
                <div style="background:linear-gradient(135deg,#4361ee,#2d46c7);border-radius:14px;padding:22px 20px 18px;color:#fff;box-shadow:0 4px 20px rgba(67,97,238,0.30);transition:all 0.25s ease;position:relative;overflow:hidden;"
                     onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 8px 28px rgba(67,97,238,0.40)'"
                     onmouseout="this.style.transform='';this.style.boxShadow='0 4px 20px rgba(67,97,238,0.30)'">
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        <div>
                            <p style="margin:0;font-size:12.5px;font-weight:500;opacity:0.85;">Jumlah Siswa</p>
                            <h3 style="margin:4px 0 0;font-size:32px;font-weight:800;color:#fff;line-height:1;"><?= count($siswa); ?></h3>
                        </div>
                        <div style="width:52px;height:52px;border-radius:14px;background:rgba(255,255,255,0.18);display:flex;align-items:center;justify-content:center;">
                            <i class="material-icons" style="font-size:28px;color:#fff;">person</i>
                        </div>
                    </div>
                    <div style="margin-top:14px;padding-top:10px;border-top:1px solid rgba(255,255,255,0.18);font-size:12px;opacity:0.8;">
                        <i class="material-icons" style="font-size:14px;vertical-align:middle;margin-right:3px;">check_circle</i> Terdaftar
                    </div>
                </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <a href="<?= base_url('admin/guru'); ?>" style="text-decoration:none;">
                <div style="background:linear-gradient(135deg,#10b981,#059669);border-radius:14px;padding:22px 20px 18px;color:#fff;box-shadow:0 4px 20px rgba(16,185,129,0.30);transition:all 0.25s ease;position:relative;overflow:hidden;"
                     onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 8px 28px rgba(16,185,129,0.40)'"
                     onmouseout="this.style.transform='';this.style.boxShadow='0 4px 20px rgba(16,185,129,0.30)'">
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        <div>
                            <p style="margin:0;font-size:12.5px;font-weight:500;opacity:0.85;">Jumlah Guru</p>
                            <h3 style="margin:4px 0 0;font-size:32px;font-weight:800;color:#fff;line-height:1;"><?= count($guru); ?></h3>
                        </div>
                        <div style="width:52px;height:52px;border-radius:14px;background:rgba(255,255,255,0.18);display:flex;align-items:center;justify-content:center;">
                            <i class="material-icons" style="font-size:28px;color:#fff;">school</i>
                        </div>
                    </div>
                    <div style="margin-top:14px;padding-top:10px;border-top:1px solid rgba(255,255,255,0.18);font-size:12px;opacity:0.8;">
                        <i class="material-icons" style="font-size:14px;vertical-align:middle;margin-right:3px;">check_circle</i> Terdaftar
                    </div>
                </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <a href="<?= base_url('admin/kelas'); ?>" style="text-decoration:none;">
                <div style="background:linear-gradient(135deg,#0ea5e9,#0284c7);border-radius:14px;padding:22px 20px 18px;color:#fff;box-shadow:0 4px 20px rgba(14,165,233,0.30);transition:all 0.25s ease;position:relative;overflow:hidden;"
                     onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 8px 28px rgba(14,165,233,0.40)'"
                     onmouseout="this.style.transform='';this.style.boxShadow='0 4px 20px rgba(14,165,233,0.30)'">
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        <div>
                            <p style="margin:0;font-size:12.5px;font-weight:500;opacity:0.85;">Jumlah Kelas</p>
                            <h3 style="margin:4px 0 0;font-size:32px;font-weight:800;color:#fff;line-height:1;"><?= count($kelas); ?></h3>
                        </div>
                        <div style="width:52px;height:52px;border-radius:14px;background:rgba(255,255,255,0.18);display:flex;align-items:center;justify-content:center;">
                            <i class="material-icons" style="font-size:28px;color:#fff;">meeting_room</i>
                        </div>
                    </div>
                    <div style="margin-top:14px;padding-top:10px;border-top:1px solid rgba(255,255,255,0.18);font-size:12px;opacity:0.8;">
                        <i class="material-icons" style="font-size:14px;vertical-align:middle;margin-right:3px;">home</i> <?= $generalSettings->school_name; ?>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <a href="<?= base_url('admin/petugas'); ?>" style="text-decoration:none;">
                <div style="background:linear-gradient(135deg,#f59e0b,#d97706);border-radius:14px;padding:22px 20px 18px;color:#fff;box-shadow:0 4px 20px rgba(245,158,11,0.30);transition:all 0.25s ease;position:relative;overflow:hidden;"
                     onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 8px 28px rgba(245,158,11,0.40)'"
                     onmouseout="this.style.transform='';this.style.boxShadow='0 4px 20px rgba(245,158,11,0.30)'">
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        <div>
                            <p style="margin:0;font-size:12.5px;font-weight:500;opacity:0.85;">Jumlah Petugas</p>
                            <h3 style="margin:4px 0 0;font-size:32px;font-weight:800;color:#fff;line-height:1;"><?= count($petugas); ?></h3>
                        </div>
                        <div style="width:52px;height:52px;border-radius:14px;background:rgba(255,255,255,0.18);display:flex;align-items:center;justify-content:center;">
                            <i class="material-icons" style="font-size:28px;color:#fff;">admin_panel_settings</i>
                        </div>
                    </div>
                    <div style="margin-top:14px;padding-top:10px;border-top:1px solid rgba(255,255,255,0.18);font-size:12px;opacity:0.8;">
                        <i class="material-icons" style="font-size:14px;vertical-align:middle;margin-right:3px;">person</i> Administrator
                    </div>
                </div>
                </a>
            </div>
        </div>


        <div class="row">
            <!-- STATS SISWA HARI INI -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <div class="d-flex flex-wrap align-items-center justify-content-between" style="gap: 12px;">
                            <div>
                                <h4 class="card-title"><b id="titleSiswaStats">Absensi Siswa Hari Ini</b></h4>
                                <p class="card-category"><?= $dateNow; ?></p>
                            </div>
                            <!-- FILTER KELAS -->
                            <div class="text-right">
                                <div class="d-flex align-items-center justify-content-end">
                                    <div id="filterLoader" style="display: none;">
                                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                    <div>
                                        <select name="id_kelas" id="filterKelas" class="custom-select">
                                            <option value="">-- Semua Kelas (<?= count($siswa) ?> siswa) --
                                            </option>
                                            <?php foreach ($kelas as $k): ?>
                                                <option value="<?= $k['id_kelas'] ?>" data-kelas="<?= $k['kelas'] ?>">
                                                    <?= $k['kelas'] ?> (
                                                    <?= $k['jumlah_siswa'] ?? 0 ?> siswa)
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="siswaStatsContainer">
                        <?= view('admin/_dashboard_siswa_stats', [
                            'hadir' => $jumlahKehadiranSiswa['hadir'],
                            'sakit' => $jumlahKehadiranSiswa['sakit'],
                            'izin' => $jumlahKehadiranSiswa['izin'],
                            'alfa' => $jumlahKehadiranSiswa['alfa'],
                            'totalSiswa' => $totalSiswa
                        ]) ?>
                    </div>
                </div>
            </div>
            <!-- STATS GURU HARI INI -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header card-header-success">
                        <h4 class="card-title"><b>Absensi Guru Hari Ini</b></h4>
                        <p class="card-category"><?= $dateNow; ?></p>
                    </div>
                    <div class="card-body">
                        <div class="row text-center flex-nowrap">
                            <div class="col-2">
                                <h5 class="text-success text-nowrap"><b>Hadir</b></h5>
                                <h4 class="text-nowrap"><?= $jumlahKehadiranGuru['hadir']; ?></h4>
                            </div>
                            <div class="col-2">
                                <h5 class="text-warning text-nowrap"><b>Sakit</b></h5>
                                <h4 class="text-nowrap"><?= $jumlahKehadiranGuru['sakit']; ?></h4>
                            </div>
                            <div class="col-2">
                                <h5 class="text-info text-nowrap"><b>Izin</b></h5>
                                <h4 class="text-nowrap"><?= $jumlahKehadiranGuru['izin']; ?></h4>
                            </div>
                            <div class="col-2">
                                <h5 class="text-danger text-nowrap"><b>Alfa</b></h5>
                                <h4 class="text-nowrap"><?= $jumlahKehadiranGuru['alfa']; ?></h4>
                            </div>
                            <div class="col-1">
                                <div class="border-right mx-auto h-100" style="width: 0;"></div>
                            </div>
                            <div class="col-2 col-sm-3">
                                <h5 class="text-primary text-nowrap"><b>Total</b></h5>
                                <h4 class="text-nowrap"><?= $totalGuru; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- CHART SISWA -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title" id="titleSiswaChart">Tingkat Kehadiran Siswa</h4>
                        <p class="card-category">Statistik kehadiran 7 hari terakhir | <?= $dateNow; ?></p>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="kehadiranSiswa"></canvas>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons text-primary">checklist</i> <a class="text-primary" href="<?= base_url('admin/absen-siswa'); ?>">Lihat data</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- CHART GURU -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header card-header-success">
                        <h4 class="card-title">Tingkat Kehadiran Guru</h4>
                        <p class="card-category">Statistik kehadiran 7 hari terakhir | <?= $dateNow; ?></p>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="kehadiranGuru"></canvas>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons text-success">checklist</i> <a class="text-success" href="<?= base_url('admin/absen-guru'); ?>">Lihat data</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ACTIVE USERS WIDGET -->
        <div class="row">
            <div class="col-lg-5">
                <?= view('admin/_active_users_widget', ['activeUsers' => $activeUsers, 'countOnline' => $countOnline]) ?>
            </div>
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title"><b>Informasi Sistem</b></h4>
                        <p class="card-category"><?= $dateNow ?></p>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-4">
                                <p style="color:var(--text-light);font-size:12px;margin-bottom:4px;">TOTAL SISWA</p>
                                <h4 style="font-weight:700;color:var(--primary);"><?= $totalSiswa ?></h4>
                            </div>
                            <div class="col-4 border-left border-right">
                                <p style="color:var(--text-light);font-size:12px;margin-bottom:4px;">TOTAL GURU</p>
                                <h4 style="font-weight:700;color:var(--success);"><?= $totalGuru ?></h4>
                            </div>
                            <div class="col-4">
                                <p style="color:var(--text-light);font-size:12px;margin-bottom:4px;">TOTAL KELAS</p>
                                <h4 style="font-weight:700;color:var(--info);"><?= count($kelas) ?></h4>
                            </div>
                        </div>
                        <hr style="border-color:var(--border-color);">
                        <h6 style="font-weight:600;margin-bottom:12px;">Link Cepat</h6>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="<?= base_url('scan/masuk') ?>" class="btn btn-success btn-sm">Absen Masuk</a>
                            <a href="<?= base_url('scan/pulang') ?>" class="btn btn-warning btn-sm">Absen Pulang</a>
                            <a href="<?= base_url('admin/absen-siswa') ?>" class="btn btn-primary btn-sm">Data Absensi</a>
                            <a href="<?= base_url('admin/generate') ?>" class="btn btn-sm" style="background:var(--bg-body);color:var(--text-dark);">Generate QR</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- Chart.js CDN -->
<script src="<?= base_url('assets/js/plugins/chartjs/chart.umd.min.js') ?>"></script>
<script>
    let kehadiranSiswaChart;
    let kehadiranGuruChart;

    const chartLabels = <?= json_encode($dateRange) ?>;

    const chartColors = {
        hadir: { border: '#4caf50', bg: 'rgba(76, 175, 80, 1)' },
        sakit: { border: '#ff9800', bg: 'rgba(255, 152, 0, 1)' },
        izin: { border: '#00bcd4', bg: 'rgba(0, 188, 212, 1)' },
        alfa: { border: '#f44336', bg: 'rgba(244, 67, 54, 1)' }
    };

    function createChartConfig(data) {
        return {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [
                    {
                        label: 'Hadir',
                        data: data.hadir,
                        borderColor: chartColors.hadir.border,
                        backgroundColor: chartColors.hadir.bg,
                        tension: 0.3,
                        fill: false,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    },
                    {
                        label: 'Sakit',
                        data: data.sakit,
                        borderColor: chartColors.sakit.border,
                        backgroundColor: chartColors.sakit.bg,
                        tension: 0.3,
                        fill: false,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    },
                    {
                        label: 'Izin',
                        data: data.izin,
                        borderColor: chartColors.izin.border,
                        backgroundColor: chartColors.izin.bg,
                        tension: 0.3,
                        fill: false,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    },
                    {
                        label: 'Alfa',
                        data: data.alfa,
                        borderColor: chartColors.alfa.border,
                        backgroundColor: chartColors.alfa.bg,
                        tension: 0.3,
                        fill: false,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    },
                    tooltip: {
                        enabled: true,
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleFont: { size: 14 },
                        bodyFont: { size: 13 },
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function (context) {
                                return context.dataset.label + ': ' + context.parsed.y + ' orang';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        stacked: false,
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            callback: function (value) {
                                if (Number.isInteger(value)) return value;
                            }
                        },
                        grid: { color: 'rgba(0, 0, 0, 0.05)' }
                    },
                    x: {
                        stacked: false,
                        grid: { display: false }
                    }
                }
            }
        };
    }

    function updateSiswaChart(newData) {
        if (kehadiranSiswaChart) {
            kehadiranSiswaChart.data.datasets[0].data = newData.hadir;
            kehadiranSiswaChart.data.datasets[1].data = newData.sakit;
            kehadiranSiswaChart.data.datasets[2].data = newData.izin;
            kehadiranSiswaChart.data.datasets[3].data = newData.alfa;
            kehadiranSiswaChart.update('active');
        }
    }

    function initDashboardPageCharts() {
        const siswaCtx = document.getElementById('kehadiranSiswa');
        if (siswaCtx) {
            const dataSiswa = {
                hadir: <?= json_encode($grafikKehadiranSiswa['hadir']) ?>,
                sakit: <?= json_encode($grafikKehadiranSiswa['sakit']) ?>,
                izin: <?= json_encode($grafikKehadiranSiswa['izin']) ?>,
                alfa: <?= json_encode($grafikKehadiranSiswa['alfa']) ?>
            };
            kehadiranSiswaChart = new Chart(siswaCtx, createChartConfig(dataSiswa));
        }

        const guruCtx = document.getElementById('kehadiranGuru');
        if (guruCtx) {
            const dataGuru = {
                hadir: <?= json_encode($grafikKehadiranGuru['hadir']) ?>,
                sakit: <?= json_encode($grafikKehadiranGuru['sakit']) ?>,
                izin: <?= json_encode($grafikKehadiranGuru['izin']) ?>,
                alfa: <?= json_encode($grafikKehadiranGuru['alfa']) ?>
            };
            kehadiranGuruChart = new Chart(guruCtx, createChartConfig(dataGuru));
        }
    }

    $(document).ready(function () {
        initDashboardPageCharts();

        $('#filterKelas').on('change', function () {
            const idKelas = $(this).val();
            const loader = $('#filterLoader');

            loader.show();

            $.ajax({
                url: '<?= base_url('admin/dashboard/filter-data') ?>',
                type: 'POST',
                data: setAjaxData({ id_kelas: idKelas }),
                success: function (response) {
                    const obj = JSON.parse(response);
                    if (obj.result == 1) {
                        $('#siswaStatsContainer').html(obj.htmlContent);
                        updateSiswaChart(obj.chartData);

                        // Update Titles
                        // const className = $('#filterKelas option:selected').attr('data-kelas');
                        // if (idKelas == "") {
                        //     $('#titleSiswaStats').text("Absensi Siswa Hari Ini");
                        //     $('#titleSiswaChart').text("Tingkat Kehadiran Siswa");
                        // } else {
                        //     $('#titleSiswaStats').text("Absensi Siswa " + className + " Hari Ini");
                        //     $('#titleSiswaChart').text("Tingkat Kehadiran Siswa " + className);
                        // }
                    }
                },
                error: function (xhr, status, thrown) {
                    console.error(thrown);
                },
                complete: function () {
                    loader.hide();
                }
            });
        });
    });

    // Auto-refresh active users setiap 15 detik
    function refreshActiveUsers() {
        $.get('<?= base_url('admin/dashboard/active-users') ?>', function(res) {
            try {
                const data = JSON.parse(res);
                $('#activeUsersContainer').html(data.htmlContent);
                $('#onlineCountBadge').text(data.count);
            } catch(e) {}
        });
    }

    setInterval(refreshActiveUsers, 15000);
</script>
<?= $this->endSection() ?>