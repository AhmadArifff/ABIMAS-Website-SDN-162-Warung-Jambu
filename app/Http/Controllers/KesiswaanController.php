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

class KesiswaanController extends Controller
{
    public function create(Request $request) {
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

        $menu = $request->query('menu'); // Mengambil parameter 'menu' dari query string
        $getisPublished = Kesiswaan::where('k_status', 'PUBLISH')->where('k_nama_menu',$menu)->get();
        $publish= null;
        foreach ($getisPublished as $isPublished) {
            if ($isPublished->k_nama_menu == $menu && $isPublished->k_status == 'PUBLISH') {
                $publish= $isPublished->k_nama_menu;
                // return redirect()->back()->withErrors(['error' => 'Data Slide Dengan Nama Slide ' . $menu . ' Sudah Ada']);
            }
        }
        // $isPublished = Kesiswaan::where('k_nama_menu', $menu)->where('k_status', 'PUBLISH')->exists() && $kesiswaan->k_status !== 'PUBLISH';
        // $isPublished = Kesiswaan::where('k_status', 'publish')->exists();
        return view('kesiswaan.admin.create_slide', compact('menu', 'kesiswaa_all', 'ekstrakurikuler_all', 'penghargaan_all', 'tatatertib_all', 'user_all', 'pembiasaan_all','publish'));
    }    

    public function store(Request $request)
    {
        $request->validate([
            'k_nama_menu' => 'required|string|max:255',
            'k_judul_slide' => 'required|string|max:255',
            'k_deskripsi_slide' => 'required|string',
            'k_judul_isi_content' => 'required|string|max:255',
            'k_foto_slide1' => 'nullable|image|max:2048',
            'k_foto_slide2' => 'nullable|image|max:2048',
            'k_foto_slide3' => 'nullable|image|max:2048',
        ]);

        $kesiswaan = new Kesiswaan;
        $kesiswaan->k_create_id = auth()->user()->id;
        $kesiswaan->k_nama_menu = $request->k_nama_menu;
        $kesiswaan->k_judul_slide = $request->k_judul_slide;
        $kesiswaan->k_deskripsi_slide = $request->k_deskripsi_slide;
        $kesiswaan->k_judul_isi_content = $request->k_judul_isi_content;
        $kesiswaan->k_status = $request->status;

        if ($request->hasFile('k_foto_slide1')) {
            $nama_file1 = "Kesiswaan_slide1_" . time() . "_" . $request->file('k_foto_slide1')->getClientOriginalName();
            $request->file('k_foto_slide1')->move('kesiswaan_image/slide_image', $nama_file1);
            $kesiswaan->k_foto_slide1 = $nama_file1;
        }

        if ($request->hasFile('k_foto_slide2')) {
            $nama_file2 = "Kesiswaan_slide2_" . time() . "_" . $request->file('k_foto_slide2')->getClientOriginalName();
            $request->file('k_foto_slide2')->move('kesiswaan_image/slide_image', $nama_file2);
            $kesiswaan->k_foto_slide2 = $nama_file2;
        }

        if ($request->hasFile('k_foto_slide3')) {
            $nama_file3 = "Kesiswaan_slide3_" . time() . "_" . $request->file('k_foto_slide3')->getClientOriginalName();
            $request->file('k_foto_slide3')->move('kesiswaan_image/slide_image', $nama_file3);
            $kesiswaan->k_foto_slide3 = $nama_file3;
        }

        $kesiswaan->save();
        return redirect()->route('admin.kesiswaan.' . strtolower($kesiswaan->k_nama_menu) . '.index')->with('success-slide', 'Data Slide '.$request->k_nama_menu .' Telah Berhasil Ditambahkan');
    }

    public function edit(Request $request, $id)
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

