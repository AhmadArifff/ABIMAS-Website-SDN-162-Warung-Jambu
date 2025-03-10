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

class PenghargaanController extends Controller
{
    public function index(Request $request)
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

        $menu = $request->input('menu', 'Penghargaan');
        $penghargaan = Penghargaan::query();
        $kesiswaan = Kesiswaan::query();
        $ekstrakurikuler = Ekstrakurikuler::query();
        
        if ($request->get('-isi-content-status')) {
            $penghargaan->where('ph_status', $request->get('-isi-content-status'));
        } else {
            $penghargaan->whereIn('ph_status', ['publish', 'draft', 'tidak']);
        }

        if ($request->get('-isi-slide-status')) {
            $kesiswaan->where('k_status', $request->get('-isi-slide-status'));
        } else {
            $kesiswaan->whereIn('k_status', ['publish', 'draft', 'tidak']);
        }

        if ($request->get('k_keyword')) {
            $kesiswaan->where('k_judul_slide', 'LIKE', "%{$request->get('k_keyword')}%");
        }

        $kesiswaan->where('k_nama_menu', $menu);
    
        $penghargaan = $penghargaan->paginate(10);
        $kesiswaan = $kesiswaan->paginate(10);
        $ekstrakurikuler = $ekstrakurikuler->paginate(10);
    
