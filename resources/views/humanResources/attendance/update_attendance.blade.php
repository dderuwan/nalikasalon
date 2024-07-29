@extends('layouts.main.master')

@section('content')
<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<main role="main" class="main-content">
  <div class="container-fluid">
    <div class="row justify-content-center p-2">
      <div class="col-12">
        <div class="card shadow mb-4 p-2 pl-3">
          <div class="card-header">
            <h3><strong class="card-title">Attendance Update</strong></h3>
          </div>
          <div class="card-body">
            <form action="{{ route('attendance.update', $attendance->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="form-group row">
                <label for="inputfirstname" class="col-sm-2 col-form-label" style="color:black;">Employee Name <i class="text-danger">*</i></label>
                <div class="col-sm-8">
                  <select class="form-control" id="inputfirstname" name="emp_id" required>
                    <option value="" disabled>Select Employee</option>
                    @foreach($employees as $employee)
                      <option value="{{ $employee->id }}" {{ $attendance->emp_id == $employee->id ? 'selected' : '' }}>{{ $employee->id }}-{{ $employee->firstname }} {{ $employee->lastname }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="inputdate" class="col-sm-2 col-form-label" style="color:black;">Date <i class="text-danger">*</i></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="inputdate" name="date" value="{{ $attendance->date }}" required>
                </div>
              </div>
              <div class="form-group row">
                <label for="inputcheckin" class="col-sm-2 col-form-label" style="color:black;">Check In</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="inputcheckin" name="checkin" value="{{ $attendance->sign_in }}">
                </div>
              </div>
              <div class="form-group row">
                <label for="inputcheckout" class="col-sm-2 col-form-label" style="color:black;">Check Out</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="inputcheckout" name="checkout" value="{{ $attendance->sign_out }}">
                </div>
              </div>
              <div class="form-group row">
                <label for="inputstaytime" class="col-sm-2 col-form-label" style="color:black;">Stayed Time</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="inputstaytime" name="staytime" value="{{ $attendance->stayed_time }}" readonly>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-10 mt-5">
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<!-- Flatpickr JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Initialize flatpickr for date input
    flatpickr("#inputdate", {
        dateFormat: "Y-m-d"
    });

    flatpickr("#inputcheckin", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "h:i:S K",
        time_24hr: false
    });

    flatpickr("#inputcheckout", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "h:i:S K",
        time_24hr: false
    });

    // Function to calculate stayed time
    function calculateStayedTime() {
        const checkin = document.getElementById('inputcheckin').value;
        const checkout = document.getElementById('inputcheckout').value;

        if (checkin && checkout) {
            const checkinTime = new Date('1970-01-01T' + checkin);
            const checkoutTime = new Date('1970-01-01T' + checkout);

            if (checkoutTime < checkinTime) {
                checkoutTime.setDate(checkoutTime.getDate() + 1);
            }

            const diff = new Date(checkoutTime - checkinTime);
            const hours = String(diff.getUTCHours()).padStart(2, '0');
            const minutes = String(diff.getUTCMinutes()).padStart(2, '0');
            const seconds = String(diff.getUTCSeconds()).padStart(2, '0');

            document.getElementById('inputstaytime').value = `${hours}:${minutes}:${seconds}`;
        }
    }

    document.getElementById('inputcheckin').addEventListener('change', calculateStayedTime);
    document.getElementById('inputcheckout').addEventListener('change', calculateStayedTime);
});
</script>

@endsection
