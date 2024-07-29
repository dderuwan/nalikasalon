@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12">
        <h2 class="page-title">Leave Application</h2>
        <p class="text-muted"></p>

        <div class="card-deck">
          <div class="card shadow mb-4">
            <div class="card-header">
              <strong class="card-title">Apply</strong>
            </div>
            <div class="card-body p-4">
              <form method="post" action="{{route('leave.store')}}"  enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="inputEmployee" style="color:black;">Employee Name <i class="text-danger">*</i></label>
                    <select class="form-control" id="inputEmployee" name="employee_id">
                      <option value="">Select Employee</option>
                      @foreach($employees as $employee)
                        <option value="{{ $employee->id }}">
                          {{ $employee->id }}-{{ $employee->firstname }} {{ $employee->lastname }}</option>
                      @endforeach
                    </select>
                    @error('employee_id')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputLeaveType" style="color:black;">Leave Type <i class="text-danger">*</i></label>
                    <select class="form-control" id="inputLeaveType" name="leave_type_id">
                      <option value="">Select Leave Type</option>
                      @foreach($leaveTypes as $leaveType)
                        <option value="{{ $leaveType->id }}">{{ $leaveType->leave_type }}</option>
                      @endforeach
                    </select>
                    @error('leave_type_id')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="apply_strt_date" style="color:black;">Application Start Date<i class="text-danger">*</i></label>
                    <input type="date" class="form-control" id="apply_strt_date" name="apply_strt_date" placeholder="Application start date">
                    @error('apply_strt_date')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label for="apply_end_date" style="color:black;">Application End Date<i class="text-danger">*</i></label>
                    <input type="date" class="form-control" id="apply_end_date" name="apply_end_date" placeholder="Application end date">
                    @error('apply_end_date')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="apply_day" style="color:black;">Apply Day</label>
                    <input type="text" class="form-control" id="apply_day" name="apply_day" placeholder="Apply day" readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="apply_hard_copy" style="color:black;">Application</label>
                    <input type="file" class="form-control" id="apply_hard_copy" name="apply_hard_copy">
                    @error('apply_hard_copy')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="leave_aprv_strt_date" style="color:black;">Approve Start Date</label>
                    <input type="date" class="form-control" id="leave_aprv_strt_date" name="leave_aprv_strt_date" placeholder="Approve start date">
                    @error('leave_aprv_strt_date')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label for="leave_aprv_end_date" style="color:black;">Approve End Date</label>
                    <input type="date" class="form-control" id="leave_aprv_end_date" name="leave_aprv_end_date" placeholder="Approve end date">
                    @error('leave_aprv_end_date')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="num_aprv_day" style="color:black;">Approved Day</label>
                    <input type="text" class="form-control" id="num_aprv_day" name="num_aprv_day" placeholder="Approved day" readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputapproved_by" style="color:black;">Approved By</label>
                    <select class="form-control" id="inputapproved_by" name="approved_by">
                      <option value="">Select</option>                    
                        <option value=""></option>             
                    </select>
                    @error('approved_by')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputreason" style="color:black;">Reason</label>
                  <input type="text" class="form-control" id="inputreason" name="reason" placeholder="Reason">
                  @error('reason')
                  <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
          </div>
        </div> 
      </div> 
    </div> 
  </div> 
</main> 

@endsection

@section('scripts')
<script>
  //calculating apply day and approve day
  document.addEventListener('DOMContentLoaded', function () {
    function calculateDays(startDate, endDate, resultField) {
      const start = new Date(startDate.value);
      const end = new Date(endDate.value);

      if (start && end) {
        const diffTime = Math.abs(end - start);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
        resultField.value = diffDays;
      } else {
        resultField.value = '';
      }
    }

    const applyStartDate = document.getElementById('apply_strt_date');
    const applyEndDate = document.getElementById('apply_end_date');
    const applyDayField = document.getElementById('apply_day');

    const approveStartDate = document.getElementById('leave_aprv_strt_date');
    const approveEndDate = document.getElementById('leave_aprv_end_date');
    const approveDayField = document.getElementById('num_aprv_day');

    applyStartDate.addEventListener('change', function () {
      calculateDays(applyStartDate, applyEndDate, applyDayField);
    });

    applyEndDate.addEventListener('change', function () {
      calculateDays(applyStartDate, applyEndDate, applyDayField);
    });

    approveStartDate.addEventListener('change', function () {
      calculateDays(approveStartDate, approveEndDate, approveDayField);
    });

    approveEndDate.addEventListener('change', function () {
      calculateDays(approveStartDate, approveEndDate, approveDayField);
    });
  });
</script>
@endsection
