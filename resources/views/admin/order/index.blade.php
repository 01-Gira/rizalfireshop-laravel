@extends('admin.layout.layout')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col mt-2">
            <h1>Orders</h1>
            <div class="col-sm-6 mt-2">
              <a class="btn btn-success btn-sm" href="/admin/products/create">
                <i class="fas fa-plus"> </i>
                Create Order
              </a>
            </div>
            @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show col-lg-8 mt-2" role="alert">
              {{ session('success') }}
              <button type="button" class="close btn btn-success" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @elseif (session()->has('danger')) 
            <div class="alert alert-danger alert-dismissible fade show col-lg-8 mt-2" role="alert">
              {{ session('danger') }}
              <button type="button" class="close btn btn-danger" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @endif
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
          <h3 class="card-title">Orders</h3>
        </div>
        <div class="card-body p-0">
          <div class="col-sm-6 d-flex justify-content-end ml-auto mt-2">
            <a class="btn btn-primary btn-sm" href="#" data-bs-toggle="modal" data-bs-target="#filterOrderModal">
              Filter Order
            </a>
          </div>  
          
          <table class="table table-striped projects">
            <thead>
              <tr>
                <th>No</th>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Courier</th>
                <th>Total Price</th>
                <th>Status</th>
                {{-- <th>Size</th>
                <th>Color</th> --}}
                <th></th>
              </tr>
            </thead>
            <tbody> 
              @foreach ($orders as $order )
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                  <a> {{ $order->order_id }} </a>
                  <br />
                  <small> Created {{ $order->created_at->format('d/m/Y H:i:s') }} </small>
                </td>
                <td>
                  <a> {{ $order->name }}</a>
                  
                </td>
                <td>
                  <a> {{ $order->courier }} </a>
                </td>
                <td>
                  <a> Rp.{{ number_format($order->total_price, 0, ',', '.') }}</a>
                </td>
                <td>
                    <a> {{ $order->transaction_status }}</a>
                  </td>
                {{-- <td>
                  <a> {{ $product->size }} </a>
                </td>
                <td>
                  <a> {{ $product->color }} </a>
                </td> --}}
                <td class="project-actions text-right">
                  <div class="row">
                    <div class="col">
                      <a class="btn btn-primary btn-sm" href="/admin/orders/{{ $order->slug }}">
                        <i class="fas fa-folder"> </i>
                        View
                      </a>
                    </div>
                    <div class="col">
                      <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-pencil-alt"> </i>
                        Edit
                      </button>
                      <ul class="dropdown-menu">
                        @if ($order->transaction_status=='capture' && !$order->no_resi)
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addResiModal-{{ $order->order_id }}">Add Resi</a></li>
                        @endif
                        <li><a class="dropdown-item" href="/admin/products/{{ $order->order_id }}/edit">Edit all</a></li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addStockModal-{{ $order->order_id }}">Download</a></li>
                      </ul>
                    </div>
                    <div class="col">
                      <form action="/admin/orders/{{ $order->id }}" method="post">
                        @csrf
                        @method('delete')
                      <button class="btn btn-danger btn-sm" href="#" onclick="return confirm('Are you sure?')">
                        <i class="fas fa-trash"> </i>
                        Delete
                      </button>
                      </form>
                    </div>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
      <div class="col-12 justify-content-center d-flex">
        {{ $orders->links() }}
      </div>

     
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
          {{-- <!-- Price Range Start -->
          <div class="form-group">
          <label for="price_range">Range Harga:</label>
          <div class="input-group">
              <input type="text" class="form-control" placeholder="Harga Min" name="min_price">
              <span class="input-group-text">-</span>
              <input type="text" class="form-control" placeholder="Harga Max" name="max_price">
          </div>
          </div>
          <!-- Price Range End --> --}}
          <!-- Status Order -->
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