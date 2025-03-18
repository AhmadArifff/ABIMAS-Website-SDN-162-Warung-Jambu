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
									<select name="name" id="media_sosial" class="form-control {{$errors->first('media_sosial') ? "is-invalid" : ""}}" required>
										@foreach(['facebook', 'twitter', 'instagram', 'youtube'] as $mediaselect)
											@if(!$mediasosial->contains('ms_nama_media', $mediaselect) || old('name', $item->ms_nama_media) == $mediaselect)
												<option value="{{ $mediaselect }}" {{ old('name', $item->ms_nama_media) == $mediaselect ? 'selected' : '' }}>{{ ucfirst($mediaselect) }}</option>
											@endif
										@endforeach
									</select>
								</div>
							@endif
							<div class="mb-3">
								<input type="text" name="menu" id="menu" value="{{ $menu }}" class="form-control" hidden>
								<label for="url" class="font-weight-bold">URL {{$menu}}</label>
								@if ($menu == 'Media')
								<input type="text" name="url" id="url" placeholder="https://example.com..." class="form-control {{$errors->first('url') ? "is-invalid" : ""}}" value="{{ $tautan->tt_url}}" required>
								@elseif ($menu == 'Tautan')	
								<input type="text" name="url" id="url" placeholder="https://example.com..." class="form-control {{$errors->first('url') ? "is-invalid" : ""}}" value="{{ $media->ms_url}}" required>
								@endif
							</div>
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
