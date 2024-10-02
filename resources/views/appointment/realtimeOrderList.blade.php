@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row mb-2">
                <div class="col-md-6" >
                     <h2>Real Time Order List</h2>
                </div>
                <div class="col-md-6">
                    @if ($message = Session::get('succes'))
                    <div class='alert alert-success'>
                        <p>{{ $message }}</p>
                    </div>
                    @endif
                </div>
                
            </div>
            <p class="card-text"></p>
            <div class="row my-4">
                <!-- Small table -->
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <table class="table datatables" id="dataTable-1">
                                <thead>
                                    <tr>
                                        <th style="color: black;">Booking_reference_number</th>
                                        <th style="color: black;">Customer</th>
                                        <th style="color: black;">Customer Contact Number</th>
                                        <th style="color: black;">Service Type</th>
                                        <th style="color: black;">Package Name</th>
                                        <th style="color: black;">Appoinment Date</th>
                                        <th style="color: black;" width="200px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($realtimeOrders as $appointment)
                                    <tr>
                                        <td>{{ $appointment->Auto_serial_number }}</td>
                                        <td>{{ $appointment->customer_name }}</td>
                                        <td>{{ $appointment->contact_number_1}}</td>
                                        <td>{{ $appointment->service_id }}</td>
                                        <td>{{ $appointment->package_id}}</td>
                                        <td>{{ $appointment->Appoinment_date }}</td>
                                        <td>
                                            
                                            <a href="{{ route('printAndRedirectmain', ['id' => $appointment->id]) }}" class="btn btn-primary" target="_blank">Print</a>
                
                                            <button class="btn btn-secondary" onclick="copyLink('{{ route('printAndRedirectmain', ['id' => $appointment->id]) }}')">Share</button>
                                            <!-- Show Button -->
                                            <a href="{{ route('showRealOrderDetails', $appointment->id) }}" class="btn btn-secondary"><i class="fe fe-eye fe-16"></i></a>

                                            <!-- Edit Button -->
                                            @if ($appointment->Main_Dresser || $appointment->Assistent_Dresser_1 || $appointment->Assistent_Dresser_2 || $appointment->Assistent_Dresser_3)
                                                    <!-- Hide Edit Button if any dresser fields have values -->
                                            @else
                                                    <!-- Edit Button -->
                                                    <a href="{{ route('updateRealOrderDetails', $appointment->id) }}" class="btn btn-primary"><i class="fe fe-edit fe-16"></i></a>
                                            @endif

                                            <!-- Delete Button -->
                                            <button class="btn btn-danger" onclick="confirmDelete({{ $appointment->id }})"><i class="fe fe-trash fe-16"></i></button>
                                            <form id="delete-form-{{ $appointment->id }}" action="{{ route('deleterealorder', $appointment->id) }}" method="POST" style="display:none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
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
</main>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(orderRequestId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + orderRequestId).submit();
            }
        })
    }
</script>
@endsection