        return view('kesiswaan.admin.index', compact('penghargaan', 'kesiswaan', 'menu','ekstrakurikuler', 'pembiasaan_all', 'kesiswaa_all', 'ekstrakurikuler_all', 'penghargaan_all', 'tatatertib_all', 'user_all'));
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
            return redirect()->back()->withErrors(['error' => 'Data Manage Content Slide Penghargaan Tidak Terpublish! Tolong Publish Terlebih Dahulu!']);
        }
        $ekstrakurikuler = Ekstrakurikuler::where('e_status', 'PUBLISH')->get();
        if (!$ekstrakurikuler) {
            return redirect()->back()->withErrors(['error' => 'Data Ekstrakurikuler Tidak Terpublish! Tolong Publish Terlebih Dahulu!']);
        }
        return view('kesiswaan/admin.create', compact('kesiswaan', 'menu', 'ekstrakurikuler', 'pembiasaan_all', 'kesiswaa_all', 'ekstrakurikuler_all', 'penghargaan_all', 'tatatertib_all', 'user_all', 'publishedEkstrakurikulerNames'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'e_id' => 'required|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $kesiswaan = Kesiswaan::where('k_status', 'PUBLISH')->first();
        if (!$kesiswaan) {
            return redirect()->back()->withErrors(['error' => 'Tidak Ada Data Slide Dengan Nama Slide "' . $kesiswaan->k_nama_menu . '" Yang PUBLISH']);
        }

        $penghargaan = new Penghargaan;
        $penghargaan->k_id = $request->k_id;
        $penghargaan->e_id = $request->e_id;
        $penghargaan->ph_create_id = auth()->user()->id;
        $penghargaan->ph_nama_kegiatan = $request->nama_kegiatan;
        $penghargaan->ph_deskripsi = $request->deskripsi;
        $penghargaan->ph_status = $request->input('status');

        if ($request->hasFile('foto')) {
            $nama_file = "Penghargaan" . time() . "_" . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move('kesiswaan_image/penghargaan_image', $nama_file);
            $penghargaan->ph_foto = $nama_file;
        }

        $penghargaan->save();
        return redirect()->route('admin.kesiswaan.penghargaan.index')->with('success-isi-content', 'Data Isi Content '. $kesiswaan->k_nama_menu .' Telah Berhasil Ditambahkan');
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

        $menu = 'Penghargaan';
        $penghargaan = Penghargaan::findOrFail($id);
        $kesiswaan = Kesiswaan::where('k_nama_menu', $menu)->where('k_status', 'PUBLISH')->first();
        $ekstrakurikuler = Ekstrakurikuler::all();
        
        if (!$kesiswaan) {
            return redirect()->back()->withErrors(['error' => 'Data Slide Harus Ada Status Publish!']);
        }
        
        if (!$ekstrakurikuler) {
            return redirect()->back()->withErrors(['error' => 'Data Ekstrakurikuler Tidak Ditemukan!']);
        }
        
        return view('kesiswaan/admin.edit', [
            'penghargaan' => $penghargaan,
            'kesiswaan' => $kesiswaan,
            'menu' => $menu,
            'ekstrakurikuler' => $ekstrakurikuler,
            'pembiasaan_all' => $pembiasaan_all,
            'kesiswaa_all' => $kesiswaa_all,
            'ekstrakurikuler_all' => $ekstrakurikuler_all,
            'penghargaan_all' => $penghargaan_all,
            'tatatertib_all' => $tatatertib_all,
            'user_all' => $user_all
        ]);
    }

    public function update(Request $request, $id)
    {
        $penghargaan = Penghargaan::findOrFail($id);
        
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|max:2048',
        ]);
        
        $kesiswaan = Kesiswaan::where('k_status', 'PUBLISH')->first();
        if (!$kesiswaan) {
            return redirect()->back()->withErrors(['error' => 'Data Manage Content Slide Penghargaan Tidak Terpublish! Tolong Publish Terlebih Dahulu!']);
        }
        $penghargaan->k_id = $request->k_id;
        $penghargaan->e_id = $request->e_id;
        $penghargaan->ph_update_id = auth()->user()->id;
        $penghargaan->ph_nama_kegiatan = $request->nama_kegiatan;
        $penghargaan->ph_deskripsi = $request->deskripsi;
        $penghargaan->ph_status = $request->input('status');

        if ($request->hasFile('foto')) {
            if ($penghargaan->ph_foto) {
                File::delete('kesiswaan_image/penghargaan_image/' . $penghargaan->ph_foto);
            }
            $nama_file = "Penghargaan" . time() . "_" . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move('kesiswaan_image/penghargaan_image', $nama_file);
            $penghargaan->ph_foto = $nama_file;
        }

        try {
            $penghargaan->save();
            return redirect()->route('admin.kesiswaan.penghargaan.index')->with('success-isi-content', 'Data Isi Content '. $kesiswaan->k_nama_menu .' Telah Berhasil Diubah');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update Penghargaan: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $penghargaan = Penghargaan::findOrFail($id);
        try {
            if ($penghargaan->ph_foto) {
                File::delete('kesiswaan_image/penghargaan_image/' . $penghargaan->ph_foto);
            }
            $penghargaan->delete();
            return redirect()->route('admin.kesiswaan.penghargaan.index')->with('success-isi-content', 'Data Isi Content '. $penghargaan->ph_nama_kegiatan .' Telah Berhasil Di Hapus Secara Permanen');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Tidak dapat menghapus atau memperbarui baris induk: pelanggaran batasan kunci asing.']);
        }
    }

    public function destroyrecycle($id)
    {
        $penghargaan = Penghargaan::findOrFail($id);
        $penghargaan->ph_delete_id = auth()->user()->id;
        $penghargaan->ph_delete_at = now()->setTimezone('Asia/Jakarta');
        $penghargaan->ph_status = 'HAPUS';
        $penghargaan->save();
        return redirect()->route('admin.kesiswaan.penghargaan.index')->with('success-isi-content', 'Data Isi Content '. $penghargaan->ph_nama_kegiatan .' Telah Berhasil Di Hapus Dan Ada Di Tampilan Status DELETE');
    }

    public function restore($id)
    {
        $penghargaan = Penghargaan::findOrFail($id);
        $penghargaan->ph_delete_at = null;
        $penghargaan->ph_delete_id = null;
        $penghargaan->ph_status = 'DRAFT';
        $penghargaan->ph_update_id = auth()->user()->id;
        $penghargaan->ph_update_at = now()->setTimezone('Asia/Jakarta');
        $penghargaan->save();
        return redirect()->route('admin.kesiswaan.penghargaan.index')->with('success-isi-content', 'Data Isi Content '. $penghargaan->ph_nama_kegiatan .' Telah Berhasil Di Pulihkan Dan Ada Di Tampilan Status DRAFT');
    }
    public function publish(Request $request,$id)
    {
        $penghargaan = Penghargaan::findOrFail($id);
        $status = $request->input('status'); // Get the status from the form input

        if (!in_array($status, ['publish', 'tidak'])) {
            return redirect()->back()->withErrors(['error' => 'Status tidak valid']);
        }
        $penghargaan->ph_status = strtoupper($status); // Set the status based on the form input
        $penghargaan->ph_update_id = auth()->user()->id; // Set update ID based on the logged-in user
        $penghargaan->ph_update_at = now()->setTimezone('Asia/Jakarta'); // Set update timestamp to the current time in Indonesia
        $penghargaan->save();
        return redirect()->back()->with('success-isi-content', 'Data Isi Content '. $penghargaan->ph_nama_kegiatan .' Telah Berhasil Dipublish');
    }
}
