@extends('layouts.admin')

@section('title', 'Beasiswas')

@section('breadcrumbs', 'Overview Beasiswa')

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
            <a href="{{route('beasiswas.create')}}" class="btn btn-sm btn-success"> <i class="fa fa-plus"></i> Create</a>
          </div>

          {{-- display filter --}}
          <div class="row mb-3">
            <div class="col-sm-7">
              <ul class="nav nav-tabs ">
                  <li class="nav-item">
                      <a class="nav-link p-2 px-3 {{Request::get('status') == NULL ? 'active' : ''}}" href="{{route('beasiswas.index')}}">All</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link p-2 px-3 {{Request::get('status') == 'publish' ?'active' : '' }}" href="{{route('beasiswas.index', ['status' =>'publish'])}}">Publish</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link p-2 px-3 {{Request::get('status') == 'draft' ?'active' : '' }}" href="{{route('beasiswas.index', ['status' =>'draft'])}}">Draft</a>
                  </li>
              </ul>
            </div>
            <div class="col-sm-5">
              <form action="{{route('beasiswas.index')}}">
                <div class="input-group">
                  <input name="keyword" type="text" value="{{Request::get('keyword')}}" class="form-control" placeholder="Filter by title" oninput="filterBeasiswaTable()">
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
            <table class="table" id="beasiswaTable">
              <thead class="text-light" style="background-color:#33b751 !important">
                <tr>
                  <th width="160px">Image</th>
                  <th class="filterable">Beasiswa Title</th>
                  <th width="150px"></th>
                  <th width="88px">Action</th>
                </tr>
              </thead>
              <tbody id="tableBody">
                @php
                                $filteredbeasiswas = $beasiswas->filter(function ($item) {
                                    return auth()->user()->role !== 'guru' || auth()->user()->id === $item->create_by;
                                });
                            @endphp
                            @foreach ($filteredbeasiswas as $beasiswa)
                {{-- @foreach ($beasiswas as $index => $beasiswa)
                @if (auth()->user()->role == 'guru' && $beasiswa->create_by != auth()->user()->id)
                  @continue
                @endif --}}
                  <tr>
                    <td align="left">
                      @if($beasiswa->image)
                        <img src="{{asset('beasiswas_image/'.$beasiswa->image)}}" alt="" width="120px">
                      @endif
                    </td>
                    <td class="filterable">
                      <a href="{{route('beasiswas.edit', [$beasiswa->id])}}" style="color:#00838f;" class="underline">
                        <span class="d-block">{{$beasiswa->title}}</span>
                      </a>
                    </td>
                    <td class="text-right pr-4">
                      @if ($beasiswa->status=='PUBLISH')
                        <span class="font-italic text-danger">Publish</span>
                      @elseif ($beasiswa->status=='DRAFT')
                        <span class="font-italic text-danger">Draft</span>
                      @endif
                    </td>
                    <td>
                      <a href="{{route('beasiswas.edit', [$beasiswa->id])}}" class="btn btn-sm btn-warning text-light" title="Edit"><i class="fa fa-pencil"></i></a>
                      <button class="btn btn-sm btn-danger" onclick="deleteConfirm('{{$beasiswa->id}}', '{{$beasiswa->title}}')" data-target="#modalDelete" data-toggle="modal"><i class="fa fa-trash"></i></button>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-3 d-flex justify-content-between align-items-center">
              <div>
                <p>Total Data: <span id="totalData">{{ $filteredbeasiswas->count() }}</span></p>
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

              function filterBeasiswaTable() {
                const input = document.querySelector('input[name="keyword"]');
                const filter = input.value.toLowerCase();
                const rows = document.querySelectorAll('#beasiswaTable tbody tr');

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


  <!-- Modal Delete -->
    <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title d-inline">Delete Beasiswa</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="message">

        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <form action="" id="url" method="POST" class="d-inline">
          @csrf 
          @method('DELETE')
          <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        </div>
      </div>
      </div>
    </div>
  <!-- End Modal Delete -->


@endsection

@section('script')
  <script>
    function deleteConfirm(id, name){ 
      var url = '{{ route("beasiswas.destroy", ":id") }}';    
          url = url.replace(':id', id);
      document.getElementById("url").setAttribute("action", url);
      document.getElementById('message').innerHTML ="Are you sure want to delete beasiswa <b>"+name+"</b> ?"
      $('#modalDelete').modal();
    }

  </script>
@endsection