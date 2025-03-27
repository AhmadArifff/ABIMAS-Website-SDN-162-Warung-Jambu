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
            <img src="{{ asset('strukturorganisasi_image/slide_image/' . $strukturorganisasi['so_foto_slide']) }}" alt="Struktur Organisasi">
            <h1>{{ $strukturorganisasi['so_judul_slide'] }}</h1>
            <h2>{{ $strukturorganisasi['so_deskripsi_slide'] }}</h2>
        </div>
    </div>
@endsection

@section('content')
    <section id="about">
        <div class="container wow fadeIn">
            <div class="row">
                <div class="col-lg-9">
                    <div class="article">
                        <h1>{{ $strukturorganisasi['so_judul_content'] }}</h1>
                        @if(pathinfo($strukturorganisasi['so_foto_atau_pdf'], PATHINFO_EXTENSION) === 'pdf')
                            <embed src="{{ asset('strukturorganisasi_image/pdf_image/' . $strukturorganisasi['so_foto_atau_pdf']) }}" type="application/pdf" width="100%" height="600px" />
                        @else
                            <img src="{{ asset('strukturorganisasi_image/foto_image/' . $strukturorganisasi['so_foto_atau_pdf']) }}" alt="Struktur Organisasi" style="width: 100%; height: auto; margin-bottom: 20px;">
                        @endif
                        <p>{{ $strukturorganisasi['so_deskripsi'] }}</p>
                        <div class="row">
                            @foreach($guru as $g)
                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-body d-flex align-items-center">
                                            <div style="flex: 1;">
                                                <h5 class="card-title">{{ $g->jabatan }}</h5>
                                                <p class="card-text">{{ $g->nama }}, {{ $g->gelar }}</p>
                                                <p class="card-text"><small class="text-muted">{{ $g->masa_kerja }} - Sekarang</small></p>
                                            </div>
                                            @if($g->foto)
                                                <img src="{{ asset('guru_image/' .$g->foto) }}" alt="{{ $g->nama }}" class="rounded" style="width: 100px; height: 100px; object-fit: cover; margin-left: 10px;">
                                            @endif
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
