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
        @if($kesiswaan)
            @if($kesiswaan->k_foto_slide1)
                <div class="hero-slide active">
                    <img id="preview-image1" src="{{ asset('kesiswaan_image/slide_image/'.$kesiswaan->k_foto_slide1) }}" alt="Slide 1">
                    <h1 id="preview-title1">{{ $kesiswaan->k_judul_slide }}</h1>
                    <h2 id="preview-description1">{{ $kesiswaan->k_deskripsi_slide }}</h2>
                </div>
            @endif
            @if($kesiswaan->k_foto_slide2)
                <div class="hero-slide">
                    <img id="preview-image2" src="{{ asset('kesiswaan_image/slide_image/'.$kesiswaan->k_foto_slide2) }}" alt="Slide 2">
                    <h1 id="preview-title2">{{ $kesiswaan->k_judul_slide }}</h1>
                    <h2 id="preview-description2">{{ $kesiswaan->k_deskripsi_slide }}</h2>
                </div>
            @endif
            @if($kesiswaan->k_foto_slide3)
                <div class="hero-slide">
                    <img id="preview-image3" src="{{ asset('kesiswaan_image/slide_image/'.$kesiswaan->k_foto_slide3) }}" alt="Slide 3">
                    <h1 id="preview-title3">{{ $kesiswaan->k_judul_slide }}</h1>
                    <h2 id="preview-description3">{{ $kesiswaan->k_deskripsi_slide }}</h2>
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
    <!--========================== Article Section ============================-->
    <section id="about" style="user-select: none;">
        <div class="container wow fadeIn">
            <div class="row">
                <div class="col-lg-9 col-md-8 col-sm-12">
                    <div class="article">
                        <h1 id="preview-main-title">{{ $kesiswaan ? $kesiswaan->k_judul_isi_content : 'Data Content Judul Belum Ditambahkan!' }}</h1>
                        <div class="row">
                            <div class="col-lg-4 col-md-5 col-sm-12 mb-3">
                                <div id="list-example" class="list-group">
                                    @foreach($tatatertib as $item)
                                        <a class="list-group-item list-group-item-action" href="#list-item-{{ $loop->index + 1 }}">{{ $loop->index + 1 }}. {{ $item->t_nama_peraturan }}</a>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-7 col-sm-12">
                                <div data-spy="scroll" data-target="#list-example" data-offset="0" class="scrollspy-example">
                                    @foreach($tatatertib as $item)
                                        <h4 id="list-item-{{ $loop->index + 1 }}">{{ $loop->index + 1 }}. {{ $item->t_nama_peraturan }}</h4>
                                        <p>{{ $item->t_deskripsi }}</p>
                                    @endforeach
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
                                @foreach($berita->take(5) as $post)
                                <a href="{{ route('berita.detail', ['id' => $post->b_id]) }}" class="card mb-3" style="transition: transform 0.3s;" data-toggle="modal" data-target="#activityModal{{ $loop->index + 1 }}">
                                    <img src="{{ asset('berita_image/'.$post->b_foto_berita) }}" class="card-img-top" alt="{{ $post->b_nama_berita }}" style="height: 150px; object-fit: cover; width: 100%; image-rendering: optimizeSpeed;">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $post->b_nama_berita }}</h5>
                                        <p class="card-text">{{ Str::limit($post->b_deskripsi_berita, 100) }}</p>
                                        <p class="card-text text-right"><small class="text-muted">{{ \Carbon\Carbon::parse($post->b_create_at)->format('d-m-Y') }}</small></p>
                                    </div>
                                </a>
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
