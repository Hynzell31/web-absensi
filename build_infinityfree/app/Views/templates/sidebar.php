<?php
$context = $ctx ?? 'dashboard';

// ===================================
// MENU BERDASARKAN ROLE
// ===================================
if (is_siswa()) {
   $menuItems = [
      ['title' => 'Dashboard Saya',  'url' => 'student/dashboard',  'icon' => 'dashboard', 'context' => 'student'],
      ['title' => 'Profil Saya',     'url' => 'student/profile',    'icon' => 'person',    'context' => 'student-profile'],
      ['title' => 'Download QR Code','url' => 'student/qr/download','icon' => 'qr_code',   'context' => 'student-qr'],
   ];
   $portalLabel = 'Portal Siswa';

} elseif (is_kepsek()) {
   $menuItems = [
      ['title' => 'Dashboard',      'url' => 'headmaster',              'icon' => 'dashboard',  'context' => 'headmaster'],
      ['title' => 'Laporan Siswa',  'url' => 'headmaster/laporan-siswa','icon' => 'assessment', 'context' => 'laporan-siswa'],
      ['title' => 'Laporan Guru',   'url' => 'headmaster/laporan-guru', 'icon' => 'bar_chart',  'context' => 'laporan-guru'],
   ];
   $portalLabel = 'Kepala Sekolah';

} elseif (is_wali_kelas() || is_guru()) {
   $menuItems = [
      ['title' => 'Dashboard Guru',   'url' => 'teacher/dashboard', 'icon' => 'dashboard',  'context' => 'dashboard'],
      ['title' => 'Laporan Kelas',    'url' => 'teacher/laporan',   'icon' => 'print',      'context' => 'laporan-kelas'],
      ['title' => 'QR Code Kelas',    'url' => 'teacher/qr',        'icon' => 'qr_code',    'context' => 'qr'],
      ['title' => 'Kelola Kehadiran', 'url' => 'teacher/attendance','icon' => 'event_note', 'context' => 'attendance'],
   ];
   $portalLabel = 'Portal Guru';

} elseif (is_superadmin()) {
   $menuItems = [
      ['title' => 'Dashboard',       'url' => 'admin/dashboard',       'icon' => 'dashboard',      'context' => 'dashboard'],
      ['title' => 'Absensi Siswa',   'url' => 'admin/absen-siswa',     'icon' => 'fact_check',     'context' => 'absen-siswa'],
      ['title' => 'Absensi Guru',    'url' => 'admin/absen-guru',      'icon' => 'fact_check',     'context' => 'absen-guru'],
      ['title' => 'Data Siswa',      'url' => 'admin/siswa',           'icon' => 'person',         'context' => 'siswa'],
      ['title' => 'Data Guru',       'url' => 'admin/guru',            'icon' => 'school',         'context' => 'guru'],
      ['title' => 'Data Kelas',      'url' => 'admin/kelas',           'icon' => 'meeting_room',   'context' => 'kelas'],
      ['title' => 'Generate QR',     'url' => 'admin/generate',        'icon' => 'qr_code_2',      'context' => 'qr'],
      ['title' => 'Laporan',         'url' => 'admin/laporan',         'icon' => 'print',          'context' => 'laporan'],
      ['title' => 'Manajemen Akun',  'url' => 'admin/petugas',         'icon' => 'manage_accounts','context' => 'petugas'],
      ['title' => 'Pengaturan',      'url' => 'admin/general-settings','icon' => 'settings',       'context' => 'general_settings'],
      ['title' => 'Backup & Restore','url' => 'admin/backup',          'icon' => 'backup',         'context' => 'backup'],
   ];
   $portalLabel = 'Super Admin';

} else {
   $menuItems = [
      ['title' => 'Dashboard',     'url' => 'admin/dashboard',   'icon' => 'dashboard',   'context' => 'dashboard'],
      ['title' => 'Absensi Siswa', 'url' => 'admin/absen-siswa', 'icon' => 'fact_check',  'context' => 'absen-siswa'],
      ['title' => 'Absensi Guru',  'url' => 'admin/absen-guru',  'icon' => 'fact_check',  'context' => 'absen-guru'],
      ['title' => 'Data Siswa',    'url' => 'admin/siswa',       'icon' => 'person',      'context' => 'siswa',      'guard' => 'can_manage_data'],
      ['title' => 'Data Guru',     'url' => 'admin/guru',        'icon' => 'school',      'context' => 'guru',       'guard' => 'can_manage_data'],
      ['title' => 'Generate QR',   'url' => 'admin/generate',    'icon' => 'qr_code_2',   'context' => 'qr',         'guard' => 'can_generate_qr'],
      ['title' => 'Laporan',       'url' => 'admin/laporan',     'icon' => 'print',       'context' => 'laporan',    'guard' => 'can_view_report'],
   ];
   $portalLabel = 'Panel Admin';
}
?>

<style>
/* ============================================================
   SIDEBAR — Background PUTIH, text HITAM, hover animasi
   ============================================================ */
.sidebar,
.sidebar[data-color],
.sidebar[data-color="azure"],
.sidebar[data-color="purple"],
.sidebar[data-color="orange"],
.sidebar[data-color="green"],
.sidebar[data-color="danger"],
.sidebar[data-color="rose"] {
   background: #ffffff !important;
   box-shadow: 1px 0 16px rgba(0,0,0,0.07) !important;
   border-right: 1px solid #eef0f6 !important;
   position: fixed !important;
   top: 0 !important;
   bottom: 0 !important;
   left: 0 !important;
   width: 260px !important;
   display: block !important;
   z-index: 1030 !important;
   overflow: hidden !important;
}

