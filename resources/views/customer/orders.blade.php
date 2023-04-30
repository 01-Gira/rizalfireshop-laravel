@extends('customer.layout.layout')
@section('customer.content')
<div class="container-fluid">
    <!-- Main content -->
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Orders</h3>
          </div>
          <div class="card-body p-0">
            <table class="table table-striped projects">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Order ID</th>
                  <th>Courier</th>
                  <th>Total Price</th>
                  <th>Status</th>
                  {{-- <th>Size</th>
                  <th>Color</th> --}}
                  <th></th>
                </tr>
              </thead>
              <tbody> 
                @foreach ($orders as $order )
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>
                    <a> {{ $order->order_id }} </a>
                    <br />
                    <small> Created {{ $order->created_at->format('d/m/Y H:i:s') }} </small>
                  </td>
                  <td>
                    <a> {{ $order->courier }} </a>
                  </td>
                  <td>
                    <a> Rp.{{ number_format($order->total_price, 0, ',', '.') }}</a>
                  </td>
                  <td>
                      <a> {{ $order->transaction_status }}</a>
                    </td>
                  {{-- <td>
                    <a> {{ $product->size }} </a>
                  </td>
                  <td>
                    <a> {{ $product->color }} </a>
                  </td> --}}
                  <td class="project-actions text-right">
                    <div class="row">
                      <div class="col">
                        <a class="btn btn-primary btn-sm" href="/orders/{{ $order->order_id }}">
                          <i class="fas fa-folder"> </i>
                          View
                        </a>
                      </div>
                      @if ($order->transaction_status!='capture' && $order->transaction_status!='delivered')
                      <div class="col">
                        <button class="btn btn-success btn-sm" id="pay-button">
                          <i class="fas fa-folder"> </i>
                          Pay now
                        </button>
                        <form id="submit_form" method="post">
                            @csrf
                            <input hidden name="json" id="json_callback">
                            <input type="text" name="order_id" value="{{ $order->order_id }}" hidden>
                        </form>

                        <script>
                            // For example trigger on button clicked, or any time you need
                            var payButton = document.getElementById('pay-button');
                                payButton.addEventListener('click', function () {
                                // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
                                window.snap.pay('{{ $order->snap_token }}', {
                                    onSuccess: function(result){
                                    /* You may add your own implementation here */
                                    send_response_to_form(result);
                                    console.log(result);
                                    },
                                    onPending: function(result){
                                    /* You may add your own implementation here */
                                    send_response_to_form(result);
                                    console.log(result);
                                    },
                                    onError: function(result){
                                    /* You may add your own implementation here */
                                    send_response_to_form(result);
                                    console.log(result);
                                    },
                                    onClose: function(){
                                    /* You may add your own implementation here */
                                    alert('you closed the popup without finishing the payment');
                                    }
                                })
                                });
                            function send_response_to_form(result){
                              document.getElementById('json_callback').value = JSON.stringify(result);
                              $('#submit_form').submit();
                            }
                        </script>
                      </div>   
                      @elseif ($order->transaction_status=='capture') 
                      <div class="col">
                        <a class="btn btn-primary btn-sm" href="{{ $order->pdf_url }}}}">
                          <i class="fas fa-folder"> </i>
                          View Invoice
                        </a>
                      </div>
                      @endif
                      
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <div class="col-12 justify-content-center d-flex">
          {{ $orders->links() }}
        </div>
      </section>
      <!-- /.content -->
</div>

@endsection