<!DOCTYPE html>
<html>
<head>
    <title>Final Appointment Bill</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: black;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            margin: auto;
            padding: 10px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .bill {
            width: 48%;
            margin: 10px 1%;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
            display: inline-block;
            vertical-align: top;
            box-sizing: border-box;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        .header, .footer {
            text-align: center;
        }
        .header img, .footer img {
            width: 100%;
            height: auto;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table th, .info-table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .info-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .final-message {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin-top: 15px;
            color: #333;
        }
        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .signatures div {
            text-align: center;
            width: 45%;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }
        .invoice-header {
            margin-bottom: 15px;
        }
        .invoice-header h2 {
            margin: 0;
            font-size: 22px;
            text-align: center;
        }
        .invoice-header p {
            margin: 3px 0;
            text-align: center;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- First Bill -->
        <div class="bill">
            <div class="header">
                <img src="/assets/images/header.png" alt="Header Image">
            </div>

            <div class="invoice-header">
                <h2>Final Appointment Bill</h2>
                <p>Invoice No: {{ $preorder->Auto_serial_number }}</p>
                <p>Date: {{ \Carbon\Carbon::parse($preorder->today)->format('Y-m-d') }}</p>
            </div>

            <table class="info-table">
                <tr>
                    <th>Customer Name</th>
                    <td>{{ $preorder->customer_name }}</td>
                </tr>
                <tr>
                    <th>Contact</th>
                    <td>{{ $preorder->contact_number_1 }}</td>
                </tr>
                <tr>
                    <th>Total</th>
                    <td>{{ $preorder->total_price }}</td>
                </tr>
                <tr>
                    <th>Advanced</th>
                    <td>{{ $preorder->advanced_payment }}</td>
                </tr>
                <tr>
                    <th>Balance</th>
                    <td>{{ $preorder->Balance_Payment }}</td>
                </tr>
            </table>

            <div class="signatures">
                <div>Authorized Signature</div>
                <div>Customer Signature</div>
            </div>

            <div class="final-message">
                Order complete. Please come again!
            </div>

            <div class="footer">
                <img src="/assets/images/footer.png" alt="Footer Image">
            </div>
        </div>

        <!-- Second Bill (same as first) -->
        <div class="bill">
            <div class="header">
                <img src="/assets/images/header.png" alt="Header Image">
            </div>

            <div class="invoice-header">
                <h2>Final Appointment Bill</h2>
                <p>Invoice No: {{ $preorder->Auto_serial_number }}</p>
                <p>Date: {{ \Carbon\Carbon::parse($preorder->today)->format('Y-m-d') }}</p>
            </div>

            <table class="info-table">
                <tr>
                    <th>Customer Name</th>
                    <td>{{ $preorder->customer_name }}</td>
                </tr>
                <tr>
                    <th>Contact</th>
                    <td>{{ $preorder->contact_number_1 }}</td>
                </tr>
                <tr>
                    <th>Total</th>
                    <td>{{ $preorder->total_price }}</td>
                </tr>
                <tr>
                    <th>Advanced</th>
                    <td>{{ $preorder->advanced_payment }}</td>
                </tr>
                <tr>
                    <th>Balance</th>
                    <td>{{ $preorder->Balance_Payment }}</td>
                </tr>
            </table>

            <div class="signatures">
                <div>Authorized Signature</div>
                <div>Customer Signature</div>
            </div>

            <div class="final-message">
                Order complete. Please come again!
            </div>

            <div class="footer">
                <img src="/assets/images/footer.png" alt="Footer Image">
            </div>
        </div>
    </div>

    <script>
        window.print(); // Automatically trigger print dialog

        window.onafterprint = function() {
            window.location.href = "{{ route('appointments') }}";
        };
    </script>
</body>
</html>
