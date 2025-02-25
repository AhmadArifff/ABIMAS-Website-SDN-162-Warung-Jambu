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
            <img src="{{ asset('sample_image/sekolah.jpg') }}" alt="Sekolah">
            <h1>Struktur Organisasi</h1>
            <h2>{{ $strukturorganisasi['deskripsi'] }}</h2>
        </div>
    </div>
@endsection

@section('content')
    <section id="about">
        <div class="container wow fadeIn">
            <div class="row">
                <div class="col-lg-9">
                    <div class="article">
                        <h1>Struktur Organisasi Sekolah SDN 163 Warung Jambu Kiaracondong</h1>
                        <img src="{{ asset($strukturorganisasi['foto']) }}" alt="Struktur Organisasi" style="width: 100%; height: auto; margin-bottom: 20px;">
                        <p>{{ $strukturorganisasi['deskripsi'] }}</p>
                        <div class="row">
                            @foreach($strukturorganisasi['jabatan'] as $jabatan)
                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $jabatan['nama_jabatan'] }}</h5>
                                            <p class="card-text">{{ $jabatan['nama'] }}</p>
                                            <p class="card-text"><small class="text-muted">{{ $jabatan['masa_jabatan'] }}</small></p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
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