.sidebar::before,
.sidebar::after,
.sidebar .sidebar-background {
   display: none !important;
   background: none !important;
   opacity: 0 !important;
}

/* Logo area */
.sidebar .logo {
   background: #ffffff !important;
   padding: 20px 18px 18px !important;
   border-bottom: 1px solid #eef0f6 !important;
   display: block !important;
}

.sidebar .logo .simple-text,
.sidebar .logo .simple-text * {
   color: #1a2035 !important;
   opacity: 1 !important;
}

/* Sidebar wrapper */
.sidebar .sidebar-wrapper {
   background: #ffffff !important;
   padding-top: 6px !important;
   height: calc(100vh - 80px) !important;
   overflow-y: auto !important;
   overflow-x: hidden !important;
}

/* ---- NAV LINKS (default: hitam) ---- */
.sidebar .nav .nav-item .nav-link,
.sidebar .nav li > a,
.sidebar .nav li a {
   background: transparent !important;
   color: #374151 !important;
   display: flex !important;
   align-items: center !important;
   padding: 10px 16px !important;
   margin: 2px 10px !important;
   border-radius: 10px !important;
   transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
   text-decoration: none !important;
   font-size: 13.5px !important;
   font-weight: 500 !important;
   white-space: nowrap !important;
   overflow: hidden !important;
   text-overflow: ellipsis !important;
   gap: 11px !important;
   position: relative !important;
}

/* ---- HOVER: background hitam, text putih ---- */
.sidebar .nav .nav-item .nav-link:hover,
.sidebar .nav li:hover > a {
   background: #1a2035 !important;
   color: #ffffff !important;
   box-shadow: 0 4px 14px rgba(26,32,53,0.18) !important;
   transform: translateX(2px) !important;
}

/* ---- ACTIVE: biru, text putih ---- */
.sidebar .nav .nav-item.active .nav-link,
.sidebar .nav li.active > a {
   background: #4361ee !important;
   color: #ffffff !important;
   font-weight: 600 !important;
   box-shadow: 0 4px 16px rgba(67,97,238,0.30) !important;
}

/* Material Icons */
.sidebar .nav .nav-item .nav-link i.material-icons,
.sidebar .nav li a i {
   font-size: 20px !important;
   color: inherit !important;
   flex-shrink: 0 !important;
   width: 24px !important;
   text-align: center !important;
   transition: inherit !important;
}

/* <p> tag inside link */
.sidebar .nav li a p {
   color: inherit !important;
   font-size: 13.5px !important;
   font-weight: inherit !important;
   margin: 0 !important;
   padding: 0 !important;
   overflow: hidden !important;
   text-overflow: ellipsis !important;
   white-space: nowrap !important;
   flex: 1 !important;
   opacity: 1 !important;
   display: block !important;
   line-height: 1.4 !important;
   transition: inherit !important;
}

/* Scrollbar */
.sidebar .sidebar-wrapper::-webkit-scrollbar { width: 3px; }
.sidebar .sidebar-wrapper::-webkit-scrollbar-thumb { background: #dde0e8; border-radius: 99px; }

/* Main panel offset */
.main-panel {
   margin-left: 260px !important;
}

@media (max-width: 991px) {
   .main-panel { margin-left: 0 !important; }
   .sidebar { transform: translateX(-100%) !important; transition: transform 0.3s cubic-bezier(0.4,0,0.2,1) !important; }
   .nav-open .sidebar { transform: translateX(0) !important; }
}
</style>

<div class="sidebar" id="app-sidebar">
   <!-- Logo Header -->
   <div class="logo">
      <a class="simple-text logo-normal" href="javascript:;" style="display:block;">
         <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:40px;height:40px;border-radius:10px;background:#eef0fd;border:1.5px solid #dce0f9;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
               <img src="<?= getLogo() ?>" alt="Logo" style="width:28px;height:28px;border-radius:7px;object-fit:cover;">
            </div>
            <div style="min-width:0;overflow:hidden;">
               <b style="display:block;font-size:14px;font-weight:700;color:#1a2035;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;line-height:1.3;">
                  <?= esc($portalLabel) ?>
               </b>
               <small style="font-size:11px;color:#9ca3af;display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                  <?= esc($generalSettings->school_name ?? 'Sekolah') ?>
               </small>
            </div>
         </div>
      </a>
   </div>

   <!-- Navigation -->
   <div class="sidebar-wrapper">
      <ul class="nav" style="list-style:none;padding:6px 0;margin:0;">
         <?php foreach ($menuItems as $item):
            if (isset($item['guard'])) {
               $fn = $item['guard'];
               if (!$fn()) continue;
            }
            $isActive = ($context === $item['context']);
         ?>
         <li class="nav-item <?= $isActive ? 'active' : '' ?>" style="list-style:none;display:block;">
            <a class="nav-link" href="<?= base_url($item['url']) ?>" title="<?= esc($item['title']) ?>">
               <i class="material-icons"><?= $item['icon'] ?></i>
               <p><?= esc($item['title']) ?></p>
            </a>
         </li>
         <?php endforeach; ?>
      </ul>
   </div>
</div>
