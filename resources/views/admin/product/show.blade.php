@extends('admin.layout.layout')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Product {{ $product->name }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Product</li>
          </div>
          <div class="col">
            <button class="btn btn-info btn-sm" href="/admin/products/{{ $product->slug }}/edit">
                <i class="fas fa-pencil-alt"> </i>
                Edit
            </button>
            </div>
            <div class="col">
                <form action="/admin/products/{{ $product->slug }}" method="post">
                    @csrf
                    @method('delete')
                <button class="btn btn-danger btn-sm" href="#">
                    <i class="fas fa-trash"> </i>
                    Delete
                </button>
                </form>
            </div>
        </div>
        
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <form action="/admin/products" method="post" enctype="multipart/form-data"> 
      @csrf
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">General</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" id="name" class="form-control" name="name" value="{{ $product->name }}" disabled>
              </div>
              <div class="form-group">
                <label for="inputDescription">Product Description</label>
                <textarea id="inputDescription" class="form-control" rows="4" name="description" disabled>{{ $product->description }}</textarea>
              </div>
              <div class="form-group">
                <label for="category">Category</label>
                <input type="text" id="name" class="form-control" name="name" value="{{ $product->category->name }}" disabled>
              </div>
              <div class="form-group">
                <label for="image">Product Image</label>
                <div style="max-height: 350px; overflow:hidden;">
                    <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid mt-3">
                </div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-6">
          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">Product Quantity</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="inputEstimatedBudget">Size</label>
                <input type="text" id="inputEstimatedBudget" class="form-control" value="{{ $product->size }}" disabled>
              </div>
              <div class="form-group">
                <label for="inputEstimatedBudget">Color</label>
                <input type="text" id="inputEstimatedBudget" class="form-control" value="{{ $product->color }}" disabled>
              </div>
              <div class="form-group">
                <label for="inputEstimatedBudget">Stock</label>
                <input type="number" id="inputEstimatedBudget" class="form-control" value="{{ $product->stock }}" disabled>
              </div>
              <div class="form-group">
                <label for="inputSpentBudget">Price</label>
                <input type="number" id="inputSpentBudget" class="form-control" value="{{ number_format($product->price, 0, ',', '.') }}" disabled>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <a href="/admin/products" class="btn btn-secondary">Cancel</a>
          {{-- <input type="submit" value="Create new Project" class="btn btn-success float-right"> --}}
        </div>
      </div>
    </form>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection