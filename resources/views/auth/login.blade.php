<style>

body {
    font-family: 'Roboto', sans-serif; /* Use the Google Font */
}

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

/* Remember Me */
.form-check-input {
    margin-top: 3px;
}

.form-check-label {
    margin-left: 5px;
}

/* Forgot Password Link */
.text-muted {
    font-size: 14px;
    text-decoration: none;
}

.text-muted:hover {
    text-decoration: underline;
}

/* Submit Button */
.btn-primary {
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border: none;
    font-size: 18px;
    font-weight:Bold;
    border-radius: 4px;
    cursor: pointer;
    display: block;
    margin-left: auto;
    margin-right: auto;
}

.btn-primary:hover {
    background-color: #2980b9;
}

/* Alert */
.alert {
    padding: 10px;
    border-radius: 4px;
    font-size: 14px;
}

.alert-success {
    background-color: #2ecc71;
    color: #fff;
}

/* Styles for the login page logo */
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


</style>

    <div class="container">
        <div class="image-container text-center">
            <img src="{{ asset('images/logo.png') }}" alt="Login Image" class="login-image">
        </div>
        <h2>Login</h2>
        <div class="card-body">
            <!-- Display Session Status -->
            @if (session('status'))
                <div class="alert alert-success mb-4">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group col-md-6">
                    <label for="contactno">{{ __('Contact Number') }}</label>
                    <input type="text" class="form-control" id="contactno" name="contactno" value="{{ old('contactno') }}" required autofocus>
                    @if ($errors->has('contactno'))
                        <span class="text-danger mt-2">{{ $errors->first('contactno') }}</span>
                    @endif
                </div>

                <!-- Password -->
                <div class="form-group col-md-6 mt-4">
                    <label for="password">{{ __('Password') }}</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    @if ($errors->has('password'))
                        <span class="text-danger mt-2">{{ $errors->first('password') }}</span>
                    @endif
                </div>

                <!-- Remember Me -->
                <div class="form-group col-md-6 mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                        <label class="form-check-label" for="remember_me">
                            {{ __('Remember me') }}
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="form-group col-md-6 mt-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Log in') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

