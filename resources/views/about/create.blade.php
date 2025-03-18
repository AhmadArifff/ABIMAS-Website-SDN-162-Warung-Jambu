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
                    <form action="{{route('admin.'.strtolower($menu) .'.store')}}" method="POST" enctype="multipart/form-data">
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
                        @if ($menu == 'Pembiasaan' || $menu == 'Penghargaan' || $menu == 'Ekstrakurikuler')
                        <div class="col-10">
                        @endif
                                <div class="d-flex align-items-end mt-2 mb-2 shadow card p-2">
                                    <div class="col-12">
                                        <label for="p_nama_kegiatan" class="col-form-label font-weight-bold">Jumlah Data</label>
                                        <button type="button" id="add-card" class="btn btn-md btn-warning">+</button>
                                    </div>
                                </div>
                                <div class="col-12" id="card-container">
                                    <div class="mb-3 row shadow card p-3">
                                        <div class="col-12" style="border: 1px solid #ddd; padding: 10px;">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label for="visi" class="col-form-label font-weight-bold">Visi</label>
                                                    <textarea name="visi[]" placeholder="Visi..." class="form-control {{$errors->first('visi') ? "is-invalid" : ""}}" required oninput="updatePreview()"></textarea>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="misi" class="col-form-label font-weight-bold">Misi</label>
                                                    <textarea name="misi[]" placeholder="Misi..." class="form-control {{$errors->first('misi') ? "is-invalid" : ""}}" required oninput="updatePreview()"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    document.getElementById('add-card').addEventListener('click', function() {
                                        const cardContainer = document.getElementById('card-container');
                                        const newCard = document.createElement('div');
                                        newCard.classList.add('mb-3', 'row', 'shadow', 'card', 'p-3');
                                        newCard.innerHTML = `
                                            <div class="col-12" style="border: 1px solid #ddd; padding: 10px;">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label for="visi" class="col-form-label font-weight-bold">Visi</label>
                                                        <textarea name="visi[]" placeholder="Visi..." class="form-control {{$errors->first('visi') ? "is-invalid" : ""}}" required oninput="updatePreview()"></textarea>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="misi" class="col-form-label font-weight-bold">Misi</label>
                                                        <textarea name="misi[]" placeholder="Misi..." class="form-control {{$errors->first('misi') ? "is-invalid" : ""}}" required oninput="updatePreview()"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        `;
                                        cardContainer.appendChild(newCard);
                                        updateJumlahData();
                                    });

                                    function updateJumlahData() {
                                        const jumlahData = document.querySelectorAll('#card-container .card').length;
                                        document.querySelector('label[for="p_nama_kegiatan"]').innerText = `Jumlah Data: ${jumlahData}`;
                                    }

                                    updateJumlahData();
                                </script>
                                <style>
                                    #add-card {
                                        position: absolute;
                                        right: 10px;
                                    }
                                </style>
                            <div class="col-12">
                                <div class="mb-3 row shadow card p-3">
                                    <div class="col-12" style="border: 1px solid #ddd; padding: 10px;">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="sejarah" class="font-weight-bold">Sejarah SDN 162 Warung Jambu Kiara Condong</label>
                                                <textarea name="sejarah" id="sejarah" placeholder="Sejarah..." class="form-control {{$errors->first('sejarah') ? "is-invalid" : ""}}" required style="width: 100%;">{{old('sejarah')}}</textarea>
                                                <input type="text" name="k_id" id="k_id" placeholder="k_id..." class="form-control {{$errors->first('k_id') ? "is-invalid" : ""}}" value="{{ $kesiswaan->k_id }}" required oninput="updatePreview()" hidden>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 mt-4">
                                <a href="{{route('admin.'.strtolower($menu) .'.index')}}" class="btn btn-md btn-secondary">Back</a>
                                <button type="submit" name="status" value="draft" class="btn btn-md btn-warning">Draft</button>
                                <button type="submit" name="status" value="publish" class="btn btn-md btn-success">Publish</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
