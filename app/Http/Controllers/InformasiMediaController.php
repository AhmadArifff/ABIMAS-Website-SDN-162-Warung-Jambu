<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Berita;
use App\Kesiswaan;
use App\Ekstrakurikuler;
use App\Penghargaan;
use App\Pembiasaan;
use App\Tatatertib;
use App\Tautan;
use App\MediaSosial;
use App\User;
use Illuminate\Support\Facades\File;

class InformasiMediaController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'guru') {
                return redirect()->route('dashboard')->withErrors(['error' => 'Anda tidak memiliki akses ke halaman ini']);
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $menu = 'Informasi Media';
        $berita = Berita::query();
        $kesiswaan = Kesiswaan::query();
        $ekstrakurikuler = Ekstrakurikuler::query();
        $penghargaan = Penghargaan::query();
        $tatatertib = Tatatertib::query();
        $tautan = Tautan::query();
        $mediasosial = MediaSosial::query();
        $user = User::query();

        $berita_all = Berita::where('b_foto', 'DRAFT')->get();
        $publishedMenus = Kesiswaan::where('k_status', 'PUBLISH')->pluck('k_nama_menu')->toArray();

        $kesiswaa_all = Kesiswaan::where('k_status', 'DRAFT')
            ->whereNotIn('k_nama_menu', $publishedMenus) // Hanya mengambil DRAFT yang tidak punya PUBLISH dalam grupnya
            ->get();

        $publishedEkstrakurikulerNames = Ekstrakurikuler::where('e_status', 'PUBLISH')->pluck('e_nama_ekstrakurikuler')->toArray();

