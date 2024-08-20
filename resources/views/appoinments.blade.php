@extends('layouts.app')

<style>
    .card {
        height: 100%;
        width: 300px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
    }

    .card-body {
        padding: 10px;
    }

    .card2-img {
        max-height: 200px;
        overflow: hidden;
    }

    .product-image {
        width: 300px;
        height: 200px;
        object-fit: cover;
    }

    .logoContent {
        color: black;
        margin-top: 30px;
    }

    .hero1 {
        background-size: cover;
        background-position: center;
        height: 200px;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hero-container {
        text-align: center;
    }

    .hero-container h2 {
        color: white;
        font-size: 36px;
        font-weight: bold;
    }

    .center-icon {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .progress-bar-containers {
        display: flex;
        justify-content: center;
        margin-top: 80px;
        padding: 0 50px;
    }

    .progress-bars {
        display: flex;
        width: 100%;
        max-width: 900px;
        justify-content: space-between;
        align-items: center;
        position: relative;
    }

    .step {
        position: relative;
        z-index: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100px;
        height: 40px;
        background-color: #ddd;
        border-radius: 50%;
        color: #666;
        font-weight: bold;
        font-size: 18px;
        line-height: 40px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .step.active {
        background-color: #007bff;
        color: white;
    }

    .step:hover {
        background-color: #0056b3;
        color: white;
    }

    .progress-line {
        position: absolute;
        top: 50%;
        left: 0;
        width: 100%;
        height: 4px;
        background-color: #ddd;
        z-index: 0;
        transform: translateY(-50%);
    }

    .step.active + .progress-line {
        background-color: #007bff;
    }

    .progress-bar .label {
        margin-top: 8px;
        font-size: 14px;
        text-align: center;
    }

    .step:last-child .progress-line {
        display: none;
    }

    .section {
        display: none;
    }

    .section.active {
        display: block;
    }

    .dtd{
        margin-top:100px;
        width:50%;
        margin-left:20%;
    }

    .nlable{
        font-size: 12px;
    }

    #service option{
        width:150px;
    }

    .form-container12 {
        width: 90%;
        max-width: 700px; /* Adjust as needed */
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f9f9f9;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
        margin-top:5%;
        margin-left:27%;
    }

    .form-group12 {
        display: flex;
        align-items: center;
        width: 100%;
        gap: 10px;
    }

    .form-group12 label {
        flex: 0 0 10%;
        margin-left:10%;
        margin-bottom: 0;
    }

    .form-group12 .form-control12 {
        flex: 1;
        max-width: 400px;
        height:30px;
    }

    #timeSlots {
        padding: 20px;
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

  .form-container13 {
        width: 90%;
        max-width: 700px; /* Adjust as needed */
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f9f9f9;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-top:5%;
        margin-left:27%;
        padding-left:02%
    }

    .form-container13 h3{
        text-align: center;
    }
    
</style>

@section('content')
<div class="container-fluid p-0">
    <div class="row justify-content-center m-0">
        <div class="col-12 p-0">
            <div class="hero1" style="background-image: url('{{ asset('images/homeimg.jpg') }}');">
                <div class="hero-container">
                    <h2 id="content-title">APPOINTMENT SECTION</h2>
                </div>
            </div>
        </div>

        <form action="{{ route('storeAppointments') }}" method="POST" id="appointmentForm">
        @csrf
        <div class="col-md-12">
            <!-- Progress Bar -->
            <div class="progress-bar-containers mb-4">
                <div class="progress-bars">
                    <div class="step active" id="step1">
                        <div>1</div>
                        <div class="nlable">Service,Package</div>
                    </div>
                    <div class="progress-line"></div>
                    <div class="step" id="step2">
                        <div>2</div>
                        <div class="nlable">Date & Time</div>
                    </div>
                    <div class="progress-line"></div>
                    <div class="step" id="step3">
                        <div>3</div>
                        <div class="nlable">Customer Details</div>
                    </div>
                    <div class="progress-line"></div>
                    <div class="step" id="step4">
                        <div>4</div>
                        <div class="nlable">Payments</div>
                    </div>
                </div>
            </div>

           <!-- Section 1: Service and Package Select -->
           
           <div id="section1" class="section active">
                <div class="form-container12">
                    <h3>Select Service and Package</h3>
                    <div class="form-group12">
                        <label for="service">Service:</label>
                        <select id="service" name="service" class="form-control12">
                            <option value="">Select Service</option>
                            @foreach($services as $service)
                                <option value="{{ $service->service_code }}" data-name="{{ $service->service_name }}">
                                    {{ $service->service_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group12">
                        <label for="package">Package:</label>
                        <select id="package" name="package" class="form-control12">
                            <option value="">Select Package</option>
                            <!-- Packages will be populated based on selected service -->
                        </select>
                    </div>
                    <button class="btn btn-primary" onclick="nextSection(2)">Next</button>
                </div>
            </div>



            <!-- Section 2: Date and Time Slot -->
            <div id="section2" class="section">
                <div class="form-container13">
                    <h3>Select Date and Time Slot</h3>
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
                        <div class="col-md-10">
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

                    
                    <div>
                        <button class="btn btn-secondary" onclick="previousSection(1)">Back</button>
                        <button class="btn btn-primary" onclick="nextSection(3)">Next</button>
                    </div>

                </div>
            </div>














            <!-- Section 3: Customer Details -->
            <div id="section3" class="section">
                <div class="form-container13">
                    <h3>Enter Customer Details</h3>
                    <!-- Customer details form -->
                    <div class="mb-3">
                        <label for="name">Name : *</label>
                        <input type="text" class="form-control" id="name" name="name"  required>
                    </div>

                    <div class="mb-3">
                        <label for="contact_number_1">Contact Number 1 : *</label>
                        <input type="text" class="form-control" id="contact_number_1" name="contact_number_1"  required>
                    </div>

                    <div class="mb-3">
                        <label for="contact_number_2">Contact Number 2 : </label>
                        <input type="text" class="form-control" id="contact_number_2" name="contact_number_2" >
                    </div>
                                                
                    <div class="mb-3">
                        <label for="address">Address : *</label>
                        <input type="text" class="form-control" id="address" name="address"  required>
                    </div>

                    <div class="mb-3">
                        <label for="date_of_birth">Date of Birth : *</label>
                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"  required>
                    </div>

                    <div>
                        <button class="btn btn-secondary" onclick="previousSection(2)">Back</button>
                        <button class="btn btn-primary" onclick="nextSection(4)">Next</button>
                    </div>
                    
                </div>
            </div>















            <!-- Section 4: Payment and Order Confirmation -->
            <div id="section4" class="section">
                <div class="form-container13">
                    <h3>Payment and Order Confirmation</h3>
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
                                <input type="number" class="form-control" id="advance_price" name="advance_price" min="0" required>
                            </div>
                    </div>

                    <!-- Total Price -->
                    <div class="form-group row">
                        <label for="totalPrice" class="col-sm-2 col-form-label" style="color:black;">Total Price <i class="text-danger">*</i></label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="total_price" name="total_price" readonly>
                        </div>
                    </div>

                    <div>
                        <button class="btn btn-secondary" onclick="previousSection(3)">Back</button>
                        <button class="btn btn-success">Confirm Appointment</button>
                    </div>
                    
                </div>
            </div>


        </div>
        </form>
    </div>
</div>

<script>
    function nextSection(sectionNumber) {
        document.querySelector('.section.active').classList.remove('active');
        document.querySelector(`#section${sectionNumber}`).classList.add('active');
        document.querySelector('.step.active').classList.remove('active');
        document.querySelector(`#step${sectionNumber}`).classList.add('active');
    }

    function previousSection(sectionNumber) {
        nextSection(sectionNumber);
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const serviceSelect = document.getElementById('service');
        const packageSelect = document.getElementById('package');

        serviceSelect.addEventListener('change', function () {
            const serviceCode = this.value;
            
            if (serviceCode) {
                fetchPackages(serviceCode);
            } else {
                // Clear the package dropdown if no service is selected
                packageSelect.innerHTML = '<option value="">Select Package</option>';
            }
        });

        function fetchPackages(serviceCode) {
            fetch(`/get-packages?service_code=${serviceCode}`)
                .then(response => response.json())
                .then(data => {
                    packageSelect.innerHTML = '<option value="">Select Package</option>';
                    data.packages.forEach(package => {
                        packageSelect.innerHTML += `<option value="${package.services_id}">${package.package_name}</option>`;
                    });
                })
                .catch(error => console.error('Error fetching packages:', error));
        }
    });
</script>

<script>    
document.getElementById('start_date').addEventListener('change', function() {
    var date = this.value;
    if (date) {
        console.log('Fetching available time slots for date:', date);
        fetchAvailableTimeSlots(date);
    }
});

document.getElementById('start_date').addEventListener('change', function() {
    var date = this.value;
    var serviceSelect = document.getElementById('service-select');
    var serviceId = serviceSelect.value;
    if (date && serviceId) {
        console.log('Fetching available time slots for date:', date, 'and service:', serviceId);
        fetchAvailableTimeSlots(date, serviceId);
    }
});

function fetchAvailableTimeSlots(date, serviceId) {
    console.log(`Fetching available time slots for date: ${date} and service: ${serviceId}`);
    fetch(`/get-available-time-slots?date=${date}&service_id=${serviceId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            console.log('Available time slots data:', data);
            var timeSlotsContainer = document.getElementById('timeSlots');
            timeSlotsContainer.innerHTML = '';

            data.available_time_slots.forEach(function(timeSlot) {
                var timeSlotDiv = document.createElement('div');
                timeSlotDiv.className = 'time-slot';
                timeSlotDiv.textContent = timeSlot;
                timeSlotDiv.addEventListener('click', function() {
                    selectTimeSlot(timeSlot, date);
                });
                timeSlotsContainer.appendChild(timeSlotDiv);
            });

            if (data.available_time_slots.length === 0) {
                console.log('No available time slots found.');
            }
        })
        .catch(error => console.error('Error fetching time slots:', error));
}

document.getElementById('service-select').addEventListener('change', function() {
    var serviceId = this.value;
    var date = document.getElementById('start_date').value;
    if (date && serviceId) {
        console.log('Fetching available time slots for date:', date, 'and service:', serviceId);
        fetchAvailableTimeSlots(date, serviceId);
    }
});


function selectTimeSlot(timeSlot, date) {
    console.log(`Selected time slot: ${timeSlot} on date: ${date}`);
    document.getElementById('appointment_time').value = timeSlot;
    document.getElementById('appointmentTime').value = timeSlot;
    var timeSlots = document.querySelectorAll('.time-slot');
    timeSlots.forEach(slot => {
        slot.style.backgroundColor = '#fff';
        slot.style.borderColor = '#ccc';
    });
    var selectedSlot = [...timeSlots].find(slot => slot.textContent === timeSlot);
    if (selectedSlot) {
        selectedSlot.style.backgroundColor = '#d0e9ff';
        selectedSlot.style.borderColor = '#4a90e2';
    }
}

$(document).ready(function() {
    let totalPrice = 0;

    function updateTotalPrice() {
        var total = 0;
        $('#package').each(function() {
            var packagePrice = $(this).find('option:selected').data('price');
            if (packagePrice) {
                total += parseFloat(packagePrice);
            }
        });
        $('#totalPrice').val(total.toFixed(2));
    }

    // When advance price is entered, decrease the total price
    $('#advance-price').on('input', function() {
        updateTotalPrice();
    });

    function updateTotalPrice() {
        let advancePrice = parseFloat($('#advance-price').val()) || 0;
        let finalPrice = totalPrice - advancePrice;
        $('#total-price').val(finalPrice.toFixed(2)); // Display final price
    }
});

</script>

<script>
    $(document).ready(function() {
        // On package selection, update the total price
        $('#package_id').change(function() {
            var packageId = $(this).val();
            if (packageId) {
                $.ajax({
                    url: '/get-package-price',  // Ensure this route is defined to fetch package price
                    type: 'GET',
                    data: { package_id: packageId },
                    success: function(data) {
                        $('#total_price').val(data.price); // Set total price to the package price
                    }
                });
            } else {
                $('#total_price').val(''); // Clear total price if no package is selected
            }
        });

        // On entering advance price, update the total price
        $('#advance_price').on('input', function() {
            var totalPrice = parseFloat($('#total_price').val());
            var advancePrice = parseFloat($(this).val());

            if (!isNaN(totalPrice) && !isNaN(advancePrice)) {
                var remainingAmount = totalPrice - advancePrice;
                $('#total_price').val(remainingAmount.toFixed(2)); // Update total price after advance payment
            }
        });
    });

</script>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


@endsection
