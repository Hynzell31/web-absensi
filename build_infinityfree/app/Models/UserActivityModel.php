<?php

namespace App\Models;

use CodeIgniter\Model;

class UserActivityModel extends Model
{
    protected $table      = 'user_activity_log';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'username',
        'role',
        'nama_lengkap',
        'ip_address',
        'user_agent',
        'last_activity',
        'is_online',
    ];

    /**
     * Update atau insert activity log saat user aktif
     */
    public function updateActivity(int $userId, string $username, int $role, ?string $namaLengkap = null): void
    {
        $request = \Config\Services::request();
        $now = date('Y-m-d H:i:s');

        $existing = $this->where('user_id', $userId)->first();

        if ($existing) {
            $this->update($existing['id'], [
                'last_activity' => $now,
                'is_online'     => 1,
                'ip_address'    => $request->getIPAddress(),
                'user_agent'    => substr($request->getUserAgent()->getAgentString(), 0, 255),
                'nama_lengkap'  => $namaLengkap,
                'role'          => $role,
            ]);
        } else {
            $this->insert([
                'user_id'       => $userId,
                'username'      => $username,
                'role'          => $role,
                'nama_lengkap'  => $namaLengkap,
                'ip_address'    => $request->getIPAddress(),
                'user_agent'    => substr($request->getUserAgent()->getAgentString(), 0, 255),
                'last_activity' => $now,
                'is_online'     => 1,
            ]);
        }
    }

    /**
     * Tandai user sebagai offline saat logout
     */
    public function setOffline(int $userId): void
    {
        $this->where('user_id', $userId)->set(['is_online' => 0])->update();
    }

    /**
     * Ambil semua user yang aktif dalam N menit terakhir (real-time online)
     */
    public function getActiveUsers(int $minutes = 5): array
    {
        $cutoff = date('Y-m-d H:i:s', strtotime("-{$minutes} minutes"));
        return $this->where('last_activity >=', $cutoff)
            ->where('is_online', 1)
            ->orderBy('last_activity', 'DESC')
            ->findAll();
    }

    /**
     * Ambil semua aktivitas terakhir per user (termasuk offline)
     */
    public function getAllRecentActivity(int $minutes = 30): array
    {
        $cutoff = date('Y-m-d H:i:s', strtotime("-{$minutes} minutes"));
        return $this->where('last_activity >=', $cutoff)
            ->orderBy('last_activity', 'DESC')
            ->findAll();
    }

    /**
     * Auto-tandai offline user yang sudah lama tidak aktif
     */
    public function markInactiveOffline(int $minutes = 5): void
    {
        $cutoff = date('Y-m-d H:i:s', strtotime("-{$minutes} minutes"));
        $this->where('last_activity <', $cutoff)
            ->where('is_online', 1)
            ->set(['is_online' => 0])
            ->update();
    }

    /**
     * Hitung jumlah user online sekarang
     */
    public function countOnlineUsers(int $minutes = 5): int
    {
        $cutoff = date('Y-m-d H:i:s', strtotime("-{$minutes} minutes"));
        return $this->where('last_activity >=', $cutoff)
            ->where('is_online', 1)
            ->countAllResults();
    }
}
