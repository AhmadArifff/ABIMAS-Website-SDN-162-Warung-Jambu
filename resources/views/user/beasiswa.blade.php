@extends('layouts.user')

@section('header')
    <style>
        #hero{
            background: url('{{asset('user/images/beasiswa.png')}}') top center;
            background-repeat: no-repeat;
            width:100%;
            background-size:cover;
            margin:5px;
        }
        .full-img {
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            height: 180px;
        }
        .content{
          line-height: 1.6;
          font-size: 15px;
        } 
    </style>    
@endsection

@section('hero')
    <h1>INFORMASI BEASISWA</h1>
@endsection

@section('content')

    <section id="contact">
      <div class="row justify-content-center">
        <div class="col-sm-10">
          <div class="row container">
            <div class="col-sm-9">

              {{-- <div class=" wow fadeInUp">
                <div class="section-header">
                  <h3 class="section-title">Informasi Beasiswa</h3>
                  <p class="section-description">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque</p>
                </div>
              </div>
              <div class=" wow fadeInUp">
                <div class="row justify-content-left">
                  @foreach ($beasiswas as $beasiswa)
                    <div class="col-lg-4 col-md-6">
                      <a href="{{route('beasiswa.show', $beasiswa->slug)}}" class="decoration-none">
                          <div class="row">
                            <div class="col-11 full-img" style="background-image: url({{asset('beasiswas_image/'.$beasiswa->image)}})"></div>
                          </div>
                          <div class="row">
                            <div class="col px-0 pt-2">
                              <h4 style="color: #666666 !important;">{{$beasiswa->title}}</h4>
                            </div>
                          </div>
                        </a>
                      </div> 
                  @endforeach
                </div>
              </div> --}}

              @if (empty(request()->segment(2)) )
                @component('user.component.all_beasiswa', ['beasiswas'=> $beasiswas])
                @endcomponent
              @else
                @component('user.component.single_beasiswa', ['beasiswa'=> $beasiswas])
                @endcomponent
              @endif


            </div>
            
        </div>

      </div>
    </section>
      
      {{-- @if (empty(request()->segment(2)) )
        @component('user.component.all_beasiswa', ['beasiswas'=> $beasiswas])
        @endcomponent
      @else
        @component('user.component.single_beasiswa', ['beasiswa'=> $beasiswas])
        @endcomponent
      @endif --}}

@endsection