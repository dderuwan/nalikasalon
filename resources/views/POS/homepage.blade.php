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
                    <form action="{{ route('POS.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Left Side with Images and Names -->
                            <div class="left-side">
                                <input type="text" id="search-bar" class="form-control" placeholder="Search items...">
                                <div class="scrollable-content">
                                    <div class="row" id="item-container">
                                        @foreach ($items as $item)
                                            @if ($item->item_quentity > 1)
                                                <div class="col-item" data-item='@json($item)' data-item-name="{{ $item->item_name}}">
                                                    <div class="custom-card">
                                                        <img src="{{ asset('images/items/' . $item->image) }}" class="custom-card-img-top" alt="{{ $item->item_name }}">
                                                        <div class="custom-card-body-item">
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
                                    <div class="custom-card-body-right">
                                        <!-- Custom Section for Customer Search and Add -->
                                        <div class="customer-section mb-3">
    <div class="input-group-yt">
        <select name="customer_contact_number" class="form-control" id="user_id" required>
            <option value="">Select Customer</option>
            @foreach($customers->unique('id') as $customer)
                <option value="{{ $customer->contact_number_1 }}" data-name="{{ $customer->name }}" data-code="{{ $customer->id }}">
                    {{ $customer->contact_number_1 }}
                </option>
            @endforeach
        </select>
        <button class="btn btn-outline-secondary" type="button" id="add-customer-btn">
            <i class="fe fe-10 fe-plus"></i>
        </button>
    </div>
    <div id="customer-name-display" class="mb-3 mt-3 ml-2" style="font-weight: bold;"></div>
    <input type="hidden" name="customer_code" id="customer_code">
