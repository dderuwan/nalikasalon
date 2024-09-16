@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <div class="container">
        <h1>Edit Orders</h1>
        <form action="{{ route('RealstoreSalonThretment2') }}"  method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="custom-card" id="card02pre">
                <h2>Order Details</h2>

                <div class="row">
                    <!-- Order ID -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Booking_number">Order ID</label>
                            <input type="text" class="form-control" name="Booking_number" value="{{ $preorder->Booking_number }}" readonly>
                        </div>
                    </div>

                    <!-- Customer Name -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="customer_name">Customer Name</label>
                            <input type="text" class="form-control" name="customer_name" value="{{ $preorder->customer_name }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Service ID -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="service_id">Service ID</label>
                            <input type="text" class="form-control" name="service_id" value="{{ $preorder->service_id }}" readonly>
                        </div>
                    </div>

                    <!-- Package ID -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="package_id">Package ID</label>
                            <input type="text" class="form-control" name="package_id" value="{{ $preorder->package_id }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Total Price -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="total_price">Total Price</label>
                            <input type="text" class="form-control" name="total_price" id="total_price" value="{{ $preorder->total_price }}" readonly>
                        </div>
                    </div>
                </div>
            </div>



            <div class="custom-card" id="card02pre">
                <h2>Main Dressers And Assistances</h2>
                <!-- Select Main Dresser -->
                <div class="form-group">
                    <label for="main_dresser">Main Dresser *</label>
                    <select name="main_dresser" class="form-control" required>
                        <option value="">Select Main Dresser</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ $preorder->main_dresser == $employee->id ? 'selected' : '' }}>
                                {{ $employee->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Assistant</th>
                            <th>Commission Type</th>
                            <th>Price</th>
                            <th>Commission Amount</th> <!-- Add this column to show the calculated commission -->
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 0; $i < 3; $i++)
                            <tr>
                                <!-- Assistant Dropdown -->
                                <td>
                                    <select name="assistants[]" class="form-control">
                                        <option value="">Select Assistant</option>
                                        @foreach($assemployees as $employee)
                                            <option value="{{ $employee->id }}"
                                                {{ isset($preorder->assistants[$i]) && $preorder->assistants[$i] == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->full_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                <!-- Commission Type Dropdown -->
                                <td>
                                    <select name="commission_type[]" class="form-control commission-type" data-row="{{ $i }}" required>
                                        <option value="">Select Commission Type</option>
                                        <option value="percentage" {{ isset($preorder->commission_type[$i]) && $preorder->commission_type[$i] == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                        <option value="fixed" {{ isset($preorder->commission_type[$i]) && $preorder->commission_type[$i] == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                    </select>
                                </td>

                                <!-- Price Input -->
                                <td>
                                    <input type="number" name="price[]" class="form-control price-input" data-row="{{ $i }}" placeholder="Enter Price" value="{{ isset($preorder->price[$i]) ? $preorder->price[$i] : '' }}" required>
                                </td>

                                <!-- Commission Amount (calculated) -->
                                <td>
                                    <input type="text" class="form-control commission-amount" id="commission-amount-{{ $i }}" value="" readonly>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>

            <div class="custom-card" id="card02pre">
                <h2>Item Vastage For Order</h2>

                <table class="table table-bordered" id="items-table">
                    <thead>
                        <tr>
                            <th style="color: black;">Item Name *</th>
                            <th style="color: black;">Vastage Slots</th>
                            <th style="color: black;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select name="items[0][item_name]" class="form-control" required>
                                    <option value="">Select Item</option>
                                    @foreach($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->item_name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="text" name="items[0][vastage_slots]" class="form-control" required></td>
                            <td><button type="button" class="btn btn-danger remove-row">Delete</button></td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="btn btn-primary" id="add-row">Add New Item</button>
            </div>

            <button type="submit" class="btn btn-success">Update</button>
        </form>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const totalPriceInput = document.getElementById('total_price');
    
    document.querySelectorAll('.commission-type').forEach(function(selectElement) {
        selectElement.addEventListener('change', function() {
            const row = selectElement.getAttribute('data-row');
            const type = selectElement.value;
            calculateCommission(row, type);
        });
    });

    document.querySelectorAll('.price-input').forEach(function(priceInput) {
        priceInput.addEventListener('input', function() {
            const row = priceInput.getAttribute('data-row');
            const type = document.querySelector(`select[name="commission_type[]"][data-row="${row}"]`).value;
            calculateCommission(row, type);
        });
    });

    function calculateCommission(row, type) {
        const totalPrice = parseFloat(totalPriceInput.value) || 0;
        const priceInput = document.querySelector(`input[name="price[]"][data-row="${row}"]`);
        const commissionAmountInput = document.getElementById(`commission-amount-${row}`);

        if (type === 'percentage') {
            const percentage = parseFloat(priceInput.value) || 0;
            const commission = (totalPrice * percentage) / 100;
            commissionAmountInput.value = commission.toFixed(2);
        } else if (type === 'fixed') {
            commissionAmountInput.value = parseFloat(priceInput.value).toFixed(2);
        } else {
            commissionAmountInput.value = '';
        }
    }
});

</script>



<script>
    let rowIndex = 1;
    const items = @json($items); // Pass PHP variable to JavaScript

    document.getElementById('add-row').addEventListener('click', function() {
        const table = document.getElementById('items-table').getElementsByTagName('tbody')[0];
        const newRow = table.insertRow();
        let itemOptions = '<option value="">Select Item</option>';

        // Generate options for items dropdown
        items.forEach(function(item) {
            itemOptions += `<option value="${item.id}">${item.item_name}</option>`;
        });

        newRow.innerHTML = `
            <tr>
                <td>
                    <select name="items[${rowIndex}][item_name]" class="form-control" required>
                        ${itemOptions}
                    </select>
                </td>
                <td><input type="text" name="items[${rowIndex}][vastage_slots]" class="form-control" required></td>
                <td><button type="button" class="btn btn-danger remove-row">Delete</button></td>
            </tr>
        `;
        rowIndex++;
    });

    document.getElementById('items-table').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-row')) {
            e.target.closest('tr').remove();
        }
    });
</script>
@endsection


<style>
    
  #card02pre{
    margin-top:20px;
    padding:20px 20px 20px 30px;
  }
</style>