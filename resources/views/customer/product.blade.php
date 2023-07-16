@extends('customer.layout.layout')
@section('customer.content')
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-sm-4">
            <img class="img-fluid w-100" src="{{ asset('storage/' . $product->image) }}" alt=" " /></a>
        </div>

        <div class="col-sm-6">
            <form action="{{ route('product.add', $product) }}" type="POST">
            @csrf
            @method('POST')

            <h2>{{ $product->name }}</h2>
            <input type="text" value="{{ $product->slug }}" hidden>
            <div class="row">
                <label>ARM LENGTH</label>
                <div class="col-md-auto g-0 px-2">
                    <input type="radio" class="btn-check" name="options-lengan" id="lengan1" autocomplete="off">
                    <label class="btn btn-outline-secondary" for="lengan1">Lengan Panjang</label>
                    
                </div>
                <div class="col-md-auto g-0">
                    <input type="radio" class="btn-check" name="options-lengan" id="secondary-lengan2" autocomplete="off">
                    <label class="btn btn-outline-secondary" for="secondary-lengan2">Lengan Pendek</label>
                </div>

            </div>
            
            <div class="row">
                <label>SIZE</label>

                <div class="col-md-auto g-0 mx-2">
                    <input type="radio" class="btn-check" name="options-size" id="size1" autocomplete="off">
                <label class="btn btn-outline-secondary" for="size1">S</label>
                    
                </div>
                <div class="col-md-auto g-0 ml-2">
                    <input type="radio" class="btn-check" name="options-size" id="secondary-size2" autocomplete="off">
                    <label class="btn btn-outline-secondary" for="secondary-size2">M</label>
                </div>
                <div class="col-md-auto g-0 mx-2">
                    <input type="radio" class="btn-check" name="options-size" id="secondary-size3" autocomplete="off">
                    <label class="btn btn-outline-secondary" for="secondary-size3">L</label>
                </div>
                <div class="col-md-auto g-0">
                    <input type="radio" class="btn-check" name="options-size" id="secondary-size4" autocomplete="off">
                    <label class="btn btn-outline-secondary" for="secondary-size4">XL</label>
                </div>
            </div>

            <div class="row">
                <div class="col-2" >
                    <input type="number" style="width: 100%;" class="rounded" required name="quantity" value="1">
                </div>
            </div>
            
            
            <div class="row">
                <div class="col-sm-5">
                    <button type="submit" style="width: 100%;" class="btn btn-danger">Add to cart</button>
                </div>
            </div>
            </form> 

        </div>

    </div>
</div>
@endsection