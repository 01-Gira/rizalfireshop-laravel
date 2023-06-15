@extends('admin.layout.layout')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
      @include('layouts._flash')
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Orders</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
              <li class="breadcrumb-item active">Orders</li>
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
          <div class="row">
            <div class="col-sm-4">
              <a class="btn btn-success btn-sm" href="/admin/orders/create">
                <i class="fas fa-plus"> </i>
                Create Order
              </a>
            </div>        
          </div>
        </div>
        <div class="card-body p-3">
          <table class="table table-striped projects" id="tblMaster">
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th class="text-center">Order ID</th>
                <th class="text-center">Customer Name</th>
                <th class="text-center">Courier</th>
                <th class="text-center">Transaction Status</th>
                <th class="text-center">Total Price</th>

                {{-- <th>Size</th>
                <th>Color</th> --}}
                <th class="text-center">Action</th>
              </tr>
            </thead>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </section>
    <!-- /.content -->
 
  </div>
  <!-- /.content-wrapper -->

  <!-- Show addResi Modal -->
  @foreach ($orders as $order)
  <div class="modal fade" id="addResiModal-{{ $order->order_id }}" tabindex="-1" aria-labelledby="showCategoryModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addResiModalLabel">{{ $order->order_id }}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="post" action="{{ route('orders.add-resi', $order->order_id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label for="no_resi">No Resi</label>
              <input type="text" id="no_resi" class="form-control @error('no_resi')
              is-invalid
          @enderror" name="no_resi" autofocus>
          @error('no_resi')
          <div class="invalid-feedback">
              {{ $message }}
          </div>
          @enderror
            </div>
            <button type="submit" class="btn btn-success" style="width: 100%">Add</button>
          </form>
        </div>
        {{-- <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div> --}}
      </div>
    </div>
  </div>
  @endforeach

  
<!-- Filter Modal -->
<div class="modal fade" id="filterOrderModal" tabindex="-1" aria-labelledby="filterOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="filterOrderModalLabel">Filter</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="GET" action="/admin/orders">
          <div class="form-group">
            <label for="search">Search</label>
            <input class="form-control" type="text" name="search" placeholder="Search Order...">
          </div>
          <div class="form-group">
            <label for="category">Status Transaction:</label>
            <select name="status_transaction" id="status_transaction" class="form-control">
                <option value="">Select one</option>
                <option value="price asc">Unpaid</option>
                <option value="price desc">Paid</option>
                <option value="price desc">On Hold</option>
                <option value="price desc">Cancelled</option>
                <option value="price desc">Success</option>
            </select>
          </div>
          <!-- Kategori end -->

          <!-- Sortir Start -->
          <div class="form-group">
          <label for="sort">Sortir:</label>
          <select class="form-control" id="sort" name="sort">
              <option value="">Select one</option>
              <option value="created_at desc">Terbaru</option>
              <option value="created_at asc">Terlama</option>
              <option value="price asc">Tertinggi</option>
              <option value="price desc">Terrendah</option>
          </select>
          </div>
          <!-- Sortir End -->

         
          <button type="submit" class="btn btn-primary mt-3">Filter</button>
        </form>
      </div>
      {{-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> --}}
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
    ajax: '{{ route('orders.dashboard') }}',
    columns: [
      {data: null, name: null, className: "text-center"},
      { data: 'order_id', name: 'order_id', className: "text-center"},
      { data: 'name', name: 'name', className: "text-center" },
      { data: 'courier', name: 'courier', className: "text-center" },
      { data: 'transaction_status', name: 'transaction_status', className: "text-center" },
      { data: 'total_price', name: 'total_price', className: "text-center",    render: function(data, type, row) {
         return 'Rp.' + row.total_price.toLocaleString('id-ID');
      }},
      {data: 'action', name: 'action', className: "text-center"},
      
    ]
  });

  $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
    // data.category = $('select[name="category"]').val();
    // data.destination = $('select[name="destination"]').val();  
  });

  $('#btnFilter').on('click', function() {
    tableMaster.ajax.reload();
  });

  function addNoResi(p) {
    Swal.fire({
      title: 'Add No Resi',
      input: 'text',
      inputPlaceholder: 'Enter No Resi',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Submit',
      cancelButtonText: 'Cancel',
      allowOutsideClick: true,
      allowEscapeKey: true,
      allowEnterKey: true,
      reverseButtons: false,
      focusCancel: false,
      preConfirm: (no_resi) => {
        const data = {
                no_resi: no_resi,
                param: p // Ubah dan tambahkan data yang Anda inginkan
            };
          return fetch('/orders/add-no-resi/${p}', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Tambahkan ini jika Anda menggunakan Laravel dan perlu melindungi dari serangan CSRF
            },
            body: JSON.stringify(data) // Kirim nomor resi sebagai data JSON
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText);
            }
            return response.json();
        })
        .then(data => {
            // Tangani respons yang diterima dari server
            if (data.success) {
                Swal.fire('Sukses', data.message, 'success');
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        })
        .catch(error => {
            Swal.showValidationMessage(`Request failed: ${error}`);
        });
      },

    }).then(function (result) {

      if (result.isConfirmed) {
        Swal.fire({
          title: 'Submitted!',
          text: `No Resi`,
          icon: 'success'
        });
      }

    }).catch(swal.noop)
    
  }
</script>
@endsection