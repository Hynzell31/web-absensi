<?php
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
<?php if (empty($activeUsers)): ?>
   <div class="text-center py-4">
      <i class="material-icons" style="font-size:36px;color:var(--border-color);">person_off</i>
      <p class="mt-2 mb-0" style="font-size:13px;color:var(--text-light);">Tidak ada pengguna online saat ini</p>
   </div>
<?php else: ?>
   <div style="max-height:320px;overflow-y:auto;">
      <?php foreach ($activeUsers as $u):
         $roleClass    = $roleColors[$u['role']] ?? 'role-staf';
         $roleLabel    = $roleLabels[$u['role']] ?? 'User';
         $initial      = strtoupper(substr($u['username'], 0, 1));
         $isOnline     = strtotime($u['last_activity']) >= strtotime('-5 minutes');
         $namaDisplay  = !empty($u['nama_lengkap']) ? $u['nama_lengkap'] : $u['username'];
         $lastActivity = date('H:i:s', strtotime($u['last_activity']));
         $lastActivityFull = date('d M Y H:i:s', strtotime($u['last_activity']));
         $statusText   = $isOnline ? '● Sedang Online' : '○ Tidak Aktif sejak ' . $lastActivity;
         $statusColor  = $isOnline ? '#16a34a' : '#9ca3af';
      ?>
      <div class="active-user-item border-bottom"
           style="cursor:pointer; transition: background 0.2s;"
           onclick="showUserDetail('<?= esc($namaDisplay) ?>', '<?= esc($roleLabel) ?>', '<?= esc($u['username']) ?>', '<?= $lastActivityFull ?>', <?= $isOnline ? 'true' : 'false' ?>, '<?= $initial ?>', '<?= $roleClass ?>')"
           onmouseover="this.style.background='rgba(0,0,0,0.03)'"
           onmouseout="this.style.background=''">
         <div class="user-avatar <?= $roleClass ?>">
            <?= $initial ?>
         </div>
         <div class="flex-grow-1" style="min-width:0;">
            <div class="d-flex align-items-center justify-content-between">
               <span style="font-weight:600;font-size:13.5px;color:var(--text-dark);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:130px;" title="<?= esc($namaDisplay) ?>">
                  <?= esc($namaDisplay) ?>
               </span>
               <small style="font-size:11px;flex-shrink:0;margin-left:6px;color:<?= $statusColor ?>;">
                  <?= $isOnline ? '● Online' : '○ Tidak aktif' ?>
               </small>
            </div>
            <div class="d-flex align-items-center gap-2 mt-1">
               <span class="badge badge-<?= ['1'=>'danger','2'=>'warning','3'=>'success','4'=>'info','5'=>'primary','0'=>'secondary'][$u['role']] ?? 'secondary' ?>" style="font-size:10px;">
                  <?= $roleLabel ?>
               </span>
               <small style="color:var(--text-light);font-size:11px;">
                  <?= $isOnline ? 'Aktif ' . $lastActivity : 'Terakhir ' . $lastActivity ?>
               </small>
            </div>
         </div>
         <i class="material-icons" style="font-size:16px;color:#ccc;flex-shrink:0;">chevron_right</i>
      </div>
      <?php endforeach; ?>
   </div>

   <!-- Modal Detail User -->
   <div class="modal fade" id="userDetailModal" tabindex="-1" role="dialog">
     <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
       <div class="modal-content" style="border-radius:16px;border:none;box-shadow:0 20px 60px rgba(0,0,0,0.15);">
         <div class="modal-header border-0 pb-0">
           <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
         </div>
         <div class="modal-body text-center pt-0 pb-4 px-4">
           <div id="modalAvatar" class="user-avatar mx-auto mb-3" style="width:64px;height:64px;font-size:28px;"></div>
           <h5 id="modalNama" class="font-weight-bold mb-1"></h5>
           <small id="modalUsername" class="text-muted d-block mb-2"></small>
           <span id="modalRole" class="badge mb-3" style="font-size:12px;padding:6px 12px;"></span>
           <div class="p-3" style="background:#f8fafc;border-radius:10px;">
             <div class="d-flex justify-content-between mb-1">
               <small class="text-muted">Status</small>
               <small id="modalStatus" class="font-weight-bold"></small>
             </div>
             <div class="d-flex justify-content-between">
               <small class="text-muted">Aktivitas Terakhir</small>
               <small id="modalLastActivity" class="font-weight-bold"></small>
             </div>
           </div>
         </div>
       </div>
     </div>
   </div>

   <script>
   function showUserDetail(nama, role, username, lastActivity, isOnline, initial, roleClass) {
      document.getElementById('modalNama').textContent = nama;
      document.getElementById('modalUsername').textContent = '@' + username;
      document.getElementById('modalLastActivity').textContent = lastActivity;
      var avatar = document.getElementById('modalAvatar');
      avatar.textContent = initial;
      avatar.className = 'user-avatar mx-auto mb-3 ' + roleClass;
      avatar.style.cssText = 'width:64px;height:64px;font-size:28px;';

      var statusEl = document.getElementById('modalStatus');
      var roleEl   = document.getElementById('modalRole');
      if (isOnline) {
         statusEl.textContent = '● Sedang Online';
         statusEl.style.color = '#16a34a';
      } else {
         statusEl.textContent = '○ Tidak Aktif';
         statusEl.style.color = '#9ca3af';
      }
      var roleColors = {'Super Admin':'danger','Kepala Sekolah':'warning','Staf Petugas':'success','Guru':'info','Siswa':'primary','Scanner':'secondary'};
      roleEl.textContent = role;
      roleEl.className = 'badge badge-' + (roleColors[role] || 'secondary') + ' mb-3';

      $('#userDetailModal').modal('show');
   }
   </script>
<?php endif; ?>

