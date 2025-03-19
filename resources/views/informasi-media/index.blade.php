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
                    <h3>Manage Isi Content Tautan</h3>
                    
                    {{-- button create --}}
                    <div class="mb-5 text-right">
                        <form action="{{ route('admin.informasi-media.create') }}" method="GET" class="d-inline">
                            <input type="text" name="menu" id="menu" placeholder="Nama Menu..." class="form-control {{$errors->first('menu') ? "is-invalid" : ""}}" value="Tautan" required hidden>
                            <button type="submit" class="btn btn-sm btn-success mt-2" {{ $tautan->count() >= 9 ? 'disabled' : '' }}> <i class="fa fa-plus"></i> Create</button>
                        </form>
                    </div>

                    {{-- display filter --}}
                    <div class="row mb-3">
                        <div class="col-sm-7"></div>
                        <div class="col-sm-5">
                            <form action="{{ route('admin.informasi-media.index') }}">
                                <input type="hidden" name="menu" value="{{ $menu }}">
                                <div class="input-group">
                                    <input name="p_keyword" type="text" value="{{ Request::get('p_keyword') }}" class="form-control" placeholder="Filter by title" oninput="filterTautanTable()">
                                    <div class="input-group-append">
                                        <input type="submit" value="Filter" class="btn btn-info">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- alert --}}
                    @if (session('success-isi-content-Tautan'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{session('success-isi-content-Tautan')}}.
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
                    <table class="table" id="tautanTable">
                        <thead class="text-light" style="background-color:#33b751 !important">
                            <tr>
                                <th width="12px">No</th>
                                <th class="text-center">Nama Tautan</th>
                                <th class="text-center">URL</th>
                                <th width="88px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tautan as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="filterable">{{ $item->tt_nama_tautan }}</td>
                                    <td class="filterable">{{ $item->tt_url }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.informasi-media.edit', $item->tt_id) }}" method="GET" class="d-inline">
                                            <input type="text" name="menu" id="menu" placeholder="Nama Menu..." class="form-control {{$errors->first('menu') ? "is-invalid" : ""}}" value="Tautan" required hidden>
                                            <button type="submit" class="btn btn-sm btn-warning text-light" title="Edit"><i class="fa fa-pencil"></i></button>
                                        </form>
                                        <form class="d-inline" method="POST" action="{{ route('admin.informasi-media.destroy', $item->tt_id) }}">
                                            @method('DELETE')
                                            @csrf
                                            <input type="hidden" name="menu" value="Tautan">
                                            <button type="button" class="btn btn-sm btn-danger btn-delete-permanent" title="Delete" data-toggle="modal" data-target="#deletePermanentModal"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <script>
                        function filterTautanTable() {
                            const input = document.querySelector('input[name="p_keyword"]');
                            const filter = input.value.toLowerCase();
                            const rows = document.querySelectorAll('#tautanTable tbody tr');

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
                    <h3>Manage Isi Content Media Sosial</h3>
                    
                    {{-- button create --}}
                    <div class="mb-5 text-right">
                        <form action="{{ route('admin.informasi-media.create') }}" method="GET" class="d-inline">
                            <input type="text" name="menu" id="menu" placeholder="Nama Menu..." class="form-control {{$errors->first('menu') ? "is-invalid" : ""}}" value="Media" required hidden>
                            <button type="submit" class="btn btn-sm btn-success mt-2" {{ $mediasosial->count() >= 4 ? 'disabled' : '' }}> <i class="fa fa-plus"></i> Create</button>
                        </form>
                    </div>

                    {{-- display filter --}}
                    <div class="row mb-3">
                        <div class="col-sm-7"></div>
                        <div class="col-sm-5">
                            <form action="{{ route('admin.informasi-media.index') }}">
                                <input type="hidden" name="menu" value="{{ $menu }}">
                                <div class="input-group">
                                    <input name="p_keyword" type="text" value="{{ Request::get('p_keyword') }}" class="form-control" placeholder="Filter by title" oninput="filterMediaTable()">
                                    <div class="input-group-append">
                                        <input type="submit" value="Filter" class="btn btn-info">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- alert --}}
                    @if (session('success-isi-content-Media'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{session('success-isi-content-Media')}}.
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
                    <table class="table" id="mediaTable">
                        <thead class="text-light" style="background-color:#33b751 !important">
                            <tr>
                                <th width="12px">No</th>
                                <th class="text-center">Nama Media</th>
                                <th class="text-center">URL</th>
                                <th width="88px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mediasosial as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="filterable">{{ $item->ms_nama_media }}</td>
                                    <td class="filterable">{{ $item->ms_url }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.informasi-media.edit', $item->ms_id) }}" method="GET" class="d-inline">
                                            <input type="text" name="menu" id="menu" placeholder="Nama Menu..." class="form-control {{$errors->first('menu') ? "is-invalid" : ""}}" value="Media" required hidden>
                                            <button type="submit" class="btn btn-sm btn-warning text-light" title="Edit"><i class="fa fa-pencil"></i></button>
                                        </form>
                                        <form class="d-inline" method="POST" action="{{ route('admin.informasi-media.destroy', $item->ms_id) }}">
                                            @method('DELETE')
                                            @csrf
                                            <input type="hidden" name="menu" value="Media">
                                            <button type="button" class="btn btn-sm btn-danger btn-delete-permanent" title="Delete" data-toggle="modal" data-target="#deletePermanentModal"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <script>
                        function filterMediaTable() {
                            const input = document.querySelector('input[name="p_keyword"]');
                            const filter = input.value.toLowerCase();
                            const rows = document.querySelectorAll('#mediaTable tbody tr');

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
