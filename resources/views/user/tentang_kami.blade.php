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

    <section id="about" style="padding: 50px 0;">
        <div class="container wow fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="article">
                        <div class="row" id="activity-cards">
                            @foreach($aboutsejarah as $sejarah)
                                @if($loop->first)
                                    <div class="col-12 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title text-center">Sejarah</h5>
                                                <p class="card-text text-justify">{{ $sejarah->as_sejarah }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            <div class="col-md-6 col-12">
                                <h3 class="text-center">Visi</h3>
                                <div class="mb-4 activity-card" data-page="1" style="transition: transform 0.3s, opacity 0.3s;">
                                    <div class="card" style="transition: transform 0.3s;">
                                        <div class="card-body">
                                            @foreach($about as $activity)
                                                <p class="card-text text-justify">{{ $activity->a_visi }}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <h3 class="text-center">Misi</h3>
                                <div class="mb-4 activity-card" data-page="1" style="transition: transform 0.3s, opacity 0.3s;">
                                    <div class="card" style="transition: transform 0.3s;">
                                        <div class="card-body">
                                            @foreach($about as $activity)
                                                <p class="card-text text-justify">{{ $activity->a_misi }}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
        #about {
            background-color: #f9f9f9;
        }
        .card {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .card-text {
            font-size: 1rem;
            line-height: 1.8;
        }
        @media (max-width: 576px) {
            .card-title {
                font-size: 1.2rem;
            }
            .card-text {
                font-size: 0.9rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.activity-card');
            cards.forEach((card, index) => {
                card.style.opacity = 0;
                card.style.transform = 'translateY(50px)';
                setTimeout(() => {
                    card.style.transition = 'transform 2s, opacity 1s';
                    card.style.opacity = 1;
                    card.style.transform = 'translateY(0)';
                }, index * 200);
            });
        });
    </script>
    <style>
        @media (min-width: 992px) {
            .activity-card {
                margin-bottom: 30px;
            }
        }
        @media (max-width: 576px) {
            .activity-card {
                width: 100% !important;
                height: auto !important;
            }
            .activity-card img {
                height: auto !important;
            }
        }
    </style>
@endsection
