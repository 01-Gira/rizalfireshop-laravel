@extends('admin.layout.layout')
@section('content')
<style>
    .input-field {
       width: 100%; /* Lebar input 100% dari lebar kolom */
    }
 </style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
      @include('layouts._flash')
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Category</h1>
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
      <form action="/admin/tags/store" method="post" id="form_id" type="post">
      @csrf
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-sm-4">
              <h3>Create Tags</h3>
            </div>        
          </div>
        </div>
        <div class="card-body p-3">
          <table class="table table-striped projects" id="tblMaster">
            <thead>
              <tr>
                <th class="text-center">Tag Name</th>
                <th class="text-center" style="width: 2%;">
                    <button type="button" class="btn btn-default btn-xs" id="btn-add-row"><span class="fa fa-plus"></span></button>
                </th>
              </tr>
            </thead>
            <tbody id="tbody">
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary" id="btn-save"><i class="fa fa-save"></i> Save</button> &nbsp;
            <a href="/admin/tags/index" class="btn btn-default" id="btn-cancel">Cancel</a>
            <p class="help-block pull-right has-error"></p>
        </div>
      </div>
      <!-- /.card -->
    </form>
     
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection
@section('scripts')
<script>
    $('#btn-add-row').on('click', function(){
        addRowDock();
    });
    
    function addRowDock() {
        var row = $('#tblMaster tbody tr').length;
        row = row + 1;

        $('#tbody').append('\
        <tr>\
            <td>\
                <input type="text" class="input-field" name="name[]" id="name" required>\
            </td>\
            <td class="no-padd">\
            <center><button type="button" class="btn btn-danger btn-xs mg-top-3" id="btn-delete-row-cycle"><i class="fa fa-trash"></i></button></center>\
            </td>\
        \
        </tr>').children(':last');
    }

    $("#tblMaster tbody").on("click", "button", function()  {
     $(this).closest("tr").remove();
    
    });

</script>

@endsection