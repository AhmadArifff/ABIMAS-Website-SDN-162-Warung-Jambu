<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pembiasaan;
use App\Kesiswaan;
use App\Modul; // Replacing Strukturorganisasi with Modul
use App\Penghargaan;
use App\Ekstrakurikuler;
use App\Beasiswa;
use App\Tatatertib;
use App\Berita;
use App\Guru;
use App\User;
use Illuminate\Support\Facades\File;

class ModulController extends Controller
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
        $pembiasaan_all = Pembiasaan::where('p_status', 'DRAFT')->get();
        $publishedMenus = Kesiswaan::where('k_status', 'PUBLISH')->pluck('k_nama_menu')->toArray();

        $kesiswaa_all = Kesiswaan::where('k_status', 'DRAFT')
            ->whereNotIn('k_nama_menu', $publishedMenus)
            ->get();
        $publishedModulNames = Modul::where('m_status', 'PUBLISH')->pluck('m_nama_modul')->toArray();

        $modul_all = Modul::where('m_status', 'DRAFT')
            ->whereNotIn('m_nama_modul', $publishedModulNames)
            ->get();
        $penghargaan_all = Penghargaan::where('ph_status', 'DRAFT')->get();
        $tatatertib_all = Tatatertib::where('t_status', 'DRAFT')->get();
        $publishedEkstrakurikulerNames = Ekstrakurikuler::where('e_status', 'PUBLISH')->pluck('e_nama_ekstrakurikuler')->toArray();

        $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'DRAFT')
            ->whereNotIn('e_nama_ekstrakurikuler', $publishedEkstrakurikulerNames)
            ->get();
        $user_all = User::all();

        $menu = 'Modul';
        $modul = Modul::query();
        $kesiswaan = Kesiswaan::query();
        $gurus = Guru::all();

        if ($request->get('-isi-content-status')) {
            $modul->where('m_status', $request->get('-isi-content-status'));
        } else {
            $modul->whereIn('m_status', ['PUBLISH', 'DRAFT', 'HAPUS']);
        }

        if ($request->get('k_keyword')) {
            $modul->where('m_nama_modul', 'LIKE', "%{$request->get('k_keyword')}%");
        }

        $kesiswaan->where('k_nama_menu', $menu);
        // $modul = Modul::all();
        $modul = $modul->get();
        $kesiswaan = $kesiswaan->get();
        $berita_all = Berita::where('b_status', 'DRAFT')->get();
        $beasiswa_all = Beasiswa::where('status', 'DRAFT')->get();

        return view('modul.index', compact('menu', 'modul', 'kesiswaan', 'pembiasaan_all', 'kesiswaa_all', 'modul_all', 'penghargaan_all', 'tatatertib_all', 'user_all', 'publishedModulNames', 'berita_all', 'beasiswa_all', 'ekstrakurikuler_all', 'publishedEkstrakurikulerNames', 'gurus'));
    }

    public function create(Request $request)
    {
        $pembiasaan_all = Pembiasaan::where('p_status', 'DRAFT')->get();
        $publishedMenus = Kesiswaan::where('k_status', 'PUBLISH')->pluck('k_nama_menu')->toArray();

        $kesiswaa_all = Kesiswaan::where('k_status', 'DRAFT')
            ->whereNotIn('k_nama_menu', $publishedMenus)
            ->get();
        $publishedModulNames = Modul::where('m_status', 'PUBLISH')->pluck('m_nama_modul')->toArray();
        $getisPublished = Modul::where('m_status', 'PUBLISH')->count();
        $publishDisabled = $getisPublished >= 1;
        $modul_all = Modul::where('m_status', 'DRAFT')
            ->whereNotIn('m_nama_modul', $publishedModulNames)
            ->get();
        $penghargaan_all = Penghargaan::where('ph_status', 'DRAFT')->get();
        $tatatertib_all = Tatatertib::where('t_status', 'DRAFT')->get();
        $publishedEkstrakurikulerNames = Ekstrakurikuler::where('e_status', 'PUBLISH')->pluck('e_nama_ekstrakurikuler')->toArray();

        $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'DRAFT')
            ->whereNotIn('e_nama_ekstrakurikuler', $publishedEkstrakurikulerNames)
            ->get();
        $user_all = User::all();
        $menu = $request->query('menu');
        $berita_all = Berita::where('b_status', 'DRAFT')->get();
        $beasiswa_all = Beasiswa::where('status', 'DRAFT')->get();
        $gurus = Guru::all();
        $modul = [
            'achievements' => [
                [
                    'foto' => 'sample_image/Gambar.png',
                    'judul' => 'Modul Pembelajaran',
                    'deskripsi' => 'Modul terbaru untuk kelas',
                    'tanggal' => '2023-07-20'
                ]
            ]
        ];
        return view('modul.create', compact('menu', 'modul', 'pembiasaan_all', 'kesiswaa_all', 'modul_all', 'penghargaan_all', 'tatatertib_all', 'user_all', 'publishedModulNames', 'berita_all', 'beasiswa_all', 'ekstrakurikuler_all', 'publishedEkstrakurikulerNames', 'getisPublished', 'publishDisabled', 'gurus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'm_nama_modul' => 'required|string|max:255',
            'm_modul_kelas' => 'required|string|max:255',
            'm_deskripsi_modul' => 'required|string',
            'm_foto_atau_pdf' => 'nullable|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $modul = new Modul;
        $modul->m_create_id = auth()->user()->id;
        $modul->m_guru_id = $request->m_guru_id; // Add this line to handle m_guru_id
        $modul->m_nama_modul = $request->m_nama_modul;
        $modul->m_modul_kelas = $request->m_modul_kelas;
        $modul->m_deskripsi_modul = $request->m_deskripsi_modul;
        $modul->m_status = $request->input('m_status', 'DRAFT'); // Default to 'DRAFT' if not provided

        if ($request->hasFile('m_foto_atau_pdf')) {
            $file = $request->file('m_foto_atau_pdf');
            $extension = $file->getClientOriginalExtension();

            if (strtolower($extension) === 'pdf') {
                $nama_file_pdf = "Modul_pdf_" . time() . "_" . $file->getClientOriginalName();
                $file->move(public_path('modul_image/pdf'), $nama_file_pdf);
                $modul->m_foto_atau_pdf = $nama_file_pdf;
            } elseif (in_array(strtolower($extension), ['jpeg', 'jpg', 'png'])) {
                $nama_file_image = "Modul_image_" . time() . "_" . $file->getClientOriginalName();
                $file->move(public_path('modul_image/foto'), $nama_file_image);
                $modul->m_foto_atau_pdf = $nama_file_image;
            } else {
                return redirect()->back()->withErrors(['error' => 'File harus berupa PDF atau gambar (jpeg, jpg, png)']);
            }
        }

        $modul->save();
        return redirect()->route('admin.modul.index')->with('success-isi-content', 'Data Modul ' . $request->m_nama_modul . ' Telah Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        $pembiasaan_all = Pembiasaan::where('p_status', 'DRAFT')->get();
        $publishedMenus = Kesiswaan::where('k_status', 'PUBLISH')->pluck('k_nama_menu')->toArray();

        $kesiswaa_all = Kesiswaan::where('k_status', 'DRAFT')
            ->whereNotIn('k_nama_menu', $publishedMenus)
            ->get();

        $publishedModulNames = Modul::where('m_status', 'PUBLISH')->pluck('m_nama_modul')->toArray();

        $modul_all = Modul::where('m_status', 'DRAFT')
            ->whereNotIn('m_nama_modul', $publishedModulNames)
            ->get();
        $penghargaan_all = Penghargaan::where('ph_status', 'DRAFT')->get();
        $publishedEkstrakurikulerNames = Ekstrakurikuler::where('e_status', 'PUBLISH')->pluck('e_nama_ekstrakurikuler')->toArray();

        $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'DRAFT')
            ->whereNotIn('e_nama_ekstrakurikuler', $publishedEkstrakurikulerNames)
            ->get();
        $tatatertib_all = Tatatertib::where('t_status', 'DRAFT')->get();
        $user_all = User::all();
        $berita_all = Berita::where('b_status', 'DRAFT')->get();
        $beasiswa_all = Beasiswa::where('status', 'DRAFT')->get();
        $getisPublished = Modul::where('m_status', 'PUBLISH')->count();
        $publishDisabled = $getisPublished >= 1;

        $gurus = Guru::all();

        $menu = 'Modul';
        $modul = Modul::findOrFail($id);
        $isPublished = Modul::where('m_status', 'PUBLISH')->exists() && $modul->m_status !== 'PUBLISH';
        $SetNames = Modul::where('m_nama_modul', $modul->m_nama_modul)
            ->where('m_status', 'PUBLISH')
            ->first();

        return view('modul.edit', compact('menu', 'modul', 'pembiasaan_all', 'kesiswaa_all', 'modul_all', 'penghargaan_all', 'tatatertib_all', 'user_all', 'publishedModulNames', 'berita_all', 'beasiswa_all', 'SetNames', 'ekstrakurikuler_all', 'publishedEkstrakurikulerNames', 'getisPublished', 'publishDisabled', 'isPublished', 'gurus'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'm_nama_modul' => 'required|string|max:255',
            'm_modul_kelas' => 'required|string|max:255',
            'm_deskripsi_modul' => 'required|string',
            'm_foto_atau_pdf' => 'nullable|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $modul = Modul::findOrFail($id);
        $modul->m_update_id = auth()->user()->id;
        $modul->m_guru_id = $request->m_guru_id; // Add this line to handle m_guru_id
        $modul->m_nama_modul = $request->m_nama_modul;
        $modul->m_modul_kelas = $request->m_modul_kelas;
        $modul->m_deskripsi_modul = $request->m_deskripsi_modul;
        $modul->m_status = $request->input('m_status', 'DRAFT'); // Default to 'DRAFT' if not provided

        if ($request->hasFile('m_foto_atau_pdf')) {
            if ($modul->m_foto_atau_pdf) {
                File::delete(public_path('modul_image/pdf/' . $modul->m_foto_atau_pdf));
                File::delete(public_path('modul_image/foto/' . $modul->m_foto_atau_pdf));
            }
            $file = $request->file('m_foto_atau_pdf');
            $extension = $file->getClientOriginalExtension();

            if (strtolower($extension) === 'pdf') {
                $nama_file_pdf = "Modul_pdf_" . time() . "_" . $file->getClientOriginalName();
                $file->move(public_path('modul_image/pdf'), $nama_file_pdf);
                $modul->m_foto_atau_pdf = $nama_file_pdf;
            } elseif (in_array(strtolower($extension), ['jpeg', 'jpg', 'png'])) {
                $nama_file_image = "Modul_image_" . time() . "_" . $file->getClientOriginalName();
                $file->move(public_path('modul_image/foto'), $nama_file_image);
                $modul->m_foto_atau_pdf = $nama_file_image;
            } else {
                return redirect()->back()->withErrors(['error' => 'File harus berupa PDF atau gambar (jpeg, jpg, png)']);
            }
        }

        $modul->save();
        return redirect()->route('admin.modul.index')->with('success-isi-content', 'Data Modul ' . $request->m_nama_modul . ' Telah Berhasil Diubah');
    }

    public function destroy($id)
    {
        $modul = Modul::findOrFail($id);
        if ($modul->m_foto_atau_pdf) {
            $pdfPath = public_path('modul_image/pdf/' . $modul->m_foto_atau_pdf);
            $imagePath = public_path('modul_image/foto/' . $modul->m_foto_atau_pdf);

            if (File::exists($pdfPath)) {
                File::delete($pdfPath);
            }
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
        $modul->delete();
        return redirect()->route('admin.modul.index')->with('success-isi-content', 'Data Modul ' . $modul->m_nama_modul . ' Telah Berhasil Dihapus Secara Permanen');
    }

    public function destroyrecycle($id)
    {
        $modul = Modul::findOrFail($id);
        $modul->m_delete_id = auth()->user()->id;
        $modul->m_delete_at = now()->setTimezone('Asia/Jakarta');
        $modul->m_status = 'HAPUS';
        $modul->save();
        return redirect()->route('admin.modul.index')->with('success-isi-content', 'Data Modul ' . $modul->m_nama_modul . ' Telah Berhasil Dihapus Dan Ada Di Tampilan Status DELETE');
    }

    public function restore($id)
    {
        $modul = Modul::findOrFail($id);
        $modul->m_delete_at = null;
        $modul->m_delete_id = null;
        $modul->m_status = 'DRAFT';
        $modul->m_update_id = auth()->user()->id;
        $modul->m_update_at = now()->setTimezone('Asia/Jakarta');
        $modul->save();
        return redirect()->route('admin.modul.index')->with('success-isi-content', 'Data Modul ' . $modul->m_nama_modul . ' Telah Berhasil Dipulihkan Dan Ada Di Tampilan Status DRAFT');
    }

    public function publish(Request $request, $id)
    {
        $modul = Modul::findOrFail($id);
        $status = $request->input('status');

        if (!in_array($status, ['publish', 'tidak'])) {
            return redirect()->back()->withErrors(['error' => 'Status tidak valid']);
        }
        $modul->m_status = strtoupper($status);
        $modul->m_update_id = auth()->user()->id;
        $modul->m_update_at = now()->setTimezone('Asia/Jakarta');
        $modul->save();
        return redirect()->back()->with('success-isi-content', 'Data Modul ' . $modul->m_nama_modul . ' Telah Berhasil Dipublish');
    }

    public function viewFile($filename)
    {
        $path = public_path('modul_image/pdf/' . $filename);

        if (!File::exists($path)) {
            abort(404, 'File not found');
        }

        return response()->file($path);
    }

    public function storeFile(Request $request)
    {
        $request->validate([
            'm_foto_atau_pdf' => 'required|mimes:jpeg,jpg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('m_foto_atau_pdf')) {
            $file = $request->file('m_foto_atau_pdf');
            $extension = $file->getClientOriginalExtension();
            $filename = "Modul_" . time() . "_" . $file->getClientOriginalName();

            if (strtolower($extension) === 'pdf') {
                $file->move(public_path('modul_image/pdf'), $filename);
            } else {
                $file->move(public_path('modul_image/foto'), $filename);
            }

            return response()->json(['success' => true, 'filename' => $filename]);
        }

        return response()->json(['success' => false, 'message' => 'File upload failed.']);
    }
}
