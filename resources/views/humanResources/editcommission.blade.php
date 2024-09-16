@extends('layouts.main.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Commission</div>

                <div class="card-body">
                    <!-- Check if there are any success messages -->
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <!-- Form to edit commission -->
                    <form action="{{ route('updatecommission', $commission->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Employee ID -->
                        <div class="form-group">
                            <label for="employee_id">Employee</label>
                            <input type="text" name="employee_id" class="form-control" value="{{ $commission->employee_id }}" readonly>
                        </div>

                        <!-- Order ID -->
                        <div class="form-group">
                            <label for="order_id">Order ID</label>
                            <input type="text" name="order_id" class="form-control" value="{{ $commission->order_id }}" readonly>
                        </div>

                        <!-- Date -->
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" name="date" class="form-control" value="{{ $commission->date }}" readonly>
                        </div>

                        <!-- Commission Amount -->
                        <div class="form-group">
                            <label for="commission_amount">Commission Amount</label>
                            <input type="number" name="commission_amount" class="form-control" value="{{ $commission->commission_amount }}">
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Commission</button>
                        </div>
                    </form>

                    <!-- Cancel Button -->
                    <a href="{{ route('commissions-list') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
