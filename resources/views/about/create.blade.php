@extends('layouts.admin')

@section('title', "Create $menu")

@section('breadcrumbs', "$menu" )

@section('second-breadcrumb')
    <li>Create</li>
@endsection
<<<<<<< HEAD
@if ($menu == 'Pembiasaan' || $menu == 'Penghargaan' || $menu == 'Ekstrakurikuler' || $menu == 'Tatatertib')
=======
>>>>>>> be8b2b83b87cf522a1c98946187e9b334ddac469
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body">
                    <div class="col-12 mb-3">
                        <h3 align="center"></h3>
                    </div>
<<<<<<< HEAD
                    <form action="{{route(strtolower($menu) .'.store')}}" method="POST" enctype="multipart/form-data">
=======
                    <form action="{{route('admin.'.strtolower($menu) .'.store')}}" method="POST" enctype="multipart/form-data">
>>>>>>> be8b2b83b87cf522a1c98946187e9b334ddac469
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @csrf
                        @if ($menu == 'Pembiasaan' || $menu == 'Penghargaan' || $menu == 'Ekstrakurikuler')
                        <div class="col-10">
                        @endif
<<<<<<< HEAD
                            @if ($menu == 'Tatatertib')
=======
>>>>>>> be8b2b83b87cf522a1c98946187e9b334ddac469
                                <div class="d-flex align-items-end mt-2 mb-2 shadow card p-2">
                                    <div class="col-12">
                                        <label for="p_nama_kegiatan" class="col-form-label font-weight-bold">Jumlah Data</label>
                                        <button type="button" id="add-card" class="btn btn-md btn-warning">+</button>
                                    </div>
                                </div>
                                <div class="col-12" id="card-container">
                                    <div class="mb-3 row shadow card p-3">
                                        <div class="col-12" style="border: 1px solid #ddd; padding: 10px;">
                                            <div class="row">
                                                <div class="col-sm-6">
<<<<<<< HEAD
                                                    <label for="p_nama_kegiatan" class="col-form-label font-weight-bold">Nama {{$menu}}</label>
                                                    @if ($menu == 'Pembiasaan' || $menu == 'Penghargaan' || $menu == 'Tatatertib')
                                                    <input type="text" name="k_id" id="k_id" placeholder="k_id..." class="form-control {{$errors->first('k_id') ? "is-invalid" : ""}}" value="{{ $kesiswaan->k_id }}" required oninput="updatePreview()" hidden>
                                                    @endif
                                                    <input type="text" name="nama_kegiatan[]" placeholder="Nama Kegiatan..." class="form-control {{$errors->first('nama_kegiatan') ? "is-invalid" : ""}}" required oninput="updatePreview()">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="p_deskripsi" class="col-form-label font-weight-bold">Deskripsi</label>
                                                    <textarea name="deskripsi[]" placeholder="Deskripsi..." class="form-control {{$errors->first('deskripsi') ? "is-invalid" : ""}}" required oninput="updatePreview()"></textarea>
=======
                                                    <label for="visi" class="col-form-label font-weight-bold">Visi</label>
                                                    <textarea name="visi[]" placeholder="Visi..." class="form-control {{$errors->first('visi') ? "is-invalid" : ""}}" required oninput="updatePreview()"></textarea>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="misi" class="col-form-label font-weight-bold">Misi</label>
                                                    <textarea name="misi[]" placeholder="Misi..." class="form-control {{$errors->first('misi') ? "is-invalid" : ""}}" required oninput="updatePreview()"></textarea>
