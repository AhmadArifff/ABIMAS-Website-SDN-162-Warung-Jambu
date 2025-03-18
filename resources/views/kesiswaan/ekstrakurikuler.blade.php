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
    @if($ekstrakurikuler)
        @if($ekstrakurikuler->e_foto_slide1)
            <div class="hero-slide active">
                <img id="preview-image1" src="{{ asset('kesiswaan_image/slide_image/'.$ekstrakurikuler->e_foto_slide1) }}" alt="Slide 1">
                <h1 id="preview-title1">{{ $ekstrakurikuler->e_nama_ekstrakurikuler }}</h1>
                <h2 id="preview-description1">{{ $ekstrakurikuler->e_deskripsi_slide }}</h2>
            </div>
        @endif
        @if($ekstrakurikuler->e_foto_slide2)
            <div class="hero-slide">
                <img id="preview-image2" src="{{ asset('kesiswaan_image/slide_image/'.$ekstrakurikuler->e_foto_slide2) }}" alt="Slide 2">
                <h1 id="preview-title2">{{ $ekstrakurikuler->e_nama_ekstrakurikuler }}</h1>
                <h2 id="preview-description2">{{ $ekstrakurikuler->e_deskripsi_slide }}</h2>
            </div>
        @endif
        @if($ekstrakurikuler->e_foto_slide3)
            <div class="hero-slide">
                <img id="preview-image3" src="{{ asset('kesiswaan_image/slide_image/'.$ekstrakurikuler->e_foto_slide3) }}" alt="Slide 3">
                <h1 id="preview-title3">{{ $ekstrakurikuler->e_nama_ekstrakurikuler }}</h1>
                <h2 id="preview-description3">{{ $ekstrakurikuler->e_deskripsi_slide }}</h2>
            </div>
        @endif
    @else
        <div class="hero-slide active">
            <h1 id="preview-title1">Data Content Slide Belum Ditambahkan!</h1>
        </div>
    @endif
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
    <section id="about">
        <div class="container wow fadeIn">
            <div class="row">
                <div class="col-lg-9">
                    <div class="article">
                        <h1 id="preview-main-title">{{ $ekstrakurikuler ? $ekstrakurikuler->e_nama_ekstrakurikuler : 'Data Content Judul Belum Ditambahkan!' }}</h1>
                        <img src="{{ asset('kesiswaan_image/ekstrakurikuler_image/'.$ekstrakurikuler->e_foto) }}" style="width: 100%; height: auto; margin-bottom: 20px;">
                        <p>{{ $ekstrakurikuler->e_deskripsi }}</p>
                        <div class="col-md-12">
                            <div class="row">
                                @foreach($achievements as $achievement)
<<<<<<< HEAD
                                    <div class="col-md-6 col-lg-6 mb-4">
                                        <div class="card">
=======
                                    <div class="col-md-6 col-lg-6 mb-4" style="transition: transform 0.3s, opacity 0.3s;">
                                        <a href="{{ route('penghargaan.detail', ['id' => $achievement->id]) }}" class="card" style="transition: transform 0.3s;" data-toggle="modal" data-target="#achievementModal{{ $loop->index + 1 }}">
>>>>>>> be8b2b83b87cf522a1c98946187e9b334ddac469
                                            <img src="{{ asset('kesiswaan_image/penghargaan_image/'.$achievement->ph_foto) }}" class="card-img-top" alt="{{ $achievement->judul }}" style="height: 150px; object-fit: cover; width: 100%; image-rendering: optimizeSpeed;">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $achievement->judul }}</h5>
                                                <p class="card-text">{{ $achievement->deskripsi }}</p>
                                                <p class="card-text text-right"><small class="text-muted">{{ \Carbon\Carbon::parse($achievement->tanggal)->format('d-m-Y') }}</small></p>
                                            </div>
<<<<<<< HEAD
                                        </div>
                                    </div>
=======
                                        </a>
                                    </div>
                                    <script>
                                        document.querySelectorAll('.col-md-6.col-lg-6.mb-4').forEach(item => {
                                            item.addEventListener('mouseover', () => {
                                                item.style.transform = 'scale(1.05)';
                                            });
                                            item.addEventListener('mouseout', () => {
                                                item.style.transform = 'scale(1)';
                                            });
                                        });
                                    </script>
>>>>>>> be8b2b83b87cf522a1c98946187e9b334ddac469
                                @endforeach
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
