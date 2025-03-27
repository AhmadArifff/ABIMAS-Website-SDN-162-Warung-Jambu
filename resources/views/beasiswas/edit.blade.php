@extends('layouts.admin')

@section('title', 'Beasiswa')

@section('breadcrumbs', 'Edit Beasiswa')

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
                    <div class="col-12 mb-3">
                        <h3 align="center"></h3>
                    </div>
                    <form action="{{route('beasiswas.update', [$beasiswa->id])}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="col-10">
                            <div class="mb-4">
                                <label for="title" class="font-weight-bold">Title</label>
                                <input type="text" name="title" placeholder="Beasiswa Title..." class="form-control {{$errors->first('title') ? "is-invalid" : ""}}" value="{{$beasiswa->title}}" required>
                                <div class="invalid-feedback"> {{$errors->first('title')}}</div>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="font-weight-bold d-flex">Image</label>
                                @if($beasiswa->image)
                                    <img src="{{asset('beasiswas_image/'.$beasiswa->image)}}" alt="" width="120px">
                                @else   
                                    No Image
                                @endif
                                <input type="file" name="image" class="form-control mt-2" accept="image/*" >
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar.</small>
                            </div>
                            
                            <div class="mb-3">
                                <label for="content" class="font-weight-bold">Content</label>
                                <textarea id="content" class="form-control ckeditor" name="content" rows="10" cols="50">{{$beasiswa->content}}</textarea>
                            </div>
                            <div class="mb-3 mt-4">
                                <button class="btn btn-secondary" name="save_action" value="DRAFT">Save as draft</button>
                                <button class="btn btn-success" name="save_action" value="PUBLISH">Publish</button>
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
    <script>
        CKEDITOR.replace( 'content', {
            filebrowserUploadUrl    : "{{route('articles.upload', ['_token' => csrf_token()])}}",
            filebrowserUploadMethod : 'form'
        });
    </script>
@endsection