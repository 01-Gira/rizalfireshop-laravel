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
            <h1>Attribute</h1>
          </div>

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
              <li class="breadcrumb-item active">Tags</li>
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
              <a class="btn btn-success btn-sm" href="/admin/attributes/create">
                <i class="fas fa-plus"> </i>
                Create Attribute
              </a>
            </div>        
          </div>
        </div>
        <div class="card-body p-3">
          <div class="col-sm-6 d-flex justify-content-end ml-auto mt-2">
            <a class="btn btn-primary btn-sm" href="#" data-bs-toggle="modal" data-bs-target="#filterCategoryModal">
              Filter Tag
            </a>
          </div>  
          <table class="table table-striped projects" id="tblMaster">
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th class="text-center">Attribute Name</th>
                <th class="text-center">Values</th>

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
        // "order": [[1, 'asc']],
        processing: true,
        // serverSide: true,
        responsive: true,
        "oLanguage": {
          'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
        },
        ajax: '{{ route('attributes.dashboard') }}',
        columns: [
          {data: null, name: null, className: "text-center"},
          { data: 'name', name: 'name', className: "text-center"},
          { data: 'value', name: 'value', className: "text-center"},

          {data: 'action', name: 'action', className: "text-center"},
          
        ]
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
            let url = '{{ route('categories.destroy', 'param') }}';
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
</script>

@endsection