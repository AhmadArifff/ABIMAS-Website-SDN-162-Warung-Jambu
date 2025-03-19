<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Beasiswa;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Pembiasaan;
use App\Kesiswaan;
use App\Ekstrakurikuler;
use App\Penghargaan;
use App\Tatatertib;
use App\Berita;
use App\User;

class BeasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

        $publishedEkstrakurikulerNames = Ekstrakurikuler::where('e_status', 'PUBLISH')->pluck('e_nama_ekstrakurikuler')->toArray();

        $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'DRAFT')
            ->whereNotIn('e_nama_ekstrakurikuler', $publishedEkstrakurikulerNames)
            ->get();

        $penghargaan_all = Penghargaan::where('ph_status', 'DRAFT')->get();
        $tatatertib_all = Tatatertib::where('t_status', 'DRAFT')->get();
        $beasiswa_all = Beasiswa::where('status', 'DRAFT')->get();
        $user_all = User::all();

        $menu = 'Beasiswa';

        $status = $request->get('status');
        $keyword = $request->get('keyword') ? $request->get('keyword') : '';
        $category = $request->get('c') ? $request->get('c') : '';

        if ($status) {
            $beasiswas = Beasiswa::where('status', strtoupper($status))
                ->where('title', 'LIKE', "%$keyword%")
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $beasiswas = Beasiswa::where('title', 'LIKE', "%$keyword%")
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }
        $berita_all = Berita::where('b_status', 'DRAFT')->get();

        return view('beasiswas.index', compact(
            'beasiswas',
            'menu',
            'status',
            'keyword',
            'category',
            'pembiasaan_all',
            'kesiswaa_all',
            'ekstrakurikuler_all',
            'penghargaan_all',
            'tatatertib_all',
            'user_all',
            'berita_all',
            'beasiswa_all'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pembiasaan_all = Pembiasaan::where('p_status', 'DRAFT')->get();
        $publishedMenus = Kesiswaan::where('k_status', 'PUBLISH')->pluck('k_nama_menu')->toArray();

        $kesiswaa_all = Kesiswaan::where('k_status', 'DRAFT')
            ->whereNotIn('k_nama_menu', $publishedMenus)
            ->get();

        $publishedEkstrakurikulerNames = Ekstrakurikuler::where('e_status', 'PUBLISH')->pluck('e_nama_ekstrakurikuler')->toArray();

        $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'DRAFT')
            ->whereNotIn('e_nama_ekstrakurikuler', $publishedEkstrakurikulerNames)
            ->get();

        $penghargaan_all = Penghargaan::where('ph_status', 'DRAFT')->get();
        $tatatertib_all = Tatatertib::where('t_status', 'DRAFT')->get();
        $user_all = User::all();
        $beasiswa_all = Beasiswa::where('status', 'DRAFT')->get();

        $menu = 'Beasiswa';
        $berita_all = Berita::where('b_status', 'DRAFT')->get();
        return view('beasiswas.create', compact(
            'menu',
            'pembiasaan_all',
            'kesiswaa_all',
            'ekstrakurikuler_all',
            'penghargaan_all',
            'tatatertib_all',
            'user_all',
            'berita_all',
            'beasiswa_all'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'title' => 'required|min:2|max:200',
            'image' => 'required',
        ])->validate();

        $new_Beasiswa = new \App\Beasiswa;
        $new_Beasiswa->title = $request->get('title');
        $new_Beasiswa->slug = Str::slug($request->get('title'), '-');
        $new_Beasiswa->content = $request->get('content');
        $new_Beasiswa->create_by = Auth::user()->id;
        $new_Beasiswa->status = $request->get('save_action');

        if ($request->file('image')) {
            $nama_file = time() . "_" . $request->file('image')->getClientOriginalName();
            $image_path = $request->file('image')->move('beasiswas_image', $nama_file);
            $new_Beasiswa->image = $nama_file;
        }

        $new_Beasiswa->save();

        return redirect()->route('beasiswas.index')->with('success', 'Beasiswa successfully created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pembiasaan_all = Pembiasaan::where('p_status', 'DRAFT')->get();
        $publishedMenus = Kesiswaan::where('k_status', 'PUBLISH')->pluck('k_nama_menu')->toArray();

        $kesiswaa_all = Kesiswaan::where('k_status', 'DRAFT')
            ->whereNotIn('k_nama_menu', $publishedMenus)
            ->get();

        $publishedEkstrakurikulerNames = Ekstrakurikuler::where('e_status', 'PUBLISH')->pluck('e_nama_ekstrakurikuler')->toArray();

        $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'DRAFT')
            ->whereNotIn('e_nama_ekstrakurikuler', $publishedEkstrakurikulerNames)
            ->get();

        $penghargaan_all = Penghargaan::where('ph_status', 'DRAFT')->get();
        $tatatertib_all = Tatatertib::where('t_status', 'DRAFT')->get();
        $beasiswa_all = Beasiswa::where('status', 'DRAFT')->get();
        $user_all = User::all();

        $menu = 'Beasiswa';

        $beasiswa = Beasiswa::findOrFail($id);
        $berita_all = Berita::where('b_status', 'DRAFT')->get();

        return view('beasiswas.edit', compact(
            'beasiswa',
            'menu',
            'pembiasaan_all',
            'kesiswaa_all',
            'ekstrakurikuler_all',
            'penghargaan_all',
            'tatatertib_all',
            'user_all',
            'berita_all',
            'beasiswa_all'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $beasiswa = Beasiswa::findOrFail($id);

        $beasiswa->title = $request->get('title');
        $beasiswa->slug = Str::slug($request->get('title'), '-');
        $beasiswa->content = $request->get('content');
        $beasiswa->status = $request->get('save_action');
        $beasiswa->update_by = Auth::user()->id;

        if ($request->file('image')) {
            if ($beasiswa->image) {
                File::delete('beasiswas_image/' . $beasiswa->image);
            }
            $nama_file = time() . "_" . $request->file('image')->getClientOriginalName();
            $new_image = $request->file('image')->move('beasiswas_image', $nama_file);
            $beasiswa->image = $nama_file;
        }

        $beasiswa->save();

        return redirect()->route('beasiswas.index')->with('success', 'Beasiswa successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $beasiswa = Beasiswa::findOrFail($id);

        if ($beasiswa->image) {
            File::delete('beasiswas_image/' . $beasiswa->image);
        }

        $beasiswa->forceDelete();

        return redirect()->route('beasiswas.index')->with('success', 'Beasiswa successfully deleted.');
    }
    public function publish(Request $request, $id)
    {
        $beasiswa = Beasiswa::findOrFail($id);
        $status = $request->input('status'); // Get the status from the form input

        if (!in_array($status, ['publish', 'tidak'])) {
            return redirect()->back()->withErrors(['error' => 'Status tidak valid']);
        }

        $beasiswa->status = strtoupper($status); // Set the status based on the form input
        $beasiswa->update_by = auth()->user()->id; // Set update ID based on the logged-in user
        $beasiswa->updated_at = now()->setTimezone('Asia/Jakarta'); // Set update timestamp to the current time in Indonesia
        $beasiswa->save();

        return redirect()->back()->with('success-isi-content', 'Data Isi Content '. $beasiswa->title .' Telah Berhasil Diupdate');
    }
}
