@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Edit Guru</h1>
    <form action="{{ route('guru.update', $guru->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ $guru->nama }}" placeholder="Masukkan nama guru" required>
        </div>
        <div class="form-group">
            <label for="jabatan">Jabatan:</label>
            <input type="text" name="jabatan" id="jabatan" class="form-control @error('jabatan') is-invalid @enderror" value="{{ $guru->jabatan }}" placeholder="Masukkan jabatan" required>
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
        <div class="mb-3">
            <label>Gelar</label>
            <input type="text" name="gelar" class="form-control" value="{{ $guru->gelar }}" placeholder="Masukkan gelar guru" required>
        </div>
        <div class="form-group">
            <label for="masa_kerja">Mulai Menjadi Guru (dalam tahun):</label>
            <input type="number" name="masa_kerja" class="form-control" value="{{ $guru->masa_kerja }}" placeholder="Masukkan tahun mulai menjadi guru" required min="0" oninput="this.value = this.value.slice(0, 4)">
        </div>
        <div class="mb-3">
            <label>Foto</label>
            <br>
            <img src="{{ asset('guru_image/' . $guru->foto) }}" alt="Foto Guru" width="100">
            <input type="file" name="foto" class="form-control" accept="image/*">
            @if($guru->foto)
            <small>Biarkan kosong jika tidak ingin mengubah foto.</small>
            @endif
        </div>
        <a href="{{ route('guru.index') }}" class="btn btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection
