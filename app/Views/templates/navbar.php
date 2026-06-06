<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top">
   <div class="container-fluid">
      <div class="navbar-wrapper">
         <p class="navbar-brand my-auto"><b><?= $title; ?></b></p>
      </div>
      <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
         <span class="sr-only">Toggle navigation</span>
         <span class="navbar-toggler-icon icon-bar"></span>
         <span class="navbar-toggler-icon icon-bar"></span>
         <span class="navbar-toggler-icon icon-bar"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end">
         <ul class="navbar-nav">
            <!-- Tombol WhatsApp -->
            <li class="nav-item">
               <a class="nav-link d-flex align-items-center gap-1"
                  href="https://wa.me/62085869786858"
                  target="_blank"
                  rel="noopener noreferrer"
                  title="Hubungi via WhatsApp: +62 085-869-786-858">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22" fill="#25D366">
                     <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                  </svg>
                  <span class="d-none d-lg-inline" style="font-size:12.5px;font-weight:600;color:#25D366;">+62 085-869-786-858</span>
               </a>
            </li>

            <!-- Scan QR Dropdown -->
            <li class="nav-item dropdown">
               <a class="nav-link" href="javascript:;" id="navbarDropdownScan" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">qr_code_scanner</i>
                  <p class="d-lg-none d-md-block">Scan</p>
               </a>
               <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownScan">
                  <a class="dropdown-item" href="<?= base_url('scan/masuk'); ?>">
                     <i class="material-icons mr-2" style="font-size:16px;vertical-align:middle;color:var(--success);">login</i> Absen Masuk
                  </a>
                  <a class="dropdown-item" href="<?= base_url('scan/pulang'); ?>">
                     <i class="material-icons mr-2" style="font-size:16px;vertical-align:middle;color:var(--warning);">logout</i> Absen Pulang
                  </a>
               </div>
            </li>

            <!-- Profile Dropdown -->
            <li class="nav-item dropdown">
               <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <div class="d-flex align-items-center gap-2">
                     <div class="user-avatar <?= 'role-' . strtolower(str_replace(' ', '', user_role()->label())) ?>" style="width:32px;height:32px;font-size:12px;">
                        <?= strtoupper(substr(user()->username, 0, 1)) ?>
                     </div>
                     <span class="d-none d-lg-inline" style="font-size:13px;font-weight:600;color:var(--text-dark);">
                        <?= user()->username; ?>
                     </span>
                  </div>
               </a>
               <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile" style="min-width:220px;">
                  <div class="px-3 py-2 border-bottom mb-1">
                     <p class="mb-0" style="font-weight:700;font-size:13.5px;color:var(--text-dark);"><?= user()->username; ?></p>
                     <p class="mb-0" style="font-size:12px;color:var(--text-light);"><?= user()->email ?? ''; ?></p>
                  </div>
                  <a class="dropdown-item d-flex align-items-center gap-2" href="#">
                     <span class="badge badge-<?= user_role()->badgeClass() ?>" style="font-size:11px;">
                        <?= user_role()->label(); ?>
                     </span>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item d-flex align-items-center gap-2" href="<?= base_url('/logout'); ?>">
                     <i class="material-icons" style="font-size:16px;color:var(--danger);">logout</i>
                     <span style="color:var(--danger);">Log Out</span>
                  </a>
               </div>
            </li>
         </ul>
      </div>
   </div>
</nav>
<!-- End Navbar -->