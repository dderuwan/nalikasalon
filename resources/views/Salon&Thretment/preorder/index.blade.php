@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row mb-2">
                <div class="col-md-6">
                    <h2>Salon & Thretments List</h2>
                </div>
                <div class="col-md-6">
                    @if ($message = Session::get('success'))
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
                                        <th style="color: black;">Id</th>
                                        <th style="color: black;">Booking Code</th>
                                        <th style="color: black;">Booking Date</th>
                                        <th style="color: black;">Seervice Type</th>
                                        <th style="color: black;">Package Name</th>
                                        <th style="color: black;">Customer Name</th>
                                        <th style="color: black;">Customer Contact</th>
                                        <th style="color: black;">Price</th>
                                        <th style="color: black;" width="200px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bookings as $service)
                                    <tr>
                                        <td>{{ $service->id }}</td>
                                        <td>{{ $service->Booking_number }}</td>
                                        <td>{{ $service->Appoinment_date }}</td>
                                        <td>{{ $service->service_id }}</td>
                                        <td>{{ $service->package_id }}</td>
                                        <td>{{ $service->customer_name }}</td>
                                        <td>{{ $service->contact_number_1 }}</td>
                                        <td>{{ $service->total_price }}</td>
                                        
                                        <td>

                                            <!-- Delete Button -->
                                            <button class="btn btn-danger" onclick="confirmDelete({{ $service->id }})"><i class="fe fe-trash fe-16"></i></button>
                                            <form id="delete-form-{{ $service->id }}" action="{{ route('deleteSalonThretment', $service->id) }}" method="POST" style="display:none;">
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
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    var editor = document.getElementById('editor');
    if (editor)
    {
        var toolbarOptions = [
            [{ 'font': [] }],
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            ['blockquote', 'code-block'],
            [{ 'header': 1 }, { 'header': 2 }],
            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
            [{ 'script': 'sub' }, { 'script': 'super' }],
            [{ 'indent': '-1' }, { 'indent': '+1' }],
            [{ 'direction': 'rtl' }],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'align': [] }],
            ['clean']
        ];
        var quill = new Quill(editor, {
            modules: {
                toolbar: toolbarOptions
            },
            theme: 'snow'
        });
    }
</script>
@endsection
