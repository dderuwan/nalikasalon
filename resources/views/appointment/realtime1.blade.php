@extends('layouts.main.master')

@section('content')

<style>
    #next {
        margin-left: 74%;
    }

    #middlecenter {
        margin-left: 35%;
    }
</style>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 mb-5">
                <h2>Bridal Appointment Closing</h2>
            </div>

            <div class="col-8 mt-10">
                <label for="customerSelect" style="color:black;">Customer <i class="text-danger">*</i></label>
                <div class="col-sm-8">
                    <select name="contact_number_1" class="form-control" id="customer_code" required>
                        <option value="">Select Customer</option>
                        @foreach($preorders->unique('contact_number_1') as $customer)
                            <option value="{{ $customer->contact_number_1 }}">{{ $customer->contact_number_1 }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-8 mt-3">
                <label for="appointmentSelect" style="color:black;">Appointment Number <i class="text-danger">*</i></label>
                <div class="col-sm-8 d-flex justify-content-center align-items-center">
                    <select name="booking_reference_number" class="form-control" id="appointment_number" required>
                        <option value="">Select Appointment</option>
                        <!-- Appointment numbers will be populated here dynamically -->
                    </select>
                </div>
            </div>

            <div class="col-8 mt-5">
                <label for="selectedAppointment" style="color:black;">Selected Appointment</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control text-center" id="selectedAppointment" readonly>
                </div>
            </div>

            <div class="col-8">
                <label for="selectedDate" class="col-sm-4 col-form-label" style="color:black;">Appointment Date</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="selectedDate" readonly>
                </div>
            </div>

            <div class="col-8">
                <label for="selectedTime" class="col-sm-4 col-form-label" style="color:black;">Appointment Time</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="selectedTime" readonly>
                </div>
            </div>

            <div class="col-8 mt-3">
                <!-- Form to submit data -->
                <form id="preorderForm" action="{{ route('realtime3page') }}" method="POST">
                    @csrf
                    <!-- Hidden field for the selected appointment number -->
                    <input type="hidden" name="selected_appointment_number" id="selectedAppointmentNumber">
                    <button type="submit" class="btn btn-primary">Next</button>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('#customer_code').select2({
        placeholder: "Select Customer",
        allowClear: true
    });

    // Handle customer selection and fetch appointments
    $('#customer_code').change(function() {
        var contactNumber = $(this).val();

        console.log("Selected Contact Number: " + contactNumber);

        if (contactNumber) {
            $.ajax({
                url: '{{ route("getAppointmentsByCustomer") }}',
                type: 'GET',
                data: { contact_number_1: contactNumber },
                success: function(data) {
                    $('#appointment_number').empty().append('<option value="">Select Appointment</option>');
                    
                    // Check if any data is returned
                    if (data.length > 0) {
                        $.each(data, function(key, value) {
                            $('#appointment_number').append(
                                '<option value="' + value.Auto_serial_number + '" data-date="' + value.Appoinment_date + '" data-time="' + value.Appointment_time + '">' + value.Auto_serial_number + '</option>'
                            );
                        });
                    } else {
                        alert("No appointments found for this contact number.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching appointments:", error);
                }
            });
        } else {
            $('#appointment_number').empty().append('<option value="">Select Appointment</option>');
        }
    });

    // Handle appointment selection and populate the fields
    $('#appointment_number').change(function() {
        var autoSerialNumber = $(this).val();
        var appointmentDate = $('#appointment_number option:selected').data('date');
        var appointmentTime = $('#appointment_number option:selected').data('time');

        // Format the date to YYYY-MM-DD if needed
        var formattedDate = appointmentDate.split('T')[0];

        $('#selectedAppointment').val(autoSerialNumber);
        $('#selectedDate').val(formattedDate);
        $('#selectedTime').val(appointmentTime);
        $('#selectedAppointmentNumber').val(autoSerialNumber); // Set the selected Auto_serial_number in the hidden field
    });
});
</script>

@endsection
