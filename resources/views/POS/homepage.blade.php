@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <div class="custom-card">
        <div class="custom-card-body">
            <ul class="custom-navs" id="myTab" role="tablist">
                <li class="custom-nav-item">
                    <a class="custom-nav-link" id="main-tab" data-toggle="tab" href="/" role="tab" aria-controls="home" aria-selected="true"><i class="fe fe-home fe-16"></i></a>
                </li>
                <li class="custom-nav-item">
                    <a class="custom-nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">New Order</a>
                </li>
                <li class="custom-nav-item">
                    <a class="custom-nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">All Orders</a>
                </li>
                <li class="custom-nav-item">
                    <a class="custom-nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Today Orders</a>
                </li>
            </ul>
            <div class="custom-tab-content" id="myTabContent">
                <div class="custom-tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row">
                        <!-- Left Side with Images and Names -->
                        <div class="left-side">
                            <input type="text" id="search-bar" class="form-control" placeholder="Search items...">
                            <div class="scrollable-content">
                                <div class="row" id="item-container">
                                @foreach ($items as $item)
                                    @if ($item->item_quentity > 1)
                                        <div class="col-item" data-item='@json($item)' data-item-name="{{ $item->item_name }}">
                                            <div class="custom-card">
                                                <img src="{{ asset('images/items/' . $item->image) }}" class="custom-card-img-top" alt="{{ $item->item_name }}">
                                                <div class="custom-card-body">
                                                    <h6 class="custom-card-title">{{ $item->item_name }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Side with Additional Content -->
    <div class="right-side">
        <div class="custom-card shadow">
            <div class="custom-card-body">
                <!-- Custom Section for Customer Search and Add -->
                <div class="customer-section mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control" id="customer-search" placeholder="Type customer's contact number">
                        <button class="btn btn-outline-secondary" type="button" id="add-customer-btn" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <div id="customer-search-results" class="dropdown-menu"></div>
                    <div id="selected-customer" class="mt-3"></div>
                </div>
                <!-- Customer Table -->
                <table class="table table-bordered" id="item-details-table">
                    <tr>
                        <th>Item Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th width="50px">Action</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Add New Customer Modal -->
    <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCustomerModalLabel">Add New Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="add-customer-form">
                        <div class="mb-3">
                            <label for="customer-name" class="form-label">Customer Name</label>
                            <input type="text" class="form-control" id="customer-name" required>
                        </div>
                        <div class="mb-3">
                            <label for="customer-contact" class="form-label">Contact Number</label>
                            <input type="text" class="form-control" id="customer-contact" required>
                        </div>
                        <div class="mb-3">
                            <label for="customer-email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="customer-email">
                        </div>
                        <button type="submit" class="btn btn-primary">Add Customer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


                    </div>
                </div>
                <div class="custom-tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab"> 
                    malshan 
                </div>
                <div class="custom-tab-pane" id="contact" role="tabpanel" aria-labelledby="contact-tab"> 
                    kulathunga 
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.custom-nav-link');
    const tabContents = document.querySelectorAll('.custom-tab-pane');

    tabs.forEach(tab => {
        tab.addEventListener('click', function (event) {
            event.preventDefault();
            
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            const target = tab.getAttribute('href').substring(1);
            
            tabContents.forEach(content => {
                if (content.getAttribute('id') === target) {
                    content.classList.add('active');
                } else {
                    content.classList.remove('active');
                }
            });
        });
    });
    
    // Search functionality
    const searchBar = document.querySelector('#search-bar');
    const items = document.querySelectorAll('.col-item');

    searchBar.addEventListener('input', function() {
        const searchTerm = searchBar.value.toLowerCase();
        
        items.forEach(item => {
            const itemName = item.getAttribute('data-item-name').toLowerCase();
            if (itemName.includes(searchTerm)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });

    document.querySelectorAll('.col-item').forEach(function(item) {
        item.addEventListener('click', function() {
            const itemData = JSON.parse(this.getAttribute('data-item'));
            const itemDetailsTable = document.querySelector('#item-details-table');
            let existingRow = null;

            itemDetailsTable.querySelectorAll('tr').forEach(row => {
                if (row.dataset.itemId === String(itemData.id)) {
                    existingRow = row;
                }
            });

            if (existingRow) {
                const quantityValue = existingRow.querySelector('.quantity-value');
                const totalCostCell = existingRow.querySelector('.total-cost');
                let currentValue = parseInt(quantityValue.textContent);

                if (currentValue < itemData.item_quentity) {
                    quantityValue.textContent = currentValue + 1;
                    updateTotalCost(quantityValue, totalCostCell, itemData.unit_price);
                }
            } else {
                const newRow = document.createElement('tr');
                newRow.setAttribute('data-item-id', itemData.id);
                newRow.innerHTML = `
                    <td>${itemData.item_name}</td>
                    <td>${itemData.unit_price}</td>
                    <td>
                        <div class="quantity">
                            <button class="btn btn-sm btn-secondary decrease-quantity">-</button>
                            <span class="quantity-value">1</span>
                            <button class="btn btn-sm btn-secondary increase-quantity">+</button>
                        </div>
                    </td>
                    <td class="total-cost">${itemData.unit_price}</td>
                    <td><button class="btn btn-danger btn-sm remove-item"><i class="fe fe-trash fe-16"></i></button></td>
                `;

                const quantityValue = newRow.querySelector('.quantity-value');
                const decreaseButton = newRow.querySelector('.decrease-quantity');
                const increaseButton = newRow.querySelector('.increase-quantity');
                const totalCostCell = newRow.querySelector('.total-cost');

                decreaseButton.addEventListener('click', function() {
                    let currentValue = parseInt(quantityValue.textContent);
                    if (currentValue > 1) {
                        quantityValue.textContent = currentValue - 1;
                        updateTotalCost(quantityValue, totalCostCell, itemData.unit_price);
                    }
                });

                increaseButton.addEventListener('click', function() {
                    let currentValue = parseInt(quantityValue.textContent);
                    if (currentValue < itemData.item_quentity) {
                        quantityValue.textContent = currentValue + 1;
                        updateTotalCost(quantityValue, totalCostCell, itemData.unit_price);
                    }
                });

                newRow.querySelector('.remove-item').addEventListener('click', function() {
                    this.closest('tr').remove();
                });

                itemDetailsTable.appendChild(newRow);
            }
        });
    });

    function updateTotalCost(quantityElement, totalCostElement, unitPrice) {
        const quantity = parseInt(quantityElement.textContent);
        const totalCost = (unitPrice * quantity).toFixed(2);
        totalCostElement.textContent = totalCost;
    }
});
</script>

<script>
        document.addEventListener('DOMContentLoaded', function() {
            // Event listener for the Add Customer button
            document.getElementById('add-customer-btn').addEventListener('click', function() {
                new bootstrap.Modal(document.getElementById('addCustomerModal')).show();
            });

            // Handle Add Customer form submission
            document.getElementById('add-customer-form').addEventListener('submit', function(event) {
                event.preventDefault();
                // Get form data
                const customerName = document.getElementById('customer-name').value;
                const customerContact = document.getElementById('customer-contact').value;
                const customerEmail = document.getElementById('customer-email').value;

                // Add customer to the database (AJAX request or form submission)
                // For demonstration, we'll just log the data
                console.log('New Customer:', {
                    name: customerName,
                    contact: customerContact,
                    email: customerEmail
                });

                // Close the modal
                new bootstrap.Modal(document.getElementById('addCustomerModal')).hide();

                // Reset the form
                document.getElementById('add-customer-form').reset();
            });

            // Handle customer search
            document.getElementById('customer-search').addEventListener('input', function() {
                const query = this.value.toLowerCase();
                const customers = @json($customers);

                // Filter customers based on the query
                const results = customers.filter(customer => 
                    customer.contact_number_1.toLowerCase().includes(query)
                );

                // Show results
                const resultsDiv = document.getElementById('customer-search-results');
                resultsDiv.innerHTML = '';
                results.forEach(result => {
                    const div = document.createElement('div');
                    div.textContent = `${result.name} (${result.contact_number_1})`;
                    resultsDiv.appendChild(div);
                });
            });
        });
    </script>
@endsection
