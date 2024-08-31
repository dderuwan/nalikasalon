@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row mb-2">    
                    <div class="col-md-12">
                        <a href="{{ route('showPreOrders') }}" class="btn btn-secondary">Back to List</a>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-12">
                        <h2>Pre Order Details</h2>
                    </div>
                </div>
                
                <div class="card shadow">
                    <div class="card-body">
                        
                        <h5 class="card-title">Customer Details</h5>
                        <p><strong>Customer Name:</strong> {{ $preorder->customer_name }}</p>
                        <p><strong>Customer Contact Number:</strong> {{ $preorder->customer_contact_1 }}</p>
                        <p><strong>Booking Reference Number:</strong> {{ $preorder->booking_reference_number }}</p>
                        <p><strong>Customer Address:</strong> {{ $preorder->customer_address }}</p>
                        <br><br>

                        <h5 class="card-title">Service Details</h5>
                        <p><strong>Service Type:</strong> {{ $preorder->Service_type }}</p>
                        <p><strong>Package ID:</strong> {{ $preorder->Package_name_1 }}</p>
                        <p><strong>Appointment Date:</strong> {{ $preorder->appointment_date->format('d-m-Y') }}</p>
                        <p><strong>Appointment Time:</strong> {{ $preorder->appointment_time }}</p>
                        <br><br>

                        <h5 class="card-title">Assign Staff</h5>
                        <p><strong>Main Job Holder:</strong> {{ $preorder->main_job_holder }}</p>
                        <p><strong>Assistant 1:</strong> {{ $preorder->Assistant_1 }}</p>
                        <p><strong>Assistant 2:</strong> {{ $preorder->Assistant_2 }}</p>
                        <p><strong>Assistant 3:</strong> {{ $preorder->Assistant_3 }}</p>
                        <p><strong>Note:</strong> {{ $preorder->note }}</p>

                        <br><br>


                        <h5 class="card-title">Payment Details</h5>
                        <p><strong>Payment Type:</strong> {{ $preorder->payment_type }}</p>
                        <p><strong>Advanced Price:</strong> {{ $preorder->Advanced_price }}</p>
                        <p><strong>Total Price:</strong> {{ $preorder->Total_price }}</p>
                        <p><strong>Status:</strong> {{ $preorder->status }}</p>

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
