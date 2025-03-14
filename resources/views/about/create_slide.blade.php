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
                    <div class="col-12 mb-3">
                        <h3 align="center"></h3>
                    </div>
                    <form action="{{route('admin.kesiswaan.kesiswaan.store')}}" method="POST" enctype="multipart/form-data">
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
                                <input type="text" name="k_nama_menu" id="k_nama_menu" placeholder="Nama Menu..." class="form-control {{$errors->first('k_nama_menu') ? "is-invalid" : ""}}" value="{{$menu}}" required oninput="updatePreview()" hidden>
                                <div class="invalid-feedback"> {{$errors->first('k_nama_menu')}}</div>
                            </div>
                            <div class="mb-3">
                                <label for="k_judul_slide" class="font-weight-bold">Judul Slide</label>
                                <input type="text" name="k_judul_slide" id="k_judul_slide" placeholder="Judul Slide..." class="form-control {{$errors->first('k_judul_slide') ? "is-invalid" : ""}}" value="{{old('k_judul_slide')}}" required oninput="updatePreview()">
                                <div class="invalid-feedback"> {{$errors->first('k_judul_slide')}}</div>
                            </div>
                            <div class="mb-3">
                                <label for="k_deskripsi_slide" class="font-weight-bold">Deskripsi Slide</label>
                                <textarea name="k_deskripsi_slide" id="k_deskripsi_slide" placeholder="Deskripsi Slide..." class="form-control {{$errors->first('k_deskripsi_slide') ? "is-invalid" : ""}}" required oninput="updatePreview()">{{old('k_deskripsi_slide')}}</textarea>
                                <div class="invalid-feedback"> {{$errors->first('k_deskripsi_slide')}}</div>
                            </div>
                            <div class="mb-3">
                                <label for="k_judul_isi_content" class="font-weight-bold">Judul Isi Content</label>
                                <input type="text" name="k_judul_isi_content" id="k_judul_isi_content" placeholder="Judul Slide..." class="form-control {{$errors->first('k_judul_slide') ? "is-invalid" : ""}}" value="{{old('k_judul_slide')}}" required oninput="updatePreview()">
                                <div class="invalid-feedback"> {{$errors->first('k_judul_isi_content')}}</div>
                            </div>
                            <div class="mb-3">
                                <label for="k_foto_slide1" class="font-weight-bold">Foto Slide 1</label>
                                <input type="file" name="k_foto_slide1" id="k_foto_slide1" class="form-control {{$errors->first('k_foto_slide1') ? "is-invalid" : ""}}" accept="image/*" onchange="updatePreview()">
                                <div class="invalid-feedback"> {{$errors->first('k_foto_slide1')}}</div>
                            </div>
                            <div class="mb-3">
                                <label for="k_foto_slide2" class="font-weight-bold">Foto Slide 2</label>
                                <input type="file" name="k_foto_slide2" id="k_foto_slide2" class="form-control {{$errors->first('k_foto_slide2') ? "is-invalid" : ""}}" accept="image/*" onchange="updatePreview()">
                                <div class="invalid-feedback"> {{$errors->first('k_foto_slide2')}}</div>
                            </div>
                            <div class="mb-3">
                                <label for="k_foto_slide3" class="font-weight-bold">Foto Slide 3</label>
                                <input type="file" name="k_foto_slide3" id="k_foto_slide3" class="form-control {{$errors->first('k_foto_slide3') ? "is-invalid" : ""}}" accept="image/*" onchange="updatePreview()">
                                <div class="invalid-feedback"> {{$errors->first('k_foto_slide3')}}</div>
                            </div>
                            <div class="mb-3 mt-4">
                                <a href="{{route('admin.'.strtolower($menu) .'.index')}}" class="btn btn-md btn-secondary">Back</a>
                                <button type="submit" name="status" value="draft" class="btn btn-md btn-warning">Draft</button>
                                @if(auth()->user()->role == 'admin')
                                    <button type="submit" name="status" value="publish" class="btn btn-md btn-success" {{ $publish==$menu ? 'disabled' : '' }}>Publish</button>
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
            <section id="hero">
                <div class="hero-container">
                    <div id="hero">
                        <div class="hero-slide active">
                            <img id="preview-image1" src="" alt="Slide 1">
                            <h1 id="preview-title"></h1>
                            <h2 id="preview-description"></h2>
                        </div>
                        <div class="hero-slide">
                            <img id="preview-image2" src="" alt="Slide 2">
                            <h1 id="preview-title"></h1>
                            <h2 id="preview-description"></h2>
                        </div>
                        <div class="hero-slide">
                            <img id="preview-image3" src="" alt="Slide 3">
                            <h1 id="preview-title"></h1>
                            <h2 id="preview-description"></h2>
                        </div>
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
            <br/>
            <section id="about">
                <div class="container wow fadeIn">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="article">
                                <h1 id="preview-main-title"></h1>
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
                                                    'image' => 'sample_image/Sekolah-SD.jpg',
                                                    'title' => 'Judul Artikel 1',
                                                    'description' => 'Deskripsi singkat artikel 1.',
                                                    'date' => 'Tanggal 01-01-2024'
                                                ],
                                                (object)[
                                                    'link' => '#',
                                                    'image' => 'sample_image/Sekolah-SD.jpg',
                                                    'title' => 'Judul Artikel 2',
                                                    'description' => 'Deskripsi singkat artikel 2.',
                                                    'date' => 'Tanggal 02-02-2024'
                                                ],
                                                (object)[
                                                    'link' => '#',
                                                    'image' => 'sample_image/Sekolah-SD.jpg',
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
            const title = document.getElementById('k_judul_slide').value;
            const description = document.getElementById('k_deskripsi_slide').value;
            document.getElementById('preview-main-title').innerText = document.getElementById('k_judul_isi_content').value;
            document.querySelectorAll('#preview-title').forEach(el => el.innerText = title);
            document.querySelectorAll('#preview-description').forEach(el => el.innerText = description);

            const fileInput1 = document.getElementById('k_foto_slide1');
            if (fileInput1.files && fileInput1.files[0]) {
                const reader1 = new FileReader();
                reader1.onload = function(e) {
                    document.getElementById('preview-image1').src = e.target.result;
                }
                reader1.readAsDataURL(fileInput1.files[0]);
            }

            const fileInput2 = document.getElementById('k_foto_slide2');
            if (fileInput2.files && fileInput2.files[0]) {
                const reader2 = new FileReader();
                reader2.onload = function(e) {
                    document.getElementById('preview-image2').src = e.target.result;
                }
                reader2.readAsDataURL(fileInput2.files[0]);
            }

            const fileInput3 = document.getElementById('k_foto_slide3');
            if (fileInput3.files && fileInput3.files[0]) {
                const reader3 = new FileReader();
                reader3.onload = function(e) {
                    document.getElementById('preview-image3').src = e.target.result;
                }
                reader3.readAsDataURL(fileInput3.files[0]);
            }
        }
    </script>
@endsection
