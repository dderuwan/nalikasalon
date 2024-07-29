@extends('layouts.main.master')

@section('content')

<style>
.action-icons {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
}

.action-icon {
    display: inline-block;
    width: 30px; 
    height: 30px; 
    line-height: 30px; 
    text-align: center;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-right: 5px; 
}

.edit-icon {
    background-color: #f0f0f0; 
}


</style>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center p-2">
            <div class="col-12">
                <div class="card shadow mb-4 p-2 pl-3">
                    <div class="card-header">
                        <h3><strong class="card-title">Weekly Leave</strong></h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width:5%; color:black;">SL</th>
                                    <th style="width:30%;color:black;">Weekly Leave Day</th>
                                    <th style="width:10%; color:black;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($weeklyHoliday->isEmpty())
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <div class="action-icons">
                                                <a href="{{ route('weekly_holiday_update', 0) }}" class="action-icon edit-icon" title="Edit">
                                                    <i class="fe fe-edit text-primary"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    @foreach($weeklyHoliday as $index => $holiday)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $holiday->dayname }}</td>
                                        <td>
                                            <div class="action-icons">
                                                <a href="{{ route('weekly_holiday_update', $holiday->id) }}" class="action-icon edit-icon" title="Edit">
                                                    <i class="fe fe-edit text-primary"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this User?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>
</main>






@endsection
