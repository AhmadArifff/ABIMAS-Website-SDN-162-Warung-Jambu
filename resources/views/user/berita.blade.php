@extends('layouts.user')

@section('header')
<<<<<<< HEAD
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
        <h1>BERITA</h1>
        <h2>Kumpulan Berita-Berita SDN 162 Kiaracondong</h2>
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
<section id="about">
    <div class="container wow fadeIn">
        <div class="row">
            <div class="col-lg-9">
                <div class="article">
                    <h2>Berita di Sekolah SDN 163 Warung Jambu Kiaracondong</h2>
                    <div class="col-md-12">
                        <div class="row" id="activity-cards">
                            @php
                            $activities = [
                            (object)[
                            'image' => 'sample_image/Silat.png',
                            'title' => 'Berita 1',
                            'description' => 'Deskripsi Berita 1.',
                            'date' => '01-01-2024',
                            'detail' => 'Detail Berita 1.'
                            ],
                            (object)[
                            'image' => 'sample_image/Silat.png',
                            'title' => 'Berita 2',
                            'description' => 'Deskripsi Berita 2.',
                            'date' => '02-02-2024',
                            'detail' => 'Detail Berita 2.'
                            ],
                            (object)[
                            'image' => 'sample_image/Silat.png',
                            'title' => 'Berita 3',
                            'description' => 'Deskripsi Berita 3.',
                            'date' => '03-03-2024',
                            'detail' => 'Detail Berita 3.'
                            ],
                            (object)[
                            'image' => 'sample_image/Silat.png',
                            'title' => 'Berita 4',
                            'description' => 'Deskripsi Berita 4.',
                            'date' => '04-04-2024',
                            'detail' => 'Detail Berita 4.'
                            ],
                            (object)[
                            'image' => 'sample_image/Silat.png',
                            'title' => 'Berita 5',
                            'description' => 'Deskripsi Berita 5.',
                            'date' => '05-05-2024',
                            'detail' => 'Detail Berita 5.'
                            ],
                            (object)[
                            'image' => 'sample_image/Silat.png',
                            'title' => 'Berita 6',
                            'description' => 'Deskripsi Berita 6.',
                            'date' => '06-06-2024',
                            'detail' => 'Detail Berita 6.'
                            ],
                            (object)[
                            'image' => 'sample_image/Silat.png',
                            'title' => 'Berita 7',
                            'description' => 'Deskripsi Berita 7.',
                            'date' => '07-07-2024',
                            'detail' => 'Detail Berita 7.'
                            ],
                            (object)[
                            'image' => 'sample_image/Silat.png',
                            'title' => 'Berita 8',
                            'description' => 'Deskripsi Berita 8.',
                            'date' => '08-08-2024',
                            'detail' => 'Detail Berita 8.'
                            ],
                            (object)[
                            'image' => 'sample_image/Silat.png',
                            'title' => 'Berita 9',
                            'description' => 'Deskripsi Berita 9.',
                            'date' => '09-09-2024',
                            'detail' => 'Detail Berita 9.'
                            ],
                            (object)[
                            'image' => 'sample_image/Silat.png',
                            'title' => 'Berita 10',
                            'description' => 'Deskripsi Berita 10.',
                            'date' => '10-10-2024',
                            'detail' => 'Detail Berita 10.'
                            ],
                            (object)[
                            'image' => 'sample_image/Silat.png',
                            'title' => 'Berita 11',
                            'description' => 'Deskripsi Berita 11.',
                            'date' => '11-11-2024',
                            'detail' => 'Detail Berita 11.'
                            ],
                            (object)[
                            'image' => 'sample_image/Silat.png',
                            'title' => 'Berita 12',
                            'description' => 'Deskripsi Berita 12.',
                            'date' => '12-12-2024',
                            'detail' => 'Detail Berita 12.'
                            ]
                            ];
                            @endphp
                            @foreach($activities as $index => $activity)
                            @if($index < 6)
                                <div class="col-md-12 mb-4 activity-card" data-page="1" style="transition: transform 0.3s, opacity 0.3s;">
                                <div class="card d-flex flex-row align-items-center">
                                    <img src="{{ asset($activity->image) }}" class="card-img-top" alt="{{ $activity->title }}" style="height: 250px; object-fit: cover; width: 40%; image-rendering: optimizeSpeed;">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $activity->title }}</h5>
                                        <p class="card-text">{{ $activity->description }}</p>
                                        <p class="card-text text-right"><small class="text-muted">{{ $activity->date }}</small></p>
                                    </div>
                                </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="activityModal{{ $index + 1 }}" tabindex="-1" role="dialog" aria-labelledby="activityModalLabel{{ $index + 1 }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="activityModalLabel{{ $index }}">{{ $activity->title }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <img src="{{ asset($activity->image) }}" class="img-fluid mb-3" alt="{{ $activity->title }}">
                                        <p>{{ $activity->detail }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @elseif($index < 12)
                            <div class="col-md-12 mb-4 activity-card" data-page="2" style="display: none; transition: transform 0.3s, opacity 0.3s;">
                            <div class="card d-flex flex-row align-items-center">
                                <img src="{{ asset($activity->image) }}" class="card-img-top" alt="{{ $activity->title }}" style="height: 250px; object-fit: cover; width: 40%; image-rendering: optimizeSpeed;">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $activity->title }}</h5>
                                    <p class="card-text">{{ $activity->description }}</p>
                                    <p class="card-text text-right"><small class="text-muted">{{ $activity->date }}</small></p>
                                </div>
                            </div>
                    </div>
                    @endif
                    @endforeach
                </div>
                <div class="text-center">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <li class="page-item"><a class="page-link" href="#" data-page="prev">Previous</a></li>
                            <li class="page-item"><a class="page-link" href="#" data-page="1">1</a></li>
                            <li class="page-item"><a class="page-link" href="#" data-page="2">2</a></li>
                            <li class="page-item"><a class="page-link" href="#" data-page="next">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
