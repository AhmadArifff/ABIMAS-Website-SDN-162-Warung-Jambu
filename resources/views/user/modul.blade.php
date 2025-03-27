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
    <h1>Modul kelas {{$modul->m_modul_kelas}}</h1>
    
@endsection


@section('content')

    <!--========================== Modul Us Section ============================-->
    <section id="about">
        <div class="container wow fadeIn">
            <div class="section-header">
                <h3 class="section-title mb-4">Informasi Modul Kelas {{$modul->m_modul_kelas}} <br>SDN 162 Warung Jambu Kiaracondong<br></h3>
            </div>
            <div class="row">
                <div class="article">
                    <div class="col-md-12">
                        <div class="row" id="activity-cards" style="margin-top: 50px">
                            @foreach($modulbykelas->take(4) as $index => $modul)
                            <div class="col-md-6 col-lg-6 mb-4 activity-card" data-page="1" style="transition: transform 0.3s, opacity 0.3s;">
                                <a href="{{ route('modul.detail', ['id' => $modul->m_id]) }}" class="card zoom-in" style="transition: transform 0.3s;" data-toggle="modal" data-target="#modulModal{{ $index + 1 }}">
                                    @if(strtolower(pathinfo($modul->m_foto_atau_pdf, PATHINFO_EXTENSION)) === 'pdf')
                                        <embed src="{{ asset('modul_image/pdf/'.$modul->m_foto_atau_pdf) }}" type="application/pdf" class="card-img-top" style="height: 250px; width: 100%; object-fit: cover;" />
                                    @else
                                        <img src="{{ asset('modul_image/foto/'.$modul->m_foto_atau_pdf) }}" class="card-img-top" alt="{{ $modul->m_nama_modul }}" style="height: 250px; object-fit: cover; width: 100%; image-rendering: optimizeSpeed;">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $modul->m_nama_modul }} By {{ $gurus->where('id', $modul->m_guru_id)->first()->nama ?? 'Tidak Diketahui' }}</h5>
                                        <p class="card-text">
                                            <strong>Instruksi Modul:</strong><br />
                                            {!! Str::limit($modul->m_deskripsi_modul, 100) !!}
                                        </p>
                                        <p class="card-text text-right"><small class="text-muted">{{ \Carbon\Carbon::parse($modul->m_create_at)->format('d-m-Y') }}</small></p>
                                    </div>
                                </a>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="modulModal{{ $index + 1 }}" tabindex="-1" role="dialog" aria-labelledby="modulModalLabel{{ $index + 1 }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modulModalLabel{{ $index }}">{{ $modul->m_nama_modul }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            @if(strtolower(pathinfo($modul->m_foto_atau_pdf, PATHINFO_EXTENSION)) === 'pdf')
                                                <embed src="{{ asset('modul_image/pdf/'.$modul->m_foto_atau_pdf) }}" type="application/pdf" class="img-fluid mb-3" style="width: 100%; height: 500px;" />
                                            @else
                                                <img src="{{ asset('modul_image/foto/'.$modul->m_foto_atau_pdf) }}" class="img-fluid mb-3" alt="{{ $modul->m_nama_modul }}" style="width: 100%; height: auto;">
                                            @endif
                                            <p><strong>Tujuan Modul:</strong><br />{!! $modul->m_deskripsi_modul !!}</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .zoom-in {
            transition: transform 0.3s ease-in-out;
        }
        .zoom-in:hover {
            transform: scale(1.05);
        }
    </style>
@endsection