<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pembiasaan;
use App\Kesiswaan;
use App\Strukturorganisasi; // Mengganti Ekstrakurikuler dengan Strukturorganisasi
use App\Penghargaan;
use App\Ekstrakurikuler;
use App\Beasiswa;
use App\Tatatertib;
use App\Berita;
use App\User;
use Illuminate\Support\Facades\File;

class StrukturorganisasiController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'admin') {
                return redirect()->route('dashboard')->withErrors(['error' => 'Anda tidak memiliki akses ke halaman ini']);
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $pembiasaan_all = Pembiasaan::where('p_status', 'DRAFT')->get();
        $publishedMenus = Kesiswaan::where('k_status', 'PUBLISH')->pluck('k_nama_menu')->toArray();

        $kesiswaa_all = Kesiswaan::where('k_status', 'DRAFT')
            ->whereNotIn('k_nama_menu', $publishedMenus)
            ->get();
        $publishedStrukturorganisasiNames = Strukturorganisasi::where('so_status', 'PUBLISH')->pluck('so_judul_content')->toArray();

        $strukturorganisasi_all = Strukturorganisasi::where('so_status', 'DRAFT')
            ->whereNotIn('so_judul_content', $publishedStrukturorganisasiNames)
            ->get();
        $penghargaan_all = Penghargaan::where('ph_status', 'DRAFT')->get();
        $tatatertib_all = Tatatertib::where('t_status', 'DRAFT')->get();
        $publishedEkstrakurikulerNames = Ekstrakurikuler::where('e_status', 'PUBLISH')->pluck('e_nama_ekstrakurikuler')->toArray();

