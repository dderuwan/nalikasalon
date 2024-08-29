@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <div class="container">
        <div class="card-body">
            <div class="card-body">
                <div class="col-md-12">
                    <div class="col-md-6">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="col-md-6">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="col-md-6">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>
@endsection
