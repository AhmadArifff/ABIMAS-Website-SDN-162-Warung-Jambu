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
                    <div class="d-flex justify-content-end mb-3">
                        <select id="rowsPerPageTautan" class="form-control form-control-sm" style="width: auto; display: inline-block;">
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="all">All</option>
                        </select>
                        <span class="ml-2">Rows per page</span>
                    </div>
                    <table class="table" id="tautanTable">
                        <thead class="text-light" style="background-color:#33b751 !important">
                            <tr>
                                <th width="12px">No</th>
                                <th class="text-center">Nama Tautan</th>
                                <th class="text-center">URL</th>
                                <th width="88px">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tautanTableBody">
                            @foreach ($tautan as $item_tautan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="filterable">{{ $item_tautan->tt_nama_tautan }}</td>
                                    <td class="filterable">{{ Str::limit($item_tautan->tt_url, 30) }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.informasi-media.edit', $item_tautan->tt_id) }}" method="GET" class="d-inline">
                                            <input type="text" name="menu" id="menu" placeholder="Nama Menu..." class="form-control {{$errors->first('menu') ? "is-invalid" : ""}}" value="Tautan" required hidden>
                                            <button type="submit" class="btn btn-sm btn-warning text-light" title="Edit"><i class="fa fa-pencil"></i></button>
                                        </form>
                                        <form class="d-inline" method="POST" action="{{ route('admin.informasi-media.destroy', $item_tautan->tt_id) }}">
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

                    {{-- Pagination --}}
                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <div>
                            <p>Total Data: <span id="totalTautanData">{{ $tautan->count() }}</span></p>
                        </div>
                        <div id="paginationControlsTautan" class="pagination d-flex align-items-center">
                            <button id="prevPageTautan" class="btn btn-sm btn-light mr-2">Previous</button>
                            <div id="pageNumbersTautan" class="d-flex"></div>
                            <button id="nextPageTautan" class="btn btn-sm btn-light ml-2">Next</button>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const tautanTableBody = document.getElementById('tautanTableBody');
                            const rowsPerPageSelectTautan = document.getElementById('rowsPerPageTautan');
                            const paginationControlsTautan = document.getElementById('paginationControlsTautan');
                            const totalTautanData = document.getElementById('totalTautanData').textContent;
                            const tautanRows = Array.from(tautanTableBody.querySelectorAll('tr'));
                            let rowsPerPageTautan = parseInt(rowsPerPageSelectTautan.value);
                            let currentPageTautan = 1;

                            function renderTautanTable() {
                                const start = (currentPageTautan - 1) * rowsPerPageTautan;
                                const end = rowsPerPageTautan === 'all' ? tautanRows.length : start + rowsPerPageTautan;

                                tautanRows.forEach((row, index) => {
                                    row.style.display = index >= start && index < end ? '' : 'none';
                                });

                                renderTautanPagination();
                            }

                            function renderTautanPagination() {
                                const totalPagesTautan = rowsPerPageTautan === 'all' ? 1 : Math.ceil(tautanRows.length / rowsPerPageTautan);
                                const prevButtonTautan = document.getElementById('prevPageTautan');
                                const nextButtonTautan = document.getElementById('nextPageTautan');
                                const pageNumbersContainerTautan = document.getElementById('pageNumbersTautan');

                                pageNumbersContainerTautan.innerHTML = '';

                                for (let i = 1; i <= totalPagesTautan; i++) {
                                    const button = document.createElement('button');
                                    button.textContent = i;
                                    button.className = 'btn btn-sm ' + (i === currentPageTautan ? 'btn-primary' : 'btn-light');
                                    button.addEventListener('click', () => {
                                        currentPageTautan = i;
                                        renderTautanTable();
                                    });
                                    pageNumbersContainerTautan.appendChild(button);
                                }

                                prevButtonTautan.disabled = currentPageTautan === 1;
                                nextButtonTautan.disabled = currentPageTautan === totalPagesTautan;

                                prevButtonTautan.addEventListener('click', () => {
                                    if (currentPageTautan > 1) {
                                        currentPageTautan--;
                                        renderTautanTable();
                                    }
                                });

                                nextButtonTautan.addEventListener('click', () => {
                                    if (currentPageTautan < totalPagesTautan) {
                                        currentPageTautan++;
                                        renderTautanTable();
                                    }
                                });
                            }

                            rowsPerPageSelectTautan.addEventListener('change', function () {
                                rowsPerPageTautan = this.value === 'all' ? tautanRows.length : parseInt(this.value);
                                currentPageTautan = 1;
                                renderTautanTable();
                            });

                            renderTautanTable();
                        });

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
                            <button type="submit" class="btn btn-sm btn-success mt-2" {{ $mediasosial->count() >= 6 ? 'disabled' : '' }}> <i class="fa fa-plus"></i> Create</button>
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
                    <div class="d-flex justify-content-end mb-3">
                        <select id="rowsPerPageMedia" class="form-control form-control-sm" style="width: auto; display: inline-block;">
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
                                <th class="text-center">Nama Media</th>
                                <th class="text-center">URL</th>
                                <th width="88px">Action</th>
                            </tr>
                        </thead>
                        <tbody id="mediaTableBody">
                            @foreach ($mediasosial as $item_mediasosial)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="filterable">{{ ucfirst($item_mediasosial->ms_nama_media) }}</td>
                                    <td class="filterable">{{ $item_mediasosial->ms_url }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.informasi-media.edit', $item_mediasosial->ms_id) }}" method="GET" class="d-inline">
                                            <input type="text" name="menu" id="menu" placeholder="Nama Menu..." class="form-control {{$errors->first('menu') ? "is-invalid" : ""}}" value="Media" required hidden>
                                            <button type="submit" class="btn btn-sm btn-warning text-light" title="Edit"><i class="fa fa-pencil"></i></button>
                                        </form>
                                        <form class="d-inline" method="POST" action="{{ route('admin.informasi-media.destroy', $item_mediasosial->ms_id) }}">
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

                    {{-- Pagination --}}
                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <div>
                            <p>Total Data: <span id="totalMediaData">{{ $mediasosial->count() }}</span></p>
                        </div>
                        <div id="paginationControlsMedia" class="pagination d-flex align-items-center">
                            <button id="prevPageMedia" class="btn btn-sm btn-light mr-2">Previous</button>
                            <div id="pageNumbersMedia" class="d-flex"></div>
                            <button id="nextPageMedia" class="btn btn-sm btn-light ml-2">Next</button>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const mediaTableBody = document.getElementById('mediaTableBody');
                            const rowsPerPageSelectMedia = document.getElementById('rowsPerPageMedia');
                            const paginationControlsMedia = document.getElementById('paginationControlsMedia');
                            const totalMediaData = document.getElementById('totalMediaData').textContent;
                            const mediaRows = Array.from(mediaTableBody.querySelectorAll('tr'));
                            let rowsPerPageMedia = parseInt(rowsPerPageSelectMedia.value);
                            let currentPageMedia = 1;

                            function renderMediaTable() {
                                const start = (currentPageMedia - 1) * rowsPerPageMedia;
                                const end = rowsPerPageMedia === 'all' ? mediaRows.length : start + rowsPerPageMedia;

                                mediaRows.forEach((row, index) => {
                                    row.style.display = index >= start && index < end ? '' : 'none';
                                });

                                renderMediaPagination();
                            }

                            function renderMediaPagination() {
                                const totalPagesMedia = rowsPerPageMedia === 'all' ? 1 : Math.ceil(mediaRows.length / rowsPerPageMedia);
                                const prevButtonMedia = document.getElementById('prevPageMedia');
                                const nextButtonMedia = document.getElementById('nextPageMedia');
                                const pageNumbersContainerMedia = document.getElementById('pageNumbersMedia');

                                pageNumbersContainerMedia.innerHTML = '';

                                for (let i = 1; i <= totalPagesMedia; i++) {
                                    const button = document.createElement('button');
                                    button.textContent = i;
                                    button.className = 'btn btn-sm ' + (i === currentPageMedia ? 'btn-primary' : 'btn-light');
                                    button.addEventListener('click', () => {
                                        currentPageMedia = i;
                                        renderMediaTable();
                                    });
                                    pageNumbersContainerMedia.appendChild(button);
                                }

                                prevButtonMedia.disabled = currentPageMedia === 1;
                                nextButtonMedia.disabled = currentPageMedia === totalPagesMedia;

                                prevButtonMedia.addEventListener('click', () => {
                                    if (currentPageMedia > 1) {
                                        currentPageMedia--;
                                        renderMediaTable();
                                    }
                                });

                                nextButtonMedia.addEventListener('click', () => {
                                    if (currentPageMedia < totalPagesMedia) {
                                        currentPageMedia++;
                                        renderMediaTable();
                                    }
                                });
                            }

                            rowsPerPageSelectMedia.addEventListener('change', function () {
                                rowsPerPageMedia = this.value === 'all' ? mediaRows.length : parseInt(this.value);
                                currentPageMedia = 1;
                                renderMediaTable();
                            });

                            renderMediaTable();
                        });

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
