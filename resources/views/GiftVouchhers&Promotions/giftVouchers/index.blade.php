@extends('layouts.main.master')

@section('content')

<main role="main" class="main-content">
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row mb-2">
                <div class="col-md-6">
                    <h2>Gift Vouchers</h2>
                </div>
                <div class="col-md-6">
                    @if ($message = Session::get('success'))
                    <div class='alert alert-success'>
                        <p>{{ $message }}</p>
                    </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <a href="{{ route('createGiftVoucher') }}" class="btn btn-primary mb-3">Add Gift Voucher</a>
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
                                        <th style="color: black;">Git Voucher Code</th>
                                        <th style="color: black;">Name</th>
                                        <th style="color: black;">Description</th>
                                        <th style="color: black;">Price</th>
                                        <th style="color: black;">Start Date</th>
                                        <th style="color: black;">End Date</th>
                                        <th style="color: black;"  width="200px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($GiftVouchers as $giftVoucher)
                                <tr>
                                    <td>{{ $giftVoucher->gift_voucher_Id }}</td>
                                    <td>{{ $giftVoucher->gift_voucher_name }}</td>
                                    <td>{!! $giftVoucher->description!!}</td>
                                    <td>{{ $giftVoucher->price }}</td>
                                    <td>{{ $giftVoucher->start_date }}</td>
                                    <td>{{ $giftVoucher->end_date }}</td>
                                    <td>
                                        <!-- Show Button -->
                                        <a href="{{ route('editGiftVoucher', $giftVoucher->id) }}" class="btn btn-secondary"><i class="fe fe-edit fe-16"></i></a>

                                        <!-- Delete Button -->
                                        <button class="btn btn-danger" onclick="confirmDelete({{ $giftVoucher->id }})"><i class="fe fe-trash fe-16"></i></button>
                                        <form id="delete-form-{{ $giftVoucher->id }}" action="{{ route('deleteGiftVoucher', $giftVoucher->id) }}" method="POST" style="display:none;">
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
