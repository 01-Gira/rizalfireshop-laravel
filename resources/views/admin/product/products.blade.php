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
            <div class="col-sm-6 mt-2">
              <a class="btn btn-success btn-sm" href="/admin/products/create">
                <i class="fas fa-plus"> </i>
                Create Product
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
          
           
          <div class="card-tools">
            <button
              type="button"
              class="btn btn-tool"
              data-card-widget="collapse"
              title="Collapse"
            >
              <i class="fas fa-minus"></i>
            </button>
            <button
              type="button"
              class="btn btn-tool"
              data-card-widget="remove"
              title="Remove"
            >
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        
        <div class="card-body p-0">
          <table class="table table-striped projects">
            <thead>
              <tr>
                <th>No</th>
                <th>Product Name</th>
                <th>Stock</th>
                <th>Price</th>
                <th>Category</th>
                <th>Size</th>
                <th>Color</th>
                <th></th>
              </tr>
            </thead>
            <tbody> 
              @foreach ($products as $product )
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                  <a> {{ $product->name }}</a>
                  <br />
                  <small> Created {{ $product->created_at->format('d/m/Y H:i:s') }} </small>
                </td>
                <td>
                  <a> {{ $product->stock }} </a>
                </td>
                <td>
                  <a> Rp.{{ number_format($product->price, 0, ',', '.') }} </a>
                </td>
                <td>
                  <a> {{ $product->category->name }}</a>
                </td>
                <td>
                  <a> {{ $product->size }} </a>
                </td>
                <td>
                  <a> {{ $product->color }} </a>
                </td>
                <td class="project-actions text-right">
                  <div class="row">
                    <div class="col">
                      <a class="btn btn-primary btn-sm" href="/admin/products/{{ $product->slug }}">
                        <i class="fas fa-folder"> </i>
                        View
                      </a>
                    </div>
                    <div class="col">
                      <a class="btn btn-info btn-sm" href="/admin/products/{{ $product->slug }}/edit">
                        <i class="fas fa-pencil-alt"> </i>
                        Edit
                      </a>
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

@endsection