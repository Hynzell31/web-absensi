<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\PetugasModel;
use App\Libraries\enums\UserRole;
use Myth\Auth\Password;

class StudentRegister extends BaseController
{
    protected SiswaModel   $siswaModel;
    protected PetugasModel $petugasModel;

    public function __construct()
    {
        $this->siswaModel   = new SiswaModel();
        $this->petugasModel = new PetugasModel();
    }

    /**
     * Tampilkan form registrasi mandiri siswa
     */
    public function index()
    {
        // Jika sudah login, redirect
        if (user()) {
            return redirect()->to('/');
        }

        $data = [
            'title'      => 'Daftar Akun Siswa',
            'validation' => \Config\Services::validation(),
        ];

        return view('auth/student_register', $data);
    }

    /**
     * Proses registrasi mandiri siswa
     */
    public function register()
    {
        if (user()) {
            return redirect()->to('/');
        }

        $rules = [
            'nama_siswa' => 'required|min_length[3]|max_length[100]',
            'email'      => 'required|valid_email|is_unique[users.email]',
            'username'   => 'required|min_length[5]|max_length[30]|is_unique[users.username]',
            'password'   => 'required|min_length[6]',
            'pass_confirm' => 'required|matches[password]',
        ];

        $errors = [
            'nama_siswa'   => ['required' => 'Nama siswa wajib diisi'],
            'email'        => [
                'required'   => 'Email wajib diisi',
                'valid_email' => 'Format email tidak valid',
                'is_unique'  => 'Email ini sudah terdaftar',
            ],
            'username'     => [
                'required'   => 'Username wajib diisi',
                'min_length' => 'Username minimal 5 karakter',
                'is_unique'  => 'Username ini sudah digunakan',
            ],
            'password'     => [
                'required'   => 'Password wajib diisi',
                'min_length' => 'Password minimal 6 karakter',
            ],
            'pass_confirm' => ['matches' => 'Konfirmasi password tidak cocok'],
        ];

        if (!$this->validate($rules, $errors)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $nama     = $this->request->getPost('nama_siswa');
        $email    = $this->request->getPost('email');
        $username = $this->request->getPost('username');
        $password = Password::hash($this->request->getPost('password'));

        // Simpan user dengan role Siswa (5)
        $result = $this->petugasModel->savePetugas(
            null,
            $email,
            $username,
            $password,
            UserRole::Siswa->value,
            null,
            1
        );

        if (!$result) {
            return redirect()->back()->withInput()->with('error', 'Gagal membuat akun. Coba lagi.');
        }

        // Ambil ID user yang baru dibuat
        $db     = \Config\Database::connect();
        $newUser = $db->table('users')->where('email', $email)->get()->getRowArray();

        if ($newUser) {
            // Cari siswa dengan nama yang sama dan belum punya user_id
            $siswaTerkait = $this->siswaModel
                ->where('nama_siswa', $nama)
                ->where('user_id IS NULL', null, false)
                ->first();

            if ($siswaTerkait) {
                $this->siswaModel->update($siswaTerkait['id_siswa'], ['user_id' => $newUser['id']]);
            }
        }

        return view('auth/student_register_success', [
            'title'    => 'Registrasi Berhasil',
            'nama'     => $nama,
            'username' => $username,
        ]);
    }

    /**
     * Form daftar akun guru (self-register)
     */
    public function guruRegister()
    {
        if (user()) return redirect()->to('/');

        $data = [
            'title'      => 'Daftar Akun Guru',
            'validation' => \Config\Services::validation(),
        ];

        return view('auth/guru_register', $data);
    }

    /**
     * Proses registrasi mandiri guru
     */
    public function guruRegisterPost()
    {
        if (user()) return redirect()->to('/');

        $rules = [
            'nama_guru'    => 'required|min_length[3]|max_length[100]',
            'kode_guru'    => 'required|max_length[20]',
            'email'        => 'required|valid_email|is_unique[users.email]',
            'username'     => 'required|min_length[5]|max_length[30]|is_unique[users.username]',
            'password'     => 'required|min_length[6]',
            'pass_confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $namaGuru  = $this->request->getPost('nama_guru');
        $kodeGuru  = $this->request->getPost('kode_guru');
        $email     = $this->request->getPost('email');
        $username  = $this->request->getPost('username');
        $password  = Password::hash($this->request->getPost('password'));

        $result = $this->petugasModel->savePetugas(
            null,
            $email,
            $username,
            $password,
            UserRole::Guru->value,
            null,
            1 // aktif
        );

        if (!$result) {
            return redirect()->back()->withInput()->with('error', 'Gagal membuat akun. Coba lagi.');
        }

        // Hubungkan ke data guru yang sudah ada
        $db      = \Config\Database::connect();
        $newUser = $db->table('users')->where('email', $email)->get()->getRowArray();

        if ($newUser) {
            $guruTerkait = (new \App\Models\GuruModel())
                ->where('nama_guru', $namaGuru)
                ->orWhere('kode_guru', $kodeGuru)
                ->where('user_id IS NULL', null, false)
                ->first();

            if ($guruTerkait) {
                (new \App\Models\GuruModel())->update($guruTerkait['id_guru'], ['user_id' => $newUser['id']]);
            }
        }

        return view('auth/student_register_success', [
            'title'    => 'Registrasi Berhasil',
            'nama'     => $namaGuru,
            'username' => $username,
            'role'     => 'Guru',
        ]);
    }
}
