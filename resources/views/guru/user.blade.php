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
    <h1>DAFTAR GURU</h1>
    
@endsection
@section('content')
<div class="container">
    <h1 class="text-center mb-4 mt-4">Daftar Guru</h1>
    <div class="row">
        @foreach($gurus as $guru)
        <div class="col-md-6 mb-4">
            <div class="d-flex justify-content-between align-items-center p-4 border rounded shadow-lg bg-white position-relative" style="box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2) !important;">
                <div class="text-center w-100">
                    <h5 class="mb-1 text-primary">{{ $guru->nama }}</h5>
                    <p class="mb-1 text-secondary">{{ $guru->jabatan }}</p>
                    <p class="mb-0 text-dark"><strong>{{ $guru->gelar }}</strong></p>
                </div>
                @if($guru->foto)
                    <img src="{{ asset('guru_image/' . $guru->foto) }}" class="rounded-circle border border-primary p-1" width="70" height="70" alt="{{ $guru->nama }}">
                @endif
            </div>
        </div>
        @endforeach
    </div>
    
</div>
@endsection
