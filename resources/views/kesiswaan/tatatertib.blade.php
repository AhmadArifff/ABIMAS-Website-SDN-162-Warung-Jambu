@extends('layouts.user')

@section('header')
    <style>
        #hero {
            background: #000;
            width: 100%;
            position: relative;
            overflow: hidden;
        }
        .hero-slide {
            position: absolute;
            top: 0;
            left: 100%;
            width: 100%;
            height: 100%;
            transition: left 1s ease-in-out, opacity 1s ease-in-out;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            opacity: 0;
        }
        .hero-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .hero-slide h1 {
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            margin: 0;
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 2rem;
        }
        .hero-slide h2 {
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            margin: 0;
            position: absolute;
            top: 60%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 1.2rem;
        }
        .hero-slide.active {
            left: 0;
            opacity: 1;
        }
        .hero-slide.previous {
            left: -100%;
            opacity: 0;
        }
        .form-control:focus {
            box-shadow: none;
        }
        .form-control::placeholder {
            font-size: 0.95rem;
            color: #aaa;
            font-style: italic;
        }
        .article {
            line-height: 1.6;
            font-size: 15px;
        }
        @media (max-width: 576px) {
            .hero-slide h1 {
                font-size: 1.5rem;
            }
            .hero-slide h2 {
                font-size: 1rem;
            }
        }
    </style>
@endsection

@section('hero')
    <div id="hero">
        <div class="hero-slide active">
            <img src="{{ asset('sample_image/1.jpg') }}" alt="Slide 1">
            <h1>Blog Jogja-Travel</h1>
            <h2>Kumpulan artikel-artikel wisata Jogja, Tips travelling, dan kesehatan</h2>
        </div>
        <div class="hero-slide">
            <img src="{{ asset('sample_image/2.jpg') }}" alt="Slide 2">
            <h1>Explore Jogja</h1>
            <h2>Temukan keindahan alam dan budaya Jogja</h2>
        </div>
        <div class="hero-slide">
            <img src="{{ asset('sample_image/3.jpg') }}" alt="Slide 3">
            <h1>Travel Tips</h1>
            <h2>Tips dan trik untuk perjalanan yang aman dan menyenangkan</h2>
        </div>
    </div>
    <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('.hero-slide');
        setInterval(() => {
            slides[currentSlide].classList.remove('active');
            slides[currentSlide].classList.add('previous');
            currentSlide = (currentSlide + 1) % slides.length;
            slides[currentSlide].classList.add('active');
            slides[currentSlide].classList.remove('previous');
        }, 5000);
    </script>
@endsection

