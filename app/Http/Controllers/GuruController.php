<?php
namespace App\Http\Controllers;

use App\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{

    public function userIndex()
{
    $gurus = Guru::all();
    return view('user.guru', compact('gurus'));
}

public function userShow($id)
{
    $guru = Guru::findOrFail($id);
    return view('user.guru_detail', compact('guru'));
}

    public function index()
    {
        $gurus = Guru::all();
        return view('guru.index', compact('gurus'));
    }

    public function create()
    {
        return view('guru.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'gelar' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $fotoPath = $request->file('foto') ? $request->file('foto')->store('foto_guru', 'public') : null;

        Guru::create([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'gelar' => $request->gelar,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('guru.index')->with('success', 'Guru berhasil ditambahkan.');
    }

    public function show(Guru $guru)
    {
        return view('guru.show', compact('guru'));
    }

    public function edit(Guru $guru)
    {
        return view('guru.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'gelar' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($guru->foto) {
                Storage::disk('public')->delete($guru->foto);
            }
            $fotoPath = $request->file('foto')->store('foto_guru', 'public');
        } else {
            $fotoPath = $guru->foto;
        }

        $guru->update([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'gelar' => $request->gelar,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(Guru $guru)
    {
        if ($guru->foto) {
            Storage::disk('public')->delete($guru->foto);
        }
        $guru->delete();

        return redirect()->route('guru.index')->with('success', 'Guru berhasil dihapus.');
    }

    public function userView()
{
    $gurus = Guru::all(); // Mengambil semua data guru dari database
    return view('guru.user', compact('gurus'));
}

}
