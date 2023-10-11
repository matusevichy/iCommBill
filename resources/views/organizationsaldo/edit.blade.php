@extends('layouts.app')

@section('title', __('Edit saldo'))

@section('content')
    <div class="container">
        <form action="{{route('organizationsaldos.update', $organizationsaldo)}}" method="post">
            @csrf
            <div class="form-floating mb-3">
                <input type="number" id="value" name="value" class="form-control @error('value') is-invalid @enderror"
                       step="0.01" value="{{ $organizationsaldo->value }}" required autocomplete="value">
                <label for="value">{{__('Value')}}</label>
                @error('value')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="date" id="date" name="date"
                       class="form-control @error('date') is-invalid @enderror"
                       value="{{ $organizationsaldo->date }}" required autocomplete="date">
                <label for="value">{{__('Date')}}</label>

                @error('date')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                @enderror
            </div>
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Submit') }}
                </button>
            </div>
            @method('PUT')
        </form>
    </div>
@endsection
