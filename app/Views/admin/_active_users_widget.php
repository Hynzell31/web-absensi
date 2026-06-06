<?php
use App\Libraries\enums\UserRole;

$roleColors = [
   1 => 'role-superadmin',
   2 => 'role-kepsek',
   3 => 'role-staf',
   4 => 'role-guru',
   5 => 'role-siswa',
   0 => 'role-staf',
];

$roleLabels = [
   0 => 'Scanner',
   1 => 'Super Admin',
   2 => 'Kepala Sekolah',
   3 => 'Staf Petugas',
   4 => 'Guru',
   5 => 'Siswa',
];
?>
<!-- Active Users Widget -->
<div class="card">
   <div class="card-header card-header-success">
      <div class="d-flex align-items-center justify-content-between">
         <div>
            <h4 class="card-title">
               <b>Pengguna Aktif</b>
               <span class="badge badge-pill ml-2"
                  style="background:rgba(255,255,255,0.2);color:#fff;font-size:13px;vertical-align:middle;"
                  id="onlineCountBadge">
                  <?= $countOnline ?>
               </span>
            </h4>
            <p class="card-category">
               <span class="online-dot"></span>
               Online dalam 5 menit terakhir
            </p>
         </div>
         <div>
            <button class="btn btn-sm" style="background:rgba(255,255,255,0.2);color:#fff;border:none;"
               onclick="refreshActiveUsers()" title="Refresh">
               <i class="material-icons" style="font-size:16px;">refresh</i>
            </button>
         </div>
      </div>
   </div>
   <div class="card-body p-0" id="activeUsersContainer">
      <?= view('admin/_active_users_list', ['activeUsers' => $activeUsers, 'countOnline' => $countOnline]) ?>
   </div>
</div>
