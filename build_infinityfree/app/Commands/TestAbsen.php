<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\SiswaModel;
use App\Models\PresensiSiswaModel;
use CodeIgniter\I18n\Time;

class TestAbsen extends BaseCommand
{
    protected $group       = 'Testing';
    protected $name        = 'test:absen';
    protected $description = 'Test insert absensi siswa';

    public function run(array $params)
    {
        $siswaModel = new SiswaModel();
        $presensiModel = new PresensiSiswaModel();

        $siswa = $siswaModel->first();
        if (!$siswa) {
            CLI::error('No siswa found.');
            return;
        }

        CLI::write("Testing scan for siswa: " . $siswa['nama_siswa'] . " (ID: " . $siswa['id_siswa'] . ", Kelas: " . $siswa['id_kelas'] . ")");

        $date = Time::today()->toDateString();
        $time = Time::now()->toTimeString();

        $sudahAbsen = $presensiModel->cekAbsen($siswa['id_siswa'], $date);
        if ($sudahAbsen) {
            CLI::write("Already absen today. ID: $sudahAbsen");
            $presensiModel->delete($sudahAbsen);
            CLI::write("Deleted previous absen.");
        }

        $presensiModel->absenMasuk($siswa['id_siswa'], $date, $time, $siswa['id_kelas']);

        if ($presensiModel->errors()) {
            CLI::error("Errors during insert:");
            print_r($presensiModel->errors());
        } else {
            $inserted = $presensiModel->cekAbsen($siswa['id_siswa'], $date);
            if ($inserted) {
                CLI::write("Success! Inserted presensi ID: $inserted");
                
                $db = \Config\Database::connect();
                $row = $db->table('tb_presensi_siswa')->where('id_presensi', $inserted)->get()->getRow();
                print_r($row);

                // test the join query
                $dataAbsenSiswa = $presensiModel->getPresensiByKelasTanggal($siswa['id_kelas'], $date);
                CLI::write("Data in getPresensiByKelasTanggal:");
                foreach($dataAbsenSiswa as $row) {
                    if ($row['id_siswa'] == $siswa['id_siswa']) {
                        print_r($row);
                    }
                }

            } else {
                CLI::error("Failed to insert, but no model errors reported.");
                $db = \Config\Database::connect();
                print_r($db->error());
            }
        }
    }
}
