@extends('layouts.main.master')
@section('title', 'Items')

@section('content')
<main role="main" class="main-content">
<div class="container">
    <h1>Item Page</h1>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <a href="{{ route('createitem') }}" class="btn btn-primary mb-3">Add Item</a>
    <table class="table table-bordered " id="items-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Item Code</th>
                <th>Item Name</th>
                <th>Description</th>
                <th>Item Quentity</th>
                <th>Shots</th>
                <th>Unit Price</th>
                <th>Supplier Code</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td id="items-table-img">
                    @if($item->image)
                        <img src="{{ asset('images/items/' . $item->image) }}" alt="{{ $item->item_name }}" style="width: 50px; height: 50px;">
                    @else
                        No image
                    @endif
                </td>
                <td>{{ $item->item_code }}</td>
                <td>{{ $item->item_name }}</td>
                <td>{{ $item->item_description }}</td>
                <td>{{ $item->item_quentity }}</td>
                <td>{{ $item->shots }}</td>
                <td>{{ $item->unit_price }}</td>
                <td>{{ $item->supplier_code }}</td>
                <td>
                    <a href="{{ route('showitem', $item->id) }}" class="btn btn-info"><i class="fe fe-eye fe-16"></i></a>
                    <a href="{{ route('edititem', $item->id) }}" class="btn btn-warning"><i class="fe fe-edit fe-16"></i></a>
                    <button class="btn btn-danger" onclick="confirmDelete({{ $item->id }})"><i class="fe fe-trash fe-16"></i></button>
                    <form id="delete-form-{{ $item->id }}" action="{{ route('deleteitem', $item->id) }}" method="POST" style="display:none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</main>
@endsection


<style>
    
    #items-table th{
        color:#001a4e;
    }

    
</style> 

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(itemId) {
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
                document.getElementById('delete-form-' + itemId).submit();
            }
        })
    }
</script>
<script>
        document.addEventListener('DOMContentLoaded', function () {
            @if (session('success'))
                showToast('success', '{{ session('success') }}');
            @endif

            @if (session('error'))
                showToast('error', '{{ session('error') }}');
            @endif

            @if (session('warning'))
                showToast('warning', '{{ session('warning') }}');
            @endif

            @if (session('info'))
                showToast('info', '{{ session('info') }}');
            @endif

            @if (session('question'))
                showToast('question', '{{ session('question') }}');
            @endif
        });
    </script>
@endsection
