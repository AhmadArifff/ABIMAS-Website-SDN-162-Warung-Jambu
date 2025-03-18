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
						<h3 align="center"></h3>
					</div>
					<form action="{{route('admin.'.strtolower($menu) .'.update', $about->a_id)}}" method="POST" enctype="multipart/form-data">
						@method('PUT')
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
						<div class="col-12 mb-3">
							<label for="a_visi" class="col-form-label font-weight-bold">Visi</label>
							<textarea name="a_visi" id="a_visi" placeholder="Visi..." class="form-control {{$errors->first('a_visi') ? "is-invalid" : ""}}" required>{{ $about->a_visi }}</textarea>
						</div>
						<div class="col-12 mb-3">
							<label for="a_misi" class="col-form-label font-weight-bold">Misi</label>
							<textarea name="a_misi" id="a_misi" placeholder="Misi..." class="form-control {{$errors->first('a_misi') ? "is-invalid" : ""}}" required>{{ $about->a_misi }}</textarea>
						</div>
						<div class="col-12 mb-3">
							<label for="as_sejarah" class="col-form-label font-weight-bold">Sejarah</label>
							<textarea name="as_sejarah" id="as_sejarah" placeholder="Sejarah..." class="form-control {{$errors->first('as_sejarah') ? "is-invalid" : ""}}" required>{{ $aboutSejarah->as_sejarah }}</textarea>
							<input type="text" name="k_id" id="k_id" placeholder="k_id..." class="form-control {{$errors->first('k_id') ? "is-invalid" : ""}}" value="{{ $kesiswaan->k_id }}" required oninput="updatePreview()" hidden>
						</div>
						<div class="mb-3 mt-4">
							<a href="{{route('admin.'.strtolower($menu) .'.index')}}" class="btn btn-md btn-secondary">Back</a>
							<button type="submit" name="status" value="draft" class="btn btn-md btn-warning">Draft</button>
							<button type="submit" name="status" value="publish" class="btn btn-md btn-success">Publish</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection