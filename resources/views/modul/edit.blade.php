@extends('layouts.admin')

@section('title', "Edit $menu")

@section('breadcrumbs', "$menu" )

@section('second-breadcrumb')
	<li>Edit</li>
@endsection

@section('css')
	<script src="/templateEditor/ckeditor/ckeditor.js"></script> 
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="card shadow">
				<div class="card-body">
					<div class="col-12 mb-3">
						<h3 align="center">Edit {{$menu}}</h3>
					</div>
					<form action="{{route('admin.'. strtolower($menu) .'.update', $modul->m_id)}}" method="POST" enctype="multipart/form-data">
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
							<div class="mb-3">
								<label for="m_guru_id" class="font-weight-bold">Guru Pengupload</label>
								<select name="m_guru_id" id="m_guru_id" class="form-control {{$errors->first('m_guru_id') ? "is-invalid" : ""}}" required>
									<option value="" disabled>Pilih Guru...</option>
									@foreach($gurus as $guru)
										<option value="{{ $guru->id }}" {{ old('m_guru_id', $modul->m_guru_id) == $guru->id ? 'selected' : '' }}>
											{{ $guru->nama }} {{ $guru->gelar }}
										</option>
									@endforeach
								</select>
							</div>
							<div class="mb-3">
								<label for="m_nama_modul" class="font-weight-bold">Nama Modul</label>
								<input type="text" name="m_nama_modul" id="m_nama_modul" placeholder="Nama Modul..." class="form-control {{$errors->first('m_nama_modul') ? "is-invalid" : ""}}" value="{{old('m_nama_modul', $modul->m_nama_modul)}}" required>
							</div>
							<div class="mb-3">
								<label for="m_modul_kelas" class="font-weight-bold">Modul Kelas</label>
								<select name="m_modul_kelas" id="m_modul_kelas" class="form-control {{$errors->first('m_modul_kelas') ? "is-invalid" : ""}}" required>
									<option value="" disabled>Pilih Kelas...</option>
									@for($i = 1; $i <= 6; $i++)
										<option value="{{ $i }}" {{ old('m_modul_kelas', $modul->m_modul_kelas) == $i ? 'selected' : '' }}>Kelas {{ $i }}</option>
									@endfor
								</select>
							</div>
							<div class="mb-3">
								<label for="m_foto_atau_pdf" class="font-weight-bold">Foto Atau PDF</label>
								@if($modul->m_foto_atau_pdf)
									<div class="mb-2">
										@php
											$extension = pathinfo($modul->m_foto_atau_pdf, PATHINFO_EXTENSION);
										@endphp
										@if(in_array(strtolower($extension), ['jpeg', 'jpg', 'png']))
											<img src="{{ asset('modul_image/foto/' . $modul->m_foto_atau_pdf) }}" width="150px" alt="Foto atau PDF">
										@elseif(strtolower($extension) === 'pdf')
											@if(auth()->check())
												<a href="{{ route('modul.file', $modul->m_foto_atau_pdf) }}" target="_blank">Lihat PDF</a>
											@else
												<p class="text-danger">Hanya pengguna yang sudah login yang dapat melihat file ini.</p>
											@endif
										@else
											<p>No File</p>
										@endif
									</div>
								@endif
								<input type="file" name="m_foto_atau_pdf" id="m_foto_atau_pdf" class="form-control {{$errors->first('m_foto_atau_pdf') ? "is-invalid" : ""}}" accept="image/*,application/pdf">
								<div class="invalid-feedback">{{$errors->first('m_foto_atau_pdf')}}</div>
							</div>
							<div class="mb-3">
								<label for="m_deskripsi_modul" class="font-weight-bold">Deskripsi Modul</label>
								<textarea id="content" class="form-control ckeditor {{$errors->first('m_deskripsi_modul') ? "is-invalid" : ""}}" name="m_deskripsi_modul" rows="10" cols="50" required>{{old('m_deskripsi_modul', $modul->m_deskripsi_modul)}}</textarea>
							</div>

							<div class="mb-3 mt-4">
								<a href="{{route('admin.'. strtolower($menu) .'.index')}}" class="btn btn-md btn-secondary">Back</a>
								<button type="submit" name="m_status" value="DRAFT" class="btn btn-md btn-warning">Save as Draft</button>
								<button type="submit" name="m_status" value="PUBLISH" class="btn btn-md btn-success">Publish</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('script')
	{{-- ckeditor --}}
	{{-- <script>
		CKEDITOR.replace( 'content', {
			filebrowserUploadUrl    : "{{route('articles.upload', ['_token' => csrf_token()])}}",
			filebrowserUploadMethod : 'form'
		});
	</script> --}}
@endsection