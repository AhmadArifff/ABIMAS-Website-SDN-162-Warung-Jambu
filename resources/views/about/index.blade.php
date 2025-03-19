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
    <div class="row">
        <div class="col-md-12">
            <div class="card">
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
                                    <a class="nav-link p-2 px-3 {{Request::get('-isi-slide-status') == NULL ? 'active' : ''}}" href="{{route('admin.'. strtolower($menu) .'.index')}}">All</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2 px-3 {{Request::get('-isi-slide-status') == 'publish' ?'active' : '' }}" href="{{route('admin.'. strtolower($menu) .'.index', ['-isi-slide-status' =>'publish'])}}">Publish</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2 px-3 {{Request::get('-isi-slide-status') == 'draft' ?'active' : '' }}" href="{{route('admin.'. strtolower($menu) .'.index', ['-isi-slide-status' =>'draft'])}}">Draft</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2 px-3 {{Request::get('-isi-slide-status') == 'hapus' ?'active' : '' }}" href="{{route('admin.'. strtolower($menu) .'.index', ['-isi-slide-status' =>'hapus'])}}">Delete</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2 px-3 {{Request::get('-isi-slide-status') == 'tidak' ?'active' : '' }}" href="{{route('admin.'. strtolower($menu) .'.index', ['-isi-slide-status' =>'tidak'])}}">Tidak Disetujui</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-5">
                            <form action="{{route('admin.'. strtolower($menu) .'.index')}}">
                                <div class="input-group">
                                    <input name="k_keyword" type="text" value="{{Request::get('k_keyword')}}" class="form-control" placeholder="Filter by judul" oninput="filterTable()">
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
                        <tbody>
                            @foreach ($kesiswaan as $index => $item)
                                @if (Request::get('k_status') != 'hapus' && $item->k_status == 'hapus')
                                    @continue
                                @endif
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td class="filterable">{{$item->k_judul_slide}}</td>
                                    <td class="filterable">{{$item->k_deskripsi_slide}}</td>
                                    <td class="filterable">{{$item->k_judul_isi_content}}</td>
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

                    <script>
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

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    
                    {{-- Title 2 --}}
                    <h3>Manage Isi Content {{$menu}}</h3>
                    
                    {{-- button create --}}
                    <div class="mb-5 text-right">
                        <form action="{{ route('admin.'. strtolower($menu) .'.create') }}" method="GET" class="d-inline">
                            <input type="text" name="menu" id="menu" placeholder="Nama Menu..." class="form-control {{$errors->first('menu') ? "is-invalid" : ""}}" value="{{$menu}}" required hidden>
                            <button type="submit" class="btn btn-sm btn-success mt-2"> <i class="fa fa-plus"></i> Create</button>
                        </form>
                    </div>

                    {{-- display filter --}}
                    <div class="row mb-3">
                        <div class="col-sm-7">
                            <ul class="nav nav-tabs ">
                                <li class="nav-item">
                                    <a class="nav-link p-2 px-3 {{Request::get('-isi-content-status') == NULL ? 'active' : ''}}" href="{{route('admin.'. strtolower($menu) .'.index')}}">All</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2 px-3 {{Request::get('-isi-content-status') == 'publish' ?'active' : '' }}" href="{{route('admin.'. strtolower($menu) .'.index', ['-isi-content-status' =>'publish'])}}">Publish</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2 px-3 {{Request::get('-isi-content-status') == 'draft' ?'active' : '' }}" href="{{route('admin.'. strtolower($menu) .'.index', ['-isi-content-status' =>'draft'])}}">Draft</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2 px-3 {{Request::get('-isi-content-status') == 'hapus' ?'active' : '' }}" href="{{route('admin.'. strtolower($menu) .'.index', ['-isi-content-status' =>'hapus'])}}">Delete</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-5">
                            <form action="{{route('admin.'. strtolower($menu) .'.index')}}">
                                <div class="input-group">
                                    <input name="p_keyword" type="text" value="{{Request::get('p_keyword')}}" class="form-control" placeholder="Filter by title" oninput="filterAboutTable()">
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

                    {{-- table --}}
                    <table class="table" id="aboutTable">
                        <thead class="text-light" style="background-color:#33b751 !important">
                            <tr>
                                <th width="12px">No</th>
                                <th class="text-center">Visi</th>
                                <th class="text-center">Misi</th>
                                <th class="text-center">Sejarah</th>
                                <th class="text-center">Status</th>
                                <th width="88px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($about as $index => $item)
                                @if (Request::get('a_status') != 'hapus' && $item->a_status == 'hapus')
                                    @continue
                                @endif
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td class="filterable">{{$item->a_visi}}</td>
                                    <td class="filterable">{{$item->a_misi}}</td>
                                    <td class="filterable">
                                        @foreach ($aboutSejarah_all as $sejarah)
                                            @if ($sejarah->as_id == $item->as_id)
                                                {{$sejarah->as_sejarah}}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{$item->a_status}}</td>
                                    <td>
                                        @if ($item->a_status == 'HAPUS')
                                            <form class="d-inline" method="POST" action="{{route('admin.about.restore', [$item->a_id])}}">
                                                @csrf   
                                                <button type="button" class="btn btn-sm btn-success btn-restore" title="Restore" data-toggle="modal" data-target="#restoreModal"><i class="fa fa-undo"></i></button>
                                            </form>
                                            <form class="d-inline" method="POST" action="{{route('admin.about.destroy', [$item->a_id])}}" >
                                                @method('delete')
                                                @csrf   
                                                <button type="button" class="btn btn-sm btn-danger btn-delete-permanent" title="Delete" data-toggle="modal" data-target="#deletePermanentModal"><i class="fa fa-trash"></i></button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.about.edit', [$item->a_id]) }}" method="GET" class="d-inline">
                                                <button type="submit" class="btn btn-sm btn-warning text-light" title="Edit"><i class="fa fa-pencil"></i></button>
                                            </form>
                                            <form class="d-inline" method="POST" action="{{route('admin.about.destroyrecycle', [$item->a_id])}}" >
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
                            {{$about->appends(Request::all())->links()}}
                        </tfoot>
                    </table>

                    <script>
                        function filterAboutTable() {
                            const input = document.querySelector('input[name="p_keyword"]');
                            const filter = input.value.toLowerCase();
                            const rows = document.querySelectorAll('#aboutTable tbody tr');

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
