@extends('layouts.app')

@section('title', __('Edit user'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit user') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('users.update', $user) }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                           class="form-control @error('name') is-invalid @enderror" name="name"
                                           value="{{$user->name}}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="phone"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Phone number') }}</label>

                                <div class="col-md-6">
                                    <input id="phone" type="text"
                                           class="form-control @error('phone') is-invalid @enderror" name="phone"
                                           maxlength="10" minlength="10" value="{{ $user->phone }}" required
                                           autocomplete="phone">

                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ $user->email !== null? $user->email : '' }}" autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            @if(Auth::user()->role_id == 1)
                                <div>
                                    <select name="role_id" id="role_id"
                                            class="form-select  @error('role_id') is-invalid @enderror" required>
                                        @foreach($roles as $role)
                                            <option
                                                value="{{$role->id}}"
                                                {{$role->id == $user->role_id? 'selected':''}}>{{__($role->name)}}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('organizationtype_id')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            @endif
                            <div class="row mb-3">
                                <label for="password"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input id="password" type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               name="password"
                                               autocomplete="new-password">
                                        <div class="input-group-addon">
                                            <a href=""><i class="fa fa-eye-slash" aria-hidden="true"
                                                          id="show_hide_password"></i></a>
                                        </div>

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password_confirm"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password_confirm" type="password" class="form-control"
                                           name="password_confirmation" autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Submit') }}
                                    </button>
                                </div>
                            </div>
                            @method('PUT')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        window.addEventListener("DOMContentLoaded", function () {
            const togglePassword = document.querySelector("#show_hide_password");

            togglePassword.addEventListener("click", function (e) {
                e.preventDefault();
                // toggle the type attribute
                const type =
                    password.getAttribute("type") === "password" ? "text" : "password";
                password.setAttribute("type", type);
                const type1 =
                    password_confirm.getAttribute("type") === "password" ? "text" : "password";
                password_confirm.setAttribute("type", type1);
                // toggle the eye / eye slash icon
                this.classList.toggle("fa-eye");
            });
        });
    </script>
@endsection
