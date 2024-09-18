@extends('layouts.main.master')

@section('content')
<style>
  #customerDetails {
      padding: 15px;
  }

  .customer-info {
      margin-bottom: 10px;
      color: black;
      font-size: 15px;
  }

  .customer-info strong {
      display: inline-block;
      width: 100px;
      margin-right:20px;
  }

  #timeSlots {
      padding: 10px;
      border: 1px solid #ddd; 
      border-radius: 4px; 
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); 
      background-color: #FAF9F9; 
      display: flex; 
      flex-wrap: wrap; /* Allows items to wrap to the next line if needed */
      gap: 10px; /* Space between time slots */
  }

  .time-slot {
      padding: 10px;
      margin: 0;
      width: 100px; 
      text-align: center;
      border: 1px solid #ccc; 
      border-radius: 4px; 
      background-color: #fff; 
      cursor: pointer; 
      transition: background-color 0.3s, border-color 0.3s;
      flex: 0 1 auto; /* Flex item can grow and shrink as needed */
  }

  .time-slot:hover {
      background-color: #f0f0f0; 
      border-color: #999; 
  }

  .custom-card-bodys {
      padding: 15px;
  }

  #cusd select{
    display: flex;
    flex-direction: column;
  }

  #totalPrice {
    font-weight: bold;
    font-size:20px;
    color: #d9534f; /* Customize the color to suit your design */
  }

  #card02pre{
    margin-top:20px;
    padding:20px 20px 20px 50px;
  }
</style>

<main role="main" class="main-content">

 @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
 @endif
 @if (session('error'))
 <div class="alert alert-danger">
     {{ session('error') }}
 </div>
 @endif
  <div class="custom-card">
    <div class="custom-card-bodys">
      <ul class="custom-navs" id="myTab" role="tablist">
        <li class="custom-nav-item">
          <a class="custom-nav-link active" id="pre-tab" data-toggle="tab" href="#pre" role="tab" aria-controls="home" aria-selected="true">Pre Booking</a>
        </li>
        
      </ul>
      <div class="custom-tab-content" id="myTabContent">
        <div class="custom-tab-pane active" id="pre" role="tabpanel" aria-labelledby="pre-tab">
          <div class="container-fluids">
              <div class="row justify-content-center pl-5 pr-5">
                <div class="col-12">
                  <div class="card shadow mb-4 p-2 pl-3">
                    <div class="card-body">
                      <form action="{{ route('appointment.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="custom-card" id="card02pre">
                        <h3>Main Details</h3>
                        <div class="form-group row">
                          <label for="customerSelect" class="col-sm-2 col-form-label" style="color:black;">Customer <i class="text-danger">*</i></label>
                          <div class="col-sm-6 d-flex align-items-center">
                                <select name="contact_number_1" class="form-control" id="customer_code" required>
                                  <option value="">Select Customer</option>
                                  @foreach($customers as $customer)
                                        <option 
                                            value="{{ $customer->contact_number_1 }}" 
                                            data-name="{{ $customer->name }}" 
                                            data-contact="{{ $customer->contact_number_1 }}" 
                                            data-address="{{ $customer->address }}" 
                                            data-dob="{{ $customer->date_of_birth }}" 
                                            data-code="{{ $customer->customer_code }}">
                                            {{ $customer->contact_number_1 }}
                                        </option>
                                    @endforeach

                              </select>
                              <button class="btn btn-outline-secondary ml-2" type="button" id="add-customer-btn">
                                  <i class="fe fe-10 fe-plus"></i>
                              </button>
                          </div>
                        </div>

                        <!-- Customer details display section -->

                        <div id="customerDetails" class="col-sm-8 mt-4 mb-4" style="display: none;">
                            <div class="customer-info" id="customerName"></div>
                            <div class="customer-info" id="customerContact"></div>
                            <div class="customer-info" id="customerAddress"></div>
                            <div class="customer-info" id="customerDOB"></div>
                        </div>

                        <!-- Hidden input fields for storing customer details -->
                        <input type="hidden" id="hiddenCustomerName" name="customer_name">
                        <input type="hidden" id="hiddenCustomerContact" name="customer_contact">
                        <input type="hidden" id="hiddenCustomerAddress" name="customer_address">
                        <input type="hidden" id="hiddenCustomerDOB" name="customer_dob">
                        <input type="hidden" id="hiddenCustomerId" name="customer_id">


                          <!-- Service Dropdown -->
                          <div class="form-group row">
                              <label for="service-select" class="col-sm-2 col-form-label" style="color:black;">Service <i class="text-danger">*</i></label>
                              <div class="col-md-6">
                                  <select class="form-control" id="service-select" name="service_id" required>
                                      <option value="">Select Service</option>
                                      @foreach($services as $service)
                                          <option value="{{ $service->service_code }}" data-name="{{ $service->service_name }}">
                                              {{ $service->service_code }} - {{ $service->service_name }}
                                          </option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>

                          <!-- Hidden input field for storing the selected service name -->
                          <input type="hidden" id="hiddenServiceName" name="service_name">


                          <!-- Package Dropdowns -->
                          <div class="form-group row">
                              <label for="package-select-1" class="col-sm-2 col-form-label" style="color:black;">Package 01 : <i class="text-danger">*</i></label>
                              <div class="col-md-6">
                                  <select class="form-control" id="package-select-1" name="package_id_1" required>
                                      <option value="">Select Package</option>
                                  </select>
                              </div>
                          </div>

                          <div id="subcategories-container"></div>

                            <!-- Date Selection -->
                            <div class="form-group row">
                                <label for="start_date" class="col-sm-2 col-form-label" style="color:black;">Date <i class="text-danger">*</i></label>
                                <div class="col-md-6">
                                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                                </div>
                            </div>



                            <!-- Time Slot Selection -->
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" style="color:black;">Time Slots <i class="text-danger">*</i></label>
                                <div class="col-md-6">
                                    <div id="timeSlots">
                                                <!-- Time slots will be dynamically populated here -->
                                    </div>
                                    <input type="hidden" id="appointment_time" name="appointment_time" required>
                                </div>
                            </div>

                                    <!-- Appointment Time Display -->
                            <div class="form-group row">
                                <label for="appointmentTime" class="col-sm-2 col-form-label" style="color:black;">Appointment Time <i class="text-danger">*</i></label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="appointmentTime" name="appointment_time" readonly>
                                </div>
                            </div>

                            
                          <!-- Note -->
                          <div class="form-group">
                              <label for="eventNote" class="col-form-label" style="color:black;">Note</label>
                              <textarea class="form-control" id="eventNote" name="note" placeholder="Add some note for your event"></textarea>
                          </div>

                          </div>

                          <div class="custom-card" id="card02pre">
                          <div class="form-group">
                                <h3>Other Package:</h3>
                                @foreach($packagesonly as $package)
                                    <div>
                                        <input type="checkbox" name="otherpackages[]" class="additional-package-checkbox" data-price="{{ $package->price }}" value="{{ $package->id }}">
                                        <label>{{ $package->package_name }} - LKR.{{ $package->price }}</label>
                                    </div>
                                @endforeach
                            </div>
                          </div>

                          <div class="custom-card" id="card02pre">
                            <div class="photographer-info">
                                <h3>Photographer Details</h3>
                                
                                <div class="form-group">
                                    <label for="photographer_name">Photographer Name:</label>
                                    <input type="text" id="photographer_name" name="photographer_name" class="form-control" placeholder="Enter Photographer Name">
                                </div>

                                <div class="form-group">
                                    <label for="photographer_contact">Contact Number:</label>
                                    <input type="text" id="photographer_contact" name="photographer_contact" class="form-control" placeholder="Enter Contact Number">
                                </div>
                            </div>
                            </div>

                            <div class="custom-card" id="card02pre">
                                <div class="hotel-dress-option">
                                    <h3>Going Away to Hotel to Dress</h3>
                                    
                                    <div class="form-group">
                                        <input type="checkbox" id="hotel_dress" name="hotel_dress" value="1">
                                        <label for="hotel_dress">Select if you are going away to a hotel to dress</label>
                                    </div>
                                </div>
                            </div>

                          <div class="custom-card" id="card02pre">

                            <h3>Payments</h3>

                            <!-- Gift Voucher and Promotional Code in one row each -->
                            <div class="form-group row" >    
                                <label for="gift_voucher_Id" class="col-sm-2 col-form-label" style="color:black;">Gift Voucher Number</label>
                                <div class="col-md-6">
                                    <select name="gift_voucher_Id" class="form-control" id="gift_voucher_Id" >
                                        <option value="">Select Gift Voucher </option>
                                        @foreach($giftvouchers->unique('gift_voucher_Id') as $voucher)
                                            <option value="{{ $voucher->gift_voucher_Id }}">{{ $voucher->gift_voucher_Id }}</option>
                                        @endforeach
                                    </select>
                                </div>    
                            </div>

                            <div class="form-group row"> 
                                <label for="gift_voucher_price" class="col-sm-2 col-form-label" style="color:black;">Gift Voucher Price</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" id="gift_voucher_price" name="gift_voucher_price" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="promotions_Id" class="col-sm-2 col-form-label" style="color:black;">Promotional Code No</label>
                                <div class="col-md-6">
                                    <select name="promotions_Id" class="form-control" id="promotions_Id" >
                                        <option value="">Select Promotional Code</option>
                                        @foreach($promotions->unique('promotions_Id') as $promotion)
                                            <option value="{{ $promotion->promotions_Id }}">{{ $promotion->promotions_Id }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                            </div>

                            <div class="form-group row">
                                <label for="promotional_price" class="col-sm-2 col-form-label" style="color:black;">Promotional Price</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" id="promotional_price" name="promotional_price" readonly>
                                </div>
                            </div>

                            <!-- Transport -->
                            <div class="form-group row">
                                <label for="Transport" class="col-sm-2 col-form-label" style="color:black;">Transport Cost:</label>
                                    
                                <div class="col-md-6">
                                    <input type="number" id="Transport" name="Transport" class="form-control" placeholder="Enter Transpotation cost">
                                </div>
                            </div>

                            <!-- Discount -->
                            <div class="form-group row">
                                <label for="Discount" class="col-sm-2 col-form-label" style="color:black;">Discount:</label>
                                    
                                <div class="col-md-6">
                                    <input type="number" id="Discount" name="Discount" class="form-control" placeholder="Enter Discount">
                                </div>
                            </div>

                            <!-- Payment Method -->
                            <div class="form-group row">
                                <label for="paymentMethod" class="col-sm-2 col-form-label" style="color:black;">Payment Method <i class="text-danger">*</i></label>
                                <div class="col-md-6">
                                    <select class="form-control" id="paymentMethod" name="payment_method" required>
                                        <option value="">Select Payment Method</option>
                                        <option value="credit_card">Credit Card</option>
                                        <option value="debit_card">Debit Card</option>
                                        <option value="paypal">PayPal</option>
                                        <option value="cash">Cash</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Advanced Payment -->
                            <div class="form-group row">
                                <label for="advancedPayment" class="col-sm-2 col-form-label" style="color:black;">Advanced Payment <i class="text-danger">*</i></label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" id="advancedPayment" name="advanced_payment" required>
                                </div>
                            </div>

                            <!-- Balance Payment -->
                            <div class="form-group row">
                                <label for="BalancePayment" class="col-sm-2 col-form-label" style="color:black;">Balance Payment</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" id="BalancePayment" name="Balance_Payment" readonly>
                                </div>
                            </div>

                            <!-- Total Price -->
                            <div class="form-group row">
                                <label for="totalPrice" class="col-sm-2 col-form-label" style="color:black;">Total Price <i class="text-danger">*</i></label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="totalPrice" name="total_price" readonly>
                                </div>
                            </div>

                          </div>

                          <div class="form-group row">
                            <div class="col-sm-10 mt-5">
                              <button type="submit" class="btn btn-primary">Save Appointment</button>
                            </div>
                          </div>
                      </form>
                    </div>
                  </div>

                  
                </div>
              </div>
            </div>
        </div>

        
      </div>
    </div>

    <!-- Add New Customer Modal -->
    <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                        <div class="modal-content">
                                        
                            <div class="modal-header">
                                <h5 class="modal-title" id="addCustomerModalLabel">Add New Customer</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                            
                                    <form action="{{ route('POS.customerstore') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="name">Name</label>
                                                    <input type="text" class="form-control" id="name" name="name"  required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="contact_number_1">Contact Number 1 : </label>
                                                    <input type="text" class="form-control" id="contact_number_1" name="contact_number_1"  required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="contact_number_2">Contact Number 2 : </label>
                                                    <input type="text" class="form-control" id="contact_number_2" name="contact_number_2" >
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label for="address">Address</label>
                                                    <input type="text" class="form-control" id="address" name="address"  required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="date_of_birth">Date of Birth</label>
                                                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"  required>
                                                </div>


                                                <div class="text-center">
                                                <button type="submit" class="btn btn-primary float-center">Submit</button>
                                                </div>

                                            </form>
                                            
                                </div>
                                       
                        </div>
                </div>
                            
            </div>
  </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Select2 on the select element
    $('#customer_code').select2({
        placeholder: 'Select or type customer contact number',
        allowClear: true
    });

    // Update customer details display when selection changes
    $('#customer_code').on('change', function() {
    var selectedOption = $(this).find('option:selected');
    var name = selectedOption.data('name') || 'N/A';
    var contact = selectedOption.data('contact') || 'N/A';
    var address = selectedOption.data('address') || 'N/A';
    var dob = selectedOption.data('dob') || 'N/A';
    var code = selectedOption.data('code') || 'N/A';

    if (name && contact && address && dob) {
        $('#customerDetails').show();
        $('#customerName').html('<strong>Name:</strong> ' + name);
        $('#customerContact').html('<strong>Contact:</strong> ' + contact);
        $('#customerAddress').html('<strong>Address:</strong> ' + address);
        $('#customerDOB').html('<strong>Date of Birth:</strong> ' + dob);
        
        // Set the hidden input fields
        $('#hiddenCustomerName').val(name);
        $('#hiddenCustomerContact').val(contact);
        $('#hiddenCustomerAddress').val(address);
        $('#hiddenCustomerDOB').val(dob);
        $('#hiddenCustomerId').val(code);

    } else {
        $('#customerDetails').hide();
        
        // Clear the hidden input fields
        $('#hiddenCustomerName').val('');
        $('#hiddenCustomerContact').val('');
        $('#hiddenCustomerAddress').val('');
        $('#hiddenCustomerDOB').val('');
        $('#hiddenCustomerId').val('');
    }
});

    // Show modal to add customer
    $('#add-customer-btn').on('click', function() {
        new bootstrap.Modal(document.getElementById('addCustomerModal')).show();
    });

    // Redirect to the same page on cancel
    $('#cancel-btn').on('click', function() {
        window.location.reload();
    });

    $('#service-select').on('change', function() {
    var selectedOption = $(this).find('option:selected');
    var serviceName = selectedOption.data('name') || '';

    // Set the hidden input field with the service name
    $('#hiddenServiceName').val(serviceName);
});

});
</script>


<script>
document.addEventListener('DOMContentLoaded', function() {
  

    timeSlots.forEach(function(timeSlot) {
        timeSlot.addEventListener('click', function() {
            appointmentTimeInput.value = timeSlot.textContent.trim();
        });
    });

    // Tab switching functionality
    const tabs = document.querySelectorAll('.custom-nav-link');
    const tabPanes = document.querySelectorAll('.custom-tab-pane');

    tabs.forEach(tab => {
        tab.addEventListener('click', function(event) {
            event.preventDefault();
            const targetPaneId = this.getAttribute('href').substring(1);

            tabs.forEach(t => t.classList.remove('active'));
            tabPanes.forEach(pane => pane.classList.remove('active'));

            this.classList.add('active');
            document.getElementById(targetPaneId).classList.add('active');
        });
    });

    // Ensure the first tab is active on page load
    tabs[0].classList.add('active');
    tabPanes[0].classList.add('active');
});

var timeSlots = document.querySelectorAll('.time-slot');
    var appointmentTimeInput = document.getElementById('appointmentTime');

timeSlots.forEach(function(timeSlot) {
        timeSlot.addEventListener('click', function() {
            appointmentTimeInput.value = timeSlot.textContent.trim();
        });
    });
</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Select2 for gift voucher search
    $('#gift_voucher_Id').select2({
        placeholder: "Select Gift Voucher",
        allowClear: true
    });

    // On change of the selected gift voucher, fetch its price
    $('#gift_voucher_Id').on('change', function() {
        let giftVoucherId = $(this).val();

        // Get the current total price from the input field
        let totalPrice = parseFloat($('#totalPrice').val());
        
        if (giftVoucherId) {
            // Perform AJAX request to get the gift voucher price
            $.ajax({
                url: '/get-gift-voucher-price/' + giftVoucherId,
                type: 'GET',
                success: function(data) {
                    if (data.success) {

                        let giftPrice = parseFloat(data.price);
                        // Update the price input field with the fetched price
                        $('#gift_voucher_price').val(giftPrice.toFixed(2));
                        
                        updateTotalPrice(giftPrice);
                    } else {
                        // Clear the price field if no voucher is found
                        $('#gift_voucher_price').val('');
                        updateTotalPrice();
                    }
                },
                error: function(err) {
                    console.log('Error fetching gift voucher details:', err);
                }
            });
        } else {
            // Clear the price input if no voucher is selected
            $('#gift_voucher_price').val('');
            updateTotalPrice();
        }
    });
});
</script>

<script>
$(document).ready(function() {
    // Initialize Select2 for searchable dropdown
    $('#promotions_Id').select2({
        placeholder: "Select Promotional Code",
        allowClear: true
    });

    // Event listener for selecting a promotion ID
    $('#promotions_Id').on('change', function() {
        let promotionId = $(this).val();

        // Get the current total price from the input field
        let totalPrice = parseFloat($('#totalPrice').val());

        if (promotionId) {
            // AJAX request to fetch the promotional price
            $.ajax({
                url: '/get-promotion-price/' + promotionId, // Adjust the URL based on your route
                type: 'GET',
                success: function(data) {
                    if (data.success) {
                        // Fetch the promotional price (assuming it's a percentage)
                        let promotionalPrice = parseFloat(data.price);

                        // Calculate the discounted price (total price * promotional percentage) / 100
                        let discountedPrice = (totalPrice * promotionalPrice) / 100;

                        // Display the promotional price and discounted price
                        $('#promotional_price').val(discountedPrice.toFixed(2)); // Display the percentage
                        updateTotalPrice(discountedPrice);
                        
                    } else {
                        alert(data.message);
                        $('#promotional_price').val('');
                        updateTotalPrice();
                    }
                },
                error: function(err) {
                    console.log('Error fetching promotion details:', err);
                }
            });
        } else {
            // Reset the promotional price if no promotion is selected
            $('#promotional_price').val('');
            updateTotalPrice();
        }
    });
});
</script>


