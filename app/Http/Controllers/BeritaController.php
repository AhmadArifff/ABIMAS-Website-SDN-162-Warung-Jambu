<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Berita;
use App\Kesiswaan;
use App\Ekstrakurikuler;
use App\Penghargaan;
use App\Beasiswa;
use App\Tatatertib;
use App\User;
use App\Pembiasaan;

class BeritaController extends Controller
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
        $menu = 'Berita';
        $berita = Berita::query();
        $kesiswaan = Kesiswaan::query();
        $ekstrakurikuler = Ekstrakurikuler::query();
        $penghargaan = Penghargaan::query();
        $tatatertib = Tatatertib::query();
        $user = User::query();

        if ($request->get('-isi-content-status')) {
            $berita->where('b_status', $request->get('-isi-content-status'));
        } else {
            $berita->whereIn('b_status', ['PUBLISH', 'DRAFT', 'TIDAK']);
        }

        if ($request->get('-isi-slide-status')) {
            $kesiswaan->where('k_status', $request->get('-isi-slide-status'));
        } else {
            $kesiswaan->whereIn('k_status', ['PUBLISH', 'DRAFT', 'TIDAK']);
        }

        if ($request->get('k_keyword')) {
            $kesiswaan->where('k_judul_slide', 'LIKE', "%{$request->get('k_keyword')}%");
        }
        $berita_all = Berita::where('b_status', 'DRAFT')->get();
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
        $berita = $berita->paginate(10);
        $kesiswaan = $kesiswaan->paginate(10);
        $pembiasaan_all = Pembiasaan::where('p_status', 'DRAFT')->get();
        $beasiswa_all = Beasiswa::where('status', 'DRAFT')->get();

        return view('berita.index', compact('berita', 'kesiswaan', 'menu', 'kesiswaa_all', 'ekstrakurikuler_all', 'penghargaan_all', 'tatatertib_all', 'user_all', 'berita_all', 'pembiasaan_all', 'beasiswa_all'));
    }

    public function create(Request $request)
    {
        $berita_all = Berita::where('b_status', 'DRAFT')->get();
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
        $pembiasaan_all = Pembiasaan::where('p_status', 'DRAFT')->get();
        $beasiswa_all = Beasiswa::where('status', 'DRAFT')->get();
        $user_all = User::all();

        $menu = $request->query('menu');
        $kesiswaan = Kesiswaan::where('k_nama_menu', $menu)->where('k_status', 'PUBLISH')->first();
        if (!$kesiswaan) {
            return redirect()->back()->withErrors(['error' => 'Data Manage Content Slide Pembiasaan Tidak Terpublish! Tolong Publish Terlebih Dahulu!']);
        }
        $publish = false; // Atau sesuaikan dengan kebutuhan

        return view('berita.create', compact('publish', 'kesiswaan', 'menu', 'kesiswaa_all', 'ekstrakurikuler_all', 'penghargaan_all', 'tatatertib_all', 'user_all', 'berita_all', 'pembiasaan_all', 'beasiswa_all'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'b_nama_berita' => 'required|string|max:255',
            'b_deskripsi_berita' => 'required|string',
            'b_foto_berita' => 'nullable|image|max:2048',
        ]);

        $kesiswaan = Kesiswaan::where('k_status', 'PUBLISH')->first();
        if (!$kesiswaan) {
            return redirect()->back()->withErrors(['error' => 'Tidak Ada Data Slide Dengan Nama Slide Yang PUBLISH']);
        }

        $berita = new Berita;
        $berita->k_id = $kesiswaan->k_id;
        $berita->b_create_id = auth()->user()->id;
        $berita->b_nama_berita = $request->b_nama_berita;
        $berita->b_deskripsi_berita = $request->b_deskripsi_berita;
        if ($request->hasFile('b_foto_berita')) {
            $nama_file = "Berita_" . time() . "_" . $request->file('b_foto_berita')->getClientOriginalName();
            $request->file('b_foto_berita')->move('berita_image', $nama_file);
            $berita->b_foto_berita = $nama_file;
        } else {
            $berita->b_foto_berita = null;
        }
        $berita->b_status = $request->input('status');

        $berita->save();
        return redirect()->route('admin.berita.index')->with('success-isi-content', 'Data Isi Content ' . $kesiswaan->k_nama_menu . ' Telah Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        $berita_all = Berita::where('b_foto_berita', 'DRAFT')->get();
        $publishedMenus = Kesiswaan::where('k_status', 'PUBLISH')->pluck('k_nama_menu')->toArray();
        $pembiasaan_all = Pembiasaan::where('p_status', 'DRAFT')->get();

        $kesiswaa_all = Kesiswaan::where('k_status', 'DRAFT')
            ->whereNotIn('k_nama_menu', $publishedMenus) // Hanya mengambil DRAFT yang tidak punya PUBLISH dalam grupnya
            ->get();
        $publishedEkstrakurikulerNames = Ekstrakurikuler::where('e_status', 'PUBLISH')->pluck('e_nama_ekstrakurikuler')->toArray();

        $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'DRAFT')
            ->whereNotIn('e_nama_ekstrakurikuler', $publishedEkstrakurikulerNames) // Hanya mengambil DRAFT yang tidak punya PUBLISH dalam grupnya
            ->get();
        $penghargaan_all = Penghargaan::where('ph_status', 'DRAFT')->get();
        $tatatertib_all = Tatatertib::where('t_status', 'DRAFT')->get();
        $beasiswa_all = Beasiswa::where('status', 'DRAFT')->get();
        $user_all = User::all();

        $menu = 'Berita';
        $berita = Berita::findOrFail($id);
        $kesiswaan = Kesiswaan::where('k_nama_menu', $menu)->where('k_status', 'PUBLISH')->first();

        if (!$kesiswaan) {
            return redirect()->back()->withErrors(['error' => 'Data Slide Harus Ada Status Publish!']);
        }

        return view('berita.edit', [
            'berita' => $berita,
            'kesiswaan' => $kesiswaan,
            'menu' => $menu,
            'kesiswaa_all' => $kesiswaa_all,
            'ekstrakurikuler_all' => $ekstrakurikuler_all,
            'penghargaan_all' => $penghargaan_all,
            'tatatertib_all' => $tatatertib_all,
            'user_all' => $user_all,
            'berita_all' => $berita_all,
            'pembiasaan_all' => $pembiasaan_all,
            'beasiswa_all' => $beasiswa_all
        ]);
    }

    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);

        $request->validate([
            'b_nama_berita' => 'required|string|max:255',
            'b_deskripsi_berita' => 'required|string',
            'b_foto_berita' => 'nullable|image|max:2048',
        ]);

        $kesiswaan = Kesiswaan::where('k_status', 'PUBLISH')->first();
        if (!$kesiswaan) {
            return redirect()->back()->withErrors(['error' => 'Tidak Ada Data Slide Dengan Nama Slide Yang PUBLISH']);
        }

        $berita->k_id = $kesiswaan->k_id;
        $berita->b_update_id = auth()->user()->id;
        $berita->b_nama_berita = $request->b_nama_berita;
        $berita->b_deskripsi_berita = $request->b_deskripsi_berita;

        if ($request->hasFile('b_foto_berita')) {
            // Delete the old image if it exists
            if ($berita->b_foto_berita && file_exists(public_path('berita_image/' . $berita->b_foto_berita))) {
                unlink(public_path('berita_image/' . $berita->b_foto_berita));
            }

            $nama_file = "Berita_" . time() . "_" . $request->file('b_foto_berita')->getClientOriginalName();
            $request->file('b_foto_berita')->move('berita_image', $nama_file);
            $berita->b_foto_berita = $nama_file;
        }

        $berita->b_status = $request->input('status');

        try {
            $berita->save();
            return redirect()->route('admin.berita.index')->with('success-isi-content', 'Data Isi Content ' . $kesiswaan->k_nama_menu . ' Telah Berhasil Diubah');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update Berita: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);
        if ($berita->b_foto_berita) {
            File::delete('berita_image/' . $berita->b_foto_berita);
        }
        $berita->delete();
        return redirect()->route('admin.berita.index')->with('success-isi-content', 'Data Isi Content ' . $berita->b_nama_berita . ' Telah Berhasil Di Hapus Secara Permanen');
    }

    public function destroyrecycle($id)
    {
        $berita = Berita::findOrFail($id);
        $berita->b_delete_id = auth()->user()->id; // Set b_delete_id based on the logged-in user
        $berita->b_delete_at = now()->setTimezone('Asia/Jakarta'); // Set b_delete_at to the current time in Indonesia
        $berita->b_status = 'HAPUS'; // Set b_foto to "HAPUS"
        $berita->save();
        return redirect()->route('admin.berita.index')->with('success-isi-content', 'Data Isi Content ' . $berita->b_nama_berita . ' Telah Berhasil Di Hapus Dan Ada Di Tampilan Status DELETE');
    }

    public function restore($id)
    {
        $berita = Berita::findOrFail($id);
        $berita->b_delete_at = null; // Remove the deletion timestamp
        $berita->b_delete_id = null; // Set the delete ID to null
        $berita->b_status = 'DRAFT'; // Set the status to "DRAFT"
        $berita->b_update_id = auth()->user()->id; // Set update ID based on the logged-in user
        $berita->b_update_at = now()->setTimezone('Asia/Jakarta'); // Set update timestamp to the current time in Indonesia
        $berita->save();
        return redirect()->route('admin.berita.index')->with('success-isi-content', 'Data Isi Content ' . $berita->b_nama_berita . ' Telah Berhasil Di Pulihkan Dan Ada Di Tampilan Status DRAFT');
    }

    public function publish(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);
        $status = $request->input('status'); // Get the status from the form input

        if (!in_array($status, ['publish', 'tidak'])) {
            return redirect()->back()->withErrors(['error' => 'Status tidak valid']);
        }

        $berita->b_status = strtoupper($status); // Set the status based on the form input
        $berita->b_update_id = auth()->user()->id; // Set update ID based on the logged-in user
        $berita->b_update_at = now()->setTimezone('Asia/Jakarta'); // Set update timestamp to the current time in Indonesia
        $berita->save();

        return redirect()->back()->with('success-isi-content', 'Data Isi Content ' . $berita->b_nama_berita . ' Telah Berhasil Diupdate');
    }
}