</div>





                                        <!-- Customer Table -->
                                        <div class="tablecontnt">
                                            <div class="scrollable-content">
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

                                        <!-- Billing Section -->
                                        <div class="custom-card">
                                            <div class="custom-card-body-details billing-section">
                                                <div class="form-group1">
                                                    <label for="net-total">Net Total</label>
                                                    <input type="text" class="form-control" name="net_total" id="net-total" readonly>
                                                </div>
                                                <div class="form-group1">
                                                    <label for="discount">Discount</label>
                                                    <input type="text" class="form-control" name="discount" id="discount">
                                                </div>
                                                <div class="form-group1">
                                                    <label for="vat">VAT</label>
                                                    <input type="text" class="form-control" name="vat" id="vat">
                                                </div>
                                                <div class="form-group1">
                                                    <label for="payment-type">Payment Type</label>
                                                    <select class="form-control" name="payment_type" id="payment-type">
                                                        <option value="cash">Cash</option>
                                                        <option value="credit">Credit</option>
                                                        <option value="debit">Debit</option>
                                                    </select>
                                                </div>
                                                <div class="form-group1">
                                                    <label for="paid-amount">Paid Amount</label>
                                                    <input type="text" class="form-control" name="paid_amount" id="paid-amount">
                                                </div>
                                                <div class="form-group1">
                                                    <label for="change">Change</label>
                                                    <input type="text" class="form-control" name="change" id="change" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Calculator Modal -->
                                <div class="modal fade" id="calculatorModal" tabindex="-1" aria-labelledby="calculatorModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="calculatorModalLabel">Calculator</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div id="calculator">
                                                    <input type="text" id="calc-display" class="form-control mb-3" readonly>
                                                    <div class="btn-group">
                                                        <button class="btn btn-secondary calc-btn">7</button>
                                                        <button class="btn btn-secondary calc-btn">8</button>
                                                        <button class="btn btn-secondary calc-btn">9</button>
                                                        <button class="btn btn-secondary calc-btn">/</button>
                                                    </div>
                                                    <div class="btn-group">
                                                        <button class="btn btn-secondary calc-btn">4</button>
                                                        <button class="btn btn-secondary calc-btn">5</button>
                                                        <button class="btn btn-secondary calc-btn">6</button>
                                                        <button class="btn btn-secondary calc-btn">*</button>
                                                    </div>
                                                    <div class="btn-group">
                                                        <button class="btn btn-secondary calc-btn">1</button>
                                                        <button class="btn btn-secondary calc-btn">2</button>
                                                        <button class="btn btn-secondary calc-btn">3</button>
                                                        <button class="btn btn-secondary calc-btn">-</button>
                                                    </div>
                                                    <div class="btn-group">
                                                        <button class="btn btn-secondary calc-btn">0</button>
                                                        <button class="btn btn-secondary calc-btn">.</button>
                                                        <button class="btn btn-secondary calc-btn">C</button>
                                                        <button class="btn btn-secondary calc-btn">+</button>
                                                    </div>
                                                    <div class="btn-group">
                                                        <button class="btn btn-primary calc-btn w-100">=</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="custom-card">
                                    <div class="custom-card-body-grand d-flex justify-content-between align-items-center">
                                        <div class="form-group2">
                                            <label for="grand-total">Grand Total</label>
                                            <input type="text" class="form-control" name="grand_total" id="grand-total" readonly>
                                        </div>
                                        <div class="button-group">
                                            <button class="btn btn-secondary" id="calculator-btn">
                                                <i class="fa fa-calculator"></i>
                                            </button>
                                            <button class="btn btn-danger ml-2" id="cancel-btn">Cancel</button>
                                            <button type="submit" class="btn btn-primary float-center">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form> 
                </div>

                <!-- All Orders Section -->
                <div class="custom-tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab"> 
                        <div class="container-fluid">
                            <div class="row justify-content-center">
                                <div class="col-12">
                                    <div class="row mb-2">
                                        <div class="col-md-6" >
                                            <h2>All Orders</h2>
                                        </div>
                                    
                                    </div>
                                    <p class="card-text"></p>
                                    <div class="row my-4">
                                        <!-- Small table -->
                                        <div class="col-md-12">
                                            <div class="card shadow">
                                                <div class="card-body">
                                                    <table class="table datatables" id="dataTable-1">
                                                        <thead>
                                                            <tr>
                                                                
                                                                <th style="color: black;">Order Code</th>
                                                                <th style="color: black;">Date</th>
                                                                <th style="color: black;">Customer Code</th>
                                                                <th style="color: black;">Total Cost</th>
                                                                <th style="color: black;" width="200px">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($orders as $order)
                                                            <tr>
                                                                <td>{{ $order->order_code }}</td>
                                                                <td>{{ $order->date }}</td>
                                                                <td>{{ $order->customer_code }}</td>
                                                                <td>{{ $order->total_cost_payment }}</td>
                                                                <td>
                                                                    <!-- Show Button -->
                                                                    <a href="{{ route('showopos', $order->id) }}" class="btn btn-secondary"><i class="fe fe-eye fe-16"></i></a>

                                                                    <!-- Delete Button -->
                                                                    <button class="btn btn-danger" onclick="confirmDelete({{ $order->id }})"><i class="fe fe-trash fe-16"></i></button>
                                                                    <form id="delete-form-{{ $order->id }}" action="{{ route('deletepos', $order->id) }}" method="POST" style="display:none;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- All Orders Section -->
                <div class="custom-tab-pane" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <h2>Today's Orders</h2>
                                    </div>
                                </div>
                                <p class="card-text"></p>
                                <div class="row my-4">
                                    <div class="col-md-12">
                                        <div class="card shadow">
                                            <div class="card-body">
                                                <table class="table datatables" id="dataTable-1">
                                                    <thead>
                                                        <tr>
                                                            <th style="color: black;">Order Code</th>
                                                            <th style="color: black;">Date</th>
                                                            <th style="color: black;">Customer Code</th>
                                                            <th style="color: black;">Total Cost</th>
                                                            <th style="color: black;" width="200px">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($orders as $order)
                                                            @if ($order->date == $today)
                                                                <tr>
                                                                    <td>{{ $order->order_code }}</td>
                                                                    <td>{{ $order->date }}</td>
                                                                    <td>{{ $order->customer_code }}</td>
                                                                    <td>{{ $order->total_cost_payment }}</td>
                                                                    <td>
                                                                        <!-- Show Button -->
                                                                        <a href="{{ route('showopos', $order->id) }}" class="btn btn-secondary"><i class="fe fe-eye fe-16"></i></a>

                                                                        <!-- Delete Button -->
                                                                        <button class="btn btn-danger" onclick="confirmDelete({{ $order->id }})"><i class="fe fe-trash fe-16"></i></button>
                                                                        <form id="delete-form-{{ $order->id }}" action="{{ route('deletepos', $order->id) }}" method="POST" style="display:none;">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                            
                                    <form action="{{ route('POS.customerstore') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="name">Name</label>
                                                    <input type="text" class="form-control" id="name" name="name"  required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="contact_number_1">Contact Number : </label>
                                                    <input type="text" class="form-control" id="contact_number_1" name="contact_number_1"  required>
                                                </div>

                                                
                                                <div class="mb-3">
                                                    <label for="address">Address</label>
                                                    <input type="text" class="form-control" id="address" name="address"  required>
                                                </div>



                                                <div class="text-center">
                                                <button type="submit" class="btn btn-primary float-center">Submit</button>
                                                </div>

                                            </form>
                                            
                                </div>
                                       
                        </div>
                </div>
                            
            </div>
        </div>
    </div>

