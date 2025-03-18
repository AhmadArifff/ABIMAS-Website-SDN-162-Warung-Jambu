
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">Daftar Guru</h1>
    <div class="row">
        @foreach($gurus as $guru)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                @if($guru->foto)
                    <img src="{{ asset('storage/' . $guru->foto) }}" class="card-img-top" alt="{{ $guru->nama }}">
                @endif
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $guru->nama }}</h5>
                    <p class="card-text">{{ $guru->jabatan }}</p>
                    <p class="card-text"><strong>{{ $guru->gelar }}</strong></p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection