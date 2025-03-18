@extends('layouts.admin')

@section('title', "Create $menu")

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
                    <form action="{{route('admin.informasi-media.store')}}" method="POST" enctype="multipart/form-data">
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
                        
                        <div class="col-10">
                                @if ($menu == 'Tautan')
                                    <div class="mb-3">
                                        <label for="name" class="font-weight-bold">Name {{$menu}}</label>
                                        <input type="text" name="name" id="name" placeholder="Name.{{$menu}}.." class="form-control {{$errors->first('name') ? "is-invalid" : ""}}" value="{{old('name')}}" required>
                                    </div>
                                    @endif
                                    @if ($menu == 'Media')
                                    <div class="mb-3">
                                        <label for="media_sosial" class="font-weight-bold">Media Sosial</label>
                                        <select name="name" id="media_sosial" class="form-control {{$errors->first('media_sosial') ? "is-invalid" : ""}}" required>
                                            @foreach(['facebook', 'twitter', 'instagram', 'youtube'] as $media)
                                                @if(!$mediasosial->contains('ms_nama_media', $media))
                                                    <option value="{{ $media }}" {{ old('media_sosial') == $media ? 'selected' : '' }}>{{ ucfirst($media) }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    @endif
                                <div class="mb-3">
                                    <input type="text" name="menu" id="menu" placeholder="Name..." value= "{{$menu}}" class="form-control {{$errors->first('name') ? "is-invalid" : ""}}" value="{{old('name')}}" required hidden>
                                    <label for="email" class="font-weight-bold">URL {{$menu}}</label>
                                    <input type="text" name="url" id="url" placeholder="https://example.com..." class="form-control {{$errors->first('url') ? "is-invalid" : ""}}" value="{{old('url')}}" required>
                                </div>
                            <div class="mb-3 mt-4">
                                <a href="{{route('admin.informasi-media.index')}}" class="btn btn-md btn-secondary">Back</a>
                                <button type="submit" class="btn btn-md btn-warning">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
