@extends('customer.layout.layout')
@section('customer.content')

<div class="container my-5">
    <form action="/checkout" id="shipping-form" method="post">
    @csrf
    <div class="row">
        <div class="col">  

                <div class="row">
                    <div class="col form-group">
                        <label for="name">First Name</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col form-group">
                        <label for="name">Last Name</label>
                        <input type="text" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="street_address">Street Address</label>
                    <input type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="province">Province</label>
                    <select class="form-control" id="province" name="province" required>
                        <option value="">Select Province</option>
                        @foreach($provinces as $province => $value)
                            <option value="{{ $province }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="city">City</label>
                    <select name="city_destination" id="city_destination" class="form-control" required>
                        <option>Select City</option>
                    </select>
                </div>
                <div class="row">
                    <div class="col form-group">
                        <label for="district">District</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col form-group">
                        <label for="postal_code">Postal Code</label>
                        <input type="text" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="message">Message (optional)</label>
                    <textarea name="" class="form-control"></textarea>
                </div>
            
        </div>
        <div class="col-12 col-md-4 col-lg-4">
            <div class="row">
                <div class="col"><h5><b>Checkout</b></h5></div>
                <div class="col">Subtotal</div>
            </div>
            
            <hr>
            @foreach ($cart as $item)
            <div class="row">
                <div class="col">{{ $item['product']->name }} x{{ $item['quantity'] }}</div>
                <div class="col text-right">Rp.{{ number_format($item['sub_total']) }}</div>
                <input type="number" name="weight" hidden value="{{ $weight }}">
            </div>
            @endforeach
            <hr>
            <div class="row">
                <div class="col">Subtotal</div>
                <div class="col text-right">Rp.{{ number_format($subTotal) }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col">
                    <p>Shipping</p>
                    <hr>
                    <div class="form-group">
                        <label for="courier">Courier</label>
                        <select name="courier" id="courier" class="form-control" required>
                            <option value="">Select Courier</option>
                            @foreach($couriers as $courier => $value)
                            <option value="{{ $courier }}">{{ $value }}</option>
                        @endforeach
                        </select>  
                    </div>
                    <div class="form-group">
                        <label for="service">Layanan:</label>
                        <select class="form-control" name="service" id="service">
                          <option value="">Pilih Layanan</option>
                        </select>
                      </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col">Subcharge</div>
                <div class="col text-right">Rp.500</div>
            </div>
            <hr>
            <div class="row">
                <div class="form-group">
                    <label for="total_cost">Total Biaya</label>
                
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-danger">CREATE ORDER</button>
        </div>
    </div>
    </form>
</div>


@endsection