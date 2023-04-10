@extends('customer.layout.layout')
@section('customer.content')

<div class="container mt-5">
    <div class="card p-2">
        <div class="row">
            <div class="col-md-8 cart">
                <div class="title">
                    <div class="row">
                        <div class="col"><b>Shopping Cart</b></div>
                    </div>
                </div>
                @foreach ($cart as $item)
                <div class="row border-top border-bottom">
                    <div class="row main align-items-center">
                        <div class="col-2"><img class="img-fluid" src="{{ asset('storage/'. $item['product']->image) }}"></div>
                        <div class="col">
                            <div class="row text-muted">Shirt</div>
                            <div class="row">{{ $item['product']->name }}</div>
                        </div>
                        <div class="col ms-2">
                            Rp.{{ number_format($item['product']->price) }}
                        </div>
                        <div class="col">
                            <a href="">-</a><a href="#" class="border">{{ $item['quantity'] }}</a><a href="">+</a>
                        </div>
                        <div class="col">Rp.{{ number_format($item['sub_total']) }}</div>
                        <div class="col">
                            <form action="{{ route('cart.destroy', $item['id']) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                          </div>
                    </div>
                </div>
                @endforeach   
                <div class="coupon mt-2">
                    <input type="text" name="" id="" placeholder="coupon code">
                    <button class="btn btn-danger">apply coupon</button>
                </div>
               
            </div>
            <div class="col-md-4 summary">
                <div><h5><b>Summary</b></h5></div>
                <hr>
                <div class="row">
                    <div class="col">Subtotal</div>
                    <div class="col text-right">Rp.{{ number_format($subTotal) }}</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col">Total</div>
                    <div class="col text-right">Rp.{{ number_format($subTotal) }}</div>
                </div>
                <hr>
                <a href="/checkout" class="btn btn-danger">PROCCED TO CHECKOUT</a>
            </div>
        </div>
        
    </div>
</div>

@endsection