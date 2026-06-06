<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Akun Guru - Absensi Sekolah</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
      min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px;
    }
    .register-container {
      background: white; border-radius: 20px;
      box-shadow: 0 20px 60px rgba(0,0,0,0.2);
      width: 100%; max-width: 500px; padding: 40px;
    }
    .register-header { text-align: center; margin-bottom: 30px; }
    .register-header .icon-wrap {
      width: 70px; height: 70px;
      background: linear-gradient(135deg, #11998e, #38ef7d);
      border-radius: 50%; display: flex; align-items: center; justify-content: center;
      margin: 0 auto 15px;
    }
    .register-header .icon-wrap i { color: white; font-size: 36px; }
    .register-header h2 { font-size: 1.6rem; font-weight: 700; color: #1a1a2e; }
    .register-header p { color: #666; font-size: 0.9rem; }
    .form-group { margin-bottom: 18px; }
    .form-group label { display: block; font-weight: 600; font-size: 0.85rem; color: #444; margin-bottom: 6px; }
    .form-group input {
      width: 100%; padding: 12px 15px; border: 2px solid #e1e5ee;
      border-radius: 10px; font-size: 0.95rem; transition: all 0.3s; outline: none;
    }
    .form-group input:focus { border-color: #11998e; box-shadow: 0 0 0 3px rgba(17,153,142,0.15); }
    .btn-register {
      width: 100%; padding: 13px;
      background: linear-gradient(135deg, #11998e, #38ef7d);
      color: white; border: none; border-radius: 10px;
      font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.3s;
    }
    .btn-register:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(17,153,142,0.4); }
    .login-link { text-align: center; margin-top: 20px; font-size: 0.9rem; color: #666; }
    .login-link a { color: #11998e; font-weight: 600; text-decoration: none; }
    .alert { padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 0.9rem; }
    .alert-danger { background: #fff5f5; color: #c53030; border: 1px solid #fed7d7; }
    .note { background: #f0fff4; border: 1px solid #c6f6d5; border-radius: 10px; padding: 12px; margin-bottom: 20px; font-size: 0.85rem; color: #276749; }
  </style>
</head>
<body>
  <div class="register-container">
    <div class="register-header">
      <div class="icon-wrap"><i class="material-icons">school</i></div>
      <h2>Daftar Akun Guru</h2>
      <p>Buat akun untuk mengakses sistem absensi sebagai guru</p>
    </div>

    <div class="note">
      <i class="material-icons" style="font-size:14px;vertical-align:middle;">info</i>
      Masukkan nama dan kode guru sesuai data yang sudah ada di sistem agar akun terhubung otomatis.
    </div>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('errors')): ?>
      <div class="alert alert-danger">
        <?php foreach (session()->getFlashdata('errors') as $err): ?>
          <div>• <?= $err ?></div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <form action="<?= base_url('daftar/guru/proses') ?>" method="POST">
      <?= csrf_field() ?>
      <div class="form-group">
        <label>Nama Lengkap</label>
        <input type="text" name="nama_guru" placeholder="Sesuai data di sistem" value="<?= old('nama_guru') ?>" required>
      </div>
      <div class="form-group">
        <label>Kode Guru</label>
        <input type="text" name="kode_guru" placeholder="Contoh: KG001" value="<?= old('kode_guru') ?>" required>
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" placeholder="email@sekolah.com" value="<?= old('email') ?>" required>
      </div>
      <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" placeholder="Minimal 5 karakter" value="<?= old('username') ?>" required>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" placeholder="Minimal 6 karakter" required>
      </div>
      <div class="form-group">
        <label>Konfirmasi Password</label>
        <input type="password" name="pass_confirm" placeholder="Ulangi password" required>
      </div>
      <button type="submit" class="btn-register">
        <i class="material-icons" style="font-size:16px;vertical-align:middle;">how_to_reg</i>
        Daftar Sekarang
      </button>
    </form>

    <div class="login-link">
      Sudah punya akun? <a href="<?= base_url('login') ?>">Login di sini</a> |
      <a href="<?= base_url('daftar/siswa') ?>">Daftar sebagai Siswa</a>
    </div>
  </div>
</body>
</html>
