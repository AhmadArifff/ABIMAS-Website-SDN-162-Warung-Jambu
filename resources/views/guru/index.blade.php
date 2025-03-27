@extends('layouts.admin')

@section('title', 'Guru')

@section('breadcrumbs', 'Overview Guru')

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
                    
                    {{-- button create --}}
                    <div class="mb-5 text-right">
                        <a href="{{route('guru.create')}}" class="btn btn-sm btn-success"> <i class="fa fa-plus"></i> Tambah Guru</a>
                    </div>

                    {{-- display filter --}}
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <form action="{{route('guru.index')}}">
                                <div class="input-group">
                                    <input name="keyword" type="text" value="{{Request::get('keyword')}}" class="form-control" placeholder="Filter by name" oninput="filterGuruTable()">
                                    <div class="input-group-append">
                                        <input type="submit" value="Filter" class="btn btn-info">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- alert --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{session('success')}}.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
                    <table class="table" id="guruTable">
                        <thead class="text-light" style="background-color:#33b751 !important">
                            <tr>
                                <th>Foto</th>
                                <th class="filterable">Nama</th>
                                <th class="filterable">Jabatan</th>
                                <th class="filterable">Gelar</th>
                                <th class="filterable">Mulai Menjadi Guru</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @foreach ($gurus as $guru)                            
                                <tr>
                                    <td align="left">
                                        @if($guru->foto)
                                            <img src="{{asset('guru_image/'.$guru->foto)}}" alt="" width="120px" height="120px" style="border-radius: 50%;">
                                        @endif
                                    </td>
                                    <td class="filterable">
                                        <a href="{{route('guru.edit', [$guru->id])}}" style="color:#00838f;" class="underline">
                                            <span class="d-block">{{$guru->nama}}</span>
                                        </a>
                                    </td>
                                    <td class="filterable">
                                        {{$guru->jabatan}}
                                    </td>
                                    <td class="filterable">
                                        {{$guru->gelar}}
                                    </td>
                                    <td class="filterable">
                                        {{$guru->mulai_menjadi_guru}}
                                    </td>
                                    <td>
                                        <a href="{{route('guru.edit', [$guru->id])}}" class="bnt btn-sm btn-warning text-light" title="Edit"><i class="fa fa-pencil"></i></a>
                                        <form action="{{ route('guru.destroy', $guru->id) }}" method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus guru ini?')"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <div>
                            <p>Total Data: <span id="totalData">{{ $gurus->count() }}</span></p>
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

                        function filterGuruTable() {
                            const input = document.querySelector('input[name="keyword"]');
                            const filter = input.value.toLowerCase();
                            const rows = document.querySelectorAll('#guruTable tbody tr');

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
@endsection
