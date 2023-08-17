@extends('layouts.app')

@section('title', __('Add counter'))

@section('content')
    <form action="{{route('counters.store')}}" method="post">
        @csrf
        <div class="form-floating mb-3">
            <input type="text" id="number" name="number" class="form-control @error('number') is-invalid @enderror"
                   value="{{ old('number') }}" required autocomplete="number" autofocus>
            <label for="number">{{__('Counter number')}}</label>

            @error('number')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <input type="date" id="date_begin" name="date_begin"
                   class="form-control @error('date_begin') is-invalid @enderror"
                   value="{{ date('Y-m-d') }}" required autocomplete="date_begin">
            <label for="value">{{__('Counter installation date')}}</label>

            @error('date_begin')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div>
            <select name="accrualtype_id" id="accrualtype_id"
                    class="form-select  @error('accrualtype_id') is-invalid @enderror" required>
                <option value="" selected>{{__('Select accrual type')}}</option>
                @foreach($accrual_types as $type)
                    <option value="{{$type->id}}">{{__($type->name)}}</option>
                @endforeach
            </select>

            @error('accrualtype_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <input type="number" id="counter_value" name="counter_value"
                   class="form-control @error('counter_value') is-invalid @enderror"
                   step="0.01" value="{{ old('counter_value') }}" required autocomplete="counter_value">
            <label for="value">{{__('Start counter value')}}</label>

            @error('counter_value')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="col-md-6 offset-md-4">
            <input type="hidden" name="abonent_id" value="{{$abonent->id}}">
            <button type="submit" class="btn btn-primary">
                {{ __('Submit') }}
            </button>
        </div>
    </form>
@endsection
