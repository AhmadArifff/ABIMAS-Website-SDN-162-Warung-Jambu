<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\About;
use App\AboutSejarah;
use App\AboutProfile;
use App\Article;
use App\Destination;
use App\Pembiasaan;
use App\Kesiswaan;
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

class UserController extends Controller
{
  public function __construct()
  {
    // $this->middleware('auth');
  }

  public function home()
  {
    $media = MediaSosial::all();
    $tautan = Tautan::all();
    $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'PUBLISH')->get();
    $kesiswaan = Kesiswaan::first(); // Adjust this query as needed
    $berita = Berita::where('b_status', 'PUBLISH')->get(); // Adjust this query as needed
    $categories = Category::all(); // Adjust this query as needed
    $beasiswas = Beasiswa::where('status', 'PUBLISH')->get(); // Adjust this query as needed
    $about = About::where('a_status', 'PUBLISH')->get();
    $aboutsejarah = AboutSejarah::all(); // Adjust this query as needed
    $gurus = Guru::all(); // Adjust this query as needed
    $pembiasaan = Pembiasaan::where('p_status', 'PUBLISH')->get();
    $penghargaan = Penghargaan::where('ph_status', 'PUBLISH')->get();

    $data = [
      'categories' => $categories,
      'about' => AboutProfile::all(),
      'kesiswaan' => $kesiswaan,
      'berita' => $berita,
      'ekstrakurikuler_all' => $ekstrakurikuler_all,
      'menu' => 'Home',
      'media' => $media,
      'tautan' => $tautan,
      'beasiswas' => $beasiswas,
      'aboutsejarah' => $aboutsejarah,
      'gurus' => $gurus,
      'pembiasaan' => $pembiasaan,
      'penghargaan' => $penghargaan
    ];

