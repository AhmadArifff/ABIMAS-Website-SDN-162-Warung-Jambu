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
                    <form action="{{route('admin.'. strtolower($menu) .'.index')}}" method="POST" enctype="multipart/form-data">
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
                                <div class="mb-3">
                                    <label for="name" class="font-weight-bold">Name</label>
                                    <input type="text" name="name" id="name" placeholder="Name..." class="form-control {{$errors->first('name') ? "is-invalid" : ""}}" value="{{old('name')}}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="role" class="font-weight-bold">Role</label>
                                    <select name="role" id="role" class="form-control {{$errors->first('role') ? "is-invalid" : ""}}" required>
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="guru" {{ old('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="font-weight-bold">Email</label>
                                    <input type="email" name="email" id="email" placeholder="Email..." class="form-control {{$errors->first('email') ? "is-invalid" : ""}}" value="{{old('email')}}" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="password" class="font-weight-bold">Password</label>
                                        <input type="password" name="password" id="password" placeholder="Password..." class="form-control {{$errors->first('password') ? "is-invalid" : ""}}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="password_confirmation" class="font-weight-bold">Confirm Password</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password..." class="form-control {{$errors->first('password_confirmation') ? "is-invalid" : ""}}" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="foto" class="font-weight-bold">Foto</label>
                                    <div class="mb-2">
                                        <img id="foto-preview" src="#" alt="Foto Preview" style="display: none; border-radius: 50%;" width="150px">
                                    </div>
                                    <input type="file" name="foto" id="foto" class="form-control {{$errors->first('foto') ? "is-invalid" : ""}}" accept="image/*" onchange="previewFoto(event)">
                                </div>

                                <script>
                                    function previewFoto(event) {
                                        var reader = new FileReader();
                                        reader.onload = function(){
                                            var output = document.getElementById('foto-preview');
                                            output.src = reader.result;
                                            output.style.display = 'block';
                                        };
                                        reader.readAsDataURL(event.target.files[0]);
                                    }
                                </script>
                            <div class="mb-3 mt-4">
                                <a href="{{route('admin.'. strtolower($menu) .'.index')}}" class="btn btn-md btn-secondary">Back</a>
                                <button type="submit" class="btn btn-md btn-warning">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
