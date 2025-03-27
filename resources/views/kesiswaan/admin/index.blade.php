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
                                    <input name="k_keyword" type="text" value="{{Request::get('k_keyword')}}" class="form-control" placeholder="Filter by judul" oninput="filterKesiswaanTable()">
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
                    <div class="d-flex justify-content-end mb-3">
                        <select id="rowsPerPage" class="form-control form-control-sm" style="width: auto; display: inline-block;">
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="all">All</option>
                        </select>
                        <span class="ml-2">Rows per page</span>
                    </div>
                    <table class="table" id="dataTable">
                        <thead class="text-light" style="background-color:#33b751 !important">
                            <tr>
                                <th width="12px">No</th>
                                <th class="text-center">Judul Slide</th>
                                <th class="text-center">Deskripsi Slide</th>
                                <th class="text-center">Judul Isi Content</th>
                                <th class="text-center">Foto Slide 1</th>
                                <th class="text-center">Foto Slide 2</th>
                                <th class="text-center">Foto Slide 3</th>
                                <th class="text-center">Status</th>
                                <th width="88px">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @foreach ($kesiswaan as $index => $item)
                                @if (Request::get('k_status') != 'hapus' && $item->k_status == 'hapus')
                                    @continue
                                @endif
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="filterable">{{ $item->k_judul_slide }}</td>
                                    <td class="filterable">{{ $item->k_deskripsi_slide }}</td>
                                    <td class="filterable">{{ $item->k_judul_isi_content }}</td>
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
                                        <td>{{ $item->k_status }} Disetujui</td>
                                    @else
                                        <td>{{ $item->k_status }}</td>
                                    @endif
                                    <td>
                                        @if ($item->k_status == 'HAPUS')
                                            <form class="d-inline" method="POST" action="{{ route('admin.kesiswaan.kesiswaan.restore', [$item->k_id]) }}">
                                                @csrf
                                                <button type="button" class="btn btn-sm btn-success btn-restore" title="Restore" data-toggle="modal" data-target="#restoreModal"><i class="fa fa-undo"></i></button>
                                            </form>
                                            <form class="d-inline" method="POST" action="{{ route('admin.kesiswaan.kesiswaan.destroy', [$item->k_id]) }}">
                                                @method('delete')
                                                @csrf
                                                <button type="button" class="btn btn-sm btn-danger btn-delete-permanent" title="Delete" data-toggle="modal" data-target="#deletePermanentModal"><i class="fa fa-trash"></i></button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.kesiswaan.kesiswaan.edit', [$item->k_id]) }}" method="GET" class="d-inline">
                                                <input type="text" name="menu" id="menu" placeholder="Nama Menu..." class="form-control {{ $errors->first('menu') ? 'is-invalid' : '' }}" value="{{ $menu }}" required hidden>
                                                <button type="submit" class="btn btn-sm btn-warning text-light" title="Edit"><i class="fa fa-pencil"></i></button>
                                            </form>
                                            <form class="d-inline" method="POST" action="{{ route('admin.kesiswaan.kesiswaan.destroyrecycle', [$item->k_id]) }}">
                                                @method('delete')
                                                @csrf
                                                <button type="button" class="btn btn-sm btn-danger btn-delete-recycle" title="Delete" data-toggle="modal" data-target="#deleteRecycleModal"><i class="fa fa-trash"></i></button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <div>
                            <p>Total Data: <span id="totalData">{{ $kesiswaan->count() }}</span></p>
                        </div>
                        <div id="paginationControls" class="pagination d-flex align-items-center">
                            <button id="prevPage" class="btn btn-sm btn-light mr-2">Previous</button>
                            <div id="pageNumbers" class="d-flex"></div>
                            <button id="nextPage" class="btn btn-sm btn-light ml-2">Next</button>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const tableBody = document.getElementById('tableBody');
                            const rowsPerPageSelect = document.getElementById('rowsPerPage');
                            const paginationControls = document.getElementById('paginationControls');
                            const totalData = document.getElementById('totalData').textContent;
                            const rows = Array.from(tableBody.querySelectorAll('tr'));
                            let rowsPerPage = parseInt(rowsPerPageSelect.value);
                            let currentPage = 1;

                            function renderTable() {
                                const start = (currentPage - 1) * rowsPerPage;
                                const end = rowsPerPage === 'all' ? rows.length : start + rowsPerPage;

                                rows.forEach((row, index) => {
                                    row.style.display = index >= start && index < end ? '' : 'none';
                                });

                                renderPagination();
                            }

                            function renderPagination() {
                                const totalPages = rowsPerPage === 'all' ? 1 : Math.ceil(rows.length / rowsPerPage);
                                const prevButton = document.getElementById('prevPage');
                                const nextButton = document.getElementById('nextPage');
                                const pageNumbersContainer = document.getElementById('pageNumbers');

                                pageNumbersContainer.innerHTML = '';

                                for (let i = 1; i <= totalPages; i++) {
                                    const button = document.createElement('button');
                                    button.textContent = i;
                                    button.className = 'btn btn-sm ' + (i === currentPage ? 'btn-primary' : 'btn-light');
                                    button.addEventListener('click', () => {
                                        currentPage = i;
                                        renderTable();
                                    });
                                    pageNumbersContainer.appendChild(button);
                                }

                                prevButton.disabled = currentPage === 1;
                                nextButton.disabled = currentPage === totalPages;

                                prevButton.addEventListener('click', () => {
                                    if (currentPage > 1) {
                                        currentPage--;
                                        renderTable();
                                    }
                                });

                                nextButton.addEventListener('click', () => {
                                    if (currentPage < totalPages) {
                                        currentPage++;
                                        renderTable();
                                    }
                                });
                            }

                            rowsPerPageSelect.addEventListener('change', function () {
                                rowsPerPage = this.value === 'all' ? rows.length : parseInt(this.value);
                                currentPage = 1;
                                renderTable();
                            });

                            renderTable();
                        });

                        function filterTable() {
                            const input = document.querySelector('input[name="k_keyword"]');
                            const filter = input.value.toLowerCase();
                            const rows = document.querySelectorAll('#dataTable tbody tr');

                            rows.forEach(row => {
                                const cells = row.querySelectorAll('.filterable');
                                const match = Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(filter));
                                row.style.display = match ? '' : 'none';
                            });
                        }
                    </script>
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
                                    <input name="keyword" type="text" value="{{ Request::get('keyword') }}" class="form-control" placeholder="Filter by title" oninput="filterMediaTable()">
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
                    <div class="d-flex justify-content-end mb-3">
                        <select id="rowsPerPage" class="form-control form-control-sm" style="width: auto; display: inline-block;">
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="all">All</option>
                        </select>
                        <span class="ml-2">Rows per page</span>
                    </div>
                    <table class="table" id="mediaTable">
                        <thead class="text-light" style="background-color:#33b751 !important">
                            <tr>
                                <th width="12px">No</th>
                                @if ($menu == 'Ekstrakurikuler' || $menu == 'Strukturorganisasi')
                                <th class="text-center">Judul Slide</th>
                                <th class="text-center">Deskripsi Slide</th>
                                    @if ($menu == 'Strukturorganisasi')
                                        <th class="text-center">Foto Slide</th>
                                    @endif
                                    @if ($menu == 'Ekstrakurikuler')
                                        <th class="text-center">Foto Slide 1</th>
                                        <th class="text-center">Foto Slide 2</th>
                                        <th class="text-center">Foto Slide 3</th>
                                    @endif
                                @endif
                                <th class="text-center">
                                    Nama 
                                    @if ($menu == 'Pembiasaan')
                                        Kegiatan
                                    @elseif ($menu == 'Penghargaan')
                                        Penghargaan
                                    @elseif ($menu == 'Ekstrakurikuler')
                                        Ekstrakurikuler
                                    @elseif ($menu == 'Strukturorganisasi')
                                        Strukturorganisasi
                                    @endif
                                </th>
                                @if ($menu == 'Strukturorganisasi')
                                <th class="text-center">
                                    Foto Strukturorganisasi
                                </th>
                                @endif
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
                        <tbody id="tableBody">
                            @php
                                $filteredpembiasaan = $pembiasaan->filter(function ($item) {
                                    return auth()->user()->role !== 'guru' || auth()->user()->id === $item->p_create_id;
                                });
                            @endphp
                            @foreach ($filteredpembiasaan as $item)
                            {{-- @foreach ($pembiasaan as $index => $item) --}}
                                @if (Request::get('status') != 'hapus' && $item->p_status == 'hapus')
                                    @continue
                                @endif
                                @if (auth()->user()->role == 'guru' && $item->p_create_id != auth()->user()->id)
                                    @continue
                                @endif
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td class="filterable">{{$item->p_nama_kegiatan}}</td>
                                    <td class="filterable">{{ Str::limit($item->p_deskripsi, 100) }}</td>
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
                        @elseif ($menu == 'Penghargaan')
                        <tbody id="tableBody">
                            @php
                                $filteredpenghargaan = $penghargaan->filter(function ($item) {
                                    return auth()->user()->role !== 'guru' || auth()->user()->id === $item->ph_create_id;
                                });
                            @endphp
                            @foreach ($filteredpenghargaan as $item)
                            {{-- @foreach ($penghargaan as $index => $item) --}}
                                @if (Request::get('status') != 'hapus' && $item->ph_status == 'hapus')
                                    @continue
                                @endif
                                @if (auth()->user()->role == 'guru' && $item->ph_create_id != auth()->user()->id)
                                    @continue
                                @endif
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td class="filterable">{{$item->ph_nama_kegiatan}}</td>
                                    <td>
                                        @php
                                            $ekskul = $ekstrakurikuler->firstWhere('e_id', $item->e_id);
                                        @endphp
                                        {{$ekskul ? $ekskul->e_nama_ekstrakurikuler : 'No Ekstrakurikuler'}}
                                    </td>
                                    <td class="filterable">{{ Str::limit($item->ph_deskripsi, 100) }}</td>
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
                        @elseif ($menu == 'Ekstrakurikuler')
                        <tbody id="tableBody">
                            @foreach ($ekstrakurikuler as $index => $item)
                                @if (Request::get('status') != 'hapus' && $item->e_status == 'hapus')
                                    @continue
                                @endif
                                @if (auth()->user()->role == 'guru' && $item->e_create_id != auth()->user()->id)
                                    @continue
                                @endif
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td class="filterable">{{$item->e_judul_slide}}</td>
                                    <td class="filterable">{{ Str::limit($item->e_deskripsi_slide, 30) }}</td>
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
                                    <td>{{ Str::limit($item->e_deskripsi, 100) }}</td>
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
                        @elseif ($menu == 'Tatatertib')
                        <tbody id="tableBody">
                            @foreach ($tatatertib as $index => $item)
                                @if (Request::get('status') != 'hapus' && $item->t_status == 'hapus')
                                    @continue
                                @endif
                                @if (auth()->user()->role == 'guru' && $item->t_create_id != auth()->user()->id)
                                    @continue
                                @endif
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td class="filterable">{{$item->t_nama_peraturan}}</td>
                                    <td class="filterable">{{ Str::limit($item->t_deskripsi, 100) }}</td>
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
                        @elseif ($menu == 'Strukturorganisasi')
                        <tbody id="tableBody">
                            @foreach ($strukturorganisasi as $index => $item)
                                @if (Request::get('status') != 'hapus' && $item->so_status == 'hapus')
                                    @continue
                                @endif
                                @if (auth()->user()->role == 'guru' && $item->so_create_id != auth()->user()->id)
                                    @continue
                                @endif
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td class="filterable">{{$item->so_judul_slide}}</td>
                                    <td class="filterable">{{ Str::limit($item->so_deskripsi_slide, 30) }}</td>
                                    <td>
                                        @if($item->so_foto_slide)
                                            <img src="{{ asset('strukturorganisasi_image/slide_image/' . $item->so_foto_slide) }}" alt="Foto Slide" width="50">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td class="filterable">{{$item->so_judul_content}}</td>
                                    <td>
                                        @if($item->so_foto_atau_pdf)
                                            @php
                                                $extension = pathinfo($item->so_foto_atau_pdf, PATHINFO_EXTENSION);
                                            @endphp
                                            @if(in_array(strtolower($extension), ['jpeg', 'jpg', 'png']))
                                                <img src="{{ asset('strukturorganisasi_image/foto_image/' . $item->so_foto_atau_pdf) }}" alt="Foto" width="50">
                                            @elseif(strtolower($extension) === 'pdf')
                                                @if(auth()->check())
                                                    <a href="{{ route('strukturorganisasi.file', $item->so_foto_atau_pdf) }}" target="_blank">View PDF</a>
                                                @else
                                                    <span>Login required to view PDF</span>
                                                @endif
                                            @else
                                                No File
                                            @endif
                                        @else
                                            No File
                                        @endif
                                    </td>
                                    <td class="filterable">{{ Str::limit($item->so_deskripsi, 100) }}</td>
                                    @if ($item->so_status == 'TIDAK')
                                        <td>{{$item->so_status}} Disetujui</td>
                                    @else
                                        <td>{{$item->so_status}}</td>    
                                    @endif
                                    <td>
                                        @if ($item->so_status == 'HAPUS')
                                            <form class="d-inline" method="POST" action="{{route('admin.kesiswaan.'. strtolower($menu) .'.restore', [$item->so_id])}}">
                                                @csrf   
                                                <button type="button" class="btn btn-sm btn-success btn-restore" title="Restore" data-toggle="modal" data-target="#restoreModal"><i class="fa fa-undo"></i></button>
                                            </form>
                                            <form class="d-inline" method="POST" action="{{route('admin.kesiswaan.'. strtolower($menu) .'.destroy', [$item->so_id])}}" >
                                                @method('delete')
                                                @csrf   
                                                <button type="button" class="btn btn-sm btn-danger btn-delete-permanent" title="Delete" data-toggle="modal" data-target="#deletePermanentModal"><i class="fa fa-trash"></i></button>
                                            </form>
                                        @else
                                            <a href="{{ route('admin.kesiswaan.'. strtolower($menu) .'.edit', [$item->so_id])}}" class="btn btn-sm btn-warning text-light" title="Edit"><i class="fa fa-pencil"></i></a>
                                            <form class="d-inline" method="POST" action="{{route('admin.kesiswaan.'. strtolower($menu) .'.destroyrecycle', [$item->so_id])}}" >
                                                @method('delete')
                                                @csrf   
                                                <button type="button" class="btn btn-sm btn-danger btn-delete-recycle" title="Delete" data-toggle="modal" data-target="#deleteRecycleModal"><i class="fa fa-trash"></i></button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        @endif
                    </table>
                    {{-- Pagination --}}
                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <div>
                            <p>Total Data: <span id="totalData">
                                @if ($menu == 'Pembiasaan')
                                    {{ $filteredpembiasaan->count() }}
                                @elseif ($menu == 'Penghargaan')
                                    {{ $filteredpenghargaan->count() }}
                                @elseif ($menu == 'Ekstrakurikuler')
                                    {{ $ekstrakurikuler->count() }}
                                @elseif ($menu == 'Strukturorganisasi')
                                    {{ $strukturorganisasi->count() }}
                                @elseif ($menu == 'Tatatertib')
                                    {{ $tatatertib->count() }}
                                @endif
                            </span></p>
                        </div>
                        <div id="paginationControls" class="pagination d-flex align-items-center">
                            <button id="prevPage" class="btn btn-sm btn-light mr-2">Previous</button>
                            <div id="pageNumbers" class="d-flex"></div>
                            <button id="nextPage" class="btn btn-sm btn-light ml-2">Next</button>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const tableBody = document.getElementById('tableBody');
                            const rowsPerPageSelect = document.getElementById('rowsPerPage');
                            const paginationControls = document.getElementById('paginationControls');
                            const totalData = document.getElementById('totalData').textContent;
                            const rows = Array.from(tableBody.querySelectorAll('tr'));
                            let rowsPerPage = parseInt(rowsPerPageSelect.value);
                            let currentPage = 1;

                            function renderTable() {
                                const start = (currentPage - 1) * rowsPerPage;
                                const end = rowsPerPage === 'all' ? rows.length : start + rowsPerPage;

                                rows.forEach((row, index) => {
                                    row.style.display = index >= start && index < end ? '' : 'none';
                                });

                                renderPagination();
                            }

                            function renderPagination() {
                                const totalPages = rowsPerPage === 'all' ? 1 : Math.ceil(rows.length / rowsPerPage);
                                const prevButton = document.getElementById('prevPage');
                                const nextButton = document.getElementById('nextPage');
                                const pageNumbersContainer = document.getElementById('pageNumbers');

                                pageNumbersContainer.innerHTML = '';

                                for (let i = 1; i <= totalPages; i++) {
                                    const button = document.createElement('button');
                                    button.textContent = i;
                                    button.className = 'btn btn-sm ' + (i === currentPage ? 'btn-primary' : 'btn-light');
                                    button.addEventListener('click', () => {
                                        currentPage = i;
                                        renderTable();
                                    });
                                    pageNumbersContainer.appendChild(button);
                                }

                                prevButton.disabled = currentPage === 1;
                                nextButton.disabled = currentPage === totalPages;

                                prevButton.addEventListener('click', () => {
                                    if (currentPage > 1) {
                                        currentPage--;
                                        renderTable();
                                    }
                                });

                                nextButton.addEventListener('click', () => {
                                    if (currentPage < totalPages) {
                                        currentPage++;
                                        renderTable();
                                    }
                                });
                            }

                            rowsPerPageSelect.addEventListener('change', function () {
                                rowsPerPage = this.value === 'all' ? rows.length : parseInt(this.value);
                                currentPage = 1;
                                renderTable();
                            });

                            renderTable();
                        });

                        function filterTable() {
                            const input = document.querySelector('input[name="k_keyword"]');
                            const filter = input.value.toLowerCase();
                            const rows = document.querySelectorAll('#dataTable tbody tr');

                            rows.forEach(row => {
                                const cells = row.querySelectorAll('.filterable');
                                const match = Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(filter));
                                row.style.display = match ? '' : 'none';
                            });
                        }
                    </script>
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