=======
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
    <section id="about">
        <div class="container wow fadeIn">
            <div class="row">
                <div class="col-lg-9">
                    <div class="article">
                        <h1 id="preview-main-title">{{ $kesiswaan ? $kesiswaan->k_judul_isi_content : 'Data Content Judul Belum Ditambahkan!' }}</h1>
                        <div class="col-md-12">
                            <div class="row" id="activity-cards">
                                @foreach($berita as $index => $activity)
                                    @if($activity->b_status == 'PUBLISH')
                                        @if($index < 6)
                                            <div class="col-md-6 col-lg-6 mb-4 activity-card" data-page="1" style="transition: transform 0.3s, opacity 0.3s;">
                                                <div class="card" style="transition: transform 0.3s;" data-toggle="modal" data-target="#activityModal{{ $index + 1 }}">
                                                    <img src="{{ asset('kesiswaan_image/berita_image/'.$activity->b_foto) }}" class="card-img-top" alt="{{ $activity->b_nama_kegiatan }}" style="height: 150px; object-fit: cover; width: 100%; image-rendering: optimizeSpeed;">
                                                    <div class="card-body">
                                                        <h5 class="card-title">{{ $activity->b_nama_kegiatan }}</h5>
                                                        <p class="card-text">{{ $activity->b_deskripsi }}</p>
                                                        <p class="card-text text-right"><small class="text-muted">{{ \Carbon\Carbon::parse($activity->b_create_at)->format('d-m-Y') }}</small></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal -->
                                            <div class="modal fade" id="activityModal{{ $index + 1 }}" tabindex="-1" role="dialog" aria-labelledby="activityModalLabel{{ $index + 1 }}" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="activityModalLabel{{ $index }}">{{ $activity->b_nama_kegiatan }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="{{ asset('kesiswaan_image/berita_image/'.$activity->b_foto) }}" class="img-fluid mb-3" alt="{{ $activity->b_nama_kegiatan }}">
                                                            <p>{{ $activity->b_deskripsi }}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif($index < 12)
                                            <div class="col-md-6 col-lg-6 mb-4 activity-card" data-page="2" style="display: none; transition: transform 0.3s, opacity 0.3s;">
                                                <div class="card" style="transition: transform 0.3s;" data-toggle="modal" data-target="#activityModal{{ $index + 1 }}">
                                                    <img src="{{ asset('kesiswaan_image/berita_image/'.$activity->b_foto) }}" class="card-img-top" alt="{{ $activity->b_nama_kegiatan }}" style="height: 150px; object-fit: cover; width: 100%; image-rendering: optimizeSpeed;">
                                                    <div class="card-body">
                                                        <h5 class="card-title">{{ $activity->b_nama_kegiatan }}</h5>
                                                        <p class="card-text">{{ $activity->b_deskripsi }}</p>
                                                        <p class="card-text text-right"><small class="text-muted">{{ \Carbon\Carbon::parse($activity->b_create_at)->format('d-m-Y') }}</small></p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                            <div class="text-center">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item"><a class="page-link" href="#" data-page="prev">Previous</a></li>
                                        @for ($i = 1; $i <= ceil($berita->where('b_status', 'PUBLISH')->count() / 6); $i++)
                                            <li class="page-item"><a class="page-link" href="#" data-page="{{ $i }}">{{ $i }}</a></li>
                                        @endfor
                                        <li class="page-item"><a class="page-link" href="#" data-page="next">Next</a></li>
                                    </ul>
                                </nav>
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
>>>>>>> be8b2b83b87cf522a1c98946187e9b334ddac469
    <script>
        document.querySelectorAll('.page-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const currentPage = document.querySelector('.page-link.active') ? parseInt(document.querySelector('.page-link.active').getAttribute('data-page')) : 1;
                let page = this.getAttribute('data-page');
                if (page === 'prev') {
                    page = currentPage > 1 ? currentPage - 1 : 1;
                } else if (page === 'next') {
<<<<<<< HEAD
                    page = currentPage < 2 ? currentPage + 1 : 2;
=======
                    page = currentPage < Math.ceil({{ $berita->count() }} / 6) ? currentPage + 1 : Math.ceil({{ $berita->count() }} / 6);
>>>>>>> be8b2b83b87cf522a1c98946187e9b334ddac469
                } else {
                    page = parseInt(page);
                }
                document.querySelectorAll('.activity-card').forEach(card => {
                    card.style.opacity = 0;
                    setTimeout(() => {
                        card.style.display = card.getAttribute('data-page') == page ? 'block' : 'none';
                        card.style.opacity = 1;
                    }, 300);
                });
                document.querySelectorAll('.page-link').forEach(link => {
                    link.classList.remove('active');
                });
                document.querySelector(`.page-link[data-page="${page}"]`).classList.add('active');
            });
        });

        document.querySelectorAll('.activity-card .card').forEach(card => {
            card.addEventListener('mouseover', () => {
                card.style.transform = 'scale(1.05)';
            });
            card.addEventListener('mouseout', () => {
                card.style.transform = 'scale(1)';
            });
        });
    </script>
    <style>
        @media (min-width: 992px) {
            .activity-card {
                margin-bottom: 30px;
            }
        }
