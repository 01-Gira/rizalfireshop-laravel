<nav class="navbar navbar-expand-lg navbar-light bg-light">
  
  <div class="container">
    <button class="navbar-toggler order-first" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="/"><span>Rizal</span> Fire Shop</a>
    <ul class="navbar-nav d-lg-none ml-auto">
      <li class="nav-item">
        @if (Auth::guard('customer')->check())
            <div class="dropdown">
              <a class="nav-link text-danger" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person"></i>
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/logout">Log out</a></li>
              </ul>
            </div>
            @else
              <a class="nav-link text-danger" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">
                  <i class="bi bi-person"></i>
              </a>
            @endif
      </li>
    </ul>
    <ul class="navbar-nav d-lg-none ms-3">
      <li class="nav-item">
        <a href="#" class="text-danger" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2">
          @if ($cart)
          <i class="bi bi-cart-fill"><span class="fs-6">{{ count($cart) }}</span></i>
          @else
          <i class="bi bi-cart"><span class="fs-6">0</span></i>
          @endif
        </a>
      </li>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
          <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNavbar2Label">Cart</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body">
            <ul class="navbar-nav">
              @if ($cart)
                  @foreach ($cart as $cartm)
                  <div class="row">
                    <div class="row main align-items-center">
                        <div class="col-2"><img class="img-fluid" src="{{ asset('storage/'. $cartm['product']->image) }}"></div>
                        <div class="col">
                            <div class="row text-muted">T-shirt</div>
                            <div class="row">{{ $cartm['product']->name }}</div>
                        </div>
                        <div class="col ms-2">
                            <a href="#">-</a><a href="#" class="border">{{ $cartm['quantity'] }}</a><a href="#">+</a>
                        </div>
                        <div class="col">Rp.{{ number_format($cartm['product']->price) }}</div>
                        <div class="col">
                          <form action="{{ route('cart.destroy', $cartm['id']) }}" method="post">
                          @csrf
                          @method('DELETE')
                          <button type="submit"><i class="bi bi-trash"></i></button>
                          </form>
                        </div>
                    </div>
                  </div>
                  @endforeach
                  @if(session()->has('warning'))
                    <div class="alert alert-danger alert-dismissible fade show m-auto" role="alert">
                      {{ session('warning') }}
                      <button type="button" class="close btn btn-danger" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                  @endif
                  <a href="/checkout" class="btn btn-danger mt-2">Procced to checkout</a>
                  @else
                  <p>Cart is empty</p>
                  @endif
            </ul>
          </div>
        </div>
    </ul>
    <div class="offcanvas offcanvas-start"  tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item d-lg-none m-2" style="width: 100%">
            <form action="/shop" method="GET">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Search Product..." name="search" required>
                <div class="input-group-append">
                  <button type="submit" class="btn btn-danger input-group-text ms-1">
                    <i class="bi bi-search"></i>
                  </button>
                </div>
            </div>
            </form>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ $active == 'home' ? 'active' : '' }}" aria-current="page" href="/">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ $active == 'shop' ? 'active' : '' }}" href="/shop">Shop</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ $active == 'about' ? 'active' : '' }}" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ $active == 'contact' ? 'active' : '' }}" href="#">Contact</a>
          </li>
          <li class="nav-item d-none d-lg-block">
            <a class="nav-link text-danger" href="#" data-bs-toggle="modal" data-bs-target="#searchModal">
              <i class="bi bi-search"></i>
            </a>
          </li> 
          <li class="nav-item d-none d-lg-block">
            @auth
            <p>{{ auth()->user()->name; }}</p>
              
            @endauth
          </li>
          <li class="nav-item d-none d-lg-block">
            <div class="dropdown">
              <a class="nav-link text-danger" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                @if ($cart)
                <i class="bi bi-cart-fill"><span>{{ count($cart) }}</span></i>
                @else
                <i class="bi bi-cart"><span class=""></span></i>
                @endif
              </a>
              <ul class="dropdown-menu">
                <div class="container">
                  <div class="row">
                    @if ($cart)
                    @foreach ($cart as $item)
                    
                      <div class="col-2"><img class="img-fluid" src="{{ asset('storage/'. $item['product']->image) }}"></div>
                      <div class="col">
                          <div class="row text-muted">T-shirt</div>
                          <div class="row">{{ $item['product']->name }}</div>
                      </div>
                      <div class="col ms-2">
                          <a href="#">-</a><a href="#" class="border">{{ $item['quantity'] }}</a><a href="#">+</a>
                      </div>
                      <div class="col">Rp.{{ number_format($item['product']->price) }}</div>
                      <div class="col">
                        <form action="{{ route('cart.destroy', $item['id']) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit"><i class="bi bi-trash"></i></button>
                        </form>
                      </div>
                    @endforeach
          
                    @else
                    <p>Cart is empty</p>
                    @endif
                  </div>
                  <a type="button" href="/cart" class="btn mb-1 mt-2" style="width: 100%; background-color: gray; color:white;">Cart</a>
                  <a type="button" href="/checkout" class="btn btn-danger" style="width: 100%">Procced to checkout</a>
              </div>
              </ul>
            </div>
          </li>
          @auth
          <li class="nav-item d-none d-lg-block">
            <div class="dropdown">
              <a class="nav-link text-danger" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person"></i>
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/orders">Orders</a></li>
                <li><a class="dropdown-item" href="/logout">Log out</a></li>
              </ul>
            </div>
          </li>
          @else
          <a class="nav-link text-danger" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">
            <i class="bi bi-person"></i>
          </a>
          @endauth
        </ul>
      </div>
    </div>
  </div>