        $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'DRAFT')
            ->whereNotIn('e_nama_ekstrakurikuler', $publishedEkstrakurikulerNames) // Hanya mengambil DRAFT yang tidak punya PUBLISH dalam grupnya
            ->get();
        $penghargaan_all = Penghargaan::where('ph_status', 'DRAFT')->get();
        $tatatertib_all = Tatatertib::where('t_status', 'DRAFT')->get();
        $pembiasaan_all= Pembiasaan::where('p_status', 'DRAFT')->get();
        $user_all = User::all();
        $kesiswaan->where('k_nama_menu', $menu);
        $tautan = $tautan->paginate(10);
        $mediasosial = $mediasosial->paginate(10);
        $user_all = User::where('role', 'guru')->get();
    
        return view('informasi-media.index', compact('menu', 'berita', 'kesiswaan', 'ekstrakurikuler', 'penghargaan', 'tatatertib', 'tautan', 'mediasosial', 'user', 'kesiswaa_all', 'ekstrakurikuler_all', 'penghargaan_all', 'tatatertib_all', 'user_all', 'berita_all', 'pembiasaan_all'));
    }

    public function create(Request $request)
    {
        $berita_all = Berita::where('b_foto', 'DRAFT')->get();
        $publishedMenus = Kesiswaan::where('k_status', 'PUBLISH')->pluck('k_nama_menu')->toArray();

        $kesiswaa_all = Kesiswaan::where('k_status', 'DRAFT')
            ->whereNotIn('k_nama_menu', $publishedMenus) // Hanya mengambil DRAFT yang tidak punya PUBLISH dalam grupnya
            ->get();
        $publishedEkstrakurikulerNames = Ekstrakurikuler::where('e_status', 'PUBLISH')->pluck('e_nama_ekstrakurikuler')->toArray();

        $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'DRAFT')
            ->whereNotIn('e_nama_ekstrakurikuler', $publishedEkstrakurikulerNames) // Hanya mengambil DRAFT yang tidak punya PUBLISH dalam grupnya
            ->get();
        $penghargaan_all = Penghargaan::where('ph_status', 'DRAFT')->get();
        $tatatertib_all = Tatatertib::where('t_status', 'DRAFT')->get();
        $pembiasaan_all= Pembiasaan::where('p_status', 'DRAFT')->get();
        $user_all = User::all();
        $mediasosial = MediaSosial::all();
        
        $menu = $request->query('menu');
        return view('informasi-media.create', compact('menu', 'kesiswaa_all', 'ekstrakurikuler_all', 'penghargaan_all', 'tatatertib_all', 'user_all', 'berita_all', 'pembiasaan_all', 'mediasosial'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'menu' => 'required|string|in:Tautan,Media',
        ]);

        
        if ($request->menu == 'Tautan') {
            $tautan = new Tautan;
            $tautan->tt_nama_tautan = $request->name;
            $tautan->tt_url = $request->url;
            $tautan->tt_create_id = auth()->user()->id;
            $tautan->save();
            return redirect()->route('admin.informasi-media.index')->with('success-isi-content-Tautan', $request->tt_nama_tautan . ' Telah Berhasil Ditambahkan');
        } elseif ($request->menu == 'Media') {
            $mediaSosial = new MediaSosial;
            $mediaSosial->ms_nama_media = $request->name;
            $mediaSosial->ms_url = $request->url;
            $mediaSosial->ms_create_id = auth()->user()->id;
            $mediaSosial->save();
            return redirect()->route('admin.informasi-media.index')->with('success-isi-content-Media', $request->ms_nama_media . ' Telah Berhasil Ditambahkan');
        }

    }
    
    public function edit(Request $request,$id)
    {
        $berita_all = Berita::where('b_foto', 'DRAFT')->get();
        $publishedMenus = Kesiswaan::where('k_status', 'PUBLISH')->pluck('k_nama_menu')->toArray();
        
        $kesiswaa_all = Kesiswaan::where('k_status', 'DRAFT')
        ->whereNotIn('k_nama_menu', $publishedMenus) // Hanya mengambil DRAFT yang tidak punya PUBLISH dalam grupnya
            ->get();
            $publishedEkstrakurikulerNames = Ekstrakurikuler::where('e_status', 'PUBLISH')->pluck('e_nama_ekstrakurikuler')->toArray();
            
        $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'DRAFT')
        ->whereNotIn('e_nama_ekstrakurikuler', $publishedEkstrakurikulerNames) // Hanya mengambil DRAFT yang tidak punya PUBLISH dalam grupnya
        ->get();
        $penghargaan_all = Penghargaan::where('ph_status', 'DRAFT')->get();
        $tatatertib_all = Tatatertib::where('t_status', 'DRAFT')->get();
        $pembiasaan_all= Pembiasaan::where('p_status', 'DRAFT')->get();
        $user_all = User::all();
        $mediasosial = MediaSosial::all();

        $menu = $request->menu;
        $tautan = Tautan::findOrFail($id);
        $media = MediaSosial::findOrFail($id);
        $item = $menu == 'Media' ? $media : $tautan;
        
        return view('informasi-media.edit', [
            'menu' => $menu,
            'kesiswaa_all' => $kesiswaa_all,
            'ekstrakurikuler_all' => $ekstrakurikuler_all,
            'penghargaan_all' => $penghargaan_all,
            'tatatertib_all' => $tatatertib_all,
            'user_all' => $user_all,
            'berita_all' => $berita_all,
            'pembiasaan_all' => $pembiasaan_all,
            'media' => $media,
            'tautan' => $tautan,
            'mediasosial' => $mediasosial,
            'item' => $item
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'menu' => 'required|string|in:Tautan,Media',
        ]);

        if ($request->menu == 'Tautan') {
            $tautan = Tautan::findOrFail($id);
            $tautan->tt_nama_tautan = $request->name;
            $tautan->tt_url = $request->url;
            $tautan->tt_update_id = auth()->user()->id;
            $tautan->save();
            return redirect()->route('admin.informasi-media.index')->with('success-isi-content-Tautan', $request->name . ' Telah Berhasil Diubah');
        } elseif ($request->menu == 'Media') {
            $mediaSosial = MediaSosial::findOrFail($id);
            $mediaSosial->ms_nama_media = $request->name;
            $mediaSosial->ms_url = $request->url;
            $mediaSosial->ms_update_id = auth()->user()->id;
            $mediaSosial->save();
            return redirect()->route('admin.informasi-media.index')->with('success-isi-content-Media', $request->name . ' Telah Berhasil Diubah');
        }
    }

    public function destroy($id, Request $request)
    {
        $request->validate([
            'menu' => 'required|string|in:Tautan,Media',
        ]);

        if ($request->menu == 'Tautan') {
            $tautan = Tautan::findOrFail($id);
            $tautan->delete();
            return redirect()->route('admin.informasi-media.index')->with('success-isi-content-Tautan', $tautan->tt_nama_tautan . ' Telah Berhasil Dihapus');
        } elseif ($request->menu == 'Media') {
            $mediaSosial = MediaSosial::findOrFail($id);
            $mediaSosial->delete();
            return redirect()->route('admin.informasi-media.index')->with('success-isi-content-Media', $mediaSosial->ms_nama_media . ' Telah Berhasil Dihapus');
        }
    }
}
