<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pembiasaan;
use App\Kesiswaan;
use App\Ekstrakurikuler;
use App\Penghargaan;
use App\Tatatertib;
use App\User;
use Illuminate\Support\Facades\File;

class PembiasaanController extends Controller
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
        $menu = 'Pembiasaan';
        $pembiasaan = Pembiasaan::query();
        $kesiswaan = Kesiswaan::query();
        $ekstrakurikuler = Ekstrakurikuler::query();
        $penghargaan = Penghargaan::query();
        $tatatertib = Tatatertib::query();
        $user = User::query();
        
        if ($request->get('-isi-content-status')) {
            $pembiasaan->where('p_status', $request->get('-isi-content-status'));
        } else {
            $pembiasaan->whereIn('p_status', ['publish', 'draft', 'tidak']);
        }

        if ($request->get('-isi-slide-status')) {
            $kesiswaan->where('k_status', $request->get('-isi-slide-status'));
        } else {
            $kesiswaan->whereIn('k_status', ['publish', 'draft', 'tidak']);
        }

        if ($request->get('k_keyword')) {
            $kesiswaan->where('k_judul_slide', 'LIKE', "%{$request->get('k_keyword')}%");
        }
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
        $kesiswaan->where('k_nama_menu', $menu);
        $pembiasaan = $pembiasaan->paginate(10);
        $kesiswaan = $kesiswaan->paginate(10);
    
        return view('kesiswaan.admin.index', compact('pembiasaan', 'kesiswaan', 'menu', 'kesiswaa_all', 'ekstrakurikuler_all', 'penghargaan_all', 'tatatertib_all', 'user_all', 'pembiasaan_all','publishedEkstrakurikulerNames'));
    }

    public function create(Request $request)
    {
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

        $menu = $request->query('menu');
        // $kesiswaan = Kesiswaan::where('k_status', 'PUBLISH')->first();
        $kesiswaan = Kesiswaan::where('k_nama_menu', $menu)->where('k_status', 'PUBLISH')->first();
        if (!$kesiswaan) {
            return redirect()->back()->withErrors(['error' => 'Data Manage Content Slide Pembiasaan Tidak Terpublish! Tolong Publish Terlebih Dahulu!']);
        }
        return view('kesiswaan/admin.create', compact('kesiswaan', 'menu', 'kesiswaa_all', 'ekstrakurikuler_all', 'penghargaan_all', 'tatatertib_all', 'user_all', 'pembiasaan_all','publishedEkstrakurikulerNames'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $kesiswaan = Kesiswaan::where('k_status', 'PUBLISH')->first();
        if (!$kesiswaan) {
            return redirect()->back()->withErrors(['error' => 'Tidak Ada Data Slide Dengan Nama Slide "' . $kesiswaan->k_nama_menu . '" Yang PUBLISH']);
        }

        $pembiasaan = new Pembiasaan;
        $pembiasaan->k_id = $request->k_id;
        $pembiasaan->p_create_id = auth()->user()->id; // Set u_id based on the logged-in user
        $pembiasaan->p_nama_kegiatan = $request->nama_kegiatan;
        $pembiasaan->p_deskripsi = $request->deskripsi;
        $pembiasaan->p_status = $request->input('status'); // Set p_status based on the button clicked

        if ($request->hasFile('foto')) {
            $nama_file = "Pembiasaan_" . time() . "_" . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move('kesiswaan_image/pembiasaan_image', $nama_file);
            $pembiasaan->p_foto = $nama_file;
        }

        $pembiasaan->save();
        return redirect()->route('admin.kesiswaan.pembiasaan.index')->with('success-isi-content', 'Data Isi Content '. $kesiswaan->k_nama_menu .' Telah Berhasil Ditambahkan');
    }

    public function edit($id)
    {
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

        $menu = 'Pembiasaan';
        $pembiasaan = Pembiasaan::findOrFail($id);
        // $kesiswaan = Kesiswaan::where('k_id', $pembiasaan->k_id)->where('k_status', 'PUBLISH')->first();
        $kesiswaan = Kesiswaan::where('k_nama_menu', $menu)->where('k_status', 'PUBLISH')->first();
        
        if (!$kesiswaan) {
            return redirect()->back()->withErrors(['error' => 'Data Slide Harus Ada Status Publish!']);
        }
        
        // $menu = $kesiswaan->k_nama_menu;
        return view('kesiswaan/admin.edit', ['pembiasaan' => $pembiasaan, 'kesiswaan' => $kesiswaan, 'menu' => $menu, 'kesiswaa_all' => $kesiswaa_all, 'ekstrakurikuler_all' => $ekstrakurikuler_all, 'penghargaan_all' => $penghargaan_all, 'tatatertib_all' => $tatatertib_all, 'user_all' => $user_all, 'pembiasaan_all' => $pembiasaan_all]);
    }

    public function update(Request $request, $id)
    {
        $pembiasaan = Pembiasaan::findOrFail($id);

        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|max:2048',
        ]);
        
        $kesiswaan = Kesiswaan::where('k_status', 'PUBLISH')->first();
        if (!$kesiswaan) {
            return redirect()->back()->withErrors(['error' => 'Data Manage Content Slide Pembiasaan Tidak Terpublish! Tolong Publish Terlebih Dahulu!']);
        }
        $pembiasaan->k_id = $request->k_id;
        $pembiasaan->p_update_id = auth()->user()->id; // Set u_id based on the logged-in user
        $pembiasaan->p_nama_kegiatan = $request->nama_kegiatan;
        $pembiasaan->p_deskripsi = $request->deskripsi;
        $pembiasaan->p_status = $request->input('status'); // Set p_status based on the button clicked

        if ($request->hasFile('foto')) {
            if ($pembiasaan->p_foto) {
                File::delete('kesiswaan_image/pembiasaan_image/' . $pembiasaan->p_foto);
            }
            $nama_file = "Pembiasaan_" . time() . "_" . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move('kesiswaan_image/pembiasaan_image', $nama_file);
            $pembiasaan->p_foto = $nama_file;
        }

        try {
            $pembiasaan->save();
            return redirect()->route('admin.kesiswaan.pembiasaan.index')->with('success-isi-content', 'Data Isi Content '. $kesiswaan->k_nama_menu .' Telah Berhasil Diubah');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update Pembiasaan: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $pembiasaan = Pembiasaan::findOrFail($id);
        if ($pembiasaan->p_foto) {
            File::delete('kesiswaan_image/pembiasaan_image/' . $pembiasaan->p_foto);
        }
        $pembiasaan->delete();
        return redirect()->route('admin.kesiswaan.pembiasaan.index')->with('success-isi-content', 'Data Isi Content '. $pembiasaan->p_nama_kegiatan .' Telah Berhasil Di Hapus Secara Permanen');
    }
    public function destroyrecycle($id)
    {
        $pembiasaan = Pembiasaan::findOrFail($id);
        $pembiasaan->p_delete_id = auth()->user()->id; // Set p_delete_id based on the logged-in user
        $pembiasaan->p_delete_at = now()->setTimezone('Asia/Jakarta'); // Set p_delete_at to the current time in Indonesia
        $pembiasaan->p_status = 'HAPUS'; // Set p_status to "HAPUS"
        $pembiasaan->save();
        return redirect()->route('admin.kesiswaan.pembiasaan.index')->with('success-isi-content', 'Data Isi Content '. $pembiasaan->p_nama_kegiatan .' Telah Berhasil Di Hapus Dan Ada Di Tampilan Status DELETE');
    }
    public function restore($id)
    {
        $pembiasaan = Pembiasaan::findOrFail($id);
        $pembiasaan->p_delete_at = null; // Remove the deletion timestamp
        $pembiasaan->p_delete_id = null; // Set the delete ID to null
        $pembiasaan->p_status = 'DRAFT'; // Set the status to "DRAFT"
        $pembiasaan->p_update_id = auth()->user()->id; // Set update ID based on the logged-in user
        $pembiasaan->p_update_at = now()->setTimezone('Asia/Jakarta'); // Set update timestamp to the current time in Indonesia
        $pembiasaan->save();
        return redirect()->route('admin.kesiswaan.pembiasaan.index')->with('success-isi-content', 'Data Isi Content '. $pembiasaan->p_nama_kegiatan .' Telah Berhasil Di Pulihkan Dan Ada Di Tampilan Status DRAFT');
    }
    public function publish(Request $request, $id)
    {
        $pembiasaan = Pembiasaan::findOrFail($id);
        $status = $request->input('status'); // Get the status from the form input

        if (!in_array($status, ['publish', 'tidak'])) {
            return redirect()->back()->withErrors(['error' => 'Status tidak valid']);
        }

        $pembiasaan->p_status = strtoupper($status); // Set the status based on the form input
        $pembiasaan->p_update_id = auth()->user()->id; // Set update ID based on the logged-in user
        $pembiasaan->p_update_at = now()->setTimezone('Asia/Jakarta'); // Set update timestamp to the current time in Indonesia
        $pembiasaan->save();

        return redirect()->back()->with('success-isi-content', 'Data Isi Content '. $pembiasaan->p_nama_kegiatan .' Telah Berhasil Diupdate');
    }
}