    return view('user.home', $data);
  }

  public function blog(Request $request)
  {
    $media = MediaSosial::all();
    $tautan = Tautan::all();
    $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'PUBLISH')->get();
    $keyword = $request->get('s') ? $request->get('s') : '';
    $category = $request->get('c') ? $request->get('c') : '';

    $articles = Article::with('categories')
      ->whereHas('categories', function ($q) use ($category) {
        $q->where('name', 'LIKE', "%$category%");
      })
      ->where('status', 'PUBLISH')
      ->where('title', 'LIKE', "%$keyword%")
      ->orderBy('created_at', 'desc')
      ->paginate(10);
    $recents = Article::select('title', 'slug')->where('status', 'PUBLISH')->orderBy('created_at', 'desc')->limit(5)->get();

    $data = [
      'articles' => $articles,
      'recents' => $recents
    ];

    return view('user/blog', $data, ['ekstrakurikuler_all' => $ekstrakurikuler_all, 'media' => $media, 'tautan' => $tautan]);
  }

  public function show_article($slug)
  {
    $media = MediaSosial::all();
    $tautan = Tautan::all();
    $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'PUBLISH')->get();
    $articles = Article::where('slug', $slug)->first();
    $recents = Article::select('title', 'slug')->where('status', 'PUBLISH')->orderBy('created_at', 'desc')->limit(5)->get();
    $data = [
      'articles' => $articles,
      'recents' => $recents
    ];
    return view('user/blog', $data, ['ekstrakurikuler_all' => $ekstrakurikuler_all, 'media' => $media, 'tautan' => $tautan]);
  }

  public function destination(Request $request)
  {
    $media = MediaSosial::all();
    $tautan = Tautan::all();
    $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'PUBLISH')->get();
    $keyword = $request->get('s') ? $request->get('s') : '';

    $destinations = Destination::where('title', 'LIKE', "%$keyword%")->orderBy('created_at', 'desc')->paginate(10);
    $other_destinations = Destination::select('title', 'slug')->where('status', 'PUBLISH')->orderBy('created_at', 'desc')->limit(5)->get();

    $data = [
      'destinations' => $destinations,
      'other' => $other_destinations
    ];

    return view('user/destination', $data, ['ekstrakurikuler_all' => $ekstrakurikuler_all, 'media' => $media, 'tautan' => $tautan]);
  }

  public function show_destination($slug)
  {
    $media = MediaSosial::all();
    $tautan = Tautan::all();
    $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'PUBLISH')->get();
    $destinations = Destination::where('slug', $slug)->firstOrFail();
    $other_destinations = Destination::select('title', 'slug')->where('status', 'PUBLISH')->orderBy('created_at', 'desc')->limit(5)->get();

    $data = [
      'destinations' => $destinations,
      'other' => $other_destinations
    ];

    return view('user/destination', $data, ['ekstrakurikuler_all' => $ekstrakurikuler_all, 'media' => $media, 'tautan' => $tautan]);
  }
  public function contact()
  {
    $media = MediaSosial::all();
    $tautan = Tautan::all();
    $berita = Berita::where('b_status', 'PUBLISH')->get();
    $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'PUBLISH')->get();
    return view('user/contact', ['ekstrakurikuler_all' => $ekstrakurikuler_all, 'media' => $media, 'tautan' => $tautan, 'berita' => $berita]);
  }
  public function berita()
  {
    $media = MediaSosial::all();
    $tautan = Tautan::all();
    $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'PUBLISH')->get();
    $berita = Berita::where('b_status', 'PUBLISH')->get();
    $menu = 'Berita';
    $kesiswaan = Kesiswaan::where('k_nama_menu', $menu)->where('k_status', 'PUBLISH')->first();
    $recentPosts = [
        (object)[
            'link' => '#',
            'image' => 'sample_image/Gambar.png',
            'title' => 'Judul Artikel 1',
            'description' => 'Deskripsi singkat artikel 1.',
            'date' => 'Tanggal 01-01-2024'
        ],
        (object)[
            'link' => '#',
            'image' => 'sample_image/Gambar.png',
            'title' => 'Judul Artikel 2',
            'description' => 'Deskripsi singkat artikel 2.',
            'date' => 'Tanggal 02-02-2024'
        ],
        (object)[
            'link' => '#',
            'image' => 'sample_image/Gambar.png',
            'title' => 'Judul Artikel 3',
            'description' => 'Deskripsi singkat artikel 3.',
            'date' => 'Tanggal 03-03-2024'
        ],
        (object)[
            'link' => '#',
            'image' => 'sample_image/Gambar.png',
            'title' => 'Judul Artikel 4',
            'description' => 'Deskripsi singkat artikel 4.',
            'date' => 'Tanggal 04-04-2024'
        ],
        (object)[
            'link' => '#',
            'image' => 'sample_image/Gambar.png',
            'title' => 'Judul Artikel 5',
            'description' => 'Deskripsi singkat artikel 5.',
            'date' => 'Tanggal 05-05-2024'
        ]
    ];
    return view('user/berita', ['ekstrakurikuler_all' => $ekstrakurikuler_all, 'berita' => $berita, 'kesiswaan' => $kesiswaan, 'recentPosts' => $recentPosts, 'media' => $media, 'tautan' => $tautan]);
  }

  public function tatatertib()
  {
    $media = MediaSosial::all();
    $tautan = Tautan::all();
    $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'PUBLISH')->get();
    $tatatertib = Tatatertib::where('t_status', 'PUBLISH')->get();
    $menu = 'Tatatertib';
    $berita = Berita::where('b_status', 'PUBLISH')->get();
    $kesiswaan = Kesiswaan::where('k_nama_menu', $menu)->where('k_status', 'PUBLISH')->first();
    return view('kesiswaan/tatatertib', ['tatatertib' => $tatatertib, 'kesiswaan' => $kesiswaan, 'ekstrakurikuler_all' => $ekstrakurikuler_all, 'media' => $media, 'tautan' => $tautan, 'berita' => $berita]);
  }

  public function pembiasaan()
  {
    $media = MediaSosial::all();
    $tautan = Tautan::all();
    $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'PUBLISH')->get();
    $pembiasaan = Pembiasaan::where('p_status', 'PUBLISH')->get();
    $menu = 'Pembiasaan';
    $berita = Berita::where('b_status', 'PUBLISH')->get();
    $kesiswaan = Kesiswaan::where('k_nama_menu', $menu)->where('k_status', 'PUBLISH')->first();
    $recentPosts = [
        (object)[
            'link' => '#',
            'image' => 'sample_image/Gambar.png',
            'title' => 'Judul Artikel 1',
            'description' => 'Deskripsi singkat artikel 1.',
            'date' => 'Tanggal 01-01-2024'
        ],
        (object)[
            'link' => '#',
            'image' => 'sample_image/Gambar.png',
            'title' => 'Judul Artikel 2',
            'description' => 'Deskripsi singkat artikel 2.',
            'date' => 'Tanggal 02-02-2024'
        ],
        (object)[
            'link' => '#',
            'image' => 'sample_image/Gambar.png',
            'title' => 'Judul Artikel 3',
            'description' => 'Deskripsi singkat artikel 3.',
            'date' => 'Tanggal 03-03-2024'
        ],
        (object)[
            'link' => '#',
            'image' => 'sample_image/Gambar.png',
            'title' => 'Judul Artikel 4',
            'description' => 'Deskripsi singkat artikel 4.',
            'date' => 'Tanggal 04-04-2024'
        ],
        (object)[
            'link' => '#',
            'image' => 'sample_image/Gambar.png',
            'title' => 'Judul Artikel 5',
            'description' => 'Deskripsi singkat artikel 5.',
            'date' => 'Tanggal 05-05-2024'
        ]
    ];
    return view('kesiswaan/pembiasaan', ['pembiasaan' => $pembiasaan, 'kesiswaan' => $kesiswaan, 'recentPosts' => $recentPosts, 'ekstrakurikuler_all' => $ekstrakurikuler_all, 'media' => $media, 'tautan' => $tautan, 'berita' => $berita]);
  }

  public function penghargaan()
  {
    $media = MediaSosial::all();
    $tautan = Tautan::all();
    $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'PUBLISH')->get();
    $penghargaan = Penghargaan::where('ph_status', 'PUBLISH')->get();
    $menu = 'Penghargaan';
    $berita = Berita::where('b_status', 'PUBLISH')->get();
    $kesiswaan = Kesiswaan::where('k_nama_menu', $menu)->where('k_status', 'PUBLISH')->first();
    return view('kesiswaan/penghargaan', ['penghargaan' => $penghargaan, 'kesiswaan' => $kesiswaan, 'ekstrakurikuler_all' => $ekstrakurikuler_all, 'media' => $media, 'tautan' => $tautan, 'berita' => $berita]);
  }
  public function strukturorganisasi()
  {
    $media = MediaSosial::all();
    $tautan = Tautan::all();
    $berita = Berita::where('b_status', 'PUBLISH')->get();
    $guru = Guru::all();
    $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'PUBLISH')->get();
    $strukturorganisasi = [
      'foto' => 'sample_image/strukturorganisasi.jpg',
      'deskripsi' => 'Struktur organisasi SDN 163 Warung Jambu Kiaracondong terdiri dari berbagai jabatan yang memiliki peran penting dalam menjalankan kegiatan sekolah.',
    ];
    return view('kesiswaan/strukturorganisasi', ['strukturorganisasi' => $strukturorganisasi, 'ekstrakurikuler_all' => $ekstrakurikuler_all, 'media' => $media, 'tautan' => $tautan, 'berita' => $berita, 'guru' => $guru]);
  }

  public function show($nama)
  {
    $media = MediaSosial::all();
    $berita = Berita::where('b_status', 'PUBLISH')->get();
    $tautan = Tautan::all();
    $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'PUBLISH')->get();
    $ekstrakurikuler = Ekstrakurikuler::where('e_nama_ekstrakurikuler', $nama)->firstOrFail();
    $achievements = Penghargaan::where('e_id', $ekstrakurikuler->e_id)
      ->where('ph_status', 'PUBLISH')
      ->get(['ph_foto', 'ph_nama_kegiatan as judul', 'ph_deskripsi', 'ph_create_at as tanggal', 'ph_id as id']);
    return view('kesiswaan/ekstrakurikuler', ['ekstrakurikuler' => $ekstrakurikuler, 'achievements' => $achievements, 'ekstrakurikuler_all' => $ekstrakurikuler_all, 'nama' => $nama, 'media' => $media, 'tautan' => $tautan, 'berita' => $berita]);
  }

  public function pembiasaandetail($id)
  {
    $media = MediaSosial::all();
    $tautan = Tautan::all();
    $berita = Berita::where('b_status', 'PUBLISH')->get();
    $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'PUBLISH')->get();
    $pembiasaandetail = Pembiasaan::where('p_id', $id)->where('p_status', 'PUBLISH')->firstOrFail();
    $menu = 'Pembiasaan';
    $kesiswaan = Kesiswaan::where('k_nama_menu', $menu)->where('k_status', 'PUBLISH')->first();
    return view('kesiswaan/kesiswaan-detail', ['pembiasaandetail' => $pembiasaandetail, 'kesiswaan' => $kesiswaan, 'ekstrakurikuler_all' => $ekstrakurikuler_all, 'media' => $media, 'tautan' => $tautan, 'menu' => $menu, 'berita' => $berita]);
  }
  public function penghargaandetail($id)
  {
    $media = MediaSosial::all();
    $tautan = Tautan::all();
    $berita = Berita::where('b_status', 'PUBLISH')->get();
    $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'PUBLISH')->get();
    $penghargaandetail = Penghargaan::where('ph_id', $id)->where('ph_status', 'PUBLISH')->firstOrFail();
    $menu = 'Penghargaan';
    $kesiswaan = Kesiswaan::where('k_nama_menu', $menu)->where('k_status', 'PUBLISH')->first();
    return view('kesiswaan/kesiswaan-detail', ['penghargaandetail' => $penghargaandetail, 'kesiswaan' => $kesiswaan, 'ekstrakurikuler_all' => $ekstrakurikuler_all, 'media' => $media, 'tautan' => $tautan, 'menu' => $menu, 'berita' => $berita]);
  }
  public function tentang_kami()
  {
    $media = MediaSosial::all();
    $tautan = Tautan::all();
    $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'PUBLISH')->get();
    $about = About::where('a_status', 'PUBLISH')->get();
    $aboutsejarah = AboutSejarah::all();
    $menu = 'About';
    $kesiswaan = Kesiswaan::where('k_nama_menu', $menu)->where('k_status', 'PUBLISH')->first();
    $recentPosts = [
        (object)[
            'link' => '#',
            'image' => 'sample_image/Gambar.png',
            'title' => 'Judul Artikel 1',
            'description' => 'Deskripsi singkat artikel 1.',
            'date' => 'Tanggal 01-01-2024'
        ],
        (object)[
            'link' => '#',
            'image' => 'sample_image/Gambar.png',
            'title' => 'Judul Artikel 2',
            'description' => 'Deskripsi singkat artikel 2.',
            'date' => 'Tanggal 02-02-2024'
        ],
        (object)[
            'link' => '#',
            'image' => 'sample_image/Gambar.png',
            'title' => 'Judul Artikel 3',
            'description' => 'Deskripsi singkat artikel 3.',
            'date' => 'Tanggal 03-03-2024'
        ],
        (object)[
            'link' => '#',
            'image' => 'sample_image/Gambar.png',
            'title' => 'Judul Artikel 4',
            'description' => 'Deskripsi singkat artikel 4.',
            'date' => 'Tanggal 04-04-2024'
        ],
        (object)[
            'link' => '#',
            'image' => 'sample_image/Gambar.png',
            'title' => 'Judul Artikel 5',
            'description' => 'Deskripsi singkat artikel 5.',
            'date' => 'Tanggal 05-05-2024'
        ]
    ];
    return view('user/tentang_kami', ['about' => $about, 'aboutsejarah' => $aboutsejarah, 'kesiswaan' => $kesiswaan, 'recentPosts' => $recentPosts, 'ekstrakurikuler_all' => $ekstrakurikuler_all, 'tautan' => $tautan, 'media' => $media]);
  }
  public function beasiswa(Request $request){
    $keyword    = $request->get('s') ? $request->get('s') : '';

    $beasiswas           = Beasiswa::where('title', 'LIKE', "%$keyword%")->orderBy('created_at', 'desc')->paginate(10);
    $other_beasiswas     = Beasiswa::select('title','slug')->where('status', 'PUBLISH')->orderBy('created_at','desc')->limit(5)->get();

    $data = [
        'beasiswas'  => beasiswa::where('status','PUBLISH')->get(),
        'other'         => $other_beasiswas
    ];
    $media = MediaSosial::all();
    $tautan = Tautan::all();
    $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'PUBLISH')->get();
    return view('user/beasiswa', $data, ['ekstrakurikuler_all' => $ekstrakurikuler_all, 'media' => $media, 'tautan' => $tautan]);
}