>>>>>>> be8b2b83b87cf522a1c98946187e9b334ddac469
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    document.getElementById('add-card').addEventListener('click', function() {
                                        const cardContainer = document.getElementById('card-container');
                                        const newCard = document.createElement('div');
                                        newCard.classList.add('mb-3', 'row', 'shadow', 'card', 'p-3');
                                        newCard.innerHTML = `
                                            <div class="col-12" style="border: 1px solid #ddd; padding: 10px;">
                                                <div class="row">
                                                    <div class="col-sm-6">
<<<<<<< HEAD
                                                        <label for="p_nama_kegiatan" class="col-form-label font-weight-bold">Nama Kegiatan</label>
                                                        <input type="text" name="nama_kegiatan[]" placeholder="Nama Kegiatan..." class="form-control {{$errors->first('nama_kegiatan') ? "is-invalid" : ""}}" required oninput="updatePreview()">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="p_deskripsi" class="col-form-label font-weight-bold">Deskripsi</label>
                                                        <textarea name="deskripsi[]" placeholder="Deskripsi..." class="form-control {{$errors->first('deskripsi') ? "is-invalid" : ""}}" required oninput="updatePreview()"></textarea>
=======
                                                        <label for="visi" class="col-form-label font-weight-bold">Visi</label>
                                                        <textarea name="visi[]" placeholder="Visi..." class="form-control {{$errors->first('visi') ? "is-invalid" : ""}}" required oninput="updatePreview()"></textarea>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="misi" class="col-form-label font-weight-bold">Misi</label>
                                                        <textarea name="misi[]" placeholder="Misi..." class="form-control {{$errors->first('misi') ? "is-invalid" : ""}}" required oninput="updatePreview()"></textarea>
>>>>>>> be8b2b83b87cf522a1c98946187e9b334ddac469
                                                    </div>
                                                </div>
                                            </div>
                                        `;
                                        cardContainer.appendChild(newCard);
                                        updateJumlahData();
                                    });

                                    function updateJumlahData() {
                                        const jumlahData = document.querySelectorAll('#card-container .card').length;
                                        document.querySelector('label[for="p_nama_kegiatan"]').innerText = `Jumlah Data: ${jumlahData}`;
                                    }

                                    updateJumlahData();
                                </script>
                                <style>
                                    #add-card {
                                        position: absolute;
                                        right: 10px;
                                    }
                                </style>
