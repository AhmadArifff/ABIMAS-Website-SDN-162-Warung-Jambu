<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <title> @yield('title') - Company Profile</title>

    <meta name="description" content="Ela Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="https://i.imgur.com/QRAUqs9.png">
    <link rel="shortcut icon" href="https://i.imgur.com/QRAUqs9.png">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{asset('ElaAdmin/css/cs-skin-elastic.css')}}">
    <link rel="stylesheet" href="{{asset('ElaAdmin/css/style.css')}}">
    <!-- Favicons -->
    <link href="{{asset('user/images/favicon.png')}}" rel="icon">
    <link href="{{asset('user/images/apple-touch-icon.png')}}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Poppins:300,400,500,700" rel="stylesheet">


    {{-- @yield('header') --}}
    <style>
        .dropdown-menu-right {
            margin-left: 10px;
        }
        #hero {
            background: #000;
            width: 100%;
            position: relative;
            overflow: hidden;
        }
        .hero-slide {
            position: absolute;
            top: 0;
            left: 100%;
            width: 100%;
            height: 100%;
            transition: left 1s ease-in-out, opacity 1s ease-in-out;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            opacity: 0;
        }
        .hero-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .hero-slide h1 {
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            margin: 0;
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 2rem;
        }
        .hero-slide h2 {
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            margin: 0;
            position: absolute;
            top: 60%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 1.2rem;
        }
        .hero-slide.active {
            left: 0;
            opacity: 1;
        }
        .hero-slide.previous {
            left: -100%;
            opacity: 0;
        }
        .form-control:focus {
            box-shadow: none;
        }
        .form-control::placeholder {
            font-size: 0.95rem;
            color: #aaa;
            font-style: italic;
        }
        .article {
            line-height: 1.6;
            font-size: 15px;
        }
        @media (max-width: 576px) {
            .hero-slide h1 {
                font-size: 1.5rem;
            }
            .hero-slide h2 {
                font-size: 1rem;
            }
        }
        #hero {
        width: 100%;
        height: 100vh;
        background-size: cover;
        position: relative;
        }

        @media (min-width: 1024px) {
        #hero {
            background-attachment: fixed;
        }
        }

        #hero:before {
        content: "";
        background: rgba(0, 0, 0, 0.6);
        position: absolute;
        bottom: 0;
        top: 0;
        left: 0;
        right: 0;
        }

        #hero .hero-container {
        position: absolute;
        bottom: 0;
        top: 0;
        left: 0;
        right: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        text-align: center;
        }

        #hero h1 {
        margin: 30px 0 10px 0;
        font-size: 48px;
        font-weight: 700;
        line-height: 56px;
        text-transform: uppercase;
        color: #fff;
        }

        @media (max-width: 768px) {
        #hero h1 {
            font-size: 28px;
            line-height: 36px;
        }
        }

        #hero h2 {
        color: #eee;
        margin-bottom: 50px;
        font-size: 24px;
        }

        @media (max-width: 768px) {
        #hero h2 {
            font-size: 18px;
            line-height: 24px;
            margin-bottom: 30px;
        }
        }
    </style>
    @yield('css')

</head>

