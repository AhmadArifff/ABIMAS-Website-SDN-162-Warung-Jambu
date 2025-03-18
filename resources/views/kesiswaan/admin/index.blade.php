@extends('layouts.admin')

@section('title', "$menu")

@section('breadcrumbs', "Overview $menu")

@section('css')
    <style>
        .underline:hover{
            text-decoration: underline;
        }
    </style>
@endsection

@section('content')
    @if (auth()->user()->role == 'admin')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
            @if ($menu == 'Pembiasaan' || $menu == 'Penghargaan' || $menu == 'Tatatertib')
                <div class="card-body">
                    
                    {{-- Title 1 --}}
                    <h3>Manage Content Slide {{$menu}}</h3>
                    
                    {{-- button create --}}
                    <div class="mb-5 text-right">
                        <form action="{{ route('admin.kesiswaan.kesiswaan.create') }}" method="GET" class="d-inline">
                            <input type="text" name="menu" id="menu" placeholder="Nama Menu..." class="form-control {{$errors->first('menu') ? "is-invalid" : ""}}" value="{{$menu}}" required hidden>
                            <button type="submit" class="btn btn-sm btn-success mt-2"> <i class="fa fa-plus"></i> Create</button>
                        </form>
                    </div>

                    {{-- display filter --}}
                    <div class="row mb-3">
                        <div class="col-sm-7">
                            <ul class="nav nav-tabs ">
                                <li class="nav-item">
                                    <a class="nav-link p-2 px-3 {{Request::get('-isi-slide-status') == NULL ? 'active' : ''}}" href="{{route('admin.kesiswaan.'. strtolower($menu) .'.index')}}">All</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2 px-3 {{Request::get('-isi-slide-status') == 'publish' ?'active' : '' }}" href="{{route('admin.kesiswaan.'. strtolower($menu) .'.index', ['-isi-slide-status' =>'publish'])}}">Publish</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2 px-3 {{Request::get('-isi-slide-status') == 'draft' ?'active' : '' }}" href="{{route('admin.kesiswaan.'. strtolower($menu) .'.index', ['-isi-slide-status' =>'draft'])}}">Draft</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2 px-3 {{Request::get('-isi-slide-status') == 'hapus' ?'active' : '' }}" href="{{route('admin.kesiswaan.'. strtolower($menu) .'.index', ['-isi-slide-status' =>'hapus'])}}">Delete</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2 px-3 {{Request::get('-isi-slide-status') == 'tidak' ?'active' : '' }}" href="{{route('admin.kesiswaan.'. strtolower($menu) .'.index', ['-isi-slide-status' =>'tidak'])}}">Tidak Disetujui</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-5">
                            <form action="{{route('admin.kesiswaan.'. strtolower($menu) .'.index')}}">
                                <div class="input-group">
                                    <input name="k_keyword" type="text" value="{{Request::get('k_keyword')}}" class="form-control" placeholder="Filter by judul">
                                    <div class="input-group-append">
                                        <input type="submit" value="Filter" class="btn btn-info">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- alert --}}
                    @if (session('success-slide'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{session('success-slide')}}.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                    @endif
                    @if ($errors->any() || session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        @if ($errors->any())
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @else
                            {{ session('error') }}
                        @endif
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    
                    {{-- table --}}
                    <table class="table">
                        <thead class="text-light" style="background-color:#33b751 !important">
                            <tr>
                                <th width="12px">No</th>
                                <th class="text-center">
                                    <a href="{{ route('admin.kesiswaan.'. strtolower($menu) .'.index', array_merge(request()->all(), ['sort' => 'k_judul_slide', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="text-light">Judul Slide</a>
                                </th>
                                <th class="text-center">
                                    <a href="{{ route('admin.kesiswaan.'. strtolower($menu) .'.index', array_merge(request()->all(), ['sort' => 'k_deskripsi_slide', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="text-light">Deskripsi Slide</a>
                                </th>
                                <th class="text-center">
                                    <a href="{{ route('admin.kesiswaan.'. strtolower($menu) .'.index', array_merge(request()->all(), ['sort' => 'k_judul_isi_content', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="text-light">Judul Isi Content</a>
                                </th>
                                <th class="text-center">Foto Slide 1</th>
                                <th class="text-center">Foto Slide 2</th>
                                <th class="text-center">Foto Slide 3</th>
                                <th class="text-center">Status</th>
                                <th width="88px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kesiswaan as $index => $item)
                                @if (Request::get('k_status') != 'hapus' && $item->k_status == 'hapus')
                                    @continue
                                @endif
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{$item->k_judul_slide}}</td>
                                    <td>{{$item->k_deskripsi_slide}}</td>
                                    <td>{{$item->k_judul_isi_content}}</td>
                                    <td>
                                        @if($item->k_foto_slide1)
                                            <img src="{{ asset('kesiswaan_image/slide_image/' . $item->k_foto_slide1) }}" alt="Foto Slide 1" width="50">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->k_foto_slide2)
                                            <img src="{{ asset('kesiswaan_image/slide_image/' . $item->k_foto_slide2) }}" alt="Foto Slide 2" width="50">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->k_foto_slide3)
                                            <img src="{{ asset('kesiswaan_image/slide_image/' . $item->k_foto_slide3) }}" alt="Foto Slide 3" width="50">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    @if ($item->k_status == 'TIDAK')
                                        <td>{{$item->k_status}} Disetujui</td>
                                    @else
                                        <td>{{$item->k_status}}</td>    
                                    @endif
                                    <td>
                                        @if ($item->k_status == 'HAPUS')
                                            <form class="d-inline" method="POST" action="{{route('admin.kesiswaan.kesiswaan.restore', [$item->k_id])}}">
                                                @csrf   
                                                <button type="button" class="btn btn-sm btn-success btn-restore" title="Restore" data-toggle="modal" data-target="#restoreModal"><i class="fa fa-undo"></i></button>
                                            </form>
                                            <form class="d-inline" method="POST" action="{{route('admin.kesiswaan.kesiswaan.destroy', [$item->k_id])}}" >
                                                @method('delete')
                                                @csrf   
                                                <button type="button" class="btn btn-sm btn-danger btn-delete-permanent" title="Delete" data-toggle="modal" data-target="#deletePermanentModal"><i class="fa fa-trash"></i></button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.kesiswaan.kesiswaan.edit', [$item->k_id]) }}" method="GET" class="d-inline">
                                                <input type="text" name="menu" id="menu" placeholder="Nama Menu..." class="form-control {{$errors->first('menu') ? "is-invalid" : ""}}" value="{{$menu}}" required hidden>
                                                <button type="submit" class="btn btn-sm btn-warning text-light" title="Edit"><i class="fa fa-pencil"></i></button>
                                            </form>
                                            <form class="d-inline" method="POST" action="{{route('admin.kesiswaan.kesiswaan.destroyrecycle', [$item->k_id])}}" >
                                                @method('delete')
                                                @csrf   
                                                <button type="button" class="btn btn-sm btn-danger btn-delete-recycle" title="Delete" data-toggle="modal" data-target="#deleteRecycleModal"><i class="fa fa-trash"></i></button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            {{$kesiswaan->appends(Request::all())->links()}}
                        </tfoot>
                    </table>
                </div>    
                @endif
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    
                    {{-- Title 2 --}}
                    <h3>Manage Isi Content {{$menu}}</h3>
                    
                    {{-- button create --}}
                    <div class="mb-5 text-right">
                        <form action="{{ route('admin.kesiswaan.'. strtolower($menu) .'.create') }}" method="GET" class="d-inline">
                            <input type="text" name="menu" id="menu" placeholder="Nama Menu..." class="form-control {{$errors->first('menu') ? "is-invalid" : ""}}" value="{{$menu}}" required hidden>
                            <button type="submit" class="btn btn-sm btn-success mt-2"> <i class="fa fa-plus"></i> Create</button>
                        </form>
                    </div>

                    {{-- display filter --}}
                    <div class="row mb-3">
                        <div class="col-sm-7">
                            <ul class="nav nav-tabs ">
                                <li class="nav-item">
                                    <a class="nav-link p-2 px-3 {{Request::get('-isi-content-status') == NULL ? 'active' : ''}}" href="{{route('admin.kesiswaan.'. strtolower($menu) .'.index')}}">All</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2 px-3 {{Request::get('-isi-content-status') == 'publish' ?'active' : '' }}" href="{{route('admin.kesiswaan.'. strtolower($menu) .'.index', ['-isi-content-status' =>'publish'])}}">Publish</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2 px-3 {{Request::get('-isi-content-status') == 'draft' ?'active' : '' }}" href="{{route('admin.kesiswaan.'. strtolower($menu) .'.index', ['-isi-content-status' =>'draft'])}}">Draft</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2 px-3 {{Request::get('-isi-content-status') == 'hapus' ?'active' : '' }}" href="{{route('admin.kesiswaan.'. strtolower($menu) .'.index', ['-isi-content-status' =>'hapus'])}}">Delete</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2 px-3 {{Request::get('-isi-content-status') == 'tidak' ?'active' : '' }}" href="{{route('admin.kesiswaan.'. strtolower($menu) .'.index', ['-isi-content-status' =>'tidak'])}}">Tidak Disetujui</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-5">
                            <form action="{{route('admin.kesiswaan.'. strtolower($menu) .'.index')}}">
                                <div class="input-group">
                                    <input name="p_keyword" type="text" value="{{Request::get('p_keyword')}}" class="form-control" placeholder="Filter by title">
                                    <div class="input-group-append">
                                        <input type="submit" value="Filter" class="btn btn-info">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- alert --}}
                    @if (session('success-isi-content'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{session('success-isi-content')}}.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                    @endif
                    @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                    @endif
                    {{-- Modal Error
                    
                    
                    {{-- table --}}
                    <table class="table">
                        <thead class="text-light" style="background-color:#33b751 !important">
                            <tr>
                                <th width="12px">No</th>
                                @if ($menu == 'Ekstrakurikuler')
                                <th class="text-center">Judul Slide</th>
                                <th class="text-center">Deskripsi Slide</th>
                                <th class="text-center">Foto Slide 1</th>
                                <th class="text-center">Foto Slide 2</th>
                                <th class="text-center">Foto Slide 3</th>
                                @endif
                                <th class="text-center">
                                    Nama 
                                    @if ($menu == 'Pembiasaan')
                                        Kegiatan
                                    @elseif ($menu == 'Penghargaan')
                                        Penghargaan
                                    @elseif ($menu == 'Ekstrakurikuler')
                                        Ekstrakurikuler
                                    @endif
                                </th>
                                @if ($menu == 'Penghargaan')
                                <th class="text-center">
                                    Nama Ekstrakurikuler
                                </th>
                                @endif
                                <th class="text-center">
                                    Deskripsi
                                </th>
                                @if ($menu == 'Pembiasaan' || $menu == 'Penghargaan' || $menu == 'Ekstrakurikuler')
                                <th class="text-center">Foto</th>
                                @endif
                                <th class="text-center">Status</th>
                                <th width="88px">Action</th>
                            </tr>
                        </thead>
                        @if ($menu == 'Pembiasaan')
                        <tbody>
                            @foreach ($pembiasaan as $index => $item)
                                @if (Request::get('status') != 'hapus' && $item->p_status == 'hapus')
                                    @continue
                                @endif
                                @if (auth()->user()->role == 'guru' && $item->p_create_id != auth()->user()->id)
                                    @continue
                                @endif
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{$item->p_nama_kegiatan}}</td>
                                    <td>{{$item->p_deskripsi}}</td>
                                    <td>
                                        @if($item->p_foto)
                                            <img src="{{ asset('kesiswaan_image/pembiasaan_image/' . $item->p_foto) }}" alt="Foto" width="50">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    @if ($item->p_status == 'TIDAK')
                                        <td>{{$item->p_status}} Disetujui</td>
                                    @else
                                        <td>{{$item->p_status}}</td>    
                                    @endif
                                    <td>
                                        @if ($item->p_status == 'HAPUS')
                                            <form class="d-inline" method="POST" action="{{route('admin.kesiswaan.'. strtolower($menu) .'.restore', [$item->p_id])}}">
                                                @csrf   
                                                <button type="button" class="btn btn-sm btn-success btn-restore" title="Restore" data-toggle="modal" data-target="#restoreModal"><i class="fa fa-undo"></i></button>
                                            </form>
                                            <form class="d-inline" method="POST" action="{{route('admin.kesiswaan.'. strtolower($menu) .'.destroy', [$item->p_id])}}" >
                                                @method('delete')
                                                @csrf   
                                                <button type="button" class="btn btn-sm btn-danger btn-delete-permanent" title="Delete" data-toggle="modal" data-target="#deletePermanentModal"><i class="fa fa-trash"></i></button>
                                            </form>
                                        @else
                                            <a href="{{ route('admin.kesiswaan.'. strtolower($menu) .'.edit', [$item->p_id])}}" class="btn btn-sm btn-warning text-light" title="Edit"><i class="fa fa-pencil"></i></a>
                                            <form class="d-inline" method="POST" action="{{route('admin.kesiswaan.'. strtolower($menu) .'.destroyrecycle', [$item->p_id])}}" >
                                                @method('delete')
                                                @csrf   
                                                <button type="button" class="btn btn-sm btn-danger btn-delete-recycle" title="Delete" data-toggle="modal" data-target="#deleteRecycleModal"><i class="fa fa-trash"></i></button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            {{$pembiasaan->appends(Request::all())->links()}}
                        </tfoot>
                        @elseif ($menu == 'Penghargaan')
                        <tbody>
                            @foreach ($penghargaan as $index => $item)
                                @if (Request::get('status') != 'hapus' && $item->ph_status == 'hapus')
                                    @continue
                                @endif
                                @if (auth()->user()->role == 'guru' && $item->ph_create_id != auth()->user()->id)
                                    @continue
                                @endif
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{$item->ph_nama_kegiatan}}</td>
                                    <td>
                                        @php
                                            $ekskul = $ekstrakurikuler->firstWhere('e_id', $item->e_id);
                                        @endphp
                                        {{$ekskul ? $ekskul->e_nama_ekstrakurikuler : 'No Ekstrakurikuler'}}
                                    </td>
                                    <td>{{$item->ph_deskripsi}}</td>
                                    <td>
                                        @if($item->ph_foto)
                                        <img src="{{ asset('kesiswaan_image/'. strtolower($menu) .'_image/' . $item->ph_foto) }}" alt="Foto" width="50">
                                        @else
                                        No Image
                                        @endif
                                    </td>
                                    @if ($item->ph_status == 'TIDAK')
                                        <td>{{$item->ph_status}} Disetujui</td>
                                    @else
                                        <td>{{$item->ph_status}}</td>    
                                    @endif
                                    <td>
                                        @if ($item->ph_status == 'HAPUS')
                                            <form class="d-inline" method="POST" action="{{route('admin.kesiswaan.'. strtolower($menu) .'.restore', [$item->ph_id])}}">
                                                @csrf   
                                                <button type="button" class="btn btn-sm btn-success btn-restore" title="Restore" data-toggle="modal" data-target="#restoreModal"><i class="fa fa-undo"></i></button>
                                            </form>
                                            <form class="d-inline" method="POST" action="{{route('admin.kesiswaan.'. strtolower($menu) .'.destroy', [$item->ph_id])}}" >
                                                @method('delete')
                                                @csrf   
                                                <button type="button" class="btn btn-sm btn-danger btn-delete-permanent" title="Delete" data-toggle="modal" data-target="#deletePermanentModal"><i class="fa fa-trash"></i></button>
                                            </form>
                                        @else
                                            <a href="{{ route('admin.kesiswaan.'. strtolower($menu) .'.edit', [$item->ph_id])}}" class="btn btn-sm btn-warning text-light" title="Edit"><i class="fa fa-pencil"></i></a>
                                            <form class="d-inline" method="POST" action="{{route('admin.kesiswaan.'. strtolower($menu) .'.destroyrecycle', [$item->ph_id])}}" >
                                                @method('delete')
                                                @csrf   
                                                <button type="button" class="btn btn-sm btn-danger btn-delete-recycle" title="Delete" data-toggle="modal" data-target="#deleteRecycleModal"><i class="fa fa-trash"></i></button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            {{$penghargaan->appends(Request::all())->links()}}
                        </tfoot>
                        @elseif ($menu == 'Ekstrakurikuler')
                        <tbody>
                            @foreach ($ekstrakurikuler as $index => $item)
                                @if (Request::get('status') != 'hapus' && $item->e_status == 'hapus')
                                    @continue
                                @endif
                                @if (auth()->user()->role == 'guru' && $item->e_create_id != auth()->user()->id)
                                    @continue
                                @endif
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{$item->e_judul_slide}}</td>
                                    <td>{{$item->e_deskripsi_slide}}</td>
                                    <td>
                                        @if($item->e_foto_slide1)
                                            <img src="{{ asset('kesiswaan_image/slide_image/' . $item->e_foto_slide1) }}" alt="Foto Slide 1" width="50">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->e_foto_slide2)
                                            <img src="{{ asset('kesiswaan_image/slide_image/' . $item->e_foto_slide2) }}" alt="Foto Slide 2" width="50">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->e_foto_slide3)
                                            <img src="{{ asset('kesiswaan_image/slide_image/' . $item->e_foto_slide3) }}" alt="Foto Slide 3" width="50">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td>{{$item->e_nama_ekstrakurikuler}}</td>
                                    <td>{{$item->e_deskripsi}}</td>
                                    <td>
                                        @if($item->e_foto)
                                        <img src="{{ asset('kesiswaan_image/'. strtolower($menu) .'_image/' . $item->e_foto) }}" alt="Foto" width="50">
                                        @else
                                        No Image
                                        @endif
                                    </td>
                                    @if ($item->e_status == 'TIDAK')
                                        <td>{{$item->e_status}} Disetujui</td>
                                    @else
                                        <td>{{$item->e_status}}</td>    
                                    @endif
                                    <td>
                                        @if ($item->e_status == 'HAPUS')
                                            <form class="d-inline" method="POST" action="{{route('admin.kesiswaan.'. strtolower($menu) .'.restore', [$item->e_id])}}">
                                                @csrf   
                                                <button type="button" class="btn btn-sm btn-success btn-restore" title="Restore" data-toggle="modal" data-target="#restoreModal"><i class="fa fa-undo"></i></button>
                                            </form>
                                            <form class="d-inline" method="POST" action="{{route('admin.kesiswaan.'. strtolower($menu) .'.destroy', [$item->e_id])}}" >
                                                @method('delete')
                                                @csrf   
                                                <button type="button" class="btn btn-sm btn-danger btn-delete-permanent" title="Delete" data-toggle="modal" data-target="#deletePermanentModal"><i class="fa fa-trash"></i></button>
                                            </form>
                                        @else
                                            <a href="{{ route('admin.kesiswaan.'. strtolower($menu) .'.edit', [$item->e_id])}}" class="btn btn-sm btn-warning text-light" title="Edit"><i class="fa fa-pencil"></i></a>
                                            <form class="d-inline" method="POST" action="{{route('admin.kesiswaan.'. strtolower($menu) .'.destroyrecycle', [$item->e_id])}}" >
                                                @method('delete')
                                                @csrf   
                                                <button type="button" class="btn btn-sm btn-danger btn-delete-recycle" title="Delete" data-toggle="modal" data-target="#deleteRecycleModal"><i class="fa fa-trash"></i></button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            {{$ekstrakurikuler->appends(Request::all())->links()}}
                        </tfoot>
                        @elseif ($menu == 'Tatatertib')
                        <tbody>
                            @foreach ($tatatertib as $index => $item)
                                @if (Request::get('status') != 'hapus' && $item->t_status == 'hapus')
                                    @continue
                                @endif
                                @if (auth()->user()->role == 'guru' && $item->t_create_id != auth()->user()->id)
                                    @continue
                                @endif
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{$item->t_nama_peraturan}}</td>
                                    <td>{{$item->t_deskripsi}}</td>
                                    @if ($item->t_status == 'TIDAK')
                                        <td>{{$item->t_status}} Disetujui</td>
                                    @else
                                        <td>{{$item->t_status}}</td>    
                                    @endif
                                    <td>
                                        @if ($item->t_status == 'HAPUS')
                                            <form class="d-inline" method="POST" action="{{route('admin.kesiswaan.'. strtolower($menu) .'.restore', [$item->t_id])}}">
                                                @csrf   
                                                <button type="button" class="btn btn-sm btn-success btn-restore" title="Restore" data-toggle="modal" data-target="#restoreModal"><i class="fa fa-undo"></i></button>
                                            </form>
                                            <form class="d-inline" method="POST" action="{{route('admin.kesiswaan.'. strtolower($menu) .'.destroy', [$item->t_id])}}" >
                                                @method('delete')
                                                @csrf   
                                                <button type="button" class="btn btn-sm btn-danger btn-delete-permanent" title="Delete" data-toggle="modal" data-target="#deletePermanentModal"><i class="fa fa-trash"></i></button>
                                            </form>
                                        @else
                                            <a href="{{ route('admin.kesiswaan.'. strtolower($menu) .'.edit', [$item->t_id])}}" class="btn btn-sm btn-warning text-light" title="Edit"><i class="fa fa-pencil"></i></a>
                                            <form class="d-inline" method="POST" action="{{route('admin.kesiswaan.'. strtolower($menu) .'.destroyrecycle', [$item->t_id])}}" >
                                                @method('delete')
                                                @csrf   
                                                <button type="button" class="btn btn-sm btn-danger btn-delete-recycle" title="Delete" data-toggle="modal" data-target="#deleteRecycleModal"><i class="fa fa-trash"></i></button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            {{$tatatertib->appends(Request::all())->links()}}
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Restore --}}
    <div class="modal fade" id="restoreModal" tabindex="-1" role="dialog" aria-labelledby="restoreModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="restoreModalLabel">Confirm Restore</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda Yakin Akan Pulihkan Data Ini Dan Di Simpan Ke Draft?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="confirmRestore">Restore</button>
                </div>
            </div>
        </div>
    </div>


    {{-- Modal Delete Recycle --}}
    <div class="modal fade" id="deleteRecycleModal" tabindex="-1" role="dialog" aria-labelledby="deleteRecycleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteRecycleModalLabel">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda Yakin Akan Hapus Data Ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteRecycle">Delete</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Delete Permanent --}}
    <div class="modal fade" id="deletePermanentModal" tabindex="-1" role="dialog" aria-labelledby="deletePermanentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePermanentModalLabel">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda Yakin Akan Hapus Data Ini Secara Permanent?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeletePermanent">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let deleteForm;
            document.querySelectorAll('.btn-delete-recycle').forEach(button => {
                button.addEventListener('click', function (event) {
                    event.preventDefault();
                    deleteForm = this.closest('form');
                    $('#deleteRecycleModal').modal('show');
                });
            });

            document.querySelectorAll('.btn-delete-permanent').forEach(button => {
                button.addEventListener('click', function (event) {
                    event.preventDefault();
                    deleteForm = this.closest('form');
                    $('#deletePermanentModal').modal('show');
                });
            });

            document.querySelectorAll('.btn-restore').forEach(button => {
                button.addEventListener('click', function (event) {
                    event.preventDefault();
                    deleteForm = this.closest('form');
                    $('#restoreModal').modal('show');
                });
            });

            document.getElementById('confirmDeleteRecycle').addEventListener('click', function () {
                deleteForm.submit();
            });

            document.getElementById('confirmDeletePermanent').addEventListener('click', function () {
                deleteForm.submit();
            });

            document.getElementById('confirmRestore').addEventListener('click', function () {
                deleteForm.submit();
            });
        });
    </script>
@endsection

@section('script')
    
@endsection
