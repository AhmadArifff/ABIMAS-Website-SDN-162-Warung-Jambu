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
            <li class="{{$url=='home'?'menu-active':''}}"><a href="{{url('home')}}">Home</a></li>
            <li class="{{$url=='berita'?'menu-active':''}}"><a href="{{url('berita')}}">Berita</a></li>            
            <li class="{{$url=='blog'?'menu-active':''}}"><a href="{{url('blog')}}">Blog</a></li>
            <li class="{{$url=='destination'?'menu-active':''}}"><a href="{{url('destination')}}">Destination</a></li>
            <li class="{{$url=='contact'?'menu-active':''}}"><a href="{{url('contact')}}">Contact </a></li>
            <li class="menu-has-children {{$url=='kesiswaan'?'menu-active':''}}"><a href="#">Kesiswaan</a>
            <ul>
              <li><a href="{{url('strukturorganisasi')}}">Struktur Organisasi SDN 163 Jambu Kiaracondong</a></li>
              <li><a href="{{url('tatatertib')}}">Tatatertib Siswa SDN 163 Jambu Kiaracondong</a></li>
              <li><a href="{{url('pembiasaan')}}">Pembiasaan</a></li>
              <li><a href="{{url('penghargaan')}}">Penghargaan</a></li>
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
                <li><a href="https://guru.kemdikbud.go.id/" title="Buku Guru dan Siswa SP" target="_parent">Buku Guru dan Siswa SP</a></li>
                <li><a href="https://sdnduajambu.blogspot.com/2020/08/blog-post.html" title="Buletin Sekolah" target="_blank">Buletin Sekolah</a></li>
                <li><a href="https://sdnduajambu.blogspot.com/2020/08/perangkat-pembelajaran-lengkap-sdn-2.html" title="Kumpulan RPP Semua Kelas" target="_blank">Kumpulan RPP Semua Kelas</a></li>
                <li><a href="https://sdnduajambu.blogspot.com/2020/08/kumpulan-soal-online-kelas-5.html" title="Kumpulan Soal Online" target="_blank">Kumpulan Soal Online</a></li>
                <li><a href="https://sdnduajambu.blogspot.com/2020/07/format-laporan-bdr-sd-negeri-2-jambu.html" title="Laporan BDR" target="_blank">Laporan BDR</a></li>
                <li><a href="http://sdnduajambu.sch.id/simpen" title="Pengumuman Kelulusan Online" target="_blank">Pengumuman Kelulusan Online</a></li>
                <li><a href="https://sdn2jambu.weebly.com/" title="Platform Sekolah Penggerak" target="_blank">Platform Sekolah Penggerak</a></li>
                <li><a href="https://sdnduajambu.sch.id/ppdb" title="PPDB Online SDN-2 Jambu" target="_blank">PPDB Online SDN-2 Jambu</a></li>
                <li><a href="https://inlislite.perpusnas.go.id/?read=installerphp" title="Unduh Aplikasi Perpustakaan Digital" target="_blank">Unduh Aplikasi Perpustakaan Digital</a></li>
              </ul>
            </div>
          </div>
            <div class="col-md-3 col-sm-6 mb-3">
              <div class="single-footer-widget">
              <h3 class="title">Kunjungi Kami :</h3>
                <div class="social-media">
                <a href="https://www.facebook.com/profile.php?id=100089628607635" class="social-icon" style="font-size: 24px; margin-right: 10px; color: #3b5998;"><i class="fa fa-facebook"></i></a>
                <a href="https://twitter.com/sdndua_jambu" class="social-icon" style="font-size: 24px; margin-right: 10px; color: #1da1f2;"><i class="fa fa-twitter"></i></a>
                <a href="https://www.instagram.com/sdn2jambu_muarateweh/" class="social-icon" style="font-size: 24px; margin-right: 10px; color: #e1306c;"><i class="fa fa-instagram"></i></a>
                <a href="https://www.youtube.com/channel/UCK6kMH030GyI0VjVSj9HMRA" class="social-icon" style="font-size: 24px; margin-right: 10px; color: #ff0000;"><i class="fa fa-youtube"></i></a>
                <a href="https://wa.me/+6285249727400" class="social-icon" style="font-size: 24px; margin-right: 10px; color: #25d366;"><i class="fa fa-whatsapp"></i></a>
                </div>
              </div>
            </div>
          <div class="col-md-3 col-sm-6 mb-3">
            <div class="single-footer-widget">
              <h3 class="title">Informasi :</h3>
              <ul class="list-unstyled">
                <li><a href="{{ url('/berita')}}" title="Berita">Berita</a></li>
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
