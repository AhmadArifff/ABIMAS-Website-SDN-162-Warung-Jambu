<?php

namespace App\Http\Controllers;

use App\Pendaftaran;
use Illuminate\Http\Request;
use App\Ekstrakurikuler;
use App\Tautan;
use App\MediaSosial;
use App\Pembiasaan;
use App\Berita;
use App\Beasiswa;
use App\Kesiswaan;
use App\Penghargaan;
use App\Tatatertib;
use App\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pendaftarans = Pendaftaran::all();
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
        $berita_all = Berita::where('b_status', 'DRAFT')->get();
        $beasiswa_all = Beasiswa::where('status', 'DRAFT')->get();

        $menu = 'pendaftaran';

        return view('pendaftarans.index', compact(
            'pendaftarans',
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pendaftaran  $pendaftaran
     * @return \Illuminate\Http\Response
     */
    public function show(Pendaftaran $pendaftaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftarans = Pendaftaran::all();
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
        $berita_all = Berita::where('b_status', 'DRAFT')->get();
        $beasiswa_all = Beasiswa::where('status', 'DRAFT')->get();

        $menu = 'pendaftaran';

        return view('pendaftarans.edit', compact(
            'pendaftaran',
            'menu',
            'pembiasaan_all',
            'kesiswaa_all',
            'ekstrakurikuler_all',
            'penghargaan_all',
            'tatatertib_all',
            'user_all',
            'berita_all',
            'beasiswa_all',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        Validator::make($request->all(), [
            'caption' => 'required|min:15',
        ])->validate();

        $pendaftaran->caption = $request->get('caption');

        if ($request->file('image')) {
            if ($pendaftaran->image) {
                File::delete('pendaftaran_image/' . $pendaftaran->image);
            }

            $nama_file = time() . "_" . $request->file('image')->getClientOriginalName();
            $new_image = $request->file('image')->move('pendaftaran_image', $nama_file);
            $pendaftaran->image = $nama_file;
        }

        $pendaftaran->save();

        return redirect()->route('pendaftarans.index')->with('success', 'Data successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pendaftaran  $pendaftaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pendaftaran $pendaftaran)
    {
        //
    }
}
