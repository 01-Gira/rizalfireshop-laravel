@extends('admin.layout.layout')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            @include('layouts._flash')
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Users</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                    <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-4">
                        <a class="btn btn-success btn-sm" href="/admin/users/create">
                        <i class="fas fa-plus"> </i>
                        <div class="spinner-border spinner-border-sm" role="status" id="btn-loading">
                        </div>
                        Create User
                        </a>
                    </div>        
                </div>
            </div>
            <div class="card-body"></div>
            <div class="card-footer"></div>
        </div>
    </section>
</div>



@endsection

@section('scripts')
<script>
    $('#btn-loading').hide();

</script>
@endsection