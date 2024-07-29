@extends('layouts.main.master')

@section('content')

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <h2 class="page-title">Attendance List</h2>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="button" class="btn btn-primary float-end" data-toggle="modal" data-target="#checkInModal">
                            Single Check In
                        </button>
                        <a href="{{ route('manage_attendance_list') }}"><button type="button" class="btn btn-primary float-end">
                             Manage Attendance
                        </button></a>
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
                                            <th style="color: black; width:25%">Name</th>
                                            <th style="color: black; width:15%">Date</th>
                                            <th style="color: black; width:15%">Check In</th>
                                            <th style="color: black; width:15%">Check Out</th>
                                            <th style="color: black; width:15%">Stayed Time</th>
                                            <th class="text-center" style="color: black; width:12%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($attendance_list as $index => $attendance)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $attendance->employee->firstname }} {{ $attendance->employee->lastname }}</td>
                                            <td>{{ $attendance->date }}</td>
                                            <td>{{ $attendance->sign_in }}</td>
                                            <td>{{ $attendance->sign_out }}</td>
                                            <td>{{ $attendance->stayed_time }}</td>
                                            <td>
                                                <div class="action-icons">
                                                    @if($attendance->sign_out)
                                                        <span>Checked Out</span>
                                                    @else
                                                        <button type="button" style="color:white; background-color:green;" class="btn checkOutButton" 
                                                            data-toggle="modal" data-target="#checkOutModal" 
                                                            data-attendance-id="{{ $attendance->id }}">
                                                            Check Out
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>                                         
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

    <!-- Single Check In Modal -->
    <div class="modal fade" id="checkInModal" tabindex="-1" role="dialog" aria-labelledby="checkInModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="checkInModalLabel">Check In</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="checkInForm" method="POST" action="{{ route('attendance.check-in') }}">
                    @csrf
                    <div class="form-group">
                        <label for="employeeName">Employee Name <i class="text-danger">*</i></label>
                        <select class="form-control" id="emp_id" name="emp_id">
                            <option value="" disabled selected>Select Employee</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->id }}-{{ $employee->firstname }} {{ $employee->lastname }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer mt-5">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Sign In</button>
                    </div>
                </form>
            </div>
           
        </div>
    </div>
</div>



    <!-- Check Out Modal -->
<div class="modal fade" id="checkOutModal" tabindex="-1" role="dialog" aria-labelledby="checkOutModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="checkOutModalLabel">Check Out</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="checkOutForm" method="POST" action="{{ route('attendance.check-out') }}">
                    @csrf
                    <input type="hidden" id="attendanceId" name="attendance_id">
                    <h3 class="text-center"><span id="currentTime"></span></h3>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="confirmCheckOutButton">Confirm</button>
                    </div>
                </form>
            </div>            
        </div>
    </div>
</div>

</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Check in functionality
    $(document).on('click', '#signInButton', function() {
        var employeeId = $('#emp_id').val();
        var currentTime = new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true });

        $.ajax({
            url: '{{ route('attendance.check-in') }}',
            type: 'POST',
            data: {
                emp_id: employeeId,
                sign_in: currentTime,
                _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
            },
            success: function(response) {
                console.log(response.message);
                $('#checkInModal').modal('hide');
            },
            error: function(xhr) {
                console.log(xhr.responseJSON.message);
            }
        });
    });

    // Check Out functionality
    let timeInterval;

    $(document).on('click', '.checkOutButton', function() {
        const attendanceId = $(this).data('attendance-id');
        
        $('#checkOutModal').data('attendance-id', attendanceId).modal('show');

        function updateTime() {
            var currentTime = new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true });
            $('#currentTime').text(currentTime);
        }
        if (timeInterval) {
            clearInterval(timeInterval);
        }
        updateTime();
        timeInterval = setInterval(updateTime, 1000);
    });

    $(document).on('click', '#confirmCheckOutButton', function() {
        const attendanceId = $('#checkOutModal').data('attendance-id');
        const signOutTime = $('#currentTime').text();

        $.ajax({
            url: '{{ route('attendance.check-out') }}',
            type: 'POST',
            data: {
                attendance_id: attendanceId,
                sign_out: signOutTime,
                _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
            },
            success: function(response) {
                console.log(response.message);

                $(`button[data-attendance-id="${attendanceId}"]`).closest('tr').find('td').eq(4).text(signOutTime); 
                $(`button[data-attendance-id="${attendanceId}"]`).closest('tr').find('td').eq(5).text(response.attendance.stayed_time);

                $(`button[data-attendance-id="${attendanceId}"]`).replaceWith('<span>Checked Out</span>');

                $('#checkOutModal').modal('hide');
                if (timeInterval) {
                    clearInterval(timeInterval);
                }
            },
            error: function(xhr) {
                console.log(xhr.responseJSON.message);
            }
        });
    });
});
</script>


@endsection
