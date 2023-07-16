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
                        <input type="text" name="first_name" class="form-control" required>
                    </div>
                    <div class="col form-group">
                        <label for="name">Last Name</label>
                        <input type="text" name="last_name" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="street_address">Street Address</label>
                    <input type="text" name="street_address" class="form-control" required>
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
                        <input type="text" name="district" class="form-control" required>
                    </div>
                    <div class="col form-group">
                        <label for="postal_code">Postal Code</label>
                        <input type="number" name="postal_code" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="message">Message (optional)</label>
                    <textarea name="message" class="form-control"></textarea>
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
                <div class="col text-right"><span id="subtotal" data-subtotal="{{ $subTotal }}">Rp.{{ number_format($subTotal) }}</span></div>
            </div>
            <hr>
            <div class="row">
                <div class="col">
                    <p>Shipping</p>
                    <hr>
                    <div class="form-group" id="courier-text">
                       <p>Silahkan pilih lokasi terlebih dahulu untuk memunculkan opsi kurir</p>
                    </div>
                    <div class="form-group" id="courier">
                        <label for="courier">Courier</label>
                        <select name="courier" id="courier" class="form-control" required>
                            <option value="">Select Courier</option>
                            @foreach($couriers as $courier => $value)
                            <option value="{{ $courier }}">{{ $value }}</option>
                        @endforeach
                        </select>  
                    </div>
                    <div class="form-group"id="courier-service">
                        <label for="service">Service:</label>
                        <select class="form-control" name="courier_service" id="service">
                          <option>Select Service</option>
                        </select>
                      </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col">Subcharge</div>
                <div class="col text-right"><span id="subcharge" data-subcharge="500"></span>Rp.500</div>
            </div>
            <hr>
            <div class="row">
                <div class="form-group">
                    <label for="total_cost">Total Biaya</label>
                    <span id="total">Rp.0</span>
                    <input type="text" name="total_price" id="total_price" hidden>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-danger" id="btn-submit">CREATE ORDER
                <div class="spinner-border spinner-border-sm" role="status" id="btn-loading">
                    <span class="sr-only"></span>
                </div>
            </button>
            
        </div>
    </div>
    </form>
</div>

@endsection

@section('scripts')
<script>
    $('#courier').hide();
    $('#courier-service').hide();
    $('#btn-loading').hide();
    // Ketika pilihan provinsi diubah
    $('select[name="province"]').on("change", function () {
        let provinceId = $(this).val();
        $("select[name=courier_service]").empty();
        $('#total').text("Rp. 0");
        $('#total_price').empty();

        if (provinceId) {
            $.ajax({
                url: "/province/" + provinceId + "/cities",
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $("select[name=city_destination]").empty();
                    $.each(data, function (key, value) {
                        $('select[name="city_destination"]').append(
                            '<option value="' + key + '">' + value + "</option>"
                        );
                    });
                    $('#courier-text').hide();
                    $('#courier').show();
                    $('#courier-service').show();
                },
                error : function(xhr) {
                    console.log(xhr.responseText)
                }

            });
        } else {
            $('select[name="city_destination"]').empty();
        }
    });

    // Ketika pengguna memilih kurir
    $("select[name=courier]").on("change", function () {
        $("select[name=courier_service]").empty();
        $('#total').text("Rp. 0");
        $('#total_price').empty();
        $('#btn-loading').show();
        $('#btn-submit').prop('disabled', true);

        var courier = $(this).val(); // Ambil nilai kurir yang dipilih
        var city_destination = $("select[name=city_destination]").val(); // Ambil nilai destination
        var weight = $("input[name=weight]").val(); // Ambil nilai weight

        // Buat permintaan ajax ke API RajaOngkir
        $.ajax({
            url: "/checkout/cost",
            method: "POST",
            data: {
                courier: courier,
                city_destination: city_destination,
                weight: weight,
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                // Tampilkan data ongkos kirim ke pengguna
                $('#btn-loading').hide();
                $('#btn-submit').prop('disabled', false);

                var costs = response[0].costs;
                var options = "";
                for (var i = 0; i < costs.length; i++) {
                    options +=
                        '<option value="' +
                        costs[i].service +
                        '" data-cost="' +
                        costs[i].cost[0].value +
                        '">' +
                        costs[i].service +
                        " - Rp" +
                        costs[i].cost[0].value +
                        "</option>";
                }
                $("select[name=courier_service]").html(options);
                updateTotal();
            },
            error: function (xhr) {
                console.log(xhr.responseText);
            },
        });
    });

    // Ketika pengguna memilih layanan pengiriman
    $("select[name=courier_service]").on("change", function () {
        updateTotal();
    });
    // Fungsi untuk memperbarui total biaya
    function updateTotal() {
        var cost = $("select[name=courier_service] option:selected").data(
            "cost"
        ); // Ambil biaya layanan pengiriman yang dipilih
        var subtotal = $("span#subtotal").data("subtotal"); // Ambil subtotal belanja
        var subcharge = $("span#subcharge").data("subcharge");

        // Jika cost tidak valid, set nilai default 0
        if (isNaN(cost)) {
            cost = 0;
        }

        var total = subtotal + subcharge + parseFloat(cost); // Hitung total biaya
        // Tampilkan total biaya ke pengguna
        $("span#total").text("Rp." + number_format(total, 0, ",", "."));
        $("input[name=total_price]").val(total);
    }


    function number_format(number, decimals, dec_point, thousands_sep) {
        decimals = decimals || 0;
        number = parseFloat(number);

        if (isNaN(number) || !isFinite(number)) {
            return "-";
        }

        var parts = [];
        var sign = number < 0 ? "-" : "";
        var integer = Math.abs(Math.round(number)).toString();
        var fraction =
            decimals > 0
                ? dec_point +
                  (Math.abs(number) - integer).toFixed(decimals).slice(2)
                : "";
        var thousands = thousands_sep === undefined ? "," : thousands_sep;
        while (integer.length > 3) {
            parts.unshift(integer.slice(-3));
            integer = integer.slice(0, -3);
        }
        parts.unshift(integer);
        return sign + parts.join(thousands) + fraction;
    }



    $('#shipping-form').on('submit', function(event){
        event.preventDefault();
        var totalText = $('#total').text();

        Swal.fire({
        title: 'Are you sure?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Order'
        }).then(function(result){
        if(result.isConfirmed){
            if (totalText === "Rp. 0") {
            event.preventDefault(); 
            console.log('');
            Swal.fire("Warning","Total price is Rp. 0. Submit prevented.", "error");
            } else {
            Swal.fire("Thank You!", "Please proceed with the payment!", "success").then(function() {
                event.currentTarget.submit(); // Mengirimkan formulir setelah pengguna mengklik tombol "OK"
            });
                
            } 
        }
      
        }).catch(swal.noop);

    });



</script>   
@endsection