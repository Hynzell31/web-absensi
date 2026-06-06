<?php

use App\Libraries\enums\UserRole;

function user_role(): UserRole
{
    $u = user();
    return UserRole::from(intval($u->is_superadmin));
}

function getUserRole(int|string $role): string
{
    return UserRole::from(intval($role))->label();
}

function is_wali_kelas(): bool
{
    // Guru yang terhubung ke kelas sebagai wali kelas (fitur asli)
    if (user_role() === UserRole::Guru) return false; // Guru login bukan wali kelas
    return !empty(user()->id_guru);
}

function is_superadmin(): bool
{
    return user_role()->isSuperAdmin();
}

function is_kepsek(): bool
{
    return user_role() === UserRole::Kepsek;
}

function is_guru(): bool
{
    return user_role() === UserRole::Guru;
}

function is_siswa(): bool
{
    return user_role() === UserRole::Siswa;
}

function can_edit_attendance(): bool
{
    return in_array(user_role(), [UserRole::SuperAdmin, UserRole::StafPetugas]);
}

function can_generate_qr(): bool
{
    return in_array(user_role(), [UserRole::SuperAdmin, UserRole::StafPetugas, UserRole::Guru]);
}

function can_view_report(): bool
{
    return in_array(user_role(), [UserRole::SuperAdmin, UserRole::StafPetugas, UserRole::Kepsek, UserRole::Guru]);
}

function can_manage_data(): bool
{
    return in_array(user_role(), [UserRole::SuperAdmin, UserRole::StafPetugas]);
}