<body>

    @php
        $url = request()->segment(2);
    @endphp

    <!-- Left Panel -->
    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="{{$url=='dashboard'?'active':''}}">
                    <a href="{{url('admin/dashboard')}}"><i class="menu-icon fa fa-laptop"></i>Dashboard </a>
                    </li>
                    <li class="{{$url=='categories'?'active':''}}">
                        <a href="{{url('admin/categories')}}"><i class="menu-icon fa fa-list-ul"></i>Categories </a>
                    </li>
                    <li class="{{$url=='articles'?'active':''}}">
                        <a href="{{url('admin/articles')}}"> <i class="menu-icon fa fa-newspaper-o"></i> Articles</a>
                    </li>
                    <li class="{{$url=='destinations'?'active':''}}">
                        <a href="{{url('admin/destinations')}}"><i class="menu-icon fa fa-paper-plane-o"></i>Destinations </a>
                    </li>
                    <li class="{{$url=='about'?'active':''}}">
                        <a href="{{url('admin/about')}}"><i class="menu-icon fa fa-user"></i>About </a>
                    </li>
                    <li class="{{$url=='berita'?'active':''}}">
                        <a href="{{url('admin/berita')}}"><i class="menu-icon fa fa-user"></i>Berita </a>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle d-flex align-items-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="menu-icon fa fa-graduation-cap mr-2"></i>Kesiswaan</a>
                        <ul class="sub-menu children dropdown-menu">
                            {{-- <li class="d-flex align-items-center"><i class="fa fa-sitemap mr-2"></i><a href="{{url('admin/kesiswaan/strukturorganisasi')}}">Struktur Organisasi</a></li> --}}
                            <li class="d-flex align-items-center"><i class="fa fa-futbol-o mr-2"></i><a href="{{ url('admin/kesiswaan/ekstrakurikuler') }}">Ekstrakurikuler</a></li>
                            <li class="d-flex align-items-center"><i class="fa fa-trophy mr-2"></i><a href="{{url('admin/kesiswaan/penghargaan')}}">Penghargaan</a></li>
                            <li class="d-flex align-items-center"><i class="fa fa-clock-o mr-2"></i><a href="{{url('admin/kesiswaan/pembiasaan')}}">Pembiasaan</a></li>
                            <li class="d-flex align-items-center"><i class="fa fa-gavel mr-2"></i><a href="{{url('admin/kesiswaan/tatatertib')}}">Tatatertib</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside>
    <!-- /#left-panel -->


    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->
            <header id="header" class="header">
                <div class="top-left">
                    <div class="navbar-header">
                        {{-- <a class="navbar-brand" href="{{url('/')}}"><img src="{{asset('ElaAdmin/images/logo.png')}}" alt="Logo"></a> --}}
                        <a class="navbar-brand text-success" href="{{url('admin/dashboard')}}" > <i class="fa fa-user-circle-o" style="font-size:34px"></i>  <span class="font-weight-bold " style="font-size:26px">Administrator</span></a>
                        <a class="navbar-brand hidden " href="{{url('/')}}"><img src="{{asset('ElaAdmin/images/logo2.png')}}" alt="Logo"></a>
                        <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
                    </div>
                </div>
                <div class="top-right">
                    <div class="header-menu">
                        <div class="header-left">
                            <div class="dropdown for-notification">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-bell"></i>
                                    @php
                                        $kesiswaan_count = $kesiswaa_all->filter(function($item) use ($kesiswaa_all) {
                                            $same_menu_items = $kesiswaa_all->where('k_nama_menu', $item->k_nama_menu);
                                            $published_item = $same_menu_items->where('k_status', 'PUBLISH')->first();
                                            return !$published_item && $same_menu_items->where('k_status', 'DRAFT')->count() > 1 || $same_menu_items->where('k_status', 'DRAFT')->count() == 1;
                                        })->count();
                                    @endphp
                                    <span class="count bg-danger">{{ $kesiswaan_count + $ekstrakurikuler_all->count() + $penghargaan_all->count() + $tatatertib_all->count() + $pembiasaan_all->count() }}</span>
                                </button>
                                <div class="dropdown-menu shadow" aria-labelledby="notification" style="width: 400px; max-height: 400px; overflow-y: auto;">
                                    <p class="red text-dark">You have {{ $kesiswaa_all->count() + $ekstrakurikuler_all->count() + $penghargaan_all->count() + $tatatertib_all->count() + $pembiasaan_all->count() }} Notifications</p>
                                    @if ($menu == 'Pembiasaan' || $menu == 'Penghargaan' || $menu == 'Ekstrakurikuler' || $menu == 'Tatatertib')
                                    @php
                                        // Ambil semua k_nama_menu yang memiliki status PUBLISH
                                        $publishedMenus = $kesiswaa_all->where('k_status', 'PUBLISH')->pluck('k_nama_menu')->unique();

                                        // Filter data agar hanya menampilkan DRAFT yang tidak memiliki PUBLISH dalam grupnya
                                        $filteredKesiswaan = $kesiswaa_all->filter(function ($item) use ($publishedMenus) {
                                            return $item->k_status === 'DRAFT' && !$publishedMenus->contains($item->k_nama_menu);
                                        });

                                        // Grouping berdasarkan k_nama_menu agar tidak ada duplikasi pengecekan
                                        $groupedKesiswaan = $filteredKesiswaan->groupBy('k_nama_menu');
                                    @endphp
                                        @foreach($groupedKesiswaan as $menuName => $items)
                                            @foreach($items as $item)
                                                <a class="dropdown-item media bg-flat-color-1 text-dark" href="#">
                                                    <div class="d-flex flex-column mr-3">
                                                        <img src="{{ $item->k_foto_slide1 ? asset('kesiswaan_image/slide_image/' . $item->k_foto_slide1) : asset('sample_image/Gambar.png') }}" alt="content image" style="width: 50px; height: 50px;" loading="lazy">
                                                        <img src="{{ $item->k_foto_slide2 ? asset('kesiswaan_image/slide_image/' . $item->k_foto_slide2) : asset('sample_image/Gambar.png') }}" alt="content image" style="width: 50px; height: 50px;" loading="lazy">
                                                        <img src="{{ $item->k_foto_slide3 ? asset('kesiswaan_image/slide_image/' . $item->k_foto_slide3) : asset('sample_image/Gambar.png') }}" alt="content image" style="width: 50px; height: 50px;" loading="lazy">
                                                    </div>
                                                    <div class="media-body">
                                                        <p class="text-dark">{{ $item->k_judul_slide }}</p>
                                                        <p>{{ Str::limit($item->k_deskripsi_slide, 30, '...') }}</p>
                                                        @foreach($user_all as $itemuser)
                                                            @if($item->k_create_id == $itemuser->id)
                                                                <p>{{ \Carbon\Carbon::parse($item->k_create_at)->format('d M Y') }} by {{ $itemuser->name ?? 'Unknown' }}</p>
                                                            @endif
                                                        @endforeach
                                                        <form action="{{ route('publish.kesiswaan', $item->k_id) }}" method="POST" class="text-right">
                                                            @csrf
                                                            <button type="submit" name="status" value="publish" class="btn btn-md btn-success">Disetujui</button>
                                                            <button type="submit" name="status" value="tidak" class="btn btn-md btn-danger">Tidak Disetujui</button>
                                                        </form>
                                                    </div>
                                                </a>
                                            @endforeach
                                        @endforeach
                                        @php
                                            // Ambil semua e_nama_ekstrakurikuler yang memiliki status PUBLISH
                                            $publishedEkstrakurikulerNames = $ekstrakurikuler_all->where('e_status', 'PUBLISH')->pluck('e_nama_ekstrakurikuler')->unique();

                                            // Filter data agar hanya menampilkan DRAFT yang tidak memiliki PUBLISH dalam grupnya
                                            $filteredEkstrakurikuler = $ekstrakurikuler_all->filter(function ($item) use ($publishedEkstrakurikulerNames) {
                                                return $item->e_status === 'DRAFT' && !$publishedEkstrakurikulerNames->contains($item->e_nama_ekstrakurikuler);
                                            });

                                            // Grouping berdasarkan e_nama_ekstrakurikuler agar tidak ada duplikasi pengecekan
                                            $groupedEkstrakurikuler = $filteredEkstrakurikuler->groupBy('e_nama_ekstrakurikuler');
                                        @endphp
                                        @foreach($groupedEkstrakurikuler as $ekstrakurikulerName => $items)
                                            @foreach($items as $item)
                                                <a class="dropdown-item media bg-flat-color-2 text-dark" href="#">
                                                    <img src="{{ $item->e_foto ? asset('kesiswaan_image/ekstrakurikuler_image/' . $item->e_foto) : asset('sample_image/Gambar.png') }}" alt="content image" class="mr-3" style="width: 50px; height: 50px;">
                                                    <div class="media-body">
                                                        <p class="text-dark">{{ $item->e_nama_ekstrakurikuler }}</p>
                                                        <p>{{ Str::limit($item->e_deskripsi, 30, '...') }}</p>
                                                        @foreach($user_all as $itemuser)
                                                            @if($item->e_create_id == $itemuser->id)
                                                                <p>{{ \Carbon\Carbon::parse($item->e_create_at)->format('d M Y') }} by {{ $itemuser->name ?? 'Unknown' }}</p>
                                                            @endif
                                                        @endforeach
                                                        <form action="{{ route('publish.ekstrakurikuler', $item->e_id) }}" method="POST" class="text-right">
                                                            @csrf
                                                            <button type="submit" name="status" value="publish" class="btn btn-md btn-success">Disetujui</button>
                                                            <button type="submit" name="status" value="tidak" class="btn btn-md btn-danger">Tidak Disetujui</button>
                                                        </form>
                                                    </div>
                                                </a>
                                            @endforeach
                                        @endforeach
                                        @foreach($penghargaan_all as $item)
                                            <a class="dropdown-item media bg-flat-color-3 text-dark" href="#">
                                                <img src="{{ $item->ph_foto ? asset('kesiswaan_image/penghargaan_image/' . $item->ph_foto) : asset('sample_image/Gambar.png') }}" alt="content image" class="mr-3" style="width: 50px; height: 50px;">
                                                <div class="media-body">
                                                    <p class="text-dark">{{ $item->ph_nama_kegiatan }}</p>
                                                    <p>{{ Str::limit($item->ph_deskripsi, 30, '...') }}</p>
                                                    @foreach($user_all as $itemuser)
                                                        @if($item->ph_create_id == $itemuser->id)
                                                            <p>{{ \Carbon\Carbon::parse($item->ph_create_at)->format('d M Y') }} by {{ $itemuser->name ?? 'Unknown' }}</p>
                                                        @endif
                                                    @endforeach
                                                    <form action="{{ route('publish.penghargaan', $item->ph_id) }}" method="POST" class="text-right">
                                                        @csrf
                                                        <button type="submit" name="status" value="publish" class="btn btn-md btn-success">Publish</button>
                                                        <button type="submit" name="status" value="tidak" class="btn btn-md btn-danger">Tidak Disetujui</button>
                                                    </form>
                                                </div>
                                            </a>
                                        @endforeach
                                        @foreach($tatatertib_all as $item)
                                            <a class="dropdown-item media bg-flat-color-4 text-dark" href="#">
                                                <div class="media-body">
                                                    <p class="text-dark">{{ $item->t_nama_peraturan }}</p>
                                                    <p>{{ Str::limit($item->t_deskripsi, 30, '...') }}</p>
                                                    @foreach($user_all as $itemuser)
                                                        @if($item->t_create_id == $itemuser->id)
                                                            <p>{{ \Carbon\Carbon::parse($item->t_create_at)->format('d M Y') }} by {{ $itemuser->name ?? 'Unknown' }}</p>
                                                        @endif
                                                    @endforeach
                                                    <form action="{{ route('publish.tatatertib', $item->t_id) }}" method="POST" class="text-right">
                                                        @csrf
                                                        <button type="submit" name="status" value="publish" class="btn btn-md btn-success">Publish</button>
                                                        <button type="submit" name="status" value="tidak" class="btn btn-md btn-danger">Tidak Disetujui</button>
                                                    </form>
                                                </div>
                                            </a>
                                        @endforeach
                                        @foreach($pembiasaan_all as $item)
                                            <a class="dropdown-item media bg-flat-color-4 text-dark" href="#">
                                                <img src="{{ $item->p_foto ? asset('kesiswaan_image/pembiasaan_image/' . $item->p_foto) : asset('sample_image/Gambar.png') }}" alt="content image" class="mr-3" style="width: 50px; height: 50px;">
                                                <div class="media-body">
                                                    <p class="text-dark">{{ $item->p_nama_kegiatan }}</p>
                                                    <p>{{ Str::limit($item->p_deskripsi, 30, '...') }}</p>
                                                    @foreach($user_all as $itemuser)
                                                        @if($item->p_create_id == $itemuser->id)
                                                            <p>{{ \Carbon\Carbon::parse($item->p_create_at)->format('d M Y') }} by {{ $itemuser->name ?? 'Unknown' }}</p>
                                                        @endif
                                                    @endforeach
                                                    <form action="{{ route('publish.pembiasaan', $item->p_id) }}" method="POST" class="text-right">
                                                        @csrf
                                                        <button type="submit" name="status" value="publish" class="btn btn-md btn-success">Publish</button>
                                                        <button type="submit" name="status" value="tidak" class="btn btn-md btn-danger">Tidak Disetujui</button>
                                                    </form>
                                                </div>
                                            </a>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="user-area dropdown float-right">
                            <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="user-avatar rounded-circle" src="{{asset('ElaAdmin/images/admin.jpg')}}" alt="User Avatar">
                            </a>

                            <div class="user-menu dropdown-menu">
                                <a class="nav-link" href="#"><i class="fa fa-cog"></i>Ganti Password</a>
                                <div class="nav-link" style="cursor:pointer" onclick="logout()" data-target="#modalLogout" data-toggle="modal"> 
                                    <i class="fa fa-power-off"></i> Logout
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
        <!-- /#header -->
        
        <div class="breadcrumbs mt-3">
            <div class="breadcrumbs-inner">
                <div class="row m-0">
                    <div class="col-sm-4">
                        <div class="page-header float-left">
                            <div class="page-title">
                                <h1 class="text-success">@yield('breadcrumbs')</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="page-header float-right">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="{{url('/'.Request::segment(1))}}">{{Request::segment(1)}}</a></li>
                                    @yield('second-breadcrumb')
                                    @yield('third-breadcrumb')
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Content -->
            <div class="content">
                <!-- Animated -->
                <div class="animated fadeIn">
                    
                    @yield('content')
                    
                </div>
                <!-- .animated -->
            </div>
        <!-- /.content -->
        <div class="clearfix"></div>
        <!-- Footer -->
        <footer class="site-footer">
            <div class="footer-inner bg-white">
                <div class="row">
                    <div class="col-sm-6">
                        Copyright &copy; 2018 Ela Admin
                    </div>
                    <div class="col-sm-6 text-right">
                        Designed by <a href="https://colorlib.com">Colorlib</a>
                    </div>
                </div>
            </div>
        </footer>
        <!-- /.site-footer -->
    </div>
    <!-- /#right-panel -->


    <!-- Modal Logout -->
        <div class="modal fade" id="modalLogout" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-inline">Logout</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure want to end this session?
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form action="" id="url-logout" method="POST" class="d-inline">
                    @csrf 
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
                </div>
            </div>
            </div>
        </div>
    <!-- End Modal Logout -->





    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        // Alert
        $(".alert").fadeTo(2000, 500).slideUp(500, function() {
            $(".alert").slideUp(500);
            $(".alert").empty();
        });

        // Logout
        function logout(){ 
            var url = '{{ route("logout") }}';    
            document.getElementById("url-logout").setAttribute("action", url);
            $('#modalLogout').modal();
        }
    </script>
    
    <!--Local Stuff-->
    @yield('script')
    
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="{{asset('ElaAdmin/js/main.js')}}"></script>




    
</body>
</html>
