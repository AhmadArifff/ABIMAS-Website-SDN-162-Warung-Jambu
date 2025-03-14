<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\About;
use App\Kesiswaan;
use App\Ekstrakurikuler;
use App\Penghargaan;
use App\Tatatertib;
use App\User;
use App\Pembiasaan;

class AboutController extends Controller
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
        $menu = 'About';
        $about = About::query();
        $kesiswaan = Kesiswaan::query();
        $ekstrakurikuler = Ekstrakurikuler::query();
        $penghargaan = Penghargaan::query();
        $tatatertib = Tatatertib::query();
        $user = User::query();
        
        if ($request->get('-isi-content-status')) {
            $about->where('a_status', $request->get('-isi-content-status'));
        } else {
            $about->whereIn('a_status', ['PUBLISH', 'DRAFT', 'TIDAK']);
        }

        if ($request->get('-isi-slide-status')) {
            $kesiswaan->where('k_status', $request->get('-isi-slide-status'));
        } else {
            $kesiswaan->whereIn('k_status', ['PUBLISH', 'DRAFT', 'TIDAK']);
        }

        if ($request->get('k_keyword')) {
            $kesiswaan->where('k_judul_slide', 'LIKE', "%{$request->get('k_keyword')}%");
        }
        $about_all = About::where('a_status', 'DRAFT')->get();
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
        $user_all = User::all();
        $kesiswaan->where('k_nama_menu', $menu);
        $about = $about->paginate(10);
        $kesiswaan = $kesiswaan->paginate(10);
        $pembiasaan_all=Pembiasaan::where('p_status', 'DRAFT')->get();
    
        return view('about.index', compact('about', 'kesiswaan', 'ekstrakurikuler', 'penghargaan', 'tatatertib', 'user', 'menu', 'kesiswaa_all', 'ekstrakurikuler_all', 'penghargaan_all', 'tatatertib_all', 'user_all', 'about_all', 'pembiasaan_all'));
    }

    public function create(Request $request)
    {
        $about_all = About::where('a_status', 'DRAFT')->get();
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
        $pembiasaan_all=Pembiasaan::where('p_status', 'DRAFT')->get();
        $user_all = User::all();

        $menu = $request->query('menu');
        $kesiswaan = Kesiswaan::where('k_nama_menu', $menu)->where('k_status', 'PUBLISH')->first();
        if (!$kesiswaan) {
            return redirect()->back()->withErrors(['error' => 'Data Manage Content Slide Pembiasaan Tidak Terpublish! Tolong Publish Terlebih Dahulu!']);
        }
        return view('about.create', compact('kesiswaan', 'menu', 'kesiswaa_all', 'ekstrakurikuler_all', 'penghargaan_all', 'tatatertib_all', 'user_all', 'about_all', 'pembiasaan_all'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'visi' => 'required|string|max:255',
            'misi' => 'required|string|max:255',
        ]);

        $kesiswaan = Kesiswaan::where('k_status', 'PUBLISH')->first();
        if (!$kesiswaan) {
            return redirect()->back()->withErrors(['error' => 'Tidak Ada Data Slide Dengan Nama Slide "' . $kesiswaan->k_nama_menu . '" Yang PUBLISH']);
        }

        $about = new About;
        $about->k_id = $request->k_id;
        $about->a_create_id = auth()->user()->id; // Set a_create_id based on the logged-in user
        $about->a_visi = $request->visi;
        $about->a_misi = $request->misi;
        $about->a_status = $request->input('status'); // Set a_status based on the button clicked

        $about->save();
        return redirect()->route('admin.kesiswaan.about.index')->with('success-isi-content', 'Data Isi Content '. $kesiswaan->k_nama_menu .' Telah Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        $about_all = About::where('a_status', 'DRAFT')->get();
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
        $user_all = User::all();

        $menu = 'About';
        $about = About::findOrFail($id);
        $kesiswaan = Kesiswaan::where('k_nama_menu', $menu)->where('k_status', 'PUBLISH')->first();
        
        if (!$kesiswaan) {
            return redirect()->back()->withErrors(['error' => 'Data Slide Harus Ada Status Publish!']);
        }
        
        return view('kesiswaan/admin.edit', ['about' => $about, 'kesiswaan' => $kesiswaan, 'menu' => $menu, 'kesiswaa_all' => $kesiswaa_all, 'ekstrakurikuler_all' => $ekstrakurikuler_all, 'penghargaan_all' => $penghargaan_all, 'tatatertib_all' => $tatatertib_all, 'user_all' => $user_all, 'about_all' => $about_all]);
    }

    public function update(Request $request, $id)
    {
        $about = About::findOrFail($id);

        $request->validate([
            'visi' => 'required|string|max:255',
            'misi' => 'required|string|max:255',
        ]);
        
        $kesiswaan = Kesiswaan::where('k_status', 'PUBLISH')->first();
        if (!$kesiswaan) {
            return redirect()->back()->withErrors(['error' => 'Data Manage Content Slide Pembiasaan Tidak Terpublish! Tolong Publish Terlebih Dahulu!']);
        }
        $about->k_id = $request->k_id;
        $about->a_update_id = auth()->user()->id; // Set a_update_id based on the logged-in user
        $about->a_visi = $request->visi;
        $about->a_misi = $request->misi;
        $about->a_status = $request->input('status'); // Set a_status based on the button clicked

        try {
            $about->save();
            return redirect()->route('admin.kesiswaan.about.index')->with('success-isi-content', 'Data Isi Content '. $kesiswaan->k_nama_menu .' Telah Berhasil Diubah');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update About: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $about = About::findOrFail($id);
        $about->delete();
        return redirect()->route('admin.kesiswaan.about.index')->with('success-isi-content', 'Data Isi Content '. $about->a_visi .' Telah Berhasil Di Hapus Secara Permanen');
    }

    public function destroyrecycle($id)
    {
        $about = About::findOrFail($id);
        $about->a_delete_id = auth()->user()->id; // Set a_delete_id based on the logged-in user
        $about->a_delete_at = now()->setTimezone('Asia/Jakarta'); // Set a_delete_at to the current time in Indonesia
        $about->a_status = 'HAPUS'; // Set a_status to "HAPUS"
        $about->save();
        return redirect()->route('admin.kesiswaan.about.index')->with('success-isi-content', 'Data Isi Content '. $about->a_visi .' Telah Berhasil Di Hapus Dan Ada Di Tampilan Status DELETE');
    }

    public function restore($id)
    {
        $about = About::findOrFail($id);
        $about->a_delete_at = null; // Remove the deletion timestamp
        $about->a_delete_id = null; // Set the delete ID to null
        $about->a_status = 'DRAFT'; // Set the status to "DRAFT"
        $about->a_update_id = auth()->user()->id; // Set update ID based on the logged-in user
        $about->a_update_at = now()->setTimezone('Asia/Jakarta'); // Set update timestamp to the current time in Indonesia
        $about->save();
        return redirect()->route('admin.kesiswaan.about.index')->with('success-isi-content', 'Data Isi Content '. $about->a_visi .' Telah Berhasil Di Pulihkan Dan Ada Di Tampilan Status DRAFT');
    }

    public function publish(Request $request, $id)
    {
        $about = About::findOrFail($id);
        $status = $request->input('status'); // Get the status from the form input

        if (!in_array($status, ['PUBLISH', 'TIDAK'])) {
            return redirect()->back()->withErrors(['error' => 'Status tidak valid']);
        }

        $about->a_status = strtoupper($status); // Set the status based on the form input
        $about->a_update_id = auth()->user()->id; // Set update ID based on the logged-in user
        $about->a_update_at = now()->setTimezone('Asia/Jakarta'); // Set update timestamp to the current time in Indonesia
        $about->save();

        return redirect()->back()->with('success-isi-content', 'Data Isi Content '. $about->a_visi .' Telah Berhasil Diupdate');
    }
}
