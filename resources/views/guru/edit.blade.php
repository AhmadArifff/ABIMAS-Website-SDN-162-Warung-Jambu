@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Guru</h1>
    <form action="{{ route('guru.update', $guru->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ $guru->nama }}" required>
        </div>
        <div class="mb-3">
            <label>Jabatan</label>
            <input type="text" name="jabatan" class="form-control" value="{{ $guru->jabatan }}" required>
        </div>
        <div class="mb-3">
            <label>Gelar</label>
            <input type="text" name="gelar" class="form-control" value="{{ $guru->gelar }}" required>
        </div>
        <div class="mb-3">
            <label>Foto</label>
            <input type="file" name="foto" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection
