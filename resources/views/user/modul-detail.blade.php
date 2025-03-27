@extends('layouts.user')

@section('header')
    <style>
        .full-img {
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            height: 180px;
        }
        #hero{
            background: url('{{asset('user/images/hero-bg.jpg')}}') top center;
        }
        .image-center{
          display: block;
          margin-left: 6.5px;
          margin-right: 6.5px;
          width: 100%;
        } 
    </style>    
@endsection

@section('hero')
    <h1>Modul kelas {{$moduldetail->m_modul_kelas}}</h1>
    
@endsection

@section('content')
    <!--========================== Article Section ============================-->
    <section id="about" style="user-select: none;">
        <div class="container wow fadeIn">
            <div class="row">
                <div class="col-lg-9 col-md-8 col-sm-12">
                    <div class="article">
                        <h1 id="preview-main-title">{{ $moduldetail->m_nama_modul }} By {{ $moduldetail->guru->g_nama }}</h1>
                        @if (pathinfo($moduldetail->m_foto_atau_pdf, PATHINFO_EXTENSION) === 'pdf')
                            <embed src="{{ asset('modul_image/pdf/' . $moduldetail->m_foto_atau_pdf) }}" type="application/pdf" width="100%" height="600px" />
                            <div class="text-right mt-3">
                                <a href="{{ asset('modul_image/pdf/' . $moduldetail->m_foto_atau_pdf) }}" class="btn btn-primary" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                                        <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z"/>
                                    </svg> Download Modul
                                </a>
                            </div>
                        @elseif (in_array(pathinfo($moduldetail->m_foto_atau_pdf, PATHINFO_EXTENSION), ['jpeg', 'jpg', 'png']))
                            <img src="{{ asset('modul_image/foto/' . $moduldetail->m_foto_atau_pdf) }}" style="width: 100%; height: 400px; object-fit: cover; margin-bottom: 20px;">
                        @else
                            <p>File tidak tersedia atau format tidak didukung.</p>
                        @endif
                        <div>{!! $moduldetail->m_deskripsi_modul !!}</div>
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
