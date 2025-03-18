@extends('layouts.admin')
@section('breadcrumbs', 'Overview Articles')
@section('title', 'Guru')
@section('content')
@section('css')
  <style>
    .underline:hover{
      text-decoration: underline;
    }
  </style>
@endsection
<div class="row">
    <div class="col-md-12">
      <div class="card">
      <div class="card-body">
<div class="container">
    <h1>Daftar Guru</h1>
    <a href="{{ route('guru.create') }}" class="btn btn-primary">Tambah Guru</a>
    <table class="table mt-3">
        <thead class="text-light" style="background-color:#33b751 !important">
            <tr>
                <th>Foto</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Gelar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gurus as $guru)
            <tr>
                <td>
                    @if($guru->foto)
                        <img src="{{ asset('storage/' . $guru->foto) }}" width="50" height="50">
                    @endif
                </td>
                <td>{{ $guru->nama }}</td>
                <td>{{ $guru->jabatan }}</td>
                <td>{{ $guru->gelar }}</td>
                <td>
                    <a href="{{ route('guru.edit', $guru->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('guru.destroy', $guru->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus guru ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
