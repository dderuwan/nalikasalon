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
}

.time-slot {
    padding: 10px;
    margin: 5px;
    width: 100px; 
    text-align: center;
    border: 1px solid #ccc; 
    border-radius: 4px; 
    background-color: #fff; 
    cursor: pointer; 
    transition: background-color 0.3s, border-color 0.3s;
}

.time-slot:hover {
    background-color: #f0f0f0; 
    border-color: #999; 
}
</style>

<main role="main" class="main-content">
  <div class="container-fluid">
    <div class="row justify-content-center pl-5 pr-5">
      <div class="col-12">
        <div class="row mb-2">
          <div class="col-md-6">
            <h2 class="page-title">New Appointment</h2>
          </div>
        </div>
        <div class="card shadow mb-4 p-2 pl-3">
          <div class="card-body">
            <form action="{{ route('appointment.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="form-group row">
                <label for="customerSelect" class="col-sm-2 col-form-label" style="color:black;">Customer <i class="text-danger">*</i></label>
                <div class="col-sm-8">
                  <select class="form-control" id="customerSelect" name="customer_id" required>
                    <option value="">Select Customer</option>
                    @foreach($customers as $customer)
                      <option value="{{ $customer->customer_code }}">{{ $customer->customer_code }} - {{ $customer->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <!-- Customer details display section -->
              <hr>
              <div id="customerDetails" class="col-sm-8 mt-4 mb-4">
                <div class="customer-info">
                    <strong>Name:</strong> <span id="customerName"></span>
                </div>
                <div class="customer-info">
                    <strong>Contact:</strong> <span id="customerContact"></span>
                </div>
                <div class="customer-info">
                    <strong>Address:</strong> <span id="customerAddress"></span>
                </div>
                <div class="customer-info">
                    <strong>Date of Birth:</strong> <span id="customerDOB"></span>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="start_date" style="color:black;">Date <i class="text-danger">*</i></label>
                  <input type="date" class="form-control" id="start_date" name="start_date" required>
                </div>
              </div>

              <!-- Time Slots -->
              <div id="timeSlots" class="mt-3">
                <label style="color:black;">Available Time Slots</label>
                <div class="d-flex flex-wrap">
                  <div class="time-slot">08:00-08:30 AM</div>
                  <div class="time-slot">08:30-09:00 AM</div>
                  <div class="time-slot">09:00-09:30 AM</div>
                  <div class="time-slot">09:30-10:00 AM</div>
                  <div class="time-slot">10:00-10:30 AM</div>
                  <div class="time-slot">10:30-11:00 AM</div>
                  <div class="time-slot">11:00-11:30 AM</div>
                  <div class="time-slot">11:30-12:00 PM</div>
                  <div class="time-slot">01:00-01:30 PM</div>
                  <div class="time-slot">01:30-02:00 PM</div>
                </div>
              </div>

              <div class="form-row mt-3">
                <div class="form-group col-md-6">
                  <label for="appointmentTime" class="col-form-label" style="color:black;">Appointment Time <i class="text-danger">*</i></label>
                  <input type="text" class="form-control" id="appointmentTime" name="appointment_time">
                </div>
                <div class="form-group col-md-6 mt-1">
                  <label for="eventType" style="color:black;">Event Type</label>
                  <select class="form-control" id="eventType" name="event_type">
                    <option value="">Select Event</option>
                    <option value="meeting">Meeting</option>
                    <option value="consultation">Consultation</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label for="eventNote" class="col-form-label" style="color:black;">Note</label>
                <textarea class="form-control" id="eventNote" name="note" placeholder="Add some note for your event"></textarea>
              </div>

              <div class="form-group row">
                <div class="col-sm-10 mt-5">
                  <button type="submit" class="btn btn-primary">Save Appointment</button>
                </div>
              </div>
            </form>
          </div>
        </div>

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
      </div>
    </div>
  </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var customerSelect = document.getElementById('customerSelect');
    var customerName = document.getElementById('customerName');
    var customerContact = document.getElementById('customerContact');
    var customerAddress = document.getElementById('customerAddress');
    var customerDOB = document.getElementById('customerDOB');

    customerSelect.addEventListener('change', function() {
        var customer_code = this.value;

        if (customer_code) {
            fetch(`/Appointments/New-appointment/customers/${customer_code}`)
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        customerName.textContent = data.name || '';
                        customerContact.textContent = data.contact_number_1 && data.contact_number_2
                            ? `${data.contact_number_1} / ${data.contact_number_2}`
                            : data.contact_number_1 || data.contact_number_2 || '';
                        customerAddress.textContent = data.address || '';
                        customerDOB.textContent = data.date_of_birth || '';
                    }
                })
                .catch(error => console.error('Error fetching customer details:', error));
        } else {
            // Clear fields if no customer is selected
            customerName.textContent = '';
            customerContact.textContent = '';
            customerAddress.textContent = '';
            customerDOB.textContent = '';
        }
    });

    //display timeslot in the appointment time
    var timeSlots = document.querySelectorAll('.time-slot');
    var appointmentTimeInput = document.getElementById('appointmentTime');

    timeSlots.forEach(function(timeSlot) {
        timeSlot.addEventListener('click', function() {
            appointmentTimeInput.value = timeSlot.textContent.trim();
        });
    });
});
</script>
@endsection
