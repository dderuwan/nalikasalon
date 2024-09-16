@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row mb-2">    
                    <div class="col-md-12">
                        <a href="{{ route('RealTimeOrderList') }}" class="btn btn-secondary">Back to List</a>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-12">
                        <h2>Real Order Details</h2>
                    </div>
                </div>
                
                <div class="card shadow">
                <div class="card-body">

                    <h5 class="card-title">Customer Details</h5>
                    <p><strong>Customer Name:</strong> {{ $preorder->customer_name }}</p>
                    <p><strong>Customer Contact Number:</strong> {{ $preorder->contact_number_1 }}</p>
                    <p><strong>Booking Reference Number:</strong> {{ $preorder->Auto_serial_number }}</p>
                    <br><br>

                    <h5 class="card-title">Service Details</h5>
                    <p><strong>Service Type:</strong> {{ $preorder->service_id }}</p>
                    <p><strong>Package 1:</strong> {{ $preorder->package_id }}</p>
                    <p><strong>Appointment Date:</strong> {{ $preorder->Appoinment_date }}</p>
                    <p><strong>Appointment Time:</strong> {{ $preorder->Appointment_time }}</p>
                    <br><br>

                    <h5 class="card-title">Assign Staff</h5>
                    <p><strong>Main Job Holder:</strong> {{ $preorder->Main_Dresser }}</p>
                    <p><strong>Assistant 1:</strong> {{ $preorder->Assistent_Dresser_1 ?? 'NOT ASSIGNED YET' }}</p>
                    <p><strong>Assistant 2:</strong> {{ $preorder->Assistent_Dresser_2 ?? 'NOT ASSIGNED YET' }}</p>
                    <p><strong>Assistant 3:</strong> {{ $preorder->Assistent_Dresser_3 ?? 'NOT ASSIGNED YET' }}</p>
                    <p><strong>Note:</strong> {{ $preorder->note }}</p>
                    <br><br>

                    <h5 class="card-title">Payment Details</h5>
                    <p><strong>Gift Voucher Number:</strong> {{ $preorder->Gift_vouchwe_id ?? 'N/A' }}</p>
                    <p><strong>Gift Voucher Price:</strong> {{ $preorder->Gift_voucher_value ?? 'N/A' }}</p>
                    <p><strong>Promotional Code Number:</strong> {{ $preorder->promotion_id ?? 'N/A' }}</p>
                    <p><strong>Promotional Price:</strong> {{ $preorder->Promotiona_value ?? 'N/A' }}</p>
                    <p><strong>Payment Type:</strong> {{ $preorder->payment_method }}</p>
                    <p><strong>Advanced Price:</strong> {{ $preorder->advanced_payment }}</p>
                    <p><strong>Total Discount:</strong> {{ $preorder->Discount ?? 0 }}</p>
                    <p><strong>Total Price:</strong> {{ $preorder->total_price }}</p>
                    <p><strong>Status:</strong> {{ $preorder->status  }}</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>
@endsection
