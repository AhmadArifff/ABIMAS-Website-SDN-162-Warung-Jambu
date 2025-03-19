@extends('layouts.admin')
@section('content')
<div class="container">
    <h1>Tambah Guru</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('guru.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="nama">Nama:</label>
            <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap" required>
        </div>

        <div class="form-group">
            <label for="jabatan">Jabatan:</label>
            <input type="text" name="jabatan" id="jabatan" class="form-control @error('jabatan') is-invalid @enderror" placeholder="Masukkan jabatan" required>
            <div id="jabatan-warning" class="text-danger" style="display: none;">
            Jabatan ini sudah ada, silakan masukkan jabatan yang berbeda.
            </div>
            @error('jabatan')
            <div class="invalid-feedback">
            {{ $message }}
            </div>
            @enderror
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
            const jabatanInput = document.getElementById('jabatan');
            const warningDiv = document.getElementById('jabatan-warning');
            const existingJabatan = @json($gurus->pluck('jabatan')->map(function($jabatan) {
                return strtolower($jabatan);
            })->toArray());

            jabatanInput.addEventListener('input', function () {
                const inputValue = jabatanInput.value.toLowerCase();
                if (existingJabatan.includes(inputValue)) {
                warningDiv.style.display = 'block';
                } else {
                warningDiv.style.display = 'none';
                }
            });
            });
        </script>

        <div class="form-group">
            <label for="gelar">Gelar:</label>
            <input type="text" name="gelar" class="form-control" placeholder="Masukkan gelar akademik" required>
        </div>
        
        <div class="form-group">
            <label for="masa_kerja">Mulai Menjadi Guru (dalam tahun):</label>
            <input type="number" name="masa_kerja" class="form-control" placeholder="Masukkan tahun mulai menjadi guru" required min="0" oninput="this.value = this.value.slice(0, 4)">
        </div>

        <div class="form-group">
            <label for="foto">Foto:</label>
            <input type="file" name="foto" class="form-control-file" accept="image/*" required>
        </div>

        <a href="{{ route('guru.index') }}" class="btn btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