<<<<<<< HEAD
                            @endif
                            @if ($menu == 'Pembiasaan' || $menu == 'Penghargaan' || $menu == 'Ekstrakurikuler')
                                @if ($menu == 'Ekstrakurikuler')
                                    <div class="mb-3">
                                        <label for="e_judul_slide" class="font-weight-bold">Judul Slide</label>
                                        <input type="text" name="e_judul_slide" id="e_judul_slide" placeholder="Judul Slide..." class="form-control {{$errors->first('k_judul_slide') ? "is-invalid" : ""}}" value="{{old('k_judul_slide')}}" required oninput="updatePreview()">
                                        <div class="invalid-feedback"> {{$errors->first('e_judul_slide')}}</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="e_deskripsi_slide" class="font-weight-bold">Deskripsi Slide</label>
                                        <textarea name="e_deskripsi_slide" id="e_deskripsi_slide" placeholder="Deskripsi Slide..." class="form-control {{$errors->first('e_deskripsi_slide') ? "is-invalid" : ""}}" required oninput="updatePreview()">{{old('e_deskripsi_slide')}}</textarea>
                                        <div class="invalid-feedback"> {{$errors->first('e_deskripsi_slide')}}</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="e_foto_slide1" class="font-weight-bold">Foto Slide 1</label>
                                        <input type="file" name="e_foto_slide1" id="e_foto_slide1" class="form-control {{$errors->first('e_foto_slide1') ? "is-invalid" : ""}}" accept="image/*" onchange="updatePreview()">
                                        <div class="invalid-feedback"> {{$errors->first('e_foto_slide1')}}</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="e_foto_slide2" class="font-weight-bold">Foto Slide 2</label>
                                        <input type="file" name="e_foto_slide2" id="e_foto_slide2" class="form-control {{$errors->first('e_foto_slide2') ? "is-invalid" : ""}}" accept="image/*" onchange="updatePreview()">
                                        <div class="invalid-feedback"> {{$errors->first('e_foto_slide2')}}</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="e_foto_slide3" class="font-weight-bold">Foto Slide 3</label>
                                        <input type="file" name="e_foto_slide3" id="e_foto_slide3" class="form-control {{$errors->first('e_foto_slide3') ? "is-invalid" : ""}}" accept="image/*" onchange="updatePreview()">
                                        <div class="invalid-feedback"> {{$errors->first('e_foto_slide3')}}</div>
                                    </div>
                                @endif
                                <div class="mb-3">
                                    <label for="p_nama_kegiatan" class="font-weight-bold">Nama 
                                        @if ($menu == 'Pembiasaan')
                                            Kegiatan
                                        @elseif ($menu == 'Penghargaan')
                                            Penghargaan
                                        @elseif ($menu == 'Ekstrakurikuler')
                                            Ekstrakurikuler
                                        @endif
                                    </label>
                                    @if ($menu == 'Pembiasaan' || $menu == 'Penghargaan')
                                    <input type="text" name="k_id" id="k_id" placeholder="k_id..." class="form-control {{$errors->first('k_id') ? "is-invalid" : ""}}" value="{{ $kesiswaan->k_id }}" required oninput="updatePreview()" hidden>
                                    @endif
                                    <input type="text" name="nama_kegiatan" id="nama_kegiatan" placeholder="Nama Kegiatan..." class="form-control {{$errors->first('nama_kegiatan') ? "is-invalid" : ""}}" value="{{old('p_nama_kegiatan')}}" required oninput="updatePreview()">
                                </div>
                                @if ($menu == 'Penghargaan')
                                    <div class="mb-3">
                                        <label for="e_id" class="font-weight-bold">Ekstrakurikuler</label>
                                        <select name="e_id" id="e_id" class="form-control {{$errors->first('e_id') ? "is-invalid" : ""}}" required oninput="updatePreview()">
                                            <option value="">Pilih Ekstrakurikuler</option>
                                            @foreach($ekstrakurikuler as $ekstra)
                                                <option value="{{ $ekstra->e_id }}" {{ old('e_id') == $ekstra->e_id ? 'selected' : '' }}>{{ $ekstra->e_nama_ekstrakurikuler }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                <div class="mb-3">
                                    <label for="p_deskripsi" class="font-weight-bold">Deskripsi</label>
                                    <textarea name="deskripsi" id="deskripsi" placeholder="Deskripsi..." class="form-control {{$errors->first('deskripsi') ? "is-invalid" : ""}}" required oninput="updatePreview()"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="p_foto" class="font-weight-bold">Foto</label>
                                    <input type="file" name="foto" id="foto" class="form-control {{$errors->first('foto') ? "is-invalid" : ""}}" accept="image/*" onchange="updatePreview()">
                                </div>
                            @endif
                            <div class="mb-3 mt-4">
                                <a href="{{route(strtolower($menu) .'.index')}}" class="btn btn-md btn-secondary">Back</a>
                                <button type="submit" name="status" value="draft" class="btn btn-md btn-warning">Draft</button>
                                @if(auth()->user()->role == 'admin')
                                    @if ($menu == 'Ekstrakurikuler')
                                        <button type="submit" name="status" value="publish" class="btn btn-md btn-success" id="publish-button">Publish</button>
                                    @else
                                        <button type="submit" name="status" value="publish" class="btn btn-md btn-success">Publish</button>
                                    @endif
                                @endif
                            </div>
                            <script>
                                const publishedEkstrakurikulerNames = @json($publishedEkstrakurikulerNames);
                                document.getElementById('nama_kegiatan').addEventListener('input', function() {
                                    const publishButton = document.getElementById('publish-button');
                                    if (publishedEkstrakurikulerNames.includes(this.value)) {
                                        publishButton.disabled = true;
                                    } else {
                                        publishButton.disabled = false;
                                    }
                                });
                            </script>
=======
                            <div class="col-12">
                                <div class="mb-3 row shadow card p-3">
                                    <div class="col-12" style="border: 1px solid #ddd; padding: 10px;">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="sejarah" class="font-weight-bold">Sejarah SDN 162 Warung Jambu Kiara Condong</label>
                                                <textarea name="sejarah" id="sejarah" placeholder="Sejarah..." class="form-control {{$errors->first('sejarah') ? "is-invalid" : ""}}" required style="width: 100%;">{{old('sejarah')}}</textarea>
                                                <input type="text" name="k_id" id="k_id" placeholder="k_id..." class="form-control {{$errors->first('k_id') ? "is-invalid" : ""}}" value="{{ $kesiswaan->k_id }}" required oninput="updatePreview()" hidden>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 mt-4">
                                <a href="{{route('admin.'.strtolower($menu) .'.index')}}" class="btn btn-md btn-secondary">Back</a>
                                <button type="submit" name="status" value="draft" class="btn btn-md btn-warning">Draft</button>
                                <button type="submit" name="status" value="publish" class="btn btn-md btn-success">Publish</button>
                            </div>
>>>>>>> be8b2b83b87cf522a1c98946187e9b334ddac469
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<<<<<<< HEAD

    <div class="card mt-4 shadow">
        <div class="card-body">
            <div class="d-flex align-items-end mt-2 mb-2 p-2">
                <div class="col-12">
                    <label for="p_nama_kegiatan" class="col-form-label font-weight-bold">Preview Content:</label>
                </div>
            </div>
            <section id="hero">
                <div class="hero-container">
                    <div id="hero">
                        @if ($menu == 'Pembiasaan' || $menu == 'Penghargaan' || $menu == 'Tatatertib')
                            <div class="hero-slide active">
                                <img id="preview-image1" src="{{ $kesiswaan->k_foto_slide1 ? asset('kesiswaan_image/slide_image/'.$kesiswaan->k_foto_slide1) : '' }}" alt="Slide 1">
                                <h1 id="preview-title1">{{ $kesiswaan->k_nama_menu }}</h1>
                                <h2 id="preview-description1">{{ $kesiswaan->k_deskripsi_slide }}</h2>
                            </div>
                            <div class="hero-slide">
                                <img id="preview-image2" src="{{ $kesiswaan->k_foto_slide2 ? asset('kesiswaan_image/slide_image/'.$kesiswaan->k_foto_slide2) : '' }}" alt="Slide 2">
                                <h1 id="preview-title2">{{ $kesiswaan->k_nama_menu }}</h1>
                                <h2 id="preview-description2">{{ $kesiswaan->k_deskripsi_slide }}</h2>
                            </div>
                            <div class="hero-slide">
                                <img id="preview-image3" src="{{ $kesiswaan->k_foto_slide3 ? asset('kesiswaan_image/slide_image/'.$kesiswaan->k_foto_slide3) : '' }}" alt="Slide 3">
                                <h1 id="preview-title3">{{ $kesiswaan->k_nama_menu }}</h1>
                                <h2 id="preview-description3">{{ $kesiswaan->k_deskripsi_slide }}</h2>
                            </div>
                        @elseif ($menu == 'Ekstrakurikuler')
                            <div class="hero-slide active">
                                <img id="preview-image1" src="" alt="Slide 1">
                                <h1 id="preview-title-slide1"></h1>
                                <h2 id="preview-description-slide1"></h2>
                            </div>
                            <div class="hero-slide">
                                <img id="preview-image2" src="" alt="Slide 2">
                                <h1 id="preview-title-slide2"></h1>
                                <h2 id="preview-description-slide2"></h2>
                            </div>
                            <div class="hero-slide">
                                <img id="preview-image3" src="" alt="Slide 3">
                                <h1 id="preview-title-slide3"></h1>
                                <h2 id="preview-description-slide3"></h2>
                            </div>
                        @endif
                    </div>
                    <script>
                        let currentSlide = 0;
                        const slides = document.querySelectorAll('.hero-slide');
                        setInterval(() => {
                            slides[currentSlide].classList.remove('active');
                            slides[currentSlide].classList.add('previous');
                            currentSlide = (currentSlide + 1) % slides.length;
                            slides[currentSlide].classList.add('active');
                            slides[currentSlide].classList.remove('previous');
                        }, 5000);
                    </script>
                </div>
            </section>
            <br>
            <section id="about">
                <div class="container wow fadeIn">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="article">
                                @if ($menu == 'Pembiasaan' || $menu == 'Penghargaan' || $menu == 'Tatatertib')
                                <h1 id="preview-main-title">{{$kesiswaan->k_judul_isi_content}}</h1>
                                @endif
                                @if ($menu == 'Ekstrakurikuler')
                                <h1 id="preview-title"></h1>
                                @endif
                                @if ($menu == 'Pembiasaan'||$menu == 'Penghargaan')
                                <div class="col-md-12">
                                    <div class="row" id="activity-cards">
                                        <div class="col-md-6 col-lg-6 mb-4 activity-card">
                                            <div class="card shadow">
                                                <img id="preview-image" src="" class="card-img-top" alt="Preview Image" style="height: 150px; object-fit: cover; width: 100%; image-rendering: optimizeSpeed;">
                                                <div class="card-body">
                                                    <h5 class="card-title" id="preview-title"></h5>
                                                    <p class="card-text" id="preview-description"></p>
                                                    <p class="card-text text-right"><small class="text-muted">{{ \Carbon\Carbon::now()->format('d-m-Y') }}</small></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @elseif ($menu == 'Ekstrakurikuler')
                                <img id="preview-image" src="" alt="Preview Image" style="width: 100%; height: auto; margin-bottom: 20px;">
                                <p class="card-text" id="preview-description"></p>
                                <div class="col-md-12">
                                    <div class="row">
                                        @foreach($ekstrakurikuler['achievements'] as $achievement)
                                            <div class="col-md-6 col-lg-6 mb-4">
                                                <div class="card">
                                                    <img src="{{ asset($achievement['foto']) }}" class="card-img-top" alt="{{ $achievement['judul'] }}" style="height: 150px; object-fit: cover; width: 100%; image-rendering: optimizeSpeed;">
                                                    <div class="card-body">
                                                        <h5 class="card-title">{{ $achievement['judul'] }}</h5>
                                                        <p class="card-text">{{ $achievement['deskripsi'] }}</p>
                                                        <p class="card-text text-right"><small class="text-muted">{{ $achievement['tanggal'] }}</small></p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @elseif ($menu == 'Tatatertib')
                                <div class="row">
                                    <div class="col-lg-4 col-md-5 col-sm-12 mb-3">
                                        <div id="list-example" class="list-group">
                                            @foreach(old('nama_kegiatan', []) as $index => $nama_kegiatan)
                                                <a class="list-group-item list-group-item-action" href="#list-item-{{ $index + 1 }}">{{ $index + 1 }}. {{ $nama_kegiatan }}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-lg-8 col-md-7 col-sm-12">
                                        <div data-spy="scroll" data-target="#list-example" data-offset="0" class="scrollspy-example">
                                            @foreach(old('nama_kegiatan', []) as $index => $nama_kegiatan)
                                                <h4 id="list-item-{{ $index + 1 }}">{{ $index + 1 }}. {{ $nama_kegiatan }}</h4>
                                                <p>{{ old('deskripsi', [])[$index] }}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endif
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
                            <!-- Recent Posts -->
                            <div class="widget">
                                <div class="widget_title">Berita Terbaru</div>
                                <div class="widget_body">
                                    <div class="recent-content">
                                        @php
                                            $recentPosts = [
                                                (object)[
                                                    'link' => '#',
                                                    'image' => 'sample_image/Gambar.png',
                                                    'title' => 'Judul Artikel 1',
                                                    'description' => 'Deskripsi singkat artikel 1.',
                                                    'date' => 'Tanggal 01-01-2024'
                                                ],
                                                (object)[
                                                    'link' => '#',
                                                    'image' => 'sample_image/Gambar.png',
                                                    'title' => 'Judul Artikel 2',
                                                    'description' => 'Deskripsi singkat artikel 2.',
                                                    'date' => 'Tanggal 02-02-2024'
                                                ],
                                                (object)[
                                                    'link' => '#',
                                                    'image' => 'sample_image/Gambar.png',
                                                    'title' => 'Judul Artikel 3',
                                                    'description' => 'Deskripsi singkat artikel 3.',
                                                    'date' => 'Tanggal 03-03-2024'
                                                ],
                                            ];
                                        @endphp
                                        @foreach($recentPosts as $post)
                                            <div class="recent-content-item card mb-3" style="cursor: pointer; transition: transform 0.2s;">
                                                <a href="{{ $post->link }}"><img src="{{ asset($post->image) }}" alt="{{ $post->title }}" class="card-img-top"></a>
                                                <div class="card-body">
                                                    <h5 class="card-title"><a href="{{ $post->link }}">{{ $post->title }}</a></h5>
                                                    <p class="card-text">{{ $post->description }}</p>
                                                    <p class="card-text"><small class="text-muted">{{ $post->date }}</small></p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <script>
                                document.querySelectorAll('.recent-content-item').forEach(item => {
                                    item.addEventListener('mouseover', () => {
                                        item.style.transform = 'scale(1.05)';
                                    });
                                    item.addEventListener('mouseout', () => {
                                        item.style.transform = 'scale(1)';
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script>
        function updatePreview() {
            const menu = "{{ $menu }}";
            if (menu === 'Ekstrakurikuler') {
                document.getElementById('preview-description').innerText = document.getElementById('deskripsi').value;
                document.getElementById('preview-title').innerText = document.getElementById('nama_kegiatan').value;
                document.getElementById('preview-title-slide1').innerText = document.getElementById('e_judul_slide').value;
                document.getElementById('preview-description-slide1').innerText = document.getElementById('e_deskripsi_slide').value;
                document.getElementById('preview-title-slide2').innerText = document.getElementById('e_judul_slide').value;
                document.getElementById('preview-description-slide2').innerText = document.getElementById('e_deskripsi_slide').value;
                document.getElementById('preview-title-slide3').innerText = document.getElementById('e_judul_slide').value;
                document.getElementById('preview-description-slide3').innerText = document.getElementById('e_deskripsi_slide').value;

                const fileInput1 = document.getElementById('e_foto_slide1');
                if (fileInput1.files && fileInput1.files[0]) {
                    const reader1 = new FileReader();
                    reader1.onload = function(e) {
                        document.getElementById('preview-image1').src = e.target.result;
                    }
                    reader1.readAsDataURL(fileInput1.files[0]);
                }

                const fileInput2 = document.getElementById('e_foto_slide2');
                if (fileInput2.files && fileInput2.files[0]) {
                    const reader2 = new FileReader();
                    reader2.onload = function(e) {
                        document.getElementById('preview-image2').src = e.target.result;
                    }
                    reader2.readAsDataURL(fileInput2.files[0]);
                }

                const fileInput3 = document.getElementById('e_foto_slide3');
                if (fileInput3.files && fileInput3.files[0]) {
                    const reader3 = new FileReader();
                    reader3.onload = function(e) {
                        document.getElementById('preview-image3').src = e.target.result;
                    }
                    reader3.readAsDataURL(fileInput3.files[0]);
                }
                
                const fileInput = document.getElementById('foto');
                if (fileInput.files && fileInput.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('preview-image').src = e.target.result;
                    }
                    reader.readAsDataURL(fileInput.files[0]);
                }
            } else if (menu === 'Tatatertib') {
                const cards = document.querySelectorAll('#card-container .card');
                const listExample = document.getElementById('list-example');
                const scrollSpyExample = document.querySelector('.scrollspy-example');
                listExample.innerHTML = '';
                scrollSpyExample.innerHTML = '';
                cards.forEach((card, index) => {
                    const namaKegiatan = card.querySelector('input[name="nama_kegiatan[]"]').value;
                    const deskripsi = card.querySelector('textarea[name="deskripsi[]"]').value;
                    listExample.innerHTML += `<a class="list-group-item list-group-item-action" href="#list-item-${index + 1}">${index + 1}. ${namaKegiatan}</a>`;
                    scrollSpyExample.innerHTML += `<h4 id="list-item-${index + 1}">${index + 1}. ${namaKegiatan}</h4><p>${deskripsi}</p>`;
                });
            } else {
                document.getElementById('preview-title').innerText = document.getElementById('nama_kegiatan').value;
                document.getElementById('preview-description').innerText = document.getElementById('deskripsi').value;
                
                const fileInput = document.getElementById('foto');
                if (fileInput.files && fileInput.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('preview-image').src = e.target.result;
                    }
                    reader.readAsDataURL(fileInput.files[0]);
                }
            }
        }
    </script>
@endsection
@endif
=======
@endsection
>>>>>>> be8b2b83b87cf522a1c98946187e9b334ddac469
