<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Jogja Travel - Regna emplate</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicons -->
  <link href="{{asset('user/images/favicon.png')}}" rel="icon">
  <link href="{{asset('user/images/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Poppins:300,400,500,700" rel="stylesheet">

  <!-- Bootstrap CSS File -->
  <link href="{{asset('user/lib/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

  <!-- Libraries CSS Files -->
  <link href="{{asset('user/lib/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
  <link href="{{asset('user/lib/animate/animate.min.css')}}" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link href="{{asset('user/css/style.css')}}" rel="stylesheet">

  @yield('header')


</head>

<body>

  @php
        $url = request()->segment(1);
  @endphp

  <!--========================== Header ============================-->
  <header id="header">
    <div class="container d-flex align-items-center justify-content-between">

      <div id="logo">
        <a href="#hero" class="d-flex align-items-center">
          <img src="{{asset('sample_image/logo_.png')}}" style="margin-right:5px; height: 40px;"/>
          <h6 class="d-inline text-light mb-0">SDN 163 WARUNGJAMBU KIARACONDONG</h6>
        </a>
      </div>

      <nav id="nav-menu-container">
        <ul class="nav-menu">
            <li class="{{$url=='home'?'menu-active':''}}"><a href="{{route('home')}}">Home</a></li>
            <li class="{{$url=='berita'?'menu-active':''}}"><a href="{{route('berita')}}">Berita</a></li>            
            <li class="{{$url=='blog'?'menu-active':''}}"><a href="{{route('blog')}}">Blog</a></li>
            <li class="{{$url=='destination'?'menu-active':''}}"><a href="{{route('destination')}}">Destination</a></li>
            <li class="{{$url=='contact'?'menu-active':''}}"><a href="{{route('contact')}}">Contact </a></li>
            <li class="menu-has-children {{$url=='kesiswaan'?'menu-active':''}}"><a href="#">Kesiswaan</a>
            <ul>
              <li><a href="{{route('strukturorganisasi')}}">Struktur Organisasi SDN 163 Jambu Kiaracondong</a></li>
              <li><a href="{{route('tatatertib')}}">Tatatertib Siswa SDN 163 Jambu Kiaracondong</a></li>
              <li><a href="{{route('pembiasaan')}}">Pembiasaan</a></li>
              <li><a href="{{route('penghargaan')}}">Penghargaan</a></li>
              <li class="menu-has-children"><a href="#">Ekstrakurikuler</a>
                <ul>
                    @foreach($ekstrakurikuler_all as $ekstrakurikuler)
                      <li><a href="{{ url('ekstrakurikuler/' . $ekstrakurikuler->e_nama_ekstrakurikuler) }}">{{ $ekstrakurikuler->e_nama_ekstrakurikuler }}</a></li>
                    @endforeach
                    
                    {{-- <li><a href="{{ url('ekstrakurikuler/pramuka') }}">Pramuka</a></li>
                    <li><a href="{{ url('ekstrakurikuler/kesenian') }}">Kesenian</a></li>
                    <li><a href="{{ url('ekstrakurikuler/karate') }}">Karate</a></li>
                    <li><a href="{{ url('ekstrakurikuler/silat') }}">Silat</a></li>
                    <li><a href="{{ url('ekstrakurikuler/olimpiade') }}">Olimpiade</a></li>
                    <li><a href="{{ url('ekstrakurikuler/paskibra') }}">Paskibra</a></li>
                    <li><a href="{{ url('ekstrakurikuler/hoki') }}">Hoki</a></li>
                    <li><a href="{{ url('ekstrakurikuler/pmr') }}">PMR</a></li>
                    <li><a href="{{ url('ekstrakurikuler/renang') }}">Renang</a></li> --}}
                </ul>
              </li>
            </ul>
          </li>
        </ul>
      </nav><!-- #nav-menu-container -->
    </div>
  </header><!-- #header -->

  <!--========================== Hero Section ============================-->
  <section id="hero">
    <div class="hero-container">
      @yield('hero')
    </div>
  </section>

  <main id="main">
    @yield('content')
  </main>

  <!--==========================
    Footer
  ============================-->
  <footer id="footer">
    <div class="footer-widget-area js-doc-bottom-el">
      <div class="container">
        <div class="row">
          <div class="col-md-3 col-sm-6 mb-3">
            <div class="single-footer-widget">
              <h3 class="title">Tautan:</h3>
              <ul class="list-unstyled">
                @foreach($tautan as $link)
                    <li><a href="{{ $link->tt_url }}" title="{{ ucwords($link->tt_nama_tautan) }}" target="_blank">{{ ucwords($link->tt_nama_tautan) }}</a></li>
                @endforeach
              </ul>
            </div>
          </div>
            <div class="col-md-3 col-sm-6 mb-3">
              <div class="single-footer-widget">
              <h3 class="title">Kunjungi Kami :</h3>
                <div class="social-media">
                @foreach($media as $social)
                  @if(strtolower($social->ms_nama_media) == 'facebook')
                  <a href="{{ $social->ms_url }}" class="social-icon" style="font-size: 24px; margin-right: 10px; color: #3b5998;"><i class="fa fa-facebook"></i></a>
                  @elseif(strtolower($social->ms_nama_media) == 'twitter')
                  <a href="{{ $social->ms_url }}" class="social-icon" style="font-size: 24px; margin-right: 10px; color: #1da1f2;"><i class="fa fa-twitter"></i></a>
                  @elseif(strtolower($social->ms_nama_media) == 'instagram')
                  <a href="{{ $social->ms_url }}" class="social-icon" style="font-size: 24px; margin-right: 10px; color: #e1306c;"><i class="fa fa-instagram"></i></a>
                  @elseif(strtolower($social->ms_nama_media) == 'youtube')
                  <a href="{{ $social->ms_url }}" class="social-icon" style="font-size: 24px; margin-right: 10px; color: #ff0000;"><i class="fa fa-youtube"></i></a>
                  {{-- @elseif(strtolower($social->ms_nama_media) == 'whatsapp')
                  <a href="{{ $social->ms_url }}" class="social-icon" style="font-size: 24px; margin-right: 10px; color: #25d366;"><i class="fa fa-whatsapp"></i></a> --}}
                  @endif
                @endforeach
                </div>
              </div>
            </div>
          <div class="col-md-3 col-sm-6 mb-3">
            <div class="single-footer-widget">
              <h3 class="title">Informasi :</h3>
              <ul class="list-unstyled">
                <li><a href="{{ route('berita')}}" title="Berita">Berita</a></li>
                <li><a href="https://www.sdnduajambu.sch.id/berita/artikel" title="Artikel">Artikel</a></li>
              </ul>
            </div>
          </div>
            <div class="col-md-3 col-sm-6 mb-3">
            <div class="single-footer-widget">
              <h3 class="title">Lokasi Sekolah:</h3>
              <div class="map-responsive">
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1983.158327062084!2d107.6288757!3d-6.9381734!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e80b29802555%3A0x7c4e5aec77737b9c!2sSDN%20162%20Warung%20Jambu!5e0!3m2!1sen!2sid!4v1698765432100!5m2!1sen!2sid" width="300" height="250" frameborder="0" style="border:0" allowfullscreen></iframe>
              </div>
            </div>
            </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- #footer -->

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

  <!-- JavaScript Libraries -->
  <script src="{{asset('user/lib/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('user/lib/easing/easing.min.js')}}"></script>
  <script src="{{asset('user/lib/wow/wow.min.js')}}"></script>

  <script src="{{asset('user/lib/superfish/superfish.min.js')}}"></script>

  <!-- Contact Form JavaScript File -->
  {{-- <script src="{{asset('user/contactform/contactform.js')}}"></script> --}}

  <!-- Template Main Javascript File -->
  <script src="{{asset('user/js/main.js')}}"></script>

</body>
</html>
