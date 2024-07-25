@extends('layouts.main.master')

@section('content')
<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<main role="main" class="main-content">
  <div class="container-fluid">
    <div class="row justify-content-center p-2">
      <div class="col-12">
        <div class="card shadow mb-4 p-2 pl-3">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h3><strong class="card-title">Holiday</strong></h3>
            <div>
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addMoreHoliday">
                <i class="fe fe-plus"></i>Add More Holiday
              </button>
              <a href="{{ route('manage_holiday') }}">
                <button type="button" class="btn btn-primary">
                  Manage Holiday
                </button>
              </a>
            </div>
          </div>
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th style="width:10%; color:black;">SL</th>
                  <th style="width:40%; color:black;">Holiday Name</th>
                  <th style="width:15%; color:black;">From</th>
                  <th style="width:15%; color:black;">To</th>
                  <th style="color:black;">Number of days</th>
                </tr>
              </thead>
              <tbody>
              @foreach($holiday_list as $index=> $Holiday)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $Holiday->holiday_name }}</td>
                  <td>{{ $Holiday->start_date }}</td>
                  <td>{{ $Holiday->end_date }}</td>
                  <td>{{ $Holiday->no_of_days }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

 <!-- Add more holiday modal -->
<div class="modal fade" id="addMoreHoliday" tabindex="-1" role="dialog" aria-labelledby="addMoreHolidayModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMoreHolidayModalLabel">Add more holiday</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('holiday.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="holidaynameInput" style="color:black;">Holiday Name<i class="text-danger">*</i></label>
                        <input type="text" class="form-control" id="holidayName" name="holiday_name" placeholder="Enter Holiday Name" required>
                    </div>
                    <div class="form-group">
                        <label for="dateFrom" style="color:black;">From <i class="text-danger">*</i></label>
                        <input type="text" class="form-control" id="dateFrom" name="start_date" placeholder="Select Date" required>
                    </div>
                    <div class="form-group">
                        <label for="dateTo" style="color:black;">To <i class="text-danger">*</i></label>
                        <input type="text" class="form-control" id="dateTo" name="end_date" placeholder="Select Date" required>
                    </div>
                    <div class="form-group">
                        <label for="numberOfDaysInput" style="color:black;">Number of Days<i class="text-danger">*</i></label>
                        <input type="number" class="form-control" id="numberOfDays" name="number_of_days" placeholder="Enter Number of Days" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" style="color:white; background-color:green;" class="btn">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</main>






<!-- Flatpickr JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Initialize flatpickr for date inputs in the modal
    flatpickr("#dateFrom", {
        dateFormat: "Y-m-d"
    });
    flatpickr("#dateTo", {
        dateFormat: "Y-m-d"
    });
});
</script>
@endsection
