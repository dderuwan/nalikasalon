@extends('layouts.main.master')

@section('content')


<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <h2 class="page-title">Leave Application</h2>
                    </div>
                    <div class="col-md-6 text-right">
                    <a href="{{ route('apply_leave') }}">
                            <button type="button" class="btn btn-primary">
                            <i class="fe fe-plus"></i>Add Leave
                            </button>
                        </a>
                        <a href="{{ route('manage_leave_application') }}">
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
                                            <th style="color: black;">Approve Start Date</th>
                                            <th style="color: black;">Approved End Date</th>
                                            <th style="color: black;">Apply Day</th>
                                            <th style="color: black;">Approve Day</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($leave_applications as $index => $leave_app)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $leave_app->employee->firstname }} {{ $leave_app->employee->lastname }}</td>
                                                <td>{{ $leave_app->leaveType->leave_type }}</td>
                                                <td>{{ $leave_app->apply_strt_date }}</td>
                                                <td>{{ $leave_app->apply_end_date }}</td>
                                                <td>{{ $leave_app->leave_aprv_strt_date }}</td>
                                                <td>{{ $leave_app->leave_aprv_end_date }}</td> 
                                                <td>{{ $leave_app->apply_day }}</td> 
                                                <td>{{ $leave_app->num_aprv_day }}</td>                                       
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
</main>




@endsection
