<style>
    /* Container */
    .container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        margin-top: 10%;
        background-color: #bde0fe;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .image-container {
    margin-top:20px;
    margin-bottom: 20px;
}

.login-image {
    width: 200px; /* Adjust the width as needed */
    height: auto;
    display: block;
    margin-left: auto;
    margin-right: auto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Adds a subtle shadow */
}

    /* Card Body */
    .card-body {
        padding: 20px;
    }

    /* Headings */
    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    /* Form Group */
    .form-group {
        margin-bottom: 15px;
    }

    /* Labels */
    .form-group label {
        font-weight: 600;
        color: #555;
    }

    /* Inputs */
    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
    }

    /* Error Messages */
    .text-danger {
        font-size: 12px;
        color: #e74c3c;
    }

    /* Submit Button */
    .btn-primary {
        background-color: #007bff;
        color: #fff;
        padding: 10px 20px;
        border: none;
        font-size: 18px;
        font-weight: Bold;
        border-radius: 4px;
        cursor: pointer;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    .btn-primary:hover {
        background-color: #2980b9;
    }
</style>

<div class="container">

    <div class="image-container text-center">
        <img src="{{ asset('images/logo.png') }}" alt="Login Image" class="login-image">
    </div>

    <h2>Reset Password</h2>
    <div class="card-body">

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div class="form-group">
                <label for="email">{{ __('Email') }}</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
                @if ($errors->has('email'))
                    <span class="text-danger mt-2">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <!-- Password -->
            <div class="form-group mt-4">
                <label for="password">{{ __('Password') }}</label>
                <input type="password" class="form-control" id="password" name="password" required autocomplete="new-password">
                @if ($errors->has('password'))
                    <span class="text-danger mt-2">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <!-- Confirm Password -->
            <div class="form-group mt-4">
                <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
                @if ($errors->has('password_confirmation'))
                    <span class="text-danger mt-2">{{ $errors->first('password_confirmation') }}</span>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Reset Password') }}
                </button>
            </div>
        </form>
    </div>
</div>
