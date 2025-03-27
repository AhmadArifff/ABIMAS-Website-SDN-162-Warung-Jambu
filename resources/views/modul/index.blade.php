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
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link p-2 px-3 {{ Request::get('-isi-content-status') == NULL ? 'active' : '' }}" href="{{ route('admin.'. strtolower($menu) .'.index') }}">All</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2 px-3 {{ Request::get('-isi-content-status') == 'PUBLISH' ? 'active' : '' }}" href="{{ route('admin.'. strtolower($menu) .'.index', ['-isi-content-status' => 'PUBLISH']) }}">Publish</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2 px-3 {{ Request::get('-isi-content-status') == 'DRAFT' ? 'active' : '' }}" href="{{ route('admin.'. strtolower($menu) .'.index', ['-isi-content-status' => 'DRAFT']) }}">Draft</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2 px-3 {{ Request::get('-isi-content-status') == 'HAPUS' ? 'active' : '' }}" href="{{ route('admin.'. strtolower($menu) .'.index', ['-isi-content-status' => 'HAPUS']) }}">Hapus</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-5">
                            <form action="{{ route('admin.'. strtolower($menu) .'.index') }}">
                                <div class="input-group">
                                    <input name="p_keyword" type="text" value="{{ Request::get('p_keyword') }}" class="form-control" placeholder="Filter by modul name" oninput="filterModulTable()">
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
                            {{ session('success-isi-content') }}.
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
                    <table class="table" id="modulTable">
                        <thead class="text-light" style="background-color:#33b751 !important">
                            <tr>
                                <th width="12px">No</th>
                                <th class="text-center">Nama Guru</th>
                                <th class="text-center">Nama Modul</th>
                                <th class="text-center">Kelas</th>
                                <th class="text-center">Deskripsi</th>
                                <th class="text-center">File</th>
                                <th class="text-center">Status</th>
                                <th width="88px">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @php
                                $filteredModul = $modul->filter(function ($item) {
                                    return auth()->user()->role !== 'guru' || auth()->user()->id === $item->m_create_id;
                                });
                            @endphp
                            @foreach ($filteredModul as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="filterable">
                                        @php
                                            $guru = $gurus->firstWhere('id', $item->m_guru_id);
                                        @endphp
                                        {{ $guru ? $guru->nama : 'Tidak Ada Guru' }}
                                    </td>
                                    <td class="filterable">{{ $item->m_nama_modul }}</td>
                                    <td class="filterable">{{ $item->m_modul_kelas }}</td>
                                    <td class="filterable">{{ Str::limit($item->m_deskripsi_modul, 50) }}</td>
                                    <td class="text-center">
                                        @if($item->m_foto_atau_pdf)
                                            @php
                                                $extension = pathinfo($item->m_foto_atau_pdf, PATHINFO_EXTENSION);
                                            @endphp
                                            @if(in_array(strtolower($extension), ['jpeg', 'jpg', 'png']))
                                                <img src="{{ asset('modul_image/foto/' . $item->m_foto_atau_pdf) }}" alt="Foto" width="50">
                                            @elseif(strtolower($extension) === 'pdf')
                                                @if(auth()->check())
                                                    <a href="{{ route('modul.file', $item->m_foto_atau_pdf) }}" target="_blank">View PDF</a>
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
                                    <td class="filterable">{{ $item->m_status }}</td>
                                    <td class="text-center">
                                        @if ($item->m_status == 'HAPUS')
                                            <form class="d-inline" method="POST" action="{{ route('admin.'. strtolower($menu) .'.restore', [$item->m_id]) }}">
                                                @csrf
                                                <button type="button" class="btn btn-sm btn-success btn-restore" title="Restore" data-toggle="modal" data-target="#restoreModal"><i class="fa fa-undo"></i></button>
                                            </form>
                                            <form class="d-inline" method="POST" action="{{ route('admin.'. strtolower($menu) .'.destroy', [$item->m_id]) }}">
                                                @method('DELETE')
                                                @csrf
                                                <button type="button" class="btn btn-sm btn-danger btn-delete-permanent" title="Delete" data-toggle="modal" data-target="#deletePermanentModal"><i class="fa fa-trash"></i></button>
                                            </form>
                                        @else
                                            <a href="{{ route('admin.'. strtolower($menu) .'.edit', [$item->m_id]) }}" class="btn btn-sm btn-warning text-light" title="Edit"><i class="fa fa-pencil"></i></a>
                                            <form class="d-inline" method="POST" action="{{ route('admin.'. strtolower($menu) .'.destroyrecycle', [$item->m_id]) }}">
                                                @method('DELETE')
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
                            <p>Total Data: <span id="totalData">{{ $filteredModul->count() }}</span></p>
                        </div>
                        <div id="paginationControls" class="pagination d-flex align-items-center">
                            <button id="prevPage" class="btn btn-sm btn-light mr-2">Previous</button>
                            <div id="pageNumbers" class="d-flex"></div>
                            <button id="nextPage" class="btn btn-sm btn-light ml-2">Next</button>
                        </div>
                    </div>
                        </div>
                        <div id="paginationControls" class="pagination"></div>
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

                        function filterModulTable() {
                            const input = document.querySelector('input[name="p_keyword"]');
                            const filter = input.value.toLowerCase();
                            const rows = document.querySelectorAll('#modulTable tbody tr');

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
