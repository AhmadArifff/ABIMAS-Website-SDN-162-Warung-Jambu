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
<section id="about" style="user-select: none;">
    <div class="container wow fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="row" id="activity-cards">
                    <div class="col-md-12 mb-4 activity-card" data-page="1" style="transition: transform 0.3s, opacity 0.3s;">
                        <div class="card d-flex flex-row align-items-center" style="transition: transform 0.3s;">
                            <img src="{{ asset('berita_image/'.$beritadetail->b_foto_berita) }}" class="card-img-top" alt="{{ $beritadetail->b_nama_berita }}" style="height: 250px; object-fit: cover; width: 40%; image-rendering: optimizeSpeed;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $beritadetail->b_nama_berita }}</h5>
                                <p class="card-text">{{ $beritadetail->b_deskripsi_berita }}</p>
                                <p class="card-text text-right"><small class="text-muted">{{ \Carbon\Carbon::parse($beritadetail->b_create_at)->format('d-m-Y') }}</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection