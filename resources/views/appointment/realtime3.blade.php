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
                    <h3>Order Details</h3>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="booking_reference_number">Appointment Number:</label>
                            <input type="text" class="form-control" id="booking_reference_number" name="booking_reference_number" value="{{ $preorderDetails->booking_reference_number }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="selected_date">Date:</label>
                            <input type="text" class="form-control" id="selected_date" name="selected_date" value="{{ $preorderDetails->appointment_date }}" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="selected_time">Time:</label>
                            <input type="text" class="form-control" id="selected_time" name="selected_time" value="{{ $preorderDetails->appointment_time }}" readonly>
                        </div>
                        <div class="col-md-6">
                           
                        </div>
                    </div>

                    <br><br>
                    <h3>Service Type & Appoinment</h3>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="Service_type">Service Type:</label>
                            <input type="text" class="form-control" id="Service_type" name="Service_type" value="{{ $preorderDetails->Service_type }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="Package_name_1">Package Name :</label>
                            <input type="text" class="form-control" id="Package_name_1" name="Package_name_1" value="{{ $preorderDetails->Package_name_1 }}" readonly>
                        </div>
                    </div>

                    <br><br>
                    <h3>Customer Details</h3>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="customer_name">Customer Name:</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ $preorderDetails->customer_name }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="customer_code">customer_code:</label>
                            <input type="text" class="form-control" id="customer_code" name="customer_code" value="{{ $preorderDetails->customer_code }}" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="customer_address">Customer Address:</label>
                            <input type="text" class="form-control" id="customer_address" name="customer_address" value="{{ $preorderDetails->customer_address }}" readonly>
                        </div>
                        <div class="col-md-6">
                        <label for="customer_contact_1">Customer Contact:</label>
                            <input type="text" class="form-control" id="customer_contact_1" name="customer_contact_1" value="{{ $preorderDetails->customer_contact_1 }}" readonly>
                        </div>
                    </div>
                    
                    <br><br>
                    <h3>Main Dresser & Assistants</h3>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="main_job_holder">Main Job Holder:</label>
                            <input type="text" class="form-control" id="main_job_holder" name="main_job_holder" value="{{ $preorderDetails->main_job_holder }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="Assistant_1">Assistant 1:</label>
                            <input type="text" class="form-control" id="Assistant_1" name="Assistant_1" value="{{ $preorderDetails->Assistant_1 }}" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="Assistant_2">Assistant 2:</label>
                            <input type="text" class="form-control" id="Assistant_2" name="Assistant_2" value="{{ $preorderDetails->Assistant_2 }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="Assistant_3">Assistant 3:</label>
                            <input type="text" class="form-control" id="Assistant_3" name="Assistant_3" value="{{ $preorderDetails->Assistant_3 }}" readonly>
                        </div>
                    </div>


                    <br><br>
                    <h3>Notes</h3>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="note">Notes:</label>
                            <textarea class="form-control" id="note" name="note">{{ $preorderDetails->note }}</textarea>
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

                                <!-- Gift Voucher and Promotional Code in one row each -->
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="gift_voucher_No">Gift Voucher No</label>
                                        <input type="text" class="form-control" id="gift_voucher_No" name="gift_voucher_No">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="gift_voucher_price">Gift Voucher Price</label>
                                        <input type="number" class="form-control" id="gift_voucher_price" name="gift_voucher_price" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="promotional_code_No">Promotional Code No</label>
                                        <input type="text" class="form-control" id="promotional_code_No" name="promotional_code_No">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="promotional_price">Promotional Price</label>
                                        <input type="number" class="form-control" id="promotional_price" name="promotional_price" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="form-group col-md-6">
                                        <label for="discount">Discount</label>
                                        <input type="number" class="form-control" id="discount" name="discount" >
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="Advanced_price">Advanced Price:</label>
                                        <input type="number" class="form-control" id="Advanced_price" name="Advanced_price" value="{{ $preorderDetails->Advanced_price }}" step="0.01" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="form-group col-md-12">
                                        <label for="Total_price">Total Price:</label>
                                        <input type="number" class="form-control" id="Total_price" name="Total_price" value="{{ $preorderDetails->Total_price }}" step="0.01" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="form-group col-md-12">
                                        <label for="balance">Balance:</label>
                                        <input type="number" class="form-control" id="balance" name="balance" value="" step="0.01">
                                    </div>
                                </div>

                                
                            

                          </div>

                    <div class="form-group">

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            @else
                <p>No details found for this order.</p>
            @endif
            </div>
        </div>
    </div>
</main>
@endsection


<script>
    function calculateBalance() {
        // Get values from the input fields
        var totalPrice = parseFloat(document.getElementById('Total_price').value) || 0;
        var discount = parseFloat(document.getElementById('discount').value) || 0;
        var advancedPrice = parseFloat(document.getElementById('Advanced_price').value) || 0;
        var giftVoucherPrice = parseFloat(document.getElementById('gift_voucher_price').value) || 0;
        var promotionalCodePrice = parseFloat(document.getElementById('promotional_price').value) || 0;

        // Calculate balance
        var balance = totalPrice - (discount + advancedPrice + giftVoucherPrice + promotionalCodePrice);

        // Set balance in the balance field
        document.getElementById('balance').value = balance.toFixed(2);
    }

    // Attach event listeners to relevant fields for real-time calculation and calculate the balance on page load
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('discount').addEventListener('input', calculateBalance);
        document.getElementById('gift_voucher_price').addEventListener('input', calculateBalance);
        document.getElementById('promotional_price').addEventListener('input', calculateBalance);
        document.getElementById('Advanced_price').addEventListener('input', calculateBalance);
        document.getElementById('Total_price').addEventListener('input', calculateBalance);

        // Initial balance calculation on page load
        calculateBalance();
    });
</script>

