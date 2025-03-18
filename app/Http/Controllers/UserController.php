<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\About;
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
    $data = [
      'categories' => Category::all(),
      'about' => AboutProfile::all()
    ];
    return view('user/home', $data, ['ekstrakurikuler_all' => $ekstrakurikuler_all, 'menu' => 'Home', 'media' => $media, 'tautan' => $tautan]);
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
    $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'PUBLISH')->get();
    return view('user/contact', ['ekstrakurikuler_all' => $ekstrakurikuler_all, 'media' => $media, 'tautan' => $tautan]);
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
    $kesiswaan = Kesiswaan::where('k_nama_menu', $menu)->where('k_status', 'PUBLISH')->first();
    return view('kesiswaan/tatatertib', ['tatatertib' => $tatatertib, 'kesiswaan' => $kesiswaan, 'ekstrakurikuler_all' => $ekstrakurikuler_all, 'media' => $media, 'tautan' => $tautan]);
  }

  public function pembiasaan()
  {
    $media = MediaSosial::all();
    $tautan = Tautan::all();
    $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'PUBLISH')->get();
    $pembiasaan = Pembiasaan::where('p_status', 'PUBLISH')->get();
    $menu = 'Pembiasaan';
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
    return view('kesiswaan/pembiasaan', ['pembiasaan' => $pembiasaan, 'kesiswaan' => $kesiswaan, 'recentPosts' => $recentPosts, 'ekstrakurikuler_all' => $ekstrakurikuler_all, 'media' => $media, 'tautan' => $tautan]);
  }

  public function penghargaan()
  {
    $media = MediaSosial::all();
    $tautan = Tautan::all();
    $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'PUBLISH')->get();
    $penghargaan = Penghargaan::where('ph_status', 'PUBLISH')->get();
    $menu = 'Penghargaan';
    $kesiswaan = Kesiswaan::where('k_nama_menu', $menu)->where('k_status', 'PUBLISH')->first();
    return view('kesiswaan/penghargaan', ['penghargaan' => $penghargaan, 'kesiswaan' => $kesiswaan, 'ekstrakurikuler_all' => $ekstrakurikuler_all, 'media' => $media, 'tautan' => $tautan]);
  }
  public function strukturorganisasi()
  {
    $media = MediaSosial::all();
    $tautan = Tautan::all();
    $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'PUBLISH')->get();
    $strukturorganisasi = [
      'foto' => 'sample_image/strukturorganisasi.jpg',
      'deskripsi' => 'Struktur organisasi SDN 163 Warung Jambu Kiaracondong terdiri dari berbagai jabatan yang memiliki peran penting dalam menjalankan kegiatan sekolah.',
      'jabatan' => [
        [
          'nama_jabatan' => 'Kepala Sekolah',
          'nama' => 'Budi Santoso',
          'masa_jabatan' => '2020 - Sekarang'
        ],
        [
          'nama_jabatan' => 'Wakil Kepala Sekolah',
          'nama' => 'Siti Aminah',
          'masa_jabatan' => '2021 - Sekarang'
        ],
        [
          'nama_jabatan' => 'Kepala Tata Usaha',
          'nama' => 'Ahmad Fauzi',
          'masa_jabatan' => '2019 - Sekarang'
        ],
        [
          'nama_jabatan' => 'Guru Kelas 1',
          'nama' => 'Rina Marlina',
          'masa_jabatan' => '2018 - Sekarang'
        ],
        [
          'nama_jabatan' => 'Guru Kelas 2',
          'nama' => 'Dewi Sartika',
          'masa_jabatan' => '2017 - Sekarang'
        ],
        [
          'nama_jabatan' => 'Guru Kelas 3',
          'nama' => 'Hendra Wijaya',
          'masa_jabatan' => '2016 - Sekarang'
        ]
      ]
    ];
    return view('kesiswaan/strukturorganisasi', ['strukturorganisasi' => $strukturorganisasi, 'ekstrakurikuler_all' => $ekstrakurikuler_all, 'media' => $media, 'tautan' => $tautan]);
  }

  public function show($nama)
  {
    $media = MediaSosial::all();
    $tautan = Tautan::all();
    $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'PUBLISH')->get();
    $ekstrakurikuler = Ekstrakurikuler::where('e_nama_ekstrakurikuler', $nama)->firstOrFail();
    $achievements = Penghargaan::where('e_id', $ekstrakurikuler->e_id)
      ->where('ph_status', 'PUBLISH')
      ->get(['ph_foto', 'ph_nama_kegiatan as judul', 'ph_deskripsi', 'ph_create_at as tanggal', 'ph_id as id']);
    return view('kesiswaan/ekstrakurikuler', ['ekstrakurikuler' => $ekstrakurikuler, 'achievements' => $achievements, 'ekstrakurikuler_all' => $ekstrakurikuler_all, 'nama' => $nama, 'media' => $media, 'tautan' => $tautan]);
  }

  public function pembiasaandetail($id)
  {
    $media = MediaSosial::all();
    $tautan = Tautan::all();
    $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'PUBLISH')->get();
    $pembiasaandetail = Pembiasaan::where('p_id', $id)->where('p_status', 'PUBLISH')->firstOrFail();
    $menu = 'Pembiasaan';
    $kesiswaan = Kesiswaan::where('k_nama_menu', $menu)->where('k_status', 'PUBLISH')->first();
    return view('kesiswaan/kesiswaan-detail', ['pembiasaandetail' => $pembiasaandetail, 'kesiswaan' => $kesiswaan, 'ekstrakurikuler_all' => $ekstrakurikuler_all, 'media' => $media, 'tautan' => $tautan, 'menu' => $menu]);
  }
  public function penghargaandetail($id)
  {
    $media = MediaSosial::all();
    $tautan = Tautan::all();
    $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'PUBLISH')->get();
    $penghargaandetail = Penghargaan::where('ph_id', $id)->where('ph_status', 'PUBLISH')->firstOrFail();
    $menu = 'Penghargaan';
    $kesiswaan = Kesiswaan::where('k_nama_menu', $menu)->where('k_status', 'PUBLISH')->first();
    return view('kesiswaan/kesiswaan-detail', ['penghargaandetail' => $penghargaandetail, 'kesiswaan' => $kesiswaan, 'ekstrakurikuler_all' => $ekstrakurikuler_all, 'media' => $media, 'tautan' => $tautan, 'menu' => $menu]);
  }
}
