@extends('admin.layout.layout')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
      @include('layouts._flash')
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Products</h1>
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
          {{-- <h3 class="card-title">Products</h3> --}}
          <div class="row">
            <div class="col-sm-4">
              <a class="btn btn-success btn-sm" href="/admin/products/create">
                <i class="fas fa-plus"> </i>
                Create Product
              </a>
            </div>        
          </div>
        </div>
        <div class="card-body p-3">
          <table class="table table-striped projects" id="tblMaster">
            <thead>
              <tr>
                {{-- <th class="text-center">No</th> --}}
                <th style="width:1px;white-space:nowrap;text-align:center;"><input class="check-all" type="checkbox"></th>
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

@endsection

@section('scripts')
    <script>
      var tableMaster = $('#tblMaster').DataTable({  
        "columnDefs": [{
          "searchable": false,
          "orderable": false,
          "targets": [0, 5],
        //   render: function (data, type, row, meta) {
        //     return meta.row + meta.settings._iDisplayStart + 1;
        // }
        }],
        "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
        "iDisplayLength": 10,
        "order": [[1, 'asc']],
        processing: true,
        responsive: true,
        "oLanguage": {
          'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
        },
        dom: 'Bfrtip',
        buttons: [
          {
              extend: 'copy',
              text: '<i class="fas fa-copy"></i> Copy', // Menambahkan ikon dan mengubah teks tombol
              className: 'btn btn-primary', // Mengubah tampilan tombol dengan kelas Bootstrap
          },
          {
              extend: 'csv',
              text: '<i class="fas fa-file-csv"></i> CSV', // Menambahkan ikon dan mengubah teks tombol
              className: 'btn btn-success', // Mengubah tampilan tombol dengan kelas Bootstrap
          },
          {
              extend: 'excel',
              text: '<i class="fas fa-file-excel"></i> Excel', // Menambahkan ikon dan mengubah teks tombol
              className: 'btn btn-info', // Mengubah tampilan tombol dengan kelas Bootstrap
          },
          {
              extend: 'pdf',
              text: '<i class="fas fa-file-pdf"></i> PDF', // Menambahkan ikon dan mengubah teks tombol
              className: 'btn btn-danger', // Mengubah tampilan tombol dengan kelas Bootstrap
          },
          {
              extend: 'print',
              text: '<i class="fas fa-print"></i> Print', // Menambahkan ikon dan mengubah teks tombol
              className: 'btn btn-secondary', // Mengubah tampilan tombol dengan kelas Bootstrap
          },
          {
            text: '<i class="fas fa-pencil"></i> Edit',
            className: 'btn btn-warning edit-checkbox',

          },
          {
            text: '<i class="fas fa-trash"></i> Delete',
            className: 'btn btn-danger delete-checkbox',
            id: 'delete-all'
          },
        ],
        ajax: '{{ route('products.dashboard') }}',
        columns: [
          // {data: null, name: null, className: "text-center"},
          {data: 'checkall', name: 'checkall', className: "text-center"},
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
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then(function (result) {
          $('#loading').show();

          if(result.isConfirmed){
            let url = '{{ route('products.destroy', 'param') }}';
            let token = $('meta[name="csrf-token"]').attr("content");
            url = url.replace('param', p);
            $.ajax({
              url: url,
              type: 'DELETE',
              dataType : 'json',
              data : {
                _token : token
              },
              success : function(response) {
                $('#loading').hide();
                tableMaster.ajax.reload();  
                if(response.indctr == 0){
                  Swal.fire('Success', response.msg, 'success');
                }else {
                  Swal.fire('Danger', response.msg, 'warning');
                }

                // swal()
                console.log(response);
              },
              error : function(xhr){
                $('#loading').hide();
                Swal.fire('Danger', xhr.responseText, 'error');
                tableMaster.ajax.reload();
                console.log(xhr.responseText);
              }
            });
          }else {
            $('#loading').hide();
                // Batalkan penghapusan
            Swal.fire('Cancelled', 'Deletion cancelled.', 'info');

          }
         
        }).catch(swal.noop)
        
      }

      $('.edit-checkbox').on('click', function(){
        Swal.fire('Edit', 'Are you sure?', 'question');
      });
    </script>
@endsection