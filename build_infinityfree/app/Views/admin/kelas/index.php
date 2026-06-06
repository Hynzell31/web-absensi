<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 col-md-12">
        <?= view('admin/_messages'); ?>
        <div class="row">
          <div class="col-12 col-xl-12">
            <div class="card">
              <div class="card-header card-header-tabs card-header-primary">
                <div class="nav-tabs-navigation">
                  <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                      <h4 class="card-title"><b>Daftar Kelas</b></h4>
                      <p class="card-category mb-0">Angkatan <?= $generalSettings->school_year; ?></p>
                    </div>

                    <div class="col-auto row m-0">
                      <div class="col-12 col-sm-auto nav nav-tabs">
                        <a class="btn-custom-tools" id="tabBtn" href="<?= base_url('admin/kelas/tambah'); ?>">
                          <i class="material-icons">add</i> Baru
                          <div class="ripple-container"></div>
                        </a>

                      </div>
                      <div class="col-12 col-sm-auto nav nav-tabs">
                        <a class="btn-custom-tools" href="<?= base_url('admin/kelas/bulk'); ?>">
                          <i class="material-icons">cloud_upload</i> Import
                        </a>
                      </div>
                      <div class="col-12 col-sm-auto nav nav-tabs">
                        <a class="btn-custom-tools" id="refreshBtn" onclick="fetchKelasData('#dataKelas')" href="javascript:void(0)">
                          <i class="material-icons">refresh</i> Refresh

                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-data" id="dataKelas">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    fetchKelasData('#dataKelas');
  });

</script>
<?= $this->endSection() ?>