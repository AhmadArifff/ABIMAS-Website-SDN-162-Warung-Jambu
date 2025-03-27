<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>SDN 162 Warung Jambu Kiaracondong - Kota Bandung</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicons -->
  <link href="{{asset('sample_image/logo_.png')}}" rel="icon">
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
          <h6 class="d-inline text-light mb-0">SDN 162 WARUNGJAMBU KIARACONDONG</h6>
        </a>
      </div>

      <nav id="nav-menu-container">
        <ul class="nav-menu">
            <li class="{{$url=='home'?'menu-active':''}}"><a href="{{route('home')}}">Home</a></li>
            <li class="{{$url=='tentang_kami'?'menu-active':''}}"><a href="{{route('tentang_kami')}}">Tentang Kami</a></li>
            <li class="{{$url=='berita'?'menu-active':''}}"><a href="{{route('berita')}}">Berita</a></li>
            <li class="{{$url=='contact'?'menu-active':''}}"><a href="{{route('contact')}}">Contact </a></li>
            <li class="{{$url=='informasi'?'menu-active':''}}"><a href="{{url('informasi')}}">Informasi</a></li>
            <li class="menu-has-children {{$url=='kesiswaan'?'menu-active':''}}"><a href="#">Kesiswaan</a>
            <ul>
              <li><a href="{{route('strukturorganisasi')}}">Struktur Organisasi SDN 162 Jambu Kiaracondong</a></li>
              <li><a href="{{route('tatatertib')}}">Tatatertib Siswa SDN 162 Jambu Kiaracondong</a></li>
              <li><a href="{{route('pembiasaan')}}">Pembiasaan</a></li>
              <li><a href="{{route('penghargaan')}}">Penghargaan</a></li>
                <li class="menu-has-children"><a href="#">Ekstrakurikuler</a>
                <ul>
                  @foreach($ekstrakurikuler_all as $ekstrakurikuler)
                    <li><a href="{{ url('ekstrakurikuler/' . $ekstrakurikuler->e_nama_ekstrakurikuler) }}">{{ $ekstrakurikuler->e_nama_ekstrakurikuler }}</a></li>
                  @endforeach
                </ul>
            </ul>
            <li class="menu-has-children"><a href="#">Modul</a>
              <ul>
                @foreach($modul_all as $modul)
                  <li><a href="{{ url('modulpelajaran/' . $modul->m_modul_kelas) }}">kelas {{ $modul->m_modul_kelas }}</a></li>
                @endforeach
              </ul>
            </li>
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
                  <a href="{{ $social->ms_url }}" class="social-icon" style="font-size: 24px; margin-right: 10px; color: #3b5998;">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" style="height: 1em; width: 1em; fill: currentColor;">
                    <path d="M279.14 288l14.22-92.66h-88.91V134.4c0-25.35 12.42-50.06 52.24-50.06H293V6.26S273.43 0 248.36 0c-73.22 0-121.14 44.38-121.14 124.72v70.62H56.89V288h70.33v224h92.66V288z"/>
                  </svg>
                  </a>
                  @elseif(strtolower($social->ms_nama_media) == 'twitter')
                  <a href="{{ $social->ms_url }}" class="social-icon" style="font-size: 24px; margin-right: 10px; color: #1da1f2;">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="height: 1em; width: 1em; fill: currentColor;">
                    <path d="M459.37 151.716a162.816 162.816 0 0 1-46.355 12.722 81.72 81.72 0 0 0 35.804-45.07 162.563 162.563 0 0 1-51.605 19.717 81.1 81.1 0 0 0-138.287 74.007A230.3 230.3 0 0 1 39.1 134.1a81.1 81.1 0 0 0 25.1 108.3 80.8 80.8 0 0 1-36.7-10.1v1c0 39.6 28.2 72.6 65.6 80.1a81.3 81.3 0 0 1-36.5 1.4c10.3 32.2 40.2 55.7 75.6 56.4a162.7 162.7 0 0 1-100.7 34.7c-6.5 0-12.9-.4-19.2-1.1a230.3 230.3 0 0 0 124.6 36.5c149.4 0 231.1-123.8 231.1-231.1 0-3.5-.1-7-.2-10.5a165.3 165.3 0 0 0 40.6-42.1z"/>
                  </svg>
                  </a>
                  @elseif(strtolower($social->ms_nama_media) == 'instagram')
                  <a href="{{ $social->ms_url }}" class="social-icon" style="font-size: 24px; margin-right: 10px; color: #e1306c;">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="height: 1em; width: 1em; fill: currentColor;">
                    <path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9 114.9-51.3 114.9-114.9-51.3-114.9-114.9-114.9zm0 186.6c-39.6 0-71.7-32.1-71.7-71.7s32.1-71.7 71.7-71.7 71.7 32.1 71.7 71.7-32.1 71.7-71.7 71.7zm146.4-194.3c0 14.9-12 26.9-26.9 26.9s-26.9-12-26.9-26.9 12-26.9 26.9-26.9 26.9 12 26.9 26.9zm76.1 27.2c-.7-35.3-9.9-66.7-36.2-92.9s-57.6-35.5-92.9-36.2c-36.6-2.1-146.4-2.1-183 0-35.3.7-66.7 9.9-92.9 36.2s-35.5 57.6-36.2 92.9c-2.1 36.6-2.1 146.4 0 183 0 35.3 9.9 66.7 36.2 92.9s57.6 35.5 92.9 36.2c36.6 2.1 146.4 2.1 183 0 35.3-.7 66.7-9.9 92.9-36.2s35.5-57.6 36.2-92.9c2.1-36.6 2.1-146.4 0-183zm-48.2 224c-7.8 19.6-23.1 35-42.7 42.7-29.5 11.7-99.5 9-132.6 9s-103.1 2.6-132.6-9c-19.6-7.8-35-23.1-42.7-42.7-11.7-29.5-9-99.5-9-132.6s-2.6-103.1 9-132.6c7.8-19.6 23.1-35 42.7-42.7 29.5-11.7 99.5-9 132.6-9s103.1-2.6 132.6 9c19.6 7.8 35 23.1 42.7 42.7 11.7 29.5 9 99.5 9 132.6s2.6 103.1-9 132.6z"/>
                  </svg>
                  </a>
                  @elseif(strtolower($social->ms_nama_media) == 'youtube')
                  <a href="{{ $social->ms_url }}" class="social-icon" style="font-size: 24px; margin-right: 10px; color: #ff0000;">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" style="height: 1em; width: 1em; fill: currentColor;">
                    <path d="M549.655 124.083c-6.281-23.65-24.764-42.133-48.414-48.414C457.781 64 288 64 288 64s-169.781 0-213.241 11.669c-23.65 6.281-42.133 24.764-48.414 48.414C16.676 167.544 16.676 256 16.676 256s0 88.456 10.669 131.917c6.281 23.65 24.764 42.133 48.414 48.414C118.219 448 288 448 288 448s169.781 0 213.241-11.669c23.65-6.281 42.133-24.764 48.414-48.414C559.324 344.456 559.324 256 559.324 256s0-88.456-10.669-131.917zM232 336V176l144 80-144 80z"/>
                  </svg>
                  </a>
                  @elseif(strtolower($social->ms_nama_media) == 'whatsapp')
                  <a href="{{ "https://wa.me/".$social->ms_url }}" class="social-icon" style="font-size: 24px; margin-right: 10px; color: #25d366;">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="height: 1em; width: 1em; fill: currentColor;">
                    <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7 .9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/>
                  </svg>
                  </a>
                  @elseif(strtolower($social->ms_nama_media) == 'tiktok')
                  <a href="{{ $social->ms_url }}" class="social-icon" style="font-size: 24px; margin-right: 10px; color: #000000;">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="height: 1em; width: 1em; fill: currentColor;">
                    <path d="M448 209.9a210.1 210.1 0 0 1 -122.8-39.3V349.4A162.6 162.6 0 1 1 185 188.3V278.2a74.6 74.6 0 1 0 52.2 71.2V0l88 0a121.2 121.2 0 0 0 1.9 22.2h0A122.2 122.2 0 0 0 381 102.4a121.4 121.4 0 0 0 67 20.1z"/>
                  </svg>
                  </a>
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
                <li><a href="{{ route('informasi')}}" title="Artikel">Informasi</a></li>
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
