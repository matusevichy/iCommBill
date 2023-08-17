@extends('layouts.app')

@section('title', __('Add abonent'))

@section('content')
    <div class="container">
        <form action="{{route('abonents.store')}}" method="post">
            @csrf
{{--            <div class="form-floating mb-3">--}}
{{--                <input type="text" id="account_number" name="account_number"--}}
{{--                       class="form-control @error('account_number') is-invalid @enderror"--}}
{{--                       value="{{ old('account_number') }}" required autocomplete="account_number" autofocus>--}}
{{--                <label for="name">{{__('Account number')}}</label>--}}

{{--                @error('account_number')--}}
{{--                <span class="invalid-feedback" role="alert">--}}
{{--                <strong>{{ $message }}</strong>--}}
{{--            </span>--}}
{{--                @enderror--}}
{{--            </div>--}}
            <div class="form-floating mb-3">
                <input type="text" id="location_number" name="location_number"
                       class="form-control @error('location_number') is-invalid @enderror"
                       value="{{ old('location_number') }}" required autocomplete="location_number">
                <label for="location">{{__('Location number')}}</label>

                @error('location_number')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="text" id="street" name="street"
                       class="form-control @error('street') is-invalid @enderror"
                       value="{{ old('street') }}" autocomplete="street">
                <label for="location">{{__('Street')}}</label>

                @error('street')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="number" id="square" name="square" step="0.01"
                       class="form-control @error('square') is-invalid @enderror" value="{{ old('square') }}"
                       required autocomplete="square">
                <label for="user_limit">{{__("Square")}},{{__('m')}}<sup>2</sup></label>

                @error('square')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                @enderror
            </div>
            <div>
                <label for="user_id">{{__('Owner')}}</label>
                <select name="user_id" id="user_id"
                        class="form-select  @error('user_id') is-invalid @enderror" required>
                    @foreach($users as $user)
                        <option value="{{$user->id}}">{{__($user->name)}} {{$user->phone}}</option>
                    @endforeach
                </select>

                @error('user_id')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                @enderror
            </div>
            <div class="col-md-6 offset-md-4">
                <input type="hidden" name="organization_id" value="{{$organization->id}}">
                <button type="submit" class="btn btn-primary">
                    {{ __('Submit') }}
                </button>
            </div>
        </form>
    </div>
@endsection
