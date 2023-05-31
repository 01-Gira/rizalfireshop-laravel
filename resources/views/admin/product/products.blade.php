@extends('admin.layout.layout')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
      @include('layouts._flash')

        <div class="row mb-2">
          <div class="col mt-2">
            <h1>Products</h1>
            <div class="row">
              <div class="col-sm-4 mt-2">
                <a class="btn btn-success btn-sm" href="/admin/products/create">
                  <i class="fas fa-plus"> </i>
                  Create Product
                </a>
              </div>             
            </div>
            <div class="row d-flex justify-content-end ml-auto">
              <div class="col-sm-3">
                <a class="btn btn-warning btn-sm" href="/admin/products/export">
                  <i class="fas fa-plus"> </i>
                  Export Data
                </a>
              </div>
              <div class="col-sm-3">
                <a class="btn btn-success btn-sm" href="/admin/products/import">
                  <i class="fas fa-plus"> </i>
                  Import Data
                </a>
              </div>
            </div>
           
          </div>

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
              <li class="breadcrumb-item active">Products</li>
            </ol>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          {{-- <h3 class="card-title ">Products</h3> --}}
          <div class="row mt-2 d-flex justify-content-start ml-auto">
            <div class="col-sm-3 ">
              <div class="form-group">
                <label for="category">Category</label>
                <select name="category" id="category" class="form-control">
                    <option selected value="0">Select one</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                      {{ $category->name }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-sm-3 d-flex justify-content-end ml-auto mt-2">
              <div class="form-group">
                <button type="button" class="btn btn-success" id="btnFilter">Filter</button>
              </div>
            </div>
          </div>
          
        </div>
        <div class="card-body p-2">

          <table class="table table-striped projects" id="tblMaster">
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th class="text-center">Product Name</th>
                <th class="text-center">Stock</th>
                <th class="text-center">Price</th>
                <th class="text-center">Category</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  
<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="filterModalLabel">Filter</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <!-- Kategori -->
          
          <!-- Kategori end -->
          <button type="submit" class="btn btn-primary mt-3">Filter</button>
      </div>
    </div>
  </div>
</div>
{{-- 
@foreach ($products as $product)
<!-- Add Stock Modal -->
<div class="modal fade" id="addStockModal-{{ $product->slug }}" tabindex="-1" aria-labelledby="addStockModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addStockModalLabel">Add Stock</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{ route('products.update-stock', $product->slug) }}" id="updateForm">
          @csrf
          @method('PUT')
          <div class="form-group">
            <label for="search">Add Stock</label>
            <input class="form-control" type="number" name="stock" placeholder="Add Stock">
          </div>
          <button type="submit" class="btn btn-primary mt-3">Add</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endforeach --}}

@endsection

@section('scripts')
    <script>
      var tableMaster = $('#tblMaster').DataTable({
        "columnDefs": [{
          "searchable": false,
          "orderable": false,
          "targets": 0,
          render: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        }],
        "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
        "iDisplayLength": 10,
        "order": [[1, 'asc']],
        processing: true,
        // serverSide: true,
        responsive: true,
        "oLanguage": {
          'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
        },
        ajax: '{{ route('products.dashboard') }}',
        columns: [
          {data: null, name: null, className: "text-center"},
          { data: 'name', name: 'name', className: "text-center"},
          { data: 'stock', name: 'stock', className: "text-center" },
          { data: 'price', name: 'price', className: "text-center",    render: function(data, type, row) {
             return 'Rp.' + row.price.toLocaleString('id-ID');
          }},
          { data: 'category_name', name: 'category_name', className: "text-center" },
          {data: 'action', name: 'action', className: "text-center"},
          
        ]
      });

      $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
        data.category = $('select[name="category"]').val();
        // data.destination = $('select[name="destination"]').val();  
      });

      $('#btnFilter').on('click', function() {
        tableMaster.ajax.reload();
      });

      function deleteData(p) {
        Swal.fire({
          title: 'Are You Sure?',
          text: 'The data that you will delete can not be retrieved!',
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Delete',
          cancelButtonText: 'Cancel',
          allowOutsideClick: true,
          allowEscapeKey: true,
          allowEnterKey: true,
          reverseButtons: false,
          focusCancel: false,
        }).then(function () {
          $('#loading').show();
          let url = '{{ route('products.delete', 'slug') }}';
          let token = $('meta[name="csrf-token"]').attr("content");
          url = url.replace('slug', p);
          $.ajax({
            url: url,
            type: 'DELETE',
            data : {
              _token : token
            },
            success : function(response) {
              $('#loading').hide();

              console.log(response);
            },
            error : function(){
              $('#loading').hide();

            }
          });
        }).catch(swal.noop)
        
      }
    </script>
@endsection