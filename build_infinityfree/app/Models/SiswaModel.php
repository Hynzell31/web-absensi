<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaModel extends Model
{
   protected function initialize()
   {
      $this->allowedFields = [
         'nama_siswa',
         'id_kelas',
         'jenis_kelamin',
         'no_hp',
         'unique_code',
         'rfid_code',
         'user_id',
      ];
   }

   protected $table = 'tb_siswa';

   protected $primaryKey = 'id_siswa';

   public function cekSiswa(string $unique_code)
   {
      $this->select('tb_siswa.*, tb_kelas.tingkat, tb_kelas.index_kelas, CONCAT(tb_kelas.tingkat, " ", tb_kelas.index_kelas) as kelas')
         ->join('tb_kelas', 'tb_kelas.id_kelas = tb_siswa.id_kelas', 'LEFT');
      return $this->where(['unique_code' => $unique_code])
         ->orWhere(['rfid_code' => $unique_code])
         ->first();
   }

   public function getSiswaById($id)
   {
      return $this->where([$this->primaryKey => $id])->first();
   }

   public function getSiswaByUserId($userId)
   {
      return $this->where(['user_id' => $userId])->first();
   }

   public function getAllSiswaWithKelas($kelas = null, $index = null)
   {
      $query = $this->select('tb_siswa.*, tb_kelas.tingkat, tb_kelas.index_kelas, CONCAT(tb_kelas.tingkat, " ", tb_kelas.index_kelas) as kelas')
         ->join('tb_kelas', 'tb_kelas.id_kelas = tb_siswa.id_kelas', 'LEFT');

      if (!empty($kelas)) {
         $query->where('tb_kelas.tingkat', $kelas);
      }
      if (!empty($index)) {
         $query->where('tb_kelas.index_kelas', $index);
      }

      return $query->orderBy('nama_siswa')->findAll();
   }

   public function getSiswaByKelas($id_kelas)
   {
      return $this->select('tb_siswa.*, tb_kelas.tingkat, tb_kelas.index_kelas, CONCAT(tb_kelas.tingkat, " ", tb_kelas.index_kelas) as kelas')
         ->join('tb_kelas', 'tb_kelas.id_kelas = tb_siswa.id_kelas', 'LEFT')
         ->where(['tb_siswa.id_kelas' => $id_kelas])
         ->orderBy('nama_siswa')
         ->findAll();
   }

   public function createSiswa($nama, $idKelas, $jenisKelamin, $noHp, $rfid = null, $user_id = null)
   {
      return $this->save([
         'nama_siswa'    => $nama,
         'id_kelas'      => $idKelas,
         'jenis_kelamin' => $jenisKelamin,
         'no_hp'         => $noHp,
         'unique_code'   => generateToken(),
         'rfid_code'     => $rfid,
         'user_id'       => $user_id,
      ]);
   }

   public function updateSiswa($id, $nama, $idKelas, $jenisKelamin, $noHp, $rfid = null, $user_id = null)
   {
      $data = [
         $this->primaryKey => $id,
         'nama_siswa'      => $nama,
         'id_kelas'        => $idKelas,
         'jenis_kelamin'   => $jenisKelamin,
         'no_hp'           => $noHp,
         'rfid_code'       => $rfid,
      ];
      if ($user_id !== null) {
         $data['user_id'] = $user_id;
      }
      return $this->save($data);
   }

   public function getSiswaCountByKelas($kelasId = null)
   {
      if (empty($kelasId)) {
         return $this->countAllResults();
      }

      $tree = array();
      $kelasId = cleanNumber($kelasId);
      if (!empty($kelasId)) {
         array_push($tree, $kelasId);
      }

      $kelasIds = $tree;
      if (countItems($kelasIds) < 1) {
         return 0;
      }

      return $this->whereIn('tb_siswa.id_kelas', $kelasIds, false)->countAllResults();
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
               continue;
            }
            foreach ($row as $k => $value) {
               $array[$i][$fields[$k]] = $value;
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

   //import csv item (tanpa nis)
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
               $data = array();
               $data['nama_siswa']    = getCSVInputValue($item, 'nama_siswa');
               $data['id_kelas']      = getCSVInputValue($item, 'id_kelas', 'int');
               $data['jenis_kelamin'] = getCSVInputValue($item, 'jenis_kelamin');
               $data['no_hp']         = getCSVInputValue($item, 'no_hp');
               $data['unique_code']   = generateToken();

               $this->insert($data);
               return $data;
            }
            $i++;
         }
      }
   }

   public function getSiswa($id)
   {
      return $this->where('id_siswa', cleanNumber($id))->get()->getRow();
   }

   //delete post
   public function deleteSiswa($id)
   {
      $siswa = $this->getSiswa($id);
      if (!empty($siswa)) {
         return $this->where('id_siswa', $siswa->id_siswa)->delete();
      }
      return false;
   }

   //delete multi post
   public function deleteMultiSelected($siswaIds)
   {
      if (!empty($siswaIds)) {
         foreach ($siswaIds as $id) {
            $this->deleteSiswa($id);
         }
      }
   }
}
