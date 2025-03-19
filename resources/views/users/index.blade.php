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
                                    <a class="nav-link p-2 px-3 {{Request::get('role') == NULL ? 'active' : ''}}" href="{{route('admin.'. strtolower($menu) .'.index')}}">All</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2 px-3 {{Request::get('role') == 'admin' ?'active' : '' }}" href="{{route('admin.'. strtolower($menu) .'.index', ['role' =>'admin'])}}">Admin</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2 px-3 {{Request::get('role') == 'guru' ?'active' : '' }}" href="{{route('admin.'. strtolower($menu) .'.index', ['role' =>'guru'])}}">Guru</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-5">
                            <form action="{{route('admin.'. strtolower($menu) .'.index')}}">
                                <div class="input-group">
                                    <input name="p_keyword" type="text" value="{{Request::get('p_keyword')}}" class="form-control" placeholder="Filter by title" oninput="filterUserTable()">
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
                    <table class="table" id="userTable">
                        <thead class="text-light" style="background-color:#33b751 !important">
                            <tr>
                                <th width="12px">No</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Role</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Foto</th>
                                <th width="88px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="filterable">{{ $item->name }}</td>
                                    <td class="filterable">{{ ucfirst($item->role) }}</td>
                                    <td class="filterable">{{ $item->email }}</td>
                                    <td class="text-center">
                                        @if ($item->foto)
                                            <img src="{{ asset('users_foto/' . $item->foto) }}" alt="Foto" width="50" class="rounded-circle">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.'. strtolower($menu) .'.edit', $item->id) }}" method="GET" class="d-inline">
                                            <input type="text" name="menu" id="menu" placeholder="Nama Menu..." class="form-control {{$errors->first('menu') ? "is-invalid" : ""}}" value="{{$menu}}" required hidden>
                                            <button type="submit" class="btn btn-sm btn-warning text-light" title="Edit"><i class="fa fa-pencil"></i></button>
                                        </form>
                                        <form class="d-inline" method="POST" action="{{ route('admin.'. strtolower($menu) .'.destroy', $item->id) }}">
                                            @method('DELETE')
                                            @csrf
                                            <button type="button" class="btn btn-sm btn-danger btn-delete-permanent" title="Delete" data-toggle="modal" data-target="#deletePermanentModal"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <script>
                        function filterUserTable() {
                            const input = document.querySelector('input[name="p_keyword"]');
                            const filter = input.value.toLowerCase();
                            const rows = document.querySelectorAll('#userTable tbody tr');

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
