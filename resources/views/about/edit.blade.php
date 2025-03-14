@extends('layouts.admin')

@section('title', "Edit $menu")

@section('breadcrumbs', "$menu" )

@section('second-breadcrumb')
	<li>Edit</li>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12">
			@if ($errors->any())
				<div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-alert">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<script>
					setTimeout(function() {
						document.getElementById('error-alert').style.display = 'none';
					}, 10000);
				</script>
			@endif
			<div class="card">
				<div class="card-body">
					<div class="col-12 mb-3">
						<h3 align="center"></h3>
					</div>
					@if ($menu == 'Pembiasaan')
					<form action="{{route(strtolower($menu) .'.update', $pembiasaan->p_id)}}" method="POST" enctype="multipart/form-data">
						@csrf
						<input type="hidden" name="_method" value="PUT">
						<div class="col-10">
							<div class="mb-3">
								<label for="p_nama_kegiatan" class="font-weight-bold">Nama Kegiatan</label>
								<input type="text" name="k_id" id="k_id" placeholder="k_id..." class="form-control {{$errors->first('p_nama_kegiatan') ? "is-invalid" : ""}}" value="{{ $kesiswaan->k_id }}" required oninput="updatePreview()" hidden>
								<input type="text" name="nama_kegiatan" id="nama_kegiatan" placeholder="Nama Kegiatan..." class="form-control {{$errors->first('p_nama_kegiatan') ? "is-invalid" : ""}}" value="{{$pembiasaan->p_nama_kegiatan}}" required oninput="updatePreview()">
							</div>
							<div class="mb-3">
								<label for="p_deskripsi" class="font-weight-bold">Deskripsi</label>
								<textarea name="deskripsi" id="deskripsi" placeholder="Deskripsi..." class="form-control {{$errors->first('p_deskripsi') ? "is-invalid" : ""}}" required oninput="updatePreview()">{{$pembiasaan->p_deskripsi}}</textarea>
							</div>
							<div class="mb-3">
								<label for="p_foto" class="font-weight-bold">Foto</label>
								@if($pembiasaan->p_foto)
									<div class="mb-2">
										<img src="{{ asset('kesiswaan_image/'. strtolower($menu) .'_image/'.$pembiasaan->p_foto) }}" width="150px" alt="Foto Pembiasaan">
									</div>
								@endif
								<input type="file" name="foto" id="foto" class="form-control {{$errors->first('p_foto') ? "is-invalid" : ""}}" accept="image/*" onchange="updatePreview()">
								<small class="text-muted">Kosongkan jika tidak ingin mengubah foto</small>
							</div>
							<div class="mb-3 mt-4">
								<a href="{{route(strtolower($menu) .'.index')}}" class="btn btn-md btn-secondary">Back</a>
								<button type="submit" name="status" value="draft" class="btn btn-md btn-warning">Draft</button>
								@if(auth()->user()->role == 'admin')
									<button type="submit" name="status" value="publish" class="btn btn-md btn-success">Publish</button>
								@endif
							</div>
						</div>
					</form>
					@elseif ($menu == 'Penghargaan')
					<form action="{{route(strtolower($menu) .'.update', $penghargaan->ph_id)}}" method="POST" enctype="multipart/form-data">
						@csrf
						<input type="hidden" name="_method" value="PUT">
						<div class="col-10">
							<div class="mb-3">
								<label for="ph_nama_kegiatan" class="font-weight-bold">Nama {{$menu}}</label>
								<input type="text" name="k_id" id="k_id" placeholder="k_id..." class="form-control {{$errors->first('p_nama_kegiatan') ? "is-invalid" : ""}}" value="{{ $kesiswaan->k_id }}" required oninput="updatePreview()" hidden>
								<input type="text" name="nama_kegiatan" id="nama_kegiatan" placeholder="Nama {{$menu}}..." class="form-control {{$errors->first('ph_nama_kegiatan') ? "is-invalid" : ""}}" value="{{$penghargaan->ph_nama_kegiatan}}" required oninput="updatePreview()">
							</div>
							<div class="mb-3">
								<label for="e_id" class="font-weight-bold">Ekstrakurikuler</label>
								<select name="e_id" id="e_id" class="form-control {{$errors->first('e_id') ? "is-invalid" : ""}}" required oninput="updatePreview()">
									<option value="">Pilih Ekstrakurikuler</option>
									@foreach($ekstrakurikuler as $ekstra)
										<option value="{{ $ekstra->e_id }}" {{ $penghargaan->e_id == $ekstra->e_id ? 'selected' : '' }}>{{ $ekstra->e_nama_ekstrakurikuler }}</option>
									@endforeach
								</select>
							</div>
							<div class="mb-3">
								<label for="ph_deskripsi" class="font-weight-bold">Deskripsi</label>
								<textarea name="deskripsi" id="deskripsi" placeholder="Deskripsi..." class="form-control {{$errors->first('ph_deskripsi') ? "is-invalid" : ""}}" required oninput="updatePreview()">{{$penghargaan->ph_deskripsi}}</textarea>
							</div>
							<div class="mb-3">
								<label for="ph_foto" class="font-weight-bold">Foto</label>
								@if($penghargaan->ph_foto)
									<div class="mb-2">
										<img src="{{ asset('kesiswaan_image/'. strtolower($menu) .'_image/'.$penghargaan->ph_foto) }}" width="150px" alt="Foto Penghargaan">
									</div>
								@endif
								<input type="file" name="foto" id="foto" class="form-control {{$errors->first('ph_foto') ? "is-invalid" : ""}}" accept="image/*" onchange="updatePreview()">
								<small class="text-muted">Kosongkan jika tidak ingin mengubah foto</small>
							</div>
							<div class="mb-3 mt-4">
								<a href="{{route(strtolower($menu) .'.index')}}" class="btn btn-md btn-secondary">Back</a>
								<button type="submit" name="status" value="draft" class="btn btn-md btn-warning">Draft</button>
								@if(auth()->user()->role == 'admin')
									<button type="submit" name="status" value="publish" class="btn btn-md btn-success">Publish</button>
								@endif
							</div>
						</div>
					</form>
					@elseif ($menu == 'Ekstrakurikuler')
					<form action="{{route(strtolower($menu) .'.update', $ekstrakurikuler->e_id)}}" method="POST" enctype="multipart/form-data">
						@csrf
						<input type="hidden" name="_method" value="PUT">
						<div class="col-10">
							<div class="mb-3">
                                <label for="e_judul_slide" class="font-weight-bold">Judul Slide</label>
                                <input type="text" name="e_judul_slide" id="e_judul_slide" placeholder="Judul Slide..." class="form-control {{$errors->first('e_judul_slide') ? "is-invalid" : ""}}" value="{{old('e_judul_slide', $ekstrakurikuler->e_judul_slide)}}" required oninput="updatePreview()">
                                <div class="invalid-feedback"> {{$errors->first('e_judul_slide')}}</div>
                            </div>
                            <div class="mb-3">
                                <label for="e_deskripsi_slide" class="font-weight-bold">Deskripsi Slide</label>
                                <textarea name="e_deskripsi_slide" id="e_deskripsi_slide" placeholder="Deskripsi Slide..." class="form-control {{$errors->first('e_deskripsi_slide') ? "is-invalid" : ""}}" required oninput="updatePreview()">{{old('e_deskripsi_slide', $ekstrakurikuler->e_deskripsi_slide)}}</textarea>
                                <div class="invalid-feedback"> {{$errors->first('e_deskripsi_slide')}}</div>
                            </div>
							<div class="mb-3">
                                <label for="e_foto_slide1" class="font-weight-bold">Foto Slide 1</label>
                                @if($ekstrakurikuler->e_foto_slide1)
                                    <div class="mb-2">
                                        <img src="{{ asset('kesiswaan_image/slide_image/'.$ekstrakurikuler->e_foto_slide1) }}" width="150px" alt="Foto Slide 1">
                                    </div>
                                @endif
                                <input type="file" accept="image/*"  name="e_foto_slide1" id="e_foto_slide1" class="form-control {{$errors->first('e_foto_slide1') ? "is-invalid" : ""}}" accept="image/*" onchange="updatePreview()">
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah foto</small>
                                <div class="invalid-feedback"> {{$errors->first('e_foto_slide1')}}</div>
                            </div>
                            <div class="mb-3">
                                <label for="e_foto_slide2" class="font-weight-bold">Foto Slide 2</label>
                                @if($ekstrakurikuler->e_foto_slide2)
                                    <div class="mb-2">
                                        <img src="{{ asset('kesiswaan_image/slide_image/'.$ekstrakurikuler->e_foto_slide2) }}" width="150px" alt="Foto Slide 2">
                                    </div>
                                @endif
                                <input type="file" name="e_foto_slide2" id="e_foto_slide2" class="form-control {{$errors->first('e_foto_slide2') ? "is-invalid" : ""}}" accept="image/*" onchange="updatePreview()">
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah foto</small>
                                <div class="invalid-feedback"> {{$errors->first('e_foto_slide2')}}</div>
                            </div>
                            <div class="mb-3">
                                <label for="e_foto_slide3" class="font-weight-bold">Foto Slide 3</label>
                                @if($ekstrakurikuler->e_foto_slide3)
                                    <div class="mb-2">
                                        <img src="{{ asset('kesiswaan_image/slide_image/'.$ekstrakurikuler->e_foto_slide3) }}" width="150px" alt="Foto Slide 3">
                                    </div>
                                @endif
                                <input type="file" name="e_foto_slide3" id="e_foto_slide3" class="form-control {{$errors->first('e_foto_slide3') ? "is-invalid" : ""}}" accept="image/*" onchange="updatePreview()">
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah foto</small>
                                <div class="invalid-feedback"> {{$errors->first('e_foto_slide3')}}</div>
                            </div>
							<div class="mb-3">
								<label for="e_nama_ekstrakurikuler" class="font-weight-bold">Nama {{$menu}}</label>
								@if ($menu == 'Pembiasaan' || $menu == 'Penghargaan')
                                    <input type="text" name="k_id" id="k_id" placeholder="k_id..." class="form-control {{$errors->first('k_id') ? "is-invalid" : ""}}" value="{{ $kesiswaan->k_id }}" required oninput="updatePreview()" hidden>
                                @endif
								<input type="text" name="nama_kegiatan" id="nama_kegiatan" placeholder="Nama {{$menu}}..." class="form-control {{$errors->first('e_nama_ekstrakurikuler') ? "is-invalid" : ""}}" value="{{$ekstrakurikuler->e_nama_ekstrakurikuler}}" required oninput="updatePreview()">
							</div>
							<div class="mb-3">
								<label for="ph_deskripsi" class="font-weight-bold">Deskripsi</label>
								<textarea name="deskripsi" id="deskripsi" placeholder="Deskripsi..." class="form-control {{$errors->first('ph_deskripsi') ? "is-invalid" : ""}}" required oninput="updatePreview()">{{$ekstrakurikuler->e_deskripsi}}</textarea>
							</div>
							<div class="mb-3">
								<label for="ph_foto" class="font-weight-bold">Foto</label>
								@if($ekstrakurikuler->e_foto)
									<div class="mb-2">
										<img src="{{ asset('kesiswaan_image/'. strtolower($menu) .'_image/'.$ekstrakurikuler->e_foto) }}" width="150px" alt="Foto Penghargaan">
									</div>
								@endif
								<input type="file" name="foto" id="foto" class="form-control {{$errors->first('ph_foto') ? "is-invalid" : ""}}" accept="image/*" onchange="updatePreview()">
								<small class="text-muted">Kosongkan jika tidak ingin mengubah foto</small>
							</div>
							<div class="mb-3 mt-4">
								<a href="{{route(strtolower($menu) .'.index')}}" class="btn btn-md btn-secondary">Back</a>
								<button type="submit" name="status" value="draft" class="btn btn-md btn-warning">Draft</button>
								@if(auth()->user()->role == 'admin')
									<button type="submit" name="status" value="publish" class="btn btn-md btn-success" id="publish-button" {{ isset($SetNames) && $SetNames->e_nama_ekstrakurikuler==$ekstrakurikuler->e_nama_ekstrakurikuler && $SetNames->e_status==$ekstrakurikuler->e_status ? '' : 'disabled' }}>Publish</button>
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
						</div>
					</form>
					@elseif ($menu == 'Tatatertib')
					<form action="{{route(strtolower($menu) .'.update', $tatatertib->t_id)}}" method="POST" enctype="multipart/form-data">
						@csrf
						<input type="hidden" name="_method" value="PUT">
						<div class="col-10">
							<div class="mb-3">
								<label for="e_nama_ekstrakurikuler" class="font-weight-bold">Nama Peraturan</label>
								<input type="text" name="k_id" id="k_id" placeholder="k_id..." class="form-control {{$errors->first('p_nama_kegiatan') ? "is-invalid" : ""}}" value="{{ $kesiswaan->k_id }}" required oninput="updatePreview()" hidden>
								<input type="text" name="nama_kegiatan" id="nama_kegiatan" placeholder="Nama Peraturan..." class="form-control {{$errors->first('e_nama_ekstrakurikuler') ? "is-invalid" : ""}}" value="{{$tatatertib->t_nama_peraturan}}" required oninput="updatePreview()">
							</div>
							<div class="mb-3">
								<label for="ph_deskripsi" class="font-weight-bold">Deskripsi</label>
								<textarea name="deskripsi" id="deskripsi" placeholder="Deskripsi..." class="form-control {{$errors->first('ph_deskripsi') ? "is-invalid" : ""}}" required oninput="updatePreview()">{{$tatatertib->t_deskripsi}}</textarea>
							</div>
							<div class="mb-3 mt-4">
								<a href="{{route(strtolower($menu) .'.index')}}" class="btn btn-md btn-secondary">Back</a>
								<button type="submit" name="status" value="draft" class="btn btn-md btn-warning">Draft</button>
								@if(auth()->user()->role == 'admin')
									<button type="submit" name="status" value="publish" class="btn btn-md btn-success">Publish</button>
								@endif
							</div>
						</div>
					</form>
					@endif
				</div>
			</div>
		</div>
	</div>

	<div class="card mt-4 shadow">
		<div class="card-body">
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
								<img id="preview-image1" src="{{ $ekstrakurikuler->e_foto_slide1 ? asset('kesiswaan_image/slide_image/'.$ekstrakurikuler->e_foto_slide1) : '' }}" alt="Slide 1">
								<h1 id="preview-title-slide1">{{ $ekstrakurikuler->e_nama_ekstrakurikuler }}</h1>
								<h2 id="preview-description-slide1">{{ $ekstrakurikuler->e_deskripsi_slide }}</h2>
							</div>
							<div class="hero-slide">
								<img id="preview-image2" src="{{ $ekstrakurikuler->e_foto_slide2 ? asset('kesiswaan_image/slide_image/'.$ekstrakurikuler->e_foto_slide2) : '' }}" alt="Slide 2">
								<h1 id="preview-title-slide2">{{ $ekstrakurikuler->e_nama_ekstrakurikuler }}</h1>
								<h2 id="preview-description-slide2">{{ $ekstrakurikuler->e_deskripsi_slide }}</h2>
							</div>
							<div class="hero-slide">
								<img id="preview-image3" src="{{ $ekstrakurikuler->e_foto_slide3 ? asset('kesiswaan_image/slide_image/'.$ekstrakurikuler->e_foto_slide3) : '' }}" alt="Slide 3">
								<h1 id="preview-title-slide3">{{ $ekstrakurikuler->e_nama_ekstrakurikuler }}</h1>
								<h2 id="preview-description-slide3">{{ $ekstrakurikuler->e_deskripsi_slide }}</h2>
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
                                <h1 id="preview-title">{{ $ekstrakurikuler->e_nama_ekstrakurikuler }}</h1>
                                @endif
								@if ($menu == 'Pembiasaan' || $menu == 'Penghargaan' || $menu == 'Ekstrakurikuler')
								<div class="col-md-12">
									@if ($menu == 'Ekstrakurikuler')
										<img id="preview-image" src="{{asset('kesiswaan_image/'. strtolower($menu) .'_image/'.$ekstrakurikuler->e_foto)}}" alt="Preview Image" style="width: 100%; height: auto; margin-bottom: 20px;">
										<p class="card-text" id="preview-description">{{$ekstrakurikuler->e_deskripsi}}</p>
									@endif
									@if ($menu == 'Pembiasaan' || $menu == 'Penghargaan')
										<div class="row" id="activity-cards">
											<div class="col-md-6 col-lg-6 mb-4 activity-card">
												<div class="card shadow">
													@if ($menu == 'Pembiasaan')
													<img id="preview-image" src="{{asset('kesiswaan_image/'. strtolower($menu) .'_image/'.$pembiasaan->p_foto)}}" class="card-img-top" alt="Preview Image" style="height: 150px; object-fit: cover; width: 100%; image-rendering: optimizeSpeed;">
													<div class="card-body">
														<h5 class="card-title" id="preview-title">{{$pembiasaan->p_nama_kegiatan}}</h5>
														<p class="card-text" id="preview-description">{{$pembiasaan->p_deskripsi}}</p>
														<p class="card-text text-right"><small class="text-muted">{{ \Carbon\Carbon::parse($pembiasaan->p_create_at)->format('d-m-Y') }}</small></p>
													</div>
													@elseif ($menu == 'Penghargaan')
													<img id="preview-image" src="{{asset('kesiswaan_image/'. strtolower($menu) .'_image/'.$penghargaan->ph_foto)}}" class="card-img-top" alt="Preview Image" style="height: 150px; object-fit: cover; width: 100%; image-rendering: optimizeSpeed;">
													<div class="card-body">
														<h5 class="card-title" id="preview-title">{{$penghargaan->ph_nama_kegiatan}}</h5>
														<p class="card-text" id="preview-description">{{$penghargaan->ph_deskripsi}}</p>
														<p class="card-text text-right"><small class="text-muted">{{ \Carbon\Carbon::parse($penghargaan->ph_create_at)->format('d-m-Y') }}</small></p>
													</div>
													@endif
												</div>
											</div>
										</div>
									@endif
									@if ($menu == 'Ekstrakurikuler')
										<div class="row">
											@foreach($ekstrakurikuler_preview['achievements'] as $achievement)
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
									@endif
								</div>
								@elseif ($menu == 'Tatatertib')
								<div class="row">
									<div class="col-lg-4 col-md-5 col-sm-12 mb-3">
										<div id="list-example" class="list-group">
											<p class="list-group-item list-group-item-action">1. {{ $tatatertib->t_nama_peraturan }}</p>
										</div>
									</div>
									<div class="col-lg-8 col-md-7 col-sm-12">
										<div data-spy="scroll" data-target="#list-example" data-offset="0" class="scrollspy-example">
											<h4 id="list-item-1">1. {{ $tatatertib->t_nama_peraturan }}</h4>
											<p>{{ $tatatertib->t_deskripsi }}</p>
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
			// document.getElementById('preview-title').innerText = document.getElementById('nama_kegiatan').value;
			// document.getElementById('preview-description').innerText = document.getElementById('deskripsi').value;

			// const fileInput = document.getElementById('foto');
			// if (fileInput.files && fileInput.files[0]) {
			// 	const reader = new FileReader();
			// 	reader.onload = function(e) {
			// 		document.getElementById('preview-image').src = e.target.result;
			// 	}
			// 	reader.readAsDataURL(fileInput.files[0]);
			// }
		}
	</script>
@endsection
