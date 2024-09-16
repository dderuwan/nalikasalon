@extends('layouts.main.master')

<style>
  #card02pre{
    margin-top:20px;
    padding:20px 20px 20px 50px;
  }

  #balance{
    color:red;
    font-size:18px;
    font-weight:bold;
  }
</style>

@section('content')
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">

            <div class="col-12 mb-5">
            @if($preorderDetails)
            <form action="{{ route('storerealtime34') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $preorderDetails->id }}">
                    <input type="hidden" id="customer_dob" name="customer_dob" value="{{ $preorderDetails->customer_dob }}">
                    <input type="hidden" id="Auto_serial_number" name="Auto_serial_number" value="{{ $preorderDetails->Auto_serial_number}}">
                    
                    <div class="custom-card" id="card02pre">
                        <h3>Order Details</h3>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="Auto_serial_number">Appointment Number:</label>
                                <input type="text" class="form-control" id="Auto_serial_number" name="Auto_serial_number" value="{{ $preorderDetails->Auto_serial_number }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="Appoinment_date">Date:</label>
                                <input type="text" class="form-control" id="Appoinment_date" name="Appoinment_date" value="{{ $preorderDetails->Appoinment_date }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="Appointment_time">Time:</label>
                                <input type="text" class="form-control" id="Appointment_time" name="Appointment_time" value="{{ $preorderDetails->Appointment_time }}" readonly>
                            </div>
                            <div class="col-md-6">
                            
                            </div>
                        </div>

                    </div>
                    <div class="custom-card" id="card02pre">
                        <h3>Service Type & Appoinment</h3>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="service_id">Service Type:</label>
                                <input type="text" class="form-control" id="service_id" name="service_id" value="{{ $preorderDetails->service_id }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="package_name">Package Name :</label>
                                <input type="text" class="form-control" id="package_name" name="package_name" value="{{ $service->package_name }}" readonly>
                            </div>
                        </div>

                    </div>

                    <div class="custom-card" id="card02pre">
                    <h3>Customer Details</h3>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="customer_name">Customer Name:</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ $preorderDetails->customer_name }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="customer_id">customer_code:</label>
                            <input type="text" class="form-control" id="customer_id" name="customer_id" value="{{ $preorderDetails->customer_id }}" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        
                        <div class="col-md-6">
                            <label for="contact_number_1">Customer Contact:</label>
                            <input type="text" class="form-control" id="contact_number_1" name="contact_number_1" value="{{ $preorderDetails->contact_number_1 }}" readonly>
                        </div>
                    </div>
                    </div>

                    <div class="custom-card" id="card02pre">

                                <h5 class="modal-title" id="paymentModalLabel">Payment Details</h5>
                                
                            <br>
                                <!-- Payment fields -->
                                <div class="form-group">
                                    <label for="paymentMethod">Payment Method</label>
                                    <select class="form-control" id="paymentMethod" name="payment_method" required>
                                        <option value="">Select Payment Method</option>
                                        <option value="credit_card">Credit Card</option>
                                        <option value="debit_card">Debit Card</option>
                                        <option value="paypal">PayPal</option>
                                        <option value="cash">Cash</option>
                                    </select>
                                </div>


                                <div class="form-group row">

                                    <div class="form-group col-md-6">
                                        <label for="total_price">Total Price:</label>
                                        <input type="number" class="form-control" id="total_price" name="total_price" value="{{ $preorderDetails->total_price }}" step="0.01" readonly>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="advanced_payment">Advanced Price:</label>
                                        <input type="number" class="form-control" id="advanced_payment" name="advanced_payment" value="{{ $preorderDetails->advanced_payment }}" step="0.01" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="form-group col-md-12">
                                        <label for="balance">Balance:</label>
                                        <input type="number" class="form-control" id="Balance_Payment" name="Balance_Payment" value="{{ $preorderDetails->Balance_Payment }}" step="0.01" readonly>
                                    </div>
                                </div>  

                          </div>

                    <div class="form-group">

                    <button type="submit" class="btn btn-primary">Finish Order</button>
                </form>
            @else
                <p>No details found for this order.</p>
            @endif
            </div>
        </div>
    </div>
</main>
@endsection


