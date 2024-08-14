@extends('layouts.app')

@section('content')
<style>
     .item-row{
        padding:5px;
     }

     .item-icons a{
        font-size: 12px;
     }


     /* shopping cart page*/
    .icon-hover-primary {
        background-color: white !important;
      }
      
      .icon-hover-primary:hover {
        background-color: white !important;
      }
      
      .icon-hover-primary:hover i {
        color: #3b71ca !important;
      }
      .icon-hover-danger {
        background-color: white !important;
      }
      
      .icon-hover-danger:hover {
        background-color: white !important;
      }
      
      .icon-hover-danger:hover i {
        color: #dc4c64 !important;
      }
      
      .quantity-input {
        display: flex;
        align-items: center;
        justify-content: flex-end;
      }
      
      .quantity-input input {
        text-align: center; 
        border: none; 
        box-shadow: none; 
        padding: 0; 
      }
      
      .quantity-input button {
        border: none;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2); 
        padding: 0.5rem;
      }

      .text-orange {
        color: #f55b29;
        font-size:20px;
      }
      
      .btn-no-border {
        border: none !important; 
      }
      
      .btn-no-border i {
        color: inherit; 
      }
      
      .card-body {
        padding: 1.5rem; 
      }
      
      .price-icons {
        display: flex;
        align-items: center;
        justify-content: flex-start;
      }
      
      .price {
        margin-right: 1rem; 
      }

      .btn-checkout {
        color: #fff;
        border: none;
        border-radius: 0; 
        padding: 10px 20px;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center; 
        text-transform: uppercase; 
        transition: background-color 0.3s ease;
      }
      
      
    .item-row {
     border: 1px solid #ddd; 
    border-radius: 5px; 
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); 
    padding: 1rem;
    background-color: #fff;
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

<div class="container mt-3 mb-5">

    <section class="my-5">
        <div class="row gx-1">
            <!-- cart -->
            <div class="col-lg-9">
                <div class="shadow-0">
                    <div class="m-3">
                        @forelse ($cart as $index => $item)
                        <div class="row gy-2 mb-2 item-row">
                            <div class="col-lg-6 d-flex align-items-center"> 
                                <input type="checkbox" class="form-check-input me-3">
                                <img src="{{ $item['image'] ?? '/path/to/default-image.jpg' }}" class="border rounded me-3" style="width: 60px; height: 60px;" />
                                <div>
                                    <a href="#" class="nav-link" style="font-weight: bold; margin-bottom: 0.5rem;">{{ $item['title'] }}</a>
                                    <p class="text-muted" style="margin: 0;"></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row gx-3">

                                    <div class="col-5 d-flex align-items-center">
                                        <p class="text-danger h5 mb-1">Rs. <span class="item-price">{{ $item['price'] }}</span></p>
                                    </div>

                                    <div class="col-4 d-flex align-items-center">
                                        <div class="input-group quantity-input">
                                            <button class="btn btn-white button-minus" type="button">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="text" class="form-control text-center quantity" id="quantity" value="1" aria-label="Quantity" data-price="{{ $item['price'] }}" style="width: 50px;" />
                                            <button class="btn btn-white button-plus" type="button">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                
                                    <div class="col-3 d-flex align-items-center justify-content-end">
                                    <a href="#" class="btn btn-light btn-no-border icon-hover-danger btn-delete-item" data-title="{{ $item['title'] }}">
                                        <i class="fas fa-trash fa-lg text-secondary"></i>
                                    </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <p>No items in the cart</p>
                        @endforelse
                    </div>
                </div>
            </div>


            <!-- summary -->
            <div class="col-lg-3">
                <div class="card summary-card mt-2">
                    <h5 class="p-4">Order Summary</h5>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="mb-2">SubTotal ({{ count($cart) }} items):</p>
                            <p class="mb-2" id="subtotal">Rs. {{ array_sum(array_column($cart, 'price')) }}</p>
                        </div>
                        
                        <hr />
                        <div class="d-flex justify-content-between">
                            <p class="mb-2">Total:</p>
                            <p class="mb-2 fw-bold text-danger" id="total">Rs. {{ array_sum(array_column($cart, 'price')) }}</p>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('checkout') }}" class="btn btn-checkout btn-danger w-100 shadow-0 mb-2"> Proceed To checkout </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.button-plus').on('click', function() {
        const quantityInput = $(this).siblings('.quantity');
        const price = parseFloat(quantityInput.data('price'));
        let currentValue = parseInt(quantityInput.val());
        if (!isNaN(currentValue)) {
            quantityInput.val(currentValue + 1);
            updatePrice();
        }
    });

    $('.button-minus').on('click', function() {
        const quantityInput = $(this).siblings('.quantity');
        const price = parseFloat(quantityInput.data('price'));
        let currentValue = parseInt(quantityInput.val());
        if (!isNaN(currentValue) && currentValue > 1) {
            quantityInput.val(currentValue - 1);
            updatePrice();
        }
    });


    function updatePrice() {
        let subtotal = 0;
        $('.item-row').each(function() {
            const quantity = parseInt($(this).find('.quantity').val());
            const price = parseFloat($(this).find('.item-price').text().replace('Rs. ', ''));
            subtotal += quantity * price;
        });
        $('#subtotal').text('Rs. ' + subtotal.toFixed(2));
        $('#total').text('Rs. ' + subtotal.toFixed(2)); 


        $('.item-row').each(function() {
            const quantity = $(this).find('.quantity').val();
            const title = $(this).find('.btn-delete-item').data('title');
            $.ajax({
                url: `{{ route('cart.update') }}`,
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    title: title,
                    quantity: quantity
                },
                success: function(response) {
                },
                error: function(xhr) {
                }
            });
        });
    }

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


    $(document).ready(function() {
        updateCartCount(); 
    });


$('.btn-delete-item').on('click', function(e) {
    e.preventDefault();

    const title = $(this).data('title');

    $.ajax({
        url: `{{ route('cart.remove', '') }}/${title}`,
        method: 'DELETE',
        data: {
            _token: "{{ csrf_token() }}"
        },
        success: function(response) {
            if (response.success) {
                updateCartCount();
                $(e.target).closest('.item-row').remove(); 
            } else {
                alert('Item could not be removed.');
            }
        },
        error: function(xhr) {
            alert('Something went wrong. Please try again.');
        }
    });
});


});

</script>
@endsection
