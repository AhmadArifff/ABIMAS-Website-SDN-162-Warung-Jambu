@extends('layouts.admin')

@section('title', "Create Slide $menu")

@section('breadcrumbs', "$menu" )

@section('second-breadcrumb')
<li>Create</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{route('admin.berita.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="col-10">
                        <div class="mb-3">
                            <input type="text" name="menu" id="menu" placeholder="Nama Menu..." class="form-control {{$errors->first('menu') ? "is-invalid" : ""}}" value="{{$menu}}" required hidden>
                            <input type="text" name="k_nama_menu" id="k_nama_menu" placeholder="Nama Menu..." class="form-control {{$errors->first('k_nama_menu') ? "is-invalid" : ""}}" value="{{$menu}}" required hidden>
                            <div class="invalid-feedback"> {{$errors->first('k_nama_menu')}}</div>
                        </div>
                        <div class="mb-3">
                            <label for="b_nama_berita" class="font-weight-bold">Nama Berita</label>
                            <input type="text" name="b_nama_berita" id="b_nama_berita" placeholder="Nama Berita..." class="form-control {{$errors->first('b_nama_berita') ? "is-invalid" : ""}}" value="{{old('b_nama_berita')}}" required>
                            <div class="invalid-feedback"> {{$errors->first('b_nama_berita')}}</div>
                        </div>
                        <div class="mb-3">
                            <label for="b_deskripsi_berita" class="font-weight-bold">Deskripsi Berita </label>
                            <textarea name="b_deskripsi_berita" id="b_deskripsi_berita" placeholder="Deskripsi Berita..." class="form-control {{$errors->first('b_deskripsi_berita') ? "is-invalid" : ""}}" required>{{old('b_deskripsi_berita')}}</textarea>
                            <div class="invalid-feedback"> {{$errors->first('b_deskripsi_berita')}}</div>
                        </div>
                        <div class="mb-3">
                            <label for="b_foto_berita" class="font-weight-bold">Foto Berita </label>
                            <input type="file" name="b_foto_berita" id="b_foto_berita" class="form-control {{$errors->first('b_foto_berita') ? "is-invalid" : ""}}" accept="image/*" onchange="updatePreview()">
                            <div class="invalid-feedback"> {{$errors->first('b_foto_berita')}}</div>
                        </div>
                        <div class="mb-3 mt-4">
                            <a href="{{route('admin.'.strtolower($menu) .'.index')}}" class="btn btn-md btn-secondary">Back</a>
                            <button type="submit" name="status" value="draft" class="btn btn-md btn-warning">Draft</button>
                            @if(auth()->user()->role == 'admin')
                            <button type="submit" name="status" value="publish" class="btn btn-md btn-success">Publish</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card mt-4 shadow">
    <div class="card-body">

        <section id="berita">
            <div class="container wow fadeIn">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="article">
                            <h1 id="preview-main-title"></h1>
                            <div class="col-md-12">
                                <div class="row" id="activity-cards">
                                    <div class="col-md-12 mb-4 activity-card" data-page="1" style="transition: transform 0.3s, opacity 0.3s;">
                                        <div class="card d-flex flex-row align-items-center">
                                            <img id="preview-image" src="" class="card-img-top" alt="Preview Image" style="height: 250px; object-fit: cover; width: 40%; image-rendering: optimizeSpeed;">
                                            <div class="card-body">
                                                <h5 class="card-title" id="preview-title"></h5>
                                                <p class="card-text" id="preview-description"></p>
                                                <p class="card-text text-right"><small class="text-muted">{{ \Carbon\Carbon::now()->format('d-m-Y') }}</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <!-- Search Element -->
                        <div class="mb-4">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Cari...">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Calendar Element -->
                        <div class="card mb-4" style="user-select: none;">
                            <div class="card-header">
                                <h5 class="card-title">Kalender</h5>
                            </div>
                            <div class="card-body text-center">
                                <h6>{{ \Carbon\Carbon::now()->format('l') }}</h6> <!-- Day of the week -->
                                <h3>{{ \Carbon\Carbon::now()->format('d') }}</h3> <!-- Day -->
                                <h6>{{ \Carbon\Carbon::now()->format('F Y') }}</h6> <!-- Month and Year -->
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<script>
    function updatePreview() {
        const title = document.getElementById('b_nama_berita').value;
        let description = document.getElementById('b_deskripsi_berita').value;
        if (description.split(' ').length > 500) {
            description = description.split(' ').slice(0, 500).join(' ') + '...';
        }
        document.querySelectorAll('#preview-title').forEach(el => el.innerText = title);
        document.querySelectorAll('#preview-description').forEach(el => el.innerText = description);

        const fileInput = document.getElementById('b_foto_berita');
        if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-image').src = e.target.result;
            }
            reader.readAsDataURL(fileInput.files[0]);
        }
    }
</script>
@endsection