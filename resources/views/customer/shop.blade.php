@extends('customer.layout.layout')
@section('customer.content')
<div class="container-fluid p-5">
    <div class="row px-xl-5">
        <!-- Shop Sidebar Start -->
        <div class="col-lg-3 col-md-12">
            <h2 class="text-uppercase mb-3">Filter</h2>
            <form method="GET" action="/shop">
                <!-- Price Range Start -->
                <div class="form-group">
                <label for="price_range">Range Harga:</label>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Harga Min" name="min_price">
                    <span class="input-group-text">-</span>
                    <input type="text" class="form-control" placeholder="Harga Max" name="max_price">
                </div>
                </div>
                <!-- Price Range End -->

                <!-- Filter review -->
                <div class="form-group">
                    <label for="filter-rating">Filter by Rating:</label>
                    <select class="form-control" id="filter-rating" name="filter-rating">
                    <option value="">-- Select rating --</option>
                    <option value="5">5 Stars</option>
                    <option value="4">4 Stars</option>
                    <option value="3">3 Stars</option>
                    <option value="2">2 Stars</option>
                    <option value="1">1 Star</option>
                    </select>
                </div>
                <!-- Filter Review End -->

                <!-- Sortir Start -->
                <div class="form-group">
                <label for="sort">Sortir:</label>
                <select class="form-control" id="sort" name="sort">
                    <option value="">Tidak Ada</option>
                    <option value="sale desc">Terpopuler</option>
                    <option value="created_at desc">Terbaru</option>
                    <option value="price asc">Termurah</option>
                    <option value="price desc">Termahal</option>
                </select>
                </div>
                <!-- Sortir End -->

                <!-- Kategori -->
                <div class="form-group">
                    <label for="category">Category:</label>
                    <select name="category" id="category" class="form-control">
                        <option value="">Select one</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                          {{ $category->name }}
                        </option>
                      @endforeach
                    </select>
                </div>
                <!-- Kategori end -->
                <button type="submit" class="btn btn-danger mt-3">Filter</button>
            </form>
        </div>
        <!-- Shop Sidebar End -->
        <div class="col-lg-9 col-md-12 mt-2">
            <div class="row pb-3">
                <div class="col-12 pb-1">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <form action="/shop">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search Product..." name="search" required>
                                <div class="input-group-append">
                                  <button type="submit" class="btn btn-danger input-group-text ms-1">
                                    <i class="bi bi-search"></i>
                                  </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @foreach ($products as $product)
                <div class="col-lg-4 col-md-6 col-sm-12 pb-1">
                    <div class="card product-item border-0 mb-4">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <img class="img-fluid w-100" src="{{ asset('storage/' . $product->image) }}" alt=" " /></a>
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3">{{ $product->name }}</h6>
                            <div class="d-flex justify-content-center">
                                <h6>Rp.{{ number_format($product->price, 0, ',', '.') }}</h6>
                            </div>
                            <div class="d-flex mb-3 justify-content-center">
                                <div class="text-primary mr-2">
                                    <small class="far fa-star"></small>
                                </div>
                                <small class="pt-1"></small>
                            </div>
                            <div class="card-footer d-flex justify-content-between bg-light border">
                                <a href="/shop/product/{{ $product->slug }}" class="btn card-link"><i class="bi bi-eye"></i> View</a>
                                <form action="{{ route('cart.add', $product) }}" id="form_cart" method="post" >
                                    @csrf
                                    <button type="submit" class="btn btn-danger card-link" id="btn-add"><i class="bi bi-cart-plus"></i> Add to cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
                @endforeach
            </div>
            <div class="col-12 justify-content-center d-flex">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $('#form_cart').submit(function(e, params){
        e.preventDefault();

    });
</script>
@endsection