        $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'DRAFT')
            ->whereNotIn('e_nama_ekstrakurikuler', $publishedEkstrakurikulerNames) // Hanya mengambil DRAFT yang tidak punya PUBLISH dalam grupnya
            ->get();
        $user_all = User::all();

        $menu = 'Strukturorganisasi';
        $strukturorganisasi = Strukturorganisasi::query();
        $kesiswaan = Kesiswaan::query();

        if ($request->get('-isi-content-status')) {
            $strukturorganisasi->where('so_status', $request->get('-isi-content-status'));
        } else {
            $strukturorganisasi->whereIn('so_status', ['PUBLISH', 'DRAFT', 'TIDAK']);
        }

        if ($request->get('-isi-slide-status')) {
            $kesiswaan->where('k_status', $request->get('-isi-slide-status'));
        } else {
            $kesiswaan->whereIn('k_status', ['PUBLISH', 'DRAFT', 'TIDAK']);
        }

        if ($request->get('k_keyword')) {
            $kesiswaan->where('k_judul_slide', 'LIKE', "%{$request->get('k_keyword')}%");
        }

        $kesiswaan->where('k_nama_menu', $menu);
        $strukturorganisasi = $strukturorganisasi->get();
        $kesiswaan = $kesiswaan->get();
        $berita_all = Berita::where('b_status', 'DRAFT')->get();
        $beasiswa_all = Beasiswa::where('status', 'DRAFT')->get();

        return view('kesiswaan.admin.index', compact('menu', 'strukturorganisasi', 'kesiswaan', 'pembiasaan_all', 'kesiswaa_all', 'strukturorganisasi_all', 'penghargaan_all', 'tatatertib_all', 'user_all', 'publishedStrukturorganisasiNames', 'berita_all', 'beasiswa_all', 'ekstrakurikuler_all'));
    }

    public function create(Request $request)
    {
        $pembiasaan_all = Pembiasaan::where('p_status', 'DRAFT')->get();
        $publishedMenus = Kesiswaan::where('k_status', 'PUBLISH')->pluck('k_nama_menu')->toArray();

        $kesiswaa_all = Kesiswaan::where('k_status', 'DRAFT')
            ->whereNotIn('k_nama_menu', $publishedMenus)
            ->get();
        $publishedStrukturorganisasiNames = Strukturorganisasi::where('so_status', 'PUBLISH')->pluck('so_judul_content')->toArray();
        $getisPublished = Strukturorganisasi::where('so_status', 'PUBLISH')->count();
        $publishDisabled = $getisPublished >= 1; // Disable button if there is at least one published data
        $strukturorganisasi_all = Strukturorganisasi::where('so_status', 'DRAFT')
            ->whereNotIn('so_judul_content', $publishedStrukturorganisasiNames)
            ->get();
        $penghargaan_all = Penghargaan::where('ph_status', 'DRAFT')->get();
        $tatatertib_all = Tatatertib::where('t_status', 'DRAFT')->get();
        $publishedEkstrakurikulerNames = Ekstrakurikuler::where('e_status', 'PUBLISH')->pluck('e_nama_ekstrakurikuler')->toArray();

        $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'DRAFT')
            ->whereNotIn('e_nama_ekstrakurikuler', $publishedEkstrakurikulerNames) // Hanya mengambil DRAFT yang tidak punya PUBLISH dalam grupnya
            ->get();
        $user_all = User::all();
        $menu = $request->query('menu');
        $berita_all = Berita::where('b_status', 'DRAFT')->get();
        $beasiswa_all = Beasiswa::where('status', 'DRAFT')->get();
        $strukturorganisasi = [
            'achievements' => [
                [
                    'foto' => 'sample_image/Gambar.png',
                    'judul' => 'Struktur Organisasi Sekolah',
                    'deskripsi' => 'Struktur organisasi terbaru',
                    'tanggal' => '2023-07-20'
                ]
            ]
        ];
        return view('kesiswaan/admin.create', compact('menu', 'strukturorganisasi', 'pembiasaan_all', 'kesiswaa_all', 'strukturorganisasi_all', 'penghargaan_all', 'tatatertib_all', 'user_all', 'publishedStrukturorganisasiNames', 'berita_all', 'beasiswa_all', 'ekstrakurikuler_all','publishedEkstrakurikulerNames','getisPublished','publishDisabled'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'so_judul_slide' => 'required|string|max:255',
            'so_deskripsi_slide' => 'required|string|max:255',
            'so_foto_slide' => 'nullable|image|max:2048',
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'so_foto_atau_pdf' => 'nullable|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $strukturorganisasi = new Strukturorganisasi;
        $strukturorganisasi->so_create_id = auth()->user()->id;
        $strukturorganisasi->so_judul_slide = $request->so_judul_slide;
        $strukturorganisasi->so_deskripsi_slide = $request->so_deskripsi_slide;
        $strukturorganisasi->so_judul_content = $request->nama_kegiatan;
        $strukturorganisasi->so_deskripsi = $request->deskripsi;
        $strukturorganisasi->so_status = $request->input('status');

        if ($request->hasFile('so_foto_slide')) {
            $nama_file = "Strukturorganisasi_" . time() . "_" . $request->file('so_foto_slide')->getClientOriginalName();
            $request->file('so_foto_slide')->move('strukturorganisasi_image/slide_image', $nama_file);
            $strukturorganisasi->so_foto_slide = $nama_file;
        }

        if ($request->hasFile('so_foto_atau_pdf')) {
            $file = $request->file('so_foto_atau_pdf');
            $extension = $file->getClientOriginalExtension();

            if (in_array(strtolower($extension), ['pdf'])) {
            $nama_file_pdf = "Strukturorganisasi_pdf_" . time() . "_" . $file->getClientOriginalName();
            $file->move('strukturorganisasi_image/pdf_image', $nama_file_pdf);
            $strukturorganisasi->so_foto_atau_pdf = $nama_file_pdf;
            } elseif (in_array(strtolower($extension), ['jpeg', 'jpg', 'png'])) {
            $nama_file_image = "Strukturorganisasi_image_" . time() . "_" . $file->getClientOriginalName();
            $file->move('strukturorganisasi_image/foto_image', $nama_file_image);
            $strukturorganisasi->so_foto_atau_pdf = $nama_file_image;
            } else {
            return redirect()->back()->withErrors(['error' => 'File harus berupa PDF atau gambar (jpeg, jpg, png)']);
            }
        }

        $strukturorganisasi->save();
        return redirect()->route('admin.kesiswaan.strukturorganisasi.index')->with('success-isi-content', 'Data Isi Content ' . $request->so_judul_content . ' Telah Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        $pembiasaan_all = Pembiasaan::where('p_status', 'DRAFT')->get();
        $publishedMenus = Kesiswaan::where('k_status', 'PUBLISH')->pluck('k_nama_menu')->toArray();

        $kesiswaa_all = Kesiswaan::where('k_status', 'DRAFT')
            ->whereNotIn('k_nama_menu', $publishedMenus)
            ->get();

        $publishedStrukturorganisasiNames = Strukturorganisasi::where('so_status', 'PUBLISH')->pluck('so_judul_content')->toArray();

        $strukturorganisasi_all = Strukturorganisasi::where('so_status', 'DRAFT')
            ->whereNotIn('so_judul_content', $publishedStrukturorganisasiNames)
            ->get();
        $penghargaan_all = Penghargaan::where('ph_status', 'DRAFT')->get();
        $publishedEkstrakurikulerNames = Ekstrakurikuler::where('e_status', 'PUBLISH')->pluck('e_nama_ekstrakurikuler')->toArray();

        $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'DRAFT')
            ->whereNotIn('e_nama_ekstrakurikuler', $publishedEkstrakurikulerNames) // Hanya mengambil DRAFT yang tidak punya PUBLISH dalam grupnya
            ->get();
        $tatatertib_all = Tatatertib::where('t_status', 'DRAFT')->get();
        $user_all = User::all();
        $berita_all = Berita::where('b_status', 'DRAFT')->get();
        $beasiswa_all = Beasiswa::where('status', 'DRAFT')->get();
        $getisPublished = Strukturorganisasi::where('so_status', 'PUBLISH')->count();
        $publishDisabled = $getisPublished >= 1;

        $menu = 'Strukturorganisasi';
        $strukturorganisasi = Strukturorganisasi::findOrFail($id);
        $isPublished = Strukturorganisasi::where('so_status', 'PUBLISH')->exists() && $strukturorganisasi->so_status !== 'PUBLISH';
        $SetNames = Strukturorganisasi::where('so_judul_content', $strukturorganisasi->so_judul_content)
            ->where('so_status', 'PUBLISH')
            ->first();

        return view('kesiswaan/admin.edit', compact('menu', 'strukturorganisasi', 'pembiasaan_all', 'kesiswaa_all', 'strukturorganisasi_all', 'penghargaan_all', 'tatatertib_all', 'user_all', 'publishedStrukturorganisasiNames', 'berita_all', 'beasiswa_all', 'SetNames', 'ekstrakurikuler_all', 'publishedEkstrakurikulerNames','getisPublished','publishDisabled','isPublished'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'so_judul_slide' => 'required|string|max:255',
            'so_deskripsi_slide' => 'required|string|max:255',
            'so_foto_slide' => 'nullable|image|max:2048',
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'so_foto_atau_pdf' => 'nullable|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $strukturorganisasi = Strukturorganisasi::findOrFail($id);
        $strukturorganisasi->so_update_id = auth()->user()->id;
        $strukturorganisasi->so_judul_slide = $request->so_judul_slide;
        $strukturorganisasi->so_deskripsi_slide = $request->so_deskripsi_slide;
        $strukturorganisasi->so_judul_content = $request->nama_kegiatan;
        $strukturorganisasi->so_deskripsi = $request->deskripsi;
        $strukturorganisasi->so_status = $request->input('status');

        if ($request->hasFile('so_foto_slide')) {
            if ($strukturorganisasi->so_foto_slide) {
                File::delete(public_path('strukturorganisasi_image/slide_image/' . $strukturorganisasi->so_foto_slide));
            }
            $nama_file = "Strukturorganisasi_" . time() . "_" . $request->file('so_foto_slide')->getClientOriginalName();
            $request->file('so_foto_slide')->move(public_path('strukturorganisasi_image/slide_image'), $nama_file);
            $strukturorganisasi->so_foto_slide = $nama_file;
        }

        if ($request->hasFile('so_foto_atau_pdf')) {
            if ($strukturorganisasi->so_foto_atau_pdf) {
                $path = public_path('strukturorganisasi_image/pdf_image/' . $strukturorganisasi->so_foto_atau_pdf);
                if (File::exists($path)) {
                    File::delete($path);
                }
            }
            $file = $request->file('so_foto_atau_pdf');
            $extension = $file->getClientOriginalExtension();

            if (strtolower($extension) === 'pdf') {
                $nama_file_pdf = "Strukturorganisasi_pdf_" . time() . "_" . $file->getClientOriginalName();
                $file->move(public_path('strukturorganisasi_image/pdf_image'), $nama_file_pdf);
                $strukturorganisasi->so_foto_atau_pdf = $nama_file_pdf;
            } elseif (in_array(strtolower($extension), ['jpeg', 'jpg', 'png'])) {
                $nama_file_image = "Strukturorganisasi_image_" . time() . "_" . $file->getClientOriginalName();
                $file->move(public_path('strukturorganisasi_image/foto_image'), $nama_file_image);
                $strukturorganisasi->so_foto_atau_pdf = $nama_file_image;
            }
        }

        $strukturorganisasi->save();
        return redirect()->route('admin.kesiswaan.strukturorganisasi.index')->with('success-isi-content', 'Data Isi Content ' . $request->so_judul_content . ' Telah Berhasil Diubah');
    }

    public function destroy($id)
    {
        $strukturorganisasi = Strukturorganisasi::findOrFail($id);
        if ($strukturorganisasi->so_foto_slide) {
            File::delete('strukturorganisasi_image/slide_image/' . $strukturorganisasi->so_foto_slide);
        }
        if ($strukturorganisasi->so_foto_atau_pdf) {
            File::delete('strukturorganisasi_image/pdf_image/' . $strukturorganisasi->so_foto_atau_pdf);
        }
        $strukturorganisasi->delete();
        return redirect()->route('admin.kesiswaan.strukturorganisasi.index')->with('success-isi-content', 'Data Isi Content ' . $strukturorganisasi->so_judul_content . ' Telah Berhasil Dihapus Secara Permanen');
    }

    public function destroyrecycle($id)
    {
        $strukturorganisasi = Strukturorganisasi::findOrFail($id);
        $strukturorganisasi->so_delete_id = auth()->user()->id;
        $strukturorganisasi->so_delete_at = now()->setTimezone('Asia/Jakarta');
        $strukturorganisasi->so_status = 'HAPUS';
        $strukturorganisasi->save();
        return redirect()->route('admin.kesiswaan.strukturorganisasi.index')->with('success-isi-content', 'Data Isi Content ' . $strukturorganisasi->so_judul_content . ' Telah Berhasil Dihapus Dan Ada Di Tampilan Status DELETE');
    }

    public function restore($id)
    {
        $strukturorganisasi = Strukturorganisasi::findOrFail($id);
        $strukturorganisasi->so_delete_at = null;
        $strukturorganisasi->so_delete_id = null;
        $strukturorganisasi->so_status = 'DRAFT';
        $strukturorganisasi->so_update_id = auth()->user()->id;
        $strukturorganisasi->so_update_at = now()->setTimezone('Asia/Jakarta');
        $strukturorganisasi->save();
        return redirect()->route('admin.kesiswaan.strukturorganisasi.index')->with('success-isi-content', 'Data Isi Content ' . $strukturorganisasi->so_judul_content . ' Telah Berhasil Dipulihkan Dan Ada Di Tampilan Status DRAFT');
    }

    public function publish(Request $request, $id)
    {
        $strukturorganisasi = Strukturorganisasi::findOrFail($id);
        $status = $request->input('status');

        if (!in_array($status, ['publish', 'tidak'])) {
            return redirect()->back()->withErrors(['error' => 'Status tidak valid']);
        }
        $strukturorganisasi->so_status = strtoupper($status);
        $strukturorganisasi->so_update_id = auth()->user()->id;
        $strukturorganisasi->so_update_at = now()->setTimezone('Asia/Jakarta');
        $strukturorganisasi->save();
        return redirect()->back()->with('success-isi-content', 'Data Isi Content ' . $strukturorganisasi->so_judul_content . ' Telah Berhasil Dipublish');
    }
    public function viewFile($filename)
    {
        $path = public_path('strukturorganisasi_image/pdf_image/' . $filename);

        if (!File::exists($path)) {
            abort(404, 'File not found');
        }

        return response()->file($path);
    }
    public function storeFile(Request $request)
    {
        $request->validate([
            'so_foto_atau_pdf' => 'required|mimes:jpeg,jpg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('so_foto_atau_pdf')) {
            $file = $request->file('so_foto_atau_pdf');
            $extension = $file->getClientOriginalExtension();
            $filename = "Strukturorganisasi_" . time() . "_" . $file->getClientOriginalName();

            if (strtolower($extension) === 'pdf') {
                $file->move(public_path('strukturorganisasi_image/pdf_image'), $filename);
            } else {
                $file->move(public_path('strukturorganisasi_image/foto_image'), $filename);
            }

            return response()->json(['success' => true, 'filename' => $filename]);
        }

        return response()->json(['success' => false, 'message' => 'File upload failed.']);
    }
}