<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    // Function to update total price
    function updateTotalPrice() {
        var total = 0;
        $('#package-select-1, #package-select-2, #package-select-3').each(function() {
            var packagePrice = $(this).find('option:selected').data('price');
            if (packagePrice) {
                total += parseFloat(packagePrice);
            }
        });
        // Add the prices of selected additional packages
        $('.additional-package-checkbox:checked').each(function() {
            var packagePrice = $(this).data('price');
            if (packagePrice) {
                total += parseFloat(packagePrice);
            }
        });

        // Add the transport cost if entered
        var transportCost = parseFloat($('#Transport').val());
        if (!isNaN(transportCost)) {
            total += transportCost;
        }

        // Subtract the discount if entered
        var discount = parseFloat($('#Discount').val());
        if (!isNaN(discount)) {
            total -= discount;
        }

        var gift = parseFloat($('#gift_voucher_price').val());
        if (!isNaN(gift)) {
            total -= gift;
        }
        
        var promo = parseFloat($('#promotional_price').val());
        if (!isNaN(promo)) {
            total -= promo;
        }

        

        // Ensure the total is not negative
        if (total < 0) {
            total = 0;
        }

        // Update the total price field
        $('#totalPrice').val(total.toFixed(2));

        // Calculate and update the balance payment
        var advancedPayment = parseFloat($('#advancedPayment').val());
        if (isNaN(advancedPayment)) {
            advancedPayment = 0;
        }
        var balancePayment = total - advancedPayment;

        if (balancePayment < 0) {
            balancePayment = 0;
        }

        $('#BalancePayment').val(balancePayment.toFixed(2));
    
    }

    // Event handler for package dropdown change
    $('#package-select-1, #package-select-2, #package-select-3').change(function() {
        var selectedPackageId = $(this).val();
        console.log("Selected Package ID: " + selectedPackageId);

        // Fetch subcategories for the selected package
        if (selectedPackageId) {
            $.ajax({
                url: '{{ route("getSubcategoriesByPackage") }}',
                method: 'GET',
                data: { package_id: selectedPackageId },
                success: function(response) {
                    var container = $('#subcategories-container');
                    container.empty();

                    response.subcategories.forEach(function(subcategory) {
                        // Create dropdown for each subcategory
                        var subcategoryHtml = `
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" style="color:black;">${subcategory.subcategory_name}:</label>
                                <div class="col-md-6">
                                    <select class="form-control item-select" data-subcategory-id="${subcategory.id}" name="subcategory_items[${subcategory.id}]">
                                        <option value="">Select Item</option>
                                    </select>
                                </div>
                            </div>
                        `;
                        container.append(subcategoryHtml);

                        // Fetch items for the subcategory
                        $.ajax({
                            url: '{{ route("getItemsBySubcategory") }}',
                            method: 'GET',
                            data: { subcategory_id: subcategory.id },
                            success: function(response) {
                                var itemSelect = container.find(`select[data-subcategory-id="${subcategory.id}"]`);
                                response.items.forEach(function(item) {
                                    var option = `<option value="${item.id}">${item.Item_name}</option>`;
                                    itemSelect.append(option);
                                });
                            },
                            error: function(xhr) {
                                console.error('Failed to fetch items:', xhr.responseText);
                            }
                        });
                    });

                    updateTotalPrice();
                },
                error: function(xhr) {
                    console.error('Failed to fetch subcategories:', xhr.responseText);
                }
            });
        } else {
            $('#subcategories-container').empty();
        }
    });

    // Event handler for additional package checkbox change
    $('.additional-package-checkbox').change(function() {
        updateTotalPrice();
    });

    // Event handler for transport cost input change
    $('#Transport').on('input', function() {
        updateTotalPrice();
    });

    $('#Discount').on('input', function() {
        updateTotalPrice();
    });


    $('#advancedPayment').on('input', function() {
        updateTotalPrice();
    });

    // Existing service-select change event handler
    $('#service-select').change(function() {
        var serviceCode = $(this).val();

        $('#package-select-1').empty().append('<option value="">Select Package</option>');
        $('#package-select-2').empty().append('<option value="">Select Package</option>');
        $('#package-select-3').empty().append('<option value="">Select Package</option>');

        if (serviceCode) {
            $.ajax({
                url: '{{ route("getPackagesByService") }}',
                method: 'GET',
                data: { service_code: serviceCode },
                success: function(response) {
                    response.packages.forEach(function(package) {
                        var option = `<option value="${package.id}" data-price="${package.price}">${package.package_name}</option>`;
                        $('#package-select-1').append(option);
                        $('#package-select-2').append(option);
                        $('#package-select-3').append(option);
                    });
                    updateTotalPrice();
                }
            });
        }
    });
});
</script>

