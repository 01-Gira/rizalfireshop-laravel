@extends('admin.layout.layout')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col mt-2">
            <h1>Categories</h1>
            <div class="col-sm-6 mt-2">
              <a class="btn btn-success btn-sm" href="#" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                <i class="fas fa-plus"> </i>
                Create Category
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
              <li class="breadcrumb-item active">Categories</li>
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
          <h3 class="card-title">Categories</h3>
        </div>
        <div class="card-body p-0">
          <div class="col-sm-6 d-flex justify-content-end ml-auto mt-2">
            <a class="btn btn-primary btn-sm" href="#" data-bs-toggle="modal" data-bs-target="#filterCategoryModal">
              Filter Categories
            </a>
          </div>  
          <table class="table table-striped projects" id="tblMaster">
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th class="text-center">Category Name</th>
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

{{-- Add Category Modal --}}
<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="createCategoryModalLabel">Add Category</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="/admin/categories" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label for="name">Category Name</label>
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
          <button type="submit" class="btn btn-primary mt-3">Add</button>
        </form>
    </div>
  </div>
</div>


{{--@foreach ($categories as $category)
<!-- Edit Category Modal -->
 <div class="modal fade" id="editCategoryModal-{{ $category->slug }}" tabindex="-1" aria-labelledby="editCategoryModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editCategoryModalLabel">Edit Category</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="/admin/categories/{{ $category->slug }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="form-group">
            <label for="name">Category Name</label>
            <input type="text" id="name" class="form-control @error('name')
            is-invalid
        @enderror" name="name" value="{{ $category->name }}" required autofocus>
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
            @enderror" name="slug" value="{{ $category->slug }}" readonly>
            @error('slug')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
          </div>
          <div class="form-group">
            <label for="image">Category Image</label>
            @if ($category->image)
            <img src="{{ asset('storage/' . $category->image) }}" class="img-preview img-fluid mb-3 col-sm-3">
            @else
            <img class="img-preview img-fluid mb-3 col-sm-3">
            @endif
            <input class="form-control @error('images')
            is-invalid
             @enderror" type="file" id="image" name="image" onchange="previewImage()">
             @error('size')
             <div class="invalid-feedback">
                 {{ $message }}
             </div>
             @enderror
          </div>
          <button type="submit" class="btn btn-primary mt-3">Add</button>
        </form>
      </div>
    </div>
  </div>
</div> 
@endforeach --}}



{{-- @foreach ($categories as $category)
<!-- Show Category Modal -->
<div class="modal fade" id="showCategoryModal-{{ $category->slug }}" tabindex="-1" aria-labelledby="showCategoryModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="showCategoryModalLabel">{{ $category->name }}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="" action="#" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label for="name">Category Name</label>
            <input type="text" id="name" class="form-control @error('name')
            is-invalid
        @enderror" name="name" value="{{ $category->name }}" readonly autofocus>
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
            @enderror" name="slug" value="{{ $category->slug }}" readonly>
            @error('slug')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
          </div>
          <div class="form-group">
            <label for="image">Category Image</label>
            @if ($category->image)
            <img src="{{ asset('storage/' . $category->image) }}" class="img-preview img-fluid mb-3 col-sm-3">
            @else
            <img class="img-preview img-fluid mb-3 col-sm-3">
            @endif
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endforeach --}}



<!-- Filter Modal -->
{{-- <div class="modal fade" id="filterCategoryModal" tabindex="-1" aria-labelledby="filterCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="filterCategoryModalLabel">Filter</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="GET" action="/admin/categories">
          <div class="form-group">
            <label for="search">Search</label>
            <input class="form-control" type="text" name="search" placeholder="Search Category...">
          </div>
          <!-- Kategori end -->
          <button type="submit" class="btn btn-primary mt-3">Filter</button>
        </form>
      </div>
    </div>
  </div>
</div> --}}
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
        ajax: '{{ route('categories.dashboard') }}',
        columns: [
          {data: null, name: null, className: "text-center"},
          { data: 'name', name: 'name', className: "text-center"},
          {data: 'action', name: 'action', className: "text-center"},
          
        ]
      });

</script>

@endsection