public function show_beasiswa($slug){
    $beasiswas       = Beasiswa::where('slug', $slug)->firstOrFail();
    $other_beasiswas = Beasiswa::select('title','slug')->where('status', 'PUBLISH')->orderBy('created_at','desc')->limit(5)->get();

    $data = [
        'beasiswas'  => $beasiswas,
        'other'         => $other_beasiswas
    ];
    $media = MediaSosial::all();
    $tautan = Tautan::all();
    $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'PUBLISH')->get();
    return view('user/beasiswa', $data, ['ekstrakurikuler_all' => $ekstrakurikuler_all, 'media' => $media, 'tautan' => $tautan]);
    
}

public function informasi()
  {
    $data = [

      'beasiswas'     => beasiswa::where('status','PUBLISH')->get(),
      'gurus'         => guru::all(),
      'pendaftarans'  => Pendaftaran::all()

    ];
    $media = MediaSosial::all();
    $tautan = Tautan::all();
    $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'PUBLISH')->get();
    return view('user/informasi', $data, ['ekstrakurikuler_all' => $ekstrakurikuler_all, 'media' => $media, 'tautan' => $tautan]);
  }
  public function beritadetail($id)
  {
    $media = MediaSosial::all();
    $tautan = Tautan::all();
    $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'PUBLISH')->get();
    $beritadetail = Berita::where('b_id', $id)->where('b_status', 'PUBLISH')->firstOrFail();
    $menu = 'Berita';
    $kesiswaan = Kesiswaan::where('k_nama_menu', $menu)->where('k_status', 'PUBLISH')->first();
    return view('berita/berita_detail', ['beritadetail' => $beritadetail, 'kesiswaan' => $kesiswaan, 'ekstrakurikuler_all' => $ekstrakurikuler_all, 'media' => $media, 'tautan' => $tautan, 'menu' => $menu]);
  }
}