<script>
    // Show modal to add customer
    $('#add-customer-btn').on('click', function() {
        new bootstrap.Modal(document.getElementById('addCustomerModal')).show();
    });
</script>


<script>
    function getSelectedPackageId() {
    // Get the package select dropdown element
    var packageSelect = document.getElementById('package-select');

    // Get the selected package ID
    var selectedPackageId = packageSelect.value;

    // Check if a valid package is selected
    if (selectedPackageId) {
        console.log("Selected Package ID:", selectedPackageId);
    } else {
        console.log("No package selected.");
    }
}

</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Define time slots
        const timeSlots = ['First Slot', 'Second Slot', 'Third Slot'];

        // Get the timeSlots div, the hidden input, and the appointment time display input
        const timeSlotsContainer = document.getElementById('timeSlots');
        const appointmentTimeInput = document.getElementById('appointment_time');
        const appointmentTimeDisplay = document.getElementById('appointmentTime');

        // Function to render time slots
        timeSlots.forEach((slot) => {
            // Create a clickable div for each time slot
            const slotElement = document.createElement('div');
            slotElement.textContent = slot;
            slotElement.classList.add('time-slot');

            // Event listener for clicking a slot
            slotElement.addEventListener('click', function () {
                // Highlight the selected time slot
                document.querySelectorAll('.time-slot').forEach(el => el.style.backgroundColor = '#fff'); // Reset background of all slots
                slotElement.style.backgroundColor = '#d1e7dd'; // Highlight selected slot

                // Set the value of the hidden input to the selected time slot
                appointmentTimeInput.value = slot;

                // Set the value of the display input to show the selected time slot
                appointmentTimeDisplay.value = slot;
            });

            // Append the slot element to the container
            timeSlotsContainer.appendChild(slotElement);
        });
    });
</script>





@endsection
