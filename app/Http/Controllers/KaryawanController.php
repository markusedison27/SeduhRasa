<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;

class KaryawanController extends Controller
{
    /**
     * Menampilkan daftar semua Karyawan
     */
    public function index()
    {
        // Ambil semua data karyawan, urutkan dari yang terbaru
        $karyawan = Karyawan::orderBy('created_at', 'desc')->get(); 
        
        // Kirim data ke view
        return view('karyawan.index', compact('karyawan'));
    }

    /**
     * Menampilkan form untuk menambah karyawan baru
     */
    public function create()
    {
        return view('karyawan.create');
    }

    /**
     * Menyimpan data karyawan baru ke database
     */
    public function store(Request $request)
    {
        // 🔒 VALIDASI INPUT - Penting untuk keamanan!
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|in:Manajer,Kasir,Barista',
            'email' => 'required|email|unique:karyawan,email',
            'telepon' => 'nullable|string|max:15',
            'alamat' => 'nullable|string|max:500',
        ], [
            // Pesan error kustom (opsional)
            'nama.required' => 'Nama harus diisi',
            'jabatan.required' => 'Jabatan harus dipilih',
            'jabatan.in' => 'Jabatan harus salah satu dari: Manajer, Kasir, Barista',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
        ]);

        // Simpan ke database
        Karyawan::create($validated);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.karyawan.index')
            ->with('success', 'Karyawan berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail satu karyawan (opsional)
     */
    public function show($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        return view('karyawan.show', compact('karyawan'));
    }

    /**
     * Menampilkan form untuk edit karyawan
     */
    public function edit($id)
    {
        // Cari karyawan berdasarkan ID, jika tidak ada akan error 404
        $karyawan = Karyawan::findOrFail($id);
        
        return view('karyawan.edit', compact('karyawan'));
    }

    /**
     * Update data karyawan di database
     */
    public function update(Request $request, $id)
    {
        // Cari karyawan yang akan diupdate
        $karyawan = Karyawan::findOrFail($id);

        // Validasi input (email unique kecuali untuk karyawan ini)
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|in:Manajer,Kasir,Barista',
            'email' => 'required|email|unique:karyawan,email,' . $id,
            'telepon' => 'nullable|string|max:15',
            'alamat' => 'nullable|string|max:500',
        ], [
            'nama.required' => 'Nama harus diisi',
            'jabatan.required' => 'Jabatan harus dipilih',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan oleh karyawan lain',
        ]);

        // Update data
        $karyawan->update($validated);

        // Redirect dengan pesan sukses
        return redirect()->route('admin.karyawan.index')
            ->with('success', 'Data karyawan berhasil diupdate!');
    }

    /**
     * Hapus karyawan dari database
     */
    public function destroy($id)
    {
        // Cari karyawan
        $karyawan = Karyawan::findOrFail($id);
        
        // Simpan nama untuk pesan sukses
        $nama = $karyawan->nama;
        
        // Hapus dari database
        $karyawan->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('admin.karyawan.index')
            ->with('success', "Karyawan {$nama} berhasil dihapus!");
    }
}