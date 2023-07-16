@extends('admin.layout.layout')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Product Add</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Product Add</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
    <form action="/admin/products" method="post" id="form-id" enctype="multipart/form-data"> 
      @csrf
      <div class="row">
        <div class="col-md-12">
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
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="name">Product Name</label>
                    <input type="text" id="name" class="form-control @error('name')
                    is-invalid
                    @enderror" name="name" value="{{ old('name') }}" required autofocus>
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
                    @enderror" name="slug" value="{{ old('slug') }}" readonly>
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
                    @enderror" rows="4" name="description" required>{{ old('description') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                  </div>
                  {{-- <div class="form-group">
                    <label for="category">Category</label>
                    <select id="category" class="form-control select2
                    @error('category')
                    is-invalid
                    @enderror" name="category_id">
                      <option selected disabled>Select one</option>
                      @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                      @endforeach
                    </select>
                    @error('category')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                  </div> --}}
                  <div class="form-group">
                    <label>Minimal</label>
                    <select class="form-control select2" style="width: 100%;" name="category_id">
                      <option selected="selected">Select Category</option>
                      @foreach ($categories as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="image">Product Image</label>
                    <img class="img-preview img-fluid mb-3 col-sm-3">
                    <input class="form-control @error('images')
                    is-invalid
                     @enderror" type="file" id="image" name="image" onchange="previewImage()">
                     @error('size')
                     <div class="invalid-feedback">
                         {{ $message }}
                     </div>
                     @enderror
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="tags">Tags</label>
                    <select class="form-control select2" name="tags[]" multiple="multiple" data-placeholder="Select a Tag">
                      <option>Alabama</option>
                      @foreach ($tags as $item)
                       <option value="{{ $item->name }}">{{ $item->name }}</option> 
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="inputEstimatedBudget">Weight</label>
                    <input type="number" id="inputEstimatedBudget" class="form-control @error('weight')
                    is-invalid
                    @enderror" name="weight"  value="{{ old('weight') }}" required>
                    @error('weight')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="inputEstimatedBudget">Stock</label>
                    <input type="number" id="inputEstimatedBudget" class="form-control @error('stock')
                      is-invalid
                    @enderror" name="stock" value="{{ old('stock') }}" required>
                    @error('stock')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="inputSpentBudget">Price</label>
                    <input type="number" id="inputSpentBudget" class="form-control @error('price')
                    is-invalid
                    @enderror" name="price" value="{{ old('price') }}" required>
                    @error('price')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                  </div>
                </div>
              </div>
              
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <input type="submit" value="Create new Product" class="btn btn-success">

              <a href="/admin/products" class="btn btn-secondary">Cancel</a>
            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>
    </form>
    </section>

    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @endsection

  @section('scripts')
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



    $('#form-id').on('submit', function(event){
        event.preventDefault();

        Swal.fire({
        title: 'Are you sure?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Order'
        }).then(function(result){
        if(result.isConfirmed){
          event.currentTarget.submit();
        }
      
        }).catch(swal.noop);

    });

</script>

@endsection