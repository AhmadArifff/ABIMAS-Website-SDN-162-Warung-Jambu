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
                                        <select name="name" id="media_sosial" class="form-control {{$errors->first('media_sosial') ? "is-invalid" : ""}}" required onchange="updateLabelAndInput()">
                                            @foreach(['facebook', 'twitter', 'instagram', 'youtube', 'whatsApp', 'tiktok'] as $media)
                                                @if(!$mediasosial->contains('ms_nama_media', $media))
                                                    <option value="{{ $media }}" {{ old('media_sosial') == $media ? 'selected' : '' }}>{{ ucfirst($media) }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    @endif
                                <div class="mb-3">
                                    <input type="text" name="menu" id="menu" placeholder="Name..." value= "{{$menu}}" class="form-control {{$errors->first('name') ? "is-invalid" : ""}}" value="{{old('name')}}" required hidden>
                                    <label for="url" id="url-label" class="font-weight-bold">URL {{$menu}}</label>
                                    <div class="input-group">
                                        <input type="text" name="url" id="url" placeholder="Nomor Admin..." class="form-control {{$errors->first('url') ? "is-invalid" : ""}}" value="{{old('url')}}" required>
                                    </div>
                                </div>

                                <script>
                                    function updateLabelAndInput() {
                                        const mediaSelect = document.getElementById('media_sosial');
                                        const urlLabel = document.getElementById('url-label');
                                        const urlInput = document.getElementById('url');
                                        const countryCode = document.getElementById('country-code');

                                        if (mediaSelect.value === 'whatsApp') {
                                            urlLabel.textContent = 'Nomor Admin';
                                            urlInput.placeholder = 'Nomor Admin...';
                                            urlInput.type = 'tel';
                                            urlInput.pattern = '\\+62[0-9]+';
                                            urlInput.maxLength = 15;
                                            urlInput.oninput = function() {
                                                // Remove non-numeric characters except the leading '+'
                                                this.value = this.value.replace(/[^\d+]/g, '');
                                            
                                                // Ensure the input starts with '+62' only once
                                                if (!this.value.startsWith('+62')) {
                                                    this.value = '+62' + this.value.replace(/^(\+62|0)+/, '');
                                                }
                                            };
                                            countryCode.style.display = 'inline-block';
                                        } else {
                                            urlLabel.textContent = 'URL {{$menu}}';
                                            urlInput.placeholder = 'https://example.com...';
                                            urlInput.type = 'text';
                                            urlInput.removeAttribute('pattern');
                                            urlInput.removeAttribute('maxlength');
                                            urlInput.oninput = null;
                                            countryCode.style.display = 'none';
                                        }
                                    }

                                    document.addEventListener('DOMContentLoaded', function() {
                                        updateLabelAndInput();

                                        const urlInput = document.getElementById('url');
                                        if (urlInput) {
                                            Inputmask({
                                                mask: '+62 999-9999-9999',
                                                placeholder: '',
                                                clearIncomplete: true
                                            }).mask(urlInput);
                                        }
                                    });
                                </script>
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
