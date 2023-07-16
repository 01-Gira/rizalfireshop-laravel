@extends('admin.layout.layout')
@section('content')
<style>
    .input-field {
       width: 100%; /* Lebar input 100% dari lebar kolom */
    }
    .tag-container {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      flex-direction: column;
      max-height: 120px;
      max-width: 100px;
      overflow-y: auto;
    }


    .tag-bubble {
      display: inline-block;
      padding: 5px 10px;
      background-color: #ffffff;
      border-radius: 20px;
      margin-right: 5px;
      margin-bottom: 5px;
      transition: transform 0.5s ease, box-shadow 0.5s ease, outline 0.5s ease;
    }

    .tag-bubble:hover {
      transform: scale(1.1);
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
      outline: 2px solid rgba(0, 0, 0, 0.3);
    }

 
    .tag-remove {
      margin-left: 5px;
      cursor: pointer;
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
            <h1>Attributes</h1>
          </div>

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
              <li class="breadcrumb-item active">Attributes</li>
            </ol>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <form action="/admin/attributes/store" method="post" id="form-id" type="post">
      @csrf
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-sm-4">
              <h3>Create Attribute</h3>
            </div>        
          </div>
        </div>
        <div class="card-body p-3">
          <table class="table table-striped projects" id="tblMaster">
            <thead>
              <tr>
                <th class="text-center">Attribute Name</th>
                <th class="text-center">Attribute Value</th>

                {{-- <th class="text-center" style="width: 2%;">
                    <button type="button" class="btn btn-default btn-xs" id="btn-add-row"><span class="fa fa-plus"></span></button>
                </th> --}}
              </tr>
            </thead>
            <tbody id="tbody">
              <tr>
                <td class="no-padd text-center">
                  <input type="text" name="name" class="form-control">
                </td>
                <td class="no-padd text-center">
                  <div id="tags-container"></div>
                  <input type="text" class="form-control" id="tags-input" />
                  <input type="hidden" id="tags-value" name="value" />
                  
                </td>
            </tr>
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary" id="btn-save"><i class="fa fa-save"></i> Save</button>
            <a href="/admin/attributes/index" class="btn btn-default" id="btn-cancel">Cancel</a>
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
  var tags = [];
  var rows = [];
  function updateTagsContainer() {
    $('#tags-container').empty();
    
    for (var i = 0; i < tags.length; i++) {
      var bubble = '<span class="tag-bubble">' + tags[i] + '<span class="tag-remove" data-index="' + i + '"><i class="fa fa-close"></i></span></span>';
      $('#tags-container').append(bubble);
    }
    
    $('#tags-value').val(JSON.stringify(tags));

  }
  
  function addTag(tag) {
    tags.push(tag);
    updateTagsContainer();
  }
  
  function removeTag(index) {
    tags.splice(index, 1);
    updateTagsContainer();
  }
  
  $('#tags-input').on('keyup', function(event) {
    if (event.keyCode === 16) { // Tombol Enter ditekan
      event.preventDefault();
      var text = $(this).val().trim();
      
      if (text !== '') {
        addTag(text);
        $(this).val(''); // Reset input setelah menambahkan nilai
      }
    }
  });
  
  $(document).on('click', '.tag-remove', function() {
    var index = $(this).data('index');
    removeTag(index);
  });




  $('#btn-add-row').on('click', function(){
      addRowDock();
  });
  
  function addRowDock() {
      rows = $('#tblMaster tbody tr').length;
      rows = rows+ 1;

      $('#tbody').append('\
      <tr>\
          <td>\
              <input type="text" class="form-control" name="name[]" id="name" required>\
          </td>\
          <td class="no-padd text-center">\
              <div id="tags-container_'+rows+'"></div>\
              <input type="text" id="tags-input_'+rows+'"/>\
              <input type="hidden" id="tags-value_'+rows+'" name="attributes[]"/>\
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