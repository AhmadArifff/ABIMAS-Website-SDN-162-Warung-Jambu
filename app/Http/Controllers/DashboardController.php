<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;

use App\About;
use App\AboutSejarah;
use App\Pembiasaan;
use App\Kesiswaan;
use App\Modul;
use App\Ekstrakurikuler;
use App\Berita;
use App\Penghargaan;
use App\Tatatertib;
use App\MediaSosial;
use App\Tautan;
use App\User;
use App\Beasiswa;
use App\Guru;
use App\Pendaftaran;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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

        $menu = 'Dashboard';
        $data = [
            'draft'     => Article::where('status', 'DRAFT')->count(),
            'publish'   => Article::where('status', 'PUBLISH')->count()
        ];
        $beasiswa_all = Beasiswa::where('status', 'DRAFT')->get();

        $pembiasaan = Pembiasaan::all();
        $kesiswaan = Kesiswaan::all();
        $ekstrakurikuler = Ekstrakurikuler::all();
        $penghargaan = Penghargaan::all();
        $tatatertib = Tatatertib::all();
        $modul = Modul::all();
        $user = User::all();
        $berita = Berita::all();
        $beasiswa = Beasiswa::all();
        $about = About::all();
        $aboutSejarah = AboutSejarah::all();
        $mediaSosial = MediaSosial::all();
        $tautan = Tautan::all();
        $guru = Guru::all();
        $pendaftaran = Pendaftaran::all();
        return view('dashboards.index', ['data'=>$data, 'menu'=>$menu, 'pembiasaan_all'=>$pembiasaan_all, 'kesiswaa_all'=>$kesiswaa_all, 'ekstrakurikuler_all'=>$ekstrakurikuler_all, 'penghargaan_all'=>$penghargaan_all, 'tatatertib_all'=>$tatatertib_all, 'user_all'=>$user_all, 'berita_all'=>$berita_all, 'beasiswa_all'=>$beasiswa_all, 'pembiasaan'=>$pembiasaan, 'kesiswaan'=>$kesiswaan, 'ekstrakurikuler'=>$ekstrakurikuler, 'penghargaan'=>$penghargaan, 'tatatertib'=>$tatatertib, 'user'=>$user, 'berita'=>$berita, 'beasiswa'=>$beasiswa, 'about'=>$about, 'aboutSejarah'=>$aboutSejarah, 'mediaSosial'=>$mediaSosial, 'tautan'=>$tautan, 'guru'=>$guru, 'pendaftaran'=>$pendaftaran, 'modul'=>$modul]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
