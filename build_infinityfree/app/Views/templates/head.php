<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="description" content="Sistem Absensi Sekolah berbasis QR Code - Modern & Efisien">
   <meta name="theme-color" content="#4361ee">
   <?= csrf_meta(); ?>

   <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/img/apple-icon.png'); ?>">
   <link rel="icon" type="image/png" href="<?= base_url('assets/img/favicon.png'); ?>">

   <?= $this->include('templates/css'); ?>

   <title><?= esc($title ?? 'Dashboard') ?> — <?= esc($generalSettings->school_name ?? 'Absensi Sekolah') ?></title>

   <script>
   /* Page Visibility API — animasi title saat pindah tab */
   (function() {
      var originalTitle = document.title;
      var blinkInterval = null;
      var msgHidden = '👋 Kembali ke sini!';

      document.addEventListener('visibilitychange', function() {
         if (document.hidden) {
            var titles = [msgHidden, originalTitle];
            var i = 0;
            blinkInterval = setInterval(function() {
               document.title = titles[i % 2];
               i++;
            }, 1200);
         } else {
            clearInterval(blinkInterval);
            document.title = originalTitle;
         }
      });

      /* Simpan title asli setelah DOM ready */
      window.addEventListener('DOMContentLoaded', function() {
         originalTitle = document.title;
      });
   })();
   </script>
</head>
