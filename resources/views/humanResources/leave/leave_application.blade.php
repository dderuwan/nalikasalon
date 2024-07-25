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
                        <h2 class="page-title">Leave Application</h2>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#">
                            <i class="fe fe-plus"></i>Add Leave
                        </button>
                        <a href="">
                            <button type="button" class="btn btn-primary">
                            Manage Application
                            </button>
                        </a>
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
                                            <th style="color: black; width:20%">Name</th>
                                            <th style="color: black;">Leave Type</th>
                                            <th style="color: black;">Application Start Date</th>
                                            <th style="color: black;">Application End Date</th>
                                            <th style="color: black;">Approved Start Date</th>
                                            <th style="color: black;">Approved End Date</th>
                                            <th style="color: black;">Apply Day</th>
                                            <th style="color: black;">Approve Day</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td> 
                                            <td></td> 
                                            <td></td>                                       
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal -->
    <div class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="dateWiseReportModalLabel" aria-hidden="true">
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
