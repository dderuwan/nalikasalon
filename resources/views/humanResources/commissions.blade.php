@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row mb-2">
                <div class="col-md-6">
                    <h2>Commissions</h2>
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
                                        <th style="color: black;">Order Id</th>
                                        <th style="color: black;">Employee Id</th>
                                        <th style="color: black;">Appoinment Date</th>
                                        <th style="color: black;">Commission Amount</th>
                                        <th style="color: black;" width="200px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($commission as $service)
                                    <tr>
                                        <td>{{ $service->id }}</td>
                                        <td>{{ $service->order_id }}</td>
                                        <td>{{ $service->employee->full_name ?? 'N/A' }}</td>
                                        <td>{{ $service->date }}</td>
                                        <td>{{ $service->commission_amount }}</td>
                                        <td>

                                            <!-- Edit Button -->
                                            <a href="{{ route('editcommission', $service->id) }}" class="btn btn-primary"><i class="fe fe-edit fe-16"></i></a>

                                            <!-- Delete Button -->
                                            <button class="btn btn-danger" onclick="confirmDelete({{ $service->id }})"><i class="fe fe-trash fe-16"></i></button>
                                            <form id="delete-form-{{ $service->id }}" action="{{ route('destroycommission', $service->id) }}" method="POST" style="display:none;">
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
