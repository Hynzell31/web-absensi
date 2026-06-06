<!DOCTYPE html>
<html lang="id">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="description" content="Sistem Absensi Sekolah berbasis QR Code - Modern & Efisien">
   <meta name="theme-color" content="#4361ee">
   <?= csrf_meta() ?>

   <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/img/apple-icon.png') ?>">
   <link rel="icon" type="image/png" href="<?= base_url('assets/img/favicon.png') ?>">

   <?= $this->include("templates/css") ?>

   <?php
   $schoolName = $generalSettings->school_name ?? 'Absensi Sekolah';
   $pageTitle  = $title ?? 'Login';
   ?>
   <title><?= esc($pageTitle) ?> — <?= esc($schoolName) ?></title>

   <script>
   /* Page Visibility API */
   (function() {
      var orig = document.title;
      var iv = null;
      document.addEventListener('visibilitychange', function() {
         if (document.hidden) {
            var t = ['👋 Kembali ke sini!', orig], i = 0;
            iv = setInterval(function() { document.title = t[i++ % 2]; }, 1200);
         } else {
            clearInterval(iv);
            document.title = orig;
         }
      });
      window.addEventListener('DOMContentLoaded', function() { orig = document.title; });
   })();
   </script>

   <style>
      body {
         background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #0f172a 100%) !important;
         min-height: 100vh;
      }

      .main-panel {
         position: relative;
         float: left;
         width: 100%;
      }

      .navbar.navbar-transparent {
         background: rgba(15,23,42,0.6) !important;
         backdrop-filter: blur(16px) !important;
         border-bottom: 1px solid rgba(255,255,255,0.06) !important;
         box-shadow: none !important;
      }

      .navbar .navbar-brand b {
         color: #fff !important;
         font-size: 15px;
         font-weight: 700;
         letter-spacing: -0.02em;
      }

      video#previewKamera {
         width: 100%;
         height: auto;
         max-height: 400px;
         margin: 0;
      }

      .previewParent {
         width: auto;
         height: auto;
         margin: auto;
         border-radius: 12px;
         overflow: hidden;
         border: 2px solid rgba(67,97,238,0.4);
      }
   </style>
</head>

<body>
   <!-- Page Loader Bar -->
   <div id="page-loader-bar"></div>

   <!-- Navbar -->
   <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top">
      <div class="container-fluid">
         <div class="navbar-wrapper row w-100 mx-0">
            <div class="col-md-6 d-flex justify-content-center justify-content-md-start">
               <p class="navbar-brand my-auto text-center mx-0"><b><?= esc($pageTitle) ?></b></p>
            </div>
            <div class="col-md-6 d-flex justify-content-center justify-content-md-end">
               <?= $this->renderSection("navaction") ?>
            </div>
         </div>
      </div>
   </nav>
   <!-- End Navbar -->

   <?= $this->renderSection("content") ?>

   <?= $this->include("templates/js") ?>

   <script>
      var BaseConfig = {
         baseURL: '<?= base_url() ?>',
         csrfTokenName: '<?= csrf_token() ?>',
         textOk: "Ok",
         textCancel: "Batalkan"
      };

      /* Page loader */
      (function() {
         var bar = document.getElementById('page-loader-bar');
         if (!bar) return;
         bar.style.cssText = 'position:fixed;top:0;left:0;height:3px;width:100%;background:linear-gradient(90deg,#4361ee,#818cf8,#4361ee);background-size:200% 100%;z-index:99999;opacity:1;animation:shimmer 1.5s infinite linear;';
         var st = document.createElement('style');
         st.textContent = '@keyframes shimmer{0%{background-position:200% 0}100%{background-position:-200% 0}}';
         document.head.appendChild(st);
         window.addEventListener('load', function() {
            setTimeout(function() {
               bar.style.opacity = '0';
               setTimeout(function() { bar.remove(); }, 400);
            }, 300);
         });
      })();
   </script>

   <?= $this->renderSection("scripts") ?>
</body>

</html>