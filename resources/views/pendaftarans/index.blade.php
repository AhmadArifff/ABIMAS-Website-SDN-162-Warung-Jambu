@extends('layouts.admin')

@section('title', 'Pendaftaran')

@section('breadcrumbs', 'Pendaftaran')

@section('second-breadcrumb')
    <li> Overview Pendaftaran</li>
@endsection

@section('content')
  <!-- table  -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
              
            @if (session('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{session('success')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
                
            @endif
            
            <h3 class="text-center mt-3 mb-5">View Pendaftaran</h3>
            
            <div class="row">
              <div class="col-3">
                @if ($pendaftarans->isNotEmpty() && $pendaftarans[0]->image)
                  <div class="card shadow">
                  <img src="{{asset('pendaftaran_image/'.$pendaftarans[0]->image)}}" class="card-img-top" alt="image">
                  </div>
                @else
                  <div class="card shadow">
                  <img src="{{asset('sample_image/Gambar.png')}}" class="card-img-top" alt="No image available">
                  </div>
                @endif
              </div>
              <div class="col-9">
                <p class="font-weight-bold">Caption:</p>
                @if ($pendaftarans->isNotEmpty())
                  <p> {!!$pendaftarans[0]->caption!!} </p>
                  <a href="{{route('pendaftarans.edit', [$pendaftarans[0]->id])}}" class="btn btn-warning text-light"><i class="fa fa-pencil"></i> Edit Profile</a>
                @else
                  <p>Data pendaftaran tidak tersedia.</p>
                @endif
              </div>
            </div>
              
          </div>
        </div>
      </div>
    </div>
  <!-- /table -->
@endsection