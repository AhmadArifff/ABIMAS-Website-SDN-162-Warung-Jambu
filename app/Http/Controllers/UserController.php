<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\About;
use App\Article;
use App\Destination;
use App\Pembiasaan;
use App\Kesiswaan;
use App\Ekstrakurikuler;
use App\Penghargaan;
use App\Tatatertib;
use App\User;

class UserController extends Controller
{
  public function __construct()
  {
    // $this->middleware('auth');
  }

  public function home()
  {
    $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'PUBLISH')->get();
    $data = [
      'categories' => Category::all(),
      'about' => About::all()
    ];
    return view('user/home', $data, ['ekstrakurikuler_all' => $ekstrakurikuler_all, 'menu' => 'home']);
  }

  public function blog(Request $request)
  {
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

    return view('user/blog', $data, ['ekstrakurikuler_all' => $ekstrakurikuler_all]);
  }

  public function show_article($slug)
  {
    $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'PUBLISH')->get();
    $articles = Article::where('slug', $slug)->first();
    $recents = Article::select('title', 'slug')->where('status', 'PUBLISH')->orderBy('created_at', 'desc')->limit(5)->get();
    $data = [
      'articles' => $articles,
      'recents' => $recents
    ];
    return view('user/blog', $data, ['ekstrakurikuler_all' => $ekstrakurikuler_all]);
  }

  public function destination(Request $request)
  {
    $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'PUBLISH')->get();
    $keyword = $request->get('s') ? $request->get('s') : '';

    $destinations = Destination::where('title', 'LIKE', "%$keyword%")->orderBy('created_at', 'desc')->paginate(10);
    $other_destinations = Destination::select('title', 'slug')->where('status', 'PUBLISH')->orderBy('created_at', 'desc')->limit(5)->get();

    $data = [
      'destinations' => $destinations,
      'other' => $other_destinations
    ];

    return view('user/destination', $data, ['ekstrakurikuler_all' => $ekstrakurikuler_all]);
  }

  public function show_destination($slug)
  {
    $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'PUBLISH')->get();
    $destinations = Destination::where('slug', $slug)->firstOrFail();
    $other_destinations = Destination::select('title', 'slug')->where('status', 'PUBLISH')->orderBy('created_at', 'desc')->limit(5)->get();

    $data = [
      'destinations' => $destinations,
      'other' => $other_destinations
    ];

    return view('user/destination', $data, ['ekstrakurikuler_all' => $ekstrakurikuler_all]);
  }

  public function contact()
  {
    $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'PUBLISH')->get();
    return view('user/contact', ['ekstrakurikuler_all' => $ekstrakurikuler_all]);
  }

  public function tatatertib()
  {
    $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'PUBLISH')->get();
    $tatatertib = Tatatertib::where('t_status', 'PUBLISH')->get();
    $menu = 'Tatatertib';
    $kesiswaan = Kesiswaan::where('k_nama_menu', $menu)->where('k_status', 'PUBLISH')->first();
    return view('kesiswaan/tatatertib', ['tatatertib' => $tatatertib, 'kesiswaan' => $kesiswaan, 'ekstrakurikuler_all' => $ekstrakurikuler_all]);
  }

  public function pembiasaan()
  {
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
    return view('kesiswaan/pembiasaan', ['pembiasaan' => $pembiasaan, 'kesiswaan' => $kesiswaan, 'recentPosts' => $recentPosts, 'ekstrakurikuler_all' => $ekstrakurikuler_all]);
  }

  public function penghargaan()
  {
    $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'PUBLISH')->get();
    $penghargaan = Penghargaan::where('ph_status', 'PUBLISH')->get();
    $menu = 'Penghargaan';
    $kesiswaan = Kesiswaan::where('k_nama_menu', $menu)->where('k_status', 'PUBLISH')->first();
    return view('kesiswaan/penghargaan', ['penghargaan' => $penghargaan, 'kesiswaan' => $kesiswaan, 'ekstrakurikuler_all' => $ekstrakurikuler_all]);
  }
  public function strukturorganisasi()
  {
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
    return view('kesiswaan/strukturorganisasi', ['strukturorganisasi' => $strukturorganisasi, 'ekstrakurikuler_all' => $ekstrakurikuler_all]);
  }

  public function show($nama)
  {
    $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'PUBLISH')->get();
    $ekstrakurikuler = Ekstrakurikuler::where('e_nama_ekstrakurikuler', $nama)->firstOrFail();
    $achievements = Penghargaan::where('e_id', $ekstrakurikuler->e_id)
      ->where('ph_status', 'PUBLISH')
      ->get(['ph_foto', 'ph_nama_kegiatan as judul', 'ph_deskripsi', 'ph_create_at as tanggal']);
    return view('kesiswaan/ekstrakurikuler', ['ekstrakurikuler' => $ekstrakurikuler, 'achievements' => $achievements, 'ekstrakurikuler_all' => $ekstrakurikuler_all, 'nama' => $nama]);
  }

  // public function ekstrakurikuler_pramuka()
  // {
  //   $ekstrakurikuler = [
  //     'name' => 'Pramuka',
  //     'description' => 'Pramuka adalah kegiatan ekstrakurikuler yang bertujuan untuk melatih keterampilan, kedisiplinan, dan kemandirian siswa.',
  //     'foto_kegiatan' => 'sample_image/Pramuka.jpg',
  //     'achievements' => [
  //       [
  //         'foto' => 'sample_image/Pramuka_achievement.jpg',
  //         'judul' => 'Lomba Pramuka Nasional',
  //         'deskripsi' => 'Juara 1 Lomba Pramuka Nasional',
  //         'tanggal' => '2023-08-15'
  //       ],
  //       [
  //         'foto' => 'sample_image/Pramuka_achievement.jpg',
  //         'judul' => 'Lomba Pramuka Regional',
  //         'deskripsi' => 'Juara 2 Lomba Pramuka Regional',
  //         'tanggal' => '2023-07-10'
  //       ]
  //     ]
  //   ];
  //   return view('kesiswaan/ekstrakurikuler', ['ekstrakurikuler' => $ekstrakurikuler]);
  // }

  // public function ekstrakurikuler_kesenian()
  // {
  //   $ekstrakurikuler = [
  //     'name' => 'Kesenian',
  //     'description' => 'Kesenian adalah kegiatan ekstrakurikuler yang bertujuan untuk mengembangkan bakat dan minat siswa dalam bidang seni.',
  //     'foto_kegiatan' => 'sample_image/Kesenian.jpg',
  //     'achievements' => [
  //       [
  //         'foto' => 'sample_image/Kesenian_achievement.jpg',
  //         'judul' => 'Festival Seni Sekolah',
  //         'deskripsi' => 'Juara 2 Festival Seni Sekolah',
  //         'tanggal' => '2023-07-20'
  //       ],
  //       [
  //         'foto' => 'sample_image/Kesenian_achievement.jpg',
  //         'judul' => 'Lomba Seni Daerah',
  //         'deskripsi' => 'Juara 1 Lomba Seni Daerah',
  //         'tanggal' => '2023-06-15'
  //       ]
  //     ]
  //   ];
  //   return view('kesiswaan/ekstrakurikuler', ['ekstrakurikuler' => $ekstrakurikuler]);
  // }

  // public function ekstrakurikuler_karate()
  // {
  //   $ekstrakurikuler = [
  //     'name' => 'Karate',
  //     'description' => 'Karate adalah kegiatan ekstrakurikuler yang bertujuan untuk melatih keterampilan bela diri dan kedisiplinan siswa.',
  //     'foto_kegiatan' => 'sample_image/Karate.jpg',
  //     'achievements' => [
  //       [
  //         'foto' => 'sample_image/Karate_achievement.jpg',
  //         'judul' => 'Kejuaraan Karate Antar Sekolah',
  //         'deskripsi' => 'Juara 3 Kejuaraan Karate Antar Sekolah',
  //         'tanggal' => '2023-06-10'
  //       ],
  //       [
  //         'foto' => 'sample_image/Karate_achievement.jpg',
  //         'judul' => 'Kejuaraan Karate Nasional',
  //         'deskripsi' => 'Juara 2 Kejuaraan Karate Nasional',
  //         'tanggal' => '2023-05-05'
  //       ]
  //     ]
  //   ];
  //   return view('kesiswaan/ekstrakurikuler', ['ekstrakurikuler' => $ekstrakurikuler]);
  // }

  // public function ekstrakurikuler_silat()
  // {
  //   $ekstrakurikuler = [
  //     'name' => 'Silat',
  //     'description' => 'Silat adalah kegiatan ekstrakurikuler yang bertujuan untuk melatih keterampilan bela diri dan kedisiplinan siswa.',
  //     'foto_kegiatan' => 'sample_image/Silat.jpg',
  //     'achievements' => [
  //       [
  //         'foto' => 'sample_image/Silat_achievement.jpg',
  //         'judul' => 'Turnamen Silat Pelajar',
  //         'deskripsi' => 'Juara 1 Turnamen Silat Pelajar',
  //         'tanggal' => '2023-05-05'
  //       ],
  //       [
  //         'foto' => 'sample_image/Silat_achievement.jpg',
  //         'judul' => 'Kejuaraan Silat Nasional',
  //         'deskripsi' => 'Juara 2 Kejuaraan Silat Nasional',
  //         'tanggal' => '2023-04-10'
  //       ]
  //     ]
  //   ];
  //   return view('kesiswaan/ekstrakurikuler', ['ekstrakurikuler' => $ekstrakurikuler]);
  // }

  // public function ekstrakurikuler_olimpiade()
  // {
  //   $ekstrakurikuler = [
  //     'name' => 'Olimpiade',
  //     'description' => 'Olimpiade adalah kegiatan ekstrakurikuler yang bertujuan untuk mengembangkan kemampuan akademik siswa melalui berbagai kompetisi.',
  //     'foto_kegiatan' => 'sample_image/Olimpiade.jpg',
  //     'achievements' => [
  //       [
  //         'foto' => 'sample_image/Olimpiade_achievement.jpg',
  //         'judul' => 'Olimpiade Sains Nasional',
  //         'deskripsi' => 'Juara Harapan 1 Olimpiade Sains Nasional',
  //         'tanggal' => '2023-04-15'
  //       ],
  //       [
  //         'foto' => 'sample_image/Olimpiade_achievement.jpg',
  //         'judul' => 'Olimpiade Matematika',
  //         'deskripsi' => 'Juara 1 Olimpiade Matematika',
  //         'tanggal' => '2023-03-20'
  //       ]
  //     ]
  //   ];
  //   return view('kesiswaan/ekstrakurikuler', ['ekstrakurikuler' => $ekstrakurikuler]);
  // }

  // public function ekstrakurikuler_paskibra()
  // {
  //   $ekstrakurikuler = [
  //     'name' => 'Paskibra',
  //     'description' => 'Paskibra adalah kegiatan ekstrakurikuler yang bertujuan untuk melatih kedisiplinan dan keterampilan baris-berbaris siswa.',
  //     'foto_kegiatan' => 'sample_image/Paskibra.jpg',
  //     'achievements' => [
  //       [
  //         'foto' => 'sample_image/Paskibra_achievement.jpg',
  //         'judul' => 'Lomba Paskibra Tingkat Kota',
  //         'deskripsi' => 'Juara 2 Lomba Paskibra Tingkat Kota',
  //         'tanggal' => '2023-03-10'
  //       ],
  //       [
  //         'foto' => 'sample_image/Paskibra_achievement.jpg',
  //         'judul' => 'Lomba Paskibra Tingkat Provinsi',
  //         'deskripsi' => 'Juara 1 Lomba Paskibra Tingkat Provinsi',
  //         'tanggal' => '2023-02-15'
  //       ]
  //     ]
  //   ];
  //   return view('kesiswaan/ekstrakurikuler', ['ekstrakurikuler' => $ekstrakurikuler]);
  // }

  // public function ekstrakurikuler_hoki()
  // {
  //   $ekstrakurikuler = [
  //     'name' => 'Hoki',
  //     'description' => 'Hoki adalah kegiatan ekstrakurikuler yang bertujuan untuk mengembangkan keterampilan olahraga hoki siswa.',
  //     'foto_kegiatan' => 'sample_image/Hoki.jpg',
  //     'achievements' => [
  //       [
  //         'foto' => 'sample_image/Hoki_achievement.jpg',
  //         'judul' => 'Kejuaraan Hoki Antar Sekolah',
  //         'deskripsi' => 'Juara 1 Kejuaraan Hoki Antar Sekolah',
  //         'tanggal' => '2023-02-20'
  //       ],
  //       [
  //         'foto' => 'sample_image/Hoki_achievement.jpg',
  //         'judul' => 'Turnamen Hoki Regional',
  //         'deskripsi' => 'Juara 2 Turnamen Hoki Regional',
  //         'tanggal' => '2023-01-15'
  //       ]
  //     ]
  //   ];
  //   return view('kesiswaan/ekstrakurikuler', ['ekstrakurikuler' => $ekstrakurikuler]);
  // }

  // public function ekstrakurikuler_pmr()
  // {
  //   $ekstrakurikuler = [
  //     'name' => 'PMR',
  //     'description' => 'PMR adalah kegiatan ekstrakurikuler yang bertujuan untuk melatih keterampilan pertolongan pertama dan kesehatan siswa.',
  //     'foto_kegiatan' => 'sample_image/PMR.jpg',
  //     'achievements' => [
  //       [
  //         'foto' => 'sample_image/PMR_achievement.jpg',
  //         'judul' => 'Lomba PMR Tingkat Provinsi',
  //         'deskripsi' => 'Juara 3 Lomba PMR Tingkat Provinsi',
  //         'tanggal' => '2023-01-15'
  //       ],
  //       [
  //         'foto' => 'sample_image/PMR_achievement.jpg',
  //         'judul' => 'Lomba PMR Tingkat Nasional',
  //         'deskripsi' => 'Juara 2 Lomba PMR Tingkat Nasional',
  //         'tanggal' => '2022-12-10'
  //       ]
  //     ]
  //   ];
  //   return view('kesiswaan/ekstrakurikuler', ['ekstrakurikuler' => $ekstrakurikuler]);
  // }

  // public function ekstrakurikuler_renang()
  // {
  //   $ekstrakurikuler = [
  //     'name' => 'Renang',
  //     'description' => 'Renang adalah kegiatan ekstrakurikuler yang bertujuan untuk mengembangkan keterampilan berenang dan kesehatan siswa.',
  //     'foto_kegiatan' => 'sample_image/Renang.jpg',
  //     'achievements' => [
  //       [
  //         'foto' => 'sample_image/Renang_achievement.jpg',
  //         'judul' => 'Kejuaraan Renang Antar Sekolah',
  //         'deskripsi' => 'Juara 1 Kejuaraan Renang Antar Sekolah',
  //         'tanggal' => '2022-12-10'
  //       ],
  //       [
  //         'foto' => 'sample_image/Renang_achievement.jpg',
  //         'judul' => 'Lomba Renang Regional',
  //         'deskripsi' => 'Juara 2 Lomba Renang Regional',
  //         'tanggal' => '2022-11-05'
  //       ]
  //     ]
  //   ];
  //   return view('kesiswaan/ekstrakurikuler', ['ekstrakurikuler' => $ekstrakurikuler]);
  // }
}
