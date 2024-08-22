<!DOCTYPE html>
<html>
<head>
    <title>Print Appointment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: black;
        }
        .container {
            width: 80%;
            margin: auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            width: 100%;
            height: auto;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table th, .info-table td {
            padding: 10px;
            text-align: left;
            
        }
        .info-table th {
            background-color: #f2f2f2;
            border-bottom: none;
        }
        .info-table .value-cell {
            text-decoration-thickness: 2px;
        }
        .footer {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .info-table th{
            font-weight:none;
        }

        .footer img{
            width: 100%;
            height: auto;
        }

        .footer div {
            width: 45%;
        }
        .footer p {
            margin: 5px 0;
        }
        .footer .signatures {
            display: flex;
            justify-content: space-between;
        }
        .footer .signatures div {
            text-align: center;
            width: 45%;
            border-top: 1px solid black;
            padding-top: 10px;
        }
        .notes {
            color: red;
            font-size: 12px;
            margin-top: 10px;
            text-align: center;
        }

        .tr1 td {
            border: 1px solid black;
            padding:0px 0px 0px 10px;
        }

        .tr2 td{
            border: 1px solid black;
        }

        .tr3 td{
            border: 1px solid black;
        }

        .value-cell{
            border: 1px solid black;
            white-space: nowrap;
        }
        .empty-space {
            height: 1px;
            line-height: 0; /* Ensures no extra space from line height */
            border: 0; /* Removes any borders */
            padding: 0; /* Removes any padding */
            margin: 0; /* Removes any margin */
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="/assets/images/header.png" alt="Header Image">
        </div>
        <table class="info-table">
            <tr class="tr1">
                <th>Invoice No</th>
                <td class="value-cell">{{ $preorder->Auto_serial_number }}</td>
                <th>Date</th>
                <td class="value-cell">{{ \Carbon\Carbon::parse($preorder->appointment_date)->format('Y-m-d') }}</td>
            </tr>
            <tr class="empty-space">
                <td>&nbsp;</td>
            </tr>
            <tr class="tr2" >
                <th>Name</th>
                <td colspan="3" class="value-cell">{{ $preorder->customer_name }}</td>
            </tr>
            <tr class="empty-space">
                <td>&nbsp;</td>
            </tr>
            <tr class="tr3">
                <th>Contact</th>
                <td class="value-cell">{{ $preorder->customer_contact_1 }}</td>
                <th>Wedding Date</th>
                <td class="value-cell">{{ \Carbon\Carbon::parse($preorder->appointment_date)->format('Y-m-d') }}</td>
            </tr>
            
            <tr>
                <th>Package</th>
                <td>
                    <input type="checkbox" {{ $preorder->Package_name_1 ? 'checked' : '' }}> {{ $preorder->Package_name_1 }}<br>
                </td>
                <th>Bridal Dressing</th>
                <td><input type="checkbox" {{ $preorder->bridal_dressing ? 'checked' : '' }}> {{ $preorder->bridal_dressing }}</td>
            </tr>
            <tr>
                <th>Fresh Bouquet</th>
                <td><input type="checkbox" {{ $preorder->fresh_bouquet ? 'checked' : '' }}> {{ $preorder->fresh_bouquet }}</td>
                <th>Headdress</th>
                <td><input type="checkbox" {{ $preorder->headdress ? 'checked' : '' }}> {{ $preorder->headdress }}</td>
            </tr>
            <tr>
                <th>Jewelry</th>
                <td><input type="checkbox" {{ $preorder->jewelry ? 'checked' : '' }}> {{ $preorder->jewelry }}</td>
                <th>Bride's Maid</th>
                <td><input type="checkbox" {{ $preorder->brides_maid ? 'checked' : '' }}> {{ $preorder->brides_maid }}</td>
            </tr>
            <tr>
                <th>Flower Girls</th>
                <td><input type="checkbox" {{ $preorder->flower_girls ? 'checked' : '' }}> {{ $preorder->flower_girls }}</td>
                <th>Goingaway Dressing</th>
                <td><input type="checkbox" {{ $preorder->goingaway_dressing ? 'checked' : '' }}> {{ $preorder->goingaway_dressing }}</td>
            </tr>
            <tr>
                <th>Homecoming Dress</th>
                <td><input type="checkbox" {{ $preorder->homecoming_dress ? 'checked' : '' }}> {{ $preorder->homecoming_dress }}</td>
                <th>Bouquet Headdress & Jewelry</th>
                <td><input type="checkbox" {{ $preorder->bouquet_headdress_jewelry ? 'checked' : '' }}> {{ $preorder->bouquet_headdress_jewelry }}</td>
            </tr>

            <tr>
                <th>Photographer & Videographer</th>
                <td colspan="3" class="value-cell">
                    Name: {{ $preorder->photographer_name }}<br>
                    Contact No: {{ $preorder->photographer_contact }}
                </td>
            </tr>

            <tr class="empty-space">
                <td>&nbsp;</td>
            </tr>
        
            <tr>
                <th>Pre Shoot Makeup</th>
                <td><input type="checkbox" {{ $preorder->pre_shoot_makeup ? 'checked' : '' }}> {{ $preorder->pre_shoot_makeup }}</td>
                <th>Transport</th>
                <td class="value-cell">{{ $preorder->transport }}</td>
            </tr>
            <tr>
                <th>Hair Setting</th>
                <td><input type="checkbox" {{ $preorder->hair_setting ? 'checked' : '' }}> {{ $preorder->hair_setting }}</td>
                <th>Total</th>
                <td class="value-cell">{{ $preorder->Total_price }}</td>
            </tr>
            <tr>
                <th>Manicure & Pedicure for Bride</th>
                <td><input type="checkbox" {{ $preorder->manicure_pedicure ? 'checked' : '' }}> {{ $preorder->manicure_pedicure }}</td>
                <th>Advanced</th>
                <td class="value-cell">{{ $preorder->Advanced_price }}</td>
            </tr>
            <tr>
                <th>Mother Dressing</th>
                <td><input type="checkbox" {{ $preorder->mother_dressing ? 'checked' : '' }}> {{ $preorder->mother_dressing }}</td>
                <th>Balance</th>
                <td class="value-cell">{{ $preorder->balance }}</td>
            </tr>
        </table>

        <tr class="empty-space">
                <td>&nbsp;</td>
            </tr>
        <div class="footer">
            <div>
                <p></p>
            </div>
            <div class="signatures">
                <div>
                    <p>Authorized Signature</p>
                </div>
                <div>
                    <p>Customer Signature</p>
                </div>
            </div>
        </div>
        <div class="notes">
            <p>You are kindly requested to settle the balance payment before 14 days of the wedding day. If not we will consider as you have canceled the appointment.
            Advance payment will not be refunded or not applicable to use for any other services of the salon under any circumstance and it has to be minimum Rs. 25000/-
            This discount or offer is valid exclusively for this package and if you change the package this offer or discount will not be valid for the new package that you select.</p>
        </div>
        <div class="footer">
            <img src="/assets/images/footer.png" alt="Footer Image">
        </div>
    </div>

    <script>
        window.print();  // Automatically trigger print dialog

        // After printing, redirect to the appointments list
        window.onafterprint = function() {
            window.location.href = "{{ route('showApp') }}";
        };
    </script>
</body>
</html>
