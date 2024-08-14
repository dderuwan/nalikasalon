@extends('layouts.main.master')

@section('content')

<style>
    #next{
        margin-left:74%;
    }

    #middlecenter{
        margin-left:35%;
    }
</style>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 mb-5">
                <h2>Real Time Appointments</h2>
            </div>

            <div class="col-12 mb-2" id="middlecenter">
                <h4>New Appoinment</h4>
                <div class="col-auto">
                    <a href="{{ route('realtime2page') }}"><button type="button" class="btn btn-primary ml-5" data-toggle="modal">
                    <span class="fe fe-plus fe-16 mr-3"></span>New Appointment</button></a>
                </div>
            </div>

            <div class="col-12 " id="middlecenter">
                <h4>or</h4>
            </div>

            <div class="col-8 mt-10" >
                <label for="customerSelect" style="color:black;">
                    Customer <i class="text-danger">*</i>
                </label>
                <div class="col-sm-8">
                    <select name="contact_number_1" class="form-control" id="customer_code" required>
                        <option value="">Select Customer</option>
                        @foreach($preorders->unique('customer_contact_1') as $customer)
                            <option value="{{ $customer->customer_contact_1 }}">
                                {{ $customer->customer_contact_1 }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="col-8 mt-3">
                <label for="appointmentSelect" style="color:black;">
                    Appointment Number <i class="text-danger">*</i>
                </label>
                <div class="col-sm-8 d-flex justify-content-center align-items-center">
                    <select name="booking_reference_number" class="form-control" id="appointment_number" required>
                        <option value="">Select Appointment</option>
                        <!-- Appointment numbers will be populated here dynamically -->
                    </select>
                </div>
            </div>

            <div class="col-8 mt-5">
                <label for="selectedAppointment" style="color:black;">
                    Selected Appointment
                </label>
                <div class="col-sm-8">
                    <input type="text" class="form-control text-center" id="selectedAppointment" readonly>
                </div>
            </div>

            <div class="col-8">
                <label for="selectedDate" class="col-sm-4 col-form-label" style="color:black;">
                    Appointment Date
                </label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="selectedDate" readonly>
                </div>
            </div>

            <div class="col-8">
                <label for="selectedTime" class="col-sm-4 col-form-label" style="color:black;">
                    Appointment Time
                </label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="selectedTime" readonly>
                </div>
            </div>

            <div class="col-8 mt-3" id="next">
              <a href="{{ route('realtime2page') }}"><button type="button" class="btn btn-primary" data-toggle="modal">Next</button></a>
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

    $('#customer_code').change(function() {
        var contactNumber = $(this).val();

        if (contactNumber) {
            $.ajax({
                url: '{{ route("getAppointmentsByCustomer") }}', // Update this route
                type: 'GET',
                data: { contact_number_1: contactNumber },
                success: function(data) {
                    $('#appointment_number').empty().append('<option value="">Select Appointment</option>');
                    $.each(data, function(key, value) {
                        $('#appointment_number').append('<option value="'+ value.booking_reference_number +'" data-date="'+ value.appointment_date +'" data-time="'+ value.appointment_time +'">'+ value.booking_reference_number +'</option>');
                    });
                }
            });
        } else {
            $('#appointment_number').empty().append('<option value="">Select Appointment</option>');
        }
    });

    $('#appointment_number').change(function() {
        var appointmentNumber = $(this).val();
        var appointmentDate = $('#appointment_number option:selected').data('date');
        var appointmentTime = $('#appointment_number option:selected').data('time');

        // Format the date to YYYY-MM-DD
        var formattedDate = appointmentDate.split('T')[0];

        $('#selectedAppointment').val(appointmentNumber);
        $('#selectedDate').val(formattedDate);
        $('#selectedTime').val(appointmentTime);
    });
});

</script>


@endsection
