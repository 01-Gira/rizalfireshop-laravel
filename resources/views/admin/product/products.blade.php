@extends('admin.layout.layout')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col mt-2">
            <h1>Products</h1>
            <div class="row">
              <div class="col-sm-6 mt-2">
                <a class="btn btn-success btn-sm" href="/admin/products/create">
                  <i class="fas fa-plus"> </i>
                  Create Product
                </a>
              </div>
              <div class="col-sm-6 mt-2">
                <a class="btn btn-warning btn-sm" href="/admin/products/export">
                  <i class="fas fa-plus"> </i>
                  Export Excel
                </a>
              </div>
            </div>
            @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show col-lg-8 mt-2" role="alert" style="width: 100%">
              {{ session('success') }}
              <button type="button" class="close btn btn-success" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @elseif (session()->has('danger')) 
            <div class="alert alert-danger alert-dismissible fade show col-lg-8 mt-2" role="alert" style="width: 100%">
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
          <h3 class="card-title">Products</h3>
        </div>
        <div class="card-body p-0">
          <div class="col-sm-6 d-flex justify-content-end ml-auto mt-2">
            <a class="btn btn-primary btn-sm" href="#" data-bs-toggle="modal" data-bs-target="#filterModal">
              Filter Product
            </a>
          </div>  
          <table class="table table-striped projects">
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th class="text-center">Product Name</th>
                <th class="text-center">Stock</th>
                <th class="text-center">Price</th>
                <th class="text-center">Category</th>
                {{-- <th>Size</th>
                <th>Color</th> --}}
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody> 
              @foreach ($products as $product )
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">
                  <a> {{ $product->name }}</a>
                  <br />
                  <small> Created {{ $product->created_at->format('d/m/Y H:i:s') }} </small>
                </td class="text-center">
                <td class="text-center">
                  <a> {{ $product->stock }} </a>
                </td>
                <td class="text-center">
                  <a> Rp.{{ number_format($product->price, 0, ',', '.') }} </a>
                </td>
                <td class="text-center">
                  <a> {{ $product->category->name }}</a>
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
                      <a class="btn btn-primary btn-sm" href="/admin/products/{{ $product->slug }}">
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
                        <li><a class="dropdown-item" href="/admin/products/{{ $product->slug }}/edit">Edit all</a></li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addStockModal-{{ $product->slug }}">Add stock</a></li>
                      </ul>
                    </div>
                    <div class="col">
                      <form action="/admin/products/{{ $product->slug }}" method="post">
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
        {{ $products->links() }}
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
        <form method="GET" action="/admin/products">
          <div class="form-group">
            <label for="search">Search</label>
            <input class="form-control" type="text" name="search" placeholder="Search Product...">
          </div>
          <!-- Price Range Start -->
          <div class="form-group">
          <label for="price_range">Range Harga:</label>
          <div class="input-group">
              <input type="text" class="form-control" placeholder="Harga Min" name="min_price">
              <span class="input-group-text">-</span>
              <input type="text" class="form-control" placeholder="Harga Max" name="max_price">
          </div>
          </div>
          <!-- Price Range End -->

          <!-- Filter review -->
          <div class="form-group">
              <label for="filter-rating">Filter by Rating:</label>
              <select class="form-control" id="filter-rating" name="filter-rating">
              <option value="">-- Select rating --</option>
              <option value="5">5 Stars</option>
              <option value="4">4 Stars</option>
              <option value="3">3 Stars</option>
              <option value="2">2 Stars</option>
              <option value="1">1 Star</option>
              </select>
          </div>
          <!-- Filter Review End -->

          <!-- Sortir Start -->
          <div class="form-group">
          <label for="sort">Sortir:</label>
          <select class="form-control" id="sort" name="sort">
              <option value="">Tidak Ada</option>
              <option value="sale desc">Terpopuler</option>
              <option value="created_at desc">Terbaru</option>
              <option value="price asc">Termurah</option>
              <option value="price desc">Termahal</option>
          </select>
          </div>
          <!-- Sortir End -->

          <!-- Kategori -->
          <div class="form-group">
              <label for="category">Category:</label>
              <select name="category" id="category" class="form-control">
                  <option value="">Select one</option>
                  @foreach ($categories as $category)
                  <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                  </option>
                @endforeach
              </select>
          </div>
          <!-- Kategori end -->
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
      {{-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> --}}
    </div>
  </div>
</div>
@endforeach

@endsection