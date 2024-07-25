@extends('layouts.main.master')

@section('content')
<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <h2 class="page-title">Attendance Reports</h2>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="button" class="btn btn-primary float-end" data-toggle="modal" data-target="#dateWiseReportModal">
                            Date wise Report
                        </button>
                        <button type="button" class="btn btn-primary float-end" data-toggle="modal" data-target="#employeeWiseReportModal">
                            Employee Wise Report
                        </button>
                        <button type="button" class="btn btn-primary float-end" data-toggle="modal" data-target="#dateintimeReportModal">
                            Date and Intime Report
                        </button>
                    </div>
                </div>
                <p class="card-text"></p>
                <div class="row my-4">
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <!-- table -->
                                <table class="table datatables table-bordered" id="dataTable-1">
                                    <thead>
                                        <tr>
                                            <th style="color: black;">SL</th>
                                            <th style="color: black; width:30%">Name</th>
                                            <th style="color: black; width:10%">ID</th>
                                            <th style="color: black; width:15%">Date</th>
                                            <th style="color: black; width:15%">Check In</th>
                                            <th style="color: black; width:15%">Check Out</th>
                                            <th style="color: black; width:15%">Stayed Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($attendance_list as $index => $attendance)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $attendance->employee->firstname }} {{ $attendance->employee->lastname }}</td>
                                            <td>{{ $attendance->employee->id }}</td>
                                            <td>{{ $attendance->date }}</td>
                                            <td>{{ $attendance->sign_in }}</td>
                                            <td>{{ $attendance->sign_out }}</td>
                                            <td>{{ $attendance->stayed_time }}</td>                                     
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Date wise modal -->
    <div class="modal fade" id="dateWiseReportModal" tabindex="-1" role="dialog" aria-labelledby="dateWiseReportModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dateWiseReportModalLabel">Date wise Report</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="dateFrom" style="color:black;">From <i class="text-danger">*</i></label>
                            <input type="text" class="form-control" id="dateFrom" placeholder="Select Date">
                        </div>
                        <div class="form-group">
                            <label for="dateTo" style="color:black;">To <i class="text-danger">*</i></label>
                            <input type="text" class="form-control" id="dateTo" placeholder="Select Date">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" style="color:white; background-color:green;" class="btn">Request</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Employee wise modal -->
    <div class="modal fade" id="employeeWiseReportModal" tabindex="-1" role="dialog" aria-labelledby="employeeWiseReportModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="employeeWiseReportModalLabel">Employee wise Report</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="employeeSelect" style="color:black;">Employee Name<i class="text-danger">*</i></label>
                            <select class="form-control" id="employeeSelect">
                                <option value="" disabled selected>Select Employee</option>
                                <option value="1">Employee 1</option>
                                <option value="2">Employee 2</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="dateFrom" style="color:black;">From <i class="text-danger">*</i></label>
                            <input type="text" class="form-control" id="dateFrom" placeholder="Select Date">
                        </div>
                        <div class="form-group">
                            <label for="dateTo" style="color:black;">To <i class="text-danger">*</i></label>
                            <input type="text" class="form-control" id="dateTo" placeholder="Select Date">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" style="color:white; background-color:green;" class="btn">Request</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Date and Intime wise modal -->
    <div class="modal fade" id="dateintimeReportModal" tabindex="-1" role="dialog" aria-labelledby="dateintimeReportModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dateintimeReportModalLabel">Date and Intime Report</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="dateFrom" style="color:black;">Date <i class="text-danger">*</i></label>
                            <input type="text" class="form-control" id="dateFrom" placeholder="Select Date">
                        </div>
                        <div class="form-group">
                            <label for="inputcheckin" style="color:black;">Start Time <i class="text-danger">*</i></label>            
                            <input type="text" class="form-control" id="inputcheckin" name="checkin">
                        </div>
                        <div class="form-group">
                            <label for="inputcheckout"  style="color:black;">End Time <i class="text-danger">*</i></label>              
                            <input type="text" class="form-control" id="inputcheckout" name="checkout">
                         </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" style="color:white; background-color:green;" class="btn">Request</button>
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

    // Initialize flatpickr for check-in and check-out
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
});
</script>



@endsection
