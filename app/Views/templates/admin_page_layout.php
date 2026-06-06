<!DOCTYPE html>
<html lang="id">

<?= $this->include("templates/head") ?>

<body>
   <!-- Page Loading Bar -->
   <div id="page-loader-bar"></div>

   <div>
      <?= $this->include("templates/sidebar") ?>
      <div class="main-panel">

         <?= $this->include("templates/navbar") ?>

         <?= $this->renderSection("content") ?>

         <?= $this->include("templates/footer") ?>

         <?php
         // echo $this->include('templates/fixed_plugin')
         ?>

      </div>
   </div>

   <?= $this->include("templates/js") ?>

   <script>
      var BaseConfig = {
         baseURL: '<?= base_url() ?>',
         csrfTokenName: '<?= csrf_token() ?>',
         textOk: "Ok",
         textCancel: "Batalkan"
      };
   </script>

   <!-- Page Transition & Loader Scripts -->
   <script>
   (function() {
      /* =========================================
         PAGE LOADER BAR — muncul saat navigasi
      ========================================= */
      var bar = document.getElementById('page-loader-bar');

      function startLoader() {
         if (!bar) return;
         bar.style.width = '0%';
         bar.style.opacity = '1';
         var w = 0;
         var interval = setInterval(function() {
            w += Math.random() * 18;
            if (w > 85) w = 85;
            bar.style.width = w + '%';
         }, 120);
         bar._interval = interval;
      }

      function finishLoader() {
         if (!bar) return;
         clearInterval(bar._interval);
         bar.style.width = '100%';
         setTimeout(function() {
            bar.style.opacity = '0';
            setTimeout(function() { bar.style.width = '0%'; }, 350);
         }, 280);
      }

      /* Start on all internal link clicks */
      document.addEventListener('click', function(e) {
         var a = e.target.closest('a');
         if (!a) return;
         var href = a.getAttribute('href');
         if (!href || href === '#' || href.startsWith('javascript') || href.startsWith('http') || a.getAttribute('target') === '_blank') return;
         startLoader();
      });

      /* Finish on page load */
      window.addEventListener('load', finishLoader);
      finishLoader();

      /* =========================================
         SIDEBAR LINK ACTIVE RIPPLE
      ========================================= */
      document.querySelectorAll('.sidebar .nav-link').forEach(function(link) {
         link.addEventListener('click', function(e) {
            var ripple = document.createElement('span');
            ripple.style.cssText = 'position:absolute;width:120%;height:120%;background:rgba(255,255,255,0.08);border-radius:50%;left:-10%;top:-10%;animation:rippleOut 0.5s ease;pointer-events:none;';
            this.appendChild(ripple);
            setTimeout(function() { ripple.remove(); }, 500);
         });
      });
   })();

   /* Ripple keyframe */
   var st = document.createElement('style');
   st.textContent = '@keyframes rippleOut{from{opacity:1;transform:scale(0)}to{opacity:0;transform:scale(1.5)}}';
   document.head.appendChild(st);
   </script>

   <?= $this->renderSection("scripts") ?>
</body>

</html>
