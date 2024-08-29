<style>

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

form {
    max-width: 600px;
    margin: 50px auto;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    color: #333;
}

input[type="text"],
input[type="email"],
input[type="password"],
input[type="date"],
input[type="file"] {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="password"]:focus,
input[type="file"]:focus {
    border-color: #007bff;
    outline: none;
}

.btn {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
}

a {
    text-decoration: none;
    color: #007bff;
}

a:hover {
    color: #0056b3;
}

.x-primary-button {
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.x-primary-button:hover {
    background-color: #0056b3;
}

input[type="file"] {
    padding: 5px;
}

input[type="file"]::file-selector-button {
    background-color: #007bff;
    color: #fff;
    padding: 5px 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}


input[type="file"]::file-selector-button:hover {
    background-color: #0056b3;
}

.mt-1 {
    margin-top: 10px;
}

.w-full {
    width: 100%;
}

.block {
    display: block;
}

.col-md-6 {
    width: 100%;
}

.clearfix::after {
    content: "";
    clear: both;
    display: table;
}

.regbtn{
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}


</style>

    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- First Name -->
        <div class="form-group col-md-6">
            <x-input-label for="firstname" :value="__('First Name *')" />
            <x-text-input id="firstname" class="block mt-1 w-full" type="text" name="firstname" :value="old('firstname')" required autofocus autocomplete="firstname" />
            <x-input-error :messages="$errors->get('firstname')" class="mt-2" />
        </div>

        <!-- MIddle Name -->
        <div class="form-group col-md-6">
            <x-input-label for="middlename" :value="__('Middle Name')" />
            <x-text-input id="middlename" class="block mt-1 w-full" type="text" name="middlename" :value="old('middlename')"  autofocus autocomplete="firstname" />
            <x-input-error :messages="$errors->get('middlename')" class="mt-2" />
        </div>

        <!-- Last Name -->
        <div class="form-group col-md-6">
            <x-input-label for="lastname" :value="__('Last Name *')" />
            <x-text-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" :value="old('lastname')" required autocomplete="lastname" />
            <x-input-error :messages="$errors->get('lastname')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="form-group col-md-6">
            <x-input-label for="email" :value="__('Email *')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- NIC -->
        <div class="form-group col-md-6">
            <x-input-label for="nic" :value="__('NIC *')" />
            <x-text-input id="nic" class="block mt-1 w-full" type="text" name="nic" :value="old('nic')" required autocomplete="nic" />
            <x-input-error :messages="$errors->get('nic')" class="mt-2" />
        </div>

        <!-- Date of Birth -->
        <div class="form-group col-md-6">
            <x-input-label for="dob" :value="__('Date of Birth')" />
            <x-text-input id="dob" class="block mt-1 w-full" type="date" name="dob" :value="old('dob')" required autocomplete="bday" />
            <x-input-error :messages="$errors->get('dob')" class="mt-2" />
        </div>


        <!-- Contact No -->
        <div class="form-group col-md-6">
            <x-input-label for="contactno" :value="__('Contact No *')" />
            <x-text-input id="contactno" class="block mt-1 w-full" type="text" name="contactno" :value="old('contactno')" required autocomplete="contactno" />
            <x-input-error :messages="$errors->get('contactno')" class="mt-2" />
        </div>

        <!-- Address -->
        <div class="form-group col-md-6">
            <x-input-label for="address" :value="__('Address *')" />
            <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required autocomplete="address" />
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <!-- City -->
        <div class="form-group col-md-6">
            <x-input-label for="city" :value="__('City *')" />
            <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')" required autocomplete="city" />
            <x-input-error :messages="$errors->get('city')" class="mt-2" />
        </div>

        <!-- Zip Code -->
        <div class="form-group col-md-6">
            <x-input-label for="zipcode" :value="__('Zip Code')" />
            <x-text-input id="zipcode" class="block mt-1 w-full" type="text" name="zipcode" :value="old('zipcode')"  autocomplete="zipcode" />
            <x-input-error :messages="$errors->get('zipcode')" class="mt-2" />
        </div>


        <!-- Password -->
        <div class="form-group col-md-6">
            <x-input-label for="password" :value="__('Password *')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="form-group col-md-6">
            <x-input-label for="password_confirmation" :value="__('Confirm Password *')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        

        <div class="btn btn-primary">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="regbtn">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</div>
</main>




