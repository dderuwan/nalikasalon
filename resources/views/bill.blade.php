<!DOCTYPE html>
<html>
<head>
    <title>Bill</title>
    <style>
        /* Add your styles here */
    </style>
</head>
<body>
    <h1>Order Bill</h1>
    <p>Order Code: {{ $order->order_code }}</p>
    <p>Date: {{ $order->date }}</p>
    <p>Customer Code: {{ $order->customer_code }}</p>

    <table border="1">
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

    <p>Discount: {{ $order->discount }}</p>
    <p>VAT: {{ $order->vat }}</p>
    <p>Paid Amount: {{ $order->paid_amount }}</p>
    <p>Change: {{ $order->change }}</p>
    <p>Grand Total: {{ $order->total_cost_payment }}</p>
</body>
</html>
