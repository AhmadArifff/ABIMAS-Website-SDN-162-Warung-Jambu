@extends('layouts.admin')

@section('title', 'Edit Guru')

@section('breadcrumbs', 'Guru')

@section('second-breadcrumb')
    <li>Edit</li>
@endsection

@section('css')
    <script src="/templateEditor/ckeditor/ckeditor.js"></script>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('guru.update', $guru->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="col-10">
                            <div class="mb-4">
                                <label for="nama" class="font-weight-bold">Nama</label>
                                <input type="text" name="nama" placeholder="Masukkan nama lengkap" class="form-control {{ $errors->first('nama') ? 'is-invalid' : '' }}" value="{{ old('nama', $guru->nama) }}" required>
                                <div class="invalid-feedback">{{ $errors->first('nama') }}</div>
                            </div>
                            <div class="mb-4">
                                <label for="jabatan" class="font-weight-bold">Jabatan</label>
                                <input type="text" name="jabatan" id="jabatan" class="form-control @error('jabatan') is-invalid @enderror" placeholder="Masukkan jabatan" required value="{{ old('jabatan', $guru->jabatan) }}">
                                <div id="jabatan-warning" class="text-danger" style="display: none;">
                                    Jabatan ini sudah ada, silakan masukkan jabatan yang berbeda.
                                </div>
                                @error('jabatan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="gelar" class="font-weight-bold">Gelar</label>
                                <input type="text" name="gelar" placeholder="Masukkan gelar akademik" class="form-control {{ $errors->first('gelar') ? 'is-invalid' : '' }}" value="{{ old('gelar', $guru->gelar) }}" required>
                                <div class="invalid-feedback">{{ $errors->first('gelar') }}</div>
                            </div>
                            <div class="mb-4">
                                <label for="masa_kerja" class="font-weight-bold">Mulai Menjadi Guru (dalam tahun)</label>
                                <input type="number" name="masa_kerja" placeholder="Masukkan tahun mulai menjadi guru" class="form-control {{ $errors->first('masa_kerja') ? 'is-invalid' : '' }}" value="{{ old('masa_kerja', $guru->masa_kerja) }}" required min="0" oninput="this.value = this.value.slice(0, 4)">
                                <div class="invalid-feedback">{{ $errors->first('masa_kerja') }}</div>
                            </div>
                            <div class="mb-4">
                                <label for="foto" class="font-weight-bold">Foto</label>
                                <br>
                                <img src="{{ asset('guru_image/' . $guru->foto) }}" alt="Foto Guru" width="100" class="mb-3">
                                <input type="file" name="foto" class="form-control {{ $errors->first('foto') ? 'is-invalid' : '' }}" accept="image/*">
                                @if($guru->foto)
                                    <small>Biarkan kosong jika tidak ingin mengubah foto.</small>
                                @endif
                                <div class="invalid-feedback">{{ $errors->first('foto') }}</div>
                            </div>
                            <div class="mb-3 mt-4">
                                <a href="{{ route('guru.index') }}" class="btn btn-md btn-secondary">Back</a>
                                <button type="submit" class="btn btn-md btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const jabatanInput = document.getElementById('jabatan');
            const warningDiv = document.getElementById('jabatan-warning');
            const currentJabatan = "{{ strtolower($guru->jabatan) }}";
            const existingJabatan = @json($gurus->pluck('jabatan')->map(function($jabatan) {
                return strtolower($jabatan);
            })->toArray());

            jabatanInput.addEventListener('input', function () {
                const inputValue = jabatanInput.value.toLowerCase();
                if (existingJabatan.includes(inputValue) && inputValue !== currentJabatan) {
                    warningDiv.style.display = 'block';
                } else {
                    warningDiv.style.display = 'none';
                }
            });
        });
    </script>
@endsection
