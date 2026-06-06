<?php

namespace App\Models;

use CodeIgniter\Model;

class GuruModel extends Model
{
   protected $allowedFields = [
      'kode_guru',
      'nama_guru',
      'jenis_kelamin',
      'alamat',
      'no_hp',
      'unique_code',
      'rfid_code',
      'user_id',
   ];

   protected $table = 'tb_guru';

   protected $primaryKey = 'id_guru';

   public function cekGuru(string $unique_code)
   {
      return $this->where(['unique_code' => $unique_code])
         ->orWhere(['rfid_code' => $unique_code])
         ->first();
   }

   public function getAllGuru()
   {
      return $this->orderBy('nama_guru')->findAll();
   }

   public function getGuruById($id)
   {
      return $this->where([$this->primaryKey => $id])->first();
   }

   public function getGuruByUserId($userId)
   {
      return $this->where(['user_id' => $userId])->first();
   }

   public function createGuru($kode_guru, $nama, $jenisKelamin, $alamat, $noHp, $rfid = null, $user_id = null)
   {
      return $this->save([
         'kode_guru'     => $kode_guru,
         'nama_guru'     => $nama,
         'jenis_kelamin' => $jenisKelamin,
         'alamat'        => $alamat,
         'no_hp'         => $noHp,
         'unique_code'   => sha1($nama . md5($kode_guru . $nama . $noHp)) . substr(sha1($kode_guru . rand(0, 100)), 0, 24),
         'rfid_code'     => $rfid,
         'user_id'       => $user_id,
      ]);
   }

   public function updateGuru($id, $kode_guru, $nama, $jenisKelamin, $alamat, $noHp, $rfid = null, $user_id = null)
   {
      $data = [
         $this->primaryKey => $id,
         'kode_guru'       => $kode_guru,
         'nama_guru'       => $nama,
         'jenis_kelamin'   => $jenisKelamin,
         'alamat'          => $alamat,
         'no_hp'           => $noHp,
         'rfid_code'       => $rfid,
      ];
      if ($user_id !== null) {
         $data['user_id'] = $user_id;
      }
      return $this->save($data);
   }

   //generate CSV object
   public function generateCSVObject($filePath)
   {
      $array = array();
      $fields = array();
      $txtName = uniqid() . '.txt';
      $i = 0;
      $handle = fopen($filePath, 'r');
      if ($handle) {
         while (($row = fgetcsv($handle)) !== false) {
            if (empty($fields)) {
               $fields = $row;
               // Remove BOM from the first element if present
               if (isset($fields[0])) {
                  $fields[0] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $fields[0]);
               }
               // Trim all fields
               $fields = array_map('trim', $fields);
               continue;
            }
            foreach ($row as $k => $value) {
               if (isset($fields[$k])) {
                  $array[$i][$fields[$k]] = trim($value);
               }
            }
            $i++;
         }
         if (!feof($handle)) {
            return false;
         }
         fclose($handle);
         if (!empty($array)) {
            $txtFile = fopen(FCPATH . 'uploads/tmp/' . $txtName, 'w');
            fwrite($txtFile, serialize($array));
            fclose($txtFile);
            $obj = new \stdClass();
            $obj->numberOfItems = countItems($array);
            $obj->txtFileName = $txtName;
            @unlink($filePath);
            return $obj;
         }
      }
      return false;
   }

   //import csv item
   public function importCSVItem($txtFileName, $index)
   {
      $filePath = FCPATH . 'uploads/tmp/' . $txtFileName;
      $file = fopen($filePath, 'r');
      $content = fread($file, filesize($filePath));
      $array = @unserialize($content);
      if (!empty($array)) {
         $i = 1;
         foreach ($array as $item) {
            if ($i == $index) {
               $kode_guru = getCSVInputValue($item, 'kode_guru') ?: getCSVInputValue($item, 'nuptk');
               $nama = getCSVInputValue($item, 'nama_guru');
               $noHp = getCSVInputValue($item, 'no_hp');

               $data = array();
               $data['kode_guru']     = $kode_guru;
               $data['nama_guru']     = $nama;
               $data['jenis_kelamin'] = getCSVInputValue($item, 'jenis_kelamin');
               $data['alamat']        = getCSVInputValue($item, 'alamat');
               $data['no_hp']         = $noHp;
               $data['unique_code']   = sha1($nama . md5($kode_guru . $nama . $noHp)) . substr(sha1($kode_guru . rand(0, 100)), 0, 24);

               $this->insert($data);
               return $data;
            }
            $i++;
         }
      }
   }
}
