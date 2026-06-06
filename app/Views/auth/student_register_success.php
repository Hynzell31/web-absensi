<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrasi Berhasil - Absensi Sekolah</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      display: flex; align-items: center; justify-content: center;
      padding: 20px;
    }
    .success-container {
      background: white;
      border-radius: 20px;
      box-shadow: 0 20px 60px rgba(0,0,0,0.2);
      width: 100%; max-width: 450px;
      padding: 50px 40px;
      text-align: center;
    }
    .success-icon {
      width: 90px; height: 90px;
      background: linear-gradient(135deg, #38a169, #276749);
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 25px;
      animation: pop 0.5s ease;
    }
    @keyframes pop {
      0% { transform: scale(0); } 70% { transform: scale(1.1); } 100% { transform: scale(1); }
    }
    .success-icon i { color: white; font-size: 48px; }
    h2 { font-size: 1.8rem; font-weight: 700; color: #1a1a2e; margin-bottom: 10px; }
    p { color: #666; font-size: 0.95rem; line-height: 1.6; margin-bottom: 8px; }
    .info-box {
      background: #f7fafc; border-radius: 12px;
      padding: 18px; margin: 20px 0;
      border: 1px solid #e2e8f0;
    }
    .info-box p { margin: 4px 0; }
    .info-box strong { color: #2d3748; }
    .btn-login {
      display: inline-block; padding: 13px 30px;
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white; border-radius: 10px;
      text-decoration: none; font-weight: 600;
      transition: all 0.3s; margin-top: 10px;
    }
    .btn-login:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(102,126,234,0.4); }
    .note { font-size: 0.82rem; color: #999; margin-top: 15px; }
  </style>
</head>
<body>
  <div class="success-container">
    <div class="success-icon"><i class="material-icons">check</i></div>
    <h2>Akun Berhasil Dibuat!</h2>
    <p>Selamat, akun Anda telah berhasil didaftarkan.</p>

    <div class="info-box">
      <p><strong>Nama:</strong> <?= esc($nama) ?></p>
      <p><strong>Username:</strong> <?= esc($username) ?></p>
      <p><strong>Role:</strong> <?= esc($role ?? 'Siswa') ?></p>
    </div>

    <p>Silakan login menggunakan username dan password yang sudah Anda buat.</p>

    <?php if (empty($role) || $role === 'Siswa'): ?>
      <p class="note">
        <i class="material-icons" style="font-size:14px;vertical-align:middle;">info</i>
        Jika nama Anda sudah terdaftar di sistem, akun akan otomatis terhubung ke data siswa Anda.
      </p>
    <?php endif; ?>

    <a href="<?= base_url('login') ?>" class="btn-login">
      <i class="material-icons" style="font-size:16px;vertical-align:middle;">login</i>
      Login Sekarang
    </a>
  </div>
</body>
</html>
