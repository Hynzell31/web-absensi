<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration: Add user_id to tb_siswa & tb_guru + Buat tabel user_activity_log
 * 
 * - tb_siswa: tambah kolom user_id (FK ke tabel users Myth Auth)
 * - tb_guru: tambah kolom user_id (FK ke tabel users Myth Auth)
 * - Buat tabel user_activity_log untuk realtime active users
 */
class AddUserIdAndActivityLog extends Migration
{
    public function up()
    {
        // -------------------------------------------------------
        // 1. Tambah kolom user_id ke tb_siswa
        // -------------------------------------------------------
        $this->forge->addColumn('tb_siswa', [
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => false,
                'null'       => true,
                'default'    => null,
                'after'      => 'id_siswa',
            ],
        ]);

        // -------------------------------------------------------
        // 2. Tambah kolom user_id ke tb_guru
        // -------------------------------------------------------
        $this->forge->addColumn('tb_guru', [
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => false,
                'null'       => true,
                'default'    => null,
                'after'      => 'id_guru',
            ],
        ]);

        // -------------------------------------------------------
        // 3. Buat tabel user_activity_log
        // -------------------------------------------------------
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => false,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => false,
                'null'       => false,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'role' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
                'default'    => 3,
            ],
            'nama_lengkap' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'ip_address' => [
                'type'       => 'VARCHAR',
                'constraint' => 45,
                'null'       => true,
            ],
            'user_agent' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'last_activity' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'is_online' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => false,
                'default'    => 1,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id');
        $this->forge->addKey('last_activity');
        $this->forge->createTable('user_activity_log', true);
    }

    public function down()
    {
        $this->forge->dropTable('user_activity_log', true);
        $this->forge->dropColumn('tb_siswa', 'user_id');
        $this->forge->dropColumn('tb_guru', 'user_id');
    }
}