</main>
@endsection


@section('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Existing code...

        // Calculator functionality
        const calculatorDisplay = document.getElementById('calc-display');
        const calculatorButtons = document.querySelectorAll('.calc-btn');

        calculatorButtons.forEach(button => {
            button.addEventListener('click', function() {
                const buttonText = this.textContent;
                if (buttonText === '=') {
                    try {
                        calculatorDisplay.value = eval(calculatorDisplay.value);
                    } catch (error) {
                        calculatorDisplay.value = 'Error';
                    }
                } else if (buttonText === 'C') {
                    calculatorDisplay.value = '';
                } else {
                    calculatorDisplay.value += buttonText;
                }
            });
        });

        document.getElementById('calculator-btn').addEventListener('click', function() {
            new bootstrap.Modal(document.getElementById('calculatorModal')).show();
        });

        // Tab switching functionality
        const tabs = document.querySelectorAll('.custom-nav-link');
        const tabPanes = document.querySelectorAll('.custom-tab-pane');

        tabs.forEach(tab => {
            tab.addEventListener('click', function(event) {
                event.preventDefault();
                const targetPaneId = this.getAttribute('href').substring(1);

                tabs.forEach(t => t.classList.remove('active'));
                tabPanes.forEach(pane => pane.classList.remove('active'));

                this.classList.add('active');
                document.getElementById(targetPaneId).classList.add('active');
            });
        });

        // Ensure the first tab is active on page load
        tabs[0].classList.add('active');
        tabPanes[0].classList.add('active');
    });
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchBar = document.querySelector('#search-bar');
    const items = document.querySelectorAll('.col-item');
    const itemDetailsTable = document.querySelector('#item-details-table');
    const netTotalInput = document.getElementById('net-total');

    searchBar.addEventListener('input', function() {
        const searchTerm = searchBar.value.toLowerCase();
        items.forEach(item => {
            const itemName = item.getAttribute('data-item-name').toLowerCase();
            item.style.display = itemName.includes(searchTerm) ? 'block' : 'none';
        });
    });

    items.forEach(function(item) {
        item.addEventListener('click', function() {
            const itemData = JSON.parse(this.getAttribute('data-item'));
            let existingRow = null;

            itemDetailsTable.querySelectorAll('tr').forEach(row => {
                if (row.dataset.itemId === String(itemData.id)) {
                    existingRow = row;
                }
            });

            if (existingRow) {
                const quantityInput = existingRow.querySelector('.quantity-input');
                const totalCostCell = existingRow.querySelector('.total-cost');
                quantityInput.value = parseInt(quantityInput.value) + 1;
                if (parseInt(quantityInput.value) > itemData.item_quentity) {
                    notifyExceedQuantity(itemData.item_quentity);
                    quantityInput.value = itemData.item_quentity;
                }
                updateTotalCost(quantityInput, totalCostCell, itemData.unit_price);
            } else {
                const newRow = document.createElement('tr');
                newRow.setAttribute('data-item-id', itemData.id);
                newRow.innerHTML = `
                    <td>${itemData.item_name}</td>
                    <td>${itemData.unit_price}</td>
                    <td class="quantity-display" contenteditable="true">1</td>
                    <td class="total-cost">${itemData.unit_price}</td>
                    <td><button class="btn btn-danger btn-sm remove-item"><i class="fe fe-trash fe-16"></i></button></td>
                    <input type="hidden" name="items[${itemData.id}][item_code]" value="${itemData.item_code}">
                    <input type="hidden" name="items[${itemData.id}][item_name]" value="${itemData.item_name}">
                    <input type="hidden" name="items[${itemData.id}][quantity]" class="hidden-quantity" value="1">
                    <input type="hidden" name="items[${itemData.id}][total]" class="hidden-total" value="${itemData.unit_price}">
                `;

                const quantityElement = newRow.querySelector('.quantity-display');
                const totalCostCell = newRow.querySelector('.total-cost');

                quantityElement.addEventListener('input', function() {
                    let quantity = parseInt(quantityElement.textContent);
                    if (quantity > itemData.quentity) {
                        notifyExceedQuantity(itemData.quentity);
                        quantity = itemData.quentity;
                        quantityElement.textContent = quantity;
                    }
                    updateTotalCost(quantity, totalCostCell, itemData.unit_price);
                    newRow.querySelector('.hidden-quantity').value = quantity;
                    newRow.querySelector('.hidden-total').value = (quantity * itemData.unit_price).toFixed(2);
                    updateNetTotal();
                });

                newRow.querySelector('.remove-item').addEventListener('click', function() {
                    this.closest('tr').remove();
                    updateNetTotal();
                });

                itemDetailsTable.appendChild(newRow);
            }
            updateNetTotal();
        });
    });

    function updateGrandTotal() {
        const netTotal = parseFloat(netTotalInput.value) || 0;
        const discount = parseFloat(document.getElementById('discount').value) || 0;
        const vat = parseFloat(document.getElementById('vat').value) || 0;
        const grandTotal = (netTotal - discount) + vat;
        document.getElementById('grand-total').value = grandTotal.toFixed(2);
        updateChange();
    }

    function updateTotalCost(quantity, totalCostElement, unitPrice) {
        const totalCost = (unitPrice * quantity).toFixed(2);
        totalCostElement.textContent = totalCost;
    }

    function updateNetTotal() {
        let netTotal = 0;
        itemDetailsTable.querySelectorAll('.total-cost').forEach(totalCostCell => {
            netTotal += parseFloat(totalCostCell.textContent);
        });
        netTotalInput.value = netTotal.toFixed(2);
        updateGrandTotal();
    }

    document.getElementById('discount').addEventListener('input', updateGrandTotal);
    document.getElementById('vat').addEventListener('input', updateGrandTotal);

    function updateChange() {
        const grandTotal = parseFloat(document.getElementById('grand-total').value) || 0;
        const paidAmount = parseFloat(document.getElementById('paid-amount').value) || 0;
        const change = paidAmount - grandTotal;
        document.getElementById('change').value = change.toFixed(2);
    }

    document.getElementById('paid-amount').addEventListener('input', updateChange);

    function notifyExceedQuantity(maxQuantity) {
        alert(`Only ${maxQuantity} items available.`);
    }
});

</script>


<script>
    // Show modal to add customer
    $('#add-customer-btn').on('click', function() {
        new bootstrap.Modal(document.getElementById('addCustomerModal')).show();
    });
</script>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Include Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
    $('#user_id').select2({
        placeholder: 'Select or type customer contact number',
        allowClear: true
    });

    // Update customer name and code display when selection changes
    $('#user_id').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var customerName = selectedOption.data('name');
        var customerCode = selectedOption.data('code'); // Get the customer ID
        if (customerName && customerCode) {
            $('#customer-name-display').text('Customer Name: ' + customerName + ' | Customer Code: ' + customerCode);
            $('#customer_code').val(customerCode); // Set the customer ID to the hidden input
        } else {
            $('#customer-name-display').text('');
            $('#customer_code').val(''); // Clear the hidden input if no selection
        }
    });
});

        document.getElementById('cancel-btn').addEventListener('click', function() {
            // Redirect to the same page
            window.location.reload();
        });

    </script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(orderRequestId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + orderRequestId).submit();
            }
        })
    }

    
</script>


@endsection


