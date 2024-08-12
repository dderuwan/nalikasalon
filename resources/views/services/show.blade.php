@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <div class="container">
        
        <br>
        <h2>Packages</h2>

        <p><strong>Service Name:</strong> {{ $service->service_name }}</p>
        <p><strong>Service Description:</strong> {{ $service->description }}</p>

        <br><br>
        <h4>Packages</h4>
        @if($service->packages->count() > 0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Package Name</th>
                        <th>Description</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($service->packages as $package)
                        <tr>
                            <td>{{ $package->package_name }}</td>
                            <td>{!! $package->description !!}</td>
                            <td>{{ $package->price }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No packages found for this service.</p>
        @endif
    </div>
</main>
@endsection
