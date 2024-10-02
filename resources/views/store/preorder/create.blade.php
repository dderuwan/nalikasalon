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
                      <form action="{{ route('preorderstore') }}" method="POST" enctype="multipart/form-data">
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
                                    @foreach($packages as $package)
                                        <option value="{{ $package->id }}" data-price="{{ $package->price }}">
                                            {{ $package->package_name }} - LKR.{{ $package->price }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                          <div id="subcategories-container"></div>

                            <!-- Date Selection -->
                            <div class="form-group row">
                                <label for="start_date" class="col-sm-2 col-form-label" style="color:black;">Date <i class="text-danger">*</i></label>
                                <div class="col-md-6">
                                    <input type="date" class="form-control" id="start_date" name="start_date" min="{{ date('Y-m-d') }}" required>
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
                                @foreach($otherpackages as $package)
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

@endsection

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
  // Initialize Select2 for customer and service selection
  $('#customer_code').select2({ placeholder: 'Select or type customer contact number', allowClear: true });
  $('#service-select').select2({ placeholder: 'Select Service', allowClear: true });

  // Show customer details when a customer is selected
  $('#customer_code').on('change', function() {
    var selectedOption = $(this).find('option:selected');
    $('#customerDetails').show();
    $('#customerName').html('<strong>Name:</strong> ' + selectedOption.data('name'));
    $('#customerContact').html('<strong>Contact:</strong> ' + selectedOption.data('contact'));
    $('#customerAddress').html('<strong>Address:</strong> ' + selectedOption.data('address'));
    $('#customerDOB').html('<strong>Date of Birth:</strong> ' + selectedOption.data('dob'));
    
    // Set hidden input values
    $('#hiddenCustomerName').val(selectedOption.data('name'));
    $('#hiddenCustomerContact').val(selectedOption.data('contact'));
    $('#hiddenCustomerAddress').val(selectedOption.data('address'));
    $('#hiddenCustomerDOB').val(selectedOption.data('dob'));
    $('#hiddenCustomerId').val(selectedOption.data('code'));
  });

  // Handle adding a new customer (show modal)
  $('#add-customer-btn').on('click', function() {
    $('#addCustomerModal').modal('show');
  });

  // Time slot selection logic
  const timeSlots = ['Fierst_Slot', 'Second_slot', 'Third_slot']; // Example time slots
  const timeSlotsContainer = $('#timeSlots');
  const appointmentTimeInput = $('#appointment_time');
  const appointmentTimeDisplay = $('#appointmentTime');

  timeSlots.forEach(slot => {
    const slotElement = $('<div class="time-slot"></div>').text(slot);
    timeSlotsContainer.append(slotElement);
    slotElement.on('click', function() {
      $('.time-slot').css('background-color', '#fff'); // Reset background of all slots
      $(this).css('background-color', '#d1e7dd'); // Highlight selected slot
      appointmentTimeInput.val(slot);
      appointmentTimeDisplay.val(slot);
    });
  });
});
</script>


<script>
    $(document).ready(function() {
    // Event handler for package selection
    $('#package-select-1').on('change', function() {
        var selectedPackageId = $(this).val(); // Get the selected package ID

        if (selectedPackageId) {
            // Make AJAX request to fetch subcategories
            $.ajax({
                url: '{{ route("getSubcategoriesByPackage") }}', // The route for fetching subcategories
                method: 'GET',
                data: { package_id: selectedPackageId },
                success: function(response) {
                    var container = $('#subcategories-container');
                    container.empty();  // Clear existing subcategories if any

                    if (response.subcategories.length > 0) {
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
                            fetchItemsBySubcategory(subcategory.id);
                        });
                    } else {
                        container.append('<p>No subcategories available for this package.</p>');
                    }
                },
                error: function(xhr) {
                    console.error('Failed to fetch subcategories:', xhr.responseText);
                }
            });
        } else {
            // Clear subcategories container if no package is selected
            $('#subcategories-container').empty();
        }
    });

    // Function to fetch items by subcategory
    // Function to fetch items by subcategory
    function fetchItemsBySubcategory(subcategoryId) {
        $.ajax({
            url: '{{ route("getItemsBySubcategory") }}',  // The route for fetching items
            method: 'GET',
            data: { subcategory_id: subcategoryId },
            success: function(response) {
                var itemSelect = $(`select[data-subcategory-id="${subcategoryId}"]`);
                itemSelect.empty(); // Clear any previous items

                // Add "Select Item" as the first placeholder option
                itemSelect.append('<option value="">Select Item</option>');

                if (response.items.length > 0) {
                    response.items.forEach(function(item) {
                        var option = `<option value="${item.id}">${item.Item_name}</option>`;
                        itemSelect.append(option);
                    });
                } else {
                    itemSelect.append('<option value="">No items available</option>');
                }
            },
            error: function(xhr) {
                console.error('Failed to fetch items:', xhr.responseText);
            }
        });
    }

});

</script>


<script>

    document.addEventListener('DOMContentLoaded', function() {
    // Get the current date in 'YYYY-MM-DD' format
    var today = new Date().toISOString().split('T')[0];

    // Set the min attribute of the date input to today's date
    document.getElementById("start_date").setAttribute('min', today);
    });

    // Show modal to add customer
    $('#add-customer-btn').on('click', function() {
        new bootstrap.Modal(document.getElementById('addCustomerModal')).show();
    });

