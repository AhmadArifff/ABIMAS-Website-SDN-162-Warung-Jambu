<?php
namespace App\Http\Controllers;

use App\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Ekstrakurikuler;
use App\Tautan;
use App\Kesiswaan;
use App\MediaSosial;
use App\Pembiasaan;
use App\Penghargaan;
use App\Tatatertib;
use App\Beasiswa;
use App\Berita;
use App\User;
class GuruController extends Controller
{

    public function userIndex()
{
    $gurus = Guru::all();
    $media = MediaSosial::all();
   $tautan = Tautan::all();
    $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'PUBLISH')->get();
    
    return view('guru.user', compact('gurus', 'media', 'tautan', 'ekstrakurikuler_all'));
}

public function userShow($id)
{
    $guru = Guru::findOrFail($id);
    return view('user.guru_detail', compact('guru'));
}

    public function index(Request $request)
    {
        $gurus = Guru::all();
        $pembiasaan_all=Pembiasaan::where('p_status', 'DRAFT')->get();
        $publishedMenus = Kesiswaan::where('k_status', 'PUBLISH')->pluck('k_nama_menu')->toArray();

        $kesiswaa_all = Kesiswaan::where('k_status', 'DRAFT')
            ->whereNotIn('k_nama_menu', $publishedMenus) // Hanya mengambil DRAFT yang tidak punya PUBLISH dalam grupnya
            ->get();
        $publishedEkstrakurikulerNames = Ekstrakurikuler::where('e_status', 'PUBLISH')->pluck('e_nama_ekstrakurikuler')->toArray();

        $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'DRAFT')
            ->whereNotIn('e_nama_ekstrakurikuler', $publishedEkstrakurikulerNames) // Hanya mengambil DRAFT yang tidak punya PUBLISH dalam grupnya
            ->get();
        $penghargaan_all=Penghargaan::where('ph_status', 'DRAFT')->get();
        $tatatertib_all=Tatatertib::where('t_status', 'DRAFT')->get();
        $user_all=User::all();
        $berita_all = Berita::where('b_status', 'DRAFT')->get();
        $beasiswa_all = Beasiswa::where('status', 'DRAFT')->get();

        $menu = 'guru';
        return view('guru.index', compact('gurus', 'menu', 'pembiasaan_all', 'kesiswaa_all', 'ekstrakurikuler_all', 'penghargaan_all', 'tatatertib_all', 'user_all', 'berita_all', 'beasiswa_all'));

    }

    public function create()
    {
        $gurus = Guru::all();
        $pembiasaan_all=Pembiasaan::where('p_status', 'DRAFT')->get();
        $publishedMenus = Kesiswaan::where('k_status', 'PUBLISH')->pluck('k_nama_menu')->toArray();

        $kesiswaa_all = Kesiswaan::where('k_status', 'DRAFT')
            ->whereNotIn('k_nama_menu', $publishedMenus) // Hanya mengambil DRAFT yang tidak punya PUBLISH dalam grupnya
            ->get();
        $publishedEkstrakurikulerNames = Ekstrakurikuler::where('e_status', 'PUBLISH')->pluck('e_nama_ekstrakurikuler')->toArray();

        $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'DRAFT')
            ->whereNotIn('e_nama_ekstrakurikuler', $publishedEkstrakurikulerNames) // Hanya mengambil DRAFT yang tidak punya PUBLISH dalam grupnya
            ->get();
        $penghargaan_all=Penghargaan::where('ph_status', 'DRAFT')->get();
        $tatatertib_all=Tatatertib::where('t_status', 'DRAFT')->get();
        $user_all=User::all();
        $berita_all = Berita::where('b_status', 'DRAFT')->get();
        $beasiswa_all = Beasiswa::where('status', 'DRAFT')->get();

        $menu = 'guru';
        return view('guru.create', compact('menu', 'pembiasaan_all', 'kesiswaa_all', 'ekstrakurikuler_all', 'penghargaan_all', 'tatatertib_all', 'user_all', 'berita_all', 'beasiswa_all', 'gurus'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'gelar' => 'required',
            'masa_kerja' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $nama_file = "Guru_" . time() . "_" . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move('guru_image', $nama_file);
            $fotoPath = $nama_file;
        } else {
            $fotoPath = null;
        }

        Guru::create([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'gelar' => $request->gelar,
            'foto' => $fotoPath,
            'masa_kerja' => $request->masa_kerja,
        ]);

        return redirect()->route('guru.index')->with('success', 'Guru berhasil ditambahkan.');
    }

    public function show(Guru $guru)
    {
        return view('guru.show', compact('guru'));
    }

    public function edit(Guru $guru)
    {
        {
            $gurus = Guru::all();
            $pembiasaan_all=Pembiasaan::where('p_status', 'DRAFT')->get();
            $publishedMenus = Kesiswaan::where('k_status', 'PUBLISH')->pluck('k_nama_menu')->toArray();
    
            $kesiswaa_all = Kesiswaan::where('k_status', 'DRAFT')
                ->whereNotIn('k_nama_menu', $publishedMenus) // Hanya mengambil DRAFT yang tidak punya PUBLISH dalam grupnya
                ->get();
            $publishedEkstrakurikulerNames = Ekstrakurikuler::where('e_status', 'PUBLISH')->pluck('e_nama_ekstrakurikuler')->toArray();
    
            $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'DRAFT')
                ->whereNotIn('e_nama_ekstrakurikuler', $publishedEkstrakurikulerNames) // Hanya mengambil DRAFT yang tidak punya PUBLISH dalam grupnya
                ->get();
            $penghargaan_all=Penghargaan::where('ph_status', 'DRAFT')->get();
            $tatatertib_all=Tatatertib::where('t_status', 'DRAFT')->get();
            $user_all=User::all();
            $berita_all = Berita::where('b_status', 'DRAFT')->get();
            $beasiswa_all = Beasiswa::where('status', 'DRAFT')->get();
    
            $menu = 'guru';
            return view('guru.edit', compact('guru', 'menu', 'pembiasaan_all', 'kesiswaa_all', 'ekstrakurikuler_all', 'penghargaan_all', 'tatatertib_all', 'user_all', 'berita_all', 'beasiswa_all', 'gurus'));
    
        }
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'gelar' => 'required|string|max:255',
            'foto' => 'nullable|image|max:2048',
            'masa_kerja' => 'required',
        ]);

        $guru->nama = $request->nama;
        $guru->jabatan = $request->jabatan;
        $guru->gelar = $request->gelar;
        $guru->masa_kerja = $request->masa_kerja;

        if ($request->hasFile('foto')) {
            if ($guru->foto) {
                File::delete('guru_image/' . $guru->foto);
            }
            $nama_file = "Guru_" . time() . "_" . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move('guru_image', $nama_file);
            $guru->foto = $nama_file;
        }

        try {
            $guru->save();
            return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update Guru: ' . $e->getMessage()]);
        }
    }

    public function destroy(Guru $guru)
    {
        if ($guru->foto) {
            File::delete('guru_image/' . $guru->foto);
        }
        $guru->delete();

        return redirect()->route('guru.index')->with('success', 'Guru berhasil dihapus.');
    }

    public function userView()
{
    $gurus = Guru::all(); // Mengambil semua data guru dari database
    $media = MediaSosial::all();
    $tautan = Tautan::all();
    $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'PUBLISH')->get();
    
    return view('guru.user', compact('gurus', 'media', 'tautan', 'ekstrakurikuler_all'));
    

}
}