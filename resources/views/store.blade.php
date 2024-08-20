@extends('layouts.app')

@section('content')

<style>
    .card {
        height: 100%;
        width: 300px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
    }

    .card-body {
        padding: 10px;
        
    }

    .card2-img {
        max-height: 200px;
        overflow: hidden;
    }

    .product-image {
        width: 300px;
        height: 200px;
        object-fit: cover;
    }

    .logoContent {
        color: black;
        margin-top: 30px;
    }

    .hero1 {
        background-size: cover;
        background-position: center;
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hero-container {
        text-align: center;
    }

    .hero-container h2 {
        color: white;
        font-size: 36px;
        font-weight: bold;
    }

    .center-icon {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .search-bar-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .search-bar {
        width: 70%;
        max-width: 500px;
    }

    .container1 {
        width: 100%;
        margin: 0 ;
    }
</style>

<div class="container1">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="hero1" style="background-image: url('{{ asset('images/homeimg.jpg') }}');">
                <div class="hero-container">
                    <h2 id="content-title">ONLINE STORE</h2>
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="search-bar-container">
        <div class="input-group search-bar">
            <div class="form-outline flex-grow-1">
                <input type="search" id="searchInput" class="form-control" placeholder="Search" />
            </div>
            <button type="button" class="btn btn-primary shadow-0">
                <i class="fas fa-search"></i>
            </button>
            <a href="{{ route('shopping_cart') }}" class="btn btn-primary center-icon ms-2">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
            </a>
        </div>
    </div>
    <hr class="mb-5">


    <div class="container">
        <div class="section menu" id="product-list">
            <div class="container" data-aos="fade-up">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title text-center mb-5 col-middle">
                            <h1 class="block-title mb-5">Products</h1>
                        </div>
                    </div>
                </div>
                <div class="row" id="products-container">
                    @foreach ($item_list as $item)
                    <div class="col-lg-4 col-md-6 mb-4 product-item" data-name="{{ $item->item_name }}">
                        <div class="card border-0 menu-item box-shadow-lg rounded-0">
                            <a href="{{ route('products.show', $item->id) }}" class="card2-img position-relative product-link">
                                <img 
                                    src="{{ $item->image ? asset('images/items/' . $item->image) : asset('images/items/default.png') }}" 
                                    class="product-image img-fluid wd_xs_100" 
                                    alt="{{ $item->item_name }}">
                            </a>
                            <div class="card-body text-center">
                                <h6 class="card-title mb-0 weeklyoffer-title text-dark product-name">{{ $item->item_name }}</h6>
                                <h6 class="card-title mb-0 weeklyoffer-title text-primary price">Rs {{ number_format($item->unit_price, 2) }}</h6>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>

   
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center mb-4 mt-5" id="pagination">
                <li class="page-item" id="prevPage">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li class="page-item active"><a class="page-link" href="#" data-page="1">1</a></li>
                <li class="page-item"><a class="page-link" href="#" data-page="2">2</a></li>
                <li class="page-item" id="nextPage">
                    <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>

        <script>
            document.getElementById('searchInput').addEventListener('input', searchProducts);

            function searchProducts() {
                var query = document.getElementById('searchInput').value.toLowerCase();
                var products = document.querySelectorAll('.product-item');

                products.forEach(function(product) {
                    var productName = product.getAttribute('data-name').toLowerCase();
                    if (productName.includes(query)) {
                        product.style.display = 'block';
                    } else {
                        product.style.display = 'none';
                    }
                });
            }
        </script>
    </div>
</div>
@endsection
