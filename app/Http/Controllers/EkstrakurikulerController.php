<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pembiasaan;
use App\Kesiswaan;
use App\Ekstrakurikuler;
use App\Penghargaan;
use App\Beasiswa;
use App\Tatatertib;
use App\Strukturorganisasi;
use App\Berita;
use App\User;
use Illuminate\Support\Facades\File;

class EkstrakurikulerController extends Controller
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

        $menu = 'Ekstrakurikuler';
        $ekstrakurikuler = Ekstrakurikuler::query();
        $kesiswaan = Kesiswaan::query();
        
        if ($request->get('-isi-content-status')) {
            $ekstrakurikuler->where('e_status', $request->get('-isi-content-status'));
        } else {
            $ekstrakurikuler->whereIn('e_status', ['PUBLISH', 'DRAFT', 'TIDAK']);
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
        $ekstrakurikuler = $ekstrakurikuler->get();
        $kesiswaan = $kesiswaan->get();
        $berita_all = Berita::where('b_status', 'DRAFT')->get();
        $beasiswa_all = Beasiswa::where('status', 'DRAFT')->get();
    
        return view('kesiswaan.admin.index', compact('ekstrakurikuler', 'kesiswaan', 'menu', 'pembiasaan_all', 'kesiswaa_all', 'ekstrakurikuler_all', 'penghargaan_all', 'tatatertib_all', 'user_all', 'berita_all', 'beasiswa_all'));
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
        $publishedEkstrakurikulerNames = Ekstrakurikuler::where('e_status', 'PUBLISH')->pluck('e_nama_ekstrakurikuler')->toArray();
        $menu = $request->query('menu');
        // $kesiswaan = Kesiswaan::where('k_nama_menu', $menu)->where('k_status', 'PUBLISH')->first();
        // if (!$kesiswaan) {
        //     return redirect()->back()->withErrors(['error' => 'Data Manage Content Slide Ekstrakurikuler Tidak Terpublish! Tolong Publish Terlebih Dahulu!']);
        // }
        $berita_all = Berita::where('b_status', 'DRAFT')->get();
        $beasiswa_all = Beasiswa::where('status', 'DRAFT')->get();
        $getisPublished = Strukturorganisasi::where('so_status', 'PUBLISH')->count();
        $publishDisabled = $getisPublished >= 1; // Disable button if there is at least one published data
        $ekstrakurikuler = [
            'achievements' => [
            [
                'foto' => 'sample_image/Gambar.png',
                'judul' => 'Festival Seni Sekolah',
                'deskripsi' => 'Juara 2 Festival Seni Sekolah',
                'tanggal' => '2023-07-20'
            ],
            [
                'foto' => 'sample_image/Gambar.png',
                'judul' => 'Lomba Seni Daerah',
                'deskripsi' => 'Juara 1 Lomba Seni Daerah',
                'tanggal' => '2023-06-15'
            ]
            ]
        ];
        return view('kesiswaan/admin.create', compact( 'menu','ekstrakurikuler', 'pembiasaan_all', 'kesiswaa_all', 'ekstrakurikuler_all', 'penghargaan_all', 'tatatertib_all', 'user_all', 'publishedEkstrakurikulerNames', 'berita_all', 'beasiswa_all','getisPublished','publishDisabled'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'e_judul_slide' => 'required|string|max:255',
            'e_deskripsi_slide' => 'required|string|max:255',
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|max:2048',
            'e_foto_slide1' => 'nullable|image|max:2048',
            'e_foto_slide2' => 'nullable|image|max:2048',
            'e_foto_slide3' => 'nullable|image|max:2048',
        ]);

        // $kesiswaan = Kesiswaan::where('k_status', 'PUBLISH')->first();
        // if (!$kesiswaan) {
        //     return redirect()->back()->withErrors(['error' => 'Tidak Ada Data Slide Dengan Nama Slide "' . $kesiswaan->k_nama_menu . '" Yang PUBLISH']);
        // }

        $ekstrakurikuler = new Ekstrakurikuler;
        $ekstrakurikuler->e_create_id = auth()->user()->id; // Set u_id based on the logged-in user
        $ekstrakurikuler->e_judul_slide = $request->e_judul_slide;
        $ekstrakurikuler->e_deskripsi_slide = $request->e_deskripsi_slide;
        $ekstrakurikuler->e_nama_ekstrakurikuler = $request->nama_kegiatan;
        $ekstrakurikuler->e_deskripsi = $request->deskripsi;
        $ekstrakurikuler->e_status = $request->input('status'); // Set e_status based on the button clicked

        if ($request->hasFile('foto')) {
            $nama_file = "Ekstrakurikuler_" . time() . "_" . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move('kesiswaan_image/ekstrakurikuler_image', $nama_file);
            $ekstrakurikuler->e_foto = $nama_file;
        }

        if ($request->hasFile('e_foto_slide1')) {
            $nama_file1 = "Ekstrakurikuler_slide1_" . time() . "_" . $request->file('e_foto_slide1')->getClientOriginalName();
            $request->file('e_foto_slide1')->move('kesiswaan_image/slide_image', $nama_file1);
            $ekstrakurikuler->e_foto_slide1 = $nama_file1;
        }

        if ($request->hasFile('e_foto_slide2')) {
            $nama_file2 = "Ekstrakurikuler_slide2_" . time() . "_" . $request->file('e_foto_slide2')->getClientOriginalName();
            $request->file('e_foto_slide2')->move('kesiswaan_image/slide_image', $nama_file2);
            $ekstrakurikuler->e_foto_slide2 = $nama_file2;
        }

        if ($request->hasFile('e_foto_slide3')) {
            $nama_file3 = "Ekstrakurikuler_slide3_" . time() . "_" . $request->file('e_foto_slide3')->getClientOriginalName();
            $request->file('e_foto_slide3')->move('kesiswaan_image/slide_image', $nama_file3);
            $ekstrakurikuler->e_foto_slide3 = $nama_file3;
        }

        $ekstrakurikuler->save();
        return redirect()->route('admin.kesiswaan.ekstrakurikuler.index')->with('success-isi-content', 'Data Isi Content '. $request->nama_kegiatan .' Telah Berhasil Ditambahkan');
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
        $berita_all = Berita::where('b_status', 'DRAFT')->get();
        $beasiswa_all = Beasiswa::where('status', 'DRAFT')->get();

        
        $ekstrakurikuler_preview = [
            'achievements' => [
            [
                'foto' => 'sample_image/Gambar.png',
                'judul' => 'Festival Seni Sekolah',
                'deskripsi' => 'Juara 2 Festival Seni Sekolah',
                'tanggal' => '2023-07-20'
            ],
            [
                'foto' => 'sample_image/Gambar.png',
                'judul' => 'Lomba Seni Daerah',
                'deskripsi' => 'Juara 1 Lomba Seni Daerah',
                'tanggal' => '2023-06-15'
                ]
                ]
            ];
            $menu = 'Ekstrakurikuler';
            $ekstrakurikuler = Ekstrakurikuler::findOrFail($id);
            $publishedEkstrakurikulerNames = Ekstrakurikuler::where('e_status', 'PUBLISH')->pluck('e_nama_ekstrakurikuler')->toArray();
            $SetNames = Ekstrakurikuler::where('e_nama_ekstrakurikuler', $ekstrakurikuler->e_nama_ekstrakurikuler)
            ->where('e_status', 'PUBLISH')
            ->first();
        // $kesiswaan = Kesiswaan::where('k_nama_menu', $menu)->where('k_status', 'PUBLISH')->first();
        
        // if (!$kesiswaan) {
        //     return redirect()->back()->withErrors(['error' => 'Data Slide Harus Ada Status Publish!']);
        // }
        
        return view('kesiswaan/admin.edit', ['ekstrakurikuler' => $ekstrakurikuler, 'menu' => $menu, 'ekstrakurikuler_preview' => $ekstrakurikuler_preview, 'pembiasaan_all' => $pembiasaan_all, 'kesiswaa_all' => $kesiswaa_all, 'ekstrakurikuler_all' => $ekstrakurikuler_all, 'penghargaan_all' => $penghargaan_all, 'tatatertib_all' => $tatatertib_all, 'user_all' => $user_all, 'publishedEkstrakurikulerNames' => $publishedEkstrakurikulerNames, 'SetNames' => $SetNames, 'berita_all' => $berita_all, 'beasiswa_all' => $beasiswa_all]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'e_judul_slide' => 'required|string|max:255',
            'e_deskripsi_slide' => 'required|string|max:255',
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|max:2048',
            'e_foto_slide1' => 'nullable|image|max:2048',
            'e_foto_slide2' => 'nullable|image|max:2048',
            'e_foto_slide3' => 'nullable|image|max:2048',
        ]);

        $ekstrakurikuler = Ekstrakurikuler::findOrFail($id);
        $ekstrakurikuler->e_update_id = auth()->user()->id; // Set u_id based on the logged-in user
        $ekstrakurikuler->e_judul_slide = $request->e_judul_slide;
        $ekstrakurikuler->e_deskripsi_slide = $request->e_deskripsi_slide;
        $ekstrakurikuler->e_nama_ekstrakurikuler = $request->nama_kegiatan;
        $ekstrakurikuler->e_deskripsi = $request->deskripsi;
        $ekstrakurikuler->e_status = $request->input('status'); // Set e_status based on the button clicked

        if ($request->hasFile('foto')) {
            if ($ekstrakurikuler->e_foto) {
                File::delete('kesiswaan_image/ekstrakurikuler_image/' . $ekstrakurikuler->e_foto);
            }
            $nama_file = "Ekstrakurikuler_" . time() . "_" . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move('kesiswaan_image/ekstrakurikuler_image', $nama_file);
            $ekstrakurikuler->e_foto = $nama_file;
        }

        if ($request->hasFile('e_foto_slide1')) {
            if ($ekstrakurikuler->e_foto_slide1) {
                File::delete('kesiswaan_image/slide_image/' . $ekstrakurikuler->e_foto_slide1);
            }
            $nama_file1 = "Ekstrakurikuler_slide1_" . time() . "_" . $request->file('e_foto_slide1')->getClientOriginalName();
            $request->file('e_foto_slide1')->move('kesiswaan_image/slide_image', $nama_file1);
            $ekstrakurikuler->e_foto_slide1 = $nama_file1;
        }

        if ($request->hasFile('e_foto_slide2')) {
            if ($ekstrakurikuler->e_foto_slide2) {
                File::delete('kesiswaan_image/slide_image/' . $ekstrakurikuler->e_foto_slide2);
            }
            $nama_file2 = "Ekstrakurikuler_slide2_" . time() . "_" . $request->file('e_foto_slide2')->getClientOriginalName();
            $request->file('e_foto_slide2')->move('kesiswaan_image/slide_image', $nama_file2);
            $ekstrakurikuler->e_foto_slide2 = $nama_file2;
        }

        if ($request->hasFile('e_foto_slide3')) {
            if ($ekstrakurikuler->e_foto_slide3) {
                File::delete('kesiswaan_image/slide_image/' . $ekstrakurikuler->e_foto_slide3);
            }
            $nama_file3 = "Ekstrakurikuler_slide3_" . time() . "_" . $request->file('e_foto_slide3')->getClientOriginalName();
            $request->file('e_foto_slide3')->move('kesiswaan_image/slide_image', $nama_file3);
            $ekstrakurikuler->e_foto_slide3 = $nama_file3;
        }

        $ekstrakurikuler->save();
        return redirect()->route('admin.kesiswaan.ekstrakurikuler.index')->with('success-isi-content', 'Data Isi Content '. $request->nama_kegiatan .' Telah Berhasil Diubah');
    }

    public function destroy($id)
    {
        $ekstrakurikuler = Ekstrakurikuler::findOrFail($id);
        if ($ekstrakurikuler->e_foto) {
            File::delete('kesiswaan_image/ekstrakurikuler_image/' . $ekstrakurikuler->e_foto);
        }
        if ($ekstrakurikuler->e_foto_slide1) {
            File::delete('kesiswaan_image/slide_image/' . $ekstrakurikuler->e_foto_slide1);
        }
        if ($ekstrakurikuler->e_foto_slide2) {
            File::delete('kesiswaan_image/slide_image/' . $ekstrakurikuler->e_foto_slide2);
        }
        if ($ekstrakurikuler->e_foto_slide3) {
            File::delete('kesiswaan_image/slide_image/' . $ekstrakurikuler->e_foto_slide3);
        }
        $ekstrakurikuler->delete();
        return redirect()->route('admin.kesiswaan.ekstrakurikuler.index')->with('success-isi-content', 'Data Isi Content '. $ekstrakurikuler->e_nama_ekstrakurikuler .' Telah Berhasil Di Hapus Secara Permanen');
    }

    public function destroyrecycle($id)
    {
        $ekstrakurikuler = Ekstrakurikuler::findOrFail($id);
        $ekstrakurikuler->e_delete_id = auth()->user()->id; // Set e_delete_id based on the logged-in user
        $ekstrakurikuler->e_delete_at = now()->setTimezone('Asia/Jakarta'); // Set e_delete_at to the current time in Indonesia
        $ekstrakurikuler->e_status = 'HAPUS'; // Set e_status to "HAPUS"
        $ekstrakurikuler->save();
        return redirect()->route('admin.kesiswaan.ekstrakurikuler.index')->with('success-isi-content', 'Data Isi Content '. $ekstrakurikuler->e_nama_ekstrakurikuler .' Telah Berhasil Di Hapus Dan Ada Di Tampilan Status DELETE');
    }

    public function restore($id)
    {
        $ekstrakurikuler = Ekstrakurikuler::findOrFail($id);
        $ekstrakurikuler->e_delete_at = null; // Remove the deletion timestamp
        $ekstrakurikuler->e_delete_id = null; // Set the delete ID to null
        $ekstrakurikuler->e_status = 'DRAFT'; // Set the status to "DRAFT"
        $ekstrakurikuler->e_update_id = auth()->user()->id; // Set update ID based on the logged-in user
        $ekstrakurikuler->e_update_at = now()->setTimezone('Asia/Jakarta'); // Set update timestamp to the current time in Indonesia
        $ekstrakurikuler->save();
        return redirect()->route('admin.kesiswaan.ekstrakurikuler.index')->with('success-isi-content', 'Data Isi Content '. $ekstrakurikuler->e_nama_ekstrakurikuler .' Telah Berhasil Di Pulihkan Dan Ada Di Tampilan Status DRAFT');
    }
    public function publish(Request $request,$id)
    {
        $ekstrakurikuler = Ekstrakurikuler::findOrFail($id);
        $status = $request->input('status'); // Get the status from the form input

        if (!in_array($status, ['publish', 'tidak'])) {
            return redirect()->back()->withErrors(['error' => 'Status tidak valid']);
        }
        $ekstrakurikuler->e_status = strtoupper($status); // Set the status based on the form input
        $ekstrakurikuler->e_update_id = auth()->user()->id; // Set update ID based on the logged-in user
        $ekstrakurikuler->e_update_at = now()->setTimezone('Asia/Jakarta'); // Set update timestamp to the current time in Indonesia
        $ekstrakurikuler->save();
        return redirect()->back()->with('success-isi-content', 'Data Isi Content '. $ekstrakurikuler->e_nama_ekstrakurikuler .' Telah Berhasil Dipublish');
    }
}
