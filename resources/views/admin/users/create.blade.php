@extends('admin.layout.layout')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            @include('layouts._flash')
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                    <li class="breadcrumb-item"><a href="/admin/users">User</a></li>
                    <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-header">
    
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