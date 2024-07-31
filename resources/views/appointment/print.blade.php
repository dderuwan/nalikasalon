<!DOCTYPE html>
<html>
<head>
    <title>Print Appointment</title>
    <style>
        /* Add your styles here for printing */
    </style>
</head>
<body>
    <h1>Appointment Details</h1>
    <p><strong>Auto Serial Number:</strong> {{ $preorder->Auto_serial_number }}</p>
    <p><strong>Booking Reference Number:</strong> {{ $preorder->booking_reference_number }}</p>
    <p><strong>Customer Code:</strong> {{ $preorder->customer_code }}</p>
    <p><strong>Customer Name:</strong> {{ $preorder->customer_name }}</p>
    <p><strong>Contact Number:</strong> {{ $preorder->customer_contact_1 }}</p>
    <p><strong>Customer Address:</strong> {{ $preorder->customer_address }}</p>
    <p><strong>Customer DOB:</strong> {{ $preorder->customer_dob }}</p>
    <p><strong>Service Type:</strong> {{ $preorder->Service_type }}</p>
    <p><strong>Package 1:</strong> {{ $preorder->Package_name_1 }}</p>
    <p><strong>Package 2:</strong> {{ $preorder->Package_name_2 }}</p>
    <p><strong>Package 3:</strong> {{ $preorder->Package_name_3 }}</p>
    <p><strong>Appointment Date:</strong> {{ $preorder->appointment_date }}</p>
    <p><strong>Appointment Time:</strong> {{ $preorder->appointment_time }}</p>
    <p><strong>Main Job Holder:</strong> {{ $preorder->main_job_holder }}</p>
    <p><strong>Assistant 1:</strong> {{ $preorder->Assistant_1 }}</p>
    <p><strong>Assistant 2:</strong> {{ $preorder->Assistant_2 }}</p>
    <p><strong>Assistant 3:</strong> {{ $preorder->Assistant_3 }}</p>
    <p><strong>Note:</strong> {{ $preorder->note }}</p>
    <p><strong>Payment Type:</strong> {{ $preorder->payment_type }}</p>
    <p><strong>Advanced Price:</strong> {{ $preorder->Advanced_price }}</p>
    <p><strong>Total Price:</strong> {{ $preorder->Total_price }}</p>

    <script>
        window.print();  // Automatically trigger print dialog

        // After printing, redirect to the appointments list
        window.onafterprint = function() {
            window.location.href = "{{ route('appointments') }}";
        };
    </script>
</body>
</html>