        $menu = $request->query('menu'); // Mengambil parameter 'menu' dari query string
        $kesiswaan = Kesiswaan::findOrFail($id);
        $isPublished = Kesiswaan::where('k_nama_menu', $menu)->where('k_status', 'PUBLISH')->exists() && $kesiswaan->k_status !== 'PUBLISH';
        if (!$kesiswaan) {
            return redirect()->back()->withErrors(['error' => 'Tidak Ada Data Slide Dengan Nama Slide ' . $menu . ' found']);
        }
        return view('kesiswaan.admin.edit_slide', ['kesiswaan' => $kesiswaan, 'isPublished' => $isPublished, 'menu' => $menu, 'kesiswaa_all' => $kesiswaa_all, 'ekstrakurikuler_all' => $ekstrakurikuler_all, 'penghargaan_all' => $penghargaan_all, 'tatatertib_all' => $tatatertib_all, 'user_all' => $user_all, 'pembiasaan_all' => $pembiasaan_all]);
    }

    public function update(Request $request, $id)
    {
        $kesiswaan = Kesiswaan::findOrFail($id);

        $request->validate([
            'k_nama_menu' => 'required|string|max:255',
            'k_judul_slide' => 'required|string|max:255',
            'k_deskripsi_slide' => 'required|string',
            'k_judul_isi_content' => 'required|string|max:255',
            'k_foto_slide1' => 'nullable|image|max:2048',
            'k_foto_slide2' => 'nullable|image|max:2048',
            'k_foto_slide3' => 'nullable|image|max:2048',
        ]);

        $kesiswaan->k_update_id = auth()->user()->id;
        $kesiswaan->k_nama_menu = $request->k_nama_menu;
        $kesiswaan->k_judul_slide = $request->k_judul_slide;
        $kesiswaan->k_deskripsi_slide = $request->k_deskripsi_slide;
        $kesiswaan->k_judul_isi_content = $request->k_judul_isi_content;
        $kesiswaan->k_status = $request->input('status');

        if ($request->hasFile('k_foto_slide1')) {
            if ($kesiswaan->k_foto_slide1) {
                File::delete('kesiswaan_image/slide_image/' . $kesiswaan->k_foto_slide1);
            }
            $nama_file1 = "Kesiswaan_slide1_" . time() . "_" . $request->file('k_foto_slide1')->getClientOriginalName();
            $request->file('k_foto_slide1')->move('kesiswaan_image/slide_image', $nama_file1);
            $kesiswaan->k_foto_slide1 = $nama_file1;
        }

        if ($request->hasFile('k_foto_slide2')) {
            if ($kesiswaan->k_foto_slide2) {
                File::delete('kesiswaan_image/slide_image/' . $kesiswaan->k_foto_slide2);
            }
            $nama_file2 = "Kesiswaan_slide2_" . time() . "_" . $request->file('k_foto_slide2')->getClientOriginalName();
            $request->file('k_foto_slide2')->move('kesiswaan_image/slide_image', $nama_file2);
            $kesiswaan->k_foto_slide2 = $nama_file2;
        }

        if ($request->hasFile('k_foto_slide3')) {
            if ($kesiswaan->k_foto_slide3) {
                File::delete('kesiswaan_image/slide_image/' . $kesiswaan->k_foto_slide3);
            }
            $nama_file3 = "Kesiswaan_slide3_" . time() . "_" . $request->file('k_foto_slide3')->getClientOriginalName();
            $request->file('k_foto_slide3')->move('kesiswaan_image/slide_image', $nama_file3);
            $kesiswaan->k_foto_slide3 = $nama_file3;
        }

        try {
            $kesiswaan->save();
            return redirect()->route('admin.kesiswaan.'. strtolower($kesiswaan->k_nama_menu) .'.index')->with('success-slide', 'Data Slide '.$request->k_nama_menu .' Telah Berhasil Diubah');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update Kesiswaan: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $kesiswaan = Kesiswaan::findOrFail($id);
        $menu = $kesiswaan->k_nama_menu;
        $kolom = '';

        if ($menu === 'Penghargaan') {
            $penghargaan = $kesiswaan->penghargaan()->whereIn('ph_status', ['PUBLISH', 'DRAFT', 'HAPUS'])->get();
            if ($penghargaan->count() > 0) {
                $kolom = $penghargaan->map(function ($item, $key) {
                    return ($key + 1) . ' Adalah ' . '"'.$item->ph_nama_kegiatan.'" dengan status "' . $item->ph_status.'"';
                })->implode(', ');
            }
        } elseif ($menu === 'Pembiasaan') {
            $pembiasaan = $kesiswaan->pembiasaan()->whereIn('p_status', ['PUBLISH', 'DRAFT', 'HAPUS'])->get();
            if ($pembiasaan->count() > 0) {
                $kolom = $pembiasaan->map(function ($item, $key) {
                    return ($key + 1) . ' Adalah ' . '"'.$item->p_nama_kegiatan.'" dengan status "' . $item->p_status.'"';
                })->implode(', ');
            }
        }

        try {
            $kesiswaan->delete();
            if ($kesiswaan->k_foto_slide1) {
                File::delete('kesiswaan_image/slide_image/' . $kesiswaan->k_foto_slide1);
            }
            if ($kesiswaan->k_foto_slide2) {
                File::delete('kesiswaan_image/slide_image/' . $kesiswaan->k_foto_slide2);
            }
            if ($kesiswaan->k_foto_slide3) {
                File::delete('kesiswaan_image/slide_image/' . $kesiswaan->k_foto_slide3);
            }
            return redirect()->route('admin.kesiswaan.'. strtolower($kesiswaan->k_nama_menu) .'.index')->with('success-slide', 'Data Slide '.$menu .' Telah Berhasil Di Hapus Permanen');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->back()->with('error', 'Tidak dapat menghapus karena data slide ini terkait dengan data "management isi content" dengan data Nama Kegiatan : ' . $kolom);
            }
            return redirect()->back()->with('error', 'Failed to delete Kesiswaan: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete Kesiswaan: ' . $e->getMessage());
        }
    }

    public function destroyrecycle($id)
    {
        $kesiswaan = Kesiswaan::findOrFail($id);
        $kesiswaan->k_delete_id = auth()->user()->id;
        $kesiswaan->k_delete_at = now()->setTimezone('Asia/Jakarta');
        $kesiswaan->k_status = 'HAPUS';
        $kesiswaan->save();
        return redirect()->route('admin.kesiswaan.'. strtolower($kesiswaan->k_nama_menu) .'.index')->with('success-slide', 'Data Slide '.$kesiswaan->k_nama_menu .' Telah Berhasil Di Hapus Dan Ada Di Tampilan Status DELETE');
    }

    public function restore($id)
    {
        $kesiswaan = Kesiswaan::findOrFail($id);
        $kesiswaan->k_delete_at = null;
        $kesiswaan->k_delete_id = null;
        $kesiswaan->k_status = 'DRAFT';
        $kesiswaan->k_update_id = auth()->user()->id;
        $kesiswaan->k_update_at = now()->setTimezone('Asia/Jakarta');
        $kesiswaan->save();
        return redirect()->route('admin.kesiswaan.'. strtolower($kesiswaan->k_nama_menu) .'.index')->with('success-slide', 'Data Slide '.$kesiswaan->k_nama_menu .' Telah Berhasil Di Pulihkan Dan Ada Di Tampilan Status DRAFT');
    }
    public function publish(Request $request, $id)
    {
        $kesiswaan = Kesiswaan::findOrFail($id);
        $status = $request->input('status'); // Get the status from the form input

        if (!in_array($status, ['publish', 'tidak'])) {
            return redirect()->back()->withErrors(['error' => 'Status tidak valid']);
        }

        $kesiswaan->k_status = strtoupper($status); // Set the status based on the form input
        $kesiswaan->k_update_id = auth()->user()->id; // Set update ID based on the logged-in user
        $kesiswaan->k_update_at = now()->setTimezone('Asia/Jakarta'); // Set update timestamp to the current time in Indonesia
        $kesiswaan->save();

        return redirect()->back()->with('success-isi-content', 'Data Isi Content '. $kesiswaan->k_nama_menu .' Telah Berhasil Diupdate');
    }
}