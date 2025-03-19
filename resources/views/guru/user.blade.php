@extends('layouts.user')

@section('header')
    <style>
        #hero{
            background: url('{{asset('user/images/destination.png')}}') top center;
            background-repeat: no-repeat;
            width:100%;
            background-size:cover;
            margin:5px;
        }
        .full-img {
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            height: 180px;
        }
        .content{
          line-height: 1.6;
          font-size: 15px;
        } 
    </style>    
@endsection

@section('hero')
    <h1>Destinasi Jogja-Travel</h1>
    <h2>Cek semua destinasi-destinasi yang dapat anda kunjungi untuk liburan anda</h2>
@endsection
@section('content')
<div class="container">
    <h1 class="text-center mb-4">Daftar Guru</h1>
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
                    <img src="{{ asset('storage/' . $guru->foto) }}" class="rounded-circle border border-primary p-1" width="70" height="70" alt="{{ $guru->nama }}">
                @endif
            </div>
        </div>
        @endforeach
    </div>
    
</div>
@endsection
