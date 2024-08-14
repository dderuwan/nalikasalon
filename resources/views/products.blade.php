@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
<style>
    .fit {
        max-width: 100%;
        max-height: 100vh;
        margin: auto;
    }
    .product-price span {
        display: inline-block;
        margin-right: 10px;
    }

    .btn-custom-buy {
      color: #fff;
      border: none;
      border-radius: 0; 
      padding: 10px 20px;
      font-size: 16px;
      font-weight: bold;
      transition: background-color 0.3s ease;
    }

    .btn-custom-buy:hover {
      background-color: #fbdb35; 
      color: #fff;
    }
 
    .btn-custom-cart {
      color: #fff;
      border: none;
      border-radius: 0; 
      padding: 10px 20px;
      font-size: 16px;
      font-weight: bold;
      display: flex;
      align-items: center;
      transition: background-color 0.3s ease;
    }
    .btn-custom-cart i {
      margin-right: 8px;
    }
    .btn-custom-cart:hover {
      background-color: #e71f1f; 
    }


    .btn-custom-out-of-stock {
      background-color: #30c1de; 
      color: #fff;
      border: none;
      border-radius: 0; 
      padding: 10px 20px;
      font-size: 16px;
      font-weight: bold;
      cursor: not-allowed;
    }

    .btn-custom-out-of-stock:hover {
      background-color: #30c1de; 
      color: #fff;
      border: none;
      cursor: not-allowed;
    }
   

</style>


<header class="header-bg">
      <div class="p-3 text-center border-bottom">
        <div class="container">
          <div class="row gy-3 justify-content-between align-items-center">
            <div class="col-lg-2 col-md-4 col-0"></div>
            <div class="order-lg-last col-lg-5 col-sm-8 col-12">
              <div class="d-flex justify-content-end">
                <a href="{{ route('shopping_cart') }}" class="border rounded py-1 px-3 nav-link d-flex align-items-center position-relative">
                    <i class="fas fa-shopping-cart m-1 me-md-2 text-black"></i>
                    <span id="cart-count" class="badge bg-warning text-dark rounded-circle position-absolute top-0 start-100 translate-middle p-1 small">0</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>


<div class="container mt-4 mb-5">
    <section class="py-5">
        <div class="container">
            <div class="row gx-5">
                <aside class="col-lg-5">
                    <div class="rounded-4 mb-3 d-flex justify-content-center">
                        <a class="rounded-4 glightbox" data-type="image" href="{{ $item->image ? asset('images/items/' . $item->image) : asset('images/items/default.png') }}">
                            <img id="product-image" style="max-width: 100%; max-height: 100vh; margin: auto;" class="rounded-4 fit" src="{{ $item->image ? asset('images/items/' . $item->image) : asset('images/items/default.png') }}" />
                        </a>
                    </div>
                </aside>

                <main class="col-lg-7">
                    <div class="ps-lg-3">
                        <h4 class="title text-dark">
                            {{ $item->item_name }}
                        </h4>
                        <div class="d-flex flex-row my-3">
                            <span class="text-muted">{{ $item->item_description }}</span>
                        </div>
                        <hr/>

                            <span class="">Availability :</span>
                            <span class="ms-1" style="color:#4caf50;">
                                {{ $item->item_quantity > 0 ? 'In stock' : 'Out of stock' }}
                            </span>

                            <div class="product-price mb-3 mt-3">
                                <span class="h4" style="color:#f55b29;">Rs. {{ $item->unit_price }}</span>
                            </div>

                            @if($item->item_quantity > 0)
                                <div class="d-flex">
                                    <a href="#" class="btn btn-custom-buy btn-warning shadow-0 me-2" onclick="buyNow()">Buy now</a>
                                    <a href="#" class="btn btn-custom-cart  btn-danger shadow-0">
                                        <i class="me-1 fa fa-shopping-cart"></i>Add to cart
                                    </a>
                                </div>
                            @else
                                <a href="#" class="btn btn-custom-out-of-stock shadow-0">
                                    Out of Stock
                                </a>
                            @endif
                        </div>

                    </div>
                </main>
            </div>
        </div>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
   $(document).ready(function() {
   
    function updateCartCount() {
    $.ajax({
        url: '{{ route('cart.count') }}',
        method: 'GET',
        success: function(response) {
            $('#cart-count').text(response.cart_count);
        },
        error: function(xhr) {
            console.log('Error fetching cart count:', xhr);
        }
    });
}

   
    updateCartCount();

    $('.btn-custom-cart').on('click', function(e) {
        e.preventDefault();

        const title = $('.title').text().trim();
        const price = $('.product-price .h4').text().trim().replace('Rs. ', '');
        const image = $('#product-image').attr('src');

        $.ajax({
            url: "{{ route('cart.add') }}",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                title: title,
                price: price,
                image: image
            },
            success: function(response) {
                console.log('Add to cart response:', response); // Check response in console
                updateCartCount();
                alert('Item added to cart!');
            },
            error: function(xhr, status, error) {
                console.error('Error adding to cart:', status, error);
                alert('Something went wrong. Please try again.');
            }
        });
    });


    window.buyNow = function() {
        const title = $('.title').text().trim();
        const price = $('.product-price .h4').text().trim().replace('Rs. ', '');
        const image = $('#product-image').attr('src');

        $.ajax({
            url: "{{ route('cart.add') }}",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                title: title,
                price: price,
                image: image
            },
            success: function(response) {
                console.log('Buy now response:', response); // Check response in console
                updateCartCount();
                window.location.href = "{{ route('shopping_cart') }}";
            },
            error: function(xhr, status, error) {
                console.error('Error during buy now:', status, error);
                alert('Something went wrong. Please try again.');
            }
        });
    }
});


</script>

@endsection
