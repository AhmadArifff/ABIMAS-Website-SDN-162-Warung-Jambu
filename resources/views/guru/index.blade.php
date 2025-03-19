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
<div class="row mb-3">
    <div class="col-md-6">
        <a href="{{ route('guru.create') }}" class="btn btn-primary">Tambah Guru</a>
    </div>
    <div class="col-md-6">
        <form action="{{ route('guru.index') }}" class="float-right">
            <div class="input-group">
                <input name="p_keyword" type="text" value="{{ Request::get('p_keyword') }}" class="form-control" placeholder="Filter by name or position" oninput="filterGuruTable()">
                <div class="input-group-append">
                    <input type="submit" value="Filter" class="btn btn-info">
                </div>
            </div>
        </form>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="container">
                    <h1>Daftar Guru</h1>
                    <table class="table mt-3" id="guruTable">
                        <thead class="text-light" style="background-color:#33b751 !important">
                            <tr>
                                <th>Foto</th>
                                <th class="filterable">Nama</th>
                                <th class="filterable">Jabatan</th>
                                <th class="filterable">Gelar</th>
                                <th class="filterable">Mulai Menjadi Guru</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($gurus as $guru)
                            <tr>
                                <td>
                                    @if($guru->foto)
                                        <img src="{{ asset('guru_image/' . $guru->foto) }}" width="50" height="50">
                                    @endif
                                </td>
                                <td class="filterable">{{ $guru->nama }}</td>
                                <td class="filterable">{{ $guru->jabatan }}</td>
                                <td class="filterable">{{ $guru->gelar }}</td>
                                <td class="filterable">{{ $guru->masa_kerja }}</td>
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
            </div>
        </div>
    </div>
</div>

<script>
    function filterGuruTable() {
        const input = document.querySelector('input[name="p_keyword"]');
        const filter = input.value.toLowerCase();
        const rows = document.querySelectorAll('#guruTable tbody tr');

        rows.forEach(row => {
            const cells = row.querySelectorAll('.filterable');
            const match = Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(filter));
            row.style.display = match ? '' : 'none';
        });
    }
</script>
</div>
@endsection