<<<<<<< HEAD

=======
>>>>>>> be8b2b83b87cf522a1c98946187e9b334ddac469
        @media (max-width: 576px) {
            .activity-card {
                width: 100% !important;
                height: auto !important;
            }
<<<<<<< HEAD

=======
>>>>>>> be8b2b83b87cf522a1c98946187e9b334ddac469
            .activity-card img {
                height: auto !important;
            }
        }
    </style>
<<<<<<< HEAD
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
                    'image' => 'sample_image/Silat.png',
                    'title' => 'Berita 1',
                    'description' => 'Deskripsi singkat Berita 1.',
                    'date' => 'Tanggal 01-01-2024'
                    ],
                    (object)[
                    'link' => '#',
                    'image' => 'sample_image/Silat.png',
                    'title' => 'Berita 2',
                    'description' => 'Deskripsi singkat Berita 2.',
                    'date' => 'Tanggal 02-02-2024'
                    ],
                    (object)[
                    'link' => '#',
                    'image' => 'sample_image/Silat.png',
                    'title' => 'Berita 3',
                    'description' => 'Deskripsi singkat Berita 3.',
                    'date' => 'Tanggal 03-03-2024'
                    ],
                    (object)[
                    'link' => '#',
                    'image' => 'sample_image/Silat.png',
                    'title' => 'Berita 4',
                    'description' => 'Deskripsi singkat Berita 4.',
                    'date' => 'Tanggal 04-04-2024'
                    ],
                    (object)[
                    'link' => '#',
                    'image' => 'sample_image/Silat.png',
                    'title' => 'Berita 5',
                    'description' => 'Deskripsi singkat Berita 5.',
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
=======
@endsection
>>>>>>> be8b2b83b87cf522a1c98946187e9b334ddac469
