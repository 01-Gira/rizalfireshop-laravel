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
        
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <form action="/admin/products/{{ $product->slug }}" method="post" enctype="multipart/form-data"> 
      @method('put')
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
                <input type="text" id="name" class="form-control @error('name')
                is-invalid
                @enderror" name="name" value="{{ $product->name }}" required autofocus>
                @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
              </div>
              <div class="form-group">
                <label for="slug">Slug</label>
                <input type="text" id="slug" class="form-control @error('slug')
                is-invalid
                @enderror" name="slug" value="{{ $product->slug }}" readonly>
                @error('slug')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
              </div>
              <div class="form-group">
                <label for="inputDescription">Product Description</label>
                <textarea id="inputDescription" class="form-control @error('description')
                is-invalid
            @enderror" rows="4" name="description" required>{{ $product->description }}</textarea>
            @error('description')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
              </div>
              <div class="form-group">
                <label for="category">Category</label>
                <select id="category" class="form-control custom-select @error('category')
                is-invalid
            @enderror" name="category_id">
                  @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                  @endforeach
                </select>
                @error('category')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
              </div>
              <div class="form-group">
                <label for="image">Product Image</label>
                @if ($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" class="img-preview img-fluid mb-3 col-sm-3">
                @else
                <img class="img-preview img-fluid mb-3 col-sm-3">
                @endif
                <input class="form-control" type="file" id="image" 
                type="file" id="image" name="image" value="{{ $product->image }}" onchange="previewImage()">
                @error('image')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
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
                <label for="inputEstimatedBudget">Weight</label>
                <input type="number" id="inputEstimatedBudget" class="form-control @error('weight')
                is-invalid
                @enderror" name="weight"  value="{{ $product->weight }}" required>
                @error('weight')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
              </div>
              
              {{-- <div class="form-group"> 
                <label for="inputEstimatedBudget">Color</label>
                <input type="text" id="inputEstimatedBudget" class="form-control @error('color')
                is-invalid
            @enderror" name="color" value="{{ $product->color }}" required>
            @error('color')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
              </div> --}}
              <div class="form-group">
                <label for="inputEstimatedBudget">Stock</label>
                <input type="number" id="stock" name="stock"class="form-control @error('stock')
                is-invalid
            @enderror" value="{{ $product->stock }}" required>
                @error('stock')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
              </div>
              <div class="form-group">
                <label for="inputSpentBudget">Price</label>
                <input type="number" id="price" name="price" class="form-control @error('price')
                is-invalid
            @enderror" value="{{ $product->price }}" required>
                @error('price')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
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
          <input type="submit" class="btn btn-success float-right">
        </div>
      </div>
    </form>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script>

    const name = document.querySelector('#name');
    const slug = document.querySelector('#slug');
    document.addEventListener('change', function() {
        fetch('/admin/products/checkSlug?name='+name.value)
            .then(response => response.json())
            .then(data =>slug.value = data.slug)
    });

    function previewImage() {
        const image = document.querySelector('#image');
        const imgPreview = document.querySelector('.img-preview');

        imgPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
    }
</script>
@endsection