@section('content')
    <!--========================== Article Section ============================-->
    <section id="about" style="user-select: none;">
        <div class="container wow fadeIn">
            <div class="row">
                <div class="col-lg-9 col-md-8 col-sm-12">
                    <div class="article">
                        <h1>Tata Tertib di Sekolah SD 163 Warung Jambu Kiaracondong</h1>
                        <div class="row">
                            <div class="col-lg-4 col-md-5 col-sm-12 mb-3">
                                <div id="list-example" class="list-group">
                                    <a class="list-group-item list-group-item-action" href="#list-item-1">1. Datang Tepat Waktu</a>
                                    <a class="list-group-item list-group-item-action" href="#list-item-2">2. Menghormati Guru dan Teman</a>
                                    <a class="list-group-item list-group-item-action" href="#list-item-3">3. Menjaga Kebersihan</a>
                                    <a class="list-group-item list-group-item-action" href="#list-item-4">4. Mengikuti Pelajaran dengan Baik</a>
                                    <a class="list-group-item list-group-item-action" href="#list-item-5">5. Memakai Seragam Lengkap</a>
                                    <a class="list-group-item list-group-item-action" href="#list-item-6">6. Tidak Membawa Barang Berbahaya</a>
                                    <a class="list-group-item list-group-item-action" href="#list-item-7">7. Tidak Bermain di Kelas</a>
                                    <a class="list-group-item list-group-item-action" href="#list-item-8">8. Mengikuti Upacara Bendera</a>
                                    <a class="list-group-item list-group-item-action" href="#list-item-9">9. Tidak Berkelahi</a>
                                    <a class="list-group-item list-group-item-action" href="#list-item-10">10. Tidak Membawa Gadget</a>
                                    <a class="list-group-item list-group-item-action" href="#list-item-11">11. Menghormati Upacara Keagamaan</a>
                                    <a class="list-group-item list-group-item-action" href="#list-item-12">12. Tidak Meninggalkan Sekolah Tanpa Izin</a>
                                    <a class="list-group-item list-group-item-action" href="#list-item-13">13. Mengikuti Ekstrakurikuler</a>
                                    <a class="list-group-item list-group-item-action" href="#list-item-14">14. Tidak Membawa Makanan dari Luar</a>
                                    <a class="list-group-item list-group-item-action" href="#list-item-15">15. Menjaga Fasilitas Sekolah</a>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-7 col-sm-12">
                                <div data-spy="scroll" data-target="#list-example" data-offset="0" class="scrollspy-example">
                                    <h4 id="list-item-1">1. Datang Tepat Waktu</h4>
                                    <p>Siswa diharapkan datang ke sekolah tepat waktu sebelum bel masuk berbunyi.</p>
                                    <h4 id="list-item-2">2. Menghormati Guru dan Teman</h4>
                                    <p>Siswa harus selalu menghormati guru dan teman-teman di sekolah.</p>
                                    <h4 id="list-item-3">3. Menjaga Kebersihan</h4>
                                    <p>Siswa wajib menjaga kebersihan kelas dan lingkungan sekolah.</p>
                                    <h4 id="list-item-4">4. Mengikuti Pelajaran dengan Baik</h4>
                                    <p>Siswa harus mengikuti pelajaran dengan baik dan tidak mengganggu proses belajar mengajar.</p>
                                    <h4 id="list-item-5">5. Memakai Seragam Lengkap</h4>
                                    <p>Siswa wajib memakai seragam lengkap sesuai dengan ketentuan sekolah.</p>
                                    <h4 id="list-item-6">6. Tidak Membawa Barang Berbahaya</h4>
                                    <p>Siswa dilarang membawa barang-barang berbahaya ke sekolah.</p>
                                    <h4 id="list-item-7">7. Tidak Bermain di Kelas</h4>
                                    <p>Siswa tidak diperbolehkan bermain di dalam kelas selama jam pelajaran.</p>
                                    <h4 id="list-item-8">8. Mengikuti Upacara Bendera</h4>
                                    <p>Siswa wajib mengikuti upacara bendera setiap hari Senin.</p>
                                    <h4 id="list-item-9">9. Tidak Berkelahi</h4>
                                    <p>Siswa dilarang berkelahi dengan teman-teman di sekolah.</p>
                                    <h4 id="list-item-10">10. Tidak Membawa Gadget</h4>
                                    <p>Siswa tidak diperbolehkan membawa gadget ke sekolah kecuali dengan izin guru.</p>
                                    <h4 id="list-item-11">11. Menghormati Upacara Keagamaan</h4>
                                    <p>Siswa harus menghormati upacara keagamaan yang diadakan di sekolah.</p>
                                    <h4 id="list-item-12">12. Tidak Meninggalkan Sekolah Tanpa Izin</h4>
                                    <p>Siswa tidak diperbolehkan meninggalkan sekolah tanpa izin dari guru atau kepala sekolah.</p>
                                    <h4 id="list-item-13">13. Mengikuti Ekstrakurikuler</h4>
                                    <p>Siswa diharapkan mengikuti kegiatan ekstrakurikuler yang disediakan oleh sekolah.</p>
                                    <h4 id="list-item-14">14. Tidak Membawa Makanan dari Luar</h4>
                                    <p>Siswa tidak diperbolehkan membawa makanan dari luar kecuali dengan izin guru.</p>
                                    <h4 id="list-item-15">15. Menjaga Fasilitas Sekolah</h4>
                                    <p>Siswa wajib menjaga dan merawat fasilitas sekolah dengan baik.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <!-- Search Element -->
                    <div class="mb-4">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari...">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Calendar Element -->
                    <div class="card mb-4" style="user-select: none;">
                        <div class="card-header">
                            <h5 class="card-title">Kalender</h5>
                        </div>
                        <div class="card-body text-center">
                            <h6>{{ \Carbon\Carbon::now()->format('l') }}</h6> <!-- Day of the week -->
                            <h3>{{ \Carbon\Carbon::now()->format('d') }}</h3> <!-- Day -->
                            <h6>{{ \Carbon\Carbon::now()->format('F Y') }}</h6> <!-- Month and Year -->
                        </div>
                    </div>
                    <!-- Recent Posts -->
                    <div class="widget">
                        <div class="widget_title">Berita Terbaru</div>
                        <div class="widget_body">
                            <div class="recent-content">
                                @php
                                    $recentPosts = [
                                        (object)[
                                            'link' => '#',
                                            'image' => 'sample_image/Sekolah-SD.jpg',
                                            'title' => 'Judul Artikel 1',
                                            'description' => 'Deskripsi singkat artikel 1.',
                                            'date' => 'Tanggal 01-01-2024'
                                        ],
                                        (object)[
                                            'link' => '#',
                                            'image' => 'sample_image/Sekolah-SD.jpg',
                                            'title' => 'Judul Artikel 2',
                                            'description' => 'Deskripsi singkat artikel 2.',
                                            'date' => 'Tanggal 02-02-2024'
                                        ],
                                        (object)[
                                            'link' => '#',
                                            'image' => 'sample_image/Sekolah-SD.jpg',
                                            'title' => 'Judul Artikel 3',
                                            'description' => 'Deskripsi singkat artikel 3.',
                                            'date' => 'Tanggal 03-03-2024'
                                        ],
                                        (object)[
                                            'link' => '#',
                                            'image' => 'sample_image/Sekolah-SD.jpg',
                                            'title' => 'Judul Artikel 4',
                                            'description' => 'Deskripsi singkat artikel 4.',
                                            'date' => 'Tanggal 04-04-2024'
                                        ],
                                        (object)[
                                            'link' => '#',
                                            'image' => 'sample_image/Sekolah-SD.jpg',
                                            'title' => 'Judul Artikel 5',
                                            'description' => 'Deskripsi singkat artikel 5.',
                                            'date' => 'Tanggal 05-05-2024'
                                        ]
                                    ];
                                @endphp
                                @foreach($recentPosts as $post)
                                    <div class="recent-content-item card mb-3" style="cursor: pointer; transition: transform 0.2s;">
                                        <a href="{{ $post->link }}"><img src="{{ asset($post->image) }}" alt="{{ $post->title }}" class="card-img-top"></a>
                                        <div class="card-body">
                                            <h5 class="card-title"><a href="{{ $post->link }}">{{ $post->title }}</a></h5>
                                            <p class="card-text">{{ $post->description }}</p>
                                            <p class="card-text"><small class="text-muted">{{ $post->date }}</small></p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <script>
                        document.querySelectorAll('.recent-content-item').forEach(item => {
                            item.addEventListener('mouseover', () => {
                                item.style.transform = 'scale(1.05)';
                            });
                            item.addEventListener('mouseout', () => {
                                item.style.transform = 'scale(1)';
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </section>
@endsection
