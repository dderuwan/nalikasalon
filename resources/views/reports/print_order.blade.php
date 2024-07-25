<!-- resources/views/reports/print_order.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Order Report</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        /* Custom styles for print */
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Order Details</h2>
        <p><strong>Order Code:</strong> {{ $order->order_code }}</p>
        <p><strong>Date:</strong> {{ $order->date }}</p>
        <p><strong>Customer Code:</strong> {{ $order->customer_code }}</p>
        <p><strong>Total Cost:</strong> {{ $order->total_cost_payment }}</p>

        <h3>Order Items</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Total Cost</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->item_code }}</td>
                    <td>{{ $item->item_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->total_cost }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <button class="btn btn-primary no-print" onclick="window.print()">Print</button>
    </div>

    <script>
        // Automatically open the print dialog when the page loads
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