</script>



<script>$(document).ready(function() {
    var basePackagePrice = 0; // Initialize the base package price

    // Event listener for main package selection
    $('#package-select-1').on('change', function() {
        basePackagePrice = parseFloat($(this).find('option:selected').data('price')) || 0; // Get the selected package's price

        // Update the total price initially with only the base package price
        updateTotalPrice();
    });

    // Event listener for additional package selection
    $('.additional-package-checkbox').on('change', function() {
        // Update the total price whenever an additional package is selected/deselected
        updateTotalPrice();
    });

    // Event listener for transport cost input
    $('#Transport').on('input', function() {
        updateTotalPrice();
    });

    // Event listener for discount input
    $('#Discount').on('input', function() {
        updateTotalPrice();
    });

    // Event listener for advanced payment input
    $('#advancedPayment').on('input', function() {
        updateTotalPrice();
    });

    // Event listener for promotional code selection
    $('#promotions_Id').on('change', function() {
        let promotionId = $(this).val(); // Get the selected promotional code ID

        if (promotionId) {
            // Perform AJAX request to get the promotional price (percentage)
            $.ajax({
                url: '/get-promotion-price/' + promotionId, // Adjust this URL to your route
                type: 'GET',
                success: function(data) {
                    if (data.success) {
                        // Calculate and display the promotional discount value in the promotional price field
                        var promotionalPercentage = parseFloat(data.price);
                        var discountValue = (basePackagePrice * promotionalPercentage) / 100; // Calculate the discount
                        $('#promotional_price').val(discountValue.toFixed(2)); // Display discount value
                        
                        updateTotalPrice(); // Recalculate the total price after applying the promotional discount
                    } else {
                        alert(data.message);
                        $('#promotional_price').val(''); // Clear the promotional price if not found
                        updateTotalPrice(); // Recalculate total without promotion
                    }
                },
                error: function(err) {
                    console.log('Error fetching promotion details:', err);
                    $('#promotional_price').val(''); // Clear the promotional price on error
                    updateTotalPrice(); // Recalculate total without promotion
                }
            });
        } else {
            // Clear the promotional price field if no promotion is selected
            $('#promotional_price').val('');
            updateTotalPrice(); // Recalculate total without promotion
        }
    });

    // Event listener for gift voucher selection
    $('#gift_voucher_Id').on('change', function() {
        let giftVoucherId = $(this).val(); // Get the selected gift voucher ID

        if (giftVoucherId) {
            // Perform AJAX request to get the gift voucher price
            $.ajax({
                url: '/get-gift-voucher-price/' + giftVoucherId, // Adjust this URL to your route
                type: 'GET',
                success: function(data) {
                    if (data.success) {
                        // Display the gift voucher price
                        $('#gift_voucher_price').val(data.price);
                        updateTotalPrice(); // Recalculate the total price with the gift voucher discount
                    } else {
                        alert(data.message);
                        $('#gift_voucher_price').val(''); // Clear the price if not found
                        updateTotalPrice(); // Recalculate total without voucher
                    }
                },
                error: function(err) {
                    console.log('Error fetching gift voucher details:', err);
                    $('#gift_voucher_price').val(''); // Clear the price on error
                    updateTotalPrice(); // Recalculate total without voucher
                }
            });
        } else {
            // Clear the gift voucher price field if no voucher is selected
            $('#gift_voucher_price').val('');
            updateTotalPrice(); // Recalculate total without voucher
        }
    });

    // Function to update the total price and balance payment
    function updateTotalPrice() {
        var totalPrice = basePackagePrice; // Start with the base price (main package)

        // Add additional package prices
        $('.additional-package-checkbox:checked').each(function() {
            var additionalPackagePrice = parseFloat($(this).data('price'));
            totalPrice += additionalPackagePrice;
        });

        // Add transport cost if entered
        var transportCost = parseFloat($('#Transport').val());
        if (!isNaN(transportCost)) {
            totalPrice += transportCost;
        }

        // Subtract discount if entered
        var discount = parseFloat($('#Discount').val());
        if (!isNaN(discount)) {
            totalPrice -= discount;
        }

        // Subtract promotional discount if entered
        var promotionalPrice = parseFloat($('#promotional_price').val());
        if (!isNaN(promotionalPrice)) {
            totalPrice -= promotionalPrice;
        }

        // Subtract gift voucher discount if entered
        var giftVoucherPrice = parseFloat($('#gift_voucher_price').val());
        if (!isNaN(giftVoucherPrice)) {
            totalPrice -= giftVoucherPrice;
        }

        // Ensure the total price is not negative
        if (totalPrice < 0) {
            totalPrice = 0;
        }

        // Update the total price field
        $('#totalPrice').val(totalPrice.toFixed(2)); // Display total with two decimal places

        // Calculate balance payment by subtracting advanced payment
        var advancedPayment = parseFloat($('#advancedPayment').val());
        if (isNaN(advancedPayment)) {
            advancedPayment = 0;
        }
        var balancePayment = totalPrice - advancedPayment;

        // Ensure balance payment is not negative
        if (balancePayment < 0) {
            balancePayment = 0;
        }

        // Update the balance payment field
        $('#BalancePayment').val(balancePayment.toFixed(2)); // Display balance with two decimal places
    }
});

    

</script>