@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <div class="container">
        <h1>GOODS IN NOTE</h1>
        <form action="{{ route('insertgin') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group pb-10">
                <label for="order_request_code">Order Request Code *</label>
                <select name="order_request_code" class="form-control" id="order_request_code" required>
                    <option value="">Select Order</option>
                    @foreach($orderRequests as $orderRequest)
                        <option value="{{ $orderRequest->order_request_code }}">{{ $orderRequest->order_request_code }}</option>
                    @endforeach
                </select>
            </div>

            <div id="order-details" style="display: none;">
                <h3>Order Details</h3>
                <p><strong>Order Request Code:</strong> <span id="order-request-code"></span></p>
                <p><strong>Supplier:</strong> <span id="supplier-name"></span></p>
                <p><strong>Ordered Date:</strong> <span id="ordered-date"></span></p>
                <input type="hidden" name="supplier_code" id="supplier_code">
                <input type="hidden" name="date" id="date">
            </div>

            <table class="table table-bordered" id="items-table">
                <thead>
                    <tr>
                        <th>Item Code</th>
                        <th>Ordered Count</th>
                        <th>Item Name</th>
                        <th>Pack Size</th>
                        <th>Unit Price</th>
                        <th>In Quantity</th>
                        <th>Total Cost</th>
                        <th>Payment</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Rows will be dynamically added here -->
                </tbody>
            </table>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
</main>

<script>
    const orderRequests = @json($orderRequests);

    document.getElementById('order_request_code').addEventListener('change', function() {
        const orderRequestCode = this.value;
        const orderDetails = document.getElementById('order-details');
        const tableBody = document.getElementById('items-table').getElementsByTagName('tbody')[0];

        // Clear existing rows
        tableBody.innerHTML = '';

        if (orderRequestCode) {
            const selectedOrder = orderRequests.find(order => order.order_request_code === orderRequestCode);

            if (selectedOrder && selectedOrder.items) {
                selectedOrder.items.forEach((item, index) => {
                    const newRow = tableBody.insertRow();
                    newRow.innerHTML = `
                    <tr>
                        <td><input type="text" name="orderItems[${index}][item_code]" class="form-control" value="${item.item_code}" readonly></td>
                        <td><input type="text" name="orderItems[${index}][quantity]" class="form-control" value="${item.quantity}" readonly></td>
                        <td><input type="text" name="orderItems[${index}][item_name]" class="form-control" value="${item.item_name}" readonly></td>
                        <td><input type="number" name="orderItems[${index}][pack_size]" class="form-control"></td>
                        <td><input type="number" name="orderItems[${index}][unit_price]" class="form-control unit-price" data-index="${index}" required></td>
                        <td><input type="number" name="orderItems[${index}][in_quantity]" class="form-control in-quantity" data-index="${index}" required></td>
                        <td><input type="number" name="orderItems[${index}][total_cost]" class="form-control total-cost" data-index="${index}" readonly></td>
                        <td>
                            <select name="orderItems[${index}][payment]" class="form-control" required>
                                <option value="paid">Paid</option>
                                <option value="not_paid">Not Paid</option>
                            </select>
                        </td>
                    </tr>
                    `;
                });

                // Add event listeners for unit price and in quantity fields to calculate total cost
                document.querySelectorAll('.unit-price, .in-quantity').forEach(element => {
                    element.addEventListener('input', calculateTotalCost);
                });

                document.getElementById('order-request-code').textContent = selectedOrder.order_request_code;
                document.getElementById('supplier-name').textContent = selectedOrder.supplier_code;
                document.getElementById('ordered-date').textContent = selectedOrder.date;
                document.getElementById('supplier_code').value = selectedOrder.supplier_code;
                document.getElementById('date').value = selectedOrder.date;
                orderDetails.style.display = 'block';
            }
        }
    });

    function calculateTotalCost(event) {
        const index = event.target.dataset.index;
        const unitPrice = parseFloat(document.querySelector(`input[name="orderItems[${index}][unit_price]"]`).value) || 0;
        const inQuantity = parseFloat(document.querySelector(`input[name="orderItems[${index}][in_quantity]"]`).value) || 0;
        const totalCost = unitPrice * inQuantity;
        document.querySelector(`input[name="orderItems[${index}][total_cost]"]`).value = totalCost.toFixed(2);
    }
</script>
@endsection
