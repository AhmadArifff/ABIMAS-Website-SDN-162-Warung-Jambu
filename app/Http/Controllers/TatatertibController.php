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

class TatatertibController extends Controller
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
        $menu = 'Tatatertib';
        $tatatertib = Tatatertib::query();
        $kesiswaan = Kesiswaan::query();
        
        if ($request->get('-isi-content-status')) {
            $tatatertib->where('t_status', $request->get('-isi-content-status'));
        } else {
            $tatatertib->whereIn('t_status', ['PUBLISH', 'DRAFT', 'TIDAK']);
        }

        if ($request->get('-isi-slide-status')) {
            $kesiswaan->where('k_status', $request->get('-isi-slide-status'));
        } else {
            $kesiswaan->whereIn('k_status', ['PUBLISH', 'DRAFT', 'TIDAK']);
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
        $tatatertib = $tatatertib->paginate(10);
        $kesiswaan = $kesiswaan->paginate(10);
    
        return view('kesiswaan.admin.index', compact('tatatertib', 'kesiswaan', 'menu', 'pembiasaan_all', 'kesiswaa_all', 'ekstrakurikuler_all', 'penghargaan_all', 'tatatertib_all', 'user_all'));
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
        $kesiswaan = Kesiswaan::where('k_nama_menu', $menu)->where('k_status', 'PUBLISH')->first();
        if (!$kesiswaan) {
            return redirect()->back()->withErrors(['error' => 'Data Manage Content Slide Tatatertib Tidak Terpublish! Tolong Publish Terlebih Dahulu!']);
        }
        $tatatertib = [
            'rules' => [
            [
                'foto' => 'sample_image/Gambar.png',
                'judul' => 'Peraturan 1',
                'deskripsi' => 'Deskripsi Peraturan 1',
                'tanggal' => '2023-07-20'
            ],
            [
                'foto' => 'sample_image/Gambar.png',
                'judul' => 'Peraturan 2',
                'deskripsi' => 'Deskripsi Peraturan 2',
                'tanggal' => '2023-06-15'
            ]
            ]
          ];
        return view('kesiswaan/admin.create', compact('kesiswaan', 'menu','tatatertib', 'pembiasaan_all', 'kesiswaa_all', 'ekstrakurikuler_all', 'penghargaan_all', 'tatatertib_all', 'user_all','publishedEkstrakurikulerNames'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan.*' => 'required|string|max:255',
            'deskripsi.*' => 'required|string',
        ]);

        $kesiswaan = Kesiswaan::where('k_status', 'PUBLISH')->first();
        if (!$kesiswaan) {
            return redirect()->back()->withErrors(['error' => 'Tidak Ada Data Slide Dengan Nama Slide "' . $kesiswaan->k_nama_menu . '" Yang PUBLISH']);
        }

        foreach ($request->nama_kegiatan as $index => $nama_kegiatan) {
            $tatatertib = new Tatatertib;
            $tatatertib->k_id = $request->k_id;
            $tatatertib->t_create_id = auth()->user()->id; // Set u_id based on the logged-in user
            $tatatertib->t_nama_peraturan = $nama_kegiatan;
            $tatatertib->t_deskripsi = $request->deskripsi[$index];
            $tatatertib->t_status = $request->input('status'); // Set t_status based on the button clicked

            $tatatertib->save();
        }

        return redirect()->route('admin.kesiswaan.tatatertib.index')->with('success-isi-content', 'Data Isi Content '. $kesiswaan->k_nama_menu .' Telah Berhasil Ditambahkan');
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
        $tatatertib_preview = [
            'rules' => [
            [
                'foto' => 'sample_image/Gambar.png',
                'judul' => 'Peraturan 1',
                'deskripsi' => 'Deskripsi Peraturan 1',
                'tanggal' => '2023-07-20'
            ],
            [
                'foto' => 'sample_image/Gambar.png',
                'judul' => 'Peraturan 2',
                'deskripsi' => 'Deskripsi Peraturan 2',
                'tanggal' => '2023-06-15'
            ]
            ]
        ];
        $menu = 'Tatatertib';
        $tatatertib = Tatatertib::findOrFail($id);
        $kesiswaan = Kesiswaan::where('k_nama_menu', $menu)->where('k_status', 'PUBLISH')->first();
        
        if (!$kesiswaan) {
            return redirect()->back()->withErrors(['error' => 'Data Slide Harus Ada Status Publish!']);
        }
        
        return view('kesiswaan/admin.edit', ['tatatertib' => $tatatertib, 'kesiswaan' => $kesiswaan, 'menu' => $menu, 'tatatertib_preview' => $tatatertib_preview, 'pembiasaan_all' => $pembiasaan_all, 'kesiswaa_all' => $kesiswaa_all, 'ekstrakurikuler_all' => $ekstrakurikuler_all, 'penghargaan_all' => $penghargaan_all, 'tatatertib_all' => $tatatertib_all, 'user_all' => $user_all]);
    }

    public function update(Request $request, $id)
    {
        $tatatertib = Tatatertib::findOrFail($id);

        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);
        
        $kesiswaan = Kesiswaan::where('k_status', 'PUBLISH')->first();
        if (!$kesiswaan) {
            return redirect()->back()->withErrors(['error' => 'Data Manage Content Slide Tatatertib Tidak Terpublish! Tolong Publish Terlebih Dahulu!']);
        }
        $tatatertib->k_id = $request->k_id;
        $tatatertib->t_update_id = auth()->user()->id; // Set u_id based on the logged-in user
        $tatatertib->t_nama_peraturan = $request->nama_kegiatan;
        $tatatertib->t_deskripsi = $request->deskripsi;
        $tatatertib->t_status = $request->input('status'); // Set t_status based on the button clicked

        try {
            $tatatertib->save();
            return redirect()->route('admin.kesiswaan.tatatertib.index')->with('success-isi-content', 'Data Isi Content '. $kesiswaan->k_nama_menu .' Telah Berhasil Diubah');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update Tatatertib: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $tatatertib = Tatatertib::findOrFail($id);
        if ($tatatertib->t_foto) {
            File::delete('kesiswaan_image/tatatertib_image/' . $tatatertib->t_foto);
        }
        $tatatertib->delete();
        return redirect()->route('admin.kesiswaan.tatatertib.index')->with('success-isi-content', 'Data Isi Content '. $tatatertib->t_nama_peraturan .' Telah Berhasil Di Hapus Secara Permanen');
    }

    public function destroyrecycle($id)
    {
        $tatatertib = Tatatertib::findOrFail($id);
        $tatatertib->t_delete_id = auth()->user()->id; // Set t_delete_id based on the logged-in user
        $tatatertib->t_delete_at = now()->setTimezone('Asia/Jakarta'); // Set t_delete_at to the current time in Indonesia
        $tatatertib->t_status = 'HAPUS'; // Set t_status to "HAPUS"
        $tatatertib->save();
        return redirect()->route('admin.kesiswaan.tatatertib.index')->with('success-isi-content', 'Data Isi Content '. $tatatertib->t_nama_peraturan .' Telah Berhasil Di Hapus Dan Ada Di Tampilan Status DELETE');
    }

    public function restore($id)
    {
        $tatatertib = Tatatertib::findOrFail($id);
        $tatatertib->t_delete_at = null; // Remove the deletion timestamp
        $tatatertib->t_delete_id = null; // Set the delete ID to null
        $tatatertib->t_status = 'DRAFT'; // Set the status to "DRAFT"
        $tatatertib->t_update_id = auth()->user()->id; // Set update ID based on the logged-in user
        $tatatertib->t_update_at = now()->setTimezone('Asia/Jakarta'); // Set update timestamp to the current time in Indonesia
        $tatatertib->save();
        return redirect()->route('admin.kesiswaan.tatatertib.index')->with('success-isi-content', 'Data Isi Content '. $tatatertib->t_nama_peraturan .' Telah Berhasil Di Pulihkan Dan Ada Di Tampilan Status DRAFT');
    }
    public function publish(Request $request,$id)
    {
        $tatatertib = Tatatertib::findOrFail($id);
        $status = $request->input('status'); // Get the status from the form input

        if (!in_array($status, ['publish', 'tidak'])) {
            return redirect()->back()->withErrors(['error' => 'Status tidak valid']);
        }
        $tatatertib->t_status = strtoupper($status); // Set the status based on the form input
        $tatatertib->t_update_id = auth()->user()->id; // Set update ID based on the logged-in user
        $tatatertib->t_update_at = now()->setTimezone('Asia/Jakarta'); // Set update timestamp to the current time in Indonesia
        $tatatertib->save();
        return redirect()->back()->with('success-isi-content', 'Data Isi Content '. $tatatertib->t_nama_peraturan .' Telah Berhasil Dipublish');
    }
}
