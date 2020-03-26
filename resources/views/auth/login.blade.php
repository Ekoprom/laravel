@extends('layouts.app')

@section('content')
<v-card class="mx-auto" max-width="600">
    <v-card-title>
        <h3>{{ __('auth.login_title') }}</h3>
    </v-card-title>

    <v-card-text>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            @error('email')
                <v-alert type="error">{{ $message }}</v-alert>
            @enderror
            @error('password')
                <v-alert type="error">{{ $message }}</v-alert>
            @enderror

            <v-text-field label="{{ __('auth.email') }}" name="email" value="{{ old('email') }}" required></v-text-field>
            <v-text-field label="{{ __('auth.password') }}" name="password" :type="'password'" required></v-text-field>

            <v-checkbox label="{{ __('auth.remember_me') }}" {{ old('remember') ? 'checked' : '' }}></v-checkbox>

            <div>
                <v-btn type="submit" color="primary">{{ __('auth.login') }}</v-btn>

                @if (Route::has('password.request'))
                    <v-btn text color="primary" href="{{ route('password.request') }}">
                        {{ __('auth.forgot_passoword') }}
                    </v-btn>
                @endif
            </div>
        </form>

    </v-card-text>

    <login></login>

</v-card>

@endsection
