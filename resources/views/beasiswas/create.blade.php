@extends('layouts.admin')

@section('title', 'Create Beasiswa')

@section('breadcrumbs', 'Beasiswa' )

@section('second-breadcrumb')
    <li>Create</li>
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
                    <form action="{{route('beasiswas.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="col-10">
                            <div class="mb-4">
                                <label for="title" class="font-weight-bold">Title</label>
                                <input type="text" name="title" placeholder="Beasiswa Title..." class="form-control {{$errors->first('title') ? "is-invalid" : ""}}" value="{{old('title')}}" required>
                                <div class="invalid-feedback"> {{$errors->first('title')}}</div>
                            </div>
                            <div class="mb-3">
                                <label for="slug" class="font-weight-bold">Image</label>
                                <input type="file" name="image" class="form-control {{$errors->first('image') ? "is-invalid" : ""}}" required>
                                <div class="invalid-feedback"> {{$errors->first('image')}}</div>
                            </div>
                            <div class="mb-3">
                                <label for="content" class="font-weight-bold">Content</label>
                                <textarea id="content" class="form-control ckeditor" name="content" rows="10" cols="50"></textarea>
                            </div>
                            
                            <div class="mb-3 mt-4">
                                <a href="{{url('admin/'.strtolower($menu).'s')}}" class="btn btn-md btn-secondary">Back</a>
                                <button type="submit" name="status" value="DRAFT" class="btn btn-md btn-warning">Draft</button>
                                @if(auth()->user()->role == 'admin')
                                    <button class="btn btn-success" name="save_action" value="PUBLISH">Publish</button>
                                @endif
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