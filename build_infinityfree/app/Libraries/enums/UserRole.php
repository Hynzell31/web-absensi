<?php

namespace App\Libraries\enums;

enum UserRole: int
{
  case Scanner = 0;
  case SuperAdmin = 1;
  case Kepsek = 2;
  case StafPetugas = 3;
  case Guru = 4;
  case Siswa = 5;

  public const ALL_ROLES = [
    self::Scanner,
    self::SuperAdmin,
    self::Kepsek,
    self::StafPetugas,
    self::Guru,
    self::Siswa,
  ];

  public function label(): string
  {
    return match ($this) {
      self::Scanner    => 'Scanner',
      self::SuperAdmin => 'Super Admin',
      self::Kepsek     => 'Kepala Sekolah',
      self::StafPetugas => 'Staf Petugas',
      self::Guru       => 'Guru',
      self::Siswa      => 'Siswa',
    };
  }

  public function isSuperAdmin(): bool
  {
    return $this === self::SuperAdmin;
  }

  public function isGuru(): bool
  {
    return $this === self::Guru;
  }

  public function isSiswa(): bool
  {
    return $this === self::Siswa;
  }

  public function badgeClass(): string
  {
    return match ($this) {
      self::Scanner     => 'secondary',
      self::SuperAdmin  => 'danger',
      self::Kepsek      => 'warning',
      self::StafPetugas => 'success',
      self::Guru        => 'info',
      self::Siswa       => 'primary',
    };
  }
}
