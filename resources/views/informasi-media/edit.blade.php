@extends('layouts.admin')

@section('title', "Edit $menu")

@section('breadcrumbs', "$menu" )

@section('second-breadcrumb')
	<li>Edit</li>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="card shadow">
				<div class="card-body">
					<div class="col-12 mb-3">
						<h3 align="center">Edit {{$menu}}</h3>
					</div>
					@if ($menu == 'Media')
					<form action="{{ route('admin.informasi-media.update', $media->ms_id) }}" method="POST" enctype="multipart/form-data">
					@elseif ($menu == 'Tautan')	
					<form action="{{ route('admin.informasi-media.update', $tautan->tt_id) }}" method="POST" enctype="multipart/form-data">
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
						@csrf
						@method('PUT')
						
						<div class="col-10">
							@if ($menu == 'Tautan')
								<div class="mb-3">
									<label for="name" class="font-weight-bold">Name {{$menu}}</label>
									<input type="text" name="name" id="name" placeholder="Name {{$menu}}..." class="form-control {{$errors->first('name') ? "is-invalid" : ""}}" value="{{ old('name', $tautan->tt_nama_tautan) }}" required>
								</div>
							@endif
							@if ($menu == 'Media')
								<div class="mb-3">
									<label for="media_sosial" class="font-weight-bold">Media Sosial</label>
									<select name="name" id="media_sosial" class="form-control {{$errors->first('media_sosial') ? "is-invalid" : ""}}" required onchange="updateLabelAndInput()">
										@foreach(['facebook', 'twitter', 'instagram', 'youtube', 'whatsApp', 'tiktok'] as $mediaOption)
										@if($mediaOption == $media->ms_nama_media)
											<option value="{{ $mediaOption }}" selected>{{ ucfirst($mediaOption) }}</option>
										@elseif(!$mediasosial->contains('ms_nama_media', $mediaOption))
											<option value="{{ $mediaOption }}" {{ old('media_sosial') == $mediaOption ? 'selected' : '' }}>{{ ucfirst($mediaOption) }}</option>
										@endif
										@endforeach
									</select>
								</div>
							@endif
							<div class="mb-3">
								<input type="text" name="menu" id="menu" placeholder="Name..." value="{{$menu}}" class="form-control {{$errors->first('name') ? "is-invalid" : ""}}" required hidden>
								<label for="url" id="url-label" class="font-weight-bold">URL {{$menu}}</label>
								<div class="input-group">
									<input type="text" name="url" id="url" placeholder="Nomor Admin..." class="form-control {{$errors->first('url') ? "is-invalid" : ""}}" value="{{old('url', $media->ms_url)}}" required>
								</div>
							</div>

							<script>
								function updateLabelAndInput() {
									const mediaSelect = document.getElementById('media_sosial');
									const urlLabel = document.getElementById('url-label');
									const urlInput = document.getElementById('url');

									if (mediaSelect.value === 'whatsApp') {
										urlLabel.textContent = 'Nomor Admin';
										urlInput.placeholder = 'Nomor Admin...';
										urlInput.type = 'tel';
										urlInput.pattern = '\\+62[0-9]+';
										urlInput.maxLength = 15;
										urlInput.oninput = function() {
											this.value = this.value.replace(/[^\d+]/g, '');
											if (!this.value.startsWith('+62')) {
												this.value = '+62' + this.value.replace(/^(\+62|0)+/, '');
											}
										};
									} else {
										urlLabel.textContent = 'URL {{$menu}}';
										urlInput.placeholder = 'https://example.com...';
										urlInput.type = 'text';
										urlInput.removeAttribute('pattern');
										urlInput.removeAttribute('maxlength');
										urlInput.oninput = null;
									}
								}

								document.addEventListener('DOMContentLoaded', function() {
									updateLabelAndInput();
								});
							</script>
							<div class="mb-3 mt-4">
								<a href="{{ route('admin.informasi-media.index') }}" class="btn btn-md btn-secondary">Back</a>
								<button type="submit" class="btn btn-md btn-warning">Submit</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