</nav> 


<!-- Search Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="searchModalLabel">Search</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
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
  </div>
</div>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="loginModalLabel">Login</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <!-- Tab bar -->
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link text-black active" data-bs-toggle="tab" role="tab" href="#sign-tabpane">Sign in</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-black" data-bs-toggle="tab" role="tab" href="#register-tabpane">Register</a>
          </li>
        </ul>
        <!-- Tab content -->
        <div class="tab-content">
          <div id="sign-tabpane" class="tab-pane fade show active"> 
            <form action="{{ url('/login') }}" method="post">
              <div class="content m-3">
                <!-- Login form here -->
                @csrf
                <div class="input-group mb-3">
                  <input type="email" name="email" class="form-control
                    @error('email')
                    is-invalid
                    @enderror" placeholder="Email" required/>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <i class="bi bi-person"></i>
                    </div>
                  </div>
                  @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="input-group mb-3">
                  <input
                    type="password"
                    name="password"
                    class="form-control
                    @error('password')
                    is-invalid
                    @enderror"
                    placeholder="Password" 
                    required
                  />
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <i class="bi bi-lock"></i>
                    </div>
                  </div>
                  @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="row">
                  <div class="col-8">
                    <div class="icheck-primary">
                      <input type="checkbox" id="remember" />
                      <label for="remember"> Remember Me </label>
                    </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-6" style="width: 100%">
                    <p>Doesnt have have an account yet? <a data-bs-toggle="tab" role="tab" href="#register-tabpane">Register</a> now!</p>
                  </div>
                 
                  <!-- /.col -->
                </div>
                <button type="submit" class="btn btn-danger btn-block mt-2" style="width: 100%">
                  Sign In
                </button>
             </div>            
          </form>
          </div>
          <div id="register-tabpane" class="tab-pane fade">
            <form action="/register" method="post">
              @csrf
              <div class="content m-3">
                <!-- Login form here -->
                <div class="input-group mb-3">
                  <input type="email" name="email" class="form-control
                    @error('email')
                    is-invalid
                    @enderror" placeholder="Email" required/>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <i class="bi bi-envelope"></i>
                    </div>
                  </div>
                  @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="row">
                  <div class="col">
                    <div class="input-group mb-3">
                      <input type="name" name="name" class="form-control
                        @error('name')
                        is-invalid
                        @enderror" placeholder="First Name" required/>
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <i class="bi bi-person"></i>
                        </div>
                      </div>
                      @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                      @enderror
                    </div>
                  </div>
                  <div class="col">
                    <div class="input-group mb-3">
                      <input type="name" name="name" class="form-control
                        @error('name')
                        is-invalid
                        @enderror" placeholder="Last Name" required/>
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <i class="bi bi-person"></i>
                        </div>
                      </div>
                      @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input
                    type="password"
                    name="password"
                    class="form-control
                    @error('password')
                    is-invalid
                    @enderror"
                    placeholder="Password" 
                    required
                  />
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <i class="bi bi-lock"></i>
                    </div>
                  </div>
                  @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="row">
                  <div class="col-8">
                    <div class="icheck-primary">
                      <input type="checkbox" id="remember" required/>
                      <label for="remember"> Aggreed </label>
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn btn-danger btn-block mt-2" style="width: 100%">
                  Register
                </button>
             </div>            
          </form>
          </div>
        </div>
      </div>
      {{-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> --}}
    </div>
  </div>
</div>

@include('layouts._flash');