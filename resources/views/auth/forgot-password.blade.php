<style>
    /* General styling for the Forgot Password form */

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

h2 {
    font-size: 24px;
    margin-bottom: 20px;
    color: #333;
    text-align: center;
}

.text-gray-600 {
    color: #6B7280; /* Tailwind's default gray-600 */
    margin-bottom: 20px;
    text-align: center;
}

.form-container {
    max-width: 500px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #f9f9f9;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* Input styles */
input[type="email"] {
    width: 100%;
    padding: 10px;
    margin-top: 10px;
    margin-bottom: 20px;
    border-radius: 4px;
    border: 1px solid #ccc;
    font-size: 16px;
}

/* Button styling */
button {
    background-color: #007BFF; /* Primary button color */
    color: white;
    padding: 10px 20px;
    font-size: 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #0056b3;
}

/* Centering elements */
.flex {
    display: flex;
    justify-content: flex-end;
}

.items-center {
    align-items: center;
}

.justify-end {
    justify-content: flex-end;
}

.mt-4 {
    margin-top: 1rem; /* Adjust this value to add more space */
}

.mb-4 {
    margin-bottom: 1rem; /* Adjust this value to add more space */
}

.mt-1 {
    margin-top: 0.25rem;
}

.block {
    display: block;
}

.w-full {
    width: 100%;
}

</style>


<div class="container">

    <div class="image-container text-center">
        <img src="{{ asset('images/logo.png') }}" alt="Login Image" class="login-image">
    </div>

    <h2>Fogot Password</h2>

    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</div>

