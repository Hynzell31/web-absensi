<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration: Refactor Schema
 * 
 * 1. Rename column `nuptk` → `kode_guru` di tb_guru
 * 2. Drop column `nis` dari tb_siswa
 * 3. Drop foreign key id_jurusan dari tb_kelas
 * 4. Drop column id_jurusan dari tb_kelas
 * 5. Drop tabel tb_jurusan (setelah hapus FK)
 */
class RefactorSchema extends Migration
{
    public function up()
    {
        // -------------------------------------------------------
        // 1. Rename nuptk → kode_guru di tb_guru
        // -------------------------------------------------------
        $this->forge->modifyColumn('tb_guru', [
            'nuptk' => [
                'name'       => 'kode_guru',
                'type'       => 'VARCHAR',
                'constraint' => 24,
                'null'       => true,
            ],
        ]);

        // -------------------------------------------------------
        // 2. Drop column nis dari tb_siswa
        // -------------------------------------------------------
        $this->forge->dropColumn('tb_siswa', 'nis');

        // -------------------------------------------------------
        // 3. Drop FK & kolom id_jurusan dari tb_kelas
        // -------------------------------------------------------
        // Cek apakah FK ada sebelum drop
        $db = \Config\Database::connect();
        
        // Drop foreign key constraint (nama FK biasanya tb_kelas_id_jurusan_foreign atau similar)
        // Coba drop dengan cara ALTER TABLE langsung
        try {
            $db->query('ALTER TABLE `tb_kelas` DROP FOREIGN KEY `tb_kelas_id_jurusan_foreign`');
        } catch (\Throwable $e) {
            // Coba nama FK lain
            try {
                $db->query('ALTER TABLE `tb_kelas` DROP FOREIGN KEY `tb_kelas_ibfk_1`');
            } catch (\Throwable $e2) {
                // Mungkin nama FK berbeda, coba approach lain
                $constraints = $db->query("
                    SELECT CONSTRAINT_NAME 
                    FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
                    WHERE TABLE_NAME = 'tb_kelas' 
                    AND COLUMN_NAME = 'id_jurusan'
                    AND CONSTRAINT_SCHEMA = DATABASE()
                    AND REFERENCED_TABLE_NAME IS NOT NULL
                ")->getResultArray();
                
                foreach ($constraints as $constraint) {
                    $db->query("ALTER TABLE `tb_kelas` DROP FOREIGN KEY `{$constraint['CONSTRAINT_NAME']}`");
                }
            }
        }

        // Ubah kolom id_jurusan menjadi nullable dulu agar bisa drop
        try {
            $this->forge->modifyColumn('tb_kelas', [
                'id_jurusan' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'null'       => true,
                ],
            ]);
        } catch (\Throwable $e) {
            // Sudah nullable
        }

        // Drop kolom id_jurusan
        $this->forge->dropColumn('tb_kelas', 'id_jurusan');

        // -------------------------------------------------------
        // 4. Drop tabel tb_jurusan
        // -------------------------------------------------------
        $this->forge->dropTable('tb_jurusan', true);
    }

    public function down()
    {
        // Re-create tb_jurusan
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'jurusan' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tb_jurusan', true);

        // Re-add id_jurusan to tb_kelas
        $this->forge->addColumn('tb_kelas', [
            'id_jurusan' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
                'default'    => 1,
            ],
        ]);

        // Rename kode_guru back to nuptk
        $this->forge->modifyColumn('tb_guru', [
            'kode_guru' => [
                'name'       => 'nuptk',
                'type'       => 'VARCHAR',
                'constraint' => 24,
                'null'       => false,
            ],
        ]);

        // Re-add nis to tb_siswa
        $this->forge->addColumn('tb_siswa', [
            'nis' => [
                'type'       => 'VARCHAR',
                'constraint' => 16,
                'null'       => true,
                'after'      => 'id_siswa',
            ],
        ]);
    }